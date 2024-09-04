package BackEnd.Form.ShoppingForms.CartItemForm;


import jakarta.validation.constraints.Min;
import jakarta.validation.constraints.NotNull;
import lombok.AllArgsConstructor;
import lombok.Data;
import lombok.NoArgsConstructor;

@Data
@NoArgsConstructor
@AllArgsConstructor
public class CartItemUpdateForm {

    @NotNull(message = "ShoeId cannot be null")
    private  Integer shoeId;

    @NotNull(message = "Size cannot be null")
    private Byte idSize;

    @NotNull(message = "AccountId cannot be null")
    private Integer accountId;

    @Min(value = 1, message = "Quantity must be at least 1")
    private Integer quantity;

    @Min(value = 0, message = "UnitPrice must be at least 0")
    private Integer unitPrice;

    @Min(value = 0, message = "Total must be at least 0")
    private Integer total;
}
