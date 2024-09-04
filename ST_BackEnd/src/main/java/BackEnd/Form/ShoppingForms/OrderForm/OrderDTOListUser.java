package BackEnd.Form.ShoppingForms.OrderForm;

import BackEnd.Form.ShoppingForms.OrderDetailForm.OrderDetailDTO;
import BackEnd.Form.ShoppingForms.OrderStatusForms.OrderStatusDTO;
import BackEnd.Form.UsersForms.UserInformationForms.UserInformationDTOForOrder;
import com.fasterxml.jackson.annotation.JsonFormat;
import com.fasterxml.jackson.annotation.JsonProperty;
import lombok.AllArgsConstructor;
import lombok.Data;
import lombok.NoArgsConstructor;

import java.time.LocalDateTime;
import java.util.List;

@Data
@NoArgsConstructor
@AllArgsConstructor
public class OrderDTOListUser {

    private String id;

    private Integer totalPrice;

    private Integer shippingFee;

    @JsonFormat(pattern = "HH:mm:ss dd/MM/yyyy")
    private LocalDateTime orderDate;

    private Integer subtotalPrice;

    @JsonProperty(value = "status")
    private String latestStatus;

    private List<OrderDetailDTO> orderDetails;

}
