package BackEnd.Entity.OrderEntity;

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
