package BackEnd.Repository.InventoryRepositoties;

import BackEnd.Entity.InventoryEntities.InventoryReport;
import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.data.jpa.repository.JpaSpecificationExecutor;

public interface IInventoryReportRepository extends JpaRepository<InventoryReport, Integer>, JpaSpecificationExecutor<InventoryReport> {
}
