package BackEnd.Controller.ShoppingControllers;

import BackEnd.Entity.ShoppingEntities.Voucher;
import BackEnd.Form.ShoppingForms.OrderForm.OrderDTOListUser;
import BackEnd.Form.ShoppingForms.VoucherForms.VoucherCreateForm;
import BackEnd.Form.ShoppingForms.VoucherForms.VoucherDTO;
import BackEnd.Form.ShoppingForms.VoucherForms.VoucherFilterForm;
import BackEnd.Form.ShoppingForms.VoucherForms.VoucherUpdateForm;
import BackEnd.Service.ShoppingServices.VoucherServices.IVoucherService;
import jakarta.validation.Valid;
import org.modelmapper.ModelMapper;
import org.modelmapper.TypeToken;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.data.domain.Page;
import org.springframework.data.domain.PageImpl;
import org.springframework.data.domain.Pageable;
import org.springframework.web.bind.annotation.*;


import java.time.LocalDate;
import java.time.LocalDateTime;
import java.util.Date;
import java.util.List;
import java.util.UUID;

@RestController
@RequestMapping("/Voucher")
@CrossOrigin(origins = "*")
public class VoucherController {

    @Autowired
    private IVoucherService voucherService;

    @Autowired
    private ModelMapper modelMapper;


    @GetMapping("/User")
    public List<VoucherDTO> getAllVouchersByUser() {

        List<Voucher> entities = voucherService.getAllVoucherByUser();

        return modelMapper.map(entities, new TypeToken<List<VoucherDTO>>() {}.getType());

    }

    @GetMapping("/Admin")
    public Page<VoucherDTO> getAllVouchersByAdmin(@RequestParam(required = false) String search,
                                                  Pageable pageable,
                                                  VoucherFilterForm form) {

        Page<Voucher> entities = voucherService.getAllVoucherByAdmin(pageable, form, search);

        List<VoucherDTO> dtos = modelMapper.map(entities.getContent(), new TypeToken<List<VoucherDTO>>() {}.getType());

        return new PageImpl<>(dtos, pageable, entities.getTotalElements());
    }

    @GetMapping()
    public VoucherDTO getAllVouchersByAdmin(@RequestParam String code) {

        Voucher entity = voucherService.getVoucherByCode(code);

        return modelMapper.map(entity, VoucherDTO.class);
    }


    @PostMapping
    public VoucherDTO createVoucher(@Valid @ModelAttribute VoucherCreateForm form) {
        if (form.getCode() == null) {
            String uuid = UUID.randomUUID().toString().replace("-", "").substring(0, 12);
            form.setCode(uuid);
        }
        return modelMapper.map(voucherService.createVoucher(form), VoucherDTO.class);
    }

    @PatchMapping
    public VoucherDTO updateVoucher(@Valid @ModelAttribute VoucherUpdateForm form) {
        return  modelMapper.map(voucherService.updateVoucher(form), VoucherDTO.class);
    }
}

