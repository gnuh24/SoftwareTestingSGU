package BackEnd.Form.ShoppingForms.VoucherForms;

import jakarta.validation.constraints.FutureOrPresent;
import jakarta.validation.constraints.Min;
import jakarta.validation.constraints.NotBlank;
import jakarta.validation.constraints.NotNull;
import lombok.AllArgsConstructor;
import lombok.Data;
import lombok.NoArgsConstructor;
import org.springframework.format.annotation.DateTimeFormat;

import java.time.LocalDateTime;

@Data
@NoArgsConstructor
@AllArgsConstructor
public class VoucherCreateForm {

    @NotNull(message = "Status cannot be null")
    private Boolean status;

    private String code;

    @NotBlank(message = "Title cannot be blank")
    private String title;


    @NotNull(message = "Expiration time cannot be null")
    @FutureOrPresent(message = "Expiration time must be in the future or present")
    @DateTimeFormat(pattern = "HH:mm:ss dd/MM/yyyy")
    private LocalDateTime expirationTime;

    @NotNull(message = "Discount amount cannot be null")
    @Min(value = 0, message = "Discount amount must be greater than or equal to 0")
    private Integer discountAmount;

    @NotNull(message = "Condition cannot be null")
    @Min(value = 0, message = "Condition must be greater than or equal to 0")
    private Integer condition;

    @NotNull(message = "isFreeShip cannot be null")
    private Boolean isFreeShip;
}
