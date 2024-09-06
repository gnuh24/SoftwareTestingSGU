<?php 
    require_once __DIR__ . "/../../Configure/MysqlConfig.php";

    //Dùng để kiểm tra xem TenDangNhap có tồn tại hay không ?
    if(isset($_GET['email'])) {
        $email = $_GET['email'];

        // Gọi hàm PHP bạn muốn thực thi và trả về kết quả dưới dạng JSON
        // $result = getAllTaiKhoan($page, $search, $quyen);
        $result = isEmailExists($email);

        echo json_encode($result);

    }
    // Kiểm tra xem các khóa cần thiết đã tồn tại trong $_POST hay không
    if(isset($_POST['hoTen']) && isset($_POST['ngaySinh']) && isset($_POST['gioiTinh']) && isset($_POST['soDienThoai']) && isset($_POST['email']) && isset($_POST['diaChi'])) {
        // Lấy các giá trị từ POST request
        $hoTen = $_POST['hoTen'];
        $ngaySinh = $_POST['ngaySinh'];
        $gioiTinh = $_POST['gioiTinh'];
        $soDienThoai = $_POST['soDienThoai'];
        $email = $_POST['email'];
        $diaChi = $_POST['diaChi'];

        if (isset($_POST['maNguoiDung'])){
            // Nếu tồn tại mã người dùng, gọi hàm updateNguoiDung
            $maNguoiDung = $_POST['maNguoiDung'];
            $result = updateNguoiDung($maNguoiDung, $hoTen, $ngaySinh, $gioiTinh, $soDienThoai, $email, $diaChi);
        } else {
            // Nếu không tồn tại mã người dùng, gọi hàm createNguoiDung
            $result = createNguoiDung($hoTen, $ngaySinh, $gioiTinh, $soDienThoai, $email, $diaChi);
        }

        // Trả về kết quả dưới dạng JSON
        echo json_encode($result);
    } 

    function getNguoiDungByMaNguoiDung($maNguoiDung){
        //Chuẩn bị trước biến $connection
        $connection = null;

        //Chuẩn bị câu truy vấn gốc
        $query = "SELECT * FROM `NguoiDung` WHERE `MaNguoiDung` = :maNguoiDung";
    
        // Khởi tạo kết nối
        $connection = MysqlConfig::getConnection();
    
    
        // Khởi tạo kết nối đến cơ sở dữ liệu
        try {

            $statement = $connection->prepare($query);
      
            if ($statement !== false) {
      
                $statement->bindValue(':maNguoiDung', $maNguoiDung, PDO::PARAM_INT);
      
                $statement->execute();
      
                $result = $statement->fetchAll(PDO::FETCH_ASSOC);
      
                return (object) [
                    "status" => 200,
                    "message" => "Thành công",
                    "data" => $result,
                ];
            } else {
              throw new PDOException();
            }
        } catch (PDOException $e) {
            return (object) [
                "status" => 400,
                "message" => "Lỗi không thể lấy quyền",
            ];
        } finally {
            $connection = null;
        }
    }

    function isEmailExists($email) {
        // Chuẩn bị biến kết nối
        $connection = null;
    
        // Chuẩn bị câu truy vấn gốc
        $query = "SELECT * FROM `NguoiDung` WHERE `Email` = :email";
    
        try {
            // Khởi tạo kết nối đến cơ sở dữ liệu
            $connection = MysqlConfig::getConnection();
    
            // Chuẩn bị câu truy vấn
            $statement = $connection->prepare($query);
    
            // Kiểm tra câu truy vấn
            if ($statement !== false) {
                // Bind giá trị vào tham số của câu truy vấn
                $statement->bindValue(':email', $email, PDO::PARAM_STR);
    
                // Thực thi câu truy vấn
                $statement->execute();
    
                // Lấy kết quả
                $result = $statement->fetchAll(PDO::FETCH_ASSOC);
    
                // Kiểm tra xem email có tồn tại hay không
                $isExists = !empty($result) ? true : false;
    
                // Trả về kết quả dưới dạng object
                return (object) [
                    "status" => 200,
                    "message" => "Truy vấn thành công !!",
                    "isExists" => $isExists
                ];
            } else {
                throw new PDOException();
            }
        } catch (PDOException $e) {
            // Xử lý ngoại lệ PDOException
            return (object) [
                "status" => 400,
                "message" => "Lỗi không thể lấy dữ liệu từ cơ sở dữ liệu",
                "isExists" => false
            ];
        } finally {
            // Đóng kết nối
            $connection = null;
        }
    }
    

    function createNguoiDung(   $hoTen,
                                $ngaySinh, 
                                $gioiTinh,
                                $soDienThoai, 
                                $email, 
                                $diaChi) {
    
        // Khởi tạo kết nối
        $connection = MysqlConfig::getConnection();
    
        $query = "INSERT INTO `NguoiDung` (`HoTen`, `NgaySinh`, `GioiTinh`, `SoDienThoai`, `Email`, `DiaChi`) 
                                    VALUES (:hoTen, :ngaySinh, :gioiTinh, :soDienThoai, :email, :diaChi)";
        
        try {
        
            $statement = $connection->prepare($query);
        
            if ($statement !== false) {
        
                // Bind giá trị vào các tham số trong câu truy vấn
                $statement->bindValue(':hoTen', $hoTen, PDO::PARAM_STR);
                $statement->bindValue(':ngaySinh', $ngaySinh, PDO::PARAM_STR);
                $statement->bindValue(':gioiTinh', $gioiTinh, PDO::PARAM_STR);
                $statement->bindValue(':soDienThoai', $soDienThoai, PDO::PARAM_STR);
                $statement->bindValue(':email', $email, PDO::PARAM_STR);
                $statement->bindValue(':diaChi', $diaChi, PDO::PARAM_STR);
        
                // Thực hiện truy vấn
                $statement->execute();
        
                // Mã người dùng vừa được tạo
                $id = $connection->lastInsertId();
    
                // Trả về ID của bản ghi vừa chèn
                return (object) [
                    "status" => 200,
                    "message" => "Thành công",
                    "data" => $id
                ];
            } else {
                // Trả về false nếu không thành công
                throw new PDOException();
            }
        } catch (PDOException $e) {
            return (object) [
                "status" => 400,
                "message" => $e->getMessage()
            ];
        } finally {
            $connection = null;
        }
    }
    

    function updateNguoiDung($maNguoiDung, $hoTen, $ngaySinh, $gioiTinh, $soDienThoai, $email, $diaChi) {
        // Khởi tạo kết nối
        $connection = MysqlConfig::getConnection();
        $tmp = 1;
        if(is_null($email))
        $query = "UPDATE `NguoiDung` SET 
        `HoTen` = :hoTen,
        `NgaySinh` = :ngaySinh,
        `GioiTinh` = :gioiTinh,
        `SoDienThoai` = :soDienThoai,
        `DiaChi` = :diaChi
    WHERE `MaNguoiDung` = :maNguoiDung";
    else
        $query = "UPDATE `NguoiDung` SET 
                    `HoTen` = :hoTen,
                    `NgaySinh` = :ngaySinh,
                    `GioiTinh` = :gioiTinh,
                    `SoDienThoai` = :soDienThoai,
                    `Email` = :email,
                    `DiaChi` = :diaChi
                WHERE `MaNguoiDung` = :maNguoiDung";
    
        try {
            $statement = $connection->prepare($query);
    
            if ($statement !== false) {
                // Bind giá trị vào các tham số trong câu truy vấn
                $statement->bindValue(':maNguoiDung', $maNguoiDung, PDO::PARAM_INT);
                $statement->bindValue(':hoTen', $hoTen, PDO::PARAM_STR);
                $statement->bindValue(':ngaySinh', $ngaySinh, PDO::PARAM_STR);
                $statement->bindValue(':gioiTinh', $gioiTinh, PDO::PARAM_STR);
                $statement->bindValue(':soDienThoai', $soDienThoai, PDO::PARAM_STR);
                if(!is_null($email))
                {
                    $statement->bindValue(':email', $email, PDO::PARAM_STR);
                }
                $statement->bindValue(':diaChi', $diaChi, PDO::PARAM_STR);
    
                // Thực hiện truy vấn
                $statement->execute();
    
                // Kiểm tra xem có bản ghi nào được cập nhật không
                if ($statement->rowCount() >= 0) {
                    // Trả về thành công nếu có bản ghi được cập nhật
                    return (object) [
                        "status" => 200,
                        "message" => "Thành công",
                    ];
                } else {
                    // Trả về false nếu không có bản ghi nào được cập nhật
                    throw new PDOException("Không có bản ghi nào được cập nhật");
                }
            }
        } catch (PDOException $e) {
            return (object) [
                "status" => 400,
                "message" => $e->getMessage()
            ];
        } finally {
            $connection = null;
        }
    }

?>
