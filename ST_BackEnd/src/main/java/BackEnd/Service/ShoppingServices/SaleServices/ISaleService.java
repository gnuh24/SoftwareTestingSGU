package BackEnd.Service.ShoppingServices.SaleServices;

import BackEnd.Entity.ShoppingEntities.Sale;
import BackEnd.Form.ShoppingForms.SaleForms.SaleCreateForm;
import BackEnd.Form.ShoppingForms.SaleForms.SaleDeleteForm;

import java.util.List;

public interface ISaleService {

    List<Sale> getSaleByEventId(Integer eventId);
    Sale createSale(SaleCreateForm form);
    void deleteSale(SaleDeleteForm form);
}
