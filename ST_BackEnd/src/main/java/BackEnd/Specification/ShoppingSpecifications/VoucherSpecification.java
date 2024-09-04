package BackEnd.Specification.ShoppingSpecifications;

import BackEnd.Entity.ShoppingEntities.Voucher;
import BackEnd.Form.ShoppingForms.VoucherForms.VoucherFilterForm;
import com.mysql.cj.util.StringUtils;
import jakarta.persistence.criteria.*;
import lombok.AllArgsConstructor;
import lombok.Data;
import lombok.NonNull;
import org.springframework.data.jpa.domain.Specification;

import java.time.LocalDateTime;

@Data
@AllArgsConstructor
public class VoucherSpecification implements Specification<Voucher> {

    @NonNull
    private String field;

    @NonNull
    private Object value;

    @Override
    public Predicate toPredicate(@NonNull Root<Voucher> root,
                                 @NonNull CriteriaQuery<?> query,
                                 @NonNull CriteriaBuilder criteriaBuilder) {

        if (field.equalsIgnoreCase("voucherId")) {
            return criteriaBuilder.equal(root.get("voucherId"), value);
        }

        if (field.equalsIgnoreCase("code")) {
            return criteriaBuilder.like(root.get("code"), "%" + value + "%");
        }

        if (field.equalsIgnoreCase("title")) {
            return criteriaBuilder.like(root.get("title"), "%" + value + "%");
        }

        if (field.equalsIgnoreCase("status")) {
            return criteriaBuilder.equal(root.get("status"), value);
        }

        if (field.equalsIgnoreCase("from")) {
            return criteriaBuilder.greaterThanOrEqualTo(root.get("expirationTime").as(LocalDateTime.class), (LocalDateTime) value);
        }

        if (field.equalsIgnoreCase("to")) {
            return criteriaBuilder.lessThanOrEqualTo(root.get("expirationTime").as(LocalDateTime.class), (LocalDateTime) value);
        }

        if (field.equalsIgnoreCase("minCondition")) {
            return criteriaBuilder.greaterThanOrEqualTo(root.get("condition"), (Integer) value);
        }

        if (field.equalsIgnoreCase("maxCondition")) {
            return criteriaBuilder.lessThanOrEqualTo(root.get("condition"), (Integer) value);
        }

        if (field.equalsIgnoreCase("isFreeShip")) {
            return criteriaBuilder.equal(root.get("isFreeShip"), value);
        }

        if (field.equalsIgnoreCase("minDiscountAmount")) {
            return criteriaBuilder.greaterThanOrEqualTo(root.get("discountAmount"), (Integer) value);
        }

        if (field.equalsIgnoreCase("maxDiscountAmount")) {
            return criteriaBuilder.lessThanOrEqualTo(root.get("discountAmount"), (Integer) value);
        }

        return null;
    }

    public static Specification<Voucher> buildWhere(String search, VoucherFilterForm form) {
        Specification<Voucher> where = null;

        if (form != null) {

            if (!StringUtils.isEmptyOrWhitespaceOnly(search)) {
                search = search.trim();
                VoucherSpecification codeSpec = new VoucherSpecification("code", search);
                VoucherSpecification titleSpec = new VoucherSpecification("title", search);
                where = Specification.where(codeSpec).or(titleSpec);
            }

            if (form.getFrom() != null) {
                VoucherSpecification fromSpec = new VoucherSpecification("from", form.getFrom());
                if (where != null) {
                    where = where.and(fromSpec);
                } else {
                    where = Specification.where(fromSpec);
                }
            }

            if (form.getTo() != null) {
                VoucherSpecification toSpec = new VoucherSpecification("to", form.getTo());
                if (where != null) {
                    where = where.and(toSpec);
                } else {
                    where = Specification.where(toSpec);
                }
            }

            if (form.getStatus() != null) {
                VoucherSpecification statusSpec = new VoucherSpecification("status", form.getStatus());
                if (where != null) {
                    where = where.and(statusSpec);
                } else {
                    where = Specification.where(statusSpec);
                }
            }

            if (form.getMinCondition() != null) {
                VoucherSpecification minConditionSpec = new VoucherSpecification("minCondition", form.getMinCondition());
                if (where != null) {
                    where = where.and(minConditionSpec);
                } else {
                    where = Specification.where(minConditionSpec);
                }
            }

            if (form.getMaxCondition() != null) {
                VoucherSpecification maxConditionSpec = new VoucherSpecification("maxCondition", form.getMaxCondition());
                if (where != null) {
                    where = where.and(maxConditionSpec);
                } else {
                    where = Specification.where(maxConditionSpec);
                }
            }

            if (form.getIsFreeShip() != null) {
                VoucherSpecification isFreeShipSpec = new VoucherSpecification("isFreeShip", form.getIsFreeShip());
                if (where != null) {
                    where = where.and(isFreeShipSpec);
                } else {
                    where = Specification.where(isFreeShipSpec);
                }
            }

            if (form.getMinDiscountAmount() != null) {
                VoucherSpecification minDiscountAmountSpec = new VoucherSpecification("minDiscountAmount", form.getMinDiscountAmount());
                if (where != null) {
                    where = where.and(minDiscountAmountSpec);
                } else {
                    where = Specification.where(minDiscountAmountSpec);
                }
            }

            if (form.getMaxDiscountAmount() != null) {
                VoucherSpecification maxDiscountAmountSpec = new VoucherSpecification("maxDiscountAmount", form.getMaxDiscountAmount());
                if (where != null) {
                    where = where.and(maxDiscountAmountSpec);
                } else {
                    where = Specification.where(maxDiscountAmountSpec);
                }
            }
        }

        return where;
    }
}
