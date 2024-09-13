package BackEnd.Service.ProductService.Batch;

import BackEnd.Entity.ProductEntity.Batch;
import BackEnd.Form.ProductForm.BatchForms.BatchCreateForm;
import BackEnd.Form.ProductForm.BatchForms.BatchUpdateForm;

import java.util.List;

public interface IBatchService {

    Batch createBatch(BatchCreateForm form);
    Batch updateBatch(BatchUpdateForm form);
    List<Batch> getAllBatchByProductId(Integer productId);
    Batch getTheValidBatch(Integer productId);
    Batch getTheValidBatchBackup(Integer productId);
    Batch getBatchById(Integer batchId);
}
