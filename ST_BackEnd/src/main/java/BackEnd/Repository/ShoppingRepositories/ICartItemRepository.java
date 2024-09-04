package BackEnd.Repository.ShoppingRepositories;

import BackEnd.Entity.ShoppingEntities.CartItem;
import org.springframework.data.jpa.repository.JpaRepository;

import java.util.List;

public interface ICartItemRepository extends JpaRepository<CartItem, CartItem.CartItemId> {

    List<CartItem> findByAccount_Id(Integer id);

    void deleteAllByAccountId(Integer accountId);

}
