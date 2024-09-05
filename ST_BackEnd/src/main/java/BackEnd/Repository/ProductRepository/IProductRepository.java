package BackEnd.Repository.ProductRepository;

import BackEnd.Entity.ProductEntity.Product;
import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.data.jpa.repository.JpaSpecificationExecutor;
import org.springframework.data.jpa.repository.Modifying;
import org.springframework.data.jpa.repository.Query;
import org.springframework.transaction.annotation.Transactional;

import java.util.List;

public interface IProductRepository extends JpaRepository<Product,  Integer>, JpaSpecificationExecutor<Product> {

    @Transactional
    @Modifying
    @Query("UPDATE Product s SET s.brand.id = 1 WHERE s.brand.id = :brandId")
    int updateBrandToDefault( Integer brandId);

    @Transactional
    @Modifying
    @Query("UPDATE Product s SET s.category.id = 1 WHERE s.category.id = :categoryId")
    int updateCategoryToDefault(Integer categoryId);
}
