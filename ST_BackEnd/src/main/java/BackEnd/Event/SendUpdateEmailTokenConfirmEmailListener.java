package BackEnd.Event;

import BackEnd.Service.AccountServices.EmailService.IEmailService;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.context.ApplicationListener;
import org.springframework.stereotype.Component;

@Component
//Đây là class thực thi khi co 1 sự kiện SendingRegistrationTokenEvent được  call
public class SendUpdateEmailTokenConfirmEmailListener
    implements ApplicationListener<SendingUpdateEmailTokenEvent> {

    @Autowired
    private IEmailService emailService;

    @Override
    /*
    - Phương thức được thực thi khi SendingRegistrationTokenEvent được call

     */
    public void onApplicationEvent(SendingUpdateEmailTokenEvent event) {
        emailService.sendUpdateEmailUserConfirm(event.getEmail(), event.getNewEmail());
    }

}
