package BackEnd.Specification.NewsSpecifications;

import BackEnd.Entity.NewsEntities.Feedback;
import BackEnd.Form.NewsForms.FeedbackForms.FeedbackFilterForm;
import com.mysql.cj.util.StringUtils;
import jakarta.persistence.criteria.*;
import lombok.AllArgsConstructor;
import lombok.Data;
import lombok.NonNull;
import org.springframework.data.jpa.domain.Specification;

import java.time.LocalDateTime;
import java.util.Date;

@Data
@AllArgsConstructor
public class FeedbackSpecification implements Specification<Feedback> {

    @NonNull
    private String field;

    @NonNull
    private Object value;

    @Override
    public Predicate toPredicate(@NonNull Root<Feedback> root,
                                 @NonNull CriteriaQuery<?> query,
                                 @NonNull CriteriaBuilder criteriaBuilder) {

        if (field.equalsIgnoreCase("title")) {
            return criteriaBuilder.like(root.get("title"), "%" + value + "%");
        }

        if (field.equalsIgnoreCase("isDeleted")) {
            return criteriaBuilder.equal(root.get("isDeleted"), value);
        }

        if (field.equalsIgnoreCase("isChecked")) {
            return criteriaBuilder.equal(root.get("isChecked"), value);
        }

        if (field.equalsIgnoreCase("from")) {
            return criteriaBuilder.greaterThanOrEqualTo(root.get("createTime").as(java.sql.Date.class), (Date) value);
        }

        if (field.equalsIgnoreCase("to")) {
            return criteriaBuilder.lessThanOrEqualTo(root.get("createTime").as(java.sql.Date.class), (Date) value);
        }

        return null;
    }

    public static Specification<Feedback> buildWhere(String search, FeedbackFilterForm form) {
        Specification<Feedback> where = null;

        if (form != null) {

            if (!StringUtils.isEmptyOrWhitespaceOnly(search)) {
                search = search.trim();
                FeedbackSpecification orderIdSpec = new FeedbackSpecification("title", search);
                where = Specification.where(orderIdSpec);
            }

            if (form.getFrom() != null) {
                FeedbackSpecification fromSpec = new FeedbackSpecification("from", form.getFrom());
                if (where != null) {
                    where = where.and(fromSpec);
                } else {
                    where = Specification.where(fromSpec);
                }
            }

            if (form.getTo() != null) {
                FeedbackSpecification toSpec = new FeedbackSpecification("to", form.getTo());
                if (where != null) {
                    where = where.and(toSpec);
                } else {
                    where = Specification.where(toSpec);
                }
            }

            if (form.getIsDeleted() != null) {
                FeedbackSpecification isDeletedSpec = new FeedbackSpecification("isDeleted", form.getIsDeleted());
                if (where != null) {
                    where = where.and(isDeletedSpec);
                } else {
                    where = Specification.where(isDeletedSpec);
                }
            }

            if (form.getIsChecked() != null) {
                FeedbackSpecification isReadedSpec = new FeedbackSpecification("isChecked", form.getIsChecked());
                if (where != null) {
                    where = where.and(isReadedSpec);
                } else {
                    where = Specification.where(isReadedSpec);
                }
            }
        }

        return where;
    }
}
