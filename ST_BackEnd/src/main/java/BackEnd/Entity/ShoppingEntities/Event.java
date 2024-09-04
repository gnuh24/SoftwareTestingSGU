package BackEnd.Entity.ShoppingEntities;

import jakarta.persistence.*;
import jakarta.validation.constraints.FutureOrPresent;
import lombok.AllArgsConstructor;
import lombok.Data;
import lombok.NoArgsConstructor;

import java.time.LocalDateTime;
import java.util.List;

@Entity
@Table(name = "Event")
@Data
@NoArgsConstructor
@AllArgsConstructor
public class Event {

    @Id
    @GeneratedValue(strategy = GenerationType.IDENTITY)
    @Column(name = "EventId", nullable = false, updatable = false)
    private Integer eventId;

    @Column(name = "Banner", nullable = false, length = 255)
    private String banner;

    @Column(name = "EventName", nullable = false, length = 255)
    private String eventName;

    @Column(name = "StartTime", nullable = false)
    private LocalDateTime startTime;

    @Column(name = "EndTime", nullable = false)
    private LocalDateTime endTime;

    @Column(name = "Status", nullable = false)
    private Boolean status;

    @Column(name = "Percentage", nullable = false)
    private Byte percentage;

    @OneToMany(mappedBy = "event", cascade = CascadeType.ALL, orphanRemoval = true)
    private List<Sale> sales;

    @PrePersist
    protected void onPrePersist() {
        if (status == null) {
            status = false;
        }
    }

}
