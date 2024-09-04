package BackEnd.Form.AuthForm;


import jakarta.validation.constraints.Email;
import jakarta.validation.constraints.NotBlank;
import jakarta.validation.constraints.Size;
import lombok.Data;
import lombok.NoArgsConstructor;

@Data
@NoArgsConstructor
public class LoginInputForm {

    @NotBlank(message = "Email không được để trống !!")
    @Email(message = "Email phải đúng định dạng !!")
    private String email;

    @NotBlank(message = "Bạn không thể để trống password")
    private String password;
}

