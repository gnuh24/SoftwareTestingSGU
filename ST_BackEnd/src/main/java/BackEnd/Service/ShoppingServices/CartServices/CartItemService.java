package BackEnd.Service.ShoppingServices.CartServices;

import BackEnd.Entity.ShoppingEntities.CartItem;
import BackEnd.Form.ShoppingForms.CartItemForm.CartItemCreateForm;
import BackEnd.Form.ShoppingForms.CartItemForm.CartItemUpdateForm;
import BackEnd.Repository.ShoppingRepositories.ICartItemRepository;
import org.modelmapper.ModelMapper;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;
import org.springframework.transaction.annotation.Transactional;

import java.util.List;

@Service
public class CartItemService implements ICartItemService {

    @Autowired
    private ICartItemRepository cartItemRepository;

    @Autowired
    private ModelMapper modelMapper;

    @Override
    public CartItem getCartItemById(CartItem.CartItemId id){
        return cartItemRepository.findById(id).orElse(null);
    }

    @Override
    public List<CartItem> getAllCartItemsByAccountId(Integer accountId) {
        return cartItemRepository.findByAccount_Id(accountId);
    }

    @Override
    @Transactional
    public CartItem createCartItem(CartItemCreateForm form) {

        CartItem cartItem = modelMapper.map(form, CartItem.class);

        return  cartItemRepository.save(cartItem);
    }

    @Override
    @Transactional
    public CartItem updateCartItem(CartItemUpdateForm form) {

        CartItem.CartItemId id = new CartItem.CartItemId(form.getShoeId(), form.getIdSize(), form.getAccountId());
        CartItem cartItem1 = getCartItemById(id);

        if (form.getUnitPrice() != null){
            cartItem1.setUnitPrice(form.getUnitPrice());
        }

        if (form.getQuantity() != null){
            cartItem1.setQuantity(form.getQuantity());
        }

        if (form.getTotal() != null){
            cartItem1.setTotal(form.getTotal());
        }

        return cartItemRepository.save(cartItem1);
    }

    @Override
    @Transactional
    public void deleteCartItem( Integer shoeId, Byte size, Integer accountId) {
        CartItem.CartItemId id = new CartItem.CartItemId(shoeId, size, accountId);
        cartItemRepository.deleteById(id);
    }

    @Override
    @Transactional
    public void deleteAllCartItem(Integer accountId) {
        cartItemRepository.deleteAllByAccountId(accountId);
    }


}

