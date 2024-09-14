package BackEnd.Entity.ProductEntity;

import BackEnd.Entity.ShoppingEntities.OrderDetail;
import jakarta.persistence.*;
import lombok.AllArgsConstructor;
import lombok.Data;
import lombok.NoArgsConstructor;

import java.time.LocalDate;
import java.time.LocalDateTime;
import java.util.List;

@Entity
@Data
@NoArgsConstructor
@AllArgsConstructor
public class Product {

    @Id
    @GeneratedValue(strategy = GenerationType.IDENTITY)
    @Column(name = "Id")
    private Integer id;

    @Column(name = "ProductName", nullable = false)
    private String productName;

    @Column(name = "Status", nullable = false)
    private Boolean status = false;

    @Column(name = "CreateTime", nullable = false)
    private LocalDateTime createTime = LocalDateTime.now();

    @Column(name = "Image", nullable = false)
    private String image;

    @Column(name = "Origin", nullable = false)
    private String origin;

    @Column(name = "Capacity", nullable = false)
    private Integer capacity;

    @Column(name = "ABV", nullable = false)
    private Integer abv;

    @Column(name = "Description")
    private String description = "Không có mô tả nào cho sản phẩm trên";

    @ManyToOne
    @JoinColumn(name = "BrandId", nullable = false)
    private Brand brand;

    @ManyToOne
    @JoinColumn(name = "CategoryId", nullable = false)
    private Category category;

    @OneToMany(mappedBy = "product")
    private List<Batch> batches;
}
