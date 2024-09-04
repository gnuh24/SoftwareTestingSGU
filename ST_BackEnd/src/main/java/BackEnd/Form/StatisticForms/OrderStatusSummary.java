package BackEnd.Form.StatisticForms;

import com.fasterxml.jackson.annotation.JsonFormat;

import java.time.LocalDate;

public interface OrderStatusSummary {
    String getStatus();
    Long getQuantity();
    @JsonFormat(pattern = "dd/MM/yyyy")
    LocalDate getUpdateDate();
}

