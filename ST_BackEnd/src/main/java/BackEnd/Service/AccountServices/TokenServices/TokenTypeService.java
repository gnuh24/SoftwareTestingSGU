package BackEnd.Service.AccountServices.TokenServices;

import BackEnd.Entity.AccountEntity.TokenType;
import BackEnd.Repository.AccountRepository.ITokenTypeRepository;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;

@Service
public class TokenTypeService implements ITokenTypeService{

    @Autowired
    private ITokenTypeRepository tokenTypeRepository;


    @Override
    public TokenType getTokenTypeById(Byte id) {
        return tokenTypeRepository.findById( id ).orElse(null);
    }
}
