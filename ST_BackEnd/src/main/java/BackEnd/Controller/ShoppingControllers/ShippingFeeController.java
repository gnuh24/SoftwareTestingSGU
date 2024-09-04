package BackEnd.Controller.ShoppingControllers;

import BackEnd.Entity.ShoppingEntities.ShippingFee;
import BackEnd.Entity.ShoppingEntities.Voucher;
import BackEnd.Form.ShoppingForms.ShippngFeeForms.ShippingFeeCreateForm;
import BackEnd.Form.ShoppingForms.ShippngFeeForms.ShippingFeeDTO;
import BackEnd.Form.ShoppingForms.VoucherForms.VoucherDTO;
import BackEnd.Service.ShoppingServices.ShippingFeeServices.ShippingFeeService;
import org.modelmapper.ModelMapper;
import org.modelmapper.TypeToken;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.data.domain.Page;
import org.springframework.data.domain.PageImpl;
import org.springframework.data.domain.Pageable;
import org.springframework.web.bind.annotation.*;

import java.util.List;

@RestController
@RequestMapping("/ShippingFee")
@CrossOrigin(origins = "*")
public class ShippingFeeController {

    @Autowired
    private ShippingFeeService shippingFeeService;

    @Autowired
    private ModelMapper modelMapper;

    @PostMapping
    public ShippingFeeDTO createShippingFee(@ModelAttribute ShippingFeeCreateForm form) {
        return modelMapper.map(shippingFeeService.createShippingFee(form), ShippingFeeDTO.class);
    }

    @GetMapping()
    public Page<ShippingFeeDTO> getAll(Pageable pageable) {

        Page<ShippingFee> entities = shippingFeeService.getAllShippingFee(pageable);

        List<ShippingFeeDTO> dtos = modelMapper.map(entities.getContent(), new TypeToken<List<ShippingFeeDTO>>() {}.getType());

        return new PageImpl<>(dtos, pageable, entities.getTotalElements());
    }

    @GetMapping("/Newest")
    public ShippingFeeDTO getNewestShippingFee() {
        return modelMapper.map(shippingFeeService.getNewestShippingFee(), ShippingFeeDTO.class);
    }
}

