package BackEnd.Specification.InventorySpecification;

import BackEnd.Entity.InventoryEntities.InventoryReport;
import BackEnd.Form.InventoryForms.InventoryReportForms.InventoryReportFilterForm;
import com.mysql.cj.util.StringUtils;
import jakarta.persistence.criteria.*;
import lombok.AllArgsConstructor;
import lombok.Data;
import lombok.NonNull;
import org.springframework.data.jpa.domain.Specification;

import java.util.Date;

@Data
@AllArgsConstructor
public class InventoryReportSpecification implements Specification<InventoryReport> {

    @NonNull
    private String field;

    @NonNull
    private Object value;

    @Override
    public Predicate toPredicate(@NonNull Root<InventoryReport> root,
                                 @NonNull CriteriaQuery<?> query,
                                 @NonNull CriteriaBuilder criteriaBuilder) {

        if (field.equalsIgnoreCase("supplier")) {
            return criteriaBuilder.like(root.get("supplier"), "%" + value + "%");
        }

        if (field.equalsIgnoreCase("supplierPhone")) {
            return criteriaBuilder.like(root.get("supplierPhone"), "%" + value + "%");
        }

        if (field.equalsIgnoreCase("from")) {
            return criteriaBuilder.greaterThanOrEqualTo(root.get("createTime").as(java.sql.Date.class), (Date) value);
        }

        if (field.equalsIgnoreCase("to")) {
            return criteriaBuilder.lessThanOrEqualTo(root.get("createTime").as(java.sql.Date.class), (Date) value);
        }

        return null;
    }


    public static Specification<InventoryReport> buildWhere(String search, InventoryReportFilterForm form) {
        Specification<InventoryReport> where = null;

        if (form != null) {

            if (!StringUtils.isEmptyOrWhitespaceOnly(search)) {
                search = search.trim();
                InventoryReportSpecification supplierSpec = new InventoryReportSpecification("supplier", search);
                where = Specification.where(supplierSpec);
            }

            if (form.getFrom() != null) {
                InventoryReportSpecification fromSpec = new InventoryReportSpecification("from", form.getFrom());
                if (where != null) {
                    where = where.and(fromSpec);
                } else {
                    where = Specification.where(fromSpec);
                }
            }

            if (form.getTo() != null) {
                InventoryReportSpecification toSpec = new InventoryReportSpecification("to", form.getTo());
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
