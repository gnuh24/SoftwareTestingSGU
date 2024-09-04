package BackEnd.Form.NewsForms.FeedbackForms;


import lombok.AllArgsConstructor;
import lombok.Data;
import lombok.NoArgsConstructor;
import jakarta.validation.constraints.NotBlank;
import jakarta.validation.constraints.NotNull;

@Data
@NoArgsConstructor
@AllArgsConstructor
public class FeedbackUpdateForm {

    @NotNull(message = "Bạn không thể để trống id của feedback muốn Update !!")
    private Integer id;

    private String title;

    private String content;
}
