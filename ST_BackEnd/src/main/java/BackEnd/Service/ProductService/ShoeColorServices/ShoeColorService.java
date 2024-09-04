package BackEnd.Service.ProductService.ShoeColorServices;

import BackEnd.Entity.ProductEntity.ShoeColor;
import BackEnd.Form.ProductForm.ShoeColorForms.ShoeColorCreateForm;
import BackEnd.Form.ProductForm.ShoeColorForms.ShoeColorCreateFormForCreateShoe;
import BackEnd.Repository.ProductRepository.IShoeColorRepository;
import org.modelmapper.ModelMapper;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;
import org.springframework.transaction.annotation.Transactional;

import java.util.List;

@Service
public class ShoeColorService implements IShoeColorService {

    @Autowired
    private IShoeColorRepository shoeColorRepository;

    @Autowired
    private ModelMapper modelMapper;


    @Override
    @Transactional
    public ShoeColor createShoeColor(ShoeColorCreateForm shoeColorForm) {
        ShoeColor shoeColor = modelMapper.map(shoeColorForm, ShoeColor.class);
        return shoeColorRepository.save(shoeColor);
    }


    @Override
    @Transactional
    public void deleteShoeColor(ShoeColor.ShoeColorId id) {
        shoeColorRepository.deleteById(id);
    }

    @Override
    @Transactional
    public void deleteShoeColorByColorId( Integer colorId){
        shoeColorRepository.deleteByColorId(colorId);
    }


}
