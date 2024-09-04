package BackEnd.Controller.NewsControllers;

import BackEnd.Entity.NewsEntities.FeedbackImage;
import BackEnd.Form.NewsForms.FeedbackImageForms.FeedbackImageCreateForm;
import BackEnd.Form.NewsForms.FeedbackImageForms.FeedbackImageDTO;
import BackEnd.Form.NewsForms.FeedbackImageForms.FeedbackImageDeleteForm;
import BackEnd.Other.ImageService.ImageService;
import BackEnd.Service.NewsServices.FeedbackImageServices.IFeedbackImageService;
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
@RequestMapping(value = "/FeedbackImage")
@CrossOrigin(origins = "*")
public class FeedbackImageController {

    @Autowired
    private IFeedbackImageService feedbackImageService;

    @Autowired
    private ModelMapper modelMapper;

    @GetMapping(value = "/{path}")
    public ResponseEntity<Resource> getFeedbackImageByPath(@PathVariable String path) {
        try {
            Path imagePath = Paths.get(ImageService.feedbackImagePath, path);
            Resource resource = new UrlResource(imagePath.toUri());

            return ResponseEntity.ok()
                .contentType(MediaType.IMAGE_JPEG)
                .header(HttpHeaders.CONTENT_DISPOSITION, "attachment; filename=\"" + resource.getFilename() + "\"")
                .body(resource);
        } catch (MalformedURLException e) {
            return ResponseEntity.badRequest().build();
        }
    }

    @PostMapping()
    public ResponseEntity<FeedbackImageDTO> createFeedbackImage(@ModelAttribute @Valid FeedbackImageCreateForm form) throws IOException {
        FeedbackImage entity = feedbackImageService.createFeedbackImage(form);
        FeedbackImageDTO dto = modelMapper.map(entity, FeedbackImageDTO.class);
        return ResponseEntity.ok(dto);
    }

    @DeleteMapping()
    public void deleteFeedbackImage(@ModelAttribute @Valid FeedbackImageDeleteForm form) throws IOException {
        feedbackImageService.deleteFeedbackImage(form);
    }
}

