package BackEnd.Controller.ProductController;

import BackEnd.Entity.ProductEntity.Batch;
import BackEnd.Entity.ProductEntity.Product;
import BackEnd.Form.ProductForm.ProductForms.*;
import BackEnd.Service.ProductService.Batch.IBatchService;
import BackEnd.Service.ProductService.Product.IProductService;
import jakarta.validation.Valid;
import org.modelmapper.ModelMapper;
import org.modelmapper.TypeToken;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.data.domain.Page;
import org.springframework.data.domain.PageImpl;
import org.springframework.data.domain.Pageable;
import org.springframework.web.bind.annotation.*;

import java.io.IOException;
import java.util.List;

@RestController
@RequestMapping(value = "/Product")
@CrossOrigin(origins = "*")
public class ProductController {

    @Autowired
    private IProductService productService;

    @Autowired
    private IBatchService batchService;

    @Autowired
    private ModelMapper modelMapper;


    @GetMapping(value = "/Admin")
    // API Sử dụng cho chức năng QL Tài khoản (Admin - Xem dưới dạng danh sách)
    public Page<ProductDTOListAdmin> getAllShoeForAdmin(Pageable pageable,
                                                        @RequestParam(name = "search", required = false) String search,
                                                        ProductFilterForm form) {
        // Lấy từ Database
        Page<Product> entites = productService.getAllProduct(pageable, search, form);

        // Chuyển sang List DTO
        List<ProductDTOListAdmin> dtos = modelMapper.map(entites.getContent(), new TypeToken<List<ProductDTOListAdmin>>() {
        }.getType());


        for (ProductDTOListAdmin dtoListAdmin: dtos){
            Batch batch = batchService.getTheValidBatch(dtoListAdmin.getId());

            if (batch == null){
                batch = batchService.getTheValidBatchBackup(dtoListAdmin.getId());
            }

            dtoListAdmin.setPrice(batch.getUnitPrice());
            dtoListAdmin.setQuantity(batch.getQuantity());
        }


        // Trả về FrontEnd với định dạng Page (Tích họp Sort, Paging)
        return new PageImpl<>(dtos, pageable, entites.getTotalElements());
    }


    @GetMapping(value = "/Admin/{shoeId}")
    // API Sử dụng cho chức năng QL Tài khoản (Admin - Xem chi tiết 1 sản phẩm)
    public ProductDTODetailAdmin getShoeInDetailForAdmin(@PathVariable Integer shoeId) {
        Product entity = productService.getProductById(shoeId);
        return modelMapper.map(entity, ProductDTODetailAdmin.class);
    }


    @GetMapping(value = "/CommonUser")
    // API Sử dụng cho chức năng Xem các sản phẩm bầy bán (User - Xem dưới dạng danh
    // sách)
    public Page<ProductDTOListUser> getAllShoeForUser(Pageable pageable,
                                                      @RequestParam(name = "search", required = false) String search,
                                                      ProductFilterForm form) {
        form.setStatus(true);

        // Lấy từ Database
        Page<Product> entites = productService.getAllProduct(pageable, search, form);
        // Chuyển sang List DTO
        List<ProductDTOListUser> dtos = modelMapper.map(entites.getContent(), new TypeToken<List<ProductDTOListUser>>() {
        }.getType());

        for (ProductDTOListUser dtoListAdmin: dtos){
            Batch batch = batchService.getTheValidBatch(dtoListAdmin.getId());

            if (batch == null){
                batch = batchService.getTheValidBatchBackup(dtoListAdmin.getId());
            }

            dtoListAdmin.setPrice(batch.getUnitPrice());
        }



        // Trả về FrontEnd với định dạng Page (Tích họp Sort, Paging)
        return new PageImpl<>(dtos, pageable, entites.getTotalElements());
    }

    @GetMapping(value = "/CommonUser/{shoeId}")
    // API Sử dụng cho chức năng QL Tài khoản (Admin - Xem chi tiết 1 sản phẩm)
    public ProductDTODetailUser getShoeInDetailForUser(@PathVariable Integer shoeId) {

        Product entity = productService.getProductById(shoeId);

        ProductDTODetailUser dto = modelMapper.map(entity, ProductDTODetailUser.class);

            Batch batch = batchService.getTheValidBatch(dto.getId());

            if (batch == null){
                batch = batchService.getTheValidBatchBackup(dto.getId());
            }

            dto.setPrice(batch.getUnitPrice());
            dto.setQuantity(batch.getQuantity());


        return dto;

    }


    @PostMapping()
    public ProductDTOListAdmin createShoe(@ModelAttribute @Valid ProductCreateForm form) throws IOException {
        Product entity = productService.createProduct(form);
        return modelMapper.map(entity, ProductDTOListAdmin.class);
    }

    @PatchMapping()
    public ProductDTOListAdmin updateShoe(@ModelAttribute @Valid ProductUpdateForm form) {
        Product entity = productService.updateProduct(form);
        return modelMapper.map(entity, ProductDTOListAdmin.class);
    }

}
