package BackEnd.Service.NewsServices.FeedbackImageServices;

import BackEnd.Entity.NewsEntities.FeedbackImage;
import BackEnd.Form.NewsForms.FeedbackImageForms.FeedbackImageCreateForm;
import BackEnd.Form.NewsForms.FeedbackImageForms.FeedbackImageDeleteForm;
import org.springframework.web.multipart.MultipartFile;

import java.io.IOException;
import java.util.List;

public interface IFeedbackImageService {

    FeedbackImage getFeedbackImageById(Integer id);
    List<FeedbackImage> getFeedbackImagesByFeedbackId(Integer feedbackId);
    FeedbackImage createFeedbackImage(Integer feedbackId, MultipartFile fileImage) throws IOException;
    FeedbackImage createFeedbackImage(FeedbackImageCreateForm form) throws IOException;
    void deleteFeedbackImage(FeedbackImageDeleteForm form);
}
