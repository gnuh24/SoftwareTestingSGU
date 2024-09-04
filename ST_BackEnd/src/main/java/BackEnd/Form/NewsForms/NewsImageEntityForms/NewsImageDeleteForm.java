package BackEnd.Form.NewsForms.NewsImageEntityForms;

import jakarta.validation.constraints.NotNull;
import lombok.AllArgsConstructor;
import lombok.Data;
import lombok.NoArgsConstructor;

@Data
@NoArgsConstructor
@AllArgsConstructor
public class NewsImageDeleteForm {

    @NotNull(message = "Không thể thiếu News Image ID")
    private Integer id;

    private String path;

}

