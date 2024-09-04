package BackEnd.Service.ShoppingServices.EventServices;

import BackEnd.Entity.ShoppingEntities.Event;
import BackEnd.Form.ShoppingForms.EventForms.EventCreateForm;
import BackEnd.Form.ShoppingForms.EventForms.EventFilterForm;
import BackEnd.Form.ShoppingForms.EventForms.EventUpdateForm;
import org.springframework.data.domain.Page;
import org.springframework.data.domain.Pageable;

import java.io.IOException;

public interface IEventService {
    Event getCurrentEvent();
    Event getEventByEventId(Integer eventId);
    Page<Event> getAllEvents(Pageable pageable, EventFilterForm form, String search);
    Event createEvent(EventCreateForm form) throws IOException;
    Event updateEvent(EventUpdateForm form) throws IOException;
    Event getEventById(Integer eventId);

    boolean isEventValidIfActive(Event event);
}

