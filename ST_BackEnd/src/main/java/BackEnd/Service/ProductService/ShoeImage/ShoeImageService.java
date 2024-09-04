package BackEnd.Service.ProductService.ShoeImage;

import BackEnd.Entity.ProductEntity.Shoe;
import BackEnd.Entity.ProductEntity.ShoeImage;
import BackEnd.Form.ProductForm.ShoeImageForm.ShoeImageCreateForm;
import BackEnd.Form.ProductForm.ShoeImageForm.ShoeImageUpdateForm;
import BackEnd.Other.ImageService.ImageService;
import BackEnd.Repository.ProductRepository.IShoeImageRepository;
import BackEnd.Service.ProductService.Shoe.IShoeService;
import org.modelmapper.ModelMapper;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.context.annotation.Lazy;
import org.springframework.stereotype.Service;
import org.springframework.transaction.annotation.Transactional;

import java.io.IOException;
import java.util.List;

@Service
public class ShoeImageService implements IShoeImageService {

    @Autowired
    private IShoeImageRepository IShoeImageRepository;

    @Autowired
    @Lazy
    private IShoeService shoeService;

    @Autowired
    private ModelMapper modelMapper;


    @Override
    public ShoeImage getShoeImageByShoeIdAndPriority( Integer shoeId, Boolean priority) {
        return IShoeImageRepository.findTopByShoe_ShoeIdAndPriority(shoeId, priority);
    }

    @Override
    public ShoeImage getShoeImageByShoeImageId(Integer shoeImageId) {
        return IShoeImageRepository.findByShoeImageId(shoeImageId);
    }


    @Override
    public List<ShoeImage> getShoeImageByShoeId( Integer shoeId) {
        return IShoeImageRepository.findByShoe_shoeId(shoeId);
    }

    @Override
    public ShoeImage createShoeImage(Shoe shoe, ShoeImageCreateForm form) throws IOException {
        ShoeImage entity = new ShoeImage();
        entity.setPriority(form.getPriority());
        entity.setPath(ImageService.saveImage(ImageService.shoeImagePath, form.getShoeImage()));
        entity.setShoe(shoe);
        return IShoeImageRepository.save(entity);
    }

    @Override
    @Transactional
    public ShoeImage createShoeImage( Integer shoeId, ShoeImageCreateForm form) throws IOException {
        ShoeImage entity = new ShoeImage();
        entity.setPriority(form.getPriority());
        entity.setPath(ImageService.saveImage(ImageService.shoeImagePath, form.getShoeImage()));
        entity.setShoe(shoeService.getShoeByShoeId(shoeId));
        return IShoeImageRepository.save(entity);
    }

    @Override
    @Transactional
    public ShoeImage updateShoeImage( Integer shoeImageId, ShoeImageUpdateForm form) throws IOException {
        ShoeImage entity = getShoeImageByShoeImageId(shoeImageId);

        if (form.getShoeImage() != null){
            ImageService.deleteImage(ImageService.shoeImagePath, entity.getPath());
            entity.setPath(ImageService.saveImage(ImageService.shoeImagePath, form.getShoeImage()));
        }

        if (form.getPriority() != null){
            entity.setPriority(form.getPriority());
        }

        return IShoeImageRepository.save(entity);
    }
}
