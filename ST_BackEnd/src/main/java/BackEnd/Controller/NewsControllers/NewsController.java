package BackEnd.Controller.NewsControllers;

import BackEnd.Entity.NewsEntities.News;
import BackEnd.Entity.NewsEntities.NewsImage;
import BackEnd.Form.NewsForms.NewsEntityForms.*;
import BackEnd.Form.NewsForms.NewsImageEntityForms.NewsImageDTO;
import BackEnd.Service.NewsServices.NewsEntityServices.INewsService;
import BackEnd.Service.NewsServices.NewsImageServices.INewsImageService;
import jakarta.validation.Valid;
import org.modelmapper.ModelMapper;
import org.modelmapper.TypeToken;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.data.domain.Page;
import org.springframework.data.domain.PageImpl;
import org.springframework.data.domain.Pageable;
import org.springframework.http.ResponseEntity;
import org.springframework.web.bind.annotation.*;

import java.io.IOException;
import java.util.List;

@RestController
@RequestMapping(value = "/News")
@CrossOrigin(origins = "*")
public class NewsController {

    @Autowired
    private INewsService newsService;

    @Autowired
    private INewsImageService newsImageService;

    @Autowired
    private ModelMapper modelMapper;

    @PostMapping()
    public ResponseEntity<NewsDTO> createNews(@ModelAttribute @Valid NewsCreateForm form) throws IOException {
        News entity = newsService.createNews(form);
        NewsDTO dto = modelMapper.map(entity, NewsDTO.class);
        return ResponseEntity.ok(dto);
    }

    @PatchMapping()
    public ResponseEntity<NewsDTO> updateNews(@ModelAttribute @Valid NewsUpdateForm form) throws IOException {
        News entity = newsService.updateNews(form);
        NewsDTO dto = modelMapper.map(entity, NewsDTO.class);
        return ResponseEntity.ok(dto);
    }


    @GetMapping("/Admin")
    public ResponseEntity<Page<NewsListDTOForAdmin>> getAllNewsByAdmin(Pageable pageable,
                                                           @RequestParam(required = false) String search,
                                                           NewsFilterForm form) {
        Page<News> entities = newsService.getAllNewsByAdmin(pageable, form, search);
        List<NewsListDTOForAdmin> dtos = modelMapper.map(entities.getContent(), new TypeToken<List<NewsListDTOForAdmin>>(){}.getType());
        Page<NewsListDTOForAdmin> dtoPage = new PageImpl<>(dtos, pageable, entities.getTotalElements());
        return ResponseEntity.ok(dtoPage);
    }

    @GetMapping("/User")
    public ResponseEntity<Page<NewsListDTOForUser>> getAllNewsByUser(Pageable pageable) {
        Page<News> entities = newsService.getAllNewsByUser(pageable);
        List<NewsListDTOForUser> dtos = modelMapper.map(entities.getContent(), new TypeToken<List<NewsListDTOForUser>>(){}.getType());
        Page<NewsListDTOForUser> dtoPage = new PageImpl<>(dtos, pageable, entities.getTotalElements());
        return ResponseEntity.ok(dtoPage);
    }

    @GetMapping("/HotNews")
    public ResponseEntity<List<NewsDTO>> getAllHotNews() {
        List<News> entities = newsService.getAllPrioritialNews();
        List<NewsDTO> dtos = modelMapper.map(entities, new TypeToken<List<NewsDTO>>(){}.getType());
        return ResponseEntity.ok(dtos);
    }

    @GetMapping("/Admin/{id}")
    public ResponseEntity<NewsDetailForAdmin> getNewsDetailByAdmin(@PathVariable Integer id) {
        News  entity = newsService.getNewsById(id);
        NewsDetailForAdmin dto = modelMapper.map(entity, NewsDetailForAdmin.class);


        return ResponseEntity.ok(dto);
    }

    @GetMapping("/User/{id}")
    public ResponseEntity<NewsDetailForUser> getNewsDetailByUser(@PathVariable Integer id) {
        News  entity = newsService.getNewsById(id);
        NewsDetailForUser dto = modelMapper.map(entity, NewsDetailForUser.class);
        return ResponseEntity.ok(dto);
    }

}
