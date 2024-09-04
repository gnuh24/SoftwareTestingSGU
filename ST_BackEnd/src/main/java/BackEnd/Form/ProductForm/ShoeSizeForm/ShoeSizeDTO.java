package BackEnd.Form.ProductForm.ShoeSizeForm;

import com.fasterxml.jackson.annotation.JsonProperty;
import lombok.AllArgsConstructor;
import lombok.Data;
import lombok.NoArgsConstructor;

@Data
@AllArgsConstructor
@NoArgsConstructor
public class ShoeSizeDTO {

    @JsonProperty(value = "size")
    private Byte idSize;

    private Integer price;

    private Short quantity;

    private Boolean status;
}
