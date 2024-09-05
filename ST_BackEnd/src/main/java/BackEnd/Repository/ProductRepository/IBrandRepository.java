package BackEnd.Repository.ProductRepository;

import BackEnd.Entity.ProductEntity.Brand;
import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.data.jpa.repository.JpaSpecificationExecutor;

import java.util.List;

public interface IBrandRepository extends JpaRepository<Brand, Integer> , JpaSpecificationExecutor<Brand> {

}