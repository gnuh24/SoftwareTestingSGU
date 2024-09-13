package BackEnd.Controller.AccountController;


import BackEnd.Configure.ErrorResponse.AuthException.MismatchedTokenAccountException;
import BackEnd.Configure.ErrorResponse.TheValueAlreadyExists;
import BackEnd.Entity.AccountEntity.Account;
import BackEnd.Form.UsersForms.AccountForms.AccountCreateForm;
import BackEnd.Form.AuthForm.LoginInfoDTO;
import BackEnd.Form.AuthForm.LoginInputForm;
import BackEnd.Service.AccountServices.AccountService.IAccountService;
import BackEnd.Service.AccountServices.AuthService.AuthService;
import BackEnd.Service.AccountServices.AuthService.IAuthService;
import BackEnd.Service.AccountServices.AuthService.JWTUtils;
import jakarta.servlet.http.HttpServletRequest;
import jakarta.validation.Valid;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.http.HttpStatus;
import org.springframework.http.ResponseEntity;
import org.springframework.web.bind.annotation.*;

import java.util.HashMap;
import java.util.Map;

@RestController
@RequestMapping("/Auth")
@CrossOrigin(origins = "*")
public class  AuthController {

    @Autowired
    private AuthService authService;

    @Autowired
    private IAccountService accountService;


    @Autowired
    private JWTUtils jwtUtils;


    //API Login
    @PostMapping(value = "/SignIn")
    public ResponseEntity<?> signInForUser(@ModelAttribute @Valid LoginInputForm signInRequest){

        LoginInfoDTO dto = authService.signInForUser(signInRequest);

        return ResponseEntity.ok(dto);

    }

    //API Login
    @PostMapping(value = "/LoginAdmin")
    public ResponseEntity<?> signInForAdmin(@ModelAttribute @Valid LoginInputForm signInRequest){

        LoginInfoDTO dto = authService.signInForAdmin(signInRequest);

        return ResponseEntity.ok(dto);

    }

    @PostMapping(value = "/Registration")
    public String registration(@ModelAttribute AccountCreateForm form) throws TheValueAlreadyExists {
        accountService.createAccount(form);
        return "Tạo tài khoản thành công !! Hãy kiêm email " + form.getEmail() + "!";
    }

    //API Kích hoạt tài khoản
    @GetMapping(value = "/ActiveUser")
    public ResponseEntity<?> activeUserViaEmail(@RequestParam String token) {
        int flag = accountService.activateUser(token);
        switch (flag){
            case 0:
                return new ResponseEntity<>("Active success!", HttpStatus.OK);
            case 1:
                return new ResponseEntity<>("Token của bạn đã hết hạn xin hãy tạo lại tài khoản !!", HttpStatus.OK);
            case 2:
                return new ResponseEntity<>("Token này đã không còn tồn tại !!", HttpStatus.OK);
        }
        return null;
    }

    @PostMapping(value = "/Refresh")
    public ResponseEntity<LoginInfoDTO> refreshToken(@RequestHeader("Authorization") String token,
                                                        @ModelAttribute LoginInfoDTO form) {
        return ResponseEntity.ok(authService.refreshToken(token, form.getRefreshToken()));
    }

}

