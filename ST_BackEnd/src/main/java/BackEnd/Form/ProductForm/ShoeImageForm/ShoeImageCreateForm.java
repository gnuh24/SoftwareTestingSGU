package BackEnd.Form.ProductForm.ShoeImageForm;

import BackEnd.Validation.FileContentType;
import BackEnd.Validation.FileSize;
import jakarta.persistence.Column;
import jakarta.persistence.GeneratedValue;
import jakarta.persistence.GenerationType;
import jakarta.persistence.Id;
import jakarta.validation.constraints.NotNull;
import lombok.AllArgsConstructor;
import lombok.Data;
import lombok.NoArgsConstructor;
import org.springframework.http.MediaType;
import org.springframework.web.multipart.MultipartFile;

@Data
@AllArgsConstructor
@NoArgsConstructor
public class ShoeImageCreateForm {

    @FileSize(max = "5MB")
    @FileContentType(allowed = { MediaType.IMAGE_JPEG_VALUE, MediaType.IMAGE_PNG_VALUE })
    @NotNull(message = "Bạn không được bỏ trống logo !!")
    private MultipartFile shoeImage;

    @NotNull(message = "Bạn không được để trống độ ưu tiên")
    private Boolean priority;

}
