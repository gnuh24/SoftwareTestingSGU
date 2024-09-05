package BackEnd.Form.ShoppingForms.OrderForm;


import BackEnd.Form.ShoppingForms.OrderDetailForm.OrderDetailDTO;
import BackEnd.Form.ShoppingForms.OrderStatusForms.OrderStatusDTO;
import BackEnd.Form.UsersForms.UserInformationForms.UserInformationDTOForOrder;
import com.fasterxml.jackson.annotation.JsonFormat;
import lombok.AllArgsConstructor;
import lombok.Data;
import lombok.NoArgsConstructor;

import java.time.LocalDateTime;
import java.util.List;

@Data
@NoArgsConstructor
@AllArgsConstructor
public class OrderDTODetailUser {

    private String id;

    private Integer totalPrice;

    @JsonFormat(pattern = "HH:mm:ss dd/MM/yyyy")
    private LocalDateTime orderTime;


    private String note;


    private List<OrderStatusDTO> orderStatuses;

    private List<OrderDetailDTO> orderDetails;

}
