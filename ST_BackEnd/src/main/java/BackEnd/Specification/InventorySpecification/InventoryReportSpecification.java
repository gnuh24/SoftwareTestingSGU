package BackEnd.Specification.InventorySpecification;

import BackEnd.Entity.InventoryEntities.InventoryReport;
import BackEnd.Entity.InventoryEntities.InventoryReportStatus;
import BackEnd.Form.InventoryForms.InventoryReportForms.InventoryReportFilterForm;
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

        if (field.equalsIgnoreCase("status")) {
            // Create a subquery to find the maximum updateTime for each inventoryReportId
            Subquery<LocalDateTime> maxUpdateTimeSubquery = query.subquery(LocalDateTime.class);
            Root<InventoryReportStatus> inventoryReportStatusRoot = maxUpdateTimeSubquery.from(InventoryReportStatus.class);
            maxUpdateTimeSubquery.select(criteriaBuilder.greatest(inventoryReportStatusRoot.<LocalDateTime>get("updateTime")));
            maxUpdateTimeSubquery.where(criteriaBuilder.equal(inventoryReportStatusRoot.get("id").get("inventoryReportId"), root.get("id")));

            // Join InventoryReport & InventoryReportStatus
            Join<InventoryReport, InventoryReportStatus> inventoryReportStatusJoin = root.join("inventoryReportStatuses");
            return criteriaBuilder.and(
                criteriaBuilder.equal(inventoryReportStatusJoin.get("id").get("status"), value),
                criteriaBuilder.equal(inventoryReportStatusJoin.get("updateTime"), maxUpdateTimeSubquery)
            );
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

            if (form.getStatus() != null && !form.getStatus().equals("")) {
                InventoryReportSpecification statusSpec = new InventoryReportSpecification("status", form.getStatus());
                if (where != null) {
                    where = where.and(statusSpec);
                } else {
                    where = Specification.where(statusSpec);
                }
            }
        }

        return where;
    }
}
