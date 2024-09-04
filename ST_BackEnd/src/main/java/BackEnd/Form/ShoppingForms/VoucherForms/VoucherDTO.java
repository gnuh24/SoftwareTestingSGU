package BackEnd.Form.ShoppingForms.VoucherForms;

import com.fasterxml.jackson.annotation.JsonFormat;
import lombok.AllArgsConstructor;
import lombok.Data;
import lombok.NoArgsConstructor;

import java.time.LocalDateTime;

@Data
@AllArgsConstructor
@NoArgsConstructor
public class VoucherDTO {
    private Integer voucherId;
    private String title;
    private Boolean status;
    private String code;

    @JsonFormat(pattern = "HH:mm:ss dd/MM/yyyy")
    private LocalDateTime expirationTime;

    private Integer discountAmount;
    private Integer condition;
    private Boolean isFreeShip;
}

