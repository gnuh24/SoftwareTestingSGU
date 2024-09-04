package BackEnd.Specification.AccountSpecifications;

import BackEnd.Entity.AccountEntity.Account;
import BackEnd.Form.UsersForms.AccountForms.AccountFilterForm;
import com.mysql.cj.util.StringUtils;
import jakarta.persistence.criteria.CriteriaBuilder;
import jakarta.persistence.criteria.CriteriaQuery;
import jakarta.persistence.criteria.Predicate;
import jakarta.persistence.criteria.Root;
import jakarta.validation.constraints.NotNull;
import lombok.Data;
import lombok.NonNull;
import org.springframework.data.jpa.domain.Specification;

import java.util.Date;

@Data
public class AccountSpecification implements Specification<Account> {

    @NonNull
    private String field;

    @NonNull
    private Object value;

    @Override
    public Predicate toPredicate(@NotNull Root<Account> root,
                                 @NotNull CriteriaQuery<?> query,
                                 @NonNull CriteriaBuilder criteriaBuilder) {

        if (field.equalsIgnoreCase("role")) {
            return criteriaBuilder.equal(root.get("role"), value);
        }

        if (field.equalsIgnoreCase("status")) {
            return criteriaBuilder.equal(root.get("status"), value);
        }

        if (field.equalsIgnoreCase("from")) {
            return criteriaBuilder.greaterThanOrEqualTo(root.get("createAt").as(Date.class), (Date) value);
        }

        if (field.equalsIgnoreCase("to")) {
            return criteriaBuilder.lessThanOrEqualTo(root.get("createAt").as(Date.class), (Date) value);
        }

        if (field.equalsIgnoreCase("email")) {
            return criteriaBuilder.like(root.get("userInformation").get("email"), "%" + value + "%");
        }

        return null;
    }

    public static Specification<Account> buildWhere(String search, AccountFilterForm form) {
        Specification<Account> where = null;

        if (!StringUtils.isEmptyOrWhitespaceOnly(search)) {
            search = search.trim();
            AccountSpecification roleSpec = new AccountSpecification("email", search);
            where = Specification.where(roleSpec);
        }

        if (form != null) {

            if (form.getRole() != null) {
                AccountSpecification roleSpec = new AccountSpecification("role", form.getRole());
                if (where != null) {
                    where = where.and(roleSpec);
                } else {
                    where = Specification.where(roleSpec);
                }
            }

            if (form.getStatus() != null) {
                AccountSpecification status = new AccountSpecification("status", form.getStatus());
                if (where != null) {
                    where = where.and(status);
                } else {
                    where = Specification.where(status);
                }
            }

            if (form.getFrom() != null) {
                AccountSpecification fromSpec = new AccountSpecification("from", form.getFrom());
                if (where != null) {
                    where = where.and(fromSpec);
                } else {
                    where = Specification.where(fromSpec);
                }
            }

            if (form.getTo() != null) {
                AccountSpecification toSpec = new AccountSpecification("to", form.getTo());
                if (where != null) {
                    where = where.and(toSpec);
                } else {
                    where = Specification.where(toSpec);
                }
            }

        }

        return where;
    }
}
