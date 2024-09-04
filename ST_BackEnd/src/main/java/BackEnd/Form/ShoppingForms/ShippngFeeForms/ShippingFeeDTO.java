package BackEnd.Form.ShoppingForms.ShippngFeeForms;

import com.fasterxml.jackson.annotation.JsonFormat;
import lombok.AllArgsConstructor;
import lombok.Data;
import lombok.NoArgsConstructor;

import java.time.LocalDateTime;


@Data
@NoArgsConstructor
@AllArgsConstructor
public class ShippingFeeDTO {

    private Integer id;
    private Integer fee;

    @JsonFormat(pattern = "hh:mm:ss dd/MM/yyyy")
    private LocalDateTime createTime;

    // Getters and setters
}

