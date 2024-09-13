package BackEnd.Form.ProductForm.ProductForms;

import BackEnd.Form.ProductForm.BatchForms.BatchDTO;
import BackEnd.Form.ProductForm.BrandForm.BrandDTOForProduct;
import BackEnd.Form.ProductForm.CategoryForms.CategoryDTOForProduct;
import com.fasterxml.jackson.annotation.JsonFormat;
import lombok.AllArgsConstructor;
import lombok.Data;
import lombok.NoArgsConstructor;

import java.time.LocalDateTime;
import java.util.List;

@Data
@NoArgsConstructor
@AllArgsConstructor
public class ProductDTODetailAdmin {

    private Integer id;

    private String productName;

    private Boolean status;

    @JsonFormat(pattern = "HH:mm:ss dd/MM/yyyy")
    private LocalDateTime createTime;

    private String image; // Assuming you are storing the image URL or path

    private String description;

    private String origin;

    private Integer capacity;

    private Integer abv;

    private List<BatchDTO> batches;

    private BrandDTOForProduct brand;

    private CategoryDTOForProduct category;
}
