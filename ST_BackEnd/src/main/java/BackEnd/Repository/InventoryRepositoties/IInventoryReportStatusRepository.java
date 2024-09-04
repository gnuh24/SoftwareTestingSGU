package BackEnd.Repository.InventoryRepositoties;

import BackEnd.Entity.InventoryEntities.InventoryReportStatus;
import BackEnd.Entity.ShoppingEntities.OrderStatus;
import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.data.jpa.repository.Query;
import org.springframework.data.repository.query.Param;

import java.util.List;

public interface IInventoryReportStatusRepository extends JpaRepository<InventoryReportStatus, InventoryReportStatus.InventoryReportStatusId> {

    @Query(value = "SELECT * FROM `InventoryReport` od JOIN `InventoryReportStatus` st ON od.`Id` = st.`InventoryReportId`\n" +
        "WHERE st.`UpdateTime` = (\n" +
        "\tSELECT MAX(st2.`UpdateTime`) FROM `InventoryReportStatus` st2\n" +
        "    WHERE st2.`InventoryReportId` = od.`Id`\n" +
        ") AND st.`InventoryReportId` = :inventoryReportId;", nativeQuery = true)
    InventoryReportStatus findLatestInventoryReportStatusByInventoryReportId(@Param("inventoryReportId") Integer inventoryReportId);


    List <InventoryReportStatus> findByInventoryReportId(Integer invenrotyReportId);
}
