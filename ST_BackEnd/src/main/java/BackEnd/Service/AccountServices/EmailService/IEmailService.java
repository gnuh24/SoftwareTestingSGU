package BackEnd.Service.AccountServices.EmailService;

public interface IEmailService {

    void sendRegistrationUserConfirm(String email);

    void sendUpdateEmailUserConfirm(String email, String newEmail);

    void sendUpdatePasswordUserConfirm(String email);

}

