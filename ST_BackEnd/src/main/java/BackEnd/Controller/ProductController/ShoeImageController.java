package BackEnd.Controller.ProductController;


import BackEnd.Entity.ProductEntity.ShoeImage;
import BackEnd.Form.ProductForm.ShoeImageForm.ShoeImageCreateForm;
import BackEnd.Form.ProductForm.ShoeImageForm.ShoeImageDTO;
import BackEnd.Form.ProductForm.ShoeImageForm.ShoeImageUpdateForm;
import BackEnd.Other.ImageService.ImageService;
import BackEnd.Service.ProductService.ShoeImage.IShoeImageService;
import org.modelmapper.ModelMapper;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.core.io.Resource;
import org.springframework.core.io.UrlResource;
import org.springframework.http.HttpHeaders;
import org.springframework.http.MediaType;
import org.springframework.http.ResponseEntity;
import org.springframework.web.bind.annotation.*;

import java.io.IOException;
import java.net.MalformedURLException;
import java.nio.file.Path;
import java.nio.file.Paths;

@RestController
@RequestMapping(value = "/ShoeImage")
@CrossOrigin(origins = "*")
public class ShoeImageController {
    @Autowired
    private IShoeImageService shoeImageService;

    @Autowired
    private ModelMapper modelMapper;

    @GetMapping(value = "/Image/{path}")
    public ResponseEntity<Resource> getBrandLogoByName(@PathVariable String path) {
        try{
            Path imagePath = Paths.get(ImageService.shoeImagePath, path);
            Resource resource = new UrlResource(imagePath.toUri());

            return ResponseEntity.ok()
                .contentType(MediaType.IMAGE_JPEG)
                .header(HttpHeaders.CONTENT_DISPOSITION, "attachment; filename=\"" + resource.getFilename() + "\"")
                .body(resource);
        }

        catch (MalformedURLException e) {
            return ResponseEntity.badRequest().build();
        }
    }

    @PostMapping(value = "/{shoeId}")
    public ShoeImageDTO createShoeImage(@PathVariable  Integer shoeId,
                                        @ModelAttribute ShoeImageCreateForm form) throws IOException {
        ShoeImage entity = shoeImageService.createShoeImage(shoeId, form);
        return modelMapper.map(entity, ShoeImageDTO.class);
    }

    @PatchMapping(value = "/{shoeImageId}")
    public ShoeImageDTO updateShoeImage(@PathVariable  Integer shoeImageId,
                                        @ModelAttribute ShoeImageUpdateForm form) throws IOException {
        ShoeImage entity = shoeImageService.updateShoeImage(shoeImageId, form);
        return modelMapper.map(entity, ShoeImageDTO.class);
    }
}
