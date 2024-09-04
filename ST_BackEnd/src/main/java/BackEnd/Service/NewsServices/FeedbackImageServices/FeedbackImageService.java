package BackEnd.Service.NewsServices.FeedbackImageServices;

import BackEnd.Entity.NewsEntities.Feedback;
import BackEnd.Entity.NewsEntities.FeedbackImage;
import BackEnd.Form.NewsForms.FeedbackImageForms.FeedbackImageCreateForm;
import BackEnd.Form.NewsForms.FeedbackImageForms.FeedbackImageDeleteForm;
import BackEnd.Other.ImageService.ImageService;
import BackEnd.Repository.NewsRepositories.IFeedbackImageRepository;
import BackEnd.Service.NewsServices.FeedbackServices.IFeedbackService;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.context.annotation.Lazy;
import org.springframework.stereotype.Service;
import org.springframework.transaction.annotation.Transactional;
import org.springframework.web.multipart.MultipartFile;

import java.io.IOException;
import java.util.List;

@Service
public class FeedbackImageService implements IFeedbackImageService {

    @Autowired
    private IFeedbackImageRepository feedbackImageRepository;

    @Autowired
    @Lazy
    private IFeedbackService feedbackService;

    @Override
    public FeedbackImage getFeedbackImageById(Integer id) {
        return feedbackImageRepository.findById(id).orElse(null);
    }

    @Override
    public List<FeedbackImage> getFeedbackImagesByFeedbackId(Integer feedbackId) {
        return feedbackImageRepository.findByFeedbackId(feedbackId);
    }

    @Override
    @Transactional
    public FeedbackImage createFeedbackImage(Integer feedbackId, MultipartFile fileImage) throws IOException {
        Feedback feedback = feedbackService.getFeedbackById(feedbackId);
        if (feedback == null) {
            throw new IllegalArgumentException("Invalid feedback ID");
        }
        FeedbackImage feedbackImage = new FeedbackImage();
        feedbackImage.setFeedback(feedback);
        String path = ImageService.saveImage(ImageService.feedbackImagePath, fileImage);
        feedbackImage.setPath(path);

        return feedbackImageRepository.save(feedbackImage);
    }

    @Override
    @Transactional
    public FeedbackImage createFeedbackImage(FeedbackImageCreateForm form) throws IOException {
        Feedback feedback = feedbackService.getFeedbackById(form.getFeedbackId());
        if (feedback == null) {
            throw new IllegalArgumentException("Invalid feedback ID");
        }
        FeedbackImage feedbackImage = new FeedbackImage();
        feedbackImage.setFeedback(feedback);
        String path = ImageService.saveImage(ImageService.feedbackImagePath, form.getImageFile());
        feedbackImage.setPath(path);

        return feedbackImageRepository.save(feedbackImage);
    }

    @Override
    @Transactional
    public void deleteFeedbackImage(FeedbackImageDeleteForm form) {
        FeedbackImage feedbackImage = getFeedbackImageById(form.getId());
        if (feedbackImage != null) {
            ImageService.deleteImage(ImageService.feedbackImagePath, feedbackImage.getPath());
            feedbackImageRepository.delete(feedbackImage);
        }
    }
}

