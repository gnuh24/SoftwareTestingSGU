package BackEnd.Form.ProductForm.ProductForms;


import lombok.AllArgsConstructor;
import lombok.Data;
import lombok.NoArgsConstructor;
import org.springframework.format.annotation.DateTimeFormat;

import java.util.Date;

@Data
@NoArgsConstructor
@AllArgsConstructor
public class ProductFilterForm {

    //Admin
    private Boolean status;

    private  Integer brandId;

    private  Integer categoryId;



    //User

//    private Integer minPrice;
//
//    private Integer maxPrice;


}
