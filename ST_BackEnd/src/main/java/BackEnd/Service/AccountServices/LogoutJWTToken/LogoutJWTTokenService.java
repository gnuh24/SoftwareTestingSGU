package BackEnd.Service.AccountServices.LogoutJWTToken;

import BackEnd.Entity.AccountEntity.LogoutJWTToken;
import BackEnd.Repository.AccountRepository.ILogoutJWTTokenRepository;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;

@Service
public class LogoutJWTTokenService implements ILogoutJWTTokenService {

    @Autowired
    private ILogoutJWTTokenRepository logoutJWTTokenRepository;

    @Override
    public boolean isThisTokenLogouted(String token) {
        return logoutJWTTokenRepository.findByToken(token) == null? false: true;
    }

    public void createLogoutJWTToken(String token) {
        LogoutJWTToken logoutJWTToken = new LogoutJWTToken();
        logoutJWTToken.setToken(token);
        logoutJWTTokenRepository.save(logoutJWTToken);
    }
}
