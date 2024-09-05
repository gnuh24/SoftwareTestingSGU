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

    @NotNull(message = "Price is required")
    @Positive(message = "Price must be a positive number")
    private Integer price;

    @NotNull(message = "Image is required")
    private MultipartFile image;

    @NotBlank(message = "Origin is required")
    @Size(max = 255, message = "Origin cannot exceed 255 characters")
    private String origin;

    @NotNull(message = "Capacity is required")
    @Positive(message = "Capacity must be a positive number")
    private Integer capacity;

    @NotNull(message = "ABV is required")
    @Positive(message = "ABV must be a positive number")
    private Integer abv;

    @Size(max = 5000, message = "Description cannot exceed 5000 characters")
    private String description;

    @NotNull(message = "Brand ID is required")
    @Positive(message = "Brand ID must be a positive number")
    private Integer brandId;

    @NotNull(message = "Category ID is required")
    @Positive(message = "Category ID must be a positive number")
    private Integer categoryId;
}

