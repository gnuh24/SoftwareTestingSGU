package BackEnd.Event;

import lombok.*;
import org.springframework.context.ApplicationEvent;

@Getter
@Setter
public class SendingRegistrationTokenEvent extends ApplicationEvent {

    private static final long serialVersionUID = 1L;

    private String email;

    public SendingRegistrationTokenEvent(String email) {
        super(email);
        this.email = email;
    }

}


