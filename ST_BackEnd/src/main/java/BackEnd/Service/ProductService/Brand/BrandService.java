package BackEnd.Service.ProductService.Brand;

import BackEnd.Entity.ProductEntity.Brand;
import BackEnd.Form.ProductForm.BrandForm.BrandCreateForm;
import BackEnd.Form.ProductForm.BrandForm.BrandUpdateForm;
import BackEnd.Other.ImageService.ImageService;
import BackEnd.Repository.ProductRepository.IBrandRepository;
import BackEnd.Service.ProductService.Shoe.ShoeService;
import BackEnd.Specification.ProductSpecification.BrandSpecification;
import org.modelmapper.ModelMapper;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.context.annotation.Lazy;
import org.springframework.data.domain.Page;
import org.springframework.data.domain.Pageable;
import org.springframework.data.jpa.domain.Specification;
import org.springframework.stereotype.Service;
import org.springframework.transaction.annotation.Transactional;

import java.io.IOException;
import java.util.List;


@Service
public class BrandService implements IBrandService {
    @Autowired
    private IBrandRepository IBrandRepository;

    @Autowired
    @Lazy
    private ShoeService shoeService;

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
    public Brand createBrand(BrandCreateForm form) throws IOException {

        //Tạo đối tượng
        Brand entity = new Brand();
        entity.setBrandName(form.getBrandName());

        //Lưu ảnh vào Folder rồi trả về tên ảnh
        entity.setLogo(ImageService.saveImage(ImageService.brandLogoPath, form.getLogo()));
        return IBrandRepository.save(entity);

    }

    @Override
    @Transactional
    /*
        IDEA Update:
        1. Kiểm tra xem thông tin mới truyền vào có thiếu trường nào không ?
            -> CHỉ xử lý những trường mới được đưa vào
        2. Đối với xử lý ảnh. Ta sẽ lưu ảnh mới vào (Ảnh cũ vẫn tồn tại trong Server)
    */
    public Brand updateBrand(BrandUpdateForm form) throws IOException {
        Brand oldBrand = getBrandById(form.getBrandId());

        if (form.getBrandName() != null){
            oldBrand.setBrandName(form.getBrandName());
        }

        if (form.getLogo() != null){
            String newLogoPath = ImageService.saveImage(ImageService.brandLogoPath, form.getLogo());
            ImageService.deleteImage(ImageService.brandLogoPath, oldBrand.getLogo());
            oldBrand.setLogo(newLogoPath);
        }

        return IBrandRepository.save(oldBrand);
    }

    @Override
    @Transactional
    /*
        Lưu ý khi xóa thương hiệu
        1. Chuyển tất cả các "Shoe" có khóa ngoại tới "Brand" cần xóa sang "Brand mặc định" (ID = 1)
        2. Xóa ảnh trong Server
        3. Xóa "Brand" khỏi database
     */
    public void deleteBrand( Integer brandId) {
        shoeService.updateDefaultBrandOfShoes(brandId);
        Brand oldBrand = getBrandById(brandId);
        ImageService.deleteImage(ImageService.brandLogoPath, oldBrand.getLogo());
        IBrandRepository.delete(oldBrand);
    }

}
