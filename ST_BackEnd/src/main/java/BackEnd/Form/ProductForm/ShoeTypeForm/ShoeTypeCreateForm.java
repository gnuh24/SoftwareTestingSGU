package BackEnd.Form.ProductForm.ShoeTypeForm;

import jakarta.validation.constraints.NotBlank;
import lombok.Data;
import lombok.NoArgsConstructor;

@Data
public class ShoeTypeCreateForm {

    @NotBlank(message = "Bạn không được để trống tên loại sản phẩm !!")
    private String shoeTypeName;

}
