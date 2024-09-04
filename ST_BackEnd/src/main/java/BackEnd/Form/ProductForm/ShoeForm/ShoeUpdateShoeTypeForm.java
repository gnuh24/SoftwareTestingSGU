package BackEnd.Form.ProductForm.ShoeForm;


import lombok.AllArgsConstructor;
import lombok.Data;
import lombok.NoArgsConstructor;

import java.util.List;

@Data
@NoArgsConstructor
@AllArgsConstructor
public class ShoeUpdateShoeTypeForm {

    private  Integer shoeTypeId;

    private List< Integer> shoesId;
}
