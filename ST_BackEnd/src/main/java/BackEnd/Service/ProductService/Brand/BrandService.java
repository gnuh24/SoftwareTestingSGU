package BackEnd.Service.ProductService.Brand;

import BackEnd.Entity.ProductEntity.Brand;
import BackEnd.Form.ProductForm.BrandForm.BrandCreateForm;
import BackEnd.Form.ProductForm.BrandForm.BrandUpdateForm;
import BackEnd.Repository.ProductRepository.IBrandRepository;
import BackEnd.Service.ProductService.Product.ProductService;
import BackEnd.Specification.ProductSpecification.BrandSpecification;
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
public class BrandService implements IBrandService {

    @Autowired
    private IBrandRepository IBrandRepository;

    @Autowired
    @Lazy
    private ProductService shoeService;

    @Autowired
    private ModelMapper modelMapper;

    @Override
    public List<Brand> getAllBrandNoPaging() {

        return IBrandRepository.findAll();
    }

    @Override
    public Page<Brand> getAllBrand(Pageable pageable, String search) {
        Specification<Brand> specification = BrandSpecification.buildWhere(search);
        return IBrandRepository.findAll(specification, pageable);
    }

    @Override
    public Brand getBrandById( Integer id) {

        return IBrandRepository.findById(id).orElse(null);
    }

    @Override
    @Transactional
    public Brand createBrand(BrandCreateForm form) {
        Brand entity = modelMapper.map(form, Brand.class);
        return IBrandRepository.save(entity);
    }

    @Override
    @Transactional
    public Brand updateBrand(BrandUpdateForm form){
        Brand oldBrand = modelMapper.map(form, Brand.class);
        return IBrandRepository.save(oldBrand);
    }

    @Override
    @Transactional
    public void deleteBrand( Integer brandId) {
        shoeService.updateDefaultBrandOfProduct(brandId);
        IBrandRepository.deleteById(brandId);
    }

}
