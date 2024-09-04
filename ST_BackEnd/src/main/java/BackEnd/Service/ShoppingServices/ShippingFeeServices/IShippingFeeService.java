package BackEnd.Service.ShoppingServices.ShippingFeeServices;


import BackEnd.Entity.ShoppingEntities.ShippingFee;
import BackEnd.Form.ShoppingForms.ShippngFeeForms.ShippingFeeCreateForm;
import org.springframework.data.domain.Page;
import org.springframework.data.domain.Pageable;

public interface IShippingFeeService {

    Page<ShippingFee> getAllShippingFee(Pageable pageable);

    ShippingFee getShippingFeeById(Integer id);

    ShippingFee createShippingFee(ShippingFeeCreateForm form);

    ShippingFee getNewestShippingFee();
}

