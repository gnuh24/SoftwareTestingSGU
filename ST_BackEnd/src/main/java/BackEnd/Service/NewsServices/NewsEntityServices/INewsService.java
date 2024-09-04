package BackEnd.Service.NewsServices.NewsEntityServices;

import BackEnd.Entity.NewsEntities.News;
import BackEnd.Form.NewsForms.NewsEntityForms.NewsCreateForm;
import BackEnd.Form.NewsForms.NewsEntityForms.NewsFilterForm;
import BackEnd.Form.NewsForms.NewsEntityForms.NewsUpdateForm;
import org.springframework.data.domain.Page;
import org.springframework.data.domain.Pageable;

import java.io.IOException;
import java.util.List;

public interface INewsService {

    News getNewsById(Integer newsId);
    List<News> getAllPrioritialNews();
    Page<News> getAllNewsByUser(Pageable pageable);
    Page<News> getAllNewsByAdmin(Pageable pageable, NewsFilterForm form, String search);
    News createNews(NewsCreateForm form) throws IOException;
    News updateNews(NewsUpdateForm form) throws IOException;
}

