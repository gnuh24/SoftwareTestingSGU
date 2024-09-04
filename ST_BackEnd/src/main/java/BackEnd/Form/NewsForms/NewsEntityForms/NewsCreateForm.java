package BackEnd.Form.NewsForms.NewsEntityForms;

import BackEnd.Form.NewsForms.NewsImageEntityForms.NewsImageCreateForm;
import BackEnd.Validation.FileContentType;
import BackEnd.Validation.FileSize;
import lombok.AllArgsConstructor;
import lombok.Data;
import jakarta.validation.constraints.NotBlank;
import jakarta.validation.constraints.NotNull;
import lombok.NoArgsConstructor;
import org.springframework.http.MediaType;
import org.springframework.web.multipart.MultipartFile;

import java.util.List;

@Data
@NoArgsConstructor
@AllArgsConstructor
public class NewsCreateForm {

    @NotBlank(message = "Bạn không được để trống tiêu đề !!")
    private String title;

    @NotNull(message = "Bạn không được để trống banner !!")
    @FileSize(max = "5MB")
    @FileContentType(allowed = { MediaType.IMAGE_JPEG_VALUE, MediaType.IMAGE_PNG_VALUE })
    private MultipartFile banner;

    @NotNull(message = "Bạn không được để trống nội dung bài viết !!")
    private String content;

    private Boolean status;

    private List<MultipartFile> newsImageList;

    private Integer authorId;

}
