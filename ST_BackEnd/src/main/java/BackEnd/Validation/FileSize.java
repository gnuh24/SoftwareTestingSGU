package BackEnd.Validation;


    import static java.lang.annotation.ElementType.ANNOTATION_TYPE;
    import static java.lang.annotation.ElementType.CONSTRUCTOR;
    import static java.lang.annotation.ElementType.FIELD;
    import static java.lang.annotation.ElementType.METHOD;
    import static java.lang.annotation.ElementType.PARAMETER;
    import static java.lang.annotation.ElementType.TYPE_USE;
    import static java.lang.annotation.RetentionPolicy.RUNTIME;

    import java.lang.annotation.Retention;
    import java.lang.annotation.Target;

    import jakarta.validation.Constraint;
    import jakarta.validation.Payload;

@Target({ METHOD, FIELD, ANNOTATION_TYPE, CONSTRUCTOR, PARAMETER, TYPE_USE })
@Retention(RUNTIME)
@Constraint(validatedBy = { FileSizeValidator.class })
public @interface FileSize {

    String message() default "Bạn chỉ có thể gửi file có kích thước đối đa 5MB";

    Class<?>[] groups() default { };

    Class<? extends Payload>[] payload() default { };

    String max();

}