package BackEnd.Form.InventoryForms.InventoryReportDetailForms;

import jakarta.validation.constraints.NotNull;
import lombok.AllArgsConstructor;
import lombok.Data;
import lombok.NoArgsConstructor;

@Data
@AllArgsConstructor
@NoArgsConstructor
public class InventoryReportDetailUpdateForm {

    @NotNull(message = "Inventory Id is required")
    private Integer idInventoryReportId;

    @NotNull(message = "Product Id is required")
    private Integer idProductId;

    private Integer quantity;

    private Integer unitPrice;

    private Integer total;
}
