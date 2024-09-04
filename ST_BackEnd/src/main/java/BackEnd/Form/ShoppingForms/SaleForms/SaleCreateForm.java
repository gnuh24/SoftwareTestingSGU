package BackEnd.Form.ShoppingForms.SaleForms;

import lombok.AllArgsConstructor;
import lombok.Data;
import lombok.NoArgsConstructor;

@Data
@NoArgsConstructor
@AllArgsConstructor
public class SaleCreateForm {
    private Integer eventId;
    private Short shoeId;
}

