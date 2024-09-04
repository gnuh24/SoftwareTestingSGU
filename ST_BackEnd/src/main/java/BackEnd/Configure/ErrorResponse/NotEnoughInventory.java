package BackEnd.Configure.ErrorResponse;

public class NotEnoughInventory extends Exception{

    public NotEnoughInventory(String message) {
        super(message);
    }
}
