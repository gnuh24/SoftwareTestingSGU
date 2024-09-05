package BackEnd.Service.AccountServices.AccountService;

import BackEnd.Configure.ErrorResponse.InvalidOldPassword;
import BackEnd.Configure.ErrorResponse.InvalidToken;
import BackEnd.Configure.ErrorResponse.TheValueAlreadyExists;
import BackEnd.Configure.ErrorResponse.TokenNotExists;
import BackEnd.Entity.AccountEntity.Account;
import BackEnd.Form.UsersForms.AccountForms.*;
import org.springframework.data.domain.Page;
import org.springframework.data.domain.Pageable;
import org.springframework.security.core.userdetails.UserDetailsService;

import java.util.Map;

public interface IAccountService extends UserDetailsService {

    int activateUser(String token);

    String getKeyForUpdateEmail(String token, String newEmail);

    String getKeyForUpdatePassword(String token);

    Page<Account> getAllAccounts(Pageable pageable, String search, AccountFilterForm form);

    Account getAccountById(Integer accountId);

    Account getAccountById(Integer accountId, String token);

    Account getAccountByEmail(String email);

    Account createAccount(AccountCreateForm form) throws TheValueAlreadyExists;

    Account createAccountByEmail(AccountCreateForm form);

    Account  updateEmailOfAccount(String token, AccountUpdateFormForEmail form) throws InvalidToken, TokenNotExists;

    Account updateAccount(String token, AccountUpdateForm form);

    Account updateStatusOfAccount(AccountUpdateFormForStatus form);

    void deleteByAccountId(Integer accountId);

    int updatePasswordOfAccount(String token, AccountUpdateFormForPassword form) throws InvalidToken, InvalidOldPassword, TokenNotExists;

    Account registerOrAuthenticateUser(String email);
}
