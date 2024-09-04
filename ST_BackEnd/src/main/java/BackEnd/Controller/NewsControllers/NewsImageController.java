package BackEnd.Controller.NewsControllers;

import BackEnd.Entity.NewsEntities.News;
import BackEnd.Entity.NewsEntities.NewsImage;
import BackEnd.Form.NewsForms.NewsEntityForms.NewsCreateForm;
import BackEnd.Form.NewsForms.NewsEntityForms.NewsDTO;
import BackEnd.Form.NewsForms.NewsEntityForms.NewsUpdateForm;
import BackEnd.Form.NewsForms.NewsImageEntityForms.NewsImageCreateForm;
import BackEnd.Form.NewsForms.NewsImageEntityForms.NewsImageDTO;
import BackEnd.Form.NewsForms.NewsImageEntityForms.NewsImageDeleteForm;
import BackEnd.Other.ImageService.ImageService;
import BackEnd.Service.NewsServices.NewsImageServices.INewsImageService;
import jakarta.validation.Valid;
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
@RequestMapping(value = "/NewsImage")
@CrossOrigin(origins = "*")
public class NewsImageController {

    @Autowired
    private INewsImageService newsImageService;

    @Autowired
    private ModelMapper modelMapper;

    @GetMapping(value = "/{path}")
    public ResponseEntity<Resource> getNewsImageByPath(@PathVariable String path) {
        try{
            Path imagePath = Paths.get(ImageService.newsImagePath, path);
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

    @PostMapping()
    public ResponseEntity<NewsImageDTO> createNewsImage(@ModelAttribute @Valid NewsImageCreateForm form) throws IOException {
        NewsImage entity = newsImageService.createNewsImage(form);
        NewsImageDTO dto = modelMapper.map(entity, NewsImageDTO.class);
        return ResponseEntity.ok(dto);
    }

    @DeleteMapping()
    public void updateNews(@ModelAttribute @Valid NewsImageDeleteForm form) throws IOException {
       newsImageService.deleteNewsImage(form);
    }
}
