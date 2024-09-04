package BackEnd.Form.ProductForm.BrandForm;

import BackEnd.Validation.FileContentType;
import BackEnd.Validation.FileSize;
import jakarta.validation.constraints.NotBlank;
import lombok.Data;
import lombok.NoArgsConstructor;
import jakarta.validation.constraints.NotNull;
import org.springframework.http.MediaType;
import org.springframework.web.multipart.MultipartFile;

@Data
public class BrandUpdateForm {

    @NotNull(message = "Bạn không thể để trống ID brand cần update !!")
    private Integer brandId;

    private String brandName;

    @FileSize(max = "5MB")
    @FileContentType(allowed = { MediaType.IMAGE_JPEG_VALUE, MediaType.IMAGE_PNG_VALUE })
    private MultipartFile logo;

}
