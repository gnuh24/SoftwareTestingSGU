package BackEnd.Form.InventoryForms.InventoryReportDetailForms;

import com.fasterxml.jackson.annotation.JsonProperty;
import lombok.AllArgsConstructor;
import lombok.Data;
import lombok.NoArgsConstructor;

@Data
@AllArgsConstructor
@NoArgsConstructor
public class InventoryReportDetailDTO {

    @JsonProperty("shoeId")
    private  Integer idShoeId;

    @JsonProperty("size")
    private Byte idSize;

    private String shoeName;

    private Integer quantity;

    private Integer unitPrice;

    private Integer total;
}

