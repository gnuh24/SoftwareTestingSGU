package BackEnd.Service.AccountServices.TokenServices;

import BackEnd.Entity.AccountEntity.Account;
import BackEnd.Entity.AccountEntity.Token;
import BackEnd.Entity.AccountEntity.TokenType;
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

    @Autowired
    private ITokenTypeService tokenTypeService;


    //Lấy Token dựa tên ID
    @Override
    public Token getRegistrationTokenById(Integer id) {
        return tokenRepository.findById(id).orElse(null);
    }

    //Lấy Token dựa trên Mã tài khoản tương ứng
    @Override
    public Token getRegistrationTokenByAccountIdAndTypeToken_Id(Integer accountId, Byte typeTokenId) {
        return tokenRepository.findTokenByAccountIdAndTypeTokenId(accountId, typeTokenId);
    }

    //Lấy Token dựa trên mã Token
    @Override
    public Token getRegistrationTokenByToken(String token, Byte typeTokenId) {
        return tokenRepository.findByTokenAndTypeTokenId(token, typeTokenId);
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

        TokenType tokenType = tokenTypeService.getTokenTypeById( (byte) 1 );

        registrationToken.setTokenType(tokenType);

        return tokenRepository.save(registrationToken);
    }



    @Override
    @Transactional
    public Token createUpdateEmailToken(Account account) {

        Token updateEmailToken = new Token();

        //Tạo token bằng mã UUID
        Random random = new Random();
        int tokenNumber = 100000 + random.nextInt(900000); // Tạo số ngẫu nhiên từ 100000 đến 999999
        String token = String.valueOf(tokenNumber);

        updateEmailToken.setToken(token);

        updateEmailToken.setAccount(account);

        TokenType tokenType = tokenTypeService.getTokenTypeById( (byte) 4 );

        updateEmailToken.setTokenType(tokenType);

        return tokenRepository.save(updateEmailToken);
    }

    @Override
    public Token createUpdatePasswordToken(Account account) {

        Token resetPasswordToken = new Token();

        //Tạo token bằng mã UUID
        Random random = new Random();
        int tokenNumber = 100000 + random.nextInt(900000); // Tạo số ngẫu nhiên từ 100000 đến 999999
        String token = String.valueOf(tokenNumber);

        resetPasswordToken.setToken(token);

        resetPasswordToken.setAccount(account);

        TokenType tokenType = tokenTypeService.getTokenTypeById( (byte) 2 );

        resetPasswordToken.setTokenType(tokenType);

        return tokenRepository.save(resetPasswordToken);
    }


    //Xóa token
    @Override
    @Transactional
    public void deleteToken(Integer id) {
        tokenRepository.deleteById(id);
    }

}
