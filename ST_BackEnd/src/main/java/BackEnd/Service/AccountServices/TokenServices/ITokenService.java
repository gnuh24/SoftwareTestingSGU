package BackEnd.Service.AccountServices.TokenServices;


import BackEnd.Entity.AccountEntity.Account;
import BackEnd.Entity.AccountEntity.Token;

public interface ITokenService {

    Token getRegistrationTokenById(Integer id);

    Token getRegistrationTokenByAccountIdAndTypeToken_Id(Integer accountId);

    Token getRegistrationTokenByToken(String token);

    Token createRegistrationToken(Account account);

    void deleteToken(Integer id);


}

