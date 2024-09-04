package BackEnd.Service.AccountServices.LogoutJWTToken;

import BackEnd.Entity.AccountEntity.LogoutJWTToken;

public interface ILogoutJWTTokenService {

    boolean isThisTokenLogouted(String token);
    void createLogoutJWTToken(String token);
}
