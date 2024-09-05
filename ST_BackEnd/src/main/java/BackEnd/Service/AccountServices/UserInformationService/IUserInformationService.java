package BackEnd.Service.AccountServices.UserInformationService;

import BackEnd.Configure.ErrorResponse.TheValueAlreadyExists;
import BackEnd.Entity.AccountEntity.UserInformation;
import BackEnd.Form.UsersForms.AccountForms.AccountUpdateForm;
import BackEnd.Form.UsersForms.UserInformationForms.UserInformationCreateForm;
import BackEnd.Form.UsersForms.UserInformationForms.UserInformationUpdateForm;
import org.apache.catalina.User;

public interface IUserInformationService {

    UserInformation getUserById(Integer userId);

    UserInformation getUserByEmail(String email);

    UserInformation createUser(String email) throws TheValueAlreadyExists;

    UserInformation createUserByEmail(String email);

    UserInformation createUser(UserInformationCreateForm form);

    boolean isEmailExists(String email);

    UserInformation updateEmailOfUser(UserInformation user, String email);

    UserInformation updateUser(UserInformation user, AccountUpdateForm form);

    UserInformation updateUser(UserInformationUpdateForm form);

    void deleteUser(Integer userId);
}
