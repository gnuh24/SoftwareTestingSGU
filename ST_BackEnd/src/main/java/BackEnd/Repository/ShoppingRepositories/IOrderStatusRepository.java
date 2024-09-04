package BackEnd.Repository.ShoppingRepositories;

import BackEnd.Entity.ShoppingEntities.OrderStatus;
import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.data.jpa.repository.Query;
import org.springframework.data.repository.query.Param;

import java.util.List;

public interface IOrderStatusRepository extends JpaRepository<OrderStatus, OrderStatus.OrderStatusId> {

    @Query(value = "SELECT * FROM `Order` od JOIN `OrderStatus` st ON od.`Id` = st.`OrderId`\n" +
        "WHERE st.`UpdateTime` = (\n" +
        "\tSELECT MAX(st2.`UpdateTime`) FROM `OrderStatus` st2\n" +
        "    WHERE st2.`OrderId` = od.`Id`\n" +
        ") AND st.`OrderId` = :orderId;", nativeQuery = true)
    OrderStatus findLatestOrderStatusByOrderId(@Param("orderId") String orderId);

}
