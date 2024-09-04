package BackEnd.Form.NewsForms.FeedbackForms;

import BackEnd.Form.NewsForms.FeedbackImageForms.FeedbackImageDTO;
import com.fasterxml.jackson.annotation.JsonFormat;
import lombok.AllArgsConstructor;
import lombok.Data;
import lombok.NoArgsConstructor;

import java.time.LocalDateTime;
import java.util.List;

@Data
@NoArgsConstructor
@AllArgsConstructor
public class FeedbackListDTO {

    private Integer id;

    private String title;

    @JsonFormat(pattern = "HH:mm:ss dd/MM/yyyy")
    private LocalDateTime createTime;

    private String orderId;

    private Boolean isChecked;

}
