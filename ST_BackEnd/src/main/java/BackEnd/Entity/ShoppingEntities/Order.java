package BackEnd.Entity.ShoppingEntities;

import BackEnd.Entity.AccountEntity.Account;
import BackEnd.Entity.AccountEntity.UserInformation;
import jakarta.persistence.*;
import lombok.AllArgsConstructor;
import lombok.Data;
import lombok.NoArgsConstructor;
import org.hibernate.annotations.GenericGenerator;

import java.time.LocalDateTime;
import java.util.List;

@Entity
@Table(name = "`Order`")
@Data
@NoArgsConstructor
@AllArgsConstructor
public class Order {

    @Id
    @GeneratedValue(generator = "order-id-generator")
    @GenericGenerator(name = "order-id-generator", strategy = "BackEnd.Entity.ShoppingEntities.OrderIdGenerator")
    @Column(name = "Id", nullable = false, length = 12)
    private String id;

    @Column(name = "OrderDate", nullable = false)
    private LocalDateTime orderDate;

    @Column(name = "TotalPrice", nullable = false)
    private Integer totalPrice;

    @Column(name = "SubtotalPrice", nullable = false)
    private Integer subtotalPrice;

    @Column(name = "Note", columnDefinition = "TEXT")
    private String note;

    @ManyToOne(fetch = FetchType.LAZY) // Many Orders can have One ShippingFee
    @JoinColumn(name = "ShippingFeeId", referencedColumnName = "Id", nullable = false) // Join column to ShippingFee
    private ShippingFee shippingFee;

    @Enumerated(EnumType.STRING)
    @Column(name = "Type", nullable = false)
    private OrderType type;

    @ManyToOne
    @JoinColumn(name = "VoucherId", referencedColumnName = "VoucherId")
    private Voucher voucher;

    @ManyToOne
    @JoinColumn(name = "UserInformationId", referencedColumnName = "id")
    private UserInformation userInformation;

    @OneToMany(mappedBy = "order")
    private List<OrderStatus> orderStatuses;

    @OneToMany(mappedBy = "order")
    private List<OrderDetail> orderDetails;

    public enum OrderType {
        Web, Facebook, Zalo, Other
    }

    @PrePersist
    private void prePersist() {
        if (orderDate == null) {
            orderDate = LocalDateTime.now();
        }
    }
}
