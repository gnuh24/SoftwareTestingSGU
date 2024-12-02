package BackEnd.Repository.ProductRepository;

import BackEnd.Entity.ProductEntity.Category;
import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.data.jpa.repository.JpaSpecificationExecutor;

public interface ICategoryRepository extends JpaRepository<Category,  Integer>, JpaSpecificationExecutor<Category> {
    boolean existsByCategoryName(String categoryName);
}
