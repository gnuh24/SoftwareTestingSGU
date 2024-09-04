package BackEnd.Service.ShoppingServices.OrderDetailServices;

import BackEnd.Entity.ShoppingEntities.Order;
import BackEnd.Entity.ShoppingEntities.OrderDetail;
import BackEnd.Form.ShoppingForms.OrderDetailForm.OrderDetailCreateForm;

import java.util.List;

public interface IOrderDetailService {

    List<OrderDetail> getAllOrderDetailByOrderId(String orderId);

    OrderDetail createOrderDetail(Order order, OrderDetailCreateForm listForm);

}
