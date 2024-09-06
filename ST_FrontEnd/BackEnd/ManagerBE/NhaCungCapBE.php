<?php
require_once __DIR__ . "/../../Configure/MysqlConfig.php";

if (isset($_POST["action"])){
    if ($_POST["action"] == "update"){
        // Update thông tin nhà cung cấp
        $MaNCC = $_POST['MaNCC'];
        $TenNCC = $_POST['TenNCC'];
        $Email = $_POST['Email'];
        $SoDienThoai = $_POST['SoDienThoai'];
        $result = updateNhaCungCap($MaNCC, $TenNCC, $Email, $SoDienThoai);
        echo json_encode($result);
    
    }else if ($_POST["action"] == "create"){
        // Thêm nhà cung cấp mới
        $TenNCC = $_POST['TenNCC'];
        $Email = $_POST['Email'];
        $SoDienThoai = $_POST['SoDienThoai'];
        $result = createNhaCungCap($TenNCC, $Email, $SoDienThoai);
        echo json_encode($result);
    }else if ($_POST["action"] == "delete"){
        $MaNCC = $_POST['MaNCC'];
        // Xoá nhà cung cấp
        $MaNCC = $_POST['MaNCC'];
        $result = deleteNhaCungCap($MaNCC);
        echo json_encode($result);
    }
}




if(isset($_GET['page'])) {
    // Gọi hàm lấy danh sách nhà cung cấp
    $page = $_GET['page'];
    $search = isset($_GET['search']) ? $_GET['search'] : "";
    $result = getAllNhaCungCap($page, $search);
    echo json_encode($result);
}

if (isset($_GET["action"])){
    $TenNCC = $_GET['TenNCC'];
    if ($_GET["action"] == "isExists"){
        // Kiểm tra xem TenNCC có tồn tại không
        $result = isTenNhaCungCapExists($TenNCC);
        echo json_encode($result);
    }else if ($_GET["action"] == "isBelongTo"){
        $MaNCC = $_GET["MaNCC"];
        $result = isTenNhaCungCapBelongToMaNhaCungCap($MaNCC, $TenNCC);
        echo json_encode($result);
    }
}


function getAllNhaCungCapNotPage()
{
        
    // Chuẩn bị trước biến $connection
    $connection = null;
    // Mảng chứa điều kiện
    $where_conditions = [];
    // Chuẩn bị câu truy vấn gốc
    $query = "SELECT * FROM `NhaCungCap`";
  
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
                "data" => $result,
            ];
        } else {
            throw new PDOException();
        }
    } catch (PDOException $e) {
        return (object) [
            "status" => 400,
            "message" => "Lỗi không thể lấy danh sách nhà cung cấp",
        ];
    } finally {
        $connection = null;
    }
}


function getAllNhaCungCap($page,$search)
{
        
    // Chuẩn bị trước biến $connection
    $connection = null;
    // Mảng chứa điều kiện
    $where_conditions = [];
    // Chuẩn bị câu truy vấn gốc
    $query = "SELECT * FROM `NhaCungCap`";
    // Số phần tử mỗi trang
    $entityPerPage = 6;
    // Tổng số trang
    $totalPages = null;
    // Khởi tạo kết nối
    $connection = MysqlConfig::getConnection();   
     // Lọc theo search
     if (!empty($search)) {
        $where_conditions[] = "`TenNCC` LIKE '%" . $search . "%'";
    }   
    // Kết nối các điều kiện lại với nhau (Nếu không có thì skip)
    if (!empty($where_conditions)) {
        $query .= " WHERE " . implode(" AND ", $where_conditions);
    }
     
    // Tính toán tổng số trang
    if ($totalPages === null) {

        // Query dùng để tính tổng số trang của các data trả về
        $query_total_row = "SELECT COUNT(*) FROM `NhaCungCap`";
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
            "message" => "Lỗi không thể lấy danh sách nhà cung cấp",
        ];
    } finally {
        $connection = null;
    }
}

function getNhaCungCapByID($MaNCC)
{
    // Khởi tạo kết nối
    $connection = null;

    // Chuẩn bị câu truy vấn gốc
    $query = "SELECT * FROM `NhaCungCap` WHERE `MaNCC` = :MaNCC";

    // Khởi tạo kết nối
    $connection = MysqlConfig::getConnection();

    try {
        $statement = $connection->prepare($query);

        if ($statement !== false) {
            $statement->bindValue(':MaNCC', $MaNCC, PDO::PARAM_INT);

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
            "message" => "Lỗi không thể lấy thông tin nhà cung cấp",
        ];
    } finally {
        $connection = null;
    }
}

function getNhaCungCapBySDT($SoDienThoai)
{
    // Khởi tạo kết nối
    $connection = null;

    // Chuẩn bị câu truy vấn gốc
    $query = "SELECT * FROM `NhaCungCap` WHERE `SoDienThoai` = :SoDienThoai";

    // Khởi tạo kết nối
    $connection = MysqlConfig::getConnection();

    try {
        $statement = $connection->prepare($query);

        if ($statement !== false) {
            $statement->bindValue(':SoDienThoai', $SoDienThoai, PDO::PARAM_INT);

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
            "message" => "Lỗi không thể lấy thông tin nhà cung cấp",
        ];
    } finally {
        $connection = null;
    }
}

