package BackEnd.Form.UsersForms.AccountForms;

import lombok.AllArgsConstructor;
import lombok.Data;
import lombok.NoArgsConstructor;

@Data
@NoArgsConstructor
@AllArgsConstructor
public class AccountUpdateFormForPassword {

    private String oldPassword;

    private String newPassword;

    private String token;

}
