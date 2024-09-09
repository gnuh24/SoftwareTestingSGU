package BackEnd.Form.StatisticForms;

import java.math.BigDecimal;

public interface ProductSalesSummary {
    Integer getProductId();
    String getProductName();
    Long getQuantity();
    BigDecimal getTotal();
}

