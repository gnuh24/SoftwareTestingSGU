package BackEnd.Service.ProductService.Category;

import BackEnd.Entity.ProductEntity.Category;
import BackEnd.Form.ProductForm.CategoryForms.CategoryCreateForm;
import BackEnd.Form.ProductForm.CategoryForms.CategoryUpdateForm;
import org.springframework.data.domain.Page;
import org.springframework.data.domain.Pageable;

import java.util.List;

public interface ICategoryService {

    List<Category> getAllCategoryNoPaging();

    Page<Category> getAllCategory(Pageable pageable, String search);

    Category getCategoryById(Integer id);

    Category createCategory(CategoryCreateForm form) throws Exception;

    Category updateCategory(CategoryUpdateForm form) throws Exception;

    void deleteCategory(Integer categoryId);

}
