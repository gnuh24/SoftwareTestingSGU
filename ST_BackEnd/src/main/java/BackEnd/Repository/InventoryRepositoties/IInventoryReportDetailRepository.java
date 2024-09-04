package BackEnd.Repository.InventoryRepositoties;

import BackEnd.Entity.InventoryEntities.InventoryReportDetail;
import org.springframework.data.jpa.repository.JpaRepository;

import java.util.List;

public interface IInventoryReportDetailRepository extends JpaRepository<InventoryReportDetail, InventoryReportDetail.InventoryReportDetailId> {

    List<InventoryReportDetail> findByInventoryReportId_Id(Integer id);
}
