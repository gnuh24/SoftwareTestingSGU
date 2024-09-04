package BackEnd.Service.NewsServices.FeedbackServices;

import BackEnd.Entity.NewsEntities.Feedback;
import BackEnd.Entity.ShoppingEntities.Order;
import BackEnd.Form.NewsForms.FeedbackForms.FeedbackCreateForm;
import BackEnd.Form.NewsForms.FeedbackForms.FeedbackFilterForm;
import BackEnd.Form.NewsForms.FeedbackForms.FeedbackUpdateForm;
import BackEnd.Repository.NewsRepositories.IFeedbackRepository;
import BackEnd.Service.NewsServices.FeedbackImageServices.IFeedbackImageService;
import BackEnd.Service.ShoppingServices.OrderServices.IOrderService;
import BackEnd.Specification.NewsSpecifications.FeedbackSpecification;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.context.annotation.Lazy;
import org.springframework.data.domain.Page;
import org.springframework.data.domain.Pageable;
import org.springframework.data.jpa.domain.Specification;
import org.springframework.stereotype.Service;
import org.springframework.web.multipart.MultipartFile;

import java.io.IOException;
import java.util.List;

@Service
public class FeedbackService implements IFeedbackService {

    @Autowired
    private IFeedbackRepository feedbackRepository;

    @Autowired
    @Lazy
    private IOrderService orderService;

    @Autowired
    private IFeedbackImageService feedbackImageService;

    @Override
    public Feedback createFeedback(FeedbackCreateForm form) throws IOException {
        Feedback feedback = new Feedback();
        feedback.setTitle(form.getTitle());
        feedback.setContent(form.getContent());

        Order order = orderService.getOrderById(form.getOrderId());
        feedback.setOrder(order);

        feedback = feedbackRepository.save(feedback);
        for (MultipartFile file: form.getMultipartFileList()){
            feedbackImageService.createFeedbackImage(feedback.getId(), file);
        }
        return feedback;
    }


    @Override
    public Feedback getFeedbackById(Integer id) {
        Feedback feedback = feedbackRepository.findById(id).orElse(null);
        feedback.setIsChecked(true);
        return feedbackRepository.save(feedback) ;
    }

    @Override
    public Page<Feedback> getAllFeedbacks(Pageable pageable, FeedbackFilterForm form, String search) {
        Specification<Feedback> where = FeedbackSpecification.buildWhere(search, form);
        return feedbackRepository.findAll(where, pageable);
    }

    @Override
    public void deleteFeedback(Integer id) {
        Feedback feedback = getFeedbackById(id);
        feedback.setIsDeleted(true);
        feedbackRepository.save(feedback);
    }
}
