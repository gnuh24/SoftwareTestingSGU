package BackEnd.Form.ShoppingForms.CartItemForm;

import jakarta.validation.constraints.NotNull;
import lombok.AllArgsConstructor;
import lombok.Data;
import lombok.NoArgsConstructor;

@Data
@NoArgsConstructor
@AllArgsConstructor
public class CartItemDeleteForm {

    @NotNull(message = "ShoeId cannot be null")
    private Integer shoeId;

    @NotNull(message = "Size cannot be null")
    private Byte idSize;

    @NotNull(message = "AccountId cannot be null")
    private Integer accountId;

}
