<?php
require_once __DIR__ . "/../../Configure/MysqlConfig.php";

if (isset($_GET['page'])) {
    $page = $_GET['page'];
    $minNgayTao = isset($_GET['minNgayTao']) ? $_GET['minNgayTao'] : "";
    $maxNgayTao = isset($_GET['maxNgayTao']) ? $_GET['maxNgayTao'] : "";
    $trangThai = isset($_GET['trangThai']) ? $_GET['trangThai'] : "";

    // Gọi hàm PHP bạn muốn thực thi và trả về kết quả dưới dạng JSON
    $result = getAllDonHang($page, $minNgayTao, $maxNgayTao, $trangThai);

    echo json_encode($result);
}

if (isset($_POST['action'])) {
    if ($_POST['action'] == "add") {
        $tongGiaTri = $_POST['tongGiaTri'];
        $maKH =  $_POST['maTaiKhoan'];
        $maPhuongThuc =  $_POST['maPhuongThuc'];
        $maDichVu =  $_POST['maDichVu'];
        $diaChiGiaoHang =  $_POST['diaChiGiaoHang'];

        // Gọi hàm PHP bạn muốn thực thi và trả về kết quả dưới dạng JSON
        $result = createDonHang($tongGiaTri, $maKH, $diaChiGiaoHang, $maPhuongThuc, $maDichVu);

        echo json_encode($result);
    }
}

if (isset($_GET['MaDonHang'])) {
    $MaDonHang = $_GET['MaDonHang'];

    $result = getDonHangByMaDonHang($MaDonHang);

    echo json_encode($result);
}


function getAllDonHang($page, $minNgayTao, $maxNgayTao, $trangThai)
{
    $connection = null;
    $query = "SELECT dh.MaDonHang,
                    dh.NgayDat,
                    dh.TongGiaTri,
                    dh.MaKH,
                    dh.DiaChiGiaoHang,
                    pt.MaPhuongThuc,
                    dv.MaDichVu,
                    pt.TenPhuongThuc,
                    tt.TrangThai,
                    tt.NgayCapNhat,
                    dv.TenDichVu,
                    kh.HoTen,
                    kh.SoDienThoai,
                    kh.Email 
                FROM `DonHang` dh
                JOIN `PhuongThucThanhToan` pt ON dh.`MaPhuongThuc` = pt.`MaPhuongThuc`
                JOIN `TrangThaiDonHang` tt ON dh.`MaDonHang` = tt.`MaDonHang`
                JOIN `nguoidung` kh ON dh.`MaKH` = kh.`MaNguoiDung`
                JOIN `dichvuvanchuyen` dv ON dh.`MaDichVu` = dv.`MaDichVu`
                WHERE tt.NgayCapNhat = (SELECT MAX(NgayCapNhat)
                                        FROM TrangThaiDonHang 
                                        WHERE MaDonHang = dh.MaDonHang)
                ";

    $query_total_row = "SELECT COUNT(*)
                        FROM `DonHang` dh
                        JOIN `PhuongThucThanhToan` pt ON dh.`MaPhuongThuc` = pt.`MaPhuongThuc`
                        JOIN `TrangThaiDonHang` tt ON dh.`MaDonHang` = tt.`MaDonHang`
                        JOIN `nguoidung` kh ON dh.`MaKH` = kh.`MaNguoiDung`
                        JOIN `dichvuvanchuyen` dv ON dh.`MaDichVu` = dv.`MaDichVu`
                        WHERE tt.NgayCapNhat = (SELECT MAX(NgayCapNhat) 
                                                FROM TrangThaiDonHang 
                                                WHERE MaDonHang = dh.MaDonHang)";

    $where_conditions = [];

    $entityPerPage = 7;
    $totalPages = null;

    if ($minNgayTao !== "null") {
        $where_conditions[] = "dh.NgayDat >= '$minNgayTao 00:00:00'";
    }
    if ($maxNgayTao !== "null") {
        $where_conditions[] = "dh.NgayDat <= '$maxNgayTao 23:59:59'";
    }

    if ($trangThai !== "null") {
        $where_conditions[] = "tt.TrangThai = '$trangThai'";
    }

    if (!empty($where_conditions)) {
        $query .= " AND " . implode(" AND ", $where_conditions);
        $query_total_row .= " AND " . implode(" AND ", $where_conditions);
    }

    $query .= "ORDER BY dh.MaDonHang DESC";
    $query_total_row .= "ORDER BY dh.MaDonHang DESC";

    $connection = MysqlConfig::getConnection();

    if ($totalPages === null) {
        $statement_total_row = $connection->prepare($query_total_row);
        $statement_total_row->execute();

        $totalPages = ceil($statement_total_row->fetchColumn() / $entityPerPage);
    }

    $current_page = $page;
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
            "message" => "Lỗi không thể lấy danh sách đơn hàng",
        ];
    } finally {
        $connection = null;
    }
}

function getAllDonHangByMaKH($maKH)
{
    $connection = null;
    $query = "SELECT * FROM `DonHang` dh 
                JOIN `TrangThaiDonHang` tt ON dh.`MaDonHang` = tt.`MaDonHang`
                JOIN `PhuongThucThanhToan` pptt ON dh.`MaPhuongThuc` = pptt.`MaPhuongThuc`
				JOIN `DichVuVanChuyen` dvvc ON dh.`MaDichVu` = dvvc.`MaDichVu`
                WHERE tt.`NgayCapNhat` = (
                    SELECT MAX(`NgayCapNhat`) 
                    FROM `TrangThaiDonHang` subtt 
                    WHERE dh.`MaDonHang` = subtt.`MaDonHang`
                ) AND dh.`MaKH` = :maKH
                ORDER BY dh.`NgayDat` desc";

    $connection = MysqlConfig::getConnection();

    try {
        $statement = $connection->prepare($query);

        if ($statement !== false) {
            $statement->bindValue(':maKH', $maKH, PDO::PARAM_INT);
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
            "message" => "Lỗi không thể lấy danh sách đơn hàng của khách hàng",
        ];
    } finally {
        $connection = null;
    }
}

function getDonHangByMaDonHang($maDonHang)
{
    $connection = null;
    $query = "SELECT dh.MaDonHang,
                    dh.NgayDat,
                    dh.TongGiaTri,
                    dh.MaKH,
                    dh.DiaChiGiaoHang,
                    pt.MaPhuongThuc,
                    dv.MaDichVu,
                    pt.TenPhuongThuc,
                    tt.TrangThai,
                    tt.NgayCapNhat,
                    dv.TenDichVu,
                    kh.HoTen,
                    kh.SoDienThoai,
                    kh.Email 
                FROM `DonHang` dh
                JOIN `PhuongThucThanhToan` pt ON dh.`MaPhuongThuc` = pt.`MaPhuongThuc`
                JOIN `TrangThaiDonHang` tt ON dh.`MaDonHang` = tt.`MaDonHang`
                JOIN `nguoidung` kh ON dh.`MaKH` = kh.`MaNguoiDung`
                JOIN `dichvuvanchuyen` dv ON dh.`MaDichVu` = dv.`MaDichVu`
                WHERE tt.NgayCapNhat = (SELECT MAX(NgayCapNhat)
                                        FROM TrangThaiDonHang 
                                        WHERE MaDonHang = dh.MaDonHang)
                AND dh.`MaDonHang` = :maDonHang";

    $connection = MysqlConfig::getConnection();

    try {
        $statement = $connection->prepare($query);

        if ($statement !== false) {
            $statement->bindValue(':maDonHang', $maDonHang, PDO::PARAM_INT);
            $statement->execute();
            $result = $statement->fetch(PDO::FETCH_ASSOC);

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
            "message" => "Lỗi không thể lấy thông tin đơn hàng",
        ];
    } finally {
        $connection = null;
    }
}

function createDonHang($tongGiaTri, $maKH, $diaChiGiaoHang, $maPhuongThuc, $maDichVu)
{
    $connection = null;

    $query_insert_donhang = "INSERT INTO `DonHang` (`TongGiaTri`, `MaKH`, `DiaChiGiaoHang`, `MaPhuongThuc`, `MaDichVu`) 
                                VALUES (:tongGiaTri, :maKH, :diaChiGiaoHang, :maPhuongThuc, :maDichVu)";

    $query_insert_trangthai = "INSERT INTO `TrangThaiDonHang` (`TrangThai`, `MaDonHang`) 
                                    VALUES ('ChoDuyet', LAST_INSERT_ID())";

    $connection = MysqlConfig::getConnection();

    try {
        // Thực hiện truy vấn insert vào bảng DonHang
        $statement_donhang = $connection->prepare($query_insert_donhang);

        if ($statement_donhang !== false) {
            $statement_donhang->bindValue(':tongGiaTri', $tongGiaTri, PDO::PARAM_INT);
            $statement_donhang->bindValue(':maKH', $maKH, PDO::PARAM_INT);
            $statement_donhang->bindValue(':diaChiGiaoHang', $diaChiGiaoHang, PDO::PARAM_STR);
            $statement_donhang->bindValue(':maPhuongThuc', $maPhuongThuc, PDO::PARAM_INT);
            $statement_donhang->bindValue(':maDichVu', $maDichVu, PDO::PARAM_INT);

            $statement_donhang->execute();

            // Lấy ID của đơn hàng vừa được tạo
            $id_donhang = $connection->lastInsertId();

            // Thực hiện truy vấn insert vào bảng TrangThaiDonHang
            $statement_trangthai = $connection->prepare($query_insert_trangthai);

            if ($statement_trangthai !== false) {
                $statement_trangthai->execute();

                return (object) [
                    "status" => 200,
                    "message" => "Thành công",
                    "data" => $id_donhang
                ];
            } else {
                throw new PDOException("Lỗi khi thêm trạng thái đơn hàng.");
            }
        } else {
            throw new PDOException("Lỗi khi thêm đơn hàng.");
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
