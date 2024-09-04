package BackEnd.Form.ProductForm.ShoeImageForm;

import jakarta.persistence.Column;
import lombok.AllArgsConstructor;
import lombok.Data;
import lombok.NoArgsConstructor;

@Data
@AllArgsConstructor@NoArgsConstructor
public class ShoeImageDTO {

    private  Integer shoeImageId;

    private String path;

    private Boolean priority;
}
