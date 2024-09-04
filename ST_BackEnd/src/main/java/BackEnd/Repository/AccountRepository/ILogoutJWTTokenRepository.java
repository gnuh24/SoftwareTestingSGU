package BackEnd.Repository.AccountRepository;

import BackEnd.Entity.AccountEntity.LogoutJWTToken;
import org.springframework.data.jpa.repository.JpaRepository;

public interface ILogoutJWTTokenRepository extends JpaRepository<LogoutJWTToken, Integer> {
    LogoutJWTToken findByToken(String token);
}

