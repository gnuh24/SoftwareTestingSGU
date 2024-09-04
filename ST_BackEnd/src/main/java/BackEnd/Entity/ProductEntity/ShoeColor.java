package BackEnd.Entity.ProductEntity;

import jakarta.persistence.*;
import lombok.AllArgsConstructor;
import lombok.Data;
import lombok.NoArgsConstructor;

import java.io.Serializable;

@Entity
@Table(name = "ShoeColor")
@Data
@NoArgsConstructor
@AllArgsConstructor
public class ShoeColor implements Serializable {

    @EmbeddedId
    private ShoeColorId id;

    @ManyToOne
    @MapsId("shoeId")
    @JoinColumn(name = "ShoeId", referencedColumnName = "ShoeId")
    private Shoe shoe;

    @ManyToOne
    @MapsId("colorId")
    @JoinColumn(name = "ColorId", referencedColumnName = "Id")
    private Color color;

    @Embeddable
    @Data
    @AllArgsConstructor
    @NoArgsConstructor
    public static class ShoeColorId implements Serializable {

        @Column(name = "ShoeId", nullable = false)
        private  Integer shoeId;

        @Column(name = "ColorId", nullable = false)
        private  Integer colorId;
    }
}

