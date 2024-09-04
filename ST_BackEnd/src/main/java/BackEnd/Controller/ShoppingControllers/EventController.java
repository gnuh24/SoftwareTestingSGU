package BackEnd.Controller.ShoppingControllers;

import BackEnd.Entity.ShoppingEntities.Event;
import BackEnd.Form.ShoppingForms.EventForms.*;
import BackEnd.Form.ShoppingForms.VoucherForms.VoucherDTO;
import BackEnd.Other.ImageService.ImageService;
import BackEnd.Service.ShoppingServices.EventServices.IEventService;
import jakarta.validation.Valid;
import org.modelmapper.ModelMapper;
import org.modelmapper.TypeToken;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.core.io.Resource;
import org.springframework.core.io.UrlResource;
import org.springframework.data.domain.Page;
import org.springframework.data.domain.PageImpl;
import org.springframework.data.domain.Pageable;
import org.springframework.http.HttpHeaders;
import org.springframework.http.MediaType;
import org.springframework.http.ResponseEntity;
import org.springframework.web.bind.annotation.*;

import java.io.IOException;
import java.net.MalformedURLException;
import java.nio.file.Path;
import java.nio.file.Paths;
import java.util.List;

@RestController
@RequestMapping("/Event")
@CrossOrigin(origins = "*")
public class EventController {

    @Autowired
    private IEventService eventService;

    @Autowired
    private ModelMapper modelMapper;

    @GetMapping(value = "/Banner/{path}")
    public ResponseEntity<Resource> getBannerOfEvent(@PathVariable String path) {
        try{
            Path imagePath = Paths.get(ImageService.eventBannerPath, path);
            Resource resource = new UrlResource(imagePath.toUri());

            return ResponseEntity.ok()
                .contentType(MediaType.IMAGE_JPEG)
                .header(HttpHeaders.CONTENT_DISPOSITION, "attachment; filename=\"" + resource.getFilename() + "\"")
                .body(resource);
        }

        catch (MalformedURLException e) {
            return ResponseEntity.badRequest().build();
        }
    }

    @GetMapping(value = "/Admin")
    public ResponseEntity<Page<EventDTO>> getAllEventByAdmin(Pageable pageable,
                                                             EventFilterForm form,
                                                             String search){
        Page<Event> entities =  eventService.getAllEvents(pageable, form, search);
        List<EventDTO> dtos = modelMapper.map(entities.getContent(), new TypeToken<List<EventDTO>>() {}.getType());
        Page<EventDTO> result = new PageImpl<>(dtos, pageable, entities.getTotalElements());
        return ResponseEntity.ok( result);
    }

    @GetMapping("/Current")
    public ResponseEntity<EventDTO> getCurrentEvent() {
        Event currentEvent = eventService.getCurrentEvent();
        if (currentEvent != null) {
            EventDTO eventDTO = modelMapper.map(currentEvent, EventDTO.class);
            return ResponseEntity.ok(eventDTO);
        } else {
            return ResponseEntity.noContent().build();
        }
    }

    @PostMapping
    public ResponseEntity<EventDTO> createEvent(@ModelAttribute @Valid EventCreateForm form) throws Exception {
            Event createdEvent = eventService.createEvent(form);
            EventDTO dto = modelMapper.map(createdEvent, EventDTO.class);
            return ResponseEntity.ok(dto);
    }

    @PatchMapping()
    public ResponseEntity<EventDTO> updateEvent(@ModelAttribute @Valid EventUpdateForm form) throws Exception {

        if (form.getStatus() != null && form.getStatus()){
            Event event = eventService.getEventById(form.getEventId());
            boolean check = eventService.isEventValidIfActive(event);
            System.err.println("Check nè: " + check);
            if (check){
                Event updatedEvent = eventService.updateEvent(form);
                EventDTO dto = modelMapper.map(updatedEvent, EventDTO.class);
                return ResponseEntity.ok(dto);
            }else {
                throw new Exception("Bạn không thể public 1 event mà thời gian diễn ra của event đó có 1 event khác đang diễn ra trong hệ thống !!");
            }
        }else{
            Event updatedEvent = eventService.updateEvent(form);
            EventDTO dto = modelMapper.map(updatedEvent, EventDTO.class);
            return ResponseEntity.ok(dto);
        }


    }
}
