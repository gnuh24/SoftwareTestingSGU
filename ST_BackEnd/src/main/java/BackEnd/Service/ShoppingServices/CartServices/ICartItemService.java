package BackEnd.Service.ShoppingServices.CartServices;



import BackEnd.Entity.ShoppingEntities.CartItem;
import BackEnd.Form.ShoppingForms.CartItemForm.CartItemCreateForm;
import BackEnd.Form.ShoppingForms.CartItemForm.CartItemUpdateForm;

import java.util.List;

public interface ICartItemService {

    CartItem getCartItemById(CartItem.CartItemId id);
    List<CartItem> getAllCartItemsByAccountId(Integer accountId);
    CartItem createCartItem(CartItemCreateForm cartItem);
    CartItem updateCartItem(CartItemUpdateForm cartItem);
    void deleteCartItem( Integer shoeId, Byte size, Integer accountId);
    void deleteAllCartItem(Integer accountId);
;}

