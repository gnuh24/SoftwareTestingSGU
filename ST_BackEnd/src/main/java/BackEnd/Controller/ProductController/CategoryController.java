package BackEnd.Controller.ProductController;

import BackEnd.Entity.ProductEntity.Category;
import BackEnd.Form.ProductForm.CategoryForms.CategoryCreateForm;
import BackEnd.Form.ProductForm.CategoryForms.CategoryDTO;
import BackEnd.Form.ProductForm.CategoryForms.CategoryUpdateForm;
import BackEnd.Service.ProductService.Category.ICategoryService;
import jakarta.validation.Valid;
import org.modelmapper.ModelMapper;
import org.modelmapper.TypeToken;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.data.domain.Page;
import org.springframework.data.domain.PageImpl;
import org.springframework.data.domain.Pageable;
import org.springframework.web.bind.annotation.*;

import java.util.List;

@RestController
@RequestMapping(value = "/Category")
@CrossOrigin(origins = "*")
public class CategoryController {

    @Autowired
    private ICategoryService categoryService; // Thay thế shoeTypeService bằng categoryService

    @Autowired
    private ModelMapper modelMapper;

    @GetMapping(value = "/noPaging")
    //API lấy danh sách `Category` phiên bản không paging dành cho các Combobox
    public List<CategoryDTO> getAllCategoryNoPaging() { // Thay thế getAllShoeTypeNoPaging bằng getAllCategoryNoPaging

        //  1. Lấy dữ liệu từ Service
        List<Category> list = categoryService.getAllCategoryNoPaging(); // Thay thế shoeTypeService bằng categoryService

        // 2. Dùng Model Mapper để chuyển từ list Category -> list CategoryDTO
        return modelMapper.map(list, new TypeToken<List<CategoryDTO>>(){}.getType());
    }

    @GetMapping()
    //API lấy toàn bộ danh sách bao gồm cả Paing dành cho Admin
    public Page<CategoryDTO> getAllCategory(Pageable pageable,
                                            @RequestParam(name = "search", required = false) String search) { // Thay thế getAllShoeType bằng getAllCategory

        // 1. Lấy toàn bộ danh sách `Category` theo yêu cầu
        Page<Category> entities = categoryService.getAllCategory(pageable, search); // Thay thế shoeTypeService bằng categoryService

        // 2. Chuyển thành List DTO
        List<CategoryDTO> dtos = modelMapper.map(entities.getContent(), new TypeToken<List<CategoryDTO>>(){}.getType());

        // 3. Trả về phiên bản Page DTO
        return new PageImpl<>(dtos, pageable, entities.getTotalElements());
    }

    @GetMapping(value = "/{categoryId}")
    public CategoryDTO getCategoryById(@PathVariable Integer categoryId) { // Thay thế getShoeTypeById bằng getCategoryById
        Category entity = categoryService.getCategoryById(categoryId); // Thay thế shoeTypeService bằng categoryService
        return modelMapper.map(entity, CategoryDTO.class);
    }

    @PostMapping()
    public CategoryDTO createCategory(@ModelAttribute @Valid CategoryCreateForm form) { // Thay thế createShoeType bằng createCategory
        Category entity = categoryService.createCategory(form); // Thay thế shoeTypeService bằng categoryService
        return modelMapper.map(entity, CategoryDTO.class);
    }

    @PatchMapping()
    public CategoryDTO updateCategory(@ModelAttribute @Valid CategoryUpdateForm form) { // Thay thế updateShoeType bằng updateCategory
        Category entity = categoryService.updateCategory(form); // Thay thế shoeTypeService bằng categoryService
        return modelMapper.map(entity, CategoryDTO.class);
    }

    @DeleteMapping(value = "/{categoryId}")
    public void deleteCategory(@PathVariable Integer categoryId) { // Thay thế deleteShoeType bằng deleteCategory
        categoryService.deleteCategory(categoryId); // Thay thế shoeTypeService bằng categoryService
    }
}