function isEmailExists($Email) {
    // Chuẩn bị biến kết nối
    $connection = null;

    // Chuẩn bị câu truy vấn gốc
    $query = "SELECT * FROM `nhacungcap` WHERE `Email` = :Email";

    try {
        // Khởi tạo kết nối đến cơ sở dữ liệu
        $connection = MysqlConfig::getConnection();

        // Chuẩn bị câu truy vấn
        $statement = $connection->prepare($query);

        // Kiểm tra câu truy vấn
        if ($statement !== false) {
            // Bind giá trị vào tham số của câu truy vấn
            $statement->bindValue(':Email', $Email, PDO::PARAM_STR);

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

function isTenNhaCungCapExists($TenNCC)
{
    // Khởi tạo kết nối
    $connection = null;

    // Chuẩn bị câu truy vấn gốc
    $query = "SELECT * FROM `NhaCungCap` WHERE `TenNCC` = :TenNCC";

    // Khởi tạo kết nối
    $connection = MysqlConfig::getConnection();

    try {
        $statement = $connection->prepare($query);

        if ($statement !== false) {
            $statement->bindValue(':TenNCC', $TenNCC, PDO::PARAM_STR);

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
            "message" => "Lỗi không thể kiểm tra nhà cung cấp",
        ];
    } finally {
        $connection = null;
    }
}

function isTenNhaCungCapBelongToMaNhaCungCap($MaNCC, $TenNCC)
{
    // Khởi tạo kết nối
    $connection = null;

    // Chuẩn bị câu truy vấn gốc
    $query = "SELECT * FROM `NhaCungCap` WHERE `MaNCC` = :MaNCC AND `TenNCC` = :TenNCC";

    // Khởi tạo kết nối
    $connection = MysqlConfig::getConnection();

    try {
        $statement = $connection->prepare($query);

        if ($statement !== false) {
            $statement->bindValue(':MaNCC', $MaNCC, PDO::PARAM_INT);
            $statement->bindValue(':TenNCC', $TenNCC, PDO::PARAM_STR);

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
            "message" => "Lỗi không thể kiểm tra nhà cung cấp",
        ];
    } finally {
        $connection = null;
    }
}

function createNhaCungCap($TenNCC,  $Email, $SoDienThoai)
{
    // Khởi tạo kết nối
    $connection = MysqlConfig::getConnection();

    $query = "INSERT INTO `NhaCungCap` (`TenNCC`,`SoDienThoai`,`Email`) VALUES (:TenNCC,:SoDienThoai,:Email)";

    try {
        $statement = $connection->prepare($query);

        if ($statement !== false) {
            $statement->bindValue(':TenNCC', $TenNCC, PDO::PARAM_STR);
            $statement->bindValue(':SoDienThoai', $SoDienThoai, PDO::PARAM_STR);
            $statement->bindValue(':Email', $Email, PDO::PARAM_STR);

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

function updateNhaCungCap($MaNCC, $TenNCC,  $Email, $SoDienThoai)
{
    // Khởi tạo kết nối
    $connection = MysqlConfig::getConnection();

    $query = "UPDATE `NhaCungCap` SET 
                `TenNCC` = :TenNCC,
                `soDienThoai`=:soDienThoai,
                `Email` =:Email
              WHERE `MaNCC` = :MaNCC";

    try {
        $statement = $connection->prepare($query);

        if ($statement !== false) {
            $statement->bindValue(':MaNCC', $MaNCC, PDO::PARAM_INT);
            $statement->bindValue(':TenNCC', $TenNCC, PDO::PARAM_STR);
            $statement->bindValue(':soDienThoai', $SoDienThoai, PDO::PARAM_STR);
            $statement->bindValue(':Email', $Email, PDO::PARAM_STR);


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

function deleteNhaCungCap($MaNCC)
{
    // Khởi tạo kết nối
    $connection = MysqlConfig::getConnection();

    try {
        // Bắt đầu transaction
        $connection->beginTransaction();

        // Lấy danh sách các phiếu nhập kho thuộc nhà cung cấp cần xóa
        $query_select_PNKS = "SELECT `MaNCC` FROM `PhieuNhapKho` WHERE `MaNCC` = :MaNCC";
        $statement_select_PNKS = $connection->prepare($query_select_PNKS);
        $statement_select_PNKS->bindValue(':MaNCC', $MaNCC, PDO::PARAM_INT);
        $statement_select_PNKS->execute();
        $PNKS = $statement_select_PNKS->fetchAll(PDO::FETCH_ASSOC);

        // Cập nhật mã nhà cung cấp của các phiếu nhập kho đó sang mã nhà cung cấp mặc định (id = 1)
        $query_update_PNKS = "UPDATE `PhieuNhapKho` SET `MaNCC` = 1 WHERE `MaNCC` = :MaNCC";
        $statement_update_PNKS = $connection->prepare($query_update_PNKS);
        $statement_update_PNKS->bindValue(':MaNCC', $MaNCC, PDO::PARAM_INT);
        $statement_update_PNKS->execute();

        // Xóa loại nhà cung cáp
        $query_delete_nha_cung_cap = "DELETE FROM `NhaCungCap` WHERE `MaNCC` = :MaNCC";
        $statement_delete_nha_cung_cap = $connection->prepare($query_delete_nha_cung_cap);
        $statement_delete_nha_cung_cap->bindValue(':MaNCC', $MaNCC, PDO::PARAM_INT);
        $statement_delete_nha_cung_cap->execute();

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
