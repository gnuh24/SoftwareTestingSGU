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
public class OrderCreateFormForUser {

    private Integer accountId;

    @NotNull(message = "TotalPrice cannot be null")
    private Integer totalPrice;

    private String note;

//    @NotNull(message = "Bạn không được để trống phương thức thanh toán")
//    private Order.PaymentOption paymentOption;
//
//    @NotNull(message = "Paid cannot be null")
//    private Boolean paid;

    private List<OrderDetailCreateForm> listOrderDetail;

}
