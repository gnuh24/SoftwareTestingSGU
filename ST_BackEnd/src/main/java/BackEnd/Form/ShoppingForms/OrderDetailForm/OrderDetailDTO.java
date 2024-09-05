package BackEnd.Form.ShoppingForms.OrderDetailForm;

import com.fasterxml.jackson.annotation.JsonProperty;
import lombok.AllArgsConstructor;
import lombok.Data;
import lombok.NoArgsConstructor;

@Data
@NoArgsConstructor
@AllArgsConstructor
public class OrderDetailDTO {

    @JsonProperty("productId")
    private  Integer idProductId;

    private String productName;

    @JsonProperty("image")
    private String productImage;

    private Integer quantity;

    private Integer unitPrice;

    private Integer total;


}
