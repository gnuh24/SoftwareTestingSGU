package BackEnd.Service.AccountServices.AccountService;

import BackEnd.Configure.ErrorResponse.InvalidOldPassword;
import BackEnd.Configure.ErrorResponse.InvalidToken;
import BackEnd.Configure.ErrorResponse.TheValueAlreadyExists;
import BackEnd.Configure.ErrorResponse.TokenNotExists;
import BackEnd.Entity.AccountEntity.Account;
import BackEnd.Entity.AccountEntity.Token;
import BackEnd.Entity.AccountEntity.UserInformation;
import BackEnd.Event.SendingRegistrationTokenEvent;
import BackEnd.Event.SendingUpdateEmailTokenEvent;
import BackEnd.Event.SendingUpdatePasswordTokenEvent;
import BackEnd.Form.UsersForms.AccountForms.*;
import BackEnd.Repository.AccountRepository.IAccountRepository;
import BackEnd.Service.AccountServices.AuthService.JWTUtils;
import BackEnd.Service.AccountServices.TokenServices.ITokenService;
import BackEnd.Service.AccountServices.UserInformationService.IUserInformationService;
import BackEnd.Specification.AccountSpecifications.AccountSpecification;
import org.modelmapper.ModelMapper;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.context.ApplicationEventPublisher;
import org.springframework.data.domain.Page;
import org.springframework.data.domain.Pageable;
import org.springframework.data.jpa.domain.Specification;
import org.springframework.security.access.AccessDeniedException;
import org.springframework.security.core.authority.AuthorityUtils;
import org.springframework.security.core.userdetails.UserDetails;
import org.springframework.security.core.userdetails.UsernameNotFoundException;
import org.springframework.security.crypto.password.PasswordEncoder;
import org.springframework.stereotype.Service;
import org.springframework.transaction.annotation.Transactional;

import java.time.LocalDateTime;
import java.util.Map;
import java.util.Optional;

@Service
public class AccountService implements IAccountService {

    @Autowired
    private IAccountRepository repository;

    @Autowired
    private IUserInformationService userService;

    @Autowired
    private PasswordEncoder passwordEncoder;

    @Autowired
    private ITokenService tokenService;

    @Autowired
    private JWTUtils jwtUtils;


    @Autowired
    private ApplicationEventPublisher eventPublisher;

    @Autowired
    private ModelMapper modelMapper;

    @Override
    public Page<Account> getAllAccounts(Pageable pageable, String search, AccountFilterForm form) {
        Specification<Account> buildWhere = AccountSpecification.buildWhere(search, form);
        return repository.findAll(buildWhere, pageable);
    }

    @Override
    public Account getAccountById(Integer accountId, String token) {

        Account account = repository.findById(accountId).orElse(null);

        String email = jwtUtils.extractUsernameWithoutLibrary(token);

        assert account != null;
        if (!account.getUsername().equals(email) ){
            throw new AccessDeniedException("Bạn không có quyền try cập !!");
        }

        return account;
    }

    @Override
    public Account getAccountById(Integer accountId) {

        return repository.findById(accountId).orElse(null);
    }



    @Override
    public Account getAccountByEmail(String email) {
        return repository.findByUserInformation_Email(email);
    }

    @Override
    @Transactional
    public Account createAccount(AccountCreateForm form) throws TheValueAlreadyExists {

        UserInformation in4 = userService.createUser(form.getEmail());

        Account account = new Account();
        account.setPassword(passwordEncoder.encode(form.getPassword()));
        account.setUserInformation(in4);
        account = repository.save(account);
        tokenService.createRegistrationToken(account);
        eventPublisher.publishEvent(new SendingRegistrationTokenEvent(form.getEmail()));

        return account;
    }

    @Override
    @Transactional
    public Account createAccountByEmail(AccountCreateForm form) {

        UserInformation in4 = userService.createUserByEmail(form.getEmail());

        Account account = new Account();
        account.setPassword(passwordEncoder.encode(form.getPassword()));
        account.setUserInformation(in4);
        account.setType(Account.AccountType.GOOGLE);
        account.setStatus(true);
        account = repository.save(account);
        tokenService.createRegistrationToken(account);
        eventPublisher.publishEvent(new SendingRegistrationTokenEvent(form.getEmail()));

        return account;
    }



    @Override
    @Transactional
    public Account updateStatusOfAccount(AccountUpdateFormForStatus form) {
        Account account = getAccountById(form.getAccountId());

        if (form.getStatus() != null){
            account.setStatus(form.getStatus());
        }

        return repository.save(account);
    }

    @Override
    @Transactional
    public Account updateEmailOfAccount(String authToken, AccountUpdateFormForEmail form) throws InvalidToken, TokenNotExists {
        String tokenString = form.getToken();

        Token token = tokenService.getRegistrationTokenByToken(tokenString, (byte) 4 );

        if (token == null){
            throw new TokenNotExists("Token không tồn tại !!");
        }


        String oldEmail = jwtUtils.extractUsernameWithoutLibrary(authToken);

        if (!oldEmail.equals(token.getAccount().getUserInformation().getEmail())){
            throw new InvalidToken("Token bạn gửi không có chức năng thay đổi email của tài khoản này !!");
        }

        if ( token.getExpiration().isAfter(LocalDateTime.now())){
            Account account = getAccountByEmail(oldEmail);
            UserInformation userInformation = userService.getUserByEmail(account.getUserInformation().getEmail());
            userService.updateEmailOfUser(userInformation, form.getNewEmail());
            tokenService.deleteToken(token.getId());
            return account;
        }else{
            // remove Registration User Token
            tokenService.deleteToken(token.getId());
            return null;
            //throw new TokenExpiredException("Token kích hoạt tài khoản của bạn đã hết hạn !! Xin hãy tạo lại tài khoản !!");
        }

    }

