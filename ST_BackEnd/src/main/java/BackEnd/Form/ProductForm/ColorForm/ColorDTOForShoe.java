package BackEnd.Form.ProductForm.ColorForm;

import jakarta.persistence.criteria.CriteriaBuilder;
import lombok.Data;
import lombok.NoArgsConstructor;

@Data
@NoArgsConstructor
public class ColorDTOForShoe {

    private String colorName;

    private Boolean status;

}