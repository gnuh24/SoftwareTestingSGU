package BackEnd.Form.ProductForm.ShoeTypeForm;


import jakarta.validation.constraints.NotBlank;
import jakarta.validation.constraints.NotNull;
import lombok.Data;
import lombok.NoArgsConstructor;

@Data
public class ShoeTypeUpdateForm {

    @NotNull(message = "Bạn không được để trống ID loại sản phẩm muốn update !!")
    private  Integer shoeTypeId;

    @NotBlank(message = "Bạn không được để trống tên loại sản phẩm !!")
    private String shoeTypeName;

}
