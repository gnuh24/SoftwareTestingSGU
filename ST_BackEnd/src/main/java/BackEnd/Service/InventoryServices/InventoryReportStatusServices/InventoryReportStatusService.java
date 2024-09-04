package BackEnd.Service.InventoryServices.InventoryReportStatusServices;

import BackEnd.Entity.InventoryEntities.InventoryReportDetail;
import BackEnd.Entity.InventoryEntities.InventoryReportStatus;
import BackEnd.Entity.ProductEntity.ShoeSize;
import BackEnd.Form.InventoryForms.InventoryReportStatusForms.InventoryReportStatusCreateForm;
import BackEnd.Repository.InventoryRepositoties.IInventoryReportStatusRepository;
import BackEnd.Service.InventoryServices.InventoryReportDetailServices.IInventoryReportDetailService;
import BackEnd.Service.ProductService.ShoeSize.IShoeSizeService;
import org.modelmapper.ModelMapper;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;
import org.springframework.transaction.annotation.Transactional;

import java.util.List;

@Service
public class InventoryReportStatusService implements IInventoryReportStatusService {

    @Autowired
    private IInventoryReportStatusRepository inventoryReportStatusRepository;

    @Autowired
    private IInventoryReportDetailService inventoryReportDetailService;

    @Autowired
    private IShoeSizeService shoeSizeService;

    @Autowired
    private ModelMapper modelMapper;

    @Override
    public InventoryReportStatus getTheNewestStatusByInventoryReportId(Integer id) {
        // Retrieve the latest status by sorting on updateTime in descending order and limiting the result to 1.
        return inventoryReportStatusRepository.findLatestInventoryReportStatusByInventoryReportId(id);
    }


    @Override
    @Transactional
    /*
    Các trường hợp
        Không có gì -> Chờ nhập: Tạo trạng thái `chờ nhập`
        Chờ nhập -> Đã nhập : Tạo trạng thái `Đã nhap` + tăng số lượng sản phẩm
        Chờ nhập -> Hủy:   Tạo trạng thái `Huy`
        Đã nhập -> HỦy: Tạo trạng thái hủy và giảm số lượng đã nhập
     */
    public InventoryReportStatus createInventoryReportStatus(InventoryReportStatusCreateForm form) {

        InventoryReportStatus newsetStatus = getTheNewestStatusByInventoryReportId(form.getInventoryReportId());


        InventoryReportStatus inventoryReportStatus = modelMapper.map(form, InventoryReportStatus.class);

        inventoryReportStatus = inventoryReportStatusRepository.save(inventoryReportStatus);
        if (newsetStatus != null){
            List<InventoryReportDetail> details = inventoryReportDetailService.getInventoryReportDetailByInventoryReportId(form.getInventoryReportId());

            if (newsetStatus.getId().getStatus().equals(InventoryReportStatus.Status.ChoNhapKho) &&
                form.getIdStatus().equals(InventoryReportStatus.Status.DaNhapKho)){

                for (InventoryReportDetail ctdh : details) {
                    ShoeSize shoeSize = shoeSizeService.getShoeSizeById(ctdh.getId().getShoeId(), ctdh.getId().getSize());

                    Short soLuongConLai = (short) (shoeSize.getQuantity() + ctdh.getQuantity());

                    shoeSize.setQuantity(soLuongConLai);


                }

            }
        }


        return inventoryReportStatus;
    }
}


