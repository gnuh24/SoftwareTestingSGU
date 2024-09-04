package BackEnd.Form.InventoryForms.InventoryReportForms;

import BackEnd.Entity.InventoryEntities.InventoryReportStatus;
import com.fasterxml.jackson.annotation.JsonFormat;
import lombok.AllArgsConstructor;
import lombok.Data;
import lombok.NoArgsConstructor;

import java.time.LocalDateTime;

@Data
@AllArgsConstructor
@NoArgsConstructor
public class InventoryReportListDTO {

    private Integer id;

    @JsonFormat(pattern = "HH:mm:ss dd/MM/yyyy")
    private LocalDateTime createTime;

    private Integer totalPrice;

    private String supplier;

    private String supplierPhone;

    private String status;

}

