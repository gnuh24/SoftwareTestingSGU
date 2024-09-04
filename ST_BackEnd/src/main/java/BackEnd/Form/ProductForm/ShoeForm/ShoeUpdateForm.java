package BackEnd.Form.ProductForm.ShoeForm;

import lombok.AllArgsConstructor;
import lombok.Data;
import lombok.NoArgsConstructor;


@Data
@AllArgsConstructor
@NoArgsConstructor
public class ShoeUpdateForm {

    private Integer shoeId;

    private String shoeName;

    private Boolean status;

    private String description;

    private Boolean priority;

    private Integer shoeColorId;

    private Integer brandId;

    private Integer shoeTypeId;
}

