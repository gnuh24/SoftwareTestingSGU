package BackEnd.Repository.AccountRepository;

import BackEnd.Entity.AccountEntity.Token;
import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.data.jpa.repository.Query;
import org.springframework.data.repository.query.Param;

public interface ITokenRepository extends JpaRepository<Token, Integer> {

    @Query("SELECT t FROM Token t WHERE t.account.id = :accountId AND t.tokenType.id = :typeTokenId ORDER BY t.createTime DESC LIMIT 1")
    Token findTokenByAccountIdAndTypeTokenId(@Param("accountId") Integer accountId, @Param("typeTokenId") Byte typeTokenId);

    @Query("SELECT t FROM Token t WHERE t.token = :token AND t.tokenType.id = :typeTokenId")
    Token findByTokenAndTypeTokenId(@Param("token") String token, @Param("typeTokenId") Byte typeTokenId);
}
