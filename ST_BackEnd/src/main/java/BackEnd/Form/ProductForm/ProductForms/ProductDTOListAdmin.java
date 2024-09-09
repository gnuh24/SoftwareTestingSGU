package BackEnd.Form.ProductForm.ProductForms;


import BackEnd.Form.ProductForm.BrandForm.BrandDTOForProduct;
import BackEnd.Form.ProductForm.CategoryForms.CategoryDTOForProduct;
import com.fasterxml.jackson.annotation.JsonFormat;
import lombok.AllArgsConstructor;
import lombok.Data;
import lombok.NoArgsConstructor;

import java.time.LocalDateTime;

@Data
@AllArgsConstructor
@NoArgsConstructor
public class ProductDTOListAdmin {

    private  Integer id;

    private String productName;

    private Boolean status;

    private Integer quantity;

    private Integer price;

    private String image;

    @JsonFormat(pattern = "HH:mm:ss dd/MM/yyyy")
    private LocalDateTime createTime;

    private BrandDTOForProduct brand;

    private CategoryDTOForProduct category;

}
