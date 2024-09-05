package BackEnd.Form.ProductForm.CategoryForms;

import jakarta.validation.constraints.NotBlank;
import lombok.Data;

@Data
public class CategoryCreateForm {

    @NotBlank(message = "Bạn không được để trống tên loại sản phẩm !!")
    private String categoryName;

}
