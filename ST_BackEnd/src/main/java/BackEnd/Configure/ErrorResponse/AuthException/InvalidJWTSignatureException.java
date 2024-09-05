package BackEnd.Configure.ErrorResponse.AuthException;

import org.springframework.security.core.AuthenticationException;


// TODO: Lỗi này dùng cho trường hợp khi người dùng truyền vào 1 Token lạ (Signature không hợp lệ)
public class InvalidJWTSignatureException extends AuthenticationException {

    public InvalidJWTSignatureException(String message) {
        super(message);
    }

}
