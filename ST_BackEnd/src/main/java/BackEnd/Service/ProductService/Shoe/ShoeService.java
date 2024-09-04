package BackEnd.Service.ProductService.Shoe;

import BackEnd.Entity.ProductEntity.Brand;
import BackEnd.Entity.ProductEntity.Color;
import BackEnd.Entity.ProductEntity.Shoe;
import BackEnd.Entity.ProductEntity.ShoeType;
import BackEnd.Form.ProductForm.ShoeColorForms.ShoeColorCreateForm;
import BackEnd.Form.ProductForm.ShoeColorForms.ShoeColorCreateFormForCreateShoe;
import BackEnd.Form.ProductForm.ShoeColorForms.ShoeColorDTO;
import BackEnd.Form.ProductForm.ShoeForm.*;
import BackEnd.Form.ProductForm.ShoeImageForm.ShoeImageCreateForm;
import BackEnd.Form.ProductForm.ShoeSizeForm.ShoeSizeCreateForm;
import BackEnd.Repository.ProductRepository.IShoeRepository;
import BackEnd.Service.ProductService.Brand.IBrandService;
import BackEnd.Service.ProductService.ColorServices.IColorService;
import BackEnd.Service.ProductService.ShoeColorServices.IShoeColorService;
import BackEnd.Service.ProductService.ShoeImage.IShoeImageService;
import BackEnd.Service.ProductService.ShoeSize.IShoeSizeService;
import BackEnd.Service.ProductService.ShoeType.IShoeTypeService;
import BackEnd.Service.ShoppingServices.EventServices.IEventService;
import BackEnd.Specification.ProductSpecification.ShoeSpecification;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.data.domain.Page;
import org.springframework.data.domain.Pageable;
import org.springframework.data.jpa.domain.Specification;
import org.springframework.stereotype.Service;
import org.springframework.transaction.annotation.Transactional;

import java.io.IOException;
import java.util.List;

@Service
public class ShoeService implements IShoeService {

    @Autowired
    private IShoeRepository shoeRepository;

    @Autowired
    private IBrandService brandService;

    @Autowired
    private IColorService colorService;

    @Autowired
    private IShoeColorService shoeColorService;

    @Autowired
    private IShoeTypeService shoeTypeService;

    @Autowired
    private IShoeSizeService shoeSizeService;

    @Autowired
    private IShoeImageService shoeImageService;

    @Autowired
    private IEventService eventService;



    @Override
    public Page<Shoe> getAllShoe(Pageable pageable, String search, ShoeFilterForm form) {
        Specification<Shoe> where = ShoeSpecification.buildWhere(search, form);
        return shoeRepository.findAll(where, pageable);
    }

    @Override
    public Shoe getShoeByShoeId( Integer shoeId) {
        return shoeRepository.findById(shoeId).get();
    }


    @Override
    public List<Shoe> getShoeByEventId(Integer eventId) {
        return shoeRepository.findShoesByEventId(eventId);
    }

    @Override
    public int updateDefaultBrandOfShoes( Integer brandId) {
        return shoeRepository.updateBrandToDefault(brandId);
    }

    @Override
    public int updateDefaultShoeTypeOfShoes( Integer shoeTypeId) {
        return shoeRepository.updateShoeTypeToDefault(shoeTypeId);
    }


    public List<Shoe> getAllShoeByListId(List<Integer> listId) {
        return shoeRepository.findAllById(listId);
    }

    @Override
    @Transactional
    public Shoe createShoe(ShoeCreateForm form) throws IOException {

        Shoe entity = new Shoe();
        entity.setShoeName(form.getShoeName());
        entity.setDescription(form.getDescription());
        entity.setPriority(form.getPriority());
        entity.setStatus(form.getStatus());

        Brand brand = brandService.getBrandById(form.getBrandId());
        entity.setBrand(brand);

        ShoeType shoeType = shoeTypeService.getShoeTypeById(form.getShoeTypeId());
        entity.setShoeType(shoeType);

        entity = shoeRepository.save(entity);

        for (ShoeColorCreateFormForCreateShoe shoeColorDTO: form.getShoeColors()){
            ShoeColorCreateForm form1 = new ShoeColorCreateForm(shoeColorDTO.getColorId(), entity.getShoeId());
            shoeColorService.createShoeColor(form1);
        }

        for (ShoeSizeCreateForm shoeSizeCreateForm: form.getShoeSizes()) {
            shoeSizeService.createShoeSize(entity.getShoeId(), shoeSizeCreateForm);
        }

        for (ShoeImageCreateForm shoeImageCreateForm: form.getShoeImages()) {
            shoeImageService.createShoeImage(entity, shoeImageCreateForm);
        }

        return entity;
    }

    @Override
    @Transactional
    public Shoe updateShoe( Integer shoeId, ShoeUpdateForm form) {
        Shoe oldShoe = getShoeByShoeId(shoeId);

        if (form.getShoeName() != null) {
            oldShoe.setShoeName(form.getShoeName());
        }
        if (form.getStatus() != null) {
            oldShoe.setStatus(form.getStatus());
        }
        if (form.getDescription() != null) {
            oldShoe.setDescription(form.getDescription());
        }
        if (form.getPriority() != null) {
            oldShoe.setPriority(form.getPriority());
        }
        if (form.getBrandId() != null) {
            Brand newBrand = brandService.getBrandById(form.getBrandId());
            oldShoe.setBrand(newBrand);
        }
        if (form.getShoeTypeId() != null) {
            ShoeType shoeType = shoeTypeService.getShoeTypeById(form.getShoeTypeId());
            oldShoe.setShoeType(shoeType);
        }
        return shoeRepository.save(oldShoe);
    }


//    @Override
//    @Transactional
//    public List<Shoe> updateBrandOfShoes(ShoeUpdateBrandForm form){
//
//        List<Shoe> shoes = getAllShoeByListId(form.getShoesId());
//
//        Brand newBrand = brandService.getBrandById(form.getBrandId());
//
//        for (Shoe shoe: shoes){
//            shoe.setBrand(newBrand);
//        }
//
//        return shoeRepository.saveAll(shoes);
//    }
//
//    @Override
//    @Transactional
//    public List<Shoe> updateShoeTypeOfShoes(ShoeUpdateShoeTypeForm form) {
//        List<Shoe> shoes = getAllShoeByListId(form.getShoesId());
//
//        ShoeType newShoeType = shoeTypeService.getShoeTypeById(form.getShoeTypeId());
//
//        for (Shoe shoe: shoes){
//            shoe.setShoeType(newShoeType);
//        }
//
//        return shoeRepository.saveAll(shoes);
//    }



}
