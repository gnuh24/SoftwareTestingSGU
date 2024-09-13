package BackEnd.Service.AccountServices.TokenServices;

import BackEnd.Entity.AccountEntity.Account;
import BackEnd.Entity.AccountEntity.Token;
import BackEnd.Repository.AccountRepository.ITokenRepository;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;
import org.springframework.transaction.annotation.Transactional;

import java.util.Random;
import java.util.UUID;

@Service
public class TokenService implements ITokenService{

    @Autowired
    private ITokenRepository tokenRepository;


    //Lấy Token dựa tên ID
    @Override
    public Token getRegistrationTokenById(Integer id) {
        return tokenRepository.findById(id).orElse(null);
    }

    //Lấy Token dựa trên Mã tài khoản tương ứng
    @Override
    public Token getRegistrationTokenByAccountIdAndTypeToken_Id(Integer accountId) {
        return tokenRepository.findTokenByAccountIdAndTypeTokenId(accountId);
    }

    //Lấy Token dựa trên mã Token
    @Override
    public Token getRegistrationTokenByToken(String token) {
        return tokenRepository.findByTokenAndTypeTokenId(token);
    }


    //Tạo Token
    @Override
    @Transactional
    public Token createRegistrationToken(Account account) {

        Token registrationToken = new Token();

        //Tạo token bằng mã UUID
        String token = UUID.randomUUID().toString();

        registrationToken.setToken(token);

        registrationToken.setAccount(account);

        return tokenRepository.save(registrationToken);
    }


    //Xóa token
    @Override
    @Transactional
    public void deleteToken(Integer id) {
        tokenRepository.deleteById(id);
    }

}
