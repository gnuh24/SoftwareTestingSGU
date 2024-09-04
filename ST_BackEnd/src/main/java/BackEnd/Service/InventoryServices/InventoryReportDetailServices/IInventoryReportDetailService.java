package BackEnd.Service.InventoryServices.InventoryReportDetailServices;

import BackEnd.Entity.InventoryEntities.InventoryReport;
import BackEnd.Entity.InventoryEntities.InventoryReportDetail;
import BackEnd.Form.InventoryForms.InventoryReportDetailForms.InventoryReportDetailCreateForm;
import BackEnd.Form.InventoryForms.InventoryReportDetailForms.InventoryReportDetailCreateFormForFirstTime;
import BackEnd.Form.InventoryForms.InventoryReportDetailForms.InventoryReportDetailUpdateForm;
import org.springframework.data.domain.Page;
import org.springframework.data.domain.Pageable;

import java.util.List;

public interface IInventoryReportDetailService {

    List<InventoryReportDetail> getInventoryReportDetailByInventoryReportId(Integer id);

    InventoryReportDetail getInventoryReportDetailById(InventoryReportDetail.InventoryReportDetailId id);


    InventoryReportDetail createInventoryReportDetail(InventoryReportDetailCreateForm form);

    InventoryReportDetail updateInventoryReportDetailById(InventoryReportDetailUpdateForm form);

    void deleteInventoryReportDetail(InventoryReportDetail.InventoryReportDetailId id);
}
