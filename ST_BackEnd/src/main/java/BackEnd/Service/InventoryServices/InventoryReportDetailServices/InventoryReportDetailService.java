package BackEnd.Service.InventoryServices.InventoryReportDetailServices;

import BackEnd.Entity.InventoryEntities.InventoryReport;
import BackEnd.Entity.InventoryEntities.InventoryReportDetail;
import BackEnd.Form.InventoryForms.InventoryReportDetailForms.InventoryReportDetailCreateForm;
import BackEnd.Form.InventoryForms.InventoryReportDetailForms.InventoryReportDetailCreateFormForFirstTime;
import BackEnd.Form.InventoryForms.InventoryReportDetailForms.InventoryReportDetailUpdateForm;
import BackEnd.Repository.InventoryRepositoties.IInventoryReportDetailRepository;
import BackEnd.Service.InventoryServices.InventoryReportServices.IInventoryReportService;
import BackEnd.Service.ProductService.Product.IProductService;
import org.modelmapper.ModelMapper;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.context.annotation.Lazy;
import org.springframework.data.domain.Page;
import org.springframework.data.domain.Pageable;
import org.springframework.data.jpa.domain.Specification;
import org.springframework.stereotype.Service;
import org.springframework.transaction.annotation.Transactional;

import java.util.List;

@Service
public class InventoryReportDetailService implements IInventoryReportDetailService {

    @Autowired
    private IInventoryReportDetailRepository inventoryReportDetailRepository;

    @Autowired
    private ModelMapper modelMapper;

    @Autowired
    @Lazy
    private IInventoryReportService inventoryReportService;

    @Autowired
    private IProductService productService;

    @Override
    public List<InventoryReportDetail> getInventoryReportDetailByInventoryReportId(Integer id) {
        return inventoryReportDetailRepository.findByInventoryReportId_Id(id);
    }

    @Override
    public InventoryReportDetail getInventoryReportDetailById(InventoryReportDetail.InventoryReportDetailId id) {
        return inventoryReportDetailRepository.findById(id).orElse(null);
    }


    @Override
    @Transactional
    public InventoryReportDetail createInventoryReportDetail(InventoryReportDetailCreateForm form) {
        InventoryReportDetail inventoryReportDetail = modelMapper.map(form, InventoryReportDetail.class);
        return inventoryReportDetailRepository.save(inventoryReportDetail);
    }

    @Override
    @Transactional
    public InventoryReportDetail updateInventoryReportDetailById(InventoryReportDetailUpdateForm form) {
        InventoryReportDetail.InventoryReportDetailId id = new InventoryReportDetail.InventoryReportDetailId(
            form.getIdInventoryReportId(),
            form.getIdProductId()
        );
        InventoryReportDetail inventoryReportDetail = getInventoryReportDetailById(id);

//        InventoryReport inventoryReport = inventoryReportService.getInventoryReportById(form.getIdInventoryReportId());
//        inventoryReportDetail.setInventoryReport(inventoryReport);

        if (inventoryReportDetail != null) {
            if (form.getQuantity() != null) {
                inventoryReportDetail.setQuantity(form.getQuantity());
            }
            if (form.getUnitPrice() != null) {
                inventoryReportDetail.setUnitPrice(form.getUnitPrice());
            }
            if (form.getTotal() != null) {
                inventoryReportDetail.setTotal(form.getTotal());
            }
            return inventoryReportDetailRepository.save(inventoryReportDetail);
        }

        return null;
    }

    @Override
    public void deleteInventoryReportDetail(InventoryReportDetail.InventoryReportDetailId id) {
        inventoryReportDetailRepository.deleteById(id);
    }
}
