package BackEnd.Specification.ProductSpecification;

import BackEnd.Entity.ProductEntity.Color;
import com.mysql.cj.util.StringUtils;
import jakarta.persistence.criteria.CriteriaBuilder;
import jakarta.persistence.criteria.CriteriaQuery;
import jakarta.persistence.criteria.Predicate;
import jakarta.persistence.criteria.Root;
import lombok.Data;
import lombok.NonNull;
import org.springframework.data.jpa.domain.Specification;

@Data
public class ColorSpecification implements Specification<Color> {

    @NonNull
    private String field;

    @NonNull
    private Object value;

    @Override
    public Predicate toPredicate(@NonNull Root<Color> root,
                                 @NonNull CriteriaQuery<?> query,
                                 @NonNull CriteriaBuilder criteriaBuilder) {

        if (field.equalsIgnoreCase("colorName")) {
            return criteriaBuilder.like(root.get("colorName"), "%" + value + "%");
        }

        return null;
    }

    public static Specification<Color> buildWhere(String search) {
        Specification<Color> where = null;

        if (!StringUtils.isEmptyOrWhitespaceOnly(search)) {
            search = search.trim();
            ColorSpecification spec = new ColorSpecification("colorName", search);
            where = Specification.where(spec);
        }
        return where;
    }
}
