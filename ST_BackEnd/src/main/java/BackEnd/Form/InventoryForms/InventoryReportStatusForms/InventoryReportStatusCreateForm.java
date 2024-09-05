package BackEnd.Form.InventoryForms.InventoryReportStatusForms;

import BackEnd.Entity.InventoryEntities.InventoryReportStatus;
import jakarta.validation.constraints.NotNull;
import lombok.AllArgsConstructor;
import lombok.Data;
import lombok.NoArgsConstructor;

@Data
@AllArgsConstructor
@NoArgsConstructor
public class InventoryReportStatusCreateForm {

    @NotNull(message = "Inventory Report ID cannot be null")
    private Integer inventoryReportId;

    @NotNull(message = "Status cannot be null")
    private InventoryReportStatus.Status idStatus;

}
