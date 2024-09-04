package BackEnd.Form.ShoppingForms.OrderForm;


import com.fasterxml.jackson.annotation.JsonFormat;
import lombok.AllArgsConstructor;
import lombok.Data;
import lombok.NoArgsConstructor;

import java.time.LocalDateTime;

@Data
@NoArgsConstructor
@AllArgsConstructor
public class OrderDTO {

    private String id;

    private Integer totalPrice;

    private Integer shippingFee;

    private String type;

    @JsonFormat(pattern = "hh:mm:ss dd/MM/yyyy")
    private LocalDateTime orderDate;

    private String voucherCode;


}
