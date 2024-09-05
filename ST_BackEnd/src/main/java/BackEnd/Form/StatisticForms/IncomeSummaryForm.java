package BackEnd.Form.StatisticForms;

import com.fasterxml.jackson.annotation.JsonFormat;

import java.math.BigDecimal;
import java.time.LocalDate;

public interface IncomeSummaryForm {
    BigDecimal getIncome();

    @JsonFormat(pattern = "dd/MM/yyyy")
    LocalDate getUpdateDate();
}