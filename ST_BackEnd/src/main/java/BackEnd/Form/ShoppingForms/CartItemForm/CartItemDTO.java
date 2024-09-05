package BackEnd.Form.ShoppingForms.CartItemForm;

import com.fasterxml.jackson.annotation.JsonFormat;
import com.fasterxml.jackson.annotation.JsonProperty;
import jakarta.validation.constraints.NotNull;
import lombok.AllArgsConstructor;
import lombok.Data;
import lombok.NoArgsConstructor;

@Data
@NoArgsConstructor
@AllArgsConstructor
public class CartItemDTO {

    @JsonProperty("productId")
    private Integer idProductId;

    @JsonProperty("accountId")
    private Integer idAccountId;

    @JsonProperty("image")
    private String productImage;

    private Integer quantity;
    private Integer unitPrice;
    private Integer total;
}
