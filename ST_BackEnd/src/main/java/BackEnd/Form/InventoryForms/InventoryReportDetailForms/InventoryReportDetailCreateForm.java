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

    private  Integer idShoeId;

    private Byte idSize;

    private Integer quantity;

    private Integer unitPrice;

    private Integer total;
}

