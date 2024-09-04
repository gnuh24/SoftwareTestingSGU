package BackEnd.Form.ProductForm.ProductForms;

import BackEnd.Form.ProductForm.BrandForm.BrandDTOForProduct;
import BackEnd.Form.ProductForm.CategoryForms.CategoryDTOForProduct;
import lombok.AllArgsConstructor;
import lombok.Data;
import lombok.NoArgsConstructor;

@Data
@AllArgsConstructor
@NoArgsConstructor
public class ProductDTODetailUser {

    private Integer id;

    private String productName;

    private Integer price;

    private String image;


    private String description;

    private String origin;

    private Integer capacity;

    private Integer abv;

    private Integer quantity;


    private BrandDTOForProduct brand;

    private CategoryDTOForProduct category;
}
