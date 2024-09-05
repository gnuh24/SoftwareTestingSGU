package BackEnd.Service.ShoppingServices.OrderServices;

import BackEnd.Entity.AccountEntity.Account;
import BackEnd.Entity.AccountEntity.UserInformation;
import BackEnd.Entity.ShoppingEntities.Order;
import BackEnd.Entity.ShoppingEntities.OrderStatus;
import BackEnd.Form.ShoppingForms.OrderDetailForm.OrderDetailCreateForm;
import BackEnd.Form.ShoppingForms.OrderForm.OrderCreateFormForUser;
import BackEnd.Form.ShoppingForms.OrderForm.OrderFilterForm;
import BackEnd.Form.ShoppingForms.OrderStatusForms.OrderStatusCreateFormForFirstTime;
import BackEnd.Repository.ShoppingRepositories.IOrderRepository;
import BackEnd.Service.AccountServices.AccountService.IAccountService;
import BackEnd.Service.AccountServices.AuthService.JWTUtils;
import BackEnd.Service.ShoppingServices.OrderDetailServices.IOrderDetailService;
import BackEnd.Service.ShoppingServices.OrderStatusServices.IOrderStatusService;
import BackEnd.Specification.ShoppingSpecifications.OrderSpecification;
import org.modelmapper.ModelMapper;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.data.domain.Page;
import org.springframework.data.domain.Pageable;
import org.springframework.data.jpa.domain.Specification;
import org.springframework.stereotype.Service;
import org.springframework.transaction.annotation.Transactional;

import java.nio.file.AccessDeniedException;
import java.util.List;

@Service
public class OrderService implements IOrderService{

    @Autowired
    private IOrderRepository orderRepository;

    @Autowired
    private IOrderDetailService orderDetailService;

    @Autowired
    private IOrderStatusService orderStatusService;

    @Autowired
    private IAccountService accountService;

    @Autowired
    private JWTUtils jwtUtilsl;

    @Autowired
    private ModelMapper modelMapper;


    @Override
    public Page<Order> getAllOrder(Pageable pageable, OrderFilterForm form, String search) {
        Specification<Order> where = OrderSpecification.buildWhere(search, form);
        return orderRepository.findAll(where, pageable);
    }

    @Override
    public List<Order> getAllOrderByUser(String token) {

        String email = jwtUtilsl.extractUsernameWithoutLibrary(token);

        Account account = accountService.getAccountByEmail(email);

        return orderRepository.findByAccount_Id(account.getId());
    }

    @Override
    public Order getOrderById(String orderId) {
        return orderRepository.findById(orderId).orElse(null);
    }

    @Override
    public Boolean isOrderBelongToThisId(Integer userInformationId, String orderId){
        return orderRepository.isOrderBelongToThisId(userInformationId, orderId);
    }

    @Override
    public Order getOrderById(String token, String orderId) throws AccessDeniedException {

        String email = jwtUtilsl.extractUsernameWithoutLibrary(token);

        Account account = accountService.getAccountByEmail(email);

        if (isOrderBelongToThisId(account.getId(), orderId)){
            return orderRepository.findById(orderId).orElse(null);
        }else{
            throw new AccessDeniedException("Bạn không có quyền truy cập thông tin này");
        }

    }


    @Override
    @Transactional
    public Order createOrder(OrderCreateFormForUser form) {

        // 1. Create new `Order`
        Order newOrder = modelMapper.map(form, Order.class);
        newOrder = orderRepository.save(newOrder);


        // 2. Create new `OrderDetail`s
        for (OrderDetailCreateForm form1: form.getListOrderDetail()){
            orderDetailService.createOrderDetail(newOrder, form1);
        }

        // 3. Create new `OrderStatus`
        OrderStatusCreateFormForFirstTime orderStatusCreateForm = new OrderStatusCreateFormForFirstTime(newOrder.getId(), OrderStatus.Status.ChoDuyet);
        orderStatusService.createOrderStatusFirstTime(orderStatusCreateForm);


        // 4. Liên kết thông tin người dùng
        Account in4 = accountService.getAccountById(form.getAccountId());
        newOrder.setAccount(in4);

        return newOrder;

    }

}
