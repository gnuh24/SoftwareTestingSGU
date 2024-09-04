package BackEnd.Specification.NewsSpecifications;

import BackEnd.Entity.NewsEntities.News;
import BackEnd.Form.NewsForms.NewsEntityForms.NewsFilterForm;
import com.mysql.cj.util.StringUtils;
import jakarta.persistence.criteria.*;
import lombok.AllArgsConstructor;
import lombok.Data;
import lombok.NonNull;
import org.springframework.data.jpa.domain.Specification;

import java.time.LocalDateTime;

@Data
@AllArgsConstructor
public class NewsSpecification implements Specification<News> {

    @NonNull
    private String field;

    @NonNull
    private Object value;

    @Override
    public Predicate toPredicate(@NonNull Root<News> root,
                                 @NonNull CriteriaQuery<?> query,
                                 @NonNull CriteriaBuilder criteriaBuilder) {

        if (field.equalsIgnoreCase("newsId")) {
            return criteriaBuilder.equal(root.get("newsId"), value);
        }

        if (field.equalsIgnoreCase("title")) {
            return criteriaBuilder.like(root.get("title"), "%" + value + "%");
        }


        if (field.equalsIgnoreCase("status")) {
            return criteriaBuilder.equal(root.get("status"), value);
        }


        if (field.equalsIgnoreCase("priorityFlag")) {
            return criteriaBuilder.equal(root.get("priorityFlag"), value);
        }

        if (field.equalsIgnoreCase("from")) {
            return criteriaBuilder.greaterThanOrEqualTo(root.get("createTime").as(LocalDateTime.class), (LocalDateTime) value);
        }

        if (field.equalsIgnoreCase("to")) {
            return criteriaBuilder.lessThanOrEqualTo(root.get("createTime").as(LocalDateTime.class), (LocalDateTime) value);
        }

        return null;
    }

    public static Specification<News> buildWhere(String search, NewsFilterForm form) {
        Specification<News> where = null;

        if (form != null) {

            if (!StringUtils.isEmptyOrWhitespaceOnly(search)) {
                search = search.trim();
                NewsSpecification titleSpec = new NewsSpecification("title", search);
                where = Specification.where(titleSpec);
            }

            if (form.getFrom() != null) {
                NewsSpecification fromSpec = new NewsSpecification("from", form.getFrom());
                if (where != null) {
                    where = where.and(fromSpec);
                } else {
                    where = Specification.where(fromSpec);
                }
            }

            if (form.getTo() != null) {
                NewsSpecification toSpec = new NewsSpecification("to", form.getTo());
                if (where != null) {
                    where = where.and(toSpec);
                } else {
                    where = Specification.where(toSpec);
                }
            }

            if (form.getStatus() != null) {
                NewsSpecification statusSpec = new NewsSpecification("status", form.getStatus());
                if (where != null) {
                    where = where.and(statusSpec);
                } else {
                    where = Specification.where(statusSpec);
                }
            }

            if (form.getPriorityFlag() != null) {
                NewsSpecification priorityFlag = new NewsSpecification("priorityFlag", form.getPriorityFlag());
                if (where != null) {
                    where = where.and(priorityFlag);
                } else {
                    where = Specification.where(priorityFlag);
                }
            }
        }

        return where;
    }
}
