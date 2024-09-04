package BackEnd.Service.NewsServices.NewsImageServices;


import BackEnd.Entity.NewsEntities.News;
import BackEnd.Entity.NewsEntities.NewsImage;
import BackEnd.Form.NewsForms.NewsImageEntityForms.NewsImageCreateForm;
import BackEnd.Form.NewsForms.NewsImageEntityForms.NewsImageDeleteForm;
import org.springframework.web.multipart.MultipartFile;

import java.io.IOException;
import java.util.List;

public interface INewsImageService {

    NewsImage getNewsImageById(Integer id);
    List<NewsImage> getNewsImagesByNewsId(Integer newsId);
    NewsImage createNewsImage(News news, MultipartFile fileImage) throws IOException;
    NewsImage createNewsImage(NewsImageCreateForm form) throws IOException;
    void deleteNewsImage(NewsImageDeleteForm form);

}
