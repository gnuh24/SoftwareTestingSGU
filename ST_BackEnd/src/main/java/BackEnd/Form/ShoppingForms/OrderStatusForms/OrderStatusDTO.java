package BackEnd.Form.ShoppingForms.OrderStatusForms;

import BackEnd.Entity.ShoppingEntities.OrderStatus;
import com.fasterxml.jackson.annotation.JsonFormat;
import com.fasterxml.jackson.annotation.JsonProperty;
import lombok.*;

import java.time.LocalDateTime;

@Data
@NoArgsConstructor
@AllArgsConstructor
public class OrderStatusDTO {

    @JsonProperty("status")
    private OrderStatus.Status idStatus;

    @JsonFormat(pattern = "hh:mm:ss dd/MM/yyyy")
    private LocalDateTime updateTime;
}
