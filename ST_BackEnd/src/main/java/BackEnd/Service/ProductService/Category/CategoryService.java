package BackEnd.Service.ProductService.Category;

import BackEnd.Entity.ProductEntity.Category;
import BackEnd.Form.ProductForm.CategoryForms.CategoryCreateForm;
import BackEnd.Form.ProductForm.CategoryForms.CategoryUpdateForm;
import BackEnd.Repository.ProductRepository.ICategoryRepository;
import BackEnd.Service.ProductService.Product.IProductService;
import BackEnd.Specification.ProductSpecification.CategorySpecification;
import org.modelmapper.ModelMapper;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.context.annotation.Lazy;
import org.springframework.data.domain.Page;
import org.springframework.data.domain.Pageable;
import org.springframework.data.jpa.domain.Specification;
import org.springframework.stereotype.Service;
import org.springframework.transaction.annotation.Transactional;

import java.util.List;

@Service
public class CategoryService implements ICategoryService {

    @Autowired
    private ICategoryRepository categoryRepository;

    @Autowired
    @Lazy
    private IProductService shoeService;

    @Autowired
    private ModelMapper modelMapper;


    @Override
    public List<Category> getAllCategoryNoPaging() {
        return categoryRepository.findAll();
    }

    @Override
    public Page<Category> getAllCategory(Pageable pageable, String search) {
        Specification<Category> specification = CategorySpecification.buildWhere(search);
        return categoryRepository.findAll(specification, pageable);
    }

    @Override
    public Category getCategoryById(Integer id) {
        return categoryRepository.findById( id ).orElse(null);
    }

    @Override
    @Transactional
    public Category createCategory(CategoryCreateForm form) {
        Category entity = modelMapper.map(form, Category.class);
        return categoryRepository.save(entity);
    }

    @Override
    @Transactional
    public Category updateCategory(CategoryUpdateForm form) {
        Category entity = modelMapper.map(form, Category.class);
        return categoryRepository.save(entity);
    }

    @Override
    @Transactional
    public void deleteCategory(Integer categoryId) {
        shoeService.updateDefaultCategoryOfProduct(categoryId);
        categoryRepository.deleteById(categoryId);
    }


}
