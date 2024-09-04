package BackEnd.Service.InventoryServices.InventoryReportStatusServices;


import BackEnd.Entity.InventoryEntities.InventoryReportStatus;
import BackEnd.Form.InventoryForms.InventoryReportStatusForms.InventoryReportStatusCreateForm;

import java.util.List;

public interface IInventoryReportStatusService {

    InventoryReportStatus getTheNewestStatusByInventoryReportId(Integer id);


    InventoryReportStatus createInventoryReportStatus(InventoryReportStatusCreateForm form);

}