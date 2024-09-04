package BackEnd.Service.ShoppingServices.SaleServices;

import BackEnd.Entity.ShoppingEntities.Sale;
import BackEnd.Form.ShoppingForms.SaleForms.SaleCreateForm;
import BackEnd.Form.ShoppingForms.SaleForms.SaleDeleteForm;
import BackEnd.Repository.ShoppingRepositories.IEventRepository;
import BackEnd.Repository.ShoppingRepositories.ISaleRepository;
import org.modelmapper.ModelMapper;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;

import java.util.List;

@Service
public class SaleService implements ISaleService {

    @Autowired
    private ISaleRepository saleRepository;

    @Autowired
    private IEventRepository eventRepository;

    @Autowired
    private ModelMapper modelMapper;

    @Override
    public List<Sale> getSaleByEventId(Integer eventId) {
        return saleRepository.findById_EventId(eventId);
    }

    @Override
    public Sale createSale(SaleCreateForm form) {
        Sale sale = modelMapper.map(form, Sale.class);
        return saleRepository.save(sale);
    }

    @Override
    public void deleteSale(SaleDeleteForm form) {
        Sale.SaleId saleId = new Sale.SaleId(form.getEventId(), form.getShoeId());
        saleRepository.deleteById(saleId);
    }
}
