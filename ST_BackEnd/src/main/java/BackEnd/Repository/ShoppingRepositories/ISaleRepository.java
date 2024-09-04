package BackEnd.Repository.ShoppingRepositories;

import BackEnd.Entity.ShoppingEntities.Sale;
import BackEnd.Entity.ShoppingEntities.Sale.SaleId;
import org.springframework.data.jpa.repository.JpaRepository;

import java.util.List;

public interface ISaleRepository extends JpaRepository<Sale, SaleId> {
    List<Sale> findById_EventId(Integer eventId);
}

