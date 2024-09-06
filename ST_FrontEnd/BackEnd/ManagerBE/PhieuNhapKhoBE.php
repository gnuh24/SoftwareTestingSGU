<?php
require_once __DIR__ . "/../../Configure/MysqlConfig.php";

if (isset($_GET['page'])) {
    $page = $_GET['page'];
    $datenhapkho = isset($_GET['datenhapkho']) ? $_GET['datenhapkho'] : null;
    $result = getAllphieunhapkho($page, $datenhapkho);
    echo json_encode($result);
}

function getAllphieunhapkho($page, $datenhapkho = null)
{
    $connection = MysqlConfig::getConnection();
    $query = "SELECT MaPhieu, NgayNhapKho, pnk.MaNCC, TongGiaTri, pnk.MaQuanLy, TenNCC, nguoidung.HoTen, pnk.TrangThai AS PhieuTrangThai 
              FROM PhieuNhapKho AS pnk 
              JOIN nhacungcap ON pnk.MaNCC = nhacungcap.MaNCC 
              JOIN taikhoan AS tk ON pnk.MaQuanLy = tk.MaTaiKhoan 
              JOIN NguoiDung ON tk.MaTaiKhoan = NguoiDung.MaNguoiDung";
    
    // Xây dựng điều kiện WHERE dựa trên ngày nhập kho nếu có
    $where_conditions = [];
    if ($datenhapkho !== null && $datenhapkho !== "") {
        $where_conditions[] = "NgayNhapKho LIKE :NgayNhapKho";
    }
    
    // Thêm các điều kiện WHERE vào truy vấn nếu có
    if (!empty($where_conditions)) {
        $query .= " WHERE " . implode(" AND ", $where_conditions);
    }

    // Truy vấn để tính tổng số lượng bản ghi
    $query_total_row = "SELECT COUNT(*) AS totalRows FROM (" . $query . ") AS subquery";
    $statement_total_row = $connection->prepare($query_total_row);
    if ($datenhapkho !== null && $datenhapkho !== "") {
        $statement_total_row->execute([':NgayNhapKho' => '%' . $datenhapkho . '%']);
    } else {
        $statement_total_row->execute();
    }
    $totalRows = $statement_total_row->fetchColumn();
    $totalPages = ceil($totalRows / 8); 

    // Thêm LIMIT và OFFSET vào truy vấn
    $start_from = ($page - 1) * 8;
    $query .= " ORDER BY MaPhieu ASC LIMIT 8 OFFSET $start_from";

    try {
        $statement = $connection->prepare($query);
        if ($datenhapkho !== null && $datenhapkho !== "") {
            $statement->execute([':NgayNhapKho' => '%' . $datenhapkho . '%']);
        } else {
            $statement->execute();
        }
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);

        return (object) [
            "status" => 200,
            "message" => "Thành công",
            "data" => $result,
            "totalPages" => $totalPages
        ];
    } catch (PDOException $e) {
        return (object) [
            "status" => 400,
            "message" => "Lỗi không thể lấy danh sách nhập kho: " . $e->getMessage(),
        ];
    } finally {
        $connection = null;
    }
}




function getPhieuNhapByMaPhieuNhap($maPhieuNhap)
{
    //Chuẩn bị trước biến $connection
    $connection = null;

    //Chuẩn bị câu truy vấn gốc
    $query = "SELECT * FROM `PhieuNhapKho` WHERE `MaPhieu` = :maPhieuNhap";

    // Khởi tạo kết nối
    $connection = MysqlConfig::getConnection();


    // Khởi tạo kết nối đến cơ sở dữ liệu
    try {

        $statement = $connection->prepare($query);

        if ($statement !== false) {

            $statement->bindValue(':maTaiKhoan', $maPhieuNhap, PDO::PARAM_INT);

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

function createPhieuNhapKho($NgayNhapKho, $TongGiaTri, $MaNCC, $MaQuanLy)
{

    // Khởi tạo kết nối
    $connection = MysqlConfig::getConnection();

    $query = "INSERT INTO `PhieuNhapKho`(`NgayNhapKho`,`TongGiaTri`, `MaNCC`, `MaQuanLy`) 
                                VALUES (:NgayNhapKho, :TongGiaTri, :MaNCC,:MaQuanLy)";


    try {

        $statement = $connection->prepare($query);

        if ($statement  !== false) {

            // Bind giá trị vào tham số :tenTaiKhoan trong câu truy vấn
            $statement->bindValue(':NgayNhapKho', $NgayNhapKho,        PDO::PARAM_STR);
            $statement->bindValue(':TongGiaTri', $TongGiaTri,            PDO::PARAM_INT);
            $statement->bindValue(':MaNCC', $MaNCC,              PDO::PARAM_INT);
            $statement->bindValue(':MaQuanLy', $MaQuanLy,              PDO::PARAM_INT);

            // Thực hiện truy vấn
            $statement = $statement->execute();

            //Mã phiếu nhập vừa khởi tạo
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
function updatePhieuNhapKho($MaPhieuNhapKho, $TongGiaTri, $MaNCC, $TrangThai)
{
    $connection = MysqlConfig::getConnection();
    $currentStatus = getCurrentPhieuNhapKhoStatus($MaPhieuNhapKho);
    $query = "UPDATE `PhieuNhapKho` 
              SET `TongGiaTri` = :TongGiaTri, 
                  `MaNCC` = :MaNCC, 
                  `TrangThai` = :TrangThai
              WHERE `MaPhieu` = :MaPhieuNhapKho";

    try {
        $statement = $connection->prepare($query);

        if ($statement !== false) {
            // Bind giá trị vào tham số của câu truy vấn
            $statement->bindValue(':MaPhieuNhapKho', $MaPhieuNhapKho, PDO::PARAM_INT);
            $statement->bindValue(':TongGiaTri', $TongGiaTri, PDO::PARAM_STR);
            $statement->bindValue(':MaNCC', $MaNCC, PDO::PARAM_INT);
            // Bind giá trị vào tham số của câu truy vấn
            $statement->bindValue(':TrangThai', $TrangThai, PDO::PARAM_STR); // Sử dụng PDO::PARAM_STR cho kiểu ENUM
            $statement->execute();
            $rowCount = $statement->rowCount();

            if ($rowCount >= 0) {
                if (strtolower($TrangThai) === strtolower($currentStatus)) {
                    $status = 200;
                } else {
                    $status = 300;
                }
                
                return (object) [
                    "status" => $status,
                    "message" => "Cập nhật thành công"
                ];
            } else {
                return (object) [
                    "status" => 404,
                    "message" => "Không tìm thấy phiếu nhập kho"
                ];
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

function getCurrentPhieuNhapKhoStatus($MaPhieuNhapKho)
{
    // Câu truy vấn SQL để lấy trạng thái hiện tại của phiếu nhập kho
    $query = "SELECT `TrangThai` FROM `PhieuNhapKho` WHERE `MaPhieu` = :MaPhieuNhapKho";
    $connection = MysqlConfig::getConnection();

    try {
        $statement = $connection->prepare($query);

        if ($statement !== false) {
            // Bind giá trị vào tham số của câu truy vấn
            $statement->bindValue(':MaPhieuNhapKho', $MaPhieuNhapKho, PDO::PARAM_INT);

            // Thực thi truy vấn
            $statement->execute();

            // Lấy kết quả truy vấn
            $result = $statement->fetch(PDO::FETCH_ASSOC);

            // Trả về trạng thái hiện tại
            return $result['TrangThai'];
        }
    } catch (PDOException $e) {
        // Xử lý ngoại lệ nếu có
        return false;
    }
}
