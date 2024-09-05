package BackEnd.Entity.ShoppingEntities;

import jakarta.persistence.*;
import lombok.AllArgsConstructor;
import lombok.Data;
import lombok.NoArgsConstructor;

import java.io.Serializable;

@Entity
@Data
@NoArgsConstructor
@AllArgsConstructor
public class OrderDetail {

    @Id
    @EmbeddedId
    private OrderDetailId id;

    @Column(name = "Quantity", nullable = false)
    private Integer quantity;

    @Column(name = "UnitPrice", nullable = false)
    private Integer unitPrice;

    @Column(name = "Total", nullable = false)
    private Integer total;

    // Thêm mối quan hệ với Order
    @ManyToOne
    @JoinColumn(name = "OrderId", insertable = false, updatable = false)
    private Order order;

    @Embeddable
    @Data
    @NoArgsConstructor
    @AllArgsConstructor
    public static class OrderDetailId implements Serializable {

        @Column(name = "OrderId")
        private String orderId;

        @Column(name = "ProductId")
        private Integer productId;
    }
}