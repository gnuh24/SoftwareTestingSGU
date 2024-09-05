package BackEnd.Form.InventoryForms.InventoryReportDetailForms;

import jakarta.validation.constraints.NotNull;
import lombok.AllArgsConstructor;
import lombok.Data;
import lombok.NoArgsConstructor;

@Data
@NoArgsConstructor
@AllArgsConstructor
public class InventoryReportDetailDeleteForm {

    @NotNull(message = "Inventory Id is required")
    private Integer idInventoryReportId;

    @NotNull(message = "Product Id is required")
    private  Integer idProductId;

}
