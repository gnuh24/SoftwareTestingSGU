package BackEnd.Repository.ShoppingRepositories;

import BackEnd.Entity.ShoppingEntities.Order;
import BackEnd.Form.StatisticForms.BestSellerForm;
import BackEnd.Form.StatisticForms.BestSellerSizeForm;
import BackEnd.Form.StatisticForms.IncomeSummaryForm;
import BackEnd.Form.StatisticForms.OrderStatusSummary;
import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.data.jpa.repository.JpaSpecificationExecutor;
import org.springframework.data.jpa.repository.Query;
import org.springframework.data.repository.query.Param;

import java.time.LocalDate;
import java.util.List;

public interface IOrderRepository extends JpaRepository<Order, String>, JpaSpecificationExecutor<Order> {

    List<Order> findByUserInformation_Id(Integer userInformationId);

    @Query("SELECT CASE WHEN COUNT(o) > 0 THEN true ELSE false END " +
        "FROM Order o " +
        "WHERE o.userInformation.id = :userInformationId " +
        "AND o.id = :orderId")
    Boolean isOrderBelongToThisId(@Param("userInformationId") Integer userInformationId,
                                  @Param("orderId") String orderId);

    @Query(value = "SELECT s.ShoeId AS shoeId, s.ShoeName AS shoeName, " +
        "COUNT(od.Quantity) AS quantity, SUM(od.Total) AS total " +
        "FROM `Order` o " +
        "JOIN `OrderDetail` od ON o.Id = od.OrderId " +
        "JOIN `Shoe` s ON od.ShoeId = s.ShoeId " +
        "JOIN `OrderStatus` os ON os.OrderId = o.Id " +
        "JOIN `Brand` b ON s.BrandId = b.BrandId " + // Join with Brand table
        "JOIN `ShoeType` st ON s.ShoeTypeId = st.ShoeTypeId " + // Join with ShoeType table
        "WHERE os.Status = 'GiaoThanhCong' AND " +
        "DATE(os.UpdateTime) BETWEEN COALESCE(:minDate, '2022-01-01') AND COALESCE(:maxDate, CURRENT_DATE()) " +
        "AND (:brandId IS NULL OR b.BrandId = :brandId) " + // Filter by brandId if provided
        "AND (:shoeTypeId IS NULL OR st.ShoeTypeId = :shoeTypeId) " + // Filter by shoeTypeId if provided
        "GROUP BY s.ShoeId, s.ShoeName " +
        "ORDER BY total DESC, quantity DESC " +
        "LIMIT :limit", nativeQuery = true)
    List<BestSellerForm> findShoeSales(@Param("minDate") String minDate,
                                       @Param("maxDate") String maxDate,
                                       @Param("limit") Integer limit,
                                       @Param("brandId") Integer brandId,
                                       @Param("shoeTypeId") Integer shoeTypeId);


    @Query(value = "SELECT s.ShoeId AS shoeId, s.ShoeName AS shoeName, od.Size AS size, " +
        "COUNT(od.Quantity) AS quantity, SUM(od.Total) AS total " +
        "FROM `Order` o " +
        "JOIN `OrderDetail` od ON o.Id = od.OrderId " +
        "JOIN `Shoe` s ON od.ShoeId = s.ShoeId " +
        "JOIN `OrderStatus` os ON os.OrderId = o.Id " +
        "WHERE os.Status = 'GiaoThanhCong' AND " +
        "s.ShoeId = :shoeId AND " +
        "DATE(os.UpdateTime) BETWEEN COALESCE(:minDate, '2022-01-01') AND COALESCE(:maxDate, CURRENT_DATE()) " +
        "GROUP BY s.ShoeId, s.ShoeName, od.Size " +
        "ORDER BY total DESC, quantity DESC", nativeQuery = true)
    List<BestSellerSizeForm> findShoeSizeSales(@Param("shoeId") Integer shoeId,
                                               @Param("minDate") String minDate,
                                               @Param("maxDate") String maxDate);



    @Query(value = "SELECT ot.Status AS status, COUNT(ot.Status) AS quantity, DATE(ot.UpdateTime) AS updateDate " +
        "FROM `Order` od " +
        "JOIN `OrderStatus` ot ON od.Id = ot.OrderId " +
        "WHERE ot.UpdateTime = (" +
        "  SELECT MAX(ot2.UpdateTime) FROM `OrderStatus` ot2 " +
        "  WHERE ot2.OrderId = od.Id" +
        ") " +
        "AND DATE(ot.UpdateTime) BETWEEN COALESCE(:minDate, '2010-01-01') AND COALESCE(:maxDate, CURRENT_DATE()) " +
        "GROUP BY ot.Status, DATE(ot.UpdateTime) " +
        "ORDER BY DATE(ot.UpdateTime)",
        nativeQuery = true)
    List<OrderStatusSummary> findOrderStatusSummary(@Param("minDate") String minDate, @Param("maxDate") String maxDate);

    @Query(value = "SELECT SUM(od.TotalPrice) AS income, DATE(ot.UpdateTime) AS updateDate " +
        "FROM `Order` od " +
        "JOIN `OrderStatus` ot ON od.Id = ot.OrderId " +
        "WHERE ot.UpdateTime = ( " +
        "    SELECT MAX(ot2.UpdateTime) " +
        "    FROM `OrderStatus` ot2 " +
        "    WHERE ot2.OrderId = od.Id " +
        ") " +
        "AND DATE(ot.UpdateTime) BETWEEN COALESCE(:minDate, '2010-01-01') AND COALESCE(:maxDate, CURRENT_DATE()) " +
        "AND ot.Status = 'GiaoThanhCong' " +
        "GROUP BY updateDate " +
        "ORDER BY updateDate", nativeQuery = true)
    List<IncomeSummaryForm> findIncomeSummary(@Param("minDate") String minDate,
                                          @Param("maxDate") String maxDate);


}
