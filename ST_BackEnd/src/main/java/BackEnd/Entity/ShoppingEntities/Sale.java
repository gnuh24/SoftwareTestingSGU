package BackEnd.Entity.ShoppingEntities;

import BackEnd.Entity.ProductEntity.Shoe;
import jakarta.persistence.*;
import lombok.AllArgsConstructor;
import lombok.Data;
import lombok.NoArgsConstructor;

import java.io.Serializable;

@Data
@NoArgsConstructor
@AllArgsConstructor
@Entity
@Table(name = "Sale")
public class Sale {

    @EmbeddedId
    private SaleId id;

    // Relationship mappings
    @ManyToOne
    @MapsId("eventId")
    @JoinColumn(name = "EventId", referencedColumnName = "EventId")
    private Event event;

    @ManyToOne
    @MapsId("shoeId")
    @JoinColumn(name = "ShoeId", referencedColumnName = "ShoeId")
    private Shoe shoe;

    @Embeddable
    @Data
    @NoArgsConstructor
    @AllArgsConstructor
    public static class SaleId implements Serializable {

        @Column(name = "EventId")
        private Integer eventId;

        @Column(name = "ShoeId")
        private  Integer shoeId;
    }
}

