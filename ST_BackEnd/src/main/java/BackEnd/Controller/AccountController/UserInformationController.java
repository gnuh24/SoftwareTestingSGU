package BackEnd.Controller.AccountController;

import BackEnd.Entity.AccountEntity.UserInformation;
import BackEnd.Form.UsersForms.AccountForms.AccountDTOForProfile;
import BackEnd.Form.UsersForms.AccountForms.AccountUpdateForm;
import BackEnd.Form.UsersForms.UserInformationForms.UserInformationCreateForm;
import BackEnd.Form.UsersForms.UserInformationForms.UserInformationDTOForOrder;
import BackEnd.Form.UsersForms.UserInformationForms.UserInformationUpdateForm;
import BackEnd.Service.AccountServices.AccountService.IAccountService;
import BackEnd.Service.AccountServices.UserInformationService.IUserInformationService;
import jakarta.validation.Valid;
import org.modelmapper.ModelMapper;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.http.ResponseEntity;
import org.springframework.web.bind.annotation.*;

@RestController
@RequestMapping("/UserInformation")
@CrossOrigin(origins = "*")
public class UserInformationController {

    @Autowired
    private IUserInformationService informationService;

    @Autowired
    private ModelMapper modelMapper;

    @Autowired
    private IAccountService accountService;

    @PostMapping()
    public ResponseEntity<UserInformationDTOForOrder> createNewUser(@Valid @ModelAttribute UserInformationCreateForm userCreateForm) {
        UserInformation userInformation = informationService.createUser(userCreateForm);
        UserInformationDTOForOrder dto = modelMapper.map(userInformation, UserInformationDTOForOrder.class);
        return ResponseEntity.ok(dto);
    }

    @PatchMapping()
    public UserInformationDTOForOrder updateAccount(@ModelAttribute @Valid UserInformationUpdateForm form){

        UserInformationDTOForOrder account = modelMapper.map(informationService.updateUser(form), UserInformationDTOForOrder.class);
        return account;
    }


}
