package BackEnd.Entity.ShoppingEntities;

import lombok.AllArgsConstructor;
import lombok.Data;
import lombok.NoArgsConstructor;

import jakarta.persistence.*;

import java.io.Serializable;
import java.time.LocalDateTime;

@Entity
@Data
@NoArgsConstructor
@AllArgsConstructor
public class OrderStatus {

    @EmbeddedId
    private OrderStatusId id;

    @Column(name = "UpdateTime", nullable = false)
    private LocalDateTime updateTime = LocalDateTime.now();

    @ManyToOne
    @MapsId("orderId")
    @JoinColumn(name = "OrderId", referencedColumnName = "Id")
    private Order order;

    @Embeddable
    @Data
    @AllArgsConstructor
    @NoArgsConstructor
    public static class OrderStatusId implements Serializable {

        @Column(name = "OrderId", nullable = false, length = 12)
        private String orderId;

        @Enumerated(EnumType.STRING)
        @Column(name = "Status", nullable = false, length = 12)
        private Status status = Status.ChoDuyet;
    }

    public enum Status {
        ChoDuyet, DaDuyet, DangGiao, GiaoThanhCong, Huy
    }
}
