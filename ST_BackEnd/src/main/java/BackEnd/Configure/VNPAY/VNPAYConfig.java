package BackEnd.Configure.VNPAY;

import jakarta.servlet.http.HttpServletRequest;

import javax.crypto.Mac;
import javax.crypto.spec.SecretKeySpec;
import java.nio.charset.StandardCharsets;
import java.util.*;

public class VNPAYConfig {
    // URL dùng để gửi yêu cầu thanh toán đến VNPay (Sandbox dùng để thử nghiệm)
    public static String vnp_PayUrl = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";

    // URL dùng để nhận kết quả thanh toán sau khi người dùng hoàn thành thanh toán
    public static String vnp_ReturnUrl = "http://localhost:8080/returnPay";

    // Mã terminal của merchant (do VNPay cấp)
    public static String vnp_TmnCode = "JU0RHJD8";

    // Secret key dùng để mã hóa dữ liệu giao dịch (do VNPay cấp)
    public static String secretKey = "J6OYKNGW8XG59IM8DX78HG2D2CSRNW93";

    // URL API của VNPay để xử lý giao dịch
    public static String vnp_ApiUrl = "https://sandbox.vnpayment.vn/merchant_webapi/api/transaction";

    // Phương thức dùng để mã hóa các trường dữ liệu bằng HMAC-SHA512
    public static String hashAllFields(Map fields) {
        // Lấy tất cả tên các trường dữ liệu trong Map và sắp xếp chúng theo thứ tự alphabet
        List fieldNames = new ArrayList(fields.keySet());
        Collections.sort(fieldNames);

        StringBuilder sb = new StringBuilder();
        Iterator itr = fieldNames.iterator();
        while (itr.hasNext()) {
            String fieldName = (String) itr.next();
            String fieldValue = (String) fields.get(fieldName);
            // Nếu giá trị của trường không null và có độ dài > 0, thì thêm vào chuỗi hash
            if ((fieldValue != null) && (fieldValue.length() > 0)) {
                sb.append(fieldName); // Thêm tên trường
                sb.append("=");       // Thêm dấu "="
                sb.append(fieldValue); // Thêm giá trị của trường
            }
            // Nếu còn trường tiếp theo, thêm "&" để nối
            if (itr.hasNext()) {
                sb.append("&");
            }
        }
        // Mã hóa chuỗi đã tạo bằng HMAC-SHA512 với secretKey
        return hmacSHA512(secretKey, sb.toString());
    }

    // Phương thức thực hiện mã hóa HMAC-SHA512
    public static String hmacSHA512(final String key, final String data) {
        try {
            // Kiểm tra key và data có null không
            if (key == null || data == null) {
                throw new NullPointerException();
            }
            // Khởi tạo thuật toán HMAC-SHA512
            final Mac hmac512 = Mac.getInstance("HmacSHA512");
            byte[] hmacKeyBytes = key.getBytes(); // Chuyển secretKey sang mảng byte
            final SecretKeySpec secretKey = new SecretKeySpec(hmacKeyBytes, "HmacSHA512");
            hmac512.init(secretKey); // Khởi tạo với secretKey

            byte[] dataBytes = data.getBytes(StandardCharsets.UTF_8); // Chuyển data thành byte
            byte[] result = hmac512.doFinal(dataBytes); // Thực hiện mã hóa

            // Chuyển kết quả mã hóa thành chuỗi hex
            StringBuilder sb = new StringBuilder(2 * result.length);
            for (byte b : result) {
                sb.append(String.format("%02x", b & 0xff));
            }
            return sb.toString(); // Trả về chuỗi mã hóa hex

        } catch (Exception ex) {
            return ""; // Nếu có lỗi xảy ra, trả về chuỗi rỗng
        }
    }

    // Phương thức lấy địa chỉ IP của client
    public static String getIpAddress(HttpServletRequest request) {
        String ipAdress;
        try {
            // Lấy IP từ header "X-FORWARDED-FOR" (thường dùng khi qua proxy)
            ipAdress = request.getHeader("X-FORWARDED-FOR");
            if (ipAdress == null) {
                // Nếu không có, lấy địa chỉ IP trực tiếp từ request
                ipAdress = request.getRemoteAddr();
            }
        } catch (Exception e) {
            // Nếu có lỗi, trả về thông báo lỗi
            ipAdress = "Invalid IP:" + e.getMessage();
        }
        return ipAdress; // Trả về địa chỉ IP hoặc thông báo lỗi
    }

    // Phương thức tạo số ngẫu nhiên với độ dài nhất định
    public static String getRandomNumber(int len) {
        Random rnd = new Random();
        String chars = "0123456789"; // Chuỗi ký tự số dùng để tạo chuỗi ngẫu nhiên
        StringBuilder sb = new StringBuilder(len);

        // Lặp qua độ dài yêu cầu và chọn ngẫu nhiên ký tự từ chuỗi số
        for (int i = 0; i < len; i++) {
            sb.append(chars.charAt(rnd.nextInt(chars.length())));
        }
        return sb.toString(); // Trả về chuỗi số ngẫu nhiên
    }
}
