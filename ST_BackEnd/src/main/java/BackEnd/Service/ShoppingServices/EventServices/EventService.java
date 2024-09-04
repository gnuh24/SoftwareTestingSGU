package BackEnd.Service.ShoppingServices.EventServices;

import BackEnd.Entity.ShoppingEntities.Event;
import BackEnd.Form.ShoppingForms.EventForms.EventCreateForm;
import BackEnd.Form.ShoppingForms.EventForms.EventFilterForm;
import BackEnd.Form.ShoppingForms.EventForms.EventUpdateForm;
import BackEnd.Form.ShoppingForms.SaleForms.SaleCreateForm;
import BackEnd.Form.ShoppingForms.SaleForms.SaleCreateFormForFirstTime;
import BackEnd.Other.ImageService.ImageService;
import BackEnd.Repository.ShoppingRepositories.IEventRepository;
import BackEnd.Service.ShoppingServices.SaleServices.ISaleService;
import BackEnd.Specification.ShoppingSpecifications.EventSpecification;
import org.modelmapper.ModelMapper;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.data.domain.Page;
import org.springframework.data.domain.Pageable;
import org.springframework.data.jpa.domain.Specification;
import org.springframework.stereotype.Service;
import org.springframework.transaction.annotation.Transactional;

import java.io.IOException;
import java.time.LocalDateTime;
import java.util.List;

@Service
public class EventService implements IEventService {

    @Autowired
    private IEventRepository eventRepository;

    @Autowired
    private ISaleService saleService;

    @Autowired
    private ModelMapper modelMapper;



    @Override
    public Event getEventByEventId(Integer eventId){
        return eventRepository.findById(eventId).orElse(null);
    }

    @Override
    public Page<Event> getAllEvents(Pageable pageable, EventFilterForm form, String search) {
        Specification<Event> buildWhere = EventSpecification.buildWhere(form, search);
        return eventRepository.findAll( buildWhere, pageable);
    }


    @Override
    @Transactional
    public Event createEvent(EventCreateForm form) throws IOException {
        Event event = modelMapper.map(form, Event.class);
        event = eventRepository.save(event);
        for (SaleCreateFormForFirstTime form1: form.getSaleCreateForm()){
            SaleCreateForm saleCreateForm = new SaleCreateForm(event.getEventId(), form1.getShoeId());
            saleService.createSale(saleCreateForm);
        }

        String path = ImageService.saveImage(ImageService.eventBannerPath, form.getBanner());
        event.setBanner(path);
        return event;
    }

    @Override
    public Event getCurrentEvent() {
        LocalDateTime currentTime = LocalDateTime.now();
        return eventRepository.findCurrentEvent(currentTime);
    }


    @Override
    @Transactional
    public Event updateEvent(EventUpdateForm form) throws IOException {
        Event event = getEventByEventId(form.getEventId());

        if (form.getBanner() != null) {

            ImageService.deleteImage(ImageService.eventBannerPath, event.getBanner());

            String path = ImageService.saveImage(ImageService.eventBannerPath, form.getBanner());

            event.setBanner(path);
        }

        if (form.getEventName() != null) {
            event.setEventName(form.getEventName());
        }


        if (form.getStatus() != null) {
            event.setStatus(form.getStatus());
        }

        if (form.getPercentage() != null) {
            event.setPercentage(form.getPercentage());
        }

        return eventRepository.save(event);
    }


    @Override
    public Event getEventById(Integer eventId) {
        return eventRepository.findById(eventId).orElseThrow(() -> new RuntimeException("Event not found with id: " + eventId));
    }

    @Override
    public boolean isEventValidIfActive(Event event) {

        Event currentEvent = getCurrentEvent();
        if (currentEvent != null){
            if ( currentEvent.getEndTime().isAfter(event.getStartTime())){
                return false;
            }
        }


        List<Event> list = eventRepository.findFutureActiveEvents(LocalDateTime.now());
        for (Event eventDB : list) {
            if (!(event.getStartTime().isAfter(eventDB.getEndTime()) || event.getEndTime().isBefore(eventDB.getStartTime()))) {
                return false;
            }
        }
        return true;
    }

}

