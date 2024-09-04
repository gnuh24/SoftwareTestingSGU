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
public class VoucherUpdateForm {

    @NotNull(message = "Voucher ID cannot be null")
    private Integer voucherId;

    private String title;

    private Boolean status;

    @FutureOrPresent(message = "Expiration time must be in the future or present")
    @DateTimeFormat(pattern = "HH:mm:ss dd/MM/yyyy")
    private LocalDateTime expirationTime;

    @Min(value = 0, message = "Discount amount must be greater than or equal to 0")
    private Integer discountAmount;

    @Min(value = 0, message = "Condition must be greater than or equal to 0")
    private Integer condition;

    private Boolean isFreeShip;
}
