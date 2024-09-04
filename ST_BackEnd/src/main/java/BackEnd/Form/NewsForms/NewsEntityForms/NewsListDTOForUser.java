package BackEnd.Form.NewsForms.NewsEntityForms;

import com.fasterxml.jackson.annotation.JsonFormat;
import lombok.AllArgsConstructor;
import lombok.Data;
import lombok.NoArgsConstructor;

import java.time.LocalDateTime;

@Data
@NoArgsConstructor
@AllArgsConstructor
public class NewsListDTOForUser {
    private Integer id;
    private String banner;
    private String title;
    @JsonFormat(pattern = "hh:mm:ss dd/MM/yyyy")
    private LocalDateTime createTime;
}
