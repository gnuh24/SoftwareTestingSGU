package BackEnd.Configure.ErrorResponse;

public class TokenNotExists extends Exception{
    public TokenNotExists(String error){
        super(error);
    }
}
