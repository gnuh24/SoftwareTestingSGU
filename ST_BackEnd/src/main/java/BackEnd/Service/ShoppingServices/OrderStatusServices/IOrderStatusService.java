package BackEnd.Service.ShoppingServices.OrderStatusServices;

import BackEnd.Configure.ErrorResponse.NotEnoughInventory;
import BackEnd.Entity.ShoppingEntities.OrderStatus;
import BackEnd.Form.ShoppingForms.OrderStatusForms.OrderStatusCreateFormForFirstTime;

import java.nio.file.AccessDeniedException;

public interface IOrderStatusService {

    OrderStatus getNewestOrderStatus(String orderId);

    OrderStatus createOrderStatusFirstTime(OrderStatusCreateFormForFirstTime form);

    OrderStatus createOrderStatus(OrderStatusCreateFormForFirstTime form) throws NotEnoughInventory;

    OrderStatus createOrderStatus(String token, OrderStatusCreateFormForFirstTime form) throws NotEnoughInventory, AccessDeniedException;

}
