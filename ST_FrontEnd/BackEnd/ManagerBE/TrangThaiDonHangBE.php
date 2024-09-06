<?php
require_once __DIR__ . "/../../Configure/MysqlConfig.php";
// TrangThai NgayCapNhat MaDonHang
if (isset($_GET['MaDonHang'])) {
    $MaDonHang = $_GET['MaDonHang'];

    // Gọi hàm PHP bạn muốn thực thi và trả về kết quả dưới dạng JSON
    $result = getTrangThaiDonHangByMaDonHang($MaDonHang);

    echo json_encode($result);
}

if (isset($_POST['MaDonHang'])){
    $MaDonHang = $_POST['MaDonHang'];
    $TrangThai = $_POST['TrangThai'];

    $result = createTrangThaiDonHang($MaDonHang, $TrangThai);

    echo json_encode($result);
}

if (isset($_POST['action'])){
    if ($_POST['action'] == "add"){
        $maDonHang = $_POST['maDonHang'];
        $trangThai =  $_POST['trangThai'];
     
        // Gọi hàm PHP bạn muốn thực thi và trả về kết quả dưới dạng JSON
        $result = createTrangThaiDonHang($maDonHang, $trangThai);

        echo json_encode($result);

    }
}

function getTrangThaiDonHangByMaDonHang($maDonHang) {
    $connection = null;

    $query = "SELECT * FROM `TrangThaiDonHang` WHERE `MaDonHang` = :maDonHang ORDER BY `NgayCapNhat`";

    $connection = MysqlConfig::getConnection();

    try {
        $statement = $connection->prepare($query);

        if ($statement !== false) {
            $statement->bindValue(':maDonHang', $maDonHang, PDO::PARAM_INT);

            $statement->execute();

            $result = $statement->fetchALL(PDO::FETCH_ASSOC);

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
            "message" => "Lỗi không thể lấy thông tin trạng thái đơn hàng",
        ];
    } finally {
        $connection = null;
    }
}

function createTrangThaiDonHang($maDonHang, $trangThai) {
    $connection = null;

    $query = "INSERT INTO trangthaidonhang (MaDonHang, TrangThai) 
                VALUES (:maDonHang, :trangThai)";

    $connection = MysqlConfig::getConnection();

    try {
        $statement = $connection->prepare($query);

        if ($statement !== false) {
            $statement->bindValue(':maDonHang', $maDonHang, PDO::PARAM_INT);
            $statement->bindValue(':trangThai', $trangThai, PDO::PARAM_STR);

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
?>
