package BackEnd.Form.InventoryForms.InventoryReportDetailForms;

import jakarta.validation.constraints.NotNull;
import lombok.AllArgsConstructor;
import lombok.Data;
import lombok.NoArgsConstructor;

@Data
@NoArgsConstructor
@AllArgsConstructor
public class InventoryReportDetailDeleteForm {
    private Integer idInventoryReportId;

    private  Integer idShoeId;

    private Byte idSize;
}
