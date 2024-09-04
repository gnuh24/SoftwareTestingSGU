package BackEnd.Event;

import lombok.Getter;
import lombok.Setter;
import org.springframework.context.ApplicationEvent;

@Getter
@Setter
public class SendingUpdatePasswordTokenEvent extends ApplicationEvent {

    private static final long serialVersionUID = 1L;

    private String email;

    public SendingUpdatePasswordTokenEvent(String email) {
        super(email);
        this.email = email;
    }

}

