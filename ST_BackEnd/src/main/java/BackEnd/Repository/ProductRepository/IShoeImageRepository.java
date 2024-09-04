package BackEnd.Repository.ProductRepository;

import BackEnd.Entity.ProductEntity.ShoeImage;
import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.data.jpa.repository.JpaSpecificationExecutor;

import java.util.List;

public interface IShoeImageRepository extends JpaRepository<ShoeImage,  Integer>, JpaSpecificationExecutor<ShoeImage> {
    ShoeImage findTopByShoe_ShoeIdAndPriority(Integer shoeId, Boolean priority);
    ShoeImage findByShoeImageId( Integer shoeImageId);
    List<ShoeImage> findByShoe_shoeId( Integer shoeId);

}