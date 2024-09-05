package BackEnd.Form.AuthForm;

import lombok.*;

@Data
@AllArgsConstructor
@NoArgsConstructor
public class LoginInfoDTO {

    private int statusCode;

    private String error;
    private String message;

    private String token;
    private String tokenExpirationTime;

    private String refreshToken;
    private String refreshTokenExpirationTime;

    private String email;
    private String role;
    private Integer id;
    private Boolean status;

}
