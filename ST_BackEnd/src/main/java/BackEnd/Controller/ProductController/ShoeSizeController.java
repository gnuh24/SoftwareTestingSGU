package BackEnd.Controller.ProductController;

import BackEnd.Entity.ProductEntity.ShoeSize;
import BackEnd.Form.ProductForm.ShoeSizeForm.ShoeSizeCreateForm;
import BackEnd.Form.ProductForm.ShoeSizeForm.ShoeSizeDTO;
import BackEnd.Form.ProductForm.ShoeSizeForm.ShoeSizeUpdateForm;
import BackEnd.Service.ProductService.ShoeSize.IShoeSizeService;
import org.modelmapper.ModelMapper;
import org.modelmapper.TypeToken;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.web.bind.annotation.*;

import java.io.IOException;
import java.util.List;

@RestController
@RequestMapping(value = "/ShoeSize")
@CrossOrigin(origins = "http://localhost:5173")
public class ShoeSizeController {

    @Autowired
    private IShoeSizeService shoeSizeService;

    @Autowired
    private ModelMapper modelMapper;

    @GetMapping(value = "/{shoeId}")
    public List<ShoeSizeDTO> getAllShoeSizeByShoeId(@PathVariable Integer shoeId) {
        List<ShoeSize> shoeSize = shoeSizeService.getAllShoeSizeByShoeId(shoeId);

        return modelMapper.map(shoeSize, new TypeToken<List<ShoeSizeDTO>>(){}.getType());

    }

    @PostMapping(value = "/{shoeId}")
    public ShoeSizeDTO createShoe(@PathVariable  Integer shoeId,
                                             @ModelAttribute ShoeSizeCreateForm form) throws IOException {
       ShoeSize shoeSize = shoeSizeService.createShoeSize(shoeId, form);
       return modelMapper.map(shoeSize, ShoeSizeDTO.class);

    }

    @PatchMapping()
    public ShoeSizeDTO updateShoe(@ModelAttribute ShoeSizeUpdateForm form) {
        ShoeSize entity = shoeSizeService.updateShoeSize(form);

        return  modelMapper.map(entity, ShoeSizeDTO.class);
    }



}

