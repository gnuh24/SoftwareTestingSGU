package BackEnd.Service.AccountServices.AuthService;

import BackEnd.Configure.ErrorResponse.AuthException.InvalidCredentialsException;
import BackEnd.Configure.ErrorResponse.InvalidToken;
import BackEnd.Form.AuthForm.LoginInfoDTO;
import BackEnd.Form.AuthForm.LoginInputForm;
import org.springframework.security.core.AuthenticationException;

public interface IAuthService {
    LoginInfoDTO signInForUser(LoginInputForm signinRequest) throws AuthenticationException;
    LoginInfoDTO signInForAdmin(LoginInputForm signinRequest) throws InvalidCredentialsException;
    LoginInfoDTO refreshToken(String oldToken, String refreshToken) throws InvalidToken;
}
