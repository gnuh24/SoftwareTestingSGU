package BackEnd.Controller.ProductController;

import BackEnd.Entity.ProductEntity.Color;
import BackEnd.Form.ProductForm.ColorForm.ColorCreateForm;
import BackEnd.Form.ProductForm.ColorForm.ColorDTO;
import BackEnd.Form.ProductForm.ColorForm.ColorUpdateForm;
import BackEnd.Service.ProductService.ColorServices.IColorService;
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
@RequestMapping(value = "/Color")
@CrossOrigin(origins = "*")
public class ColorController {

    @Autowired
    private IColorService shoeColorService;

    @Autowired
    private ModelMapper modelMapper;

    @GetMapping(value = "/noPaging")
    public List<ColorDTO> getAllColorNoPaging() {
        List<Color> list = shoeColorService.getAllShoeColorNoPaging();
        return modelMapper.map(list, new TypeToken<List<ColorDTO>>() {}.getType());
    }

    @GetMapping()
    public Page<ColorDTO> getAllColor(Pageable pageable,
                                          @RequestParam(name = "search", required = false) String search) {
        Page<Color> entities = shoeColorService.getAllShoeColor(pageable, search);
        List<ColorDTO> dtos = modelMapper.map(entities.getContent(), new TypeToken<List<ColorDTO>>() {}.getType());
        return new PageImpl<>(dtos, pageable, entities.getTotalElements());
    }

    @GetMapping(value = "/{colorId}")
    public ColorDTO getColorById(@PathVariable Integer colorId) {
        Color entity = shoeColorService.getShoeColorById(colorId);
        return modelMapper.map(entity, ColorDTO.class);
    }

    @PostMapping()
    public ColorDTO createShoeColor(@ModelAttribute @Valid ColorCreateForm form) {
        Color entity = shoeColorService.createShoeColor(form);
        return modelMapper.map(entity, ColorDTO.class);
    }

    @PatchMapping()
    public ColorDTO updateShoeColor(@ModelAttribute @Valid ColorUpdateForm form) {
        Color entity = shoeColorService.updateShoeColor(form);
        return modelMapper.map(entity, ColorDTO.class);
    }

    @DeleteMapping(value = "/{colorId}")
    public void deleteShoeColor(@PathVariable Integer colorId) {
        shoeColorService.deleteShoeColor(colorId);
    }
}
