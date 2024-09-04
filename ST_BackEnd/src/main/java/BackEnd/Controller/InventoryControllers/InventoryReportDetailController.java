package BackEnd.Controller.InventoryControllers;

import BackEnd.Entity.InventoryEntities.InventoryReportDetail;
import BackEnd.Form.InventoryForms.InventoryReportDetailForms.InventoryReportDetailCreateForm;
import BackEnd.Form.InventoryForms.InventoryReportDetailForms.InventoryReportDetailDTO;
import BackEnd.Form.InventoryForms.InventoryReportDetailForms.InventoryReportDetailDeleteForm;
import BackEnd.Form.InventoryForms.InventoryReportDetailForms.InventoryReportDetailUpdateForm;
import BackEnd.Service.InventoryServices.InventoryReportDetailServices.IInventoryReportDetailService;
import jakarta.validation.Valid;
import org.modelmapper.ModelMapper;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.data.domain.Page;
import org.springframework.data.domain.Pageable;
import org.springframework.http.ResponseEntity;
import org.springframework.web.bind.annotation.*;

@RestController
@RequestMapping("/InventoryReportDetail")
@CrossOrigin(origins = "*")
public class InventoryReportDetailController {

    @Autowired
    private IInventoryReportDetailService inventoryReportDetailService;

    @Autowired
    private ModelMapper modelMapper;


    @PostMapping
    public ResponseEntity<InventoryReportDetailDTO> createInventoryReportDetail(@ModelAttribute @Valid InventoryReportDetailCreateForm form) {
        InventoryReportDetail createdInventoryReportDetail = inventoryReportDetailService.createInventoryReportDetail(form);
        InventoryReportDetailDTO dto = modelMapper.map(createdInventoryReportDetail, InventoryReportDetailDTO.class);
        return ResponseEntity.ok(dto);
    }

    @PatchMapping()
    public ResponseEntity<InventoryReportDetailDTO> updateInventoryReportDetail(@ModelAttribute InventoryReportDetailUpdateForm form) {
        InventoryReportDetail updatedInventoryReportDetail = inventoryReportDetailService.updateInventoryReportDetailById(form);
        InventoryReportDetailDTO dto = modelMapper.map(updatedInventoryReportDetail, InventoryReportDetailDTO.class);
        return ResponseEntity.ok(dto);
    }

    @DeleteMapping()
    public ResponseEntity<Void> deleteInventoryReportDetail(@ModelAttribute InventoryReportDetailDeleteForm form) {

        InventoryReportDetail.InventoryReportDetailId id = new InventoryReportDetail.InventoryReportDetailId(
                                                                                                form.getIdInventoryReportId(),
                                                                                                form.getIdShoeId(),
                                                                                                form.getIdSize());

        inventoryReportDetailService.deleteInventoryReportDetail(id);
        return ResponseEntity.noContent().build();
    }
}

