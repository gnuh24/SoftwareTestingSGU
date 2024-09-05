package BackEnd.Service.ShoppingServices.OrderServices;

import BackEnd.Entity.ShoppingEntities.Order;
import BackEnd.Form.ShoppingForms.OrderForm.OrderCreateFormForUser;
import BackEnd.Form.ShoppingForms.OrderForm.OrderFilterForm;
import org.springframework.data.domain.Page;
import org.springframework.data.domain.Pageable;

import java.nio.file.AccessDeniedException;
import java.util.List;

public interface IOrderService {

    Page<Order> getAllOrder(Pageable pageable, OrderFilterForm form, String search);

    Boolean isOrderBelongToThisId(Integer userInformationId, String orderId);

    List<Order> getAllOrderByUser(String token);

    Order getOrderById(String orderId);

    Order getOrderById(String token, String orderId) throws AccessDeniedException;

    Order createOrder(OrderCreateFormForUser form);


}
