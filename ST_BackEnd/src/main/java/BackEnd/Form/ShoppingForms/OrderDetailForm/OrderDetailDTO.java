package BackEnd.Form.ShoppingForms.OrderDetailForm;

import com.fasterxml.jackson.annotation.JsonProperty;
import lombok.AllArgsConstructor;
import lombok.Data;
import lombok.NoArgsConstructor;

@Data
@NoArgsConstructor
@AllArgsConstructor
public class OrderDetailDTO {

//    private OrderDetailIdDTO id;

    @JsonProperty("shoeId")
    private  Integer idShoeId;

    @JsonProperty("size")
    private Byte idSize;

    private String shoeName;

    private String defaultImage;

    private Integer quantity;

    private Integer unitPrice;

    private Integer total;


}
