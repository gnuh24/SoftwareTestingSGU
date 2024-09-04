package BackEnd.Form.UsersForms.UserInformationForms;

import BackEnd.Entity.AccountEntity.UserInformation;
import jakarta.validation.constraints.*;
import lombok.AllArgsConstructor;
import lombok.Data;
import lombok.NoArgsConstructor;
import org.springframework.format.annotation.DateTimeFormat;

import java.time.LocalDate;


@Data
@NoArgsConstructor
@AllArgsConstructor
public class UserInformationCreateForm {

    @Email(message = "Email should be valid")
    @Size(max = 255, message = "Email cannot exceed 255 characters")
    private String email;

    @Size(max = 255, message = "Address cannot exceed 255 characters")
    private String address;

    @DateTimeFormat(pattern = "dd/MM/yyyy")
    private LocalDate birthday;

    @Size(max = 255, message = "Fullname cannot exceed 255 characters")
    private String fullname;

    private UserInformation.Gender gender;

    @Pattern(regexp = "\\d{10,20}", message = "Phone number must be between 10 and 20 digits")
    private String phoneNumber;


}
