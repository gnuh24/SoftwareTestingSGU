package BackEnd.Controller.ShoppingControllers;

import BackEnd.Configure.ErrorResponse.VoucherExpiredException;
import BackEnd.Entity.AccountEntity.Account;
import BackEnd.Entity.ProductEntity.ShoeImage;
import BackEnd.Entity.ShoppingEntities.Order;
import BackEnd.Entity.ShoppingEntities.OrderStatus;
import BackEnd.Entity.ShoppingEntities.Voucher;
import BackEnd.Form.ShoppingForms.OrderDetailForm.OrderDetailDTO;
import BackEnd.Form.ShoppingForms.OrderForm.*;
import BackEnd.Service.AccountServices.AccountService.IAccountService;
import BackEnd.Service.AccountServices.UserInformationService.IUserInformationService;
import BackEnd.Service.ProductService.ShoeImage.IShoeImageService;
import BackEnd.Service.ShoppingServices.OrderServices.IOrderService;
import BackEnd.Service.ShoppingServices.OrderStatusServices.IOrderStatusService;
import BackEnd.Service.ShoppingServices.VoucherServices.IVoucherService;
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
    private IShoeImageService shoeImageService;

    @Autowired
    private IVoucherService voucherService;

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

            for (OrderDetailDTO orderDetailDTO: dtoListAdmin.getOrderDetails()){

                ShoeImage shoeImage = shoeImageService.getShoeImageByShoeIdAndPriority(orderDetailDTO.getIdShoeId(), true);

                String defaultImage = shoeImage.getPath();
                orderDetailDTO.setDefaultImage(defaultImage);
            }

        }

        return dtos;
    }

    @GetMapping(value = "/MyOrder/{id}")
    public OrderDTODetailUser getOrderInDetailForUser(@RequestHeader("Authorization") String token,
                                                        @PathVariable ("id") String id) throws AccessDeniedException {

        Order order = orderService.getOrderById(token, id);

        OrderDTODetailUser orderDTODetailAdmin = modelMapper.map(order, OrderDTODetailUser.class);

        for (OrderDetailDTO orderDetailDTO: orderDTODetailAdmin.getOrderDetails()){

            ShoeImage shoeImage = shoeImageService.getShoeImageByShoeIdAndPriority(orderDetailDTO.getIdShoeId(), true);

            String defaultImage = shoeImage.getPath();
            orderDetailDTO.setDefaultImage(defaultImage);
        }

        return orderDTODetailAdmin;
    }


    @GetMapping(value = "/Admin/{id}")
    public OrderDTODetailAdmin getOrderInDetailForAdmin(@PathVariable ("id") String id){

        Order order = orderService.getOrderById(id);
        OrderDTODetailAdmin orderDTODetailAdmin = modelMapper.map(order, OrderDTODetailAdmin.class);

        for (OrderDetailDTO orderDetailDTO: orderDTODetailAdmin.getOrderDetails()){

            ShoeImage shoeImage = shoeImageService.getShoeImageByShoeIdAndPriority(orderDetailDTO.getIdShoeId(), true);

            String defaultImage = shoeImage.getPath();
            orderDetailDTO.setDefaultImage(defaultImage);
        }

        return orderDTODetailAdmin;
    }

    @PostMapping(value = "/Admin")
    public ResponseEntity<OrderDTO> createNewOrderByAdmin(@Valid @ModelAttribute OrderCreateFormForAdmin orderCreateDTO) throws VoucherExpiredException {
        Voucher voucher = null;

        if (orderCreateDTO.getVoucherId() != null){
            voucher = voucherService.getVoucherById(orderCreateDTO.getVoucherId());
            if (voucher.getExpirationTime().isBefore(LocalDateTime.now())){
                throw new VoucherExpiredException("Voucher đã hết hạn sử dụng !!");
            }
        }

        Order savedOrder = orderService.createOrder(voucher, orderCreateDTO);
        OrderDTO dto = modelMapper.map(savedOrder, OrderDTO.class);
        return ResponseEntity.ok(dto);
    }

    @PostMapping(value = "/User")
    public ResponseEntity<OrderDTO> createNewOrderByUser(@RequestHeader("Authorization") String token,
                                                            @Valid @ModelAttribute OrderCreateFormForUser orderCreateDTO) throws VoucherExpiredException {
        Voucher voucher = null;
        if (orderCreateDTO.getVoucherId() != null){
            voucher = voucherService.getVoucherById(orderCreateDTO.getVoucherId());
            if (voucher.getExpirationTime().isBefore(LocalDateTime.now())){
                throw new VoucherExpiredException("Voucher đã hết hạn sử dụng !!");
            }
        }

        Account account = accountService.getAccountById(orderCreateDTO.getAccountId(), token);

        OrderCreateFormForAdmin formForAdmin = modelMapper.map(orderCreateDTO, OrderCreateFormForAdmin.class);
        formForAdmin.setUserInformationId(account.getUserInformation().getId());

        Order savedOrder = orderService.createOrder(voucher, formForAdmin);
        OrderDTO dto = modelMapper.map(savedOrder, OrderDTO.class);
        return ResponseEntity.ok(dto);
    }

    @PatchMapping()
    public ResponseEntity<OrderDTO> updateOrder( @ModelAttribute OrderUpdateForm orderUpdateForm) {

        // Save the updated order
        Order updatedOrder = orderService.updateOrder(orderUpdateForm);

        // Map the updated order to DTO
        OrderDTO dto = modelMapper.map(updatedOrder, OrderDTO.class);

        // Return ResponseEntity with the updated DTO
        return ResponseEntity.ok(dto);
    }
}
