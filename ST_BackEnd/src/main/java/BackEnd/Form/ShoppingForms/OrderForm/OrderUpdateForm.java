package BackEnd.Form.ShoppingForms.OrderForm;

import BackEnd.Entity.ShoppingEntities.Order;
import jakarta.validation.constraints.NotNull;
import lombok.AllArgsConstructor;
import lombok.Data;
import lombok.NoArgsConstructor;

@Data
@AllArgsConstructor
@NoArgsConstructor
public class OrderUpdateForm {

    private String id;

    private String note;

    private Order.OrderType type;

    private Integer userInformationId;
}
