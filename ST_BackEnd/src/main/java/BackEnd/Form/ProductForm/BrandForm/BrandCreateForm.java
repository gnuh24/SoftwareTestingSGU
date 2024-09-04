package BackEnd.Form.ProductForm.BrandForm;


import BackEnd.Validation.FileContentType;
import BackEnd.Validation.FileSize;
import jakarta.validation.constraints.NotBlank;
import jakarta.validation.constraints.NotNull;
import lombok.Data;
import lombok.NoArgsConstructor;
import org.springframework.http.MediaType;
import org.springframework.web.multipart.MultipartFile;

@Data
public class BrandCreateForm {

    @NotBlank(message = "Bạn không được để trống tên thương hiệu !!")
    private String brandName;

    @FileSize(max = "5MB")
    @FileContentType(allowed = { MediaType.IMAGE_JPEG_VALUE, MediaType.IMAGE_PNG_VALUE })
    private MultipartFile logo;

}
