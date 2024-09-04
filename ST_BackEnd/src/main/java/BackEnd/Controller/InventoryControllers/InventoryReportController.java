package BackEnd.Controller.InventoryControllers;

import BackEnd.Entity.InventoryEntities.InventoryReport;
import BackEnd.Entity.InventoryEntities.InventoryReportDetail;
import BackEnd.Entity.InventoryEntities.InventoryReportStatus;
import BackEnd.Form.InventoryForms.InventoryReportDetailForms.InventoryReportDetailDTO;
import BackEnd.Form.InventoryForms.InventoryReportForms.*;
import BackEnd.Service.InventoryServices.InventoryReportDetailServices.IInventoryReportDetailService;
import BackEnd.Service.InventoryServices.InventoryReportDetailServices.InventoryReportDetailService;
import BackEnd.Service.InventoryServices.InventoryReportServices.IInventoryReportService;
import BackEnd.Service.InventoryServices.InventoryReportServices.InventoryReportService;
import BackEnd.Service.InventoryServices.InventoryReportStatusServices.IInventoryReportStatusService;
import org.modelmapper.ModelMapper;
import org.modelmapper.TypeToken;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.data.domain.Page;
import org.springframework.data.domain.Pageable;
import org.springframework.http.ResponseEntity;
import org.springframework.web.bind.annotation.*;

import java.util.List;

@RestController
@RequestMapping("/InventoryReport")
@CrossOrigin(origins = "*")
public class InventoryReportController {

    @Autowired
    private IInventoryReportService inventoryReportService;

    @Autowired
    private IInventoryReportDetailService inventoryReportDetailService;

    @Autowired
    private IInventoryReportStatusService inventoryReportStatusService;

    @Autowired
    private ModelMapper modelMapper;

    @GetMapping("/{id}")
    public ResponseEntity<InventoryReportInDetailDTO> getInventoryReportById(@PathVariable Integer id) {
        InventoryReport inventoryReport = inventoryReportService.getInventoryReportById(id);

        if (inventoryReport == null) {
            return ResponseEntity.notFound().build();
        }

        InventoryReportInDetailDTO inventoryReportDTO = modelMapper.map(inventoryReport, InventoryReportInDetailDTO.class);

        return ResponseEntity.ok(inventoryReportDTO);
    }

    @GetMapping
    public ResponseEntity<Page<InventoryReportListDTO>> getAllInventoryReports(Pageable pageable,
                                                                               InventoryReportFilterForm filterForm,
                                                                               @RequestParam(required = false) String search) {
        Page<InventoryReport> page = inventoryReportService.getAllInventoryReports(pageable, filterForm, search);
        Page<InventoryReportListDTO> dtoPage = page.map(inventoryReport -> modelMapper.map(inventoryReport, InventoryReportListDTO.class));

        for (InventoryReportListDTO listDTO: dtoPage.getContent()){
            InventoryReportStatus status = inventoryReportStatusService.getTheNewestStatusByInventoryReportId(listDTO.getId());
            listDTO.setStatus(status.getId().getStatus().toString());
        }

        return ResponseEntity.ok(dtoPage);
    }

    @PostMapping
    public ResponseEntity<InventoryReportListDTO> createInventoryReport(@ModelAttribute InventoryReportCreateForm form) {
        InventoryReport createdInventoryReport = inventoryReportService.createInventoryReport(form);
        InventoryReportListDTO inventoryReportDTO = modelMapper.map(createdInventoryReport, InventoryReportListDTO.class);

        // Tìm status mới nhất
        inventoryReportDTO.setStatus(
            inventoryReportStatusService.getTheNewestStatusByInventoryReportId(
                inventoryReportDTO.getId()
            ).getId().getStatus().toString()
        );

        return ResponseEntity.ok(inventoryReportDTO);
    }

    @PatchMapping
    public ResponseEntity<InventoryReportListDTO> updateInventoryReportById(@ModelAttribute InventoryReportUpdateForm form) {

        InventoryReport updatedInventoryReport = inventoryReportService.updateInventoryReportById(form);
        InventoryReportListDTO inventoryReportDTO = modelMapper.map(updatedInventoryReport, InventoryReportListDTO.class);

        // Tìm status mới nhất
        inventoryReportDTO.setStatus(
            inventoryReportStatusService.getTheNewestStatusByInventoryReportId(
                inventoryReportDTO.getId()
            ).getId().getStatus().toString()
        );

        return ResponseEntity.ok(inventoryReportDTO);
    }
}
