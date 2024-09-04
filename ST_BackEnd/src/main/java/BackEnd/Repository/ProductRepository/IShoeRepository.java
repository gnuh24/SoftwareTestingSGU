package BackEnd.Repository.ProductRepository;

import BackEnd.Entity.ProductEntity.Shoe;
import org.springframework.data.domain.Page;
import org.springframework.data.domain.Pageable;
import org.springframework.data.jpa.domain.Specification;
import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.data.jpa.repository.JpaSpecificationExecutor;
import org.springframework.data.jpa.repository.Modifying;
import org.springframework.data.jpa.repository.Query;
import org.springframework.data.repository.query.Param;
import org.springframework.transaction.annotation.Transactional;

import java.util.List;

public interface IShoeRepository extends JpaRepository<Shoe,  Integer>, JpaSpecificationExecutor<Shoe> {

    List<Shoe> getShoeByBrand_BrandId( Integer brandId);

    List<Shoe> getShoeByShoeType_ShoeTypeId( Integer shoeTypeId);

    @Query("SELECT s FROM Shoe s JOIN s.sales sa WHERE sa.event.eventId = :eventId")
    List<Shoe> findShoesByEventId(@Param("eventId") Integer eventId);

    @Transactional
    @Modifying
    @Query("UPDATE Shoe s SET s.brand.id = 1 WHERE s.brand.id = :brandId")
    int updateBrandToDefault( Integer brandId);

    @Transactional
    @Modifying
    @Query("UPDATE Shoe s SET s.shoeType.id = 1 WHERE s.shoeType.id = :shoeTypeId")
    int updateShoeTypeToDefault( Integer shoeTypeId);
}
