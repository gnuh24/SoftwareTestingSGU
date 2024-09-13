package BackEnd.Repository.AccountRepository;

import BackEnd.Entity.AccountEntity.Token;
import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.data.jpa.repository.Query;
import org.springframework.data.repository.query.Param;

public interface ITokenRepository extends JpaRepository<Token, Integer> {

    @Query("SELECT t FROM Token t WHERE t.account.id = :accountId ORDER BY t.createTime DESC LIMIT 1")
    Token findTokenByAccountIdAndTypeTokenId(@Param("accountId") Integer accountId);

    @Query("SELECT t FROM Token t WHERE t.token = :token ")
    Token findByTokenAndTypeTokenId(@Param("token") String token);
}
