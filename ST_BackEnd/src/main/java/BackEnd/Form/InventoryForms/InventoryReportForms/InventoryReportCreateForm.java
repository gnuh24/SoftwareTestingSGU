package BackEnd.Form.InventoryForms.InventoryReportForms;
import BackEnd.Form.InventoryForms.InventoryReportDetailForms.InventoryReportDetailCreateForm;
import BackEnd.Form.InventoryForms.InventoryReportDetailForms.InventoryReportDetailCreateFormForFirstTime;
import jakarta.validation.constraints.NotNull;
import lombok.AllArgsConstructor;
import lombok.Data;
import lombok.NoArgsConstructor;

import java.util.List;

@Data
@AllArgsConstructor
@NoArgsConstructor
public class InventoryReportCreateForm {


    private String supplier;

    private String supplierPhone;

    @NotNull(message = "Bạn không thể để trống tổng tiền của phiếu nhập !!")
    private Integer totalPrice;

    private List<InventoryReportDetailCreateFormForFirstTime> inventoryReportDetailCreateFormList;

}

