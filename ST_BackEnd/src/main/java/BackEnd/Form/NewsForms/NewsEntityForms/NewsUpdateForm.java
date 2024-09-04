package BackEnd.Form.NewsForms.NewsEntityForms;

import lombok.AllArgsConstructor;
import lombok.Data;
import jakarta.validation.constraints.NotBlank;
import jakarta.validation.constraints.NotNull;
import lombok.NoArgsConstructor;
import org.springframework.web.multipart.MultipartFile;

@Data
@AllArgsConstructor
@NoArgsConstructor
public class NewsUpdateForm {

    @NotNull(message = "Bạn không thể để trống ID của `News` cần update !!")
    private Integer id;

    private MultipartFile banner;

    private String content;

    private String title;

    private Boolean status;

    private Boolean priorityFlag;
}
