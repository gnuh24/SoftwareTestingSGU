package BackEnd.Entity.ShoppingEntities;

import jakarta.persistence.*;
import lombok.AllArgsConstructor;
import lombok.Data;
import lombok.NoArgsConstructor;

import java.time.LocalDateTime;

@Entity
@Data
@NoArgsConstructor
@AllArgsConstructor
@Table(name = "ShippingFee")
public class ShippingFee {

    @Id
    @GeneratedValue(strategy = GenerationType.IDENTITY)
    private Integer id;

    @Column(nullable = false)
    private Integer fee;

    @Column(nullable = false, updatable = false)
    private LocalDateTime createTime;

    @PrePersist
    private void prePersist() {

        if (createTime == null){
            createTime = LocalDateTime.now();
        }

    }

}
