package BackEnd.Form.ShoppingForms.OrderDetailForm;

import jakarta.validation.constraints.NotNull;
import lombok.AllArgsConstructor;
import lombok.Data;
import lombok.NoArgsConstructor;

@Data
@NoArgsConstructor
@AllArgsConstructor
public class OrderDetailCreateForm {
    @NotNull(message = "Shoe ID cannot be null")
    private Short shoeId;

    @NotNull(message = "Size cannot be null")
    private Byte idSize;

    @NotNull(message = "Quantity cannot be null")
    private Integer quantity;

    @NotNull(message = "Unit price cannot be null")
    private Integer unitPrice;

    @NotNull(message = "Total cannot be null")
    private Integer total;
}
