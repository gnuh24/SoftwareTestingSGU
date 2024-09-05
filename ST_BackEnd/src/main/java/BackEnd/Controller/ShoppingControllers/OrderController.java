package BackEnd.Controller.ShoppingControllers;

import BackEnd.Configure.ErrorResponse.VoucherExpiredException;
import BackEnd.Entity.AccountEntity.Account;
import BackEnd.Entity.ShoppingEntities.Order;
import BackEnd.Entity.ShoppingEntities.OrderStatus;
import BackEnd.Form.ShoppingForms.OrderDetailForm.OrderDetailDTO;
import BackEnd.Form.ShoppingForms.OrderForm.*;
import BackEnd.Service.AccountServices.AccountService.IAccountService;
import BackEnd.Service.AccountServices.UserInformationService.IUserInformationService;
import BackEnd.Service.ShoppingServices.OrderServices.IOrderService;
import BackEnd.Service.ShoppingServices.OrderStatusServices.IOrderStatusService;
import jakarta.validation.Valid;
import org.modelmapper.ModelMapper;
import org.modelmapper.TypeToken;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.data.domain.Page;
import org.springframework.data.domain.PageImpl;
import org.springframework.data.domain.Pageable;
import org.springframework.http.ResponseEntity;
import org.springframework.web.bind.annotation.*;


import java.nio.file.AccessDeniedException;
import java.time.LocalDateTime;
import java.util.List;

@RestController
@RequestMapping("/Order")
@CrossOrigin(origins = "*")
public class OrderController {

    @Autowired
    private IOrderService orderService;

    @Autowired
    private IOrderStatusService statusService;

    @Autowired
    private IAccountService accountService;

    @Autowired
    private IUserInformationService userService;

    @Autowired
    private ModelMapper modelMapper;

    @GetMapping(value = "/Admin")
    public Page<OrderDTOListAdmin> getAllOrderAdmin(Pageable pageable,
                                                    OrderFilterForm form,
                                                    @RequestParam(required = false) String search) {
        Page<Order> entities = orderService.getAllOrder(pageable, form, search);
        List<OrderDTOListAdmin> dtos = modelMapper.map(entities.getContent(), new TypeToken<List<OrderDTOListAdmin>>() {
        }.getType());

        for (OrderDTOListAdmin dtoListAdmin: dtos){
            OrderStatus newStatus = statusService.getNewestOrderStatus(dtoListAdmin.getId());
            dtoListAdmin.setLatestStatus(
                newStatus.getId().getStatus().toString()
            );
        }

        return new PageImpl<>(dtos, pageable, entities.getTotalElements());
    }

    @GetMapping(value = "/MyOrder")
    public List<OrderDTOListUser> getAllOrderByUser(@RequestHeader("Authorization") String token) {
        List<Order> entities = orderService.getAllOrderByUser(token);

        List<OrderDTOListUser> dtos = modelMapper.map(entities, new TypeToken<List<OrderDTOListUser>>() {
        }.getType());

        for (OrderDTOListUser dtoListAdmin: dtos){
            OrderStatus newStatus = statusService.getNewestOrderStatus(dtoListAdmin.getId());
            dtoListAdmin.setLatestStatus(
                newStatus.getId().getStatus().toString()
            );
        }

        return dtos;
    }

    @GetMapping(value = "/MyOrder/{id}")
    public OrderDTODetailUser getOrderInDetailForUser(@RequestHeader("Authorization") String token,
                                                        @PathVariable ("id") String id) throws AccessDeniedException {

        Order order = orderService.getOrderById(token, id);


        return modelMapper.map(order, OrderDTODetailUser.class);
    }


    @GetMapping(value = "/Admin/{id}")
    public OrderDTODetailAdmin getOrderInDetailForAdmin(@PathVariable ("id") String id){

        Order order = orderService.getOrderById(id);


        return modelMapper.map(order, OrderDTODetailAdmin.class);
    }


    @PostMapping(value = "/User")
    public ResponseEntity<OrderDTO> createNewOrderByUser(@RequestHeader("Authorization") String token,
                                                            @Valid @ModelAttribute OrderCreateFormForUser orderCreateDTO) throws VoucherExpiredException {


        Account account = accountService.getAccountById(orderCreateDTO.getAccountId(), token);

        OrderCreateFormForUser formForUser = modelMapper.map(orderCreateDTO, OrderCreateFormForUser.class);
        formForUser.setAccountId(account.getUserInformation().getId());

        Order savedOrder = orderService.createOrder(formForUser);
        OrderDTO dto = modelMapper.map(savedOrder, OrderDTO.class);
        return ResponseEntity.ok(dto);
    }


}
