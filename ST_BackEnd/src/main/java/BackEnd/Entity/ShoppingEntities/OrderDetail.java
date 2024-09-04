package BackEnd.Entity.ShoppingEntities;

import BackEnd.Entity.ProductEntity.Shoe;
import jakarta.persistence.*;
import lombok.AllArgsConstructor;
import lombok.Data;
import lombok.NoArgsConstructor;

import java.io.Serializable;

@Data
@NoArgsConstructor
@AllArgsConstructor
@Entity
@Table(name = "OrderDetail")
public class OrderDetail {

    @EmbeddedId
    private OrderDetailId id;

    @Column(name = "Quantity", nullable = false)
    private Integer quantity;

    @Column(name = "UnitPrice", nullable = false)
    private Integer unitPrice;

    @Column(name = "Total", nullable = false)
    private Integer total;

    // Relationship mappings
    @ManyToOne
    @MapsId("shoeId")
    @JoinColumn(name = "ShoeId", referencedColumnName = "ShoeId")
    private Shoe shoe;

    @ManyToOne
    @MapsId("orderId")
    @JoinColumn(name = "OrderId", referencedColumnName = "Id")
    private Order order;

    @Embeddable
    @Data
    @NoArgsConstructor
    @AllArgsConstructor
    public static class OrderDetailId implements Serializable {

        @Column(name = "ShoeId")
        private  Integer shoeId;

        @Column(name = "Size")
        private Byte size;

        @Column(name = "OrderId")
        private String orderId; // Changed to match Order's ID type
    }
}
