package BackEnd.Entity.NewsEntities;

import jakarta.persistence.*;
import lombok.AllArgsConstructor;
import lombok.Data;
import lombok.NoArgsConstructor;

@Entity
@Table(name = "FeedbackImage")
@Data
@NoArgsConstructor
@AllArgsConstructor
public class FeedbackImage {

    @Id
    @GeneratedValue(strategy = GenerationType.IDENTITY)
    @Column(name = "Id", nullable = false)
    private Integer id;

    @Column(name = "Path", nullable = false)
    private String path;

    @ManyToOne
    @JoinColumn(name = "FeedbackId", nullable = false)
    private Feedback feedback;
}

