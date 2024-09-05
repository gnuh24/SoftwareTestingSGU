package BackEnd.Configure.WebSecurity;
import BackEnd.Configure.ErrorResponse.AuthException.AuthExceptionHandler;
import BackEnd.Configure.ErrorResponse.AuthException.TokenExpiredException;
import BackEnd.Service.AccountServices.AuthService.JWTUtils;
import BackEnd.Service.AccountServices.LogoutJWTToken.ILogoutJWTTokenService;
import jakarta.servlet.FilterChain;
import jakarta.servlet.ServletException;
import jakarta.servlet.http.HttpServletRequest;
import jakarta.servlet.http.HttpServletResponse;
import jakarta.validation.constraints.NotNull;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Component;
import org.springframework.web.filter.OncePerRequestFilter;

import java.io.IOException;

@Component
public class LogoutAuthFilter extends OncePerRequestFilter {

    @Autowired
    private JWTUtils jwtUtils;

    @Autowired
    private ILogoutJWTTokenService logoutJWTTokenService;

    @Autowired
    private AuthExceptionHandler authExceptionHandler;

    @Override
    // TODO: Kiểm tra xem TOKEN có nằm trong "BlackList" (Danh sách các token đã logout) hay chưa
    protected void doFilterInternal(HttpServletRequest request,
                                    @NotNull HttpServletResponse response,
                                    @NotNull FilterChain filterChain) throws ServletException, IOException {
        final String authHeader = request.getHeader("Authorization");
        if (authHeader != null && logoutJWTTokenService.isThisTokenLogouted(authHeader)) {
            authExceptionHandler.commence(request, response, new TokenExpiredException("Access Token này đã bị vô hiệu hóa vì thế không thể dùng được nữa !!") );
        }
        filterChain.doFilter(request, response);
    }
}
