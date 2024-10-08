package BackEnd.Form.ProductForm.ProductForms;

import jakarta.validation.constraints.NotBlank;
import jakarta.validation.constraints.NotNull;
import jakarta.validation.constraints.Positive;
import jakarta.validation.constraints.Size;
import lombok.AllArgsConstructor;
import lombok.Data;
import lombok.NoArgsConstructor;
import org.springframework.web.multipart.MultipartFile;


@Data
@AllArgsConstructor
@NoArgsConstructor
public class ProductUpdateForm {

    @NotNull(message = "Id is required")
    private Integer id;

    private Boolean status;

    private MultipartFile image;

    private String origin;

    private Integer capacity;

    private Integer abv;

    private String description;

    private Integer brandId;

    private Integer categoryId;
}

