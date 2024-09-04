package BackEnd.Service.ShoppingServices.ShippingFeeServices;

import BackEnd.Entity.ShoppingEntities.ShippingFee;
import BackEnd.Form.ShoppingForms.ShippngFeeForms.ShippingFeeCreateForm;
import BackEnd.Repository.ShoppingRepositories.IShippingFeeRepository;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.data.domain.Page;
import org.springframework.data.domain.Pageable;
import org.springframework.stereotype.Service;

@Service
public class ShippingFeeService implements IShippingFeeService {

    @Autowired
    private IShippingFeeRepository shippingFeeRepository;


    @Override
    public Page<ShippingFee> getAllShippingFee(Pageable pageable) {
        return shippingFeeRepository.findAll(pageable);
    }

    @Override
    public ShippingFee getShippingFeeById(Integer id) {
        return shippingFeeRepository.findById(id).orElse(null);
    }

    @Override
    public ShippingFee createShippingFee(ShippingFeeCreateForm form) {
        ShippingFee shippingFee = new ShippingFee();
        shippingFee.setFee(form.getFee());
        return shippingFeeRepository.save(shippingFee);
    }

    @Override
    public ShippingFee getNewestShippingFee() {
        return shippingFeeRepository.findTopByOrderByCreateTimeDesc();
    }
}

