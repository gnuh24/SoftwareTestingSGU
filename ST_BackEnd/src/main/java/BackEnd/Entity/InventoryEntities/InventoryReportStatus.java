package BackEnd.Entity.InventoryEntities;

import jakarta.persistence.*;
import lombok.AllArgsConstructor;
import lombok.Data;
import lombok.NoArgsConstructor;

import java.io.Serializable;
import java.time.LocalDateTime;

@Entity
@Table(name = "InventoryReportStatus")
@Data
@NoArgsConstructor
@AllArgsConstructor
public class InventoryReportStatus {

    @EmbeddedId
    private InventoryReportStatusId id;

    @Column(name = "UpdateTime", nullable = false)
    private LocalDateTime updateTime;

    @ManyToOne
    @MapsId("inventoryReportId")
    @JoinColumn(name = "InventoryReportId", referencedColumnName = "Id")
    private InventoryReport inventoryReport;

    @Embeddable
    @Data
    @NoArgsConstructor
    @AllArgsConstructor
    public static class InventoryReportStatusId implements Serializable {

        @Column(name = "InventoryReportId", nullable = false)
        private Integer inventoryReportId;

        @Enumerated(EnumType.STRING)
        @Column(name = "Status", nullable = false)
        private Status status;
    }

    public enum Status {
        ChoNhapKho, DaNhapKho, Huy
    }

    @PrePersist
    private void prePersist() {
        if (updateTime == null) {
            updateTime = LocalDateTime.now();
        }

        if (id.getStatus() == null) {
            id.status = Status.ChoNhapKho;
        }
    }
}
