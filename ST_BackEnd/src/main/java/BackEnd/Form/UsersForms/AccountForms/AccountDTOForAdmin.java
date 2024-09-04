package BackEnd.Form.UsersForms.AccountForms;


import BackEnd.Entity.AccountEntity.Account;
import com.fasterxml.jackson.annotation.JsonFormat;
import com.fasterxml.jackson.annotation.JsonProperty;
import lombok.AllArgsConstructor;
import lombok.Data;
import lombok.NoArgsConstructor;

import java.time.LocalDateTime;

@Data
@NoArgsConstructor
@AllArgsConstructor
public class AccountDTOForAdmin {

    private Integer id;

    @JsonFormat(pattern = "HH:mm:ss dd/MM/yyyy")
    private LocalDateTime createAt;

    private Boolean status;

    private Account.Role role;

    private Account.AccountType type;

    @JsonProperty("email")
    private String userInformationEmail;

}
