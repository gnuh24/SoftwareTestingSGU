package BackEnd.Form.InventoryForms.InventoryReportStatusForms;

import BackEnd.Entity.InventoryEntities.InventoryReportStatus;
import com.fasterxml.jackson.annotation.JsonFormat;
import com.fasterxml.jackson.annotation.JsonProperty;
import lombok.AllArgsConstructor;
import lombok.Data;
import lombok.NoArgsConstructor;

import java.time.LocalDateTime;

@Data
@NoArgsConstructor
@AllArgsConstructor
public class InventoryReportStatusDTO {


    @JsonProperty("status")
    private InventoryReportStatus.Status idStatus;

    @JsonFormat(pattern = "HH:mm:ss yyyy/MM/dd")
    private LocalDateTime updateTime;
}
