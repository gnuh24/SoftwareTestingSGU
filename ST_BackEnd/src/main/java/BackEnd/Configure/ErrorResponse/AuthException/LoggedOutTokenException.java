package BackEnd.Configure.ErrorResponse.AuthException;

import org.springframework.security.core.AuthenticationException;

// TODO: Lỗi này được dùng cho trường hợp các JWT TOKEN đã bị vô hiệu hóa (Được lưu vào bảng LogoutJWTTOken trong DB)
public class LoggedOutTokenException extends AuthenticationException {
    public LoggedOutTokenException(String msg) {
        super(msg);
    }
}