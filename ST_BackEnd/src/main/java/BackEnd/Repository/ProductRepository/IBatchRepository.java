package BackEnd.Repository.ProductRepository;

import BackEnd.Entity.ProductEntity.Batch;
import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.data.jpa.repository.Query;
import org.springframework.data.repository.query.Param;

import java.util.List;


public interface IBatchRepository extends JpaRepository<Batch, Integer> {

    List<Batch> findByProductIdOrderByReceivingTimeDesc(Integer productId);

    @Query(value = "SELECT * FROM `Batch`\n" +
                    "WHERE `Quantity` > 0 \n" +
                    "AND `ReceivingTime` = (\n" +
                    "\tSELECT MIN(`ReceivingTime`) FROM `Batch`\n" +
                    "    WHERE `ProductId` = :productId\n" +
                    "    AND `Quantity` > 0\n" +
                    ")\n" +
                    "AND `ProductId` = :productId", nativeQuery = true)
    Batch findOldestBatchWithQuantityGreaterThanZero(@Param("productId") Integer productId);

    @Query(value = "SELECT * FROM `Batch`\n" +
                    "WHERE `ReceivingTime` = (\n" +
                    "\tSELECT MAX(`ReceivingTime`) FROM `Batch`\n" +
                    "    WHERE `ProductId` = :productId\n" +
                    ")\n" +
                    "AND `ProductId` = :productId", nativeQuery = true)
    Batch findValidBatchByProductIdBackupVersion(@Param("productId") Integer productId);

}



