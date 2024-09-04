package BackEnd.Service.ProductService.ShoeType;

import BackEnd.Entity.ProductEntity.ShoeType;
import BackEnd.Form.ProductForm.ShoeTypeForm.ShoeTypeCreateForm;
import BackEnd.Form.ProductForm.ShoeTypeForm.ShoeTypeUpdateForm;
import org.springframework.data.domain.Page;
import org.springframework.data.domain.Pageable;

import java.util.List;

public interface IShoeTypeService {

    List<ShoeType> getAllShoeTypeNoPaging();

    Page<ShoeType> getAllShoeType(Pageable pageable, String search);

    ShoeType getShoeTypeById( Integer id);

    ShoeType createShoeType(ShoeTypeCreateForm form);

    ShoeType updateShoeType(ShoeTypeUpdateForm form);

    void deleteShoeType( Integer shoeTypeId);

}
