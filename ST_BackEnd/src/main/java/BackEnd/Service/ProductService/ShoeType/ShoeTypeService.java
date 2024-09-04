package BackEnd.Service.ProductService.ShoeType;

import BackEnd.Entity.ProductEntity.ShoeType;
import BackEnd.Form.ProductForm.ShoeTypeForm.ShoeTypeCreateForm;
import BackEnd.Form.ProductForm.ShoeTypeForm.ShoeTypeUpdateForm;
import BackEnd.Repository.ProductRepository.IShoeTypeRepository;
import BackEnd.Service.ProductService.Shoe.IShoeService;
import BackEnd.Specification.ProductSpecification.ShoeTypeSpecification;
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
public class ShoeTypeService implements IShoeTypeService {

    @Autowired
    private IShoeTypeRepository shoeTypeRepository;

    @Autowired
    @Lazy
    private IShoeService shoeService;

    @Autowired
    private ModelMapper modelMapper;



    @Override
    public List<ShoeType> getAllShoeTypeNoPaging() {
        return shoeTypeRepository.findAll();
    }

    @Override
    public Page<ShoeType> getAllShoeType(Pageable pageable, String search) {
        Specification<ShoeType> specification = ShoeTypeSpecification.buildWhere(search);
        return shoeTypeRepository.findAll(specification, pageable);
    }

    @Override
    public ShoeType getShoeTypeById( Integer id) {
        return shoeTypeRepository.findById( id ).get();
    }

    @Override
    @Transactional
    public ShoeType createShoeType(ShoeTypeCreateForm form) {
        ShoeType entity = modelMapper.map(form, ShoeType.class);
        return shoeTypeRepository.save(entity);
    }

    @Override
    @Transactional
    public ShoeType updateShoeType(ShoeTypeUpdateForm form) {
        ShoeType entity = modelMapper.map(form, ShoeType.class);
        return shoeTypeRepository.save(entity);
    }

    @Override
    @Transactional
    public void deleteShoeType( Integer shoeTypeId) {
        shoeService.updateDefaultShoeTypeOfShoes(shoeTypeId);
        shoeTypeRepository.deleteById(shoeTypeId);
    }


}
