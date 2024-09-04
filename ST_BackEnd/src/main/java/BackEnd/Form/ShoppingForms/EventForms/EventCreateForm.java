package BackEnd.Form.ShoppingForms.EventForms;

import BackEnd.Form.ShoppingForms.SaleForms.SaleCreateFormForFirstTime;
import BackEnd.Validation.FileContentType;
import BackEnd.Validation.FileSize;
import jakarta.validation.constraints.FutureOrPresent;
import jakarta.validation.constraints.NotNull;
import lombok.AllArgsConstructor;
import lombok.Data;
import lombok.NoArgsConstructor;
import org.springframework.format.annotation.DateTimeFormat;
import org.springframework.http.MediaType;
import org.springframework.web.multipart.MultipartFile;

import java.time.LocalDateTime;
import java.util.List;

@Data
@NoArgsConstructor
@AllArgsConstructor
public class EventCreateForm {

    private String eventName;

    @FileSize(max = "5MB")
    @FileContentType(allowed = { MediaType.IMAGE_JPEG_VALUE, MediaType.IMAGE_PNG_VALUE })
    @NotNull(message = "Bạn không được bỏ trống logo !!")
    private MultipartFile banner;

    @DateTimeFormat(pattern = "HH:mm:ss dd/MM/yyyy")
    @FutureOrPresent(message = "Ngày bắt đầu sự kiện phải là 1 ngày trong tương lai !!")
    private LocalDateTime startTime;

    @DateTimeFormat(pattern = "HH:mm:ss dd/MM/yyyy")
    @FutureOrPresent(message = "Ngày kết sự kiện phải là 1 ngày trong tương lai !!")
    private LocalDateTime endTime;

    private Byte percentage;

    private List<SaleCreateFormForFirstTime> saleCreateForm;

}

