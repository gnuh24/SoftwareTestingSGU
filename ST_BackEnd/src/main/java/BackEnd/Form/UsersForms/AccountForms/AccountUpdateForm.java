package BackEnd.Form.UsersForms.AccountForms;

import BackEnd.Entity.AccountEntity.UserInformation;
import jakarta.validation.constraints.Email;
import jakarta.validation.constraints.Pattern;
import jakarta.validation.constraints.Size;
import lombok.Data;
import lombok.NoArgsConstructor;
import org.springframework.format.annotation.DateTimeFormat;

import java.time.LocalDate;

@Data
@NoArgsConstructor
public class AccountUpdateForm {

    private Integer accountId;

//    @Pattern(regexp = "Male|Female|Other", message = "Giới tính phải là 'Male', 'Female', hoặc 'Other' !!")
    private UserInformation.Gender gender;

    @Size(max = 255, message = "Địa chỉ không được dài quá 255 ký tự !!")
    private String address;

    @Size(max = 255, message = "Họ tên không được dài quá 255 ký tự !!")
    private String fullname;

    @Pattern(regexp = "^\\+?[0-9. ()-]{7,25}$", message = "Số điện thoại không hợp lệ !!")
    private String phone;

    @DateTimeFormat(pattern = "dd/MM/yyyy")
    private LocalDate birthday;

}
