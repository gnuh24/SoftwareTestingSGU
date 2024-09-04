package BackEnd.Configure.ErrorResponse.AuthException;

import org.springframework.security.core.AuthenticationException;

public class AccountBannedException extends AuthenticationException {
    public AccountBannedException(String message) {
        super(message);
    }
}
