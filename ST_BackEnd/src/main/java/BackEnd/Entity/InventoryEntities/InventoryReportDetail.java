package BackEnd.Entity.InventoryEntities;

import BackEnd.Entity.ProductEntity.Product;
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
public class InventoryReportDetail implements Serializable {

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
    @MapsId("productId")
    @JoinColumn(name = "ProductId", referencedColumnName = "Id")
    private Product product;

    @Embeddable
    @Data
    @AllArgsConstructor
    @NoArgsConstructor
    public static class InventoryReportDetailId implements Serializable {

        @Column(name = "InventoryReportId", nullable = false)
        private Integer inventoryReportId;

        @Column(name = "ProductId", nullable = false)
        private Integer productId;
    }
}
