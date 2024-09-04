package BackEnd.Form.NewsForms.NewsEntityForms;

import BackEnd.Form.NewsForms.NewsImageEntityForms.NewsImageDTO;
import lombok.AllArgsConstructor;
import lombok.Data;
import lombok.NoArgsConstructor;

import java.time.LocalDateTime;
import java.util.List;

@Data
@NoArgsConstructor
@AllArgsConstructor
public class NewsDetailForUser {
    private Integer id;
    private String banner;
    private String content;
    private String title;
    private LocalDateTime createTime;
    private List<NewsImageDTO> newsImages;
}
