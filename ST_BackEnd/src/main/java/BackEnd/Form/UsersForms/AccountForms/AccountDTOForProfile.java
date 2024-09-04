package BackEnd.Form.UsersForms.AccountForms;

import com.fasterxml.jackson.annotation.JsonFormat;
import com.fasterxml.jackson.annotation.JsonProperty;
import lombok.AllArgsConstructor;
import lombok.Data;
import lombok.NoArgsConstructor;

import java.time.LocalDate;

@Data
@NoArgsConstructor
@AllArgsConstructor
public class AccountDTOForProfile {

    private Integer accountId;

    @JsonProperty(value = "email")
    private String userInformationEmail;

    @JsonProperty(value = "gender")
    private String userInformationGender;

    @JsonProperty(value = "address")
    private String userInformationAddress;

    @JsonProperty(value = "fullname")
    private String userInformationFullname;

    @JsonFormat(pattern = "dd/MM/yyyy")
    @JsonProperty(value = "birthday")
    private LocalDate userInformationBirthday;

    @JsonProperty(value = "phoneNumber")
    private String userInformationPhoneNumber;

    private String newToken;

    private String newRefreshToken;

}
