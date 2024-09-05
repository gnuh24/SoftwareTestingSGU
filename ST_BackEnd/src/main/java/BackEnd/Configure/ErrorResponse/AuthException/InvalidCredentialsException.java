package BackEnd.Configure.ErrorResponse.AuthException;


import org.springframework.security.core.AuthenticationException;


// TODO: Lỗi này dùng khi người dùng đăng nhập thất bại (Sai email hoặc mật khẩu)
public class InvalidCredentialsException extends AuthenticationException {
    public InvalidCredentialsException(String message) {
        super(message);
    }

    public InvalidCredentialsException(String message, Throwable cause) {
        super(message, cause);
    }
}

