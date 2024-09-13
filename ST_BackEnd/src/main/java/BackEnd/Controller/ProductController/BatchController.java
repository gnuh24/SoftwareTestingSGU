package BackEnd.Controller.ProductController;

import BackEnd.Entity.ProductEntity.Batch;
import BackEnd.Form.ProductForm.BatchForms.BatchCreateForm;
import BackEnd.Form.ProductForm.BatchForms.BatchDTO;
import BackEnd.Form.ProductForm.BatchForms.BatchUpdateForm;
import BackEnd.Service.ProductService.Batch.IBatchService;
import jakarta.validation.Valid;
import org.modelmapper.ModelMapper;
import org.modelmapper.TypeToken;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.web.bind.annotation.*;

import java.util.List;

@RestController
@RequestMapping("/Batch")
public class BatchController {

    @Autowired
    private IBatchService batchService;

    @Autowired
    private ModelMapper modelMapper;

    @PostMapping()
    public BatchDTO createBatch(@ModelAttribute @Valid BatchCreateForm form) {
        return modelMapper.map(batchService.createBatch(form), BatchDTO.class );
    }

    @PutMapping()
    public BatchDTO updateBatch(@ModelAttribute @Valid BatchUpdateForm form) {
        return modelMapper.map(batchService.updateBatch(form), BatchDTO.class);
    }

    @GetMapping("/{productId}")
    public List<BatchDTO> getAllBatchByProductId(@PathVariable Integer productId) {
        List<Batch> entities = batchService.getAllBatchByProductId(productId);;
        return modelMapper.map(entities, new TypeToken<List<BatchDTO>>(){}.getType());
    }

//    @GetMapping("/valid")
//    public BatchDTO getTheValidBatch() {
//        return modelMapper(batchService.getTheValidBatch());
//    }
}
