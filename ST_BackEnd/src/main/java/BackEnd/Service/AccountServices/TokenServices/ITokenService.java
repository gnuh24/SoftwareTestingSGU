package BackEnd.Service.AccountServices.TokenServices;


import BackEnd.Entity.AccountEntity.Account;
import BackEnd.Entity.AccountEntity.Token;

public interface ITokenService {

    Token getRegistrationTokenById(Integer id);

    Token getRegistrationTokenByAccountIdAndTypeToken_Id(Integer accountId, Byte typeTokenId);

    Token getRegistrationTokenByToken(String token, Byte typeTokenId);

    Token createRegistrationToken(Account account);

    Token createUpdateEmailToken(Account account);

    Token createUpdatePasswordToken(Account account);


    void deleteToken(Integer id);


}

