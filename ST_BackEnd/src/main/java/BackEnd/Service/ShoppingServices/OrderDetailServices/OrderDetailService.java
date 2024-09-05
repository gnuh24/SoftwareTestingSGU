package BackEnd.Service.ShoppingServices.OrderDetailServices;

import BackEnd.Entity.ProductEntity.Product;
import BackEnd.Entity.ShoppingEntities.Order;
import BackEnd.Entity.ShoppingEntities.OrderDetail;
import BackEnd.Form.ShoppingForms.OrderDetailForm.OrderDetailCreateForm;
import BackEnd.Repository.ShoppingRepositories.IOrderDetailRepository;
import BackEnd.Service.ProductService.Product.IProductService;
import org.modelmapper.ModelMapper;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;

import java.util.List;

@Service
public class OrderDetailService implements IOrderDetailService{

    @Autowired
    private IOrderDetailRepository orderDetailRepository;

    @Autowired
    private IProductService productService;


    @Autowired
    private ModelMapper modelMapper;

    @Override
    public List<OrderDetail> getAllOrderDetailByOrderId(String orderId) {
        return orderDetailRepository.findByOrderId(orderId);
    }


//    @Override
//    public OrderDetail createOrderDetail(Order order, OrderDetailCreateForm listForm) {
//        OrderDetail orderDetail = modelMapper.map(listForm, OrderDetail.class);
//        orderDetail.setOrder(order);
//        return orderDetailRepository.save(orderDetail);
//    }

    @Override
    public OrderDetail createOrderDetail(Order order, OrderDetailCreateForm listForm) {

        OrderDetail orderDetail = modelMapper.map(listForm, OrderDetail.class);
        orderDetail.setOrder(order);

        OrderDetail.OrderDetailId id = new OrderDetail.OrderDetailId(order.getId(), listForm.getProductId());
        orderDetail.setId(id);

        return orderDetailRepository.save(orderDetail);
    }

}
