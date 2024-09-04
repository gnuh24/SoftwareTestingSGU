package BackEnd.Entity.ProductEntity;

import jakarta.persistence.*;
import lombok.AllArgsConstructor;
import lombok.Data;
import lombok.NoArgsConstructor;

@Entity
@Table(name = "Brand")
@Data
@AllArgsConstructor
@NoArgsConstructor
public class Brand {

    @Id
    @GeneratedValue(strategy = GenerationType.IDENTITY)
    @Column(name = "BrandId")
    private Integer brandId;

    @Column(name = "BrandName", nullable = false)
    private String brandName;

    @Column(name = "Logo", nullable = false)
    private String logo;

}
