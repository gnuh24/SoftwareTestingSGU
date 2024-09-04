package BackEnd.Service.ProductService.ShoeColorServices;

import BackEnd.Entity.ProductEntity.ShoeColor;
import BackEnd.Entity.ProductEntity.ShoeColor.ShoeColorId;
import BackEnd.Form.ProductForm.ShoeColorForms.ShoeColorCreateForm;
import BackEnd.Form.ProductForm.ShoeColorForms.ShoeColorCreateFormForCreateShoe;

import java.util.List;
import java.util.Optional;

public interface IShoeColorService {
    ShoeColor createShoeColor(ShoeColorCreateForm shoeColor);
    void deleteShoeColor(ShoeColorId id);
    void deleteShoeColorByColorId( Integer colorId);

}

