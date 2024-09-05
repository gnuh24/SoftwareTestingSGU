package BackEnd.Form.ShoppingForms.CartItemForm;

import jakarta.validation.constraints.NotNull;
import lombok.AllArgsConstructor;
import lombok.Data;
import lombok.NoArgsConstructor;

@Data
@NoArgsConstructor
@AllArgsConstructor
public class CartItemDTO {

    private Integer idShoeId;

    private Integer idSize;

    private Integer idAccountId;
    private Integer quantity;
    private Integer unitPrice;
    private Integer total;
}
