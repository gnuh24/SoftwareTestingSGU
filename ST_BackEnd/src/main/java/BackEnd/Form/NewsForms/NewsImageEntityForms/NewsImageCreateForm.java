package BackEnd.Form.NewsForms.NewsImageEntityForms;

import jakarta.validation.constraints.NotNull;
import lombok.Data;
import org.springframework.web.multipart.MultipartFile;

@Data
public class NewsImageCreateForm {

    @NotNull(message = "NewsId is required")
    private Integer newsId;

    @NotNull(message = "Bạn không được để trống ảnh !!")
    private MultipartFile imageFile;

}

