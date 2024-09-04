package BackEnd.Form.ProductForm.ShoeForm;

import BackEnd.Form.ProductForm.ShoeColorForms.ShoeColorCreateForm;
import BackEnd.Form.ProductForm.ShoeColorForms.ShoeColorCreateFormForCreateShoe;
import BackEnd.Form.ProductForm.ShoeImageForm.ShoeImageCreateForm;
import BackEnd.Form.ProductForm.ShoeSizeForm.ShoeSizeCreateForm;
import jakarta.validation.Valid;
import jakarta.validation.constraints.NotBlank;
import jakarta.validation.constraints.NotNull;
import lombok.AllArgsConstructor;
import lombok.Data;
import lombok.NoArgsConstructor;
import java.util.List;

@Data
@AllArgsConstructor
@NoArgsConstructor
public class ShoeCreateForm {

    @NotBlank(message = "Shoe name is required")
    private String shoeName;

    @NotNull(message = "Status is required")
    private Boolean status;

    private String description;

    private Boolean priority;

    @NotNull(message = "Brand ID is required")
    private  Integer brandId;

    @NotNull(message = "Shoe type ID is required")
    private  Integer shoeTypeId;

    @NotNull(message = "Shoe color ID is required")
    private  Integer shoeColorId;

    @Valid
    private List<@Valid ShoeColorCreateFormForCreateShoe> shoeColors;

    @Valid
    private List<@Valid ShoeSizeCreateForm> shoeSizes;

    @Valid
    private List<@Valid ShoeImageCreateForm> shoeImages;
}
