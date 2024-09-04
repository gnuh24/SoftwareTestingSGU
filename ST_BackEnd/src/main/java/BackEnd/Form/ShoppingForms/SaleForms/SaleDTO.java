package BackEnd.Form.ShoppingForms.SaleForms;

import com.fasterxml.jackson.annotation.JsonFormat;
import com.fasterxml.jackson.annotation.JsonProperty;
import lombok.AllArgsConstructor;
import lombok.Data;
import lombok.NoArgsConstructor;

@Data
@NoArgsConstructor
@AllArgsConstructor
public class SaleDTO {

    @JsonProperty("eventId")
    private Integer idEventId;

    @JsonProperty("shoeId")
    private Integer idShoeId;
}
