package BackEnd.Event;

import lombok.Getter;
import lombok.Setter;
import org.springframework.context.ApplicationEvent;

@Getter
@Setter
public class SendingUpdateEmailTokenEvent extends ApplicationEvent {

    private static final long serialVersionUID = 1L;

    private String email;

    private String newEmail;

    public SendingUpdateEmailTokenEvent(String email, String newEmail) {
        super(email);
        this.email = email;
        this.newEmail = newEmail;
    }

}
