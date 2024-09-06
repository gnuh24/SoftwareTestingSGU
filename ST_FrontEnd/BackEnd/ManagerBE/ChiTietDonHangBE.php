<?php
require_once __DIR__ . "/../../Configure/MysqlConfig.php";

if (isset($_POST['action'])) {
    if ($_POST['action'] == "add") {
        $maDonHang = $_POST['maDonHang'];
        $maSanPham =  $_POST['maSanPham'];
        $donGia =  $_POST['donGia'];
        $soLuong =  $_POST['soLuong'];
        $thanhTien =  $_POST['thanhTien'];

        // Gọi hàm PHP bạn muốn thực thi và trả về kết quả dưới dạng JSON
        $result = createChiTietDonHang($maDonHang, $maSanPham, $donGia, $soLuong, $thanhTien);

        echo json_encode($result);
    }
}

if (isset($_GET['MaDonHang'])) {
    $MaDonHang = $_GET['MaDonHang'];

    $result = getChiTietDonHangByMaDonHang($MaDonHang);

    echo json_encode($result);
}


function getChiTietDonHangByMaDonHang($maDonHang) {

    $connection = null;

    $query = "SELECT ct.`MaSanPham`, ct.`SoLuong`, ct.`ThanhTien`, ct.`DonGia`, sp.`TenSanPham`, sp.`AnhMinhHoa` FROM `CTDH` ct JOIN `SanPham` sp ON ct.`MaSanPham` = sp.`MaSanPham` WHERE `MaDonHang` = :maDonHang";

    $connection = MysqlConfig::getConnection();

    try {
        $statement = $connection->prepare($query);

        if ($statement !== false) {
            $statement->bindValue(':maDonHang', $maDonHang, PDO::PARAM_INT);

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
            "message" => "Lỗi không thể lấy thông tin chi tiết đơn hàng",
        ];
    } finally {
        $connection = null;
    }
}

function createChiTietDonHang($maDonHang, $maSanPham, $donGia, $soLuong, $thanhTien)
{
    $connection = null;

    $query = "INSERT INTO `CTDH` (`MaDonHang`, `MaSanPham`, `DonGia`, `SoLuong`, `ThanhTien`) 
                VALUES (:maDonHang, :maSanPham, :donGia, :soLuong, :thanhTien)";

    $connection = MysqlConfig::getConnection();

    try {
        $statement = $connection->prepare($query);

        if ($statement !== false) {
            $statement->bindValue(':maDonHang', $maDonHang, PDO::PARAM_INT);
            $statement->bindValue(':maSanPham', $maSanPham, PDO::PARAM_INT);
            $statement->bindValue(':donGia', $donGia, PDO::PARAM_INT);
            $statement->bindValue(':soLuong', $soLuong, PDO::PARAM_INT);
            $statement->bindValue(':thanhTien', $thanhTien, PDO::PARAM_INT);

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
