package BackEnd.Repository.ProductRepository;

import BackEnd.Entity.ProductEntity.Color;
import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.data.jpa.repository.JpaSpecificationExecutor;
import org.springframework.data.jpa.repository.Query;
import org.springframework.data.repository.query.Param;

import java.util.List;

public interface IColorRepository extends JpaRepository<Color,  Integer>, JpaSpecificationExecutor<Color> {

    @Query("SELECT c FROM Color c JOIN ShoeColor sc ON c.id = sc.id.colorId WHERE sc.id.shoeId = :shoeId")
    List<Color> findColorsByShoeId(@Param("shoeId")  Integer shoeId);

}
