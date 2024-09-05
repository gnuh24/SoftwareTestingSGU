package BackEnd.Form.ShoppingForms.CartItemForm;

import jakarta.validation.constraints.NotNull;
import lombok.AllArgsConstructor;
import lombok.Data;
import lombok.NoArgsConstructor;

@Data
@NoArgsConstructor
@AllArgsConstructor
public class CartItemDeleteForm {

    @NotNull(message = "ProductId cannot be null")
    private Integer productId;

    @NotNull(message = "AccountId cannot be null")
    private Integer accountId;

}
