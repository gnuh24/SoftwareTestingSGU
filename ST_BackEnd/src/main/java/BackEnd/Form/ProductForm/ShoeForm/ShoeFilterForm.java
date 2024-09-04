package BackEnd.Form.ProductForm.ShoeForm;


import lombok.AllArgsConstructor;
import lombok.Data;
import lombok.NoArgsConstructor;
import org.springframework.format.annotation.DateTimeFormat;

import java.time.LocalDate;
import java.util.Date;
import java.util.List;

@Data
@NoArgsConstructor
@AllArgsConstructor
public class ShoeFilterForm {

    //Admin
    private Boolean status;

    @DateTimeFormat(pattern = "dd/MM/yyyy")
    private Date minCreateDate;

    @DateTimeFormat(pattern = "dd/MM/yyyy")
    private Date maxCreateDate;

    private Boolean priority;

    private  Integer brandId;

    private  Integer shoeTypeId;

    private List< Integer> listShoeColorId;


    //User

    private Integer minPrice;

    private Integer maxPrice;

    // Event

    private Integer eventId;

}
