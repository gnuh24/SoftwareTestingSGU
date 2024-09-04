package BackEnd.Form.ProductForm.ShoeForm;

import lombok.AllArgsConstructor;
import lombok.Data;
import lombok.NoArgsConstructor;

@Data
@NoArgsConstructor
@AllArgsConstructor
public class ShoeDTOForEventAdmin {

    private  Integer shoeId;

    private String shoeName;

    private Boolean status;

    private String defaultImage;

}
