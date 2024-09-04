package BackEnd.Configure.WebSecurity;

import BackEnd.Configure.ErrorResponse.AuthException.AuthExceptionHandler;
import BackEnd.Configure.ErrorResponse.TheValueAlreadyExists;
import BackEnd.Entity.AccountEntity.Account;
import BackEnd.Service.AccountServices.AccountService.IAccountService;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.context.annotation.Bean;
import org.springframework.context.annotation.Configuration;
import org.springframework.context.annotation.Lazy;
import org.springframework.http.HttpMethod;
import org.springframework.security.authentication.AuthenticationManager;
import org.springframework.security.authentication.AuthenticationProvider;
import org.springframework.security.authentication.UsernamePasswordAuthenticationToken;
import org.springframework.security.authentication.dao.DaoAuthenticationProvider;
import org.springframework.security.config.Customizer;
import org.springframework.security.config.annotation.authentication.configuration.AuthenticationConfiguration;
import org.springframework.security.config.annotation.web.builders.HttpSecurity;
import org.springframework.security.config.annotation.web.configuration.EnableWebSecurity;

import org.springframework.security.config.annotation.web.configurers.AbstractHttpConfigurer;

import org.springframework.security.config.http.SessionCreationPolicy;
import org.springframework.security.core.context.SecurityContextHolder;
import org.springframework.security.crypto.bcrypt.BCryptPasswordEncoder;
import org.springframework.security.crypto.password.PasswordEncoder;
import org.springframework.security.oauth2.client.oidc.userinfo.OidcUserRequest;
import org.springframework.security.oauth2.client.oidc.userinfo.OidcUserService;
import org.springframework.security.oauth2.core.OAuth2AuthenticationException;
import org.springframework.security.oauth2.core.oidc.user.DefaultOidcUser;
import org.springframework.security.oauth2.core.oidc.user.OidcUser;
import org.springframework.security.oauth2.core.user.DefaultOAuth2User;
import org.springframework.security.oauth2.core.user.OAuth2User;
import org.springframework.security.web.SecurityFilterChain;
import org.springframework.security.web.authentication.UsernamePasswordAuthenticationFilter;
import org.springframework.web.cors.CorsConfigurationSource;

@Configuration
@EnableWebSecurity
public class WebSecutiryConfiguration {

    @Autowired
    @Lazy
    private IAccountService accountService;

    @Autowired
    @Lazy
    private AuthExceptionHandler authExceptionHandler;

    @Autowired
    private JWTAuthorizationFilter jwtAuthFIlter;

    @Autowired
    private LogoutAuthFilter logoutAuthFilter;

    @Autowired
    private OAuthAuthenicationSuccessHandler handler;

