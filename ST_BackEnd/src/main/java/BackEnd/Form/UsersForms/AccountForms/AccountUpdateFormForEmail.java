package BackEnd.Form.UsersForms.AccountForms;

import lombok.AllArgsConstructor;
import lombok.Data;
import lombok.NoArgsConstructor;

@Data
@NoArgsConstructor
@AllArgsConstructor
public class AccountUpdateFormForEmail {

    private String newEmail;

    private String token;
}