    @Override
    @Transactional
    public Account updateAccount(String token, AccountUpdateForm form) {

        Account account = getAccountById(form.getAccountId());

        String email = jwtUtils.extractUsernameWithoutLibrary(token);

        assert account != null;
        if (!account.getUsername().equals(email) ){
            throw new AccessDeniedException("Bạn không có quyền try cập !!");
        }

        userService.updateUser(account.getUserInformation(), form);

        return repository.save(account);
    }



    @Override
    /**
     * MÔ TẢ VỀ NGHIỆP VỤ KÍCH HOẠT TÀI KHOẢN
     *             1. Tìm đối tượng RegistrationToken dựa tên Token
     *             2. Kiểm tra hạn sử dụng
     *                 2.1 Nếu hợp lệ
     *                - Mở khóa tài khoản
     *                - Xóa token đã dùng
     *                 2.2 Neu không hợp lệ
     *                - Xóa token, tài khoản và người dùng liên quan
     *                - Yêu cầu ng dùng Registates lại
     *
     *
     *     Các mã lỗi
     *     0: Thành công
     *     1. Token hết hn
     *     2. Token không còn tồn tại

     */
    public int activateUser(String token){
        Token registrationToken = tokenService.getRegistrationTokenByToken(token, (byte) 1);

        if (registrationToken == null){
            return 2;
        }

        Account account = registrationToken.getAccount();


        if ( registrationToken.getExpiration().isAfter(LocalDateTime.now())){
            account.setActive(true);
            repository.save(account);
            tokenService.deleteToken(registrationToken.getId());
            return 0;
        }else{
            // remove Registration User Token
            tokenService.deleteToken(registrationToken.getId());
            deleteByAccountId(account.getId());
            return 1;
            //throw new TokenExpiredException("Token kích hoạt tài khoản của bạn đã hết hạn !! Xin hãy tạo lại tài khoản !!");
        }


    }

    @Override
    public String getKeyForUpdateEmail(String token, String newEmail) {
        String oldEmail = jwtUtils.extractUsernameWithoutLibrary(token);
        Account account = getAccountByEmail(oldEmail);
        Token token1 = tokenService.createUpdateEmailToken(account);

        eventPublisher.publishEvent(new SendingUpdateEmailTokenEvent(oldEmail, newEmail));

        return "Khởi tạo mã xác thực thành công !! Hãy kiểm tra email: " + newEmail;
    }

    @Override
    public String getKeyForUpdatePassword(String token) {
        String oldEmail = jwtUtils.extractUsernameWithoutLibrary(token);
        Account account = getAccountByEmail(oldEmail);
        Token token1 = tokenService.createUpdatePasswordToken(account);

        eventPublisher.publishEvent(new SendingUpdatePasswordTokenEvent(oldEmail));

        return "Khởi tạo mã xác thực thành công !! Hãy kiểm tra email: " + oldEmail;
    }


    @Override
    @Transactional
    public void deleteByAccountId(Integer accountId) {
        userService.deleteUser(accountId);
        repository.deleteById(accountId);
    }

    @Override
    public int updatePasswordOfAccount(String authToken, AccountUpdateFormForPassword form) throws InvalidToken, InvalidOldPassword, TokenNotExists {
        String tokenString = form.getToken();
        Token token = tokenService.getRegistrationTokenByToken(tokenString, (byte) 2 );

        if (token == null){
            throw new TokenNotExists("Token không tồn tại !!");
        }

        String email = jwtUtils.extractUsernameWithoutLibrary(authToken);
        Account account = token.getAccount();

        if (!email.equals(account.getUserInformation().getEmail())){
            throw new InvalidToken("Token bạn gửi không có chức năng thay đổi mật khẩu của tài khoản này !!");
        }

        String encodedOldPasswordFromInputForm = passwordEncoder.encode(form.getOldPassword());

        if (!passwordEncoder.matches(form.getOldPassword(), account.getPassword())) {
            throw new InvalidOldPassword("Mật khẩu cũ không đúng !!");
        }

        if ( token.getExpiration().isAfter(LocalDateTime.now())){
            String newPassword = passwordEncoder.encode(form.getNewPassword());
            account.setPassword(newPassword);
            repository.save(account);
            tokenService.deleteToken(token.getId());
            return 0;
        }else{
            // remove Registration User Token
            tokenService.deleteToken(token.getId());
            return 1;
            //throw new TokenExpiredException("Token kích hoạt tài khoản của bạn đã hết hạn !! Xin hãy tạo lại tài khoản !!");
        }

    }


    @Override
    public UserDetails loadUserByUsername(String username) throws UsernameNotFoundException {
        Account account = getAccountByEmail(username);

        if (account == null) {
            throw new UsernameNotFoundException(username);
        }

        return new org.springframework.security.core.userdetails.User(
            account.getUserInformation().getEmail(),
            account.getPassword(),
            AuthorityUtils.createAuthorityList(account.getRole().toString())
        );
    }

    @Override
    public Account registerOrAuthenticateUser(String email) {
       Account userOptional = getAccountByEmail(email);

        if (userOptional == null) {
            // Đăng ký người dùng mới
            AccountCreateForm form = new AccountCreateForm();
            form.setEmail(email);
            form.setPassword("123456");


            return  createAccountByEmail(form);
        }

        return userOptional;


    }

}
