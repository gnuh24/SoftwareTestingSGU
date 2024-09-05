package BackEnd.Repository.ShoppingRepositories;

import BackEnd.Entity.ShoppingEntities.OrderDetail;
import org.springframework.data.jpa.repository.JpaRepository;

import java.util.List;

public interface IOrderDetailRepository extends JpaRepository<OrderDetail, OrderDetail.OrderDetailId> {

    List<OrderDetail> findByOrderId(String orderId);

}
