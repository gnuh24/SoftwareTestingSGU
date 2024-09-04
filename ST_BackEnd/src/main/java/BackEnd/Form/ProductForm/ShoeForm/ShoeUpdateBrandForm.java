package BackEnd.Form.ProductForm.ShoeForm;


import lombok.AllArgsConstructor;
import lombok.Data;
import lombok.NoArgsConstructor;

import java.util.List;

@Data
@NoArgsConstructor
@AllArgsConstructor
public class ShoeUpdateBrandForm {

    private  Integer brandId;

    private List< Integer> shoesId;

}
