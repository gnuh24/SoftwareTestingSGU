package BackEnd.Service.InventoryServices.InventoryReportServices;

import BackEnd.Entity.InventoryEntities.InventoryReport;
import BackEnd.Form.InventoryForms.InventoryReportForms.InventoryReportCreateForm;
import BackEnd.Form.InventoryForms.InventoryReportForms.InventoryReportFilterForm;
import BackEnd.Form.InventoryForms.InventoryReportForms.InventoryReportUpdateForm;
import org.springframework.data.domain.Page;
import org.springframework.data.domain.Pageable;

public interface IInventoryReportService {
    InventoryReport getInventoryReportById(Integer id);
    Page<InventoryReport> getAllInventoryReports(Pageable pageable, InventoryReportFilterForm filterForm, String search);
    InventoryReport createInventoryReport(InventoryReportCreateForm form);
    InventoryReport updateInventoryReportById(InventoryReportUpdateForm form);
}

