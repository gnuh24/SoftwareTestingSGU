package BackEnd.Form.ShoppingForms.CartItemForm;


import com.fasterxml.jackson.annotation.JsonProperty;
import jakarta.validation.constraints.Min;
import jakarta.validation.constraints.NotNull;
import lombok.AllArgsConstructor;
import lombok.Data;
import lombok.NoArgsConstructor;

@AllArgsConstructor
@NoArgsConstructor
@Data
public class CartItemCreateForm {

    @NotNull(message = "ShoeId cannot be null")
    private Integer shoeId;

    @NotNull(message = "Size cannot be null")
    private Byte idSize;

    @NotNull(message = "AccountId cannot be null")
    private Integer accountId;

    @NotNull(message = "Quantity cannot be null")
    @Min(value = 1, message = "Quantity must be at least 1")
    private Integer quantity;

    @NotNull(message = "UnitPrice cannot be null")
    @Min(value = 0, message = "UnitPrice must be at least 0")
    private Integer unitPrice;

    @NotNull(message = "Total cannot be null")
    @Min(value = 0, message = "Total must be at least 0")
    private Integer total;
}
