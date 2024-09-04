package BackEnd.Form.ShoppingForms.EventForms;

import BackEnd.Validation.FileContentType;
import BackEnd.Validation.FileSize;
import jakarta.validation.constraints.NotNull;
import lombok.AllArgsConstructor;
import lombok.Data;
import lombok.NoArgsConstructor;
import org.springframework.format.annotation.DateTimeFormat;
import org.springframework.http.MediaType;
import org.springframework.web.multipart.MultipartFile;

import java.time.LocalDateTime;

@Data
@NoArgsConstructor
@AllArgsConstructor

public class EventUpdateForm {
    private Integer eventId;

    @FileSize(max = "5MB")
    @FileContentType(allowed = { MediaType.IMAGE_JPEG_VALUE, MediaType.IMAGE_PNG_VALUE })
    private MultipartFile banner;

    private String eventName;
    private Boolean status;
    private Byte percentage;
}
