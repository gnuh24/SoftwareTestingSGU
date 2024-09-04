package BackEnd.Entity.ShoppingEntities;

import BackEnd.Entity.AccountEntity.Account;
import BackEnd.Entity.ProductEntity.Shoe;
import BackEnd.Entity.ProductEntity.ShoeSize;
import jakarta.persistence.*;
import lombok.AllArgsConstructor;
import lombok.Data;
import lombok.NoArgsConstructor;

import java.io.Serializable;

@Data
@NoArgsConstructor
@AllArgsConstructor
@Entity
@Table(name = "CartItem")
public class CartItem {

    @EmbeddedId
    private CartItemId id;

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
    @MapsId("accountId")
    @JoinColumn(name = "AccountId", referencedColumnName = "id")
    private Account account;

    @Embeddable
    @Data
    @NoArgsConstructor
    @AllArgsConstructor
    public static class CartItemId implements Serializable {
        @Column(name = "ShoeId")
        private Integer shoeId;

        @Column(name = "Size")
        private Byte size;

        @Column(name = "AccountId")
        private Integer accountId;
    }
}
