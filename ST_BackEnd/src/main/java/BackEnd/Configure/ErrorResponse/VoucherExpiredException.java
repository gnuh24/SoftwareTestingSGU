package BackEnd.Configure.ErrorResponse;

public class VoucherExpiredException extends Exception{

    public VoucherExpiredException(String error){
        super(error);
    }
}
