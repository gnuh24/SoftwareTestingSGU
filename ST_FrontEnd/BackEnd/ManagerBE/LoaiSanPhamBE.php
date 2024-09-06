<?php 
    require_once __DIR__ . "/../../Configure/MysqlConfig.php";

    //Dùng để call List loại sản phẩm
    if(isset($_GET['isDemoHome'])) {
    
        $result = getAllLoaiSanPhamNoPaging();
    
        echo json_encode($result);

    }

    //Dùng để call List loại sản phẩm
    if(isset($_GET['page'])) {
        $page = $_GET['page'];
        $search = isset($_GET['search']) ? $_GET['search'] : "";
    
        // Gọi hàm PHP bạn muốn thực thi và trả về kết quả dưới dạng JSON
        $result = getAllLoaiSanPham($page, $search);
    
        echo json_encode($result);
    }

//Dùng để update thông tin nhà cung cấp
if(isset($_POST['MaLoaiSanPham']) && isset($_POST['TenLoaiSanPham'])) {
    $MaLoaiSanPham = $_POST['MaLoaiSanPham'];
    $TenLoaiSanPham = $_POST['TenLoaiSanPham'];

    $result = updateLoaiSanPham($MaLoaiSanPham, $TenLoaiSanPham);
    

    echo json_encode($result);
}

//Dùng để thêm nhà cung cấp
if(isset($_POST['TenLoaiSanPham'])) {
    $TenLoaiSanPham = $_POST['TenLoaiSanPham'];

    // Gọi hàm createNhaCungCap và trả về kết quả dưới dạng JSON
    $result = createLoaiSanPham($TenLoaiSanPham);

    echo json_encode($result);
}

//Dùng để xoá nhà cung cấp
if(isset($_GET['MaLoaiSanPham'])) {
    $MaLoaiSanPham = $_GET['MaLoaiSanPham'];

    // Gọi hàm deleteNhaCungCap và trả về kết quả dưới dạng JSON
    $result = deleteLoaiSanPham($MaLoaiSanPham);

    echo json_encode($result);
}

//Dùng để kiểm tra xem TenLoaiSanPham có tồn tại hay không ?
if(isset($_GET['TenLoaiSanPham']) ) {
    $TenLoaiSanPham = $_GET['TenLoaiSanPham'];

    $result = isTenLoaiSanPhamExists($TenLoaiSanPham);

    echo json_encode($result);

}

function getAllLoaiSanPhamNoPaging(){
    // Chuẩn bị trước biến $connection
    $connection = null;

    // Chuẩn bị câu truy vấn gốc
    $query = "SELECT * FROM `LoaiSanPham`";

    // Khởi tạo kết nối
    $connection = MysqlConfig::getConnection();

    
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
            "message" => "Lỗi không thể lấy danh sách loại sản phẩm",
        ];
    } finally {
        $connection = null;
    }
}


function getAllLoaiSanPham($page,$search){
    // Chuẩn bị trước biến $connection
    $connection = null;

    // Mảng chứa điều kiện
    $where_conditions = [];

    // Chuẩn bị câu truy vấn gốc
    $query = "SELECT * FROM `LoaiSanPham`";

     // Số phần tử mỗi trang
     $entityPerPage = 5;

     // Tổng số trang
     $totalPages = null;

    // Khởi tạo kết nối
    $connection = MysqlConfig::getConnection();

      // Lọc theo search
      if (!empty($search)) {
        $where_conditions[] = "`TenLoaiSanPham` LIKE '%" . $search . "%'";
    }   
    // Kết nối các điều kiện lại với nhau (Nếu không có thì skip)
    if (!empty($where_conditions)) {
        $query .= " WHERE " . implode(" AND ", $where_conditions);
    }
     
    // Tính toán tổng số trang
    if ($totalPages === null) {

        // Query dùng để tính tổng số trang của các data trả về
        $query_total_row = "SELECT COUNT(*) FROM `LoaiSanPham`";
        $statement_total_row = $connection->prepare($query_total_row);
        $statement_total_row->execute();

        // Làm tròn lên -> Tính ra tổng số trang
        $totalPages = ceil($statement_total_row->fetchColumn() / $entityPerPage);
    }

    // Kiểm tra tham số phân trang
    $current_page = isset($page) ? $page : 1;
    $start_from = ($current_page - 1) * $entityPerPage;

    $query .= " LIMIT $entityPerPage OFFSET $start_from";

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
            "message" => "Lỗi không thể lấy danh sách loại sản phẩm",
        ];
    } finally {
        $connection = null;
    }
}

