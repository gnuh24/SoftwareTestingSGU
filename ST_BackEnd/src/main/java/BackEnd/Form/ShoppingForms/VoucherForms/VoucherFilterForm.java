package BackEnd.Form.ShoppingForms.VoucherForms;


import lombok.AllArgsConstructor;
import lombok.Data;
import lombok.NoArgsConstructor;
import org.springframework.format.annotation.DateTimeFormat;

import java.time.LocalDateTime;
import java.util.Date;

@Data
@NoArgsConstructor
@AllArgsConstructor
public class VoucherFilterForm {

    private Boolean status;


    @DateTimeFormat(pattern = "dd/MM/yyyy")
    private Date from;

    @DateTimeFormat(pattern = "dd/MM/yyyy")
    private Date to;

    private Integer minCondition;
    private Integer maxCondition;

    private Boolean isFreeShip;

    private Integer minDiscountAmount;

    private Integer maxDiscountAmount;

}

