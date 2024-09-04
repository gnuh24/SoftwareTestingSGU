package BackEnd.Service.ProductService.Product;

import BackEnd.Entity.ProductEntity.Product;
import BackEnd.Form.ProductForm.ProductForms.*;
import org.springframework.data.domain.Page;
import org.springframework.data.domain.Pageable;

import java.io.IOException;

public interface IProductService {

    Page<Product> getAllProduct(Pageable pageable, String search, ProductFilterForm form);

    Product getProductById(Integer productId);

    int updateDefaultBrandOfProduct(Integer brandId);

    int updateDefaultCategoryOfProduct(Integer categoryId);

    Product createProduct(ProductCreateForm form) throws IOException;

    Product updateProduct(ProductUpdateForm form);

}
