package BackEnd.Service.ProductService.Product;

import BackEnd.Entity.ProductEntity.Brand;
import BackEnd.Entity.ProductEntity.Category;
import BackEnd.Entity.ProductEntity.Product;
import BackEnd.Form.ProductForm.ProductForms.*;
import BackEnd.Other.CloundinaryServices;
import BackEnd.Repository.ProductRepository.IProductRepository;
import BackEnd.Service.ProductService.Brand.IBrandService;
import BackEnd.Service.ProductService.Category.ICategoryService;
import BackEnd.Specification.ProductSpecification.ProductSpecification;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.data.domain.Page;
import org.springframework.data.domain.Pageable;
import org.springframework.data.jpa.domain.Specification;
import org.springframework.stereotype.Service;
import org.springframework.transaction.annotation.Transactional;

import java.io.IOException;

@Service
public class ProductService implements IProductService {

    @Autowired
    private IProductRepository productRepository;

    @Autowired
    private IBrandService brandService;


    @Autowired
    private ICategoryService categoryService;


    @Override
    public Page<Product> getAllProduct(Pageable pageable, String search, ProductFilterForm form) {
        Specification<Product> where = ProductSpecification.buildWhere(search, form);
        return productRepository.findAll(where, pageable);
    }

    @Override
    public Product getProductById(Integer productId) {
        return productRepository.findById(productId).orElse(null);
    }


    @Override
    public int updateDefaultBrandOfProduct(Integer brandId) {
        return productRepository.updateBrandToDefault(brandId);
    }

    @Override
    public int updateDefaultCategoryOfProduct(Integer categoryId) {
        return productRepository.updateCategoryToDefault(categoryId);
    }

    @Override
    @Transactional
    public Product createProduct(ProductCreateForm form){

        Product entity = new Product();

        entity.setProductName(form.getProductName());

        Brand brand = brandService.getBrandById(1);
        entity.setBrand(brand);

        Category category = categoryService.getCategoryById(1);
        entity.setCategory(category);

        return productRepository.save(entity);
    }

    @Override
    @Transactional
    public Product updateProduct(ProductUpdateForm form) {
        // Fetch the existing product from the repository
        Product oldProduct = getProductById(form.getId());

        // Update fields if they are not null


        if (form.getStatus() != null) {
            oldProduct.setStatus(form.getStatus());
        }
        if (form.getImage() != null) {
            if (oldProduct.getImage() != null){
                CloundinaryServices.deleteImage(oldProduct.getImage());
            }
            oldProduct.setImage(
                CloundinaryServices.createImageFromMultipart(form.getImage())
            );
        }

        if (form.getOrigin() != null) {
            oldProduct.setOrigin(form.getOrigin());
        }
        if (form.getCapacity() != null) {
            oldProduct.setCapacity(form.getCapacity());
        }
        if (form.getAbv() != null) {
            oldProduct.setAbv(form.getAbv());
        }
        if (form.getDescription() != null) {
//            if (form.getDescription().equals("")){
//                oldProduct.setDescription("Không có mô tả nào cho sản phẩm trên");
//            }
            oldProduct.setDescription(form.getDescription());
        }
        if (form.getBrandId() != null) {
            Brand newBrand = brandService.getBrandById(form.getBrandId());
            oldProduct.setBrand(newBrand);
        }
        if (form.getCategoryId() != null) {
            Category newCategory = categoryService.getCategoryById(form.getCategoryId());
            oldProduct.setCategory(newCategory);
        }

        // Save the updated product
        return productRepository.save(oldProduct);
    }


}
