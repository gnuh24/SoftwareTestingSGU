package BackEnd.Service.ProductService.ColorServices;

import BackEnd.Entity.ProductEntity.Color;
import BackEnd.Form.ProductForm.ColorForm.ColorCreateForm;
import BackEnd.Form.ProductForm.ColorForm.ColorUpdateForm;
import org.springframework.data.domain.Page;
import org.springframework.data.domain.Pageable;

import java.util.List;

public interface IColorService {
    List<Color> getAllShoeColorNoPaging();

    List<Color> getAllColorByShoeId( Integer shoeId);

    Page<Color> getAllShoeColor(Pageable pageable, String search);

    Color getShoeColorById( Integer id);

    Color createShoeColor(ColorCreateForm form);

    Color updateShoeColor(ColorUpdateForm form);

    void deleteShoeColor( Integer shoeColorId);
}
