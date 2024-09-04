package BackEnd.Form.ShoppingForms.OrderForm;

import BackEnd.Entity.ShoppingEntities.Order;
import BackEnd.Form.ShoppingForms.OrderDetailForm.OrderDetailCreateForm;
import jakarta.validation.constraints.NotNull;
import lombok.AllArgsConstructor;
import lombok.Data;
import lombok.NoArgsConstructor;

import java.util.List;

@Data
@NoArgsConstructor
@AllArgsConstructor
public class OrderCreateFormForAdmin {

    private Integer userInformationId;

    @NotNull(message = "TotalPrice cannot be null")
    private Integer totalPrice;

    @NotNull(message = "SubtotalPrice cannot be null")
    private Integer subtotalPrice;

    private String note;

    @NotNull(message = "ShippingFeeId cannot be null")
    private Integer shippingFeeId;

    @NotNull(message = "Type cannot be null")
    private Order.OrderType type;


    private List<OrderDetailCreateForm> listOrderDetail;

    private Integer voucherId;


}
