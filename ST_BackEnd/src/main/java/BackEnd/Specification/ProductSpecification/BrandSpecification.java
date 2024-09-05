package BackEnd.Specification.ProductSpecification;

import BackEnd.Entity.ProductEntity.Brand;
import com.mysql.cj.util.StringUtils;
import jakarta.persistence.criteria.CriteriaBuilder;
import jakarta.persistence.criteria.CriteriaQuery;
import jakarta.persistence.criteria.Predicate;
import jakarta.persistence.criteria.Root;
import lombok.Data;
import lombok.NonNull;
import org.springframework.data.jpa.domain.Specification;

@Data
public class BrandSpecification implements Specification<Brand>{

    @NonNull
    private String field;

    @NonNull
    private Object value;

    @Override
    //Đây là phương thức ta dùng để custom filter
    public Predicate toPredicate(@NonNull Root<Brand> root,
                                 @NonNull CriteriaQuery<?> query,
                                 @NonNull CriteriaBuilder criteriaBuilder) {

        if (field.equalsIgnoreCase("brandName")){
            return criteriaBuilder.like(root.get("brandName") ,"%" + value  + "%");
        }

        return null;
    }


    //Đây là phương thức ta sẽ gọi ở Service và dùng nó với Repository để filter
    public static Specification<Brand> buildWhere(String search){
        Specification<Brand> where = null;

        if (!StringUtils.isEmptyOrWhitespaceOnly(search)) {
            search = search.trim();
            BrandSpecification brandName = new BrandSpecification("brandName", search);
            where = Specification.where(brandName);
        }

        return where;

    }
}

