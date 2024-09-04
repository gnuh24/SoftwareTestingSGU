package BackEnd.Entity.ShoppingEntities;

import BackEnd.Entity.AccountEntity.Account;
import jakarta.persistence.*;
import lombok.AllArgsConstructor;
import lombok.Data;
import lombok.NoArgsConstructor;
import org.hibernate.annotations.GenericGenerator;
import BackEnd.Entity.OrderEntity.OrderDetail;
import java.time.LocalDateTime;
import java.util.List;

@Entity
@Data
@NoArgsConstructor
@AllArgsConstructor
public class Order {

    @Id
    @GeneratedValue(generator = "order-id-generator")
    @GenericGenerator(name = "order-id-generator", strategy = "BackEnd.Entity.ShoppingEntities.OrderIdGenerator")
    @Column(name = "Id", nullable = false, length = 12)
    private String id;

    @Column(name = "OrderTime", nullable = false)
    private LocalDateTime orderTime = LocalDateTime.now();;

    @Column(name = "TotalPrice", nullable = false)
    private Integer totalPrice;

    @Column(name = "Note")
    private String note;

    @ManyToOne
    @JoinColumn(name = "AccountId")
    private Account account;

    @OneToMany(mappedBy = "order")
    private List<OrderStatus> orderStatuses;

    @OneToMany(mappedBy = "order")
    private List<OrderDetail> orderDetails;


}
