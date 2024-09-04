package BackEnd.Entity.ProductEntity;

import jakarta.persistence.*;
import lombok.AllArgsConstructor;
import lombok.Data;
import lombok.NoArgsConstructor;

import java.io.Serializable;

@Entity
@Table(name = "ShoeSize")
@Data
@NoArgsConstructor
@AllArgsConstructor
public class ShoeSize implements Serializable {

    @EmbeddedId
    private ShoeSizeId id;

    @Column(name = "Price", nullable = false)
    private Integer price;

    @Column(name = "Quanlity", nullable = false)
    private Short quantity;

    @Column(name = "Status", nullable = false)
    private Boolean status;

    @ManyToOne
    @MapsId("shoeId")
    @JoinColumn(name = "ShoeId", referencedColumnName = "ShoeId")
    private Shoe shoe;

    @PrePersist
    private void prePersist() {
        if (quantity == null) {
            quantity = 0;
        }
        if (status == null) {
            status = true;
        }
    }

    @Embeddable
    @Data
    @AllArgsConstructor
    @NoArgsConstructor
    public static class ShoeSizeId implements Serializable {

        @Column(name = "ShoeId", nullable = false)
        private Integer shoeId;

        @Column(name = "Size", nullable = false)
        private Byte size;
    }
}
