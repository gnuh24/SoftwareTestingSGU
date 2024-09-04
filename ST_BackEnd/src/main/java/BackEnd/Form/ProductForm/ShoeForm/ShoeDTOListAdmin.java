package BackEnd.Form.ProductForm.ShoeForm;


import BackEnd.Form.ProductForm.BrandForm.BrandDTOForShoe;
import BackEnd.Form.ProductForm.ColorForm.ColorDTOForShoe;
import BackEnd.Form.ProductForm.ShoeTypeForm.ShoeTypeDTOForShoe;
import com.fasterxml.jackson.annotation.JsonFormat;
import lombok.AllArgsConstructor;
import lombok.Data;
import lombok.NoArgsConstructor;

import java.time.LocalDateTime;

@Data
@AllArgsConstructor
@NoArgsConstructor
public class ShoeDTOListAdmin {

    private  Integer shoeId;

    private String shoeName;

    private Boolean status;

    @JsonFormat(pattern = "HH:mm:ss dd/MM/yyyy")
    private LocalDateTime createDate;

    private Boolean priority;

    private BrandDTOForShoe brand;

    private ShoeTypeDTOForShoe shoeType;

    private String defaultImage;
}
