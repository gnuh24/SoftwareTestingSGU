package BackEnd.Form.NewsForms.NewsEntityForms;

import lombok.AllArgsConstructor;
import lombok.Data;
import lombok.NoArgsConstructor;
import org.springframework.format.annotation.DateTimeFormat;

import java.util.Date;

@Data
@NoArgsConstructor
@AllArgsConstructor
public class NewsFilterForm {

    @DateTimeFormat(pattern = "dd/MM/yyyy")
    private Date from;
    private Date to;
    private Boolean status;
    private Boolean priorityFlag;
}

