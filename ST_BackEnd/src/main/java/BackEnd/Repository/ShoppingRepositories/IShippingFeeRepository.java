package BackEnd.Repository.ShoppingRepositories;

import BackEnd.Entity.ShoppingEntities.ShippingFee;
import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.data.jpa.repository.Query;

public interface IShippingFeeRepository extends JpaRepository<ShippingFee, Integer> {

    @Query("SELECT s FROM ShippingFee s ORDER BY s.createTime DESC LIMIT 1")
    ShippingFee findTopByOrderByCreateTimeDesc();

//    Page<ShippingFee> findAll(Pageable pageable);
}