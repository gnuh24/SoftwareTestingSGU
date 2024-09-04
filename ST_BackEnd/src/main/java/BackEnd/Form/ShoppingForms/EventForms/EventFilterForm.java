package BackEnd.Form.ShoppingForms.EventForms;

import lombok.AllArgsConstructor;
import lombok.Data;
import lombok.NoArgsConstructor;

import java.util.Date;


@Data
@NoArgsConstructor
@AllArgsConstructor
public class EventFilterForm {

    private Boolean status;
    private Date eventTime;
    private Byte minPercent;
    private Byte maxPercent;
}
