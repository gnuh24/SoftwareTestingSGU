package BackEnd.Controller.NewsControllers;

import BackEnd.Entity.NewsEntities.Feedback;
import BackEnd.Entity.NewsEntities.FeedbackImage;
import BackEnd.Form.NewsForms.FeedbackForms.FeedbackCreateForm;
import BackEnd.Form.NewsForms.FeedbackForms.FeedbackDetailDTO;
import BackEnd.Form.NewsForms.FeedbackForms.FeedbackFilterForm;
import BackEnd.Form.NewsForms.FeedbackForms.FeedbackListDTO;
import BackEnd.Form.NewsForms.FeedbackImageForms.FeedbackImageDTO;
import BackEnd.Service.NewsServices.FeedbackImageServices.FeedbackImageService;
import BackEnd.Service.NewsServices.FeedbackServices.FeedbackService;
import jakarta.validation.Valid;
import org.modelmapper.ModelMapper;
import org.modelmapper.TypeToken;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.data.domain.Page;
import org.springframework.data.domain.PageImpl;
import org.springframework.data.domain.Pageable;
import org.springframework.http.ResponseEntity;
import org.springframework.validation.annotation.Validated;
import org.springframework.web.bind.annotation.*;

import java.io.IOException;
import java.util.List;

@RestController
@RequestMapping("/Feedback")
@CrossOrigin(origins = "*")

public class FeedbackController {

    @Autowired
    private FeedbackService feedbackService;

    @Autowired
    private FeedbackImageService feedbackImageService;

    @Autowired
    private ModelMapper modelMapper;

    @PostMapping
    public void createFeedback(@ModelAttribute @Valid FeedbackCreateForm form) throws IOException {
        feedbackService.createFeedback(form);
    }

    @GetMapping("/{id}")
    public ResponseEntity<FeedbackDetailDTO> getFeedbackById(@PathVariable Integer id) {
        Feedback feedback = feedbackService.getFeedbackById(id);
        if (feedback == null) {
            return ResponseEntity.notFound().build();
        }
        FeedbackDetailDTO dto = modelMapper.map(feedback, FeedbackDetailDTO.class);

        return ResponseEntity.ok(dto);
    }

    @GetMapping
    public ResponseEntity<Page<FeedbackListDTO>> getAllFeedbacks(Pageable pageable,
                                                          FeedbackFilterForm form,
                                                          @RequestParam(required = false) String search) {
        form.setIsDeleted(false);
        Page<Feedback> feedbacks = feedbackService.getAllFeedbacks(pageable, form, search);
        List<FeedbackListDTO> dtos = modelMapper.map(feedbacks.getContent(), new TypeToken<List<FeedbackListDTO>>(){}.getType());
        Page<FeedbackListDTO> dtoPage = new PageImpl<>(dtos, pageable, feedbacks.getTotalElements());
        return ResponseEntity.ok(dtoPage);
    }

    @DeleteMapping("/{id}")
    public ResponseEntity<Void> deleteFeedback(@PathVariable Integer id) {
        feedbackService.deleteFeedback(id);
        return ResponseEntity.noContent().build();
    }
}

