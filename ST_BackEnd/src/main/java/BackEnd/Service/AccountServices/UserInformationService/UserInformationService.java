package BackEnd.Service.AccountServices.UserInformationService;

import BackEnd.Configure.ErrorResponse.TheValueAlreadyExists;
import BackEnd.Entity.AccountEntity.UserInformation;
import BackEnd.Form.UsersForms.AccountForms.AccountUpdateForm;
import BackEnd.Form.UsersForms.UserInformationForms.UserInformationCreateForm;
import BackEnd.Form.UsersForms.UserInformationForms.UserInformationUpdateForm;
import BackEnd.Repository.AccountRepository.IUserInformationRepository;
import org.modelmapper.ModelMapper;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;
import org.springframework.transaction.annotation.Transactional;

@Service
public class UserInformationService implements IUserInformationService {

    @Autowired
    private IUserInformationRepository userInformationRepository;

    @Autowired
    private ModelMapper modelMapperl;


    @Override
    public UserInformation getUserById(Integer userId) {
        return userInformationRepository.findById(userId).orElse(null);
    }

    @Override
    public UserInformation getUserByEmail(String email) {

        return userInformationRepository.findByEmail(email);
    }

    @Override
    @Transactional
    public UserInformation createUser(UserInformationCreateForm form){
        UserInformation userInformation = modelMapperl.map(form, UserInformation.class);
        return userInformationRepository.save(userInformation);
    }


    @Override
    @Transactional
    public UserInformation createUser(String email) throws TheValueAlreadyExists {
        UserInformation userInformation = new UserInformation();

        if (isEmailExists(email)) {
            throw new TheValueAlreadyExists("Email đã tồn tại vui lòng điền email khác !!");
        }else{
            userInformation.setEmail(email);
        }

        return userInformationRepository.save(userInformation);
    }

    @Override
    public UserInformation createUserByEmail(String email) {
        UserInformation userInformation = new UserInformation();
        userInformation.setEmail(email);
        return userInformationRepository.save(userInformation);
    }

    @Override
    public boolean isEmailExists(String email) {
        return userInformationRepository.existsByEmail(email);
    }

    @Override
    public UserInformation updateEmailOfUser(UserInformation user, String email) {
        user.setEmail(email);
        return userInformationRepository.save(user);
    }


    @Override
    @Transactional
    public UserInformation updateUser(UserInformation user, AccountUpdateForm form) {

        if (user != null) {
            if (form.getFullname() != null) {
                user.setFullname(form.getFullname());
            }
            if (form.getGender() != null) {
                user.setGender(form.getGender());
            }
            if (form.getBirthday() != null) {
                user.setBirthday(form.getBirthday());
            }
            if (form.getPhone() != null) {
                user.setPhoneNumber(form.getPhone());
            }

            if (form.getAddress() != null){
                user.setAddress(form.getAddress());
            }

        }
        return userInformationRepository.save(user);
    }

    @Override
    public UserInformation updateUser(UserInformationUpdateForm form) {
        UserInformation user = userInformationRepository.findById(form.getId()).orElse(null);

        if (user != null) {
            if (form.getFullname() != null) {
                user.setFullname(form.getFullname());
            }
            if (form.getGender() != null) {
                user.setGender(form.getGender());
            }
            if (form.getBirthday() != null) {
                user.setBirthday(form.getBirthday());
            }
            if (form.getPhone() != null) {
                user.setPhoneNumber(form.getPhone());
            }

            if (form.getAddress() != null){
                user.setAddress(form.getAddress());
            }

        }
        return userInformationRepository.save(user);
    }

    @Override
    @Transactional
    public void deleteUser(Integer userId) {
        //repository.deleteById(userId);
    }
}
