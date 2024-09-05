package BackEnd.Configure.ErrorResponse.AuthException;

import org.springframework.security.core.AuthenticationException;

// TODO: Lỗi này dùng cho trường hợp Token và Refresh token được gửi không cùng 1 tài khoản
public class MismatchedTokenAccountException extends AuthenticationException {
    public MismatchedTokenAccountException(String message) {
        super(message);
    }
}