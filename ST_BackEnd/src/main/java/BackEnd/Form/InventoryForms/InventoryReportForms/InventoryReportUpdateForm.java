package BackEnd.Form.InventoryForms.InventoryReportForms;

import lombok.AllArgsConstructor;
import lombok.Data;
import lombok.NoArgsConstructor;

@Data
@AllArgsConstructor
@NoArgsConstructor
public class InventoryReportUpdateForm {

    private Integer id;

    private String supplier;

    private String supplierPhone;

    private Integer totalPrice;
}

