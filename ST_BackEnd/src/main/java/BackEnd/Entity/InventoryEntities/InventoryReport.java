package BackEnd.Entity.InventoryEntities;

import jakarta.persistence.*;
import lombok.AllArgsConstructor;
import lombok.Data;
import lombok.NoArgsConstructor;

import java.time.LocalDateTime;
import java.util.List;

@Entity
@Table(name = "InventoryReport")
@Data
@NoArgsConstructor
@AllArgsConstructor
public class InventoryReport {

    @Id
    @GeneratedValue(strategy = GenerationType.IDENTITY)
    @Column(name = "Id", nullable = false)
    private Integer id;

    @Column(name = "CreateTime", nullable = false)
    private LocalDateTime createTime;

    @Column(name = "Supplier")
    private String supplier;

    @Column(name = "SupplierPhone")
    private String supplierPhone;

    @Column(name = "TotalPrice", nullable = false)
    private Integer totalPrice;

    @OneToMany(mappedBy = "inventoryReport")
    private List<InventoryReportDetail> inventoryReportDetails;

    @OneToMany(mappedBy = "inventoryReport")
    private List<InventoryReportStatus> inventoryReportStatuses;

    @PrePersist
    private void prePersist() {
        if (createTime == null) {
            createTime = LocalDateTime.now();
        }
    }
}
