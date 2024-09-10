package BackEnd.Controller.VnpayController;


import BackEnd.Service.VnpayService.VNPAYService;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.http.ResponseEntity;
import org.springframework.stereotype.Controller;
import org.springframework.web.bind.annotation.GetMapping;
import org.springframework.web.bind.annotation.RequestParam;

import java.io.IOException;
import java.io.UnsupportedEncodingException;
import java.util.Map;

@Controller
public class VNPAYController {
    @Autowired
    private VNPAYService vnpayService;
    @GetMapping("/pay")
    public ResponseEntity<String> getPay(@RequestParam Long price, @RequestParam Integer id)throws UnsupportedEncodingException {
        // Gọi service để lấy URL thanh toán từ VNPay
        String url= vnpayService.getPay(price,id);
        // Trả về URL để người dùng có thể truy cập vào trang thanh toán VNPay
       return  ResponseEntity.ok(url);
    }
    // Tham số: Map chứa các tham số được trả về từ VNPay (vd: vnp_ResponseCode, contractId, ...)
    @GetMapping("/returnPay")
    public ResponseEntity<String> paymentCallback(@RequestParam Map<String, String> queryParams) throws IOException {
        // Lấy mã phản hồi của VNPay (vnp_ResponseCode) và ID hợp đồng (contractId) từ queryParams
        String response = vnpayService.returnPay(queryParams.get("vnp_ResponseCode"), queryParams.get("contractId"));
        // Trả về kết quả xử lý (vd: thông báo giao dịch thành công hoặc thất bại)
        return ResponseEntity.ok(response);
        }

    }
