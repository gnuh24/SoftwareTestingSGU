package BackEnd.Service.ProductService.Batch;

import BackEnd.Entity.ProductEntity.Batch;
import BackEnd.Entity.ProductEntity.Product;
import BackEnd.Form.ProductForm.BatchForms.BatchCreateForm;
import BackEnd.Form.ProductForm.BatchForms.BatchUpdateForm;
import BackEnd.Repository.ProductRepository.IBatchRepository;
import BackEnd.Service.ProductService.Product.IProductService;
import org.modelmapper.ModelMapper;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;

import java.util.List;

@Service
public class BatchService implements IBatchService{

    @Autowired
    private IBatchRepository batchRepository;
    @Autowired
    private IProductService productService;
    @Autowired
    private ModelMapper modelMapper;

    @Override
    public Batch updateBatch(BatchUpdateForm form) {

        Batch batch = getBatchById(form.getId());

        batch.setQuantity(form.getQuantity());

        return batchRepository.save(batch);
    }

    @Override
    public Batch createBatch(BatchCreateForm form) {


        Batch batch = new Batch();
        batch.setUnitPrice(form.getUnitPrice());
        batch.setQuantity(form.getQuantity());


        Product product = productService.getProductById(form.getProductId());
        batch.setProduct(product);

        return batchRepository.save(batch);
    }

    @Override
    public Batch getBatchById(Integer batchId){
        return batchRepository.findById(batchId).orElse(null);
    }

    @Override
    public List<Batch> getAllBatchByProductId(Integer productId) {
        return batchRepository.findByProductIdOrderByReceivingTimeDesc(productId);
    }

    @Override
    public Batch getTheValidBatch(Integer productId) {
        return batchRepository.findOldestBatchWithQuantityGreaterThanZero(productId);
    }

    @Override
    public Batch getTheValidBatchBackup(Integer productId) {

        return batchRepository.findValidBatchByProductIdBackupVersion(productId);
    }
}

