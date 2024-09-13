package BackEnd.Form.InventoryForms.InventoryReportDetailForms;

import com.fasterxml.jackson.annotation.JsonProperty;
import jakarta.validation.constraints.NotNull;
import lombok.AllArgsConstructor;
import lombok.Data;
import lombok.NoArgsConstructor;

@Data
@AllArgsConstructor
@NoArgsConstructor
public class InventoryReportDetailCreateForm {

    @NotNull(message = "Bạn không thể để trống mã phieu nhập kho !!")
    private Integer idInventoryReportId;

    @NotNull(message = "Product Id is required")
    private  Integer idProductId;

    private Integer quantity;

    private Integer unitPrice;

    private Integer total;

    private Integer profit;
}

