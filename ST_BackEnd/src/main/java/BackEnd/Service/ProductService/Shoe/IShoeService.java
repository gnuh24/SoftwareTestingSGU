package BackEnd.Service.ProductService.Shoe;

import BackEnd.Entity.ProductEntity.Brand;
import BackEnd.Entity.ProductEntity.Color;
import BackEnd.Entity.ProductEntity.Shoe;
import BackEnd.Entity.ProductEntity.ShoeType;
import BackEnd.Form.ProductForm.ShoeForm.*;
import org.springframework.data.domain.Page;
import org.springframework.data.domain.Pageable;

import java.io.IOException;
import java.util.List;

public interface IShoeService {

    Page<Shoe> getAllShoe(Pageable pageable, String search, ShoeFilterForm form);

    Shoe getShoeByShoeId( Integer shoeId);

    List<Shoe> getShoeByEventId(Integer eventId);

    int updateDefaultBrandOfShoes( Integer brandId);

    int updateDefaultShoeTypeOfShoes( Integer shoeTypeId);

    Shoe updateShoe( Integer shoeId, ShoeUpdateForm form);

    Shoe createShoe(ShoeCreateForm form) throws IOException;
}
