package BackEnd.Repository.NewsRepositories;

import BackEnd.Entity.NewsEntities.NewsImage;
import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.stereotype.Repository;

import java.util.List;

public interface INewsImageRepository extends JpaRepository<NewsImage, Integer> {
    List<NewsImage> findByNewsId(Integer newsId);

}

