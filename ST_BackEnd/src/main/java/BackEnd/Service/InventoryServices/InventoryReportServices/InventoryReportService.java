package BackEnd.Service.InventoryServices.InventoryReportServices;


import BackEnd.Entity.InventoryEntities.InventoryReport;
import BackEnd.Entity.InventoryEntities.InventoryReportStatus;
import BackEnd.Form.InventoryForms.InventoryReportDetailForms.InventoryReportDetailCreateForm;
import BackEnd.Form.InventoryForms.InventoryReportDetailForms.InventoryReportDetailCreateFormForFirstTime;
import BackEnd.Form.InventoryForms.InventoryReportForms.InventoryReportCreateForm;
import BackEnd.Form.InventoryForms.InventoryReportForms.InventoryReportFilterForm;
import BackEnd.Form.InventoryForms.InventoryReportForms.InventoryReportUpdateForm;
import BackEnd.Form.InventoryForms.InventoryReportStatusForms.InventoryReportStatusCreateForm;
import BackEnd.Repository.InventoryRepositoties.IInventoryReportRepository;
import BackEnd.Service.InventoryServices.InventoryReportDetailServices.IInventoryReportDetailService;
import BackEnd.Service.InventoryServices.InventoryReportStatusServices.IInventoryReportStatusService;
import org.modelmapper.ModelMapper;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.data.domain.Page;
import org.springframework.data.domain.Pageable;
import org.springframework.data.jpa.domain.Specification;
import org.springframework.stereotype.Service;
import org.springframework.transaction.annotation.Transactional;
import BackEnd.Specification.InventorySpecification.InventoryReportSpecification;

@Service
public class InventoryReportService implements IInventoryReportService {

    @Autowired
    private IInventoryReportRepository inventoryReportRepository;

    @Autowired
    private IInventoryReportDetailService inventoryReportDetailService;

    @Autowired
    private IInventoryReportStatusService inventoryReportStatusService;

    @Autowired
    private ModelMapper modelMapper;

    @Override
    public InventoryReport getInventoryReportById(Integer id) {
        return inventoryReportRepository.findById(id).orElse(null);
    }

    @Override
    public Page<InventoryReport> getAllInventoryReports(Pageable pageable, InventoryReportFilterForm filterForm, String search) {
        Specification<InventoryReport> where = InventoryReportSpecification.buildWhere(search, filterForm);
        return inventoryReportRepository.findAll(where, pageable);
    }

    @Override
    @Transactional
    public InventoryReport createInventoryReport(InventoryReportCreateForm form) {
        InventoryReport inventoryReport = modelMapper.map(form, InventoryReport.class);
        inventoryReport = inventoryReportRepository.save(inventoryReport);
        for(InventoryReportDetailCreateFormForFirstTime detailForm: form.getInventoryReportDetailCreateFormList()){

            InventoryReportDetailCreateForm detailCreateForm = modelMapper.map(detailForm, InventoryReportDetailCreateForm.class);
            detailCreateForm.setIdInventoryReportId(inventoryReport.getId());

            inventoryReportDetailService.createInventoryReportDetail(detailCreateForm);
        }

        InventoryReportStatusCreateForm createForm = new InventoryReportStatusCreateForm();
        createForm.setInventoryReportId(inventoryReport.getId());
        createForm.setIdStatus(InventoryReportStatus.Status.ChoNhapKho);
        inventoryReportStatusService.createInventoryReportStatus(createForm);

        return inventoryReport;
    }

    @Override
    @Transactional
    public InventoryReport updateInventoryReportById(InventoryReportUpdateForm form) {
        InventoryReport inventoryReport = getInventoryReportById(form.getId());

        if (form.getSupplier() != null){
            inventoryReport.setSupplier(form.getSupplier());
        }

        if (form.getSupplierPhone() != null){
            inventoryReport.setSupplierPhone(form.getSupplierPhone());
        }

        if (form.getTotalPrice() != null){
            inventoryReport.setTotalPrice(form.getTotalPrice());
        }

        return inventoryReportRepository.save(inventoryReport);

    }
}

