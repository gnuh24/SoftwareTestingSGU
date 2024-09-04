package BackEnd.Entity.ProductEntity;


import jakarta.persistence.*;
import lombok.Data;

import java.util.List;

@Entity
@Data
@Table(name = "Color")
public class Color {
    @Id
    @GeneratedValue(strategy = GenerationType.IDENTITY)
    @Column(name = "Id")
    private  Integer id;

    @Column(name = "colorName", nullable = false)
    private String colorName;

    @OneToMany(mappedBy = "color")
    private List<ShoeColor> shoeColors;


}

