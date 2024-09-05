package BackEnd.Form.InventoryForms.InventoryReportDetailForms;

import com.fasterxml.jackson.annotation.JsonProperty;
import lombok.AllArgsConstructor;
import lombok.Data;
import lombok.NoArgsConstructor;

@Data
@AllArgsConstructor
@NoArgsConstructor
public class InventoryReportDetailDTO {

    @JsonProperty("productId")
    private  Integer idProductId;

    private String productName;

    private Integer quantity;

    private Integer unitPrice;

    private Integer total;
}

