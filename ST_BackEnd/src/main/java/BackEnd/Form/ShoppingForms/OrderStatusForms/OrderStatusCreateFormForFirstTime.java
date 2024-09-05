package BackEnd.Form.ShoppingForms.OrderStatusForms;

import BackEnd.Entity.ShoppingEntities.OrderStatus;
import jakarta.validation.constraints.NotNull;
import jakarta.validation.constraints.Size;
import lombok.AllArgsConstructor;
import lombok.Data;
import lombok.NoArgsConstructor;

@Data
@AllArgsConstructor
@NoArgsConstructor
public class OrderStatusCreateFormForFirstTime {

    private String orderId;

    private OrderStatus.Status idStatus;

}
