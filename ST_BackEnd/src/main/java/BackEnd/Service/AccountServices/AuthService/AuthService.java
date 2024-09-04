package BackEnd.Service.AccountServices.AuthService;

import BackEnd.Configure.ErrorResponse.AuthException.*;
import BackEnd.Configure.ErrorResponse.InvalidToken;
import BackEnd.Entity.AccountEntity.Account;
import BackEnd.Form.AuthForm.LoginInfoDTO;
import BackEnd.Form.AuthForm.LoginInputForm;
import BackEnd.Service.AccountServices.AccountService.IAccountService;
import BackEnd.Service.AccountServices.LogoutJWTToken.LogoutJWTTokenService;
import io.jsonwebtoken.ExpiredJwtException;
import io.jsonwebtoken.security.SignatureException;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.security.authentication.AuthenticationManager;
import org.springframework.security.authentication.UsernamePasswordAuthenticationToken;
import org.springframework.security.core.AuthenticationException;
import org.springframework.security.crypto.password.PasswordEncoder;
import org.springframework.stereotype.Service;

import java.util.HashMap;


@Service
public class AuthService implements IAuthService{

    @Autowired
    private IAccountService accountService;

    @Autowired
    private JWTUtils jwtUtils;

    @Autowired
    private PasswordEncoder passwordEncoder;

    @Autowired
    private AuthenticationManager authenticationManager;

    @Autowired
    private AuthExceptionHandler authExceptionHandler;

    @Autowired
    private LogoutJWTTokenService logoutJWTTokenService;

    @Override
    public LoginInfoDTO signInForUser(LoginInputForm signinRequest) throws InvalidCredentialsException {
        LoginInfoDTO response = new LoginInfoDTO();

            Account user = accountService.getAccountByEmail(signinRequest.getEmail());

            if (user == null) {
                throw new InvalidCredentialsException("Email hoặc mật khẩu không đúng !!");
            }

            if (!user.getType().equals(Account.AccountType.WEB)){
                throw new InvalidCredentialsException("Email hoặc mật khẩu không đúng !!");
            }

            if (user.getRole().toString().equals("Admin")){
                throw new InvalidCredentialsException("Email hoặc mật khẩu không đúng !!");
            }

            if (!passwordEncoder.matches(signinRequest.getPassword(), user.getPassword())) {
                throw new InvalidCredentialsException("Email hoặc mật khẩu không đúng !!");
            }

            if (!user.getActive()){
                throw new AccountBannedException("Tài khoản của bạn chưa được kích hoạt hãy kiểm tra lại email " + signinRequest.getEmail());
            }

            if (!user.getStatus()){
                throw new AccountBannedException("Tài khoản của bạn đã bị khóa !! Nếu có vấn đề xin vui lòng liên hệ Admin");
            }

            //Set các thuộc tính cho kết quả trả về
            response.setStatusCode(200);

            //Tạo Token
            String jwt = jwtUtils.generateToken(user);
            response.setToken(jwt);
            response.setTokenExpirationTime("30 phút");

            //Tạo refresh token
            String refreshToken = jwtUtils.generateRefreshToken(new HashMap<>(), user);
            response.setRefreshToken(refreshToken);
            response.setRefreshTokenExpirationTime("7 ngày");

            response.setMessage("Successfully Signed In");

            response.setStatus(user.getStatus());
            response.setEmail(user.getUsername());
            response.setId(user.getId());
            response.setRole(user.getRole().toString());

        return response;
    }

    @Override
    public LoginInfoDTO signInForAdmin(LoginInputForm signinRequest) throws InvalidCredentialsException {
        LoginInfoDTO response = new LoginInfoDTO();

        Account user = accountService.getAccountByEmail(signinRequest.getEmail());

        if (user == null) {
            throw new InvalidCredentialsException("Email hoặc mật khẩu không đúng !!");
        }

        if (!user.getRole().toString().equals("Admin")){
            throw new InvalidCredentialsException("Email hoặc mật khẩu không đúng !!");
        }

        if (!passwordEncoder.matches(signinRequest.getPassword(), user.getPassword())) {
            throw new InvalidCredentialsException("Email hoặc mật khẩu không đúng !!");
        }


        //Set các thuộc tính cho kết quả trả về
        response.setStatusCode(200);

        //Tạo Token
        String jwt = jwtUtils.generateToken(user);
        response.setToken(jwt);
        response.setTokenExpirationTime("30 phút");

        //Tạo refresh token
        String refreshToken = jwtUtils.generateRefreshToken(new HashMap<>(), user);
        response.setRefreshToken(refreshToken);
        response.setRefreshTokenExpirationTime("7 ngày");

        response.setMessage("Successfully Signed In");

        response.setStatus(user.getStatus());
        response.setEmail(user.getUsername());
        response.setId(user.getId());
        response.setRole(user.getRole().toString());

        return response;
    }

    @Override
    public LoginInfoDTO refreshToken(String oldToken, String refreshToken) throws LoggedOutTokenException, MismatchedTokenAccountException, TokenExpiredException, InvalidJWTSignatureException{
        LoginInfoDTO response = new LoginInfoDTO();

        if(logoutJWTTokenService.isThisTokenLogouted(refreshToken)){
            throw new LoggedOutTokenException("Refresh Token đã bị vô hiệu hóa vì thế không sử dụng được nữa !!");
        }

        //Lấy Email từ Token (Dùng hàm viết tay -> Vì hàm có sẵn sẽ tự kiểm tra thời hạn của Token cũ)
        String ourEmailByOldToken = jwtUtils.extractUsernameWithoutLibrary(oldToken);
        String ourEmail = jwtUtils.extractUsernameWithoutLibrary(refreshToken);

        if (!ourEmail.equals(ourEmailByOldToken)){
            throw new MismatchedTokenAccountException("Access Token và Refresh Token không cùng 1 chủ sở hữu !!");
        }

        //Tìm tài khoản dựa trên Email
        Account account = accountService.getAccountByEmail(ourEmail);
        try{
            if (jwtUtils.isRefreshTokenValid(refreshToken, account)) {
                response.setStatusCode(200);

                //Set Token mới
                var jwt = jwtUtils.generateToken(account);
                response.setToken(jwt);
                response.setTokenExpirationTime("30 phút");

                response.setMessage("Successfully Refreshed Token");
            }
        }
        catch (ExpiredJwtException e1) {
            throw new TokenExpiredException("Refresh Token của bạn đã hết hạn sử dụng !!");
        }
        catch (SignatureException e2){
            throw new InvalidJWTSignatureException("Refresh Token chứa signature không hợp lệ !!");
        }

        return response;
    }
}

