package BackEnd.Other;

import com.cloudinary.Cloudinary;
import com.cloudinary.utils.ObjectUtils;
import org.springframework.web.multipart.MultipartFile;

import java.io.IOException;
import java.io.InputStream;
import java.util.HashMap;
import java.util.Map;


public class CloundinaryServices {

    private static final String folder = "SoftwareTestingProject";

    private static final String urlImage = "http://res.cloudinary.com/djhoea2bo/image/upload/v1711511636/";

    public static String getUrlImage(String link){
        return urlImage+link;
    }

    /*************************
     *  Tạo đối tượng Cloundinary -> Kết nối với đám mây
     *  Giải thích: new Cloudinary("cloudinary://api_key:api_secret@cloud_name");
     *       + "cloud_name": Tên của cloud ban muốn lưu data vào
     *       + "api_key":     Key này dùng để xác định xem là Clound đó thuộc vào tài khoản nào
     *       + "api_secret":  Đây là key độc quyền của mỗi clound ta dùng nó để xác thực.
     * **********************/

    // Tạo bằng call API
    private static final Cloudinary cloudinary  = new Cloudinary(
        "cloudinary://863825655141484:G-81wEgAwc9q-bOS_z0Xf3Q6vxc@djhoea2bo"
    );


    public static String createImage(String imageUrl){

        try {
            /*****************
             *  Tải lên ảnh và lưu vào thư mục SoftwareTestingProject trên Cloudinary
             *      upload nhận 2 tham số đầu vào
             *          1. String: URL của ảnh  (User nhập vào)
             *          2. String: Folder bạn muốn lưu trên clound
             ********************/

            Map<String, Object> params = new HashMap<>();
            params.put("folder", CloundinaryServices.folder); // Thư mục bạn muốn lưu trên Cloudinary
            // Tên của ảnh trên Cloudinary
            params.put("public_id", imageUrl.substring(imageUrl.lastIndexOf("\\")+1,imageUrl.lastIndexOf(".")));

            Map uploadResult = cloudinary.uploader().upload(imageUrl, params);

            System.out.println("Image uploaded successfully.");

            //Tên của ảnh trên Clound
            System.out.println("Public ID: " + uploadResult.get("public_id"));

            //URL của ảnh trên Clound
            System.out.println("URL: " + uploadResult.get("url"));

            // Trả về endpoint
            return uploadResult.get("public_id").toString();

        } catch (Exception e) {
            System.err.println(e.getMessage());;
        }

        return null;
    }

    public static String createImageFromMultipart(MultipartFile file) {
        try {
            // Chuyển MultipartFile thành InputStream
            InputStream inputStream = file.getInputStream();

            Map<String, Object> params = new HashMap<>();
            params.put("folder", folder); // Thư mục lưu trên Cloudinary

            // Tên của ảnh trên Cloudinary
            String fileName = file.getOriginalFilename();
            String publicId = fileName != null ? fileName.substring(0, fileName.lastIndexOf('.')) : "default";

            params.put("public_id", publicId);

            Map uploadResult = cloudinary.uploader().upload(inputStream, params);

            System.out.println("Image uploaded successfully.");
            System.out.println("Public ID: " + uploadResult.get("public_id"));
            System.out.println("URL: " + uploadResult.get("url"));

            return uploadResult.get("public_id").toString();
        } catch (Exception e) {
            System.err.println(e.getMessage());
        }
        return null;
    }

    public static void deleteImage(String publicId){
        try {
            // Xóa hình ảnh
            cloudinary.uploader().destroy(publicId, ObjectUtils.emptyMap());
            System.out.println("Đã xóa hình ảnh thành công!");

        } catch (Exception e) {
            System.out.println("Lỗi xóa hình ảnh: " + e.getMessage());
        }
    }

}
