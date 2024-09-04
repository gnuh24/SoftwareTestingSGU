package BackEnd.Service.NewsServices.FeedbackServices;


import BackEnd.Entity.NewsEntities.Feedback;
import BackEnd.Form.NewsForms.FeedbackForms.FeedbackCreateForm;
import BackEnd.Form.NewsForms.FeedbackForms.FeedbackFilterForm;
import BackEnd.Form.NewsForms.FeedbackForms.FeedbackUpdateForm;
import org.springframework.data.domain.Page;
import org.springframework.data.domain.Pageable;

import java.io.IOException;

public interface IFeedbackService {
    Feedback getFeedbackById(Integer id);
    Feedback createFeedback(FeedbackCreateForm form) throws IOException;
    Page<Feedback> getAllFeedbacks(Pageable pageable, FeedbackFilterForm form, String search);
    void deleteFeedback(Integer id);
}
