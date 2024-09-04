package BackEnd.Repository.ShoppingRepositories;

import BackEnd.Entity.ShoppingEntities.Voucher;
import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.data.jpa.repository.JpaSpecificationExecutor;
import org.springframework.data.jpa.repository.Query;

import java.util.List;

public interface IVoucherRepository extends JpaRepository<Voucher, Integer>, JpaSpecificationExecutor<Voucher> {
    Voucher findByCode(String code);

    @Query(value = "SELECT * FROM Voucher WHERE status = true AND expirationTime > NOW()", nativeQuery = true)
    List<Voucher> getVoucherByUser();
}

