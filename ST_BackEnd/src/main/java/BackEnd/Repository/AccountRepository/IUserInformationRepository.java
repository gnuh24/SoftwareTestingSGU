package BackEnd.Repository.AccountRepository;

import BackEnd.Entity.AccountEntity.UserInformation;
import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.data.jpa.repository.JpaSpecificationExecutor;

public interface IUserInformationRepository extends JpaRepository<UserInformation, Integer>, JpaSpecificationExecutor<UserInformation> {

    boolean existsByEmail(String email);

    UserInformation findByEmail(String email);

}
