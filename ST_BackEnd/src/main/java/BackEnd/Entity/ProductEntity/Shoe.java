package BackEnd.Entity.ProductEntity;

import BackEnd.Entity.ShoppingEntities.Sale;
import jakarta.persistence.*;
import lombok.AllArgsConstructor;
import lombok.Data;
import lombok.NoArgsConstructor;

import java.time.LocalDateTime;
import java.util.List;
import java.util.Set;

@Entity
@Table(name = "Shoe")
@Data
@AllArgsConstructor
@NoArgsConstructor
public class Shoe {

    @Id
    @GeneratedValue(strategy = GenerationType.IDENTITY)
    @Column(name = "ShoeId")
    private Integer shoeId;

    @Column(name = "ShoeName", nullable = false, length = 1000)
    private String shoeName;

    @Column(name = "Status", nullable = false)
    private Boolean status;

    @Column(name = "CreateDate", nullable = false)
    private LocalDateTime createDate;

    @Column(name = "Priority", nullable = false)
    private Boolean priority;

    @Column(name = "Description", columnDefinition = "TEXT")
    private String description;

    @ManyToOne
    @JoinColumn(name = "BrandId", nullable = false)
    private Brand brand;

    @ManyToOne
    @JoinColumn(name = "ShoeTypeId", nullable = false)
    private ShoeType shoeType;

    @OneToMany(mappedBy = "shoe")
    private List<ShoeSize> shoeSizes;

    @OneToMany(mappedBy = "shoe")
    private List<ShoeImage> shoeImages;

    @OneToMany(mappedBy = "shoe")
    private List<Sale> sales;

    @OneToMany(mappedBy = "shoe")
    private List<ShoeColor> shoeColors;

    @PrePersist
    private void prePersist() {
        if (createDate == null) {
            createDate = LocalDateTime.now();
        }
    }
}
