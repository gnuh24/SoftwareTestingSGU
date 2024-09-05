package BackEnd.Entity.ShoppingEntities;

import BackEnd.Entity.AccountEntity.Account;
import BackEnd.Entity.ProductEntity.Product;
import jakarta.persistence.*;
import lombok.AllArgsConstructor;
import lombok.Data;
import lombok.NoArgsConstructor;

import java.io.Serializable;

@Entity
@Data
@NoArgsConstructor
@AllArgsConstructor
public class CartItem implements Serializable {

    @EmbeddedId
    private CartItemId id;

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
    public static class CartItemId implements Serializable {

        @Column(name = "ProductId", nullable = false)
        private Integer productId;

        @Column(name = "AccountId", nullable = false)
        private Integer accountId;
    }

    @ManyToOne
    @MapsId("productId")
    @JoinColumn(name = "ProductId", referencedColumnName = "Id")
    private Product product;

    @ManyToOne
    @MapsId("accountId")
    @JoinColumn(name = "AccountId", referencedColumnName = "Id")
    private Account account;
}
