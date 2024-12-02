package BackEnd.Form.ProductForm.CategoryForms;


import jakarta.validation.constraints.NotBlank;
import jakarta.validation.constraints.NotNull;
import jakarta.validation.constraints.Size;
import lombok.Data;

@Data
public class CategoryUpdateForm {

    @NotNull(message = "Bạn không được để trống ID loại sản phẩm muốn update !!")
    private  Integer id;

    @NotBlank(message = "Bạn không được để trống tên loại sản phẩm !!")
    @Size(min = 3, max = 100, message = "Tên loại sản phẩm phải từ 3 đến 100 ký tự !!")
    private String categoryName;

}
