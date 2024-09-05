package BackEnd.Configure.WebSecurity;

import java.io.IOException;
import java.util.Map;
import java.util.UUID;

import BackEnd.Entity.AccountEntity.Account;
import BackEnd.Service.AccountServices.AccountService.IAccountService;
import org.slf4j.Logger;
import org.slf4j.LoggerFactory;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.context.annotation.Lazy;
import org.springframework.security.authentication.UsernamePasswordAuthenticationToken;
import org.springframework.security.core.Authentication;
import org.springframework.security.core.context.SecurityContextHolder;
import org.springframework.security.oauth2.client.authentication.OAuth2AuthenticationToken;
import org.springframework.security.oauth2.core.user.DefaultOAuth2User;
import org.springframework.security.web.DefaultRedirectStrategy;
import org.springframework.security.web.authentication.AuthenticationSuccessHandler;
import org.springframework.stereotype.Component;
import java.util.List;

import jakarta.servlet.ServletException;
import jakarta.servlet.http.HttpServletRequest;
import jakarta.servlet.http.HttpServletResponse;

@Component
public class OAuthAuthenicationSuccessHandler implements AuthenticationSuccessHandler {

//    Logger logger = LoggerFactory.getLogger(OAuthAuthenicationSuccessHandler.class);

    @Autowired
    @Lazy
    private IAccountService accountService;

    @Override
    public void onAuthenticationSuccess(HttpServletRequest request,
                                        HttpServletResponse response,
                                        Authentication authentication) throws IOException {

        OAuth2AuthenticationToken oauth2AuthenticationToken = (OAuth2AuthenticationToken) authentication;
        Map<String, Object> attributes = oauth2AuthenticationToken.getPrincipal().getAttributes();

        // Identify the provider
        String authorizedClientRegistrationId = oauth2AuthenticationToken.getAuthorizedClientRegistrationId();

        Account account = null;

        if (authorizedClientRegistrationId.equalsIgnoreCase("google")) {
            account = accountService.registerOrAuthenticateUser((String) attributes.get("email"));
        }

        if (authorizedClientRegistrationId.equalsIgnoreCase("facebook")) {
            account = accountService.registerOrAuthenticateUser((String) attributes.get("email"));
        }

        // Lưu thông tin tài khoản vào session
        request.getSession().setAttribute("account", account);

        // Redirect to /home
        new DefaultRedirectStrategy().sendRedirect(request, response, "/Auth/Google");
    }


}