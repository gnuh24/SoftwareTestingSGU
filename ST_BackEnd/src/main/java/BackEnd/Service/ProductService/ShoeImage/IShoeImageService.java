package BackEnd.Service.ProductService.ShoeImage;


import BackEnd.Entity.ProductEntity.Shoe;
import BackEnd.Entity.ProductEntity.ShoeImage;
import BackEnd.Form.ProductForm.ShoeImageForm.ShoeImageCreateForm;
import BackEnd.Form.ProductForm.ShoeImageForm.ShoeImageUpdateForm;

import java.io.IOException;
import java.util.List;

public interface IShoeImageService {

    ShoeImage getShoeImageByShoeIdAndPriority( Integer shoeId, Boolean priority);

    ShoeImage getShoeImageByShoeImageId( Integer shoeImageId);

    List<ShoeImage> getShoeImageByShoeId( Integer shoeId);

    ShoeImage createShoeImage(Shoe shoe, ShoeImageCreateForm form) throws IOException;

    ShoeImage createShoeImage( Integer shoeId, ShoeImageCreateForm form) throws IOException;

    ShoeImage updateShoeImage( Integer shoeImageId, ShoeImageUpdateForm form) throws IOException;

}
