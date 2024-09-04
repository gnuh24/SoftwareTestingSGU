package BackEnd.Specification.ProductSpecification;


import BackEnd.Entity.ProductEntity.Category;
import com.mysql.cj.util.StringUtils;
import jakarta.persistence.criteria.CriteriaBuilder;
import jakarta.persistence.criteria.CriteriaQuery;
import jakarta.persistence.criteria.Predicate;
import jakarta.persistence.criteria.Root;
import lombok.Data;
import lombok.NonNull;
import org.springframework.data.jpa.domain.Specification;

@Data
public class CategorySpecification implements Specification<Category> {

    @NonNull
    private String field;

    @NonNull
    private Object value;


    @Override
    //Đây là phương thức ta dùng để custom filter
    public Predicate toPredicate(@NonNull Root<Category> root,
                                 @NonNull CriteriaQuery<?> query,
                                 @NonNull CriteriaBuilder criteriaBuilder) {

        if (field.equalsIgnoreCase("categoryName")){
            return criteriaBuilder.like(root.get("categoryName") ,"%" + value  + "%");
        }

        return null;
    }


    //Đây là phương thức ta sẽ gọi ở Service và dùng nó với Repository để filter
    public static Specification<Category> buildWhere(String search){
        Specification<Category> where = null;


        if (!StringUtils.isEmptyOrWhitespaceOnly(search)) {
            search = search.trim();
            CategorySpecification categoryName = new CategorySpecification("categoryName", search);
            where = Specification.where(categoryName);
        }


        return where;

    }
}
