package BackEnd.Controller.ProductController;


import BackEnd.Entity.ProductEntity.ShoeType;
import BackEnd.Form.ProductForm.ShoeTypeForm.ShoeTypeCreateForm;
import BackEnd.Form.ProductForm.ShoeTypeForm.ShoeTypeDTO;
import BackEnd.Form.ProductForm.ShoeTypeForm.ShoeTypeUpdateForm;
import BackEnd.Service.ProductService.ShoeType.IShoeTypeService;
import jakarta.validation.Valid;
import org.modelmapper.ModelMapper;
import org.modelmapper.TypeToken;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.data.domain.Page;
import org.springframework.data.domain.PageImpl;
import org.springframework.data.domain.Pageable;
import org.springframework.web.bind.annotation.*;

import java.util.List;

@RestController
@RequestMapping(value = "/ShoeType")
@CrossOrigin(origins = "*")
public class ShoeTypeController {

    @Autowired
    private IShoeTypeService shoeTypeService;

    @Autowired
    private ModelMapper modelMapper;

    @GetMapping(value = "/noPaging")
    //API lấy danh sách `ShoeType` phiên bản không paging dành cho các Combobox
    public List<ShoeTypeDTO> getAllShoeTypeNoPaging(){

        //  1. Lấy dữ liệu từ Service
        List<ShoeType> list = shoeTypeService.getAllShoeTypeNoPaging();

        // 2. Dùng Model Mapper để chuyển từ list ShoeType -> list ShoeTypeDTO
        return modelMapper.map(list, new TypeToken<List<ShoeTypeDTO>>(){}.getType());

    }

    @GetMapping()
    //API lấy toàn bộ danh sách bao gồm cả Paing dành cho Admin
    public Page<ShoeTypeDTO> getAllShoeType(Pageable pageable,
                                          @RequestParam(name = "search", required = false) String search){

        // 1. Lấy toàn bộ danh sách `ShoeType` theo yêu cầu
        Page<ShoeType> entites = shoeTypeService.getAllShoeType(pageable, search);

        // 2. Chuyển thành List DTO
        List<ShoeTypeDTO> dtos = modelMapper.map(entites.getContent(), new TypeToken<List<ShoeTypeDTO>>(){}.getType());

        // 3. Trả về phiên ban Page DTO
        return new PageImpl<>(dtos, pageable, entites.getTotalElements());
    }

    @GetMapping(value = "/{shoeTypeId}")
    public ShoeTypeDTO getShoeTypeById(@PathVariable  Integer shoeTypeId){
        ShoeType entity = shoeTypeService.getShoeTypeById(shoeTypeId);
        return modelMapper.map(entity, ShoeTypeDTO.class);
    }

    @PostMapping()
    public ShoeTypeDTO createShoeType(@ModelAttribute @Valid ShoeTypeCreateForm form){
        ShoeType entity = shoeTypeService.createShoeType(form);
        return modelMapper.map(entity, ShoeTypeDTO.class);
    }

    @PatchMapping()
    public ShoeTypeDTO updateShoeType(@ModelAttribute @Valid ShoeTypeUpdateForm form){
        ShoeType entity = shoeTypeService.updateShoeType(form);
        return modelMapper.map(entity, ShoeTypeDTO.class);
    }

    @DeleteMapping(value = "/{shoeTypeId}")
    public void deleteShoeType(@PathVariable  Integer shoeTypeId){
        shoeTypeService.deleteShoeType(shoeTypeId);
    }

}
