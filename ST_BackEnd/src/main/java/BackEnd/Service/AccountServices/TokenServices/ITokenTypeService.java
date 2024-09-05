package BackEnd.Service.AccountServices.TokenServices;

import BackEnd.Entity.AccountEntity.TokenType;

public interface ITokenTypeService {

    TokenType getTokenTypeById(Byte id);

}
