package BackEnd.Entity.InventoryEntities;

import BackEnd.Entity.ProductEntity.Shoe;
import BackEnd.Entity.ProductEntity.ShoeSize;
import jakarta.persistence.*;
import lombok.AllArgsConstructor;
import lombok.Data;
import lombok.NoArgsConstructor;

import java.io.Serializable;

@Entity
@Table(name = "InventoryReportDetail")
@Data
@NoArgsConstructor
@AllArgsConstructor
public class InventoryReportDetail {

    @EmbeddedId
    private InventoryReportDetailId id;

    @Column(name = "Quantity", nullable = false)
    private Integer quantity;

    @Column(name = "UnitPrice", nullable = false)
    private Integer unitPrice;

    @Column(name = "Total", nullable = false)
    private Integer total;

    @ManyToOne
    @MapsId("inventoryReportId")
    @JoinColumn(name = "InventoryReportId", referencedColumnName = "Id")
    private InventoryReport inventoryReport;

    @ManyToOne
    @MapsId("shoeId")
    @JoinColumn(name = "ShoeId", referencedColumnName = "ShoeId")
    private Shoe shoe;

    @Embeddable
    @Data
    @NoArgsConstructor
    @AllArgsConstructor
    public static class InventoryReportDetailId implements Serializable {

        @Column(name = "InventoryReportId")
        private Integer inventoryReportId;

        @Column(name = "ShoeId")
        private Integer shoeId;

        @Column(name = "Size")
        private Byte size;
    }
}
