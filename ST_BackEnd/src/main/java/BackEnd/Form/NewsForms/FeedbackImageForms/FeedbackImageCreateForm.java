package BackEnd.Form.NewsForms.FeedbackImageForms;


import jakarta.validation.constraints.NotNull;
import lombok.*;
import org.springframework.web.multipart.MultipartFile;

@Data
@NoArgsConstructor
@AllArgsConstructor
public class FeedbackImageCreateForm {

    @NotNull
    private Integer feedbackId;

    @NotNull
    private MultipartFile imageFile;
}
