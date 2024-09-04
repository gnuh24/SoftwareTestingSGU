package BackEnd.Specification.ShoppingSpecifications;

import BackEnd.Entity.ShoppingEntities.Order;
import BackEnd.Entity.ShoppingEntities.OrderStatus;
import BackEnd.Form.ShoppingForms.OrderForm.OrderFilterForm;
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
public class OrderSpecification implements Specification<Order> {

    @NonNull
    private String field;

    @NonNull
    private Object value;

    @Override
    public Predicate toPredicate(@NonNull Root<Order> root,
                                 @NonNull CriteriaQuery<?> query,
                                 @NonNull CriteriaBuilder criteriaBuilder) {

        if (field.equalsIgnoreCase("orderId")) {
            return criteriaBuilder.equal(root.get("id"), value);
        }

        if (field.equalsIgnoreCase("type")) {
            return criteriaBuilder.equal(root.get("type"), value);
        }

        if (field.equalsIgnoreCase("from")) {
            return criteriaBuilder.greaterThanOrEqualTo(root.get("orderDate").as(java.sql.Date.class) , (Date) value);
        }

        if (field.equalsIgnoreCase("to")) {
            return criteriaBuilder.lessThanOrEqualTo(root.get("orderDate").as(java.sql.Date.class) , (Date) value);
        }

        if (field.equalsIgnoreCase("status")) {
            // Create a subquery to find the maximum updateTime for each orderId
            Subquery<LocalDateTime> maxUpdateTimeSubquery = query.subquery(LocalDateTime.class);
            Root<OrderStatus> orderStatusRoot = maxUpdateTimeSubquery.from(OrderStatus.class);
            maxUpdateTimeSubquery.select(criteriaBuilder.greatest(orderStatusRoot.<LocalDateTime>get("updateTime")));
            maxUpdateTimeSubquery.where(criteriaBuilder.equal(orderStatusRoot.get("id").get("orderId"), root.get("id")));

            // Join Order with OrderStatus
            Join<Order, OrderStatus> orderStatusJoin = root.join("orderStatuses");
            return criteriaBuilder.and(
                criteriaBuilder.equal(orderStatusJoin.get("id").get("status"), value),
                criteriaBuilder.equal(orderStatusJoin.get("updateTime"), maxUpdateTimeSubquery)
            );
        }

        return null;
    }

    public static Specification<Order> buildWhere(String search, OrderFilterForm form) {
        Specification<Order> where = null;

        if (form != null) {

            if (!StringUtils.isEmptyOrWhitespaceOnly(search)) {
                search = search.trim();
                OrderSpecification orderId = new OrderSpecification("orderId", search);
                where = Specification.where(orderId);
            }


            if (form.getFrom() != null) {
                OrderSpecification toSpec = new OrderSpecification("from", form.getFrom());
                if (where != null) {
                    where = where.and(toSpec);
                } else {
                    where = Specification.where(toSpec);
                }
            }

            if (form.getTo() != null) {
                OrderSpecification toSpec = new OrderSpecification("to", form.getTo());
                if (where != null) {
                    where = where.and(toSpec);
                } else {
                    where = Specification.where(toSpec);
                }
            }

            if (form.getStatus() != null) {
                OrderSpecification statusSpec = new OrderSpecification("status", form.getStatus());
                if (where != null) {
                    where = where.and(statusSpec);
                } else {
                    where = Specification.where(statusSpec);
                }
            }

            if (form.getType() != null) {
                OrderSpecification typeSpec = new OrderSpecification("type", form.getType());
                if (where != null) {
                    where = where.and(typeSpec);
                } else {
                    where = Specification.where(typeSpec);
                }
            }
        }

        return where;
    }
}