package BackEnd.Service.AccountServices.EmailService;

import BackEnd.Entity.AccountEntity.Account;
import BackEnd.Service.AccountServices.AccountService.IAccountService;
import BackEnd.Service.AccountServices.TokenServices.ITokenService;
import jakarta.mail.MessagingException;
import jakarta.mail.internet.MimeMessage;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.mail.javamail.JavaMailSender;
import org.springframework.mail.javamail.MimeMessageHelper;
import org.springframework.stereotype.Service;


@Service
public class EmailService implements IEmailService {

    @Autowired
    private IAccountService accountService;

    @Autowired
    private ITokenService tokenService;

    @Autowired
    private JavaMailSender mailSender;

    @Override
    public void sendRegistrationUserConfirm(String email) {
        Account account = accountService.getAccountByEmail(email);
        String token = tokenService.getRegistrationTokenByAccountIdAndTypeToken_Id(account.getId(), (byte) 1).getToken();
        String confirmationUrl = "http://localhost:8080/Auth/ActiveUser?token=" + token;

        String subject = "Xác Nhận Đăng Ký Account";
        String content = getEmailContentForRegistration(confirmationUrl);

        sendEmail(email, subject, content);
    }

    @Override
    public void sendUpdateEmailUserConfirm(String email, String newEmail) {
        Account account = accountService.getAccountByEmail(email);
        String token = tokenService.getRegistrationTokenByAccountIdAndTypeToken_Id(account.getId(), (byte) 4).getToken();

        String subject = "Mã xác nhận đổi email";
        String content = getEmailContentWithSixDigitTokenEmail(token);

        sendEmail(newEmail, subject, content);
    }

    @Override
    public void sendUpdatePasswordUserConfirm(String email) {
        Account account = accountService.getAccountByEmail(email);
        String token = tokenService.getRegistrationTokenByAccountIdAndTypeToken_Id(account.getId(), (byte) 2).getToken();

        String subject = "Mã xác nhận đổi mật khẩu";
        String content = getEmailContentWithSixDigitTokenPassword(token);

        sendEmail(email, subject, content);
    }

    private String getEmailContentForRegistration(String confirmationUrl) {
        return "<!DOCTYPE html>" +
            "<html>" +
                "<head>" +
                    "<style>" +
                        "body {font-family: Arial, sans-serif;}" +
                        ".container {padding: 20px;}" +
                        ".header {background-color: #4CAF50; padding: 10px; text-align: center; color: white;}" +
                        ".content {margin: 20px; padding: 20px; border: 1px solid #ddd; border-radius: 5px;}" +
                        ".button {background-color: #4CAF50; color: white; padding: 10px 20px; text-align: center; text-decoration: none; display: inline-block; border-radius: 5px;}" +
                        ".footer {margin-top: 20px; text-align: center; color: #888;}" +
                        ".highlight {color: white; font-weight: bold;}" +  // Thêm lớp .highlight
                    "</style>" +
                "</head>" +
                "<body>" +
                    "<div class=\"container\">" +
                        "<div class=\"header\">" +
                            "<h1>Xác Nhận Đăng Ký Account</h1>" +
                        "</div>" +
                        "<div class=\"content\">" +
                            "<p>Chào bạn,</p>" +
                            "<p>Bạn đã đăng ký thành công. Click vào link dưới đây để kích hoạt tài khoản:</p>" +
                            "<p><a href=\"" + confirmationUrl + "\" class=\"button\"><span class=\"highlight\">Kích hoạt tài khoản</span></a></p>" +  // Áp dụng lớp .highlight
                        "</div>" +
                        "<div class=\"footer\">" +
                            "<p>Cảm ơn bạn vì đã tin tưởng chúng tôi!</p>" +
                        "</div>" +
                    "</div>" +
                "</body>" +
            "</html>";
    }

    // Method to create the email content with the 6-digit token
    private String getEmailContentWithSixDigitTokenEmail(String token) {
        return "<!DOCTYPE html>" +
            "<html>" +
                "<head>" +
                    "<style>" +
                        "body {font-family: Arial, sans-serif;}" +
                        ".container {padding: 20px;}" +
                        ".header {background-color: #4CAF50; padding: 10px; text-align: center; color: white;}" +
                        ".content {margin: 20px; padding: 20px; border: 1px solid #ddd; border-radius: 5px;}" +
                        ".button {background-color: #4CAF50; color: white; padding: 10px 20px; text-align: center; text-decoration: none; display: inline-block; border-radius: 5px;}" +
                        ".footer {margin-top: 20px; text-align: center; color: #888;}" +
                        ".highlight {color: white; font-weight: bold;}" +
                    "</style>" +
                "</head>" +
                "<body>" +
                    "<div class=\"container\">" +
                        "<div class=\"header\">" +
                            "<h1>Mã xác thực thay đổi email</h1>" +
                        "</div>" +
                        "<div class=\"content\">" +
                            "<p>Chào bạn,</p>" +
                            "<p>Mã xác thực đổi email</p>" +
                            "<p class=\"button\"><span class=\"highlight\">" + token + "</span></p>" +  // Display the token
                        "</div>" +
                        "<div class=\"footer\">" +
                            "<p>Cảm ơn bạn vì đã tin tưởng chúng tôi!</p>" +
                        "</div>" +
                    "</div>" +
                "</body>" +
            "</html>";
    }

    private String getEmailContentWithSixDigitTokenPassword(String token) {
        return "<!DOCTYPE html>" +
            "<html>" +
            "<head>" +
            "<style>" +
            "body {font-family: Arial, sans-serif;}" +
            ".container {padding: 20px;}" +
            ".header {background-color: #4CAF50; padding: 10px; text-align: center; color: white;}" +
            ".content {margin: 20px; padding: 20px; border: 1px solid #ddd; border-radius: 5px;}" +
            ".button {background-color: #4CAF50; color: white; padding: 10px 20px; text-align: center; text-decoration: none; display: inline-block; border-radius: 5px;}" +
            ".footer {margin-top: 20px; text-align: center; color: #888;}" +
            ".highlight {color: white; font-weight: bold;}" +
            "</style>" +
            "</head>" +
            "<body>" +
            "<div class=\"container\">" +
            "<div class=\"header\">" +
            "<h1>Mã xác thực thay đổi mật khẩu</h1>" +
            "</div>" +
            "<div class=\"content\">" +
            "<p>Chào bạn,</p>" +
            "<p>Mã xác thực đổi mật khẩu</p>" +
            "<p class=\"button\"><span class=\"highlight\">" + token + "</span></p>" +  // Display the token
            "</div>" +
            "<div class=\"footer\">" +
            "<p>Cảm ơn bạn vì đã tin tưởng chúng tôi!</p>" +
            "</div>" +
            "</div>" +
            "</body>" +
            "</html>";
    }


    private void sendEmail(final String recipientEmail, final String subject, final String content) {
        MimeMessage message = mailSender.createMimeMessage();
        try {
            MimeMessageHelper helper = new MimeMessageHelper(message, true, "UTF-8");
            helper.setTo(recipientEmail);
            helper.setSubject(subject);
            helper.setText(content, true); // true indicates HTML

            mailSender.send(message);
        } catch (MessagingException e) {
            throw new RuntimeException(e);
        }
    }
}
