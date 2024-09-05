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
    public Product createProduct(ProductCreateForm form) throws IOException {

        Product entity = new Product();

        entity.setProductName(form.getProductName());
        entity.setPrice(form.getPrice());
        String path = CloundinaryServices.createImageFromMultipart(form.getImage());

        if (path != null){
            entity.setImage(path);
        }else{
            System.err.println("Lỗi Clound");
        }


        entity.setDescription(form.getDescription());
        entity.setAbv(form.getAbv());
        entity.setCapacity(form.getCapacity());
        entity.setOrigin(form.getOrigin());

        Brand brand = brandService.getBrandById(form.getBrandId());
        entity.setBrand(brand);

        Category category = categoryService.getCategoryById(form.getCategoryId());
        entity.setCategory(category);

        return productRepository.save(entity);
    }

    @Override
    @Transactional
    public Product updateProduct(ProductUpdateForm form) {
        // Fetch the existing product from the repository
        Product oldProduct = getProductById(form.getId());

        // Update fields if they are not null
        if (form.getProductName() != null) {
            oldProduct.setProductName(form.getProductName());
        }
        if (form.getStatus() != null) {
            oldProduct.setStatus(form.getStatus());
        }
        if (form.getImage() != null) {
            CloundinaryServices.deleteImage(oldProduct.getImage());
            oldProduct.setImage(
                CloundinaryServices.createImageFromMultipart(form.getImage())
            );
        }
        if (form.getPrice() != null) {
            oldProduct.setPrice(form.getPrice());
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
