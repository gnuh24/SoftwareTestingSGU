package BackEnd.Controller.ShoppingControllers;

import BackEnd.Entity.ShoppingEntities.CartItem;
import BackEnd.Form.ProductForm.ShoeSizeForm.ShoeSizeDTO;
import BackEnd.Form.ShoppingForms.CartItemForm.CartItemCreateForm;
import BackEnd.Form.ShoppingForms.CartItemForm.CartItemDTO;
import BackEnd.Form.ShoppingForms.CartItemForm.CartItemDeleteForm;
import BackEnd.Form.ShoppingForms.CartItemForm.CartItemUpdateForm;
import BackEnd.Service.ShoppingServices.CartServices.ICartItemService;
import org.modelmapper.ModelMapper;
import org.modelmapper.TypeToken;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.http.ResponseEntity;
import org.springframework.web.bind.annotation.*;

import jakarta.validation.Valid;

import java.lang.reflect.Type;
import java.util.List;

@RestController
@RequestMapping("/CartItem")
@CrossOrigin(origins = "*")
public class CartItemController {

    @Autowired
    private ICartItemService cartItemService;

    @Autowired
    private ModelMapper modelMapper;


    @GetMapping("/{accountId}")
    public List<CartItemDTO> getAllCartItemsByAccountId(@PathVariable Integer accountId) {
        List<CartItem> entites = cartItemService.getAllCartItemsByAccountId(accountId);
        List<CartItemDTO> dto = modelMapper.map(entites, new TypeToken<List<CartItemDTO>>() {
        }.getType());
        return dto;
    }

    @PostMapping
    public CartItemDTO createCartItem(@ModelAttribute @Valid CartItemCreateForm cartItemCreateForm) {

        CartItem cartItem = cartItemService.createCartItem(cartItemCreateForm);
        return modelMapper.map(cartItem, CartItemDTO.class);
    }

    @PatchMapping
    public CartItemDTO updateCartItem(@ModelAttribute @Valid CartItemUpdateForm cartItemUpdateForm) {
        CartItem cartItem = cartItemService.updateCartItem(cartItemUpdateForm);
        return modelMapper.map(cartItem, CartItemDTO.class);    }

    @DeleteMapping()
    public void deleteCartItem(@ModelAttribute @Valid CartItemDeleteForm form) {
        cartItemService.deleteCartItem(form.getShoeId(), form.getIdSize(), form.getAccountId());
    }

    @DeleteMapping("/{accountId}")
    public ResponseEntity<Void> deleteAllCartItems(@PathVariable Integer accountId) {
        cartItemService.deleteAllCartItem(accountId);
        return ResponseEntity.noContent().build();
    }
}
