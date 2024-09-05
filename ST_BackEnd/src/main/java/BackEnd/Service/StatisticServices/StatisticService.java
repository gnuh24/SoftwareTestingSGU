package BackEnd.Service.StatisticServices;

import BackEnd.Form.StatisticForms.BestSellerForm;
import BackEnd.Form.StatisticForms.BestSellerSizeForm;
import BackEnd.Form.StatisticForms.IncomeSummaryForm;
import BackEnd.Form.StatisticForms.OrderStatusSummary;
import BackEnd.Repository.ShoppingRepositories.IOrderRepository;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;

import java.util.List;

@Service
public class StatisticService implements IStatisticService{

    @Autowired
    private IOrderRepository orderRepository;

    @Override
    public List<BestSellerForm> getShoeSales(String minDate, String maxDate, Integer limit, Integer brandId, Integer shoeTypeId) {
        return orderRepository.findShoeSales(minDate, maxDate, limit, brandId, shoeTypeId);
    }


    @Override
    public List<BestSellerSizeForm> getShoeSizeSales(Integer shoeId, String minDate, String maxDate) {
        return orderRepository.findShoeSizeSales(shoeId, minDate, maxDate);
    }

    @Override
    public List<OrderStatusSummary> getAllSummaryOrderStatus(String minDate, String maxDate) {
        return orderRepository.findOrderStatusSummary(minDate, maxDate);
    }

    @Override
    public List<IncomeSummaryForm> getIncomeSummary(String minDate, String maxDate) {
        return orderRepository.findIncomeSummary(minDate, maxDate);
    }
}
