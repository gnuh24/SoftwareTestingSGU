package BackEnd.Form.ProductForm.ShoeImageForm;

import lombok.AllArgsConstructor;
import lombok.Data;
import lombok.NoArgsConstructor;
import org.springframework.web.multipart.MultipartFile;

@Data
@AllArgsConstructor
@NoArgsConstructor
public class ShoeImageUpdateForm {

    private MultipartFile shoeImage;

    private Boolean priority;

}
