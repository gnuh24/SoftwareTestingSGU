package BackEnd.Controller.ShoppingControllers;

import BackEnd.Configure.ErrorResponse.NotEnoughInventory;
import BackEnd.Entity.ShoppingEntities.OrderStatus;
import BackEnd.Form.ShoppingForms.OrderStatusForms.OrderStatusCreateFormForFirstTime;
import BackEnd.Form.ShoppingForms.OrderStatusForms.OrderStatusDTO;
import BackEnd.Service.ShoppingServices.OrderServices.IOrderService;
import BackEnd.Service.ShoppingServices.OrderStatusServices.IOrderStatusService;
import org.modelmapper.ModelMapper;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.web.bind.annotation.*;

import java.nio.file.AccessDeniedException;
import java.rmi.AccessException;

@RestController
@RequestMapping("/OrderStatus")
@CrossOrigin(origins = "*")
public class OrderStatusController {

    @Autowired
    private IOrderStatusService orderStatusService;

    @Autowired
    private ModelMapper modelMapper;

    // Create a new order status
    @PostMapping(value = "/User")
    public OrderStatusDTO createOrderStatus(@RequestHeader("Authorization") String token,
                                            @ModelAttribute OrderStatusCreateFormForFirstTime orderStatus) throws NotEnoughInventory,  AccessDeniedException {
        OrderStatus orderStatus1 = orderStatusService.createOrderStatus(token, orderStatus);
        return modelMapper.map(orderStatus1, OrderStatusDTO.class);
    }

    // Create a new order status
    @PostMapping(value = "/Admin")
    public OrderStatusDTO createOrderStatus(@ModelAttribute OrderStatusCreateFormForFirstTime orderStatus) throws NotEnoughInventory {
        OrderStatus orderStatus1 = orderStatusService.createOrderStatus(orderStatus);
        return modelMapper.map(orderStatus1, OrderStatusDTO.class);
    }
}
