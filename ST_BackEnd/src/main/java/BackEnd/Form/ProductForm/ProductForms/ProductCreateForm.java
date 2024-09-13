package BackEnd.Form.ProductForm.ProductForms;
import jakarta.validation.constraints.NotBlank;
import jakarta.validation.constraints.NotNull;
import lombok.AllArgsConstructor;
import lombok.Data;
import lombok.NoArgsConstructor;
import org.springframework.web.multipart.MultipartFile;

import jakarta.validation.constraints.*;

@Data
@AllArgsConstructor
@NoArgsConstructor
public class ProductCreateForm {

    @NotBlank(message = "Product name is required")
    @Size(max = 1000, message = "Product name cannot exceed 1000 characters")
    private String productName;


}