function getLoaiSanPhamByID($MaLoaiSanPham) {
    // Khởi tạo kết nối
    $connection = null;

    // Chuẩn bị câu truy vấn gốc
    $query = "SELECT * FROM `LoaiSanPham` WHERE `MaLoaiSanPham` = :MaLoaiSanPham";

    // Khởi tạo kết nối
    $connection = MysqlConfig::getConnection();

    try {
        $statement = $connection->prepare($query);

        if ($statement !== false) {
            $statement->bindValue(':MaLoaiSanPham', $MaLoaiSanPham, PDO::PARAM_INT);

            $statement->execute();

            $result = $statement->fetch(PDO::FETCH_ASSOC);

            return (object) [
                "status" => 200,
                "message" => "Truy vấn thành công!",
                "data" => $result
            ];
        } else {
            throw new PDOException();
        }
    } catch (PDOException $e) {
        return (object) [
            "status" => 400,
            "message" => "Lỗi không thể lấy thông tin loại sản phẩm",
        ];
    } finally {
        $connection = null;
    }
}

function isTenLoaiSanPhamExists($TenLoaiSanPham) {
    // Khởi tạo kết nối
    $connection = null;

    // Chuẩn bị câu truy vấn gốc
    $query = "SELECT * FROM `LoaiSanPham` WHERE `TenLoaiSanPham` = :TenLoaiSanPham";

    // Khởi tạo kết nối
    $connection = MysqlConfig::getConnection();

    try {
        $statement = $connection->prepare($query);

        if ($statement !== false) {
            $statement->bindValue(':TenLoaiSanPham', $TenLoaiSanPham, PDO::PARAM_STR);

            $statement->execute();

            $result = $statement->fetchAll(PDO::FETCH_ASSOC);

            $isExists = !empty($result) ? 1 : 0;

            return (object) [
                "status" => 200,
                "message" => "Truy vấn thành công!",
                "isExists" => $isExists
            ];
        } else {
            throw new PDOException();
        }
    } catch (PDOException $e) {
        return (object) [
            "status" => 400,
            "message" => "Lỗi không thể kiểm tra loại sản phẩm",
        ];
    } finally {
        $connection = null;
    }
}

function isTenLoaiSanPhamBelongToMaSanPham($MaLoaiSanPham, $TenLoaiSanPham) {
    // Khởi tạo kết nối
    $connection = null;

    // Chuẩn bị câu truy vấn gốc
    $query = "SELECT * FROM `LoaiSanPham` WHERE `MaLoaiSanPham` = :MaLoaiSanPham AND `TenLoaiSanPham` = :TenLoaiSanPham";

    // Khởi tạo kết nối
    $connection = MysqlConfig::getConnection();

    try {
        $statement = $connection->prepare($query);

        if ($statement !== false) {
            $statement->bindValue(':MaLoaiSanPham', $MaLoaiSanPham, PDO::PARAM_INT);
            $statement->bindValue(':TenLoaiSanPham', $TenLoaiSanPham, PDO::PARAM_STR);

            $statement->execute();

            $result = $statement->fetchAll(PDO::FETCH_ASSOC);

            $isExists = !empty($result) ? 1 : 0;

            return (object) [
                "status" => 200,
                "message" => "Truy vấn thành công!",
                "isExists" => $isExists
            ];
        } else {
            throw new PDOException();
        }
    } catch (PDOException $e) {
        return (object) [
            "status" => 400,
            "message" => "Lỗi không thể kiểm tra loại sản phẩm",
        ];
    } finally {
        $connection = null;
    }
}