    @Bean
    public SecurityFilterChain filterChain(HttpSecurity http,
            CorsConfigurationSource corsConfigurationSource) throws Exception {

        http
                // Loại bỏ bảo vệ CSRF
                .csrf(AbstractHttpConfigurer::disable)

                // Configure các luồng truy cập
                .authorizeHttpRequests((auth) -> auth

                        // TODO: CÁC API LIÊN QUAN ĐẾN PRODUCT
                        // Các API `Brand`
                        .requestMatchers(HttpMethod.GET, "/Brand/noPaging").permitAll()
                        .requestMatchers(HttpMethod.GET, "/Brand").permitAll()
                        .requestMatchers(HttpMethod.GET, "/Brand/{brandId}").permitAll()
                        .requestMatchers(HttpMethod.GET, "/Brand/Image/{logo}").permitAll()
                        .requestMatchers(HttpMethod.POST, "/Brand").hasAnyAuthority("Admin")
                        .requestMatchers(HttpMethod.PATCH, "/Brand").hasAnyAuthority("Admin")
                        .requestMatchers(HttpMethod.DELETE, "/Brand/{brandId}").hasAnyAuthority("Admin")

                        // Các API `ShoeType`
                        .requestMatchers(HttpMethod.GET, "/ShoeType/noPaging").permitAll()
                        .requestMatchers(HttpMethod.GET, "/ShoeType").permitAll()
                        .requestMatchers(HttpMethod.GET, "/ShoeType/{shoeTypeId}").permitAll()
                        .requestMatchers(HttpMethod.POST, "/ShoeType").hasAnyAuthority("Admin")
                        .requestMatchers(HttpMethod.PATCH, "/ShoeType").hasAnyAuthority("Admin")
                        .requestMatchers(HttpMethod.DELETE, "/ShoeType/{shoeTypeId}").hasAnyAuthority("Admin")

                        // Các API `Color`
                        .requestMatchers(HttpMethod.GET, "/Color/noPaging").permitAll()
                        .requestMatchers(HttpMethod.GET, "/Color").permitAll()
                        .requestMatchers(HttpMethod.GET, "/Color/{colorId}").permitAll()
                        .requestMatchers(HttpMethod.POST, "/Color").hasAnyAuthority("Admin")
                        .requestMatchers(HttpMethod.PATCH, "/Color").hasAnyAuthority("Admin")
                        .requestMatchers(HttpMethod.DELETE, "/Color/{colorId}").hasAnyAuthority("Admin")
                        // Các API `ShoeColor`
                        .requestMatchers(HttpMethod.POST, "/ShoeColor").hasAnyAuthority("Admin")
                        .requestMatchers(HttpMethod.DELETE, "/ShoeColor").hasAnyAuthority("Admin")

                        // Các API `Shoe`
                        .requestMatchers(HttpMethod.GET, "/Shoe/Admin").hasAnyAuthority("Admin")
                        .requestMatchers(HttpMethod.GET, "/Shoe/Admin/{shoeId}").hasAnyAuthority("Admin")
                        .requestMatchers(HttpMethod.GET, "/Shoe/Inventory").hasAnyAuthority("Admin")
                        .requestMatchers(HttpMethod.GET, "/Shoe/Event").permitAll()
                        .requestMatchers(HttpMethod.GET, "/Shoe/Event/{eventId}").hasAnyAuthority("Admin")
                        .requestMatchers(HttpMethod.GET, "/Shoe/CommonUser").permitAll()
                        .requestMatchers(HttpMethod.GET, "/Shoe/CommonUser/{shoeId}").permitAll()
                        .requestMatchers(HttpMethod.POST, "/Shoe").hasAnyAuthority("Admin")
                        .requestMatchers(HttpMethod.PATCH, "/Shoe").hasAnyAuthority("Admin")
                        .requestMatchers(HttpMethod.PATCH, "/Shoe/UpdateBrand").hasAnyAuthority("Admin")
                        .requestMatchers(HttpMethod.PATCH, "/Shoe/UpdateShoeType").hasAnyAuthority("Admin")

                        // Các API `ShoeSize`
                    .requestMatchers(HttpMethod.GET, "/ShoeSize/{shoeId}").hasAnyAuthority("Admin")

                    .requestMatchers(HttpMethod.POST, "/ShoeSize/{shoeId}").hasAnyAuthority("Admin")
                        .requestMatchers(HttpMethod.PATCH, "/ShoeSize").hasAnyAuthority("Admin")

                        // Các API `ShoeImage`
                        .requestMatchers(HttpMethod.GET, "/ShoeImage/Image/{path}").permitAll()
                        .requestMatchers(HttpMethod.POST, "/ShoeImage/{shoeId}").hasAnyAuthority("Admin")
                        .requestMatchers(HttpMethod.PATCH, "/ShoeImage/{shoeImageId}").hasAnyAuthority("Admin")

                        // TODO: Các API liên quan đến `Account`

                        .requestMatchers(HttpMethod.POST, "/Auth/Logout").hasAnyAuthority("User", "Admin")
                        .requestMatchers(HttpMethod.POST, "/Auth/SignIn").permitAll()
                        .requestMatchers(HttpMethod.POST, "/Auth/LoginAdmin").permitAll()
                        .requestMatchers(HttpMethod.POST, "/Auth/Registration").permitAll()
                        .requestMatchers(HttpMethod.POST, "/Auth/Refresh").permitAll()
                        .requestMatchers(HttpMethod.GET, "/Auth/ActiveUser").permitAll()
                        .requestMatchers(HttpMethod.GET, "/Auth/Google").permitAll()
                        .requestMatchers(HttpMethod.GET, "/Auth/Facebook").permitAll()

                        .requestMatchers("/oauth2/authorization/**").permitAll()
                        .requestMatchers("/login/oauth2/code/google").permitAll()

                        .requestMatchers(HttpMethod.GET, "/Account/isThisEmailExists").permitAll()
                        .requestMatchers(HttpMethod.GET, "/Account").hasAnyAuthority("Admin")
                        .requestMatchers(HttpMethod.GET, "/Account/{accountId}").hasAnyAuthority("User", "Admin")
                        .requestMatchers(HttpMethod.GET, "/Account/GetKeyForUpdateEmail")
                        .hasAnyAuthority("User", "Admin")
                        .requestMatchers(HttpMethod.PATCH, "/Account/UpdateInformation")
                        .hasAnyAuthority("User", "Admin")
                        .requestMatchers(HttpMethod.PATCH, "/Account/ChangeStatus").hasAnyAuthority("Admin")
                        .requestMatchers(HttpMethod.PATCH, "/Account/NewEmail").hasAnyAuthority("User", "Admin")
                        .requestMatchers(HttpMethod.GET, "/Account/GetKeyForUpdatePassword")
                        .hasAnyAuthority("User", "Admin")
                        .requestMatchers(HttpMethod.PATCH, "/Account/NewPassword").hasAnyAuthority("User", "Admin")

                        .requestMatchers(HttpMethod.POST, "/UserInformation").hasAnyAuthority("Admin")
                        .requestMatchers(HttpMethod.PATCH, "/UserInformation").hasAnyAuthority("Admin")

                        // TODO: Các API liên quan đến chức năng mua hàng

                        // Các API Giỏ hàng
                        .requestMatchers(HttpMethod.GET, "/CartItem/{accountId}").hasAnyAuthority("User", "Admin")
                        .requestMatchers(HttpMethod.POST, "/CartItem").hasAnyAuthority("User", "Admin")
                        .requestMatchers(HttpMethod.PATCH, "/CartItem").hasAnyAuthority("User", "Admin")
                        .requestMatchers(HttpMethod.DELETE, "/CartItem").hasAnyAuthority("User", "Admin")
                    .requestMatchers(HttpMethod.DELETE, "/CartItem/{accountId}").hasAnyAuthority("User", "Admin")

                        // Các API Đơn hàng
                        .requestMatchers(HttpMethod.GET, "/Order/Admin").hasAnyAuthority("Admin")
                        .requestMatchers(HttpMethod.GET, "/Order/Admin/{id}").hasAnyAuthority("Admin")
                        .requestMatchers(HttpMethod.GET, "/Order/MyOrder").hasAnyAuthority("User", "Admin")
                        .requestMatchers(HttpMethod.GET, "/Order/MyOrder/{id}").hasAnyAuthority("User", "Admin")

                        .requestMatchers(HttpMethod.POST, "/Order/Admin").hasAnyAuthority("Admin")
                        .requestMatchers(HttpMethod.POST, "/Order/User").hasAnyAuthority("User")

                        .requestMatchers(HttpMethod.PATCH, "/Order").hasAnyAuthority("Admin")

                        // Các API Trạng thái đơn hàng
                        .requestMatchers(HttpMethod.POST, "/OrderStatus/Admin").hasAnyAuthority("Admin")
                        .requestMatchers(HttpMethod.POST, "/OrderStatus/User").hasAnyAuthority("User")

                        // Các API Voucher
                        .requestMatchers(HttpMethod.GET, "/Voucher").hasAnyAuthority("User", "Admin")
                        .requestMatchers(HttpMethod.GET, "/Voucher/User").permitAll()
                        .requestMatchers(HttpMethod.GET, "/Voucher/Admin").hasAnyAuthority("Admin")
                        .requestMatchers(HttpMethod.POST, "/Voucher").hasAnyAuthority("Admin")
                        .requestMatchers(HttpMethod.PATCH, "/Voucher").hasAnyAuthority("Admin")

                        // Các API Shipping Fee
                        .requestMatchers(HttpMethod.GET, "/ShippingFee").hasAnyAuthority("Admin")

                        .requestMatchers(HttpMethod.GET, "/ShippingFee/Newest").hasAnyAuthority("User", "Admin")
                        .requestMatchers(HttpMethod.POST, "/ShippingFee").hasAnyAuthority("Admin")

                        // Các API Event (sự kiện khuyến mãi)

                        .requestMatchers(HttpMethod.GET, "/Event/Admin").hasAnyAuthority("Admin")
                        .requestMatchers(HttpMethod.GET, "/Event/Currnet").permitAll()
                        .requestMatchers(HttpMethod.GET, "/Event/Banner/{path}").permitAll()

                        .requestMatchers(HttpMethod.POST, "/Event").hasAnyAuthority("Admin")
                        .requestMatchers(HttpMethod.PATCH, "/Event").hasAnyAuthority("Admin")

                        // Các API `Sale`
                        .requestMatchers(HttpMethod.GET, "/Sale/{eventId}").permitAll()
                        .requestMatchers(HttpMethod.POST, "/Sale").hasAnyAuthority("Admin")
                        .requestMatchers(HttpMethod.DELETE, "/Sale").hasAnyAuthority("Admin")

                        // TODO: Các API Liên quan đến tin tức

                        .requestMatchers(HttpMethod.GET, "/News/Admin").hasAnyAuthority("Admin")
                        .requestMatchers(HttpMethod.GET, "/News/User").permitAll()
                        .requestMatchers(HttpMethod.GET, "/News/HotNews").permitAll()
                        .requestMatchers(HttpMethod.GET, "/News/Admin/{id}").hasAnyAuthority("Admin")
                        .requestMatchers(HttpMethod.GET, "/News/User/{id}").permitAll()

                        .requestMatchers(HttpMethod.POST, "/News").hasAnyAuthority("Admin")
                        .requestMatchers(HttpMethod.PATCH, "/News").hasAnyAuthority("Admin")

                        .requestMatchers(HttpMethod.GET, "/NewsImage/{path}").permitAll()
                        .requestMatchers(HttpMethod.POST, "/NewsImage").hasAnyAuthority("Admin")
                        .requestMatchers(HttpMethod.DELETE, "/NewsImage").hasAnyAuthority("Admin")

                        .requestMatchers(HttpMethod.GET, "/Feedback").hasAnyAuthority("Admin")
                        .requestMatchers(HttpMethod.GET, "/Feedback/{id}").hasAnyAuthority("Admin")
                        .requestMatchers(HttpMethod.POST, "/Feedback").hasAnyAuthority("User")
                        .requestMatchers(HttpMethod.DELETE, "/Feedback/{id}").hasAnyAuthority("Admin")

                        .requestMatchers(HttpMethod.GET, "/FeedbackImage/{path}").permitAll()
                        .requestMatchers(HttpMethod.POST, "/Feedback").hasAnyAuthority("Admin")
                        .requestMatchers(HttpMethod.DELETE, "/Feedback").hasAnyAuthority("Admin")

                        // TODO: API liên quan đến Inventory (nhập kho)

                        .requestMatchers(HttpMethod.GET, "/InventoryReport").hasAnyAuthority("Admin")
                        .requestMatchers(HttpMethod.GET, "/InventoryReport/{id}").hasAnyAuthority("Admin")
                        .requestMatchers(HttpMethod.POST, "/InventoryReport").hasAnyAuthority("Admin")
                        .requestMatchers(HttpMethod.PATCH, "/InventoryReport").hasAnyAuthority("Admin")

                        .requestMatchers(HttpMethod.POST, "/InventoryReportDetail").hasAnyAuthority("Admin")
                        .requestMatchers(HttpMethod.PATCH, "/InventoryReportDetail").hasAnyAuthority("Admin")
                        .requestMatchers(HttpMethod.DELETE, "/InventoryReportDetail").hasAnyAuthority("Admin")

                        .requestMatchers(HttpMethod.POST, "/InventoryReportStatus").hasAnyAuthority("Admin")

                        // TODO: API Thống kê
                        .requestMatchers(HttpMethod.GET, "/Statistic/BestSeller").hasAnyAuthority("Admin")
                        .requestMatchers(HttpMethod.GET, "/Statistic/OrderStatus").hasAnyAuthority("Admin")
                        .requestMatchers(HttpMethod.GET, "/Statistic/BestSellerBySize").hasAnyAuthority("Admin")
                        .requestMatchers(HttpMethod.GET, "/Statistic/IncomeSummary").hasAnyAuthority("Admin")

                    // Xác thực tất cả các request
                        .anyRequest()
                        .authenticated()

                ).httpBasic(Customizer.withDefaults())

                // Add JWT vào chuỗi lọc và ưu tiên loc theo JWT
                .sessionManagement(manager -> manager.sessionCreationPolicy(SessionCreationPolicy.STATELESS))
                .authenticationProvider(authenticationProvider())
                .addFilterBefore(logoutAuthFilter,
                        UsernamePasswordAuthenticationFilter.class)
                .addFilterBefore(
                        jwtAuthFIlter, UsernamePasswordAuthenticationFilter.class)

                .exceptionHandling((exceptionHandling) -> exceptionHandling

                        // Cấu hình xử lý ngoại lệ cho trường hợp không xác thực (Login sai ^^)
                        .authenticationEntryPoint(authExceptionHandler)

                        // Cấu hình xử lý ngoại lệ cho trường hợp truy cập bị từ chối (Không đủ quyền)
                        .accessDeniedHandler(authExceptionHandler)

                )
                .oauth2Login(oauth -> {
                    oauth.loginPage("/Auth/SignIn");
                    oauth.successHandler(handler);
                });

        return http.build();
    }

    @Bean
    public PasswordEncoder passwordEncoder() {
        return new BCryptPasswordEncoder();
    }

    @Bean
    public AuthenticationManager authenticationManager(AuthenticationConfiguration authenticationConfiguration)
            throws Exception {
        return authenticationConfiguration.getAuthenticationManager();
    }

    @Bean
    public AuthenticationProvider authenticationProvider() {
        DaoAuthenticationProvider daoAuthenticationProvider = new DaoAuthenticationProvider();
        daoAuthenticationProvider.setUserDetailsService(accountService);
        daoAuthenticationProvider.setPasswordEncoder(passwordEncoder());
        return daoAuthenticationProvider;
    }

}
