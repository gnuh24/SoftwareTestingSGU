package BackEnd.Service.ProductService.ShoeSize;

import BackEnd.Entity.ProductEntity.ShoeSize;
import BackEnd.Form.ProductForm.ShoeSizeForm.ShoeSizeCreateForm;
import BackEnd.Form.ProductForm.ShoeSizeForm.ShoeSizeUpdateForm;

import java.util.List;

public interface IShoeSizeService {
    List<ShoeSize> getAllShoeSizeByShoeId( Integer shoeId);

    List<ShoeSize> getAllShoeSizeByShoeIdAndStatus( Integer shoeId, Boolean status);

    Byte getNumberOfSize(  Integer shoeId);

    Integer getTheLowestPrice( Integer shoeId);

    List<Byte> getTop3SizeOfShoe( Integer shoeId);

    ShoeSize getShoeSizeById( Integer shoeId, Byte size);

    ShoeSize createShoeSize( Integer shoeId, ShoeSizeCreateForm form);

    ShoeSize updateShoeSize(ShoeSizeUpdateForm form);

}
