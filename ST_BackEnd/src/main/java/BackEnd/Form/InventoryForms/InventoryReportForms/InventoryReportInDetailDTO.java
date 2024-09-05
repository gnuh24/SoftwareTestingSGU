package BackEnd.Form.InventoryForms.InventoryReportForms;

import BackEnd.Entity.InventoryEntities.InventoryReportDetail;
import BackEnd.Form.InventoryForms.InventoryReportDetailForms.InventoryReportDetailDTO;
import BackEnd.Form.InventoryForms.InventoryReportStatusForms.InventoryReportStatusDTO;
import com.fasterxml.jackson.annotation.JsonFormat;
import lombok.AllArgsConstructor;
import lombok.Data;
import lombok.NoArgsConstructor;

import java.time.LocalDateTime;
import java.util.List;

@Data
@AllArgsConstructor
@NoArgsConstructor
public class InventoryReportInDetailDTO {
    private Integer id;

    @JsonFormat(pattern = "HH:mm:ss yyyy/MM/dd")
    private LocalDateTime createTime;

    private Integer totalPrice;

    private String supplier;

    private String supplierPhone;

    private List<InventoryReportDetailDTO> inventoryReportDetails;

    private List<InventoryReportStatusDTO> inventoryReportStatuses;

}
