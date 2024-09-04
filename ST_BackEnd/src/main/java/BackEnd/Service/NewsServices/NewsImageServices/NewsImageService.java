package BackEnd.Service.NewsServices.NewsImageServices;

import BackEnd.Entity.NewsEntities.News;
import BackEnd.Entity.NewsEntities.NewsImage;
import BackEnd.Form.NewsForms.NewsImageEntityForms.NewsImageCreateForm;
import BackEnd.Form.NewsForms.NewsImageEntityForms.NewsImageDeleteForm;
import BackEnd.Other.ImageService.ImageService;
import BackEnd.Repository.NewsRepositories.INewsImageRepository;
import BackEnd.Service.NewsServices.NewsEntityServices.INewsService;
import org.modelmapper.ModelMapper;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.context.annotation.Lazy;
import org.springframework.stereotype.Service;
import org.springframework.transaction.annotation.Transactional;
import org.springframework.web.multipart.MultipartFile;

import java.io.IOException;
import java.util.List;

@Service
public class NewsImageService implements INewsImageService {

    @Autowired
    private INewsImageRepository newsImageRepository;

    @Autowired
    @Lazy
    private INewsService newsService;

    @Autowired
    private ModelMapper modelMapper;


    @Override
    public NewsImage getNewsImageById(Integer id) {
        return newsImageRepository.findById(id).orElse(null);
    }

    @Override
    public List<NewsImage> getNewsImagesByNewsId(Integer newsId) {
        return newsImageRepository.findByNewsId(newsId);
    }

    @Override
    @Transactional
    public NewsImage createNewsImage(News news, MultipartFile fileImage) throws IOException {;

        NewsImage newsImage = new NewsImage();
        newsImage.setNews(news);
        String path = ImageService.saveImage(ImageService.newsImagePath, fileImage);
        newsImage.setPath(path);

        return newsImageRepository.save(newsImage);
    }

    @Override
    @Transactional
    public NewsImage createNewsImage(NewsImageCreateForm form) throws IOException {
        News news = newsService.getNewsById(form.getNewsId());
        NewsImage newsImage = new NewsImage();
        newsImage.setNews(news);

        String path = ImageService.saveImage(ImageService.newsImagePath, form.getImageFile());
        newsImage.setPath(path);

        return newsImageRepository.save(newsImage);
    }

    @Override
    @Transactional
    public void deleteNewsImage(NewsImageDeleteForm form) {
        NewsImage newsImage = getNewsImageById(form.getId());
        ImageService.deleteImage(ImageService.newsImagePath, form.getPath());
        newsImageRepository.delete(newsImage);

    }


}

