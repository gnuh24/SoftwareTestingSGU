package BackEnd.Controller.StatisticControllers;

import BackEnd.Form.StatisticForms.BestSellerForm;
import BackEnd.Form.StatisticForms.BestSellerSizeForm;
import BackEnd.Form.StatisticForms.IncomeSummaryForm;
import BackEnd.Form.StatisticForms.OrderStatusSummary;
import BackEnd.Service.StatisticServices.IStatisticService;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.format.annotation.DateTimeFormat;
import org.springframework.web.bind.annotation.*;

import java.text.SimpleDateFormat;
import java.util.Date;
import java.util.List;


@RestController
@RequestMapping("/Statistic")
@CrossOrigin(origins = "*")
public class StatisticController {

    @Autowired
    private IStatisticService statisticService;

    @GetMapping("/BestSeller")
    public List<BestSellerForm> getBestSellers(@RequestParam(required = false) @DateTimeFormat(pattern = "dd/MM/yyyy") Date minDate,
                                               @RequestParam(required = false) @DateTimeFormat(pattern = "dd/MM/yyyy") Date maxDate,
                                               @RequestParam(defaultValue = "10") Integer limit,
                                               @RequestParam(required = false) Integer brandId,
                                               @RequestParam(required = false) Integer shoeTypeId) {
        SimpleDateFormat sdf = new SimpleDateFormat("yyyy-MM-dd");
        String minDateString = minDate != null ? sdf.format(minDate) : null;
        String maxDateString = maxDate != null ? sdf.format(maxDate) : null;

        return statisticService.getShoeSales(minDateString, maxDateString, limit, brandId, shoeTypeId);
    }

    @GetMapping("/BestSellerBySize")
    public List<BestSellerSizeForm> getBestSellerBySize(
        @RequestParam Integer shoeId,
        @RequestParam(required = false) @DateTimeFormat(pattern = "dd/MM/yyyy") Date minDate,
        @RequestParam(required = false) @DateTimeFormat(pattern = "dd/MM/yyyy") Date maxDate) {

        SimpleDateFormat sdf = new SimpleDateFormat("yyyy-MM-dd");
        String minDateString = minDate != null ? sdf.format(minDate) : null;
        String maxDateString = maxDate != null ? sdf.format(maxDate) : null;

        return statisticService.getShoeSizeSales(shoeId, minDateString, maxDateString);
    }


    @GetMapping("/OrderStatus")
    public List<OrderStatusSummary> getSummaryAboutOrderStatus(@RequestParam(required = false) @DateTimeFormat(pattern = "dd/MM/yyyy") Date minDate,
                                                  @RequestParam(required = false) @DateTimeFormat(pattern = "dd/MM/yyyy") Date maxDate){
        SimpleDateFormat sdf = new SimpleDateFormat("yyyy-MM-dd");
        String minDateString = minDate != null ? sdf.format(minDate) : null;
        String maxDateString = maxDate != null ? sdf.format(maxDate) : null;

        return statisticService.getAllSummaryOrderStatus(minDateString, maxDateString);
    }

    @GetMapping("/IncomeSummary")
    public List<IncomeSummaryForm> getIncomeSummary(@RequestParam(required = false) @DateTimeFormat(pattern = "dd/MM/yyyy") Date minDate,
                                                    @RequestParam(required = false) @DateTimeFormat(pattern = "dd/MM/yyyy") Date maxDate) {
        SimpleDateFormat sdf = new SimpleDateFormat("yyyy-MM-dd");
        String minDateString = minDate != null ? sdf.format(minDate) : null;
        String maxDateString = maxDate != null ? sdf.format(maxDate) : null;

        return statisticService.getIncomeSummary(minDateString, maxDateString);
    }
}
