package BackEnd.Entity.ShoppingEntities;

import org.hibernate.engine.spi.SharedSessionContractImplementor;
import org.hibernate.id.IdentifierGenerator;

import java.io.Serializable;
import java.util.UUID;

public class OrderIdGenerator implements IdentifierGenerator {

    @Override
    public Serializable generate(SharedSessionContractImplementor session, Object obj) {
        // Tạo một UUID và loại bỏ dấu gạch ngang
        String uuid = UUID.randomUUID().toString().replaceAll("-", "");

        // Lấy 9 ký tự đầu tiên từ UUID để đảm bảo tổng độ dài là 12 ký tự
        String uniquePart = uuid.substring(0, 9).toUpperCase();

        // Kết hợp "ORD" với phần duy nhất từ UUID
        return "ORD" + uniquePart;
    }

}
