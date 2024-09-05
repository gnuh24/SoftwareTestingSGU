package BackEnd.Form.ProductForm.CategoryForms;


import jakarta.validation.constraints.NotBlank;
import jakarta.validation.constraints.NotNull;
import lombok.Data;

@Data
public class CategoryUpdateForm {

    @NotNull(message = "Bạn không được để trống ID loại sản phẩm muốn update !!")
    private  Integer id;

    @NotBlank(message = "Bạn không được để trống tên loại sản phẩm !!")
    private String categoryName;

}
