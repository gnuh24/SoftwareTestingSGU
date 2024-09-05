package BackEnd.Controller.InventoryControllers;

import BackEnd.Entity.InventoryEntities.InventoryReportStatus;
import BackEnd.Form.InventoryForms.InventoryReportStatusForms.InventoryReportStatusCreateForm;
import BackEnd.Form.InventoryForms.InventoryReportStatusForms.InventoryReportStatusDTO;
import BackEnd.Service.InventoryServices.InventoryReportStatusServices.IInventoryReportStatusService;
import org.modelmapper.ModelMapper;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.http.ResponseEntity;
import org.springframework.web.bind.annotation.*;

@RestController
@RequestMapping("/InventoryReportStatus")
@CrossOrigin(origins = "*")
public class InventoryReportStatusController {

    @Autowired
    private IInventoryReportStatusService inventoryReportStatusService;

    @Autowired
    private ModelMapper modelMapper;

    @PostMapping
    public ResponseEntity<InventoryReportStatusDTO> createInventoryReportStatus(@ModelAttribute InventoryReportStatusCreateForm form) {
        InventoryReportStatus createdStatus = inventoryReportStatusService.createInventoryReportStatus(form);
        return ResponseEntity.ok(modelMapper.map(createdStatus, InventoryReportStatusDTO.class ) );
    }
}