package BackEnd.Controller.ShoppingControllers;

import BackEnd.Entity.ShoppingEntities.Event;
import BackEnd.Entity.ShoppingEntities.Sale;
import BackEnd.Form.ShoppingForms.EventForms.EventDTO;
import BackEnd.Form.ShoppingForms.SaleForms.SaleCreateForm;
import BackEnd.Form.ShoppingForms.SaleForms.SaleDTO;
import BackEnd.Form.ShoppingForms.SaleForms.SaleDeleteForm;
import BackEnd.Service.ShoppingServices.SaleServices.ISaleService;
import org.modelmapper.ModelMapper;
import org.modelmapper.TypeToken;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.data.domain.Page;
import org.springframework.data.domain.PageImpl;
import org.springframework.http.ResponseEntity;
import org.springframework.web.bind.annotation.*;

import java.util.List;

@RestController
@RequestMapping("/Sale")
@CrossOrigin(origins = "*")
public class SaleController {

    @Autowired
    private ISaleService saleService;

    @Autowired
    private ModelMapper modelMapper;

    @GetMapping(value = "/{eventId}")
    public ResponseEntity<List<SaleDTO>> getSalesByEventId(@PathVariable Integer eventId) {
        List<Sale> entities =  saleService.getSaleByEventId(eventId);
        List<SaleDTO> dtos = modelMapper.map(entities, new TypeToken<List<SaleDTO>>() {}.getType());
        return ResponseEntity.ok(dtos);
    }

    @PostMapping
    public ResponseEntity<SaleDTO> createSale(@ModelAttribute SaleCreateForm form) {
        Sale sale = saleService.createSale(form);
        SaleDTO saleDTO = modelMapper.map(sale, SaleDTO.class);
        return ResponseEntity.ok(saleDTO);
    }

    @DeleteMapping
    public ResponseEntity<Void> deleteSale(@ModelAttribute SaleDeleteForm form) {
        saleService.deleteSale(form);
        return ResponseEntity.noContent().build();
    }
}

