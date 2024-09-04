package BackEnd.Configure.ErrorResponse;

public class InvalidToken extends Exception{

    public InvalidToken(String message) {
        super(message);
    }
}
