package BackEnd.Form.ProductForm.ShoeSizeForm;

import jakarta.validation.constraints.PositiveOrZero;
import lombok.AllArgsConstructor;
import lombok.Data;
import lombok.NoArgsConstructor;

@Data
@AllArgsConstructor
@NoArgsConstructor
public class ShoeSizeCreateForm {

    @PositiveOrZero(message = "Size giày bắt buộc phải là số nguyên dương !!")
    private Byte size;

    @PositiveOrZero(message = "Giá tiền bắt buộc phải là số nguyên dương !!")
    private Integer price;

}
