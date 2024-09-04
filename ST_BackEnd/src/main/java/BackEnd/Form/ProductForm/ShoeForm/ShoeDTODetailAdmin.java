package BackEnd.Form.ProductForm.ShoeForm;

import BackEnd.Form.ProductForm.BrandForm.BrandDTOForShoe;
import BackEnd.Form.ProductForm.ColorForm.ColorDTO;
import BackEnd.Form.ProductForm.ColorForm.ColorDTOForShoe;
import BackEnd.Form.ProductForm.ShoeColorForms.ShoeColorDTO;
import BackEnd.Form.ProductForm.ShoeColorForms.ShoeColorDTOForGetShoeDetail;
import BackEnd.Form.ProductForm.ShoeImageForm.ShoeImageDTO;
import BackEnd.Form.ProductForm.ShoeSizeForm.ShoeSizeDTO;
import BackEnd.Form.ProductForm.ShoeTypeForm.ShoeTypeDTOForShoe;
import com.fasterxml.jackson.annotation.JsonFormat;
import lombok.AllArgsConstructor;
import lombok.Data;
import lombok.NoArgsConstructor;

import java.time.LocalDateTime;
import java.util.List;


@Data
@NoArgsConstructor
@AllArgsConstructor
public class ShoeDTODetailAdmin {

    private Integer shoeId;

    private String shoeName;

    private Boolean status;

    @JsonFormat(pattern = "HH:mm:ss dd/MM/yyyy")
    private LocalDateTime createDate;

    private Boolean priority;

    private String description;

    private BrandDTOForShoe brand;

    private ShoeTypeDTOForShoe shoeType;

    private List<ShoeColorDTOForGetShoeDetail> shoeColors;

    private List<ShoeSizeDTO> shoeSizes;

    private List<ShoeImageDTO> shoeImages;

    private Byte sale;
}
