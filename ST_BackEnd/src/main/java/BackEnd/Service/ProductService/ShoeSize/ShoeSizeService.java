package BackEnd.Service.ProductService.ShoeSize;

import BackEnd.Entity.ProductEntity.Shoe;
import BackEnd.Entity.ProductEntity.ShoeSize;
import BackEnd.Form.ProductForm.ShoeSizeForm.ShoeSizeCreateForm;
import BackEnd.Form.ProductForm.ShoeSizeForm.ShoeSizeUpdateForm;
import BackEnd.Repository.ProductRepository.IShoeSizeRepository;
import BackEnd.Service.ProductService.Shoe.IShoeService;
import org.modelmapper.ModelMapper;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.context.annotation.Lazy;
import org.springframework.stereotype.Service;
import org.springframework.transaction.annotation.Transactional;

import java.util.List;

@Service
public class ShoeSizeService implements IShoeSizeService {

    @Autowired
    private IShoeSizeRepository shoeSizeRepository;

    @Autowired
    @Lazy
    private IShoeService shoeService;

    @Autowired
    private ModelMapper modelMapper;


    @Override
    public List<ShoeSize> getAllShoeSizeByShoeId( Integer shoeId) {
        return shoeSizeRepository.findByShoe_ShoeId(shoeId);
    }

    @Override
    public List<ShoeSize> getAllShoeSizeByShoeIdAndStatus( Integer shoeId, Boolean status) {
        return shoeSizeRepository.findByShoe_ShoeIdAndStatus(shoeId, status);
    }

    @Override
    public Byte getNumberOfSize( Integer shoeId) {
        return shoeSizeRepository.countNumberOfSize(shoeId);
    }

    @Override
    public Integer getTheLowestPrice( Integer shoeId) {
        return shoeSizeRepository.getTheLowestPriceOfShoe(shoeId);
    }

    @Override
    public List<Byte> getTop3SizeOfShoe( Integer shoeId){
        return shoeSizeRepository.get3BiggestSizeOfShoe(shoeId);
    }

    @Override
    public ShoeSize getShoeSizeById( Integer shoeId, Byte size) {
        return shoeSizeRepository.findByShoe_ShoeIdAndIdSize(shoeId, size);
    }


    @Override
    @Transactional
    public ShoeSize createShoeSize( Integer shoeId, ShoeSizeCreateForm form) {

        // Find the Shoe entity by shoeId
        Shoe shoe = shoeService.getShoeByShoeId(shoeId);

        // Map form data to ShoeSize entity
        ShoeSize entity = modelMapper.map(form, ShoeSize.class);

        // Create the composite key
        ShoeSize.ShoeSizeId id = new ShoeSize.ShoeSizeId(shoeId, form.getSize());
        entity.setId(id);

        // Set the Shoe entity
        entity.setShoe(shoe);

        // Save the ShoeSize entity
        return shoeSizeRepository.save(entity);
    }



    @Override
    @Transactional
    public ShoeSize updateShoeSize(ShoeSizeUpdateForm form) {

        ShoeSize shoeSize = getShoeSizeById(form.getIdShoeId(), form.getIdSize());

        if (form.getPrice() != null){
            shoeSize.setPrice(form.getPrice());
        }

        if (form.getQuantity() != null){
            shoeSize.setQuantity(form.getQuantity());
        }

        if (form.getStatus() != null){
            shoeSize.setStatus(form.getStatus());
        }

        return shoeSizeRepository.save(shoeSize);
    }
}
