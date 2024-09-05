package BackEnd.Form.ProductForm.ProductForms;

import lombok.AllArgsConstructor;
import lombok.Data;
import lombok.NoArgsConstructor;

@Data
@NoArgsConstructor
@AllArgsConstructor
public class ProductDTOListUser {

    private  Integer id;

    private String productName;

    private Integer price;

    private String image;

}
