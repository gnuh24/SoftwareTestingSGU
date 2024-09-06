<?php 
    require_once __DIR__ . "/../../Configure/MysqlConfig.php";

    //Dùng để call List Tài khoản
    if(isset($_GET['page'])) {
        $page = $_GET['page'];
        $search = isset($_GET['search']) ? $_GET['search'] : "";
        $quyen = isset($_GET['quyen']) ? $_GET['quyen'] : "";

        // Gọi hàm PHP bạn muốn thực thi và trả về kết quả dưới dạng JSON
        // $result = getAllTaiKhoan($page, $search, $quyen);
        $result = getAllTaiKhoan($page, $search, $quyen, null);

        echo json_encode($result);
    }

    //Dùng để tại tài khoản
    if(isset($_POST['tenDangNhap']) && isset($_POST['matKhau']) && isset($_POST['quyen'])) {
        $tenDangNhap = $_POST['tenDangNhap'];
        $matKhau = $_POST['matKhau'];
        $quyen = $_POST['quyen'];

        // Gọi hàm createTaiKhoan và trả về kết quả dưới dạng JSON
        $result = createTaiKhoan($tenDangNhap, $matKhau, $quyen);

        echo json_encode($result);
    }

    //Dùng để update thông tin tài khoản
    if(isset($_POST['maTaiKhoan']) && isset($_POST['quyen'])) {
        $maTaiKhoan = $_POST['maTaiKhoan'];
        $quyen = $_POST['quyen'];
    
        if(isset($_POST['trangThai'])) {
            $trangThai = $_POST['trangThai'];
            $result = updateTaiKhoan($maTaiKhoan, $trangThai, $quyen);
        } else {
            $result = updatePhanQuyenTaiKhoan($maTaiKhoan, $quyen);
        }
    
        echo json_encode($result);
    }
    

     //Dùng để login
     if(isset($_GET['tenDangNhap']) && isset($_GET['isLogin'])) {
        $tenDangNhap = $_GET['tenDangNhap'];
        
        $result = getTaiKhoanByTenDangNhap($tenDangNhap);

        echo json_encode($result);

    }

    //Dùng để kiểm tra xem TenDangNhap có tồn tại hay không ?
    if(isset($_GET['tenDangNhap']) && !isset($_GET['isLogin'])) {
        $tenDangNhap = $_GET['tenDangNhap'];

        $result = isTenDangNhapExists($tenDangNhap);

        echo json_encode($result);

    }

    function getAllTaiKhoan1($quyen){

        //Chuẩn bị trước biến $connection
        $connection = null;

        //Chuẩn bị câu truy vấn gốc
        $query = "SELECT * FROM `TaiKhoan` JOIN `NguoiDung` ON `TaiKhoan`.`MaTaiKhoan` = `NguoiDung`.`MaNguoiDung` ";

        //Mảng chứa điều kiện
        $where_conditions=[];
        
        //Số phần tử mỗi trang
        $entityPerPage = 6;

        //Tổng số trang
        $totalPages = null;

        // Thêm điều kiện về quyền
        if (!empty($quyen)) {
            $where_conditions[] = "`Quyen` = '$quyen' ";
        }



        // Kết nối các điều kiện lại với nhau (Nếu không có thì skip)
        if (!empty($where_conditions)) {
            $query .= " WHERE " . implode(" AND ", $where_conditions);
        }

        // Khởi tạo kết nối
        $connection = MysqlConfig::getConnection();
    
    
         

            //fetchColumn ( <Cột thứ n> ) : Lấy row đầu tiên của cột thứ n - 1
            $query_total_row = substr_replace($query, "COUNT(*)", 7, 1);

            // Chạy lệnh Query để lấy ra tổng trang
            $statement_total_row = $connection->prepare($query_total_row);
            $statement_total_row->execute();
    
    
        // Khởi tạo kết nối đến cơ sở dữ liệu
    
        try {

            $statement = $connection->prepare($query);
    
            if ($statement !== false) {
    
                $statement->execute();
        
                $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        
                return (object) [
                    "status" => 200,
                    "message" => "Thành công",
                    "data" => $result

                ];
            } else {
                throw new PDOException();
            }
        } catch (PDOException $e) {
            return (object) [
                "status" => 400,
                "message" => "Lỗi không thể lấy danh sách tài khoản",
                "data" => []
            ];
        } finally {
            $connection = null;
        }
    }
   

    function getAllTaiKhoan($page, $search, $quyen, $trangThai){

        //Chuẩn bị trước biến $connection
        $connection = null;

        //Chuẩn bị câu truy vấn gốc
        $query = "SELECT * FROM `TaiKhoan` JOIN `NguoiDung` ON `TaiKhoan`.`MaTaiKhoan` = `NguoiDung`.`MaNguoiDung` ";

        //Mảng chứa điều kiện
        $where_conditions=[];
        
        //Số phần tử mỗi trang
        $entityPerPage = 5;

        //Tổng số trang
        $totalPages = null;


        /*
            Ý tưởng tổng quát về lọc
                - Cứ mỗi tham số lọc được set vào thì mảng điều kiện sẽ chứa thêm 1 điều kiện
                - Sau cùng ta chỉ cần hàm implode() để nối các điều kiện lại
                    implode(<Ký tự>, <Mảng>): Dùng để nối các ký tự torng mảng lại
                    VD: 
                            $array = array('apple', 'banana', 'orange');
                            $comma_separated = implode(", ", $array);
                            echo $comma_separated; // Kết quả: apple, banana, orange

        
        */
    
        // Lọc theo search
        if (!empty($search)) {
            $empty = false;
            $where_conditions[] .= "(`TenDangNhap`  LIKE '%" . $search . "%' OR 
                                    `Email`         LIKE '%" . $search . "%')";
        }

        // Thêm điều kiện về quyền
        if (!empty($quyen)) {
            $where_conditions[] = "`Quyen` = '$quyen' ";
        }

        // Thêm điều kiện về trạng thái
        if (!empty($trangThai)) {
            $where_conditions[] = "`TrangThai` = $trangThai";
        }
        
        // Kết nối các điều kiện lại với nhau (Nếu không có thì skip)
        if (!empty($where_conditions)) {
            $query .= " WHERE " . implode(" AND ", $where_conditions);
        }

        // Khởi tạo kết nối
        $connection = MysqlConfig::getConnection();
    
        // Tính toán tổng số trang
        if ($totalPages === null) {
    
            // Query dùng để tính tổng số trang của các data trả về
            /* 
                        Substr_replace là lệnh dùng để thay thế chuỗi trong PHP
                        Param 1: $query: Chuỗi cần thay ra
                        Param 2: "COUNT(*)": Chuỗi sẽ được thay vào
                        Param 3: 7: Thay thế bắt đầu từ vị trí ký tự 7 (Tính từ 0)
                        Param 4: 1: Thay đúng 1 ký tự 
                            Sample:
                        $query = "SELECT * FROM `TaiKhoan`";
                        $query_total_row = substr_replace($query, "COUNT(*)", 7, 1);
                        -> $query_total_row = "SELECT COUNT(*) FROM `TaiKhoan`"
    
            */

            //fetchColumn ( <Cột thứ n> ) : Lấy row đầu tiên của cột thứ n - 1
            $query_total_row = substr_replace($query, "COUNT(*)", 7, 1);

            // Chạy lệnh Query để lấy ra tổng trang
            $statement_total_row = $connection->prepare($query_total_row);
            $statement_total_row->execute();
    
            //Làm tròn lên -> Tính ra tổng số trang
            $totalPages = ceil($statement_total_row->fetchColumn() / $entityPerPage);
        }
    
        // Kiểm tra tham số phân trang 
    
        /*
                $entityPerPage: Số lượng phân tử mỗi trang
                $current_page: Số trang hiện tại
                $start_from: Bắt đầu từ  row thứ bao nhiêu ?
    
                Giải thích câu truy vấn
                    + Offset: Dùng để bỏ qua số lượng row (Chặn đầu trên) (Bắt đầu từ 0)
                    + Limit giới hạn số row lấy ra (Chặn đầu dưới)
                        -> Kết hợp cả 2 lại ta có công thức phân trang
    
        */
    

        $current_page = isset($page) ? $page : 1;
        $start_from = ($current_page - 1) * $entityPerPage;
    
        $query .= " LIMIT $entityPerPage OFFSET $start_from";

    
        // Khởi tạo kết nối đến cơ sở dữ liệu
    
        try {

            $statement = $connection->prepare($query);
    
            if ($statement !== false) {
    
                $statement->execute();
        
                $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        
                return (object) [
                    "status" => 200,
                    "message" => "Thành công",
                    "data" => $result,
                    "totalPages" => $totalPages
                ];
            } else {
                throw new PDOException();
            }
        } catch (PDOException $e) {
            return (object) [
                "status" => 400,
                "message" => "Lỗi không thể lấy danh sách tài khoản",
                "data" => []
            ];
        } finally {
            $connection = null;
        }
    }

    function isTenDangNhapExists($tenDangNhap){
        //Chuẩn bị trước biến $connection
        $connection = null;

        //Chuẩn bị câu truy vấn gốc
        $query = "SELECT * FROM `TaiKhoan` WHERE `TenDangNhap` = :tenDangNhap";
    
        // Khởi tạo kết nối
        $connection = MysqlConfig::getConnection();
    
        // Khởi tạo kết nối đến cơ sở dữ liệu
        try {

            $statement = $connection->prepare($query);
    
            if ($statement !== false) {
    


                $statement->bindValue(':tenDangNhap', $tenDangNhap, PDO::PARAM_STR);
          

                $statement->execute();

                $result = $statement->fetchAll(PDO::FETCH_ASSOC);


                $isExists = !empty($result) ? 1: 0;


                return (object) [
                    "status" => 200,
                    "message" => "Truy vấn thành công !!",
                    "isExists" => $isExists
                ];
            } else {
            throw new PDOException();
            }
        } catch (PDOException $e) {
            return (object) [
                "status" => 400,
                "message" => "Lỗi không thể lấy Tài khoản",
            ];
        } finally {
            $connection = null;
        }
    }

    function getTaiKhoanByMaTaiKhoan($maTaiKhoan){
        //Chuẩn bị trước biến $connection
        $connection = null;

        //Chuẩn bị câu truy vấn gốc
        $query = "SELECT * FROM `TaiKhoan` JOIN `NguoiDung` ON `TaiKhoan`.`MaTaiKhoan` = `NguoiDung`.`MaNguoiDung` WHERE `MaTaiKhoan` = :maTaiKhoan ";
    
        // Khởi tạo kết nối
        $connection = MysqlConfig::getConnection();
    
    
        // Khởi tạo kết nối đến cơ sở dữ liệu
        try {

            $statement = $connection->prepare($query);
      
            if ($statement !== false) {
      
                $statement->bindValue(':maTaiKhoan', $maTaiKhoan, PDO::PARAM_INT);
      
                $statement->execute();
      
                $result = $statement->fetch(PDO::FETCH_ASSOC);
      
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

    function getTaiKhoanByTenDangNhap($tenDangNhap){
        //Chuẩn bị trước biến $connection
        $connection = null;

        //Chuẩn bị câu truy vấn gốc
        $query = "SELECT * FROM `TaiKhoan` JOIN `NguoiDung` ON `TaiKhoan`.`MaTaiKhoan` = `NguoiDung`.`MaNguoiDung` WHERE `TenDangNhap` = :tenDangNhap";
    
        // Khởi tạo kết nối
        $connection = MysqlConfig::getConnection();
    
    
        // Khởi tạo kết nối đến cơ sở dữ liệu
        try {

            $statement = $connection->prepare($query);
    
            if ($statement !== false) {
    
                $statement->bindValue(':tenDangNhap', $tenDangNhap, PDO::PARAM_STR);
    
                $statement->execute();
    
                $result = $statement->fetch(PDO::FETCH_ASSOC);

    
                return (object) [
                    "status" => 200,
                    "message" => "Thành công tìm tài khoản :3",
                    "data" => $result,
                ];
            } else {
                throw new PDOException();
            }
        } catch (PDOException $e) {
            return (object) [
                "status" => 400,
                "message" => "Lỗi không thể lấy Tài khoản",
            ];
        } finally {
            $connection = null;
        }
    }


    function createTaiKhoan($tenDangNhap, $matKhau, $quyen) {
    
        // Khởi tạo kết nối
        $connection = MysqlConfig::getConnection();


        //Truy vấn
        $query = "INSERT INTO `TaiKhoan` (`TenDangNhap`, `MatKhau`, `Quyen`) 
                                    VALUES (:tenDangNhap, :matKhau, :quyen)";
    
    
        try {
    
            $statement = $connection->prepare($query); 
        
            if ($statement  !== false) {
        
                // Bind giá trị vào tham số :tenTaiKhoan trong câu truy vấn
                $statement->bindValue(':tenDangNhap', $tenDangNhap,        PDO::PARAM_STR);
                $statement->bindValue(':matKhau'    , $matKhau,            PDO::PARAM_STR);
                $statement->bindValue(':quyen'      , $quyen,              PDO::PARAM_STR);

        
                // Thực hiện truy vấn
                $statement = $statement->execute();
        
                //Mã tài khoản vừa khởi tạo
                $id = $connection->lastInsertId();


                if ($statement !== false) {
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

    function updateTaiKhoan($maTaiKhoan, $trangThai, $quyen) {

        $query = "UPDATE `TaiKhoan` SET 
                        `Quyen`     = :quyen,
                        `TrangThai`   = :trangThai
                         WHERE `MaTaiKhoan` = :maTaiKhoan";
    
        // Khởi tạo kết nối
        $connection = MysqlConfig::getConnection();
    
        try {
    
            $statement = $connection->prepare($query);
        
            if ($statement  !== false) {
                // Bind giá trị vào tham số :tenTaiKhoan trong câu truy vấn
                $statement->bindValue(':maTaiKhoan', $maTaiKhoan, PDO::PARAM_INT);
                $statement->bindValue(':trangThai', $trangThai, PDO::PARAM_INT);
                $statement->bindValue(':quyen', $quyen, PDO::PARAM_STR);
        
        
                // Thực hiện truy vấn
                $statement = $statement->execute();
        
            
        
        
                if ($statement !== false) {
                    // Trả về ID của bản ghi vừa chèn
                    return (object) [
                        "status" => 200,
                        "message" => "Thành công",
                    ];
                } else {
                    // Trả về false nếu không thành công
                    throw new PDOException();
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

    function updatePhanQuyenTaiKhoan($maTaiKhoan,  $quyen) {

        $query = "UPDATE `TaiKhoan` SET 
                        `Quyen`     = :quyen
                         WHERE `MaTaiKhoan` = :maTaiKhoan";
    
        // Khởi tạo kết nối
        $connection = MysqlConfig::getConnection();
    
        try {
    
            $statement = $connection->prepare($query);
        
            if ($statement  !== false) {
                
                // Bind giá trị vào tham số :tenTaiKhoan trong câu truy vấn
                $statement->bindValue(':maTaiKhoan', $maTaiKhoan, PDO::PARAM_INT);
                $statement->bindValue(':quyen', $quyen, PDO::PARAM_STR);
        
                // Thực hiện truy vấn
                $statement = $statement->execute();
        
        
                if ($statement !== false) {
                    // Trả về ID của bản ghi vừa chèn
                    return (object) [
                        "status" => 200,
                        "message" => "Thành công",
                    ];
                } else {
                    // Trả về false nếu không thành công
                    throw new PDOException();
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
