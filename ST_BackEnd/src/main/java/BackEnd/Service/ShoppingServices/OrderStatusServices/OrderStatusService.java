package BackEnd.Service.ShoppingServices.OrderStatusServices;

import BackEnd.Configure.ErrorResponse.NotEnoughInventory;
import BackEnd.Entity.AccountEntity.UserInformation;
import BackEnd.Entity.ProductEntity.ShoeSize;
import BackEnd.Entity.ShoppingEntities.Order;
import BackEnd.Entity.ShoppingEntities.OrderDetail;
import BackEnd.Entity.ShoppingEntities.OrderStatus;
import BackEnd.Form.ShoppingForms.OrderStatusForms.OrderStatusCreateFormForFirstTime;
import BackEnd.Repository.ShoppingRepositories.IOrderStatusRepository;
import BackEnd.Service.AccountServices.AuthService.JWTUtils;
import BackEnd.Service.AccountServices.UserInformationService.IUserInformationService;
import BackEnd.Service.ProductService.ShoeSize.IShoeSizeService;
import BackEnd.Service.ShoppingServices.OrderDetailServices.IOrderDetailService;
import BackEnd.Service.ShoppingServices.OrderServices.IOrderService;
import org.modelmapper.ModelMapper;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.context.annotation.Lazy;
import org.springframework.stereotype.Service;
import org.springframework.transaction.annotation.Transactional;

import java.nio.file.AccessDeniedException;
import java.util.List;

@Service
public class OrderStatusService implements IOrderStatusService{

    @Autowired
    private IOrderStatusRepository orderStatusRepository;

    @Autowired
    private IOrderDetailService orderDetailService;

    @Autowired
    private IShoeSizeService shoeSizeServicel;

    @Autowired
    private JWTUtils jwtUtils;

    @Autowired
    @Lazy
    private IOrderService orderService;

    @Autowired
    private IUserInformationService userInformationService;

    @Autowired
    private ModelMapper  modelMapper;

    @Override
    public OrderStatus getNewestOrderStatus(String orderId) {
        return orderStatusRepository.findLatestOrderStatusByOrderId(orderId);
    }

    @Override
    @Transactional
    public OrderStatus createOrderStatusFirstTime(OrderStatusCreateFormForFirstTime form) {

        OrderStatus newOrderStatus = modelMapper.map(form, OrderStatus.class);

        return orderStatusRepository.save(newOrderStatus);

    }

    @Override
    @Transactional
    public OrderStatus createOrderStatus(OrderStatusCreateFormForFirstTime form) throws NotEnoughInventory {

        OrderStatus orderStatus = modelMapper.map(form, OrderStatus.class);

        /**
         *  Có 2 tình huống có thể xảy ra
         *  1. Khởi tạo trạng thái lần đầu
         *      + Kiếm thử xem đơn hàng này đã có trạng thái gì trước đó chưa ?
         *      + Nếu chưa thì khởi tạo và bỏ qua phần kiểm trạng thái bên dưới và khởi tạo trạng thái mới.
         *      + Nếu đã có thì tới trường hợp thứ 2.
         *
         *  2. Chuyển trạng thái.
         *      + Nếu đơn hàng từ ChoDuyet thành DaDuyet -> Giảm số lượng toàn bộ Sản Phẩm có trong đơn hàng
         *      + Nếu đơn hàng từ ChoDuyet thành Huy -> Không làm gì cả
         *      + Nếu đơn hàng từ DaDuyet thành Huy -> Check để refund lại số lượng đã mua
         */

        //Kiểm tra xem đã tồn tai trạng thái đơn hàng cu chưa ?
        OrderStatus oldOrderStatus = getNewestOrderStatus(form.getOrderId());

        if ( oldOrderStatus != null) {
            //Duyệt sẽ giảm số lượng
            if (form.getIdStatus().equals(OrderStatus.Status.DaDuyet)) {
                List<OrderDetail> chiTietDonHang = orderDetailService.getAllOrderDetailByOrderId(form.getOrderId());
                for (OrderDetail ctdh : chiTietDonHang) {
                    ShoeSize shoeSize = shoeSizeServicel.getShoeSizeById(ctdh.getId().getShoeId(), ctdh.getId().getSize());

                    Short soLuongConLai = (short) (shoeSize.getQuantity() - ctdh.getQuantity());

                    if (soLuongConLai >= 0){
                        shoeSize.setQuantity(soLuongConLai);
                    }else{
                        throw new NotEnoughInventory("Không đủ sản phẩm " + shoeSize.getShoe().getShoeName() + ", size: "+ shoeSize.getId().getSize() +  " tồn kho !!");
                    }

                }
            }

            //Refund lại số lượng khi hủy 1 đơn hàng đã được duyệt
            else if (form.getIdStatus().equals(OrderStatus.Status.Huy) &&
                        (   oldOrderStatus.getId().getStatus().equals(OrderStatus.Status.DaDuyet) ||
                            oldOrderStatus.getId().getStatus().equals(OrderStatus.Status.DangGiao) ||
                            oldOrderStatus.getId().getStatus().equals(OrderStatus.Status.GiaoThanhCong))
                    ) {
                List<OrderDetail> chiTietDonHang = orderDetailService.getAllOrderDetailByOrderId(form.getOrderId());
                for (OrderDetail ctdh : chiTietDonHang) {

                    ShoeSize shoeSize = shoeSizeServicel.getShoeSizeById(ctdh.getId().getShoeId(), ctdh.getId().getSize());
                    shoeSize.setQuantity((short) (shoeSize.getQuantity() + ctdh.getQuantity()));

                }
            }
        }

        return orderStatusRepository.save(orderStatus);
    }

    @Override
    public OrderStatus createOrderStatus(String token, OrderStatusCreateFormForFirstTime form) throws NotEnoughInventory, AccessDeniedException {

        String email = jwtUtils.extractUsernameWithoutLibrary(token);

        UserInformation userInformation = userInformationService.getUserByEmail(email);

        if (orderService.isOrderBelongToThisId(userInformation.getId(), form.getOrderId())){
            return createOrderStatus(form);
        }else{
            throw new AccessDeniedException("Bạn không có quyền truy cập thông tin này");
        }

    }


}
