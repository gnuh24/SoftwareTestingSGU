package BackEnd.Form.NewsForms.FeedbackForms;

import BackEnd.Form.NewsForms.FeedbackImageForms.FeedbackImageDTO;
import com.fasterxml.jackson.annotation.JsonFormat;
import com.fasterxml.jackson.annotation.JsonProperty;
import jakarta.validation.constraints.NotBlank;
import jakarta.validation.constraints.NotNull;
import lombok.AllArgsConstructor;
import lombok.Data;
import lombok.NoArgsConstructor;
import org.springframework.web.multipart.MultipartFile;

import java.time.LocalDateTime;
import java.util.List;

@Data
@AllArgsConstructor
@NoArgsConstructor
public class FeedbackDetailDTO {
    private Integer id;
    private String title;
    private String content;

    @JsonFormat(pattern = "HH:mm:ss dd/MM/yyyy")
    private LocalDateTime createTime;

    private String orderId;

    @JsonProperty("fullname")
    private String orderUserInformationFullname;

    @JsonProperty("phoneNumber")
    private String orderUserInformationPhoneNumber;

    @JsonProperty("feedbackImageDTOSList")
    private List<FeedbackImageDTO> feedbackImages;
}