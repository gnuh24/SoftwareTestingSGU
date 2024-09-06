<?php
require_once __DIR__ . "/../../Configure/MysqlConfig.php";
if (isset($_GET['MaDichVu'])) {
    $MaDichVu = isset($_GET['MaDichVu']);

    $result = getDichVuVanChuyenByMaDichVu($MaDichVu);

    echo json_encode($result);
}

function getAllDichVuVanChuyenNoPaging()
{
    // Chuẩn bị trước biến $connection
    $connection = null;

    // Chuẩn bị câu truy vấn gốc
    $query = "SELECT * FROM `DichVuVanChuyen`";

    try {
        // Khởi tạo kết nối
        $connection = MysqlConfig::getConnection();

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
            "message" => "Lỗi không thể lấy danh sách phương thức vận chuyển",
        ];
    } finally {
        $connection = null;
    }
}

function getAllDichVuVanChuyen($page)
{

    // Chuẩn bị trước biến $connection
    $connection = null;

    // Chuẩn bị câu truy vấn gốc
    $query = "SELECT * FROM `DichVuVanChuyen`";
    // Số phần tử mỗi trang
    $entityPerPage = 20;
    // Tổng số trang
    $totalPages = null;
    // Khởi tạo kết nối
    $connection = MysqlConfig::getConnection();
    // Tính toán tổng số trang
    if ($totalPages === null) {

        // Query dùng để tính tổng số trang của các data trả về
        $query_total_row = "SELECT COUNT(*) FROM `DichVuVanChuyen`";
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
            "message" => "Lỗi không thể lấy danh sách phương thức thanh toán",
        ];
    } finally {
        $connection = null;
    }
}

function getDichVuVanChuyenByMaDichVu($MaDichVu)
{
    // Khởi tạo kết nối
    $connection = null;

    // Chuẩn bị câu truy vấn gốc
    $query = "SELECT * FROM `DichVuVanChuyen` WHERE `MaDichVu` = :MaDichVu";

    // Khởi tạo kết nối
    $connection = MysqlConfig::getConnection();

    try {
        $statement = $connection->prepare($query);

        if ($statement !== false) {
            $statement->bindValue(':MaDichVu', $MaDichVu, PDO::PARAM_INT);

            $statement->execute();

            $result = $statement->fetchAll(PDO::FETCH_ASSOC);

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
            "message" => "Lỗi không thể lấy thông tin phương thức thanh toán",
        ];
    } finally {
        $connection = null;
    }
}


function isTenDichVuExists($TenDichVu)
{
    // Khởi tạo kết nối
    $connection = null;

    // Chuẩn bị câu truy vấn gốc
    $query = "SELECT * FROM `DichVuVanChuyen` WHERE `TenDichVu` = :TenDichVu";

    // Khởi tạo kết nối
    $connection = MysqlConfig::getConnection();

    try {
        $statement = $connection->prepare($query);

        if ($statement !== false) {
            $statement->bindValue(':TenDichVu', $TenDichVu, PDO::PARAM_STR);

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
            "message" => "Lỗi không thể kiểm tra phương thức thanh toán",
        ];
    } finally {
        $connection = null;
    }
}

function isTenDichVuBelongToMaDichVu($MaDichVu, $TenDichVu)
{
    // Khởi tạo kết nối
    $connection = null;

    // Chuẩn bị câu truy vấn gốc
    $query = "SELECT * FROM `DichVuVanChuyen` WHERE `MaDichVu` = :MaDichVu AND `TenDichVu` = :TenDichVu";

    // Khởi tạo kết nối
    $connection = MysqlConfig::getConnection();

    try {
        $statement = $connection->prepare($query);

        if ($statement !== false) {
            $statement->bindValue(':MaDichVu', $MaDichVu, PDO::PARAM_INT);
            $statement->bindValue(':TenDichVu', $TenDichVu, PDO::PARAM_STR);

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
            "message" => "Lỗi không thể kiểm tra phương thức thanh toán",
        ];
    } finally {
        $connection = null;
    }
}

function createDichVuVanChuyen($TenDichVu)
{
    // Khởi tạo kết nối
    $connection = MysqlConfig::getConnection();

    $query = "INSERT INTO `DichVuVanChuyen` (`TenDichVu`) 
                    VALUES (:TenDichVu)";

    try {
        $statement = $connection->prepare($query);

        if ($statement !== false) {
            $statement->bindValue(':TenDichVu', $TenDichVu, PDO::PARAM_STR);
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

function updateDichVuVanChuyen($MaDichVu, $TenDichVu)
{
    // Khởi tạo kết nối
    $connection = MysqlConfig::getConnection();

    $query = "UPDATE `DichVuVanChuyen` SET 
                    `TenDichVu` = :TenDichVu,
                WHERE `MaDichVu` = :MaDichVu";

    try {
        $statement = $connection->prepare($query);

        if ($statement !== false) {
            $statement->bindValue(':MaDichVu', $MaDichVu, PDO::PARAM_INT);
            $statement->bindValue(':TenDichVu', $TenDichVu, PDO::PARAM_STR);

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

function deletePhuongThuc($MaDichVu)
{
    // Khởi tạo kết nối
    $connection = MysqlConfig::getConnection();

    try {
        // Bắt đầu transaction
        $connection->beginTransaction();

        // Lấy danh sách các hóa đơn thuộc phương thức thanh toán cần xóa
        $query_select_DonHang = "SELECT `MaDichVu` FROM `DonHang` WHERE `MaDichVu` = :MaDichVu";
        $statement_select_DonHang = $connection->prepare($query_select_DonHang);
        $statement_select_DonHang->bindValue(':MaDichVu', $MaDichVu, PDO::PARAM_INT);
        $statement_select_DonHang->execute();
        $DonHang = $statement_select_DonHang->fetchAll(PDO::FETCH_ASSOC);

        // Cập nhật mã phương thức thanh toán của các hóa đơn đó sang mã phương thức thanh toán mặc định (id = 1)
        $query_update_DonHang = "UPDATE `DonHang` SET `MaDichVu` = 1 WHERE `MaDichVu` = :MaDichVu";
        $statement_update_DonHang = $connection->prepare($query_update_DonHang);
        $statement_update_DonHang->bindValue(':MaDichVu', $MaDichVu, PDO::PARAM_INT);
        $statement_update_DonHang->execute();

        // Xóa phương thức thanh toán
        $query_delete_nha_cung_cap = "DELETE FROM `PhuongThuc` WHERE `MaDichVu` = :MaDichVu";
        $statement_delete_nha_cung_cap = $connection->prepare($query_delete_nha_cung_cap);
        $statement_delete_nha_cung_cap->bindValue(':MaDichVu', $MaDichVu, PDO::PARAM_INT);
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