function createLoaiSanPham($TenLoaiSanPham) {
    // Khởi tạo kết nối
    $connection = MysqlConfig::getConnection();

    $query = "INSERT INTO `LoaiSanPham` (`TenLoaiSanPham`) VALUES (:TenLoaiSanPham)";
    
    try {
        $statement = $connection->prepare($query);

        if ($statement !== false) {
            $statement->bindValue(':TenLoaiSanPham', $TenLoaiSanPham, PDO::PARAM_STR);

            $statement->execute();

            $id = $connection->lastInsertId();

            return (object) [
                "status" => 200,
                "message" => "Thành công",
                "data" => $id
            ];
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

function updateLoaiSanPham($MaLoaiSanPham, $TenLoaiSanPham) {
    // Khởi tạo kết nối
    $connection = MysqlConfig::getConnection();

    $query = "UPDATE `LoaiSanPham` SET 
                `TenLoaiSanPham` = :TenLoaiSanPham
              WHERE `MaLoaiSanPham` = :MaLoaiSanPham";

    try {
        $statement = $connection->prepare($query);

        if ($statement !== false) {
            $statement->bindValue(':MaLoaiSanPham', $MaLoaiSanPham, PDO::PARAM_INT);
            $statement->bindValue(':TenLoaiSanPham', $TenLoaiSanPham, PDO::PARAM_STR);

            $statement->execute();

            if ($statement->rowCount() > 0) {
                return (object) [
                    "status" => 200,
                    "message" => "Thành công",
                ];
            } else {
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

function deleteLoaiSanPham($MaLoaiSanPham) {
    // Khởi tạo kết nối
    $connection = MysqlConfig::getConnection();

    try {
        // Bắt đầu transaction
        $connection->beginTransaction();

        // Lấy danh sách các sản phẩm thuộc loại sản phẩm cần xóa
        $query_select_products = "SELECT `MaSanPham` FROM `SanPham` WHERE `MaLoaiSanPham` = :MaLoaiSanPham";
        $statement_select_products = $connection->prepare($query_select_products);
        $statement_select_products->bindValue(':MaLoaiSanPham', $MaLoaiSanPham, PDO::PARAM_INT);
        $statement_select_products->execute();
        $products = $statement_select_products->fetchAll(PDO::FETCH_ASSOC);

        // Cập nhật mã loại sản phẩm của các sản phẩm đó sang mã loại sản phẩm mặc định (id = 1)
        $query_update_products = "UPDATE `SanPham` SET `MaLoaiSanPham` = 1 WHERE `MaLoaiSanPham` = :MaLoaiSanPham";
        $statement_update_products = $connection->prepare($query_update_products);
        $statement_update_products->bindValue(':MaLoaiSanPham', $MaLoaiSanPham, PDO::PARAM_INT);
        $statement_update_products->execute();

        // Xóa loại sản phẩm
        $query_delete_loai_san_pham = "DELETE FROM `LoaiSanPham` WHERE `MaLoaiSanPham` = :MaLoaiSanPham";
        $statement_delete_loai_san_pham = $connection->prepare($query_delete_loai_san_pham);
        $statement_delete_loai_san_pham->bindValue(':MaLoaiSanPham', $MaLoaiSanPham, PDO::PARAM_INT);
        $statement_delete_loai_san_pham->execute();

        // Commit transaction nếu mọi thứ diễn ra suôn sẻ
        $connection->commit();

        return (object) [
            "status" => 200,
            "message" => "Thành công",
        ];

    } catch (PDOException $e) {
        // Rollback transaction nếu có lỗi xảy ra
        $connection->rollBack();

        return (object) [
            "status" => 400,
            "message" => $e->getMessage()
        ];
    } finally {
        $connection = null;
    }
}
