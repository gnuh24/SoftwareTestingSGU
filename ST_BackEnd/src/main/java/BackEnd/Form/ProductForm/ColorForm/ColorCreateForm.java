package BackEnd.Form.ProductForm.ColorForm;

import jakarta.validation.constraints.NotBlank;
import lombok.Data;

@Data
public class ColorCreateForm {

    @NotBlank(message = "Bạn không được để trống tên màu !!")
    private String colorName;
}
