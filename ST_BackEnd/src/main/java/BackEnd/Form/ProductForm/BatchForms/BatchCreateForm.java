package BackEnd.Form.ProductForm.BatchForms;


import jakarta.validation.constraints.NotNull;
import lombok.Data;
import lombok.NoArgsConstructor;

@Data
@NoArgsConstructor
public class BatchCreateForm {

    @NotNull(message = "ProductID is required")
    private Integer productId;

    private Integer unitPrice;

    private Integer quantity;

}
