package BackEnd.Specification.ProductSpecification;


import BackEnd.Entity.ProductEntity.ShoeType;
import com.mysql.cj.util.StringUtils;
import jakarta.persistence.criteria.CriteriaBuilder;
import jakarta.persistence.criteria.CriteriaQuery;
import jakarta.persistence.criteria.Predicate;
import jakarta.persistence.criteria.Root;
import lombok.Data;
import lombok.NonNull;
import org.springframework.data.jpa.domain.Specification;

@Data
public class ShoeTypeSpecification implements Specification<ShoeType> {

    @NonNull
    private String field;

    @NonNull
    private Object value;



    @Override
    //Đây là phương thức ta dùng để custom filter
    public Predicate toPredicate(Root<ShoeType> root,
                                 CriteriaQuery<?> query,
                                 CriteriaBuilder criteriaBuilder) {

        if (field.equalsIgnoreCase("shoeTypeName")){
            return criteriaBuilder.like(root.get("shoeTypeName") ,"%" + value  + "%");
        }

        return null;
    }


    //Đây là phương thức ta sẽ gọi ở Service và dùng nó với Repository để filter
    public static Specification<ShoeType> buildWhere(String search){
        Specification<ShoeType> where = null;


        if (!StringUtils.isEmptyOrWhitespaceOnly(search)) {
            search = search.trim();
            ShoeTypeSpecification tenLoaiSanPham = new ShoeTypeSpecification("shoeTypeName", search);
            where = Specification.where(tenLoaiSanPham);
        }


        return where;

    }
}
