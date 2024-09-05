package BackEnd.Form.ShoppingForms.OrderForm;

import com.fasterxml.jackson.annotation.JsonFormat;
import com.fasterxml.jackson.annotation.JsonProperty;
import lombok.AllArgsConstructor;
import lombok.Data;
import lombok.NoArgsConstructor;

import java.time.LocalDateTime;

@Data
@NoArgsConstructor
@AllArgsConstructor
public class OrderDTOListAdmin {

    private String id;

    private Integer totalPrice;

    @JsonFormat(pattern = "HH:mm:ss dd/MM/yyyy")
    private LocalDateTime orderTime;

    @JsonProperty(value = "status")
    private String latestStatus;

    @JsonProperty(value = "fullname")
    private String accountUserInformationFullname;

    @JsonProperty(value = "phoneNumber")
    private String accountUserInformationPhoneNumber;

}
