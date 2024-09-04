package BackEnd.Entity.ShoppingEntities;

import jakarta.persistence.*;
import lombok.AllArgsConstructor;
import lombok.Data;
import lombok.NoArgsConstructor;

import java.time.LocalDateTime;

@Entity
@Table(name = "Voucher")
@Data
@NoArgsConstructor
@AllArgsConstructor
public class Voucher {

    @Id
    @GeneratedValue(strategy = GenerationType.IDENTITY)
    @Column(name = "VoucherId", nullable = false)
    private Integer voucherId;

    @Column(name = "Title", nullable = false)
    private String title;

    @Column(name = "Status", nullable = false)
    private Boolean status;

    @Column(name = "Code", nullable = false)
    private String code;

    @Column(name = "ExpirationTime", nullable = false)
    private LocalDateTime expirationTime;

    @Column(name = "DiscountAmount", nullable = false)
    private Integer discountAmount;

    @Column(name = "`Condition`", nullable = false)
    private Integer condition;

    @Column(name = "isFreeShip", nullable = false)
    private Boolean isFreeShip;
}
