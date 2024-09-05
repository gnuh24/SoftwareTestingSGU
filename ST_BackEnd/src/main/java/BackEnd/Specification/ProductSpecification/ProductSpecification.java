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

        if (field.equalsIgnoreCase("shoeId")){
            return criteriaBuilder.equal(root.get("shoeId") ,value);
        }

        if (field.equalsIgnoreCase("shoeName")){
            return criteriaBuilder.like(root.get("shoeName") ,"%" + value  + "%");
        }

        if (field.equalsIgnoreCase("status")){
            return criteriaBuilder.equal(root.get("status"), value);
        }

        if (field.equalsIgnoreCase("minCreateDate")){
            return criteriaBuilder.greaterThanOrEqualTo(root.get("createDate").as(java.sql.Date.class) , (Date) value);
        }

        if (field.equalsIgnoreCase("maxCreateDate")){
            return criteriaBuilder.lessThanOrEqualTo(root.get("createDate").as(java.sql.Date.class) , (Date) value);
        }

        if (field.equalsIgnoreCase("brandId")){
            return criteriaBuilder.equal(root.get("brand").get("brandId"), value);
        }

        if (field.equalsIgnoreCase("shoeTypeId")){
            return criteriaBuilder.equal(root.get("shoeType").get("shoeTypeId"), value);
        }

//        if (field.equalsIgnoreCase("minPrice")) {
//            // Tạo một subquery để lấy giá trị nhỏ nhất của price từ ShoeSize
//            Subquery<Integer> subquery = query.subquery(Integer.class);
//
//            // Tạo root cho subquery từ ShoeSize
//            Root<ShoeSize> subRoot = subquery.from(ShoeSize.class);
//
//            // Chọn giá trị nhỏ nhất của price trong subquery
//            subquery.select(criteriaBuilder.min(subRoot.get("price")));
//
//            // Điều kiện của subquery: shoeId của ShoeSize bằng shoeId của root (Product)
//            subquery.where(criteriaBuilder.equal(subRoot.get("shoe").get("shoeId"), root.get("shoeId")));
//
//            // Trả về điều kiện: giá trị của subquery phải lớn hơn hoặc bằng giá trị được cung cấp
//            return criteriaBuilder.greaterThanOrEqualTo(subquery, (Integer) value);
//        }
//
//        if (field.equalsIgnoreCase("maxPrice")) {
//            // Tạo một subquery để lấy giá trị nhỏ nhất của price từ ShoeSize
//            Subquery<Integer> subquery = query.subquery(Integer.class);
//
//            // Tạo root cho subquery từ ShoeSize
//            Root<ShoeSize> subRoot = subquery.from(ShoeSize.class);
//
//            // Chọn giá trị nhỏ nhất của price trong subquery
//            subquery.select(criteriaBuilder.min(subRoot.get("price")));
//
//            // Điều kiện của subquery: shoeId của ShoeSize bằng shoeId của root (Product)
//            subquery.where(criteriaBuilder.equal(subRoot.get("shoe").get("shoeId"), root.get("shoeId")));
//
//            // Trả về điều kiện: giá trị của subquery phải nhỏ hơn hoặc bằng giá trị được cung cấp
//            return criteriaBuilder.lessThanOrEqualTo(subquery, (Integer) value);
//        }


        return null;
    }


    public static Specification<Product> buildWhere(String search,
                                                    ProductFilterForm form){
        Specification<Product> where = null;

        //Filter cho thanh tìm kiếm
        if (!StringUtils.isEmptyOrWhitespaceOnly(search)) {
            search = search.trim();
            ProductSpecification shoeName = new ProductSpecification("shoeName", search);
            ProductSpecification shoeId = null;
            try{
                Integer num = Integer.parseInt(search);
                shoeId = new ProductSpecification("shoeId", num);
                where = Specification.where(shoeName).or(shoeId);
            }catch (NumberFormatException e){
                where = Specification.where(shoeName);
            }
        }


        if (form != null){

            //Filter cho Combobox Status (Trạng thái)
            if (form.getStatus() != null){
                ProductSpecification status = new ProductSpecification("status", form.getStatus());
                if (where != null){
                    where = where.and(status);
                }else{
                    where = Specification.where(status);
                }
            }



            //Filter cho bộ lọc theo ngày ( Cận dưới )
            if (form.getMinCreateDate() != null){
                ProductSpecification minCreateDate = new ProductSpecification("minCreateDate", form.getMinCreateDate());
                if (where != null){
                    where = where.and(minCreateDate);
                }else{
                    where = Specification.where(minCreateDate);
                }
            }

            //Filter cho bộ lọc theo ngày ( Cận trên )
            if (form.getMaxCreateDate() != null){
                ProductSpecification maxCreateDate = new ProductSpecification("maxCreateDate", form.getMaxCreateDate());
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
                ProductSpecification shoeTypeId = new ProductSpecification("shoeTypeId", form.getCategoryId());
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
