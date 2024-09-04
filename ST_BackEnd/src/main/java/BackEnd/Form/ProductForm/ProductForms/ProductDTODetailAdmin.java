package BackEnd.Form.ProductForm.ProductForms;

import BackEnd.Form.ProductForm.BrandForm.BrandDTOForProduct;
import BackEnd.Form.ProductForm.CategoryForms.CategoryDTOForProduct;
import com.fasterxml.jackson.annotation.JsonFormat;
import lombok.AllArgsConstructor;
import lombok.Data;
import lombok.NoArgsConstructor;

import java.time.LocalDateTime;

@Data
@NoArgsConstructor
@AllArgsConstructor
public class ProductDTODetailAdmin {

    private Integer id;

    private String productName;

    private Boolean status;

    @JsonFormat(pattern = "HH:mm:ss dd/MM/yyyy")
    private LocalDateTime createTime;

    private Integer price;

    private String image; // Assuming you are storing the image URL or path



    private String description;

    private String origin;

    private Integer capacity;

    private Integer abv;

    private Integer quantity;



    private BrandDTOForProduct brand;

    private CategoryDTOForProduct category;
}
