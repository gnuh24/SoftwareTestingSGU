package BackEnd.Repository.AccountRepository;
import BackEnd.Entity.AccountEntity.TokenType;
import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.stereotype.Repository;

public interface ITokenTypeRepository extends JpaRepository<TokenType, Byte> {

}

