package BackEnd.Configure.WebSecurity;
import BackEnd.Configure.ErrorResponse.AuthException.AuthExceptionHandler;
import BackEnd.Configure.ErrorResponse.AuthException.InvalidJWTSignatureException;
import BackEnd.Configure.ErrorResponse.AuthException.TokenExpiredException;
import BackEnd.Service.AccountServices.AccountService.IAccountService;
import BackEnd.Service.AccountServices.AuthService.JWTUtils;
import io.jsonwebtoken.ExpiredJwtException;
import io.jsonwebtoken.security.SignatureException;
import jakarta.servlet.FilterChain;
import jakarta.servlet.ServletException;
import jakarta.servlet.http.HttpServletRequest;
import jakarta.servlet.http.HttpServletResponse;
import jakarta.validation.constraints.NotNull;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.context.annotation.Lazy;
import org.springframework.security.authentication.UsernamePasswordAuthenticationToken;
import org.springframework.security.core.context.SecurityContext;
import org.springframework.security.core.context.SecurityContextHolder;
import org.springframework.security.core.userdetails.UserDetails;
import org.springframework.security.web.authentication.WebAuthenticationDetailsSource;
import org.springframework.stereotype.Component;
import org.springframework.web.filter.OncePerRequestFilter;

import java.io.IOException;

@Component
public class JWTAuthorizationFilter extends OncePerRequestFilter {

    @Autowired
    private JWTUtils jwtUtils;

    @Autowired
    @Lazy
    private IAccountService accountService;

    @Autowired
    private AuthExceptionHandler authExceptionHandler;

    @Override
    //Xác thực Token khi login và call API (Chạy đầu tiên)
    protected void doFilterInternal(HttpServletRequest request,
                                    @NotNull HttpServletResponse response,
                                    @NotNull FilterChain filterChain) throws ServletException, IOException {

        final   String authHeader = request.getHeader("Authorization");
        final   String jwtToken;
        final   String userEmail;


        // Kiểm tra token
        if (authHeader != null && !authHeader.isBlank()) {
            /**
             * authHeader thường là 1 chuỗi thế này
             * VD: "Bearer eyJhbGciOiJIUzI1NiJ9.eyJzdWIiOiJodW5nbnQuMDIwNDA0QGdtYWlsLmNvbSIsImlhdCI6MTcxMjY3Nzk3NSwiZXhwIjoxNzEyNzY0Mzc1fQ.GeODCykd-jW9_TJCocD-j8WcQ6aH6gCIo1OPGEKpwEc"
             *  -> Dùng subString cắt ra để lấy được token
             *  Hàm tách username ra từ chuỗi JWT -> Lấy được email
             */
            jwtToken = authHeader.substring(7);
            userEmail = jwtUtils.extractUsernameWithoutLibrary(jwtToken);

            //Nếu token có thể tách được email ra && SecurityContext chưa chứ thng tin tài khoản nào
            if (userEmail != null && SecurityContextHolder.getContext().getAuthentication() == null) {

                //Lấy ra theo Email
                UserDetails userDetails = accountService.loadUserByUsername(userEmail);

                // Kiểm tra xem token hợp lệ không ?
                try {
                    if (jwtUtils.isAccessTokenValid(jwtToken, userDetails)) {

                        // Tạo SecurityContext và Authen Token
                        SecurityContext securityContext = SecurityContextHolder.createEmptyContext();
                        UsernamePasswordAuthenticationToken token = new UsernamePasswordAuthenticationToken(
                            userDetails, null, userDetails.getAuthorities()
                        );
                        token.setDetails(new WebAuthenticationDetailsSource().buildDetails(request));
                        securityContext.setAuthentication(token);
                        SecurityContextHolder.setContext(securityContext);

                    }
                }
                catch (ExpiredJwtException e1) {
                    authExceptionHandler.commence(request, response, new TokenExpiredException("Access Token của bạn đã hết hạn sử dụng !!"));
                    return;
                }
                catch (SignatureException e2){
                    authExceptionHandler.commence(request, response, new InvalidJWTSignatureException("Access Token chứa signature không hợp lệ !!"));
                    return;
                }
            }
        }

        filterChain.doFilter(request, response);
    }
}
