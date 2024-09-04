package BackEnd.Repository.NewsRepositories;

import BackEnd.Entity.NewsEntities.FeedbackImage;
import org.springframework.data.jpa.repository.JpaRepository;

import java.util.List;

public interface IFeedbackImageRepository extends JpaRepository<FeedbackImage, Integer> {
    List<FeedbackImage> findByFeedbackId(Integer feedbackId);
}
