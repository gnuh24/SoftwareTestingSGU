package BackEnd.Specification.ProductSpecification;

import BackEnd.Entity.ProductEntity.Product;
import BackEnd.Form.ProductForm.ProductForms.ProductFilterForm;
import com.mysql.cj.util.StringUtils;
import jakarta.persistence.criteria.*;
import lombok.Data;
import lombok.NonNull;
import org.springframework.data.jpa.domain.Specification;

import java.util.Date;


@Data
public class ProductSpecification implements Specification<Product> {

    @NonNull
    private String field;

    @NonNull
    private Object value;

    @Override
    //Đây là phương thức ta dùng để custom filter
    public Predicate toPredicate(@NonNull  Root<Product> root,
                                 @NonNull  CriteriaQuery<?> query,
                                 @NonNull  CriteriaBuilder criteriaBuilder) {

        if (field.equalsIgnoreCase("id")){
            return criteriaBuilder.equal(root.get("id") ,value);
        }

        if (field.equalsIgnoreCase("productName")){
            return criteriaBuilder.like(root.get("productName") ,"%" + value  + "%");
        }

        if (field.equalsIgnoreCase("status")){
            return criteriaBuilder.equal(root.get("status"), value);
        }

        if (field.equalsIgnoreCase("minCreateTime")){
            return criteriaBuilder.greaterThanOrEqualTo(root.get("createTime").as(java.sql.Date.class) , (Date) value);
        }

        if (field.equalsIgnoreCase("maxCreateTime")){
            return criteriaBuilder.lessThanOrEqualTo(root.get("createTime").as(java.sql.Date.class) , (Date) value);
        }

        if (field.equalsIgnoreCase("brandId")){
            return criteriaBuilder.equal(root.get("brand").get("id"), value);
        }

        if (field.equalsIgnoreCase("categoryId")){
            return criteriaBuilder.equal(root.get("category").get("id"), value);
        }

        if (field.equalsIgnoreCase("minPrice")){
            return criteriaBuilder.greaterThanOrEqualTo( root.get("price"), (Integer) value);
        }

        if (field.equalsIgnoreCase("maxPrice")){
            return criteriaBuilder.lessThanOrEqualTo( root.get("price"), (Integer) value);
        }

        return null;
    }


    public static Specification<Product> buildWhere(String search,
                                                    ProductFilterForm form){
        Specification<Product> where = null;

        //Filter cho thanh tìm kiếm
        if (!StringUtils.isEmptyOrWhitespaceOnly(search)) {
            search = search.trim();
            ProductSpecification productName = new ProductSpecification("productName", search);
            ProductSpecification id = null;
            try{
                Integer num = Integer.parseInt(search);
                id = new ProductSpecification("id", num);
                where = Specification.where(productName).or(id);
            }catch (NumberFormatException e){
                where = Specification.where(productName);
            }
        }


        if (form != null){

            //Filter cho Combobox Status (Trạng thái)
            if (form.getStatus() != null && !form.getStatus().equals("")){
                ProductSpecification status = new ProductSpecification("status", form.getStatus());
                if (where != null){
                    where = where.and(status);
                }else{
                    where = Specification.where(status);
                }
            }



            //Filter cho bộ lọc theo ngày ( Cận dưới )
            if (form.getMinCreateTime() != null){
                ProductSpecification minCreateDate = new ProductSpecification("minCreateTime", form.getMinCreateTime());
                if (where != null){
                    where = where.and(minCreateDate);
                }else{
                    where = Specification.where(minCreateDate);
                }
            }

            //Filter cho bộ lọc theo ngày ( Cận trên )
            if (form.getMaxCreateTime() != null){
                ProductSpecification maxCreateDate = new ProductSpecification("maxCreateTime", form.getMaxCreateTime());
                if (where != null){
                    where = where.and(maxCreateDate);
                }else{
                    where = Specification.where(maxCreateDate);
                }
            }

            //Filter cho bộ lọc theo thương hiệu
            if (form.getBrandId() != null){
                ProductSpecification brandId = new ProductSpecification("brandId", form.getBrandId());
                if (where != null){
                    where = where.and(brandId);
                }else{
                    where = Specification.where(brandId);
                }
            }

            //Filter cho bộ lọc theo loại sản phẩm
            if (form.getCategoryId() != null){
                ProductSpecification shoeTypeId = new ProductSpecification("categoryId", form.getCategoryId());
                if (where != null){
                    where = where.and(shoeTypeId);
                }else{
                    where = Specification.where(shoeTypeId);
                }
            }

            //Filter cho bộ lọc theo cận dưới của giá sản phẩm
            if (form.getMinPrice() != null){
                ProductSpecification minPrice = new ProductSpecification("minPrice", form.getMinPrice());
                if (where != null){
                    where = where.and(minPrice);
                }else{
                    where = Specification.where(minPrice);
                }
            }

            //Filter cho bộ lọc theo cận trên của giá sản phẩm
            if (form.getMaxPrice() != null){
                ProductSpecification maxPrice = new ProductSpecification("maxPrice", form.getMaxPrice());
                if (where != null){
                    where = where.and(maxPrice);
                }else{
                    where = Specification.where(maxPrice);
                }
            }



        }


        return where;
    }


}
