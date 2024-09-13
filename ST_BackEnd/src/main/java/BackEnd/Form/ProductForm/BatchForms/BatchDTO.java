package BackEnd.Form.ProductForm.BatchForms;

import com.fasterxml.jackson.annotation.JsonFormat;
import lombok.Data;
import lombok.NoArgsConstructor;
import org.springframework.format.annotation.DateTimeFormat;

import java.time.LocalDateTime;

@Data
@NoArgsConstructor
public class BatchDTO {

    private Integer id;

    private Integer price;

    private Integer quantity;

    @JsonFormat(pattern = "HH/mm/ss dd/MM/yyyy")
    private LocalDateTime receivingTime;

}
