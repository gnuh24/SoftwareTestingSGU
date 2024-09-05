package BackEnd.Service.AccountServices.AuthService;

import BackEnd.Configure.ErrorResponse.AuthException.TokenExpiredException;
import io.jsonwebtoken.Claims;
import io.jsonwebtoken.Jwts;
import io.jsonwebtoken.SignatureAlgorithm;
import io.jsonwebtoken.security.Keys;
import org.springframework.security.core.userdetails.UserDetails;
import org.springframework.stereotype.Component;

import javax.crypto.SecretKey;
import javax.crypto.spec.SecretKeySpec;
import java.nio.charset.StandardCharsets;
import java.util.Base64;
import java.util.Date;
import java.util.HashMap;
import java.util.function.Function;

@Component
public class JWTUtils {

    private final SecretKey secretKeyForAccessToken ;
    private final SecretKey secretKeyForRefreshToken = Keys.secretKeyFor(SignatureAlgorithm.HS256);

    private  static  final long EXPIRATION_TIME_FOR_TOKEN = 604_800_000; //1 Day
    private  static  final long EXPIRATION_TIME_FOR_REFRSH_TOKEN = 604_800_000; //1 Day


    public JWTUtils(){
        //Khởi tạo Secret key
        String secreteString = "843567893696976453275974432697R634976R738467TR678T34865R6834R8763T478378637664538745673865783678548735687R3";
        byte[] keyBytes = Base64.getDecoder().decode(secreteString.getBytes(StandardCharsets.UTF_8));
        this.secretKeyForAccessToken = new SecretKeySpec(keyBytes, "HmacSHA256");
    }

    //Tạo Token
    public String generateToken(UserDetails userDetails){
        return Jwts.builder()
            .subject(userDetails.getUsername())
            .issuedAt(new Date(System.currentTimeMillis()))
            .expiration(new Date(System.currentTimeMillis() + EXPIRATION_TIME_FOR_TOKEN))
            .signWith(secretKeyForAccessToken)
            .compact();
    }

    // Tạo refresh Token
    public String generateRefreshToken(HashMap<String, Object> claims, UserDetails userDetails){
        return Jwts.builder()
            .claims(claims)
            .subject(userDetails.getUsername())
            .issuedAt(new Date(System.currentTimeMillis()))
            .expiration(new Date(System.currentTimeMillis() + EXPIRATION_TIME_FOR_REFRSH_TOKEN))
            .signWith(secretKeyForRefreshToken)
            .compact();
    }


    // TODO: Các phương thức có sẵn

    //Tách email ra từ JWT Token
    public String extractUsernameAccessToken(String token){
        return extractClaims(true, token, Claims::getSubject);
    }

    //Tách email ra từ JWT Token
    public String extractUsernameRefreshToken(String token){
        return extractClaims(false, token, Claims::getSubject);
    }

    private <T> T extractClaims(Boolean isAccessToken, String token, Function<Claims, T> claimsTFunction){

        if (isAccessToken){
            return claimsTFunction.apply(
                Jwts.parser().verifyWith(secretKeyForAccessToken).build().parseSignedClaims(token).getPayload()
            );
        }

        return claimsTFunction.apply(
            Jwts.parser().verifyWith(secretKeyForRefreshToken).build().parseSignedClaims(token).getPayload()
        );

    }


    // TODO: Các phương thức Custom

    //Tách Email từ JWT Token (Dùng kỹ thuật xử lý chuỗi)
    public String extractUsernameWithoutLibrary(String token) {
        String[] parts = token.split("\\.");
        String encodedPayload = parts[1];
        String payload = new String(Base64.getUrlDecoder().decode(encodedPayload), StandardCharsets.UTF_8);
        return payload.split("\"")[3];
    }

    //Kiểm tra xem Token hợp lệ hay không (Không kiểm tra hạn dùng)
    public boolean isTokenValidWithoutExpired(String token, UserDetails userDetails){
        final String username = extractUsernameWithoutLibrary(token);
        return username.equals(userDetails.getUsername());
    }

    //Kiểm tra xem Token hợp lệ hay không
    public boolean isAccessTokenValid(String token, UserDetails userDetails) throws TokenExpiredException{
        final String username = extractUsernameAccessToken(token);
        return (username.equals(userDetails.getUsername()) && !isAccessTokenExpired(token));
    }

    //Kiểm tra xem Token hợp lệ hay không
    public boolean isRefreshTokenValid(String token, UserDetails userDetails) throws TokenExpiredException{
        final String username = extractUsernameAccessToken(token);
        return (username.equals(userDetails.getUsername()) && !isRefreshTokenExpired(token));
    }

    //Kiểm tra xem Access Token hết hạn chưa ?
    public boolean isAccessTokenExpired(String token) throws TokenExpiredException{
        boolean flag = extractClaims(true, token, Claims::getExpiration).before(new Date());
        //flag = true là Token hết hn
        if (flag){
            throw new TokenExpiredException("Access Token đăng nhập đã hết hạn !! Xin hãy refresh Token mới !!");
        }
        return false;
    }

    //Kiểm tra xem Refresh Token hết hạn chưa ?
    public boolean isRefreshTokenExpired(String token) throws TokenExpiredException{
        boolean flag = extractClaims(false, token, Claims::getExpiration).before(new Date());
        //flag = true là Token hết hn
        if (flag){
            throw new TokenExpiredException("Refresh Token đã hết hạn !! Vui lòng đăng nhập lại để lấy refresh token mới.");
        }
        return false;
    }
}
