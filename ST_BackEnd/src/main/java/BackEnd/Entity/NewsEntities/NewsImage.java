package BackEnd.Entity.NewsEntities;

import jakarta.persistence.*;
import lombok.AllArgsConstructor;
import lombok.Data;
import lombok.NoArgsConstructor;

@Entity
@Table(name = "NewsImage")
@Data
@NoArgsConstructor
@AllArgsConstructor
public class NewsImage {

    @Id
    @GeneratedValue(strategy = GenerationType.IDENTITY)
    @Column(name = "Id", nullable = false)
    private Integer id;

    @Column(name = "Path", nullable = false)
    private String path;

    @ManyToOne
    @JoinColumn(name = "NewsId", nullable = false)
    private News news;

}
