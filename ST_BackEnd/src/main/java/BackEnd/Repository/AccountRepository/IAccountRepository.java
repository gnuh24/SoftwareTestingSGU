package BackEnd.Repository.AccountRepository;

import BackEnd.Entity.AccountEntity.Account;
import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.data.jpa.repository.JpaSpecificationExecutor;

public interface IAccountRepository extends JpaRepository<Account, Integer>, JpaSpecificationExecutor<Account> {

    Account findByUserInformation_Email(String email);


}

