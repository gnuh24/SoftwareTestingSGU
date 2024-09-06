<?php
require_once __DIR__ . "/../../Configure/MysqlConfig.php";

if (isset($_POST["action"])){

    if ($_POST["action"] == 'deleteCart') {
        $result = deleteGioHang($_POST["maTaiKhoan"], $_POST["productId"]);

        echo json_encode($result);
    }else if($_POST["action"] == 'increase'){
        $result = updateGioHang($_POST["maTaiKhoan"], $_POST["productId"],  $_POST["donGia"],  $_POST["soLuong"],  $_POST["thanhTien"]);

        echo json_encode($result);
    }else if($_POST["action"] == 'decrease'){
        $result = updateGioHang($_POST["maTaiKhoan"], $_POST["productId"],  $_POST["donGia"],  $_POST["soLuong"],  $_POST["thanhTien"]);

        echo json_encode($result);
    }else if ($_POST["action"] == 'add') {
        $maTaiKhoan = $_POST["maTaiKhoan"];
        $maSanPham = $_POST["maSanPham"];
        $donGia = $_POST["donGia"];
        $soLuong = $_POST["soLuong"];
        $thanhTien = $_POST["thanhTien"];
    
        // Kiểm tra xem sản phẩm đã tồn tại trong giỏ hàng hay chưa
        $gioHang = getGioHangById($maTaiKhoan, $maSanPham);
    
        if ($gioHang->status == 200 && $gioHang->data != null) {
            // Sản phẩm đã tồn tại trong giỏ hàng
            $soLuongHienTai = $gioHang->data['SoLuong'];
            $soLuongMoi = $soLuongHienTai + $soLuong;
    
            // Lấy thông tin số lượng tồn kho của sản phẩm từ kết quả truy vấn
            $soLuongConLai = $gioHang->data['SoLuongConLai'];
    
            // Kiểm tra nếu tổng số lượng mới lớn hơn số lượng tồn kho
            if ($soLuongMoi > $soLuongConLai) {
                $soLuongMoi = $soLuongConLai; // Đặt số lượng mới bằng số lượng tồn kho
            }
    
            // Cập nhật giỏ hàng với số lượng mới tính được
            $result = updateGioHang($maTaiKhoan, $maSanPham, $donGia, $soLuongMoi, $thanhTien);
        } else {
            // Sản phẩm chưa tồn tại trong giỏ hàng, thêm mới vào giỏ hàng
            $result = createGioHang($maTaiKhoan, $maSanPham, $donGia, $soLuong, $thanhTien);
        }
    
        echo json_encode($result);
    }
    
}


function getGioHangById($maTaiKhoan, $maSanPham){
    $connection = null;
    $query = "SELECT * FROM `GioHang` JOIN `SanPham`  ON `GioHang`.`MaSanPham` = `SanPham`.`MaSanPham` WHERE `MaTaiKhoan` = :maTaiKhoan AND `SanPham`.`MaSanPham` = :maSanPham";
    $connection = MysqlConfig::getConnection();
    
    try {
        $statement = $connection->prepare($query);
        
        if ($statement !== false) {
            $statement->bindValue(':maTaiKhoan', $maTaiKhoan, PDO::PARAM_INT);
            $statement->bindValue(':maSanPham', $maSanPham, PDO::PARAM_INT);

            $statement->execute();
            $result = $statement->fetch(PDO::FETCH_ASSOC);
            
            return (object) [
                "status" => 200,
                "message" => "Thành công",
                "data" => $result
            ];
        } else {
            throw new PDOException("Lỗi khi lấy giỏ hàng theo mã tài khoản.");
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


function getAllGioHangByMaTaiKhoan($maTaiKhoan) {
    $connection = null;
    $query = "SELECT * FROM `GioHang` JOIN `SanPham`  ON `GioHang`.`MaSanPham` = `SanPham`.`MaSanPham` WHERE `MaTaiKhoan` = :maTaiKhoan";
    $connection = MysqlConfig::getConnection();
    
    try {
        $statement = $connection->prepare($query);
        
        if ($statement !== false) {
            $statement->bindValue(':maTaiKhoan', $maTaiKhoan, PDO::PARAM_INT);
            $statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
            
            return (object) [
                "status" => 200,
                "message" => "Thành công",
                "data" => $result
            ];
        } else {
            throw new PDOException("Lỗi khi lấy giỏ hàng theo mã tài khoản.");
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

function createGioHang($maTaiKhoan, $maSanPham, $donGia, $soLuong, $thanhTien) {
    $connection = null;
    $query_insert = "INSERT INTO `GioHang` (`MaTaiKhoan`, `MaSanPham`, `DonGia`, `SoLuong`, `ThanhTien`) 
                        VALUES (:maTaiKhoan, :maSanPham, :donGia, :soLuong, :thanhTien)";
    $connection = MysqlConfig::getConnection();
    
    try {
        $statement = $connection->prepare($query_insert);
        
        if ($statement !== false) {
            $statement->bindValue(':maTaiKhoan', $maTaiKhoan, PDO::PARAM_INT);
            $statement->bindValue(':maSanPham', $maSanPham, PDO::PARAM_INT);
            $statement->bindValue(':donGia', $donGia, PDO::PARAM_INT);
            $statement->bindValue(':soLuong', $soLuong, PDO::PARAM_INT);
            $statement->bindValue(':thanhTien', $thanhTien, PDO::PARAM_INT);
            
            $statement->execute();
            
            return (object) [
                "status" => 200,
                "message" => "Thêm giỏ hàng thành công"
            ];
        } else {
            throw new PDOException("Lỗi khi tạo giỏ hàng mới.");
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

function updateGioHang($maTaiKhoan, $maSanPham, $donGia, $soLuong, $thanhTien) {
    $connection = null;
    $query_update = "UPDATE `GioHang` 
                        SET `DonGia` = :donGia, `SoLuong` = :soLuong, `ThanhTien` = :thanhTien 
                        WHERE `MaTaiKhoan` = :maTaiKhoan AND `MaSanPham` = :maSanPham";
    $connection = MysqlConfig::getConnection();
    
    try {
        $statement = $connection->prepare($query_update);
        
        if ($statement !== false) {
            $statement->bindValue(':maTaiKhoan', $maTaiKhoan, PDO::PARAM_INT);
            $statement->bindValue(':maSanPham', $maSanPham, PDO::PARAM_INT);
            $statement->bindValue(':donGia', $donGia, PDO::PARAM_INT);
            $statement->bindValue(':soLuong', $soLuong, PDO::PARAM_INT);
            $statement->bindValue(':thanhTien', $thanhTien, PDO::PARAM_INT);
            
            $statement->execute();
            
            return (object) [
                "status" => 200,
                "message" => "Cập nhật giỏ hàng thành công"
            ];
        } else {
            throw new PDOException("Lỗi khi cập nhật giỏ hàng.");
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

function deleteGioHang($maTaiKhoan, $maSanPham) {
    $connection = null;
    $query_delete = "DELETE FROM `GioHang` WHERE `MaTaiKhoan` = :maTaiKhoan AND `MaSanPham` = :maSanPham";
    $connection = MysqlConfig::getConnection();
    
    try {
        $statement = $connection->prepare($query_delete);
        
        if ($statement !== false) {
            $statement->bindValue(':maTaiKhoan', $maTaiKhoan, PDO::PARAM_INT);
            $statement->bindValue(':maSanPham', $maSanPham, PDO::PARAM_INT);
            
            $statement->execute();
            
            return (object) [
                "status" => 200,
                "message" => "Xóa sản phẩm khỏi giỏ hàng thành công"
            ];
        } else {
            throw new PDOException("Lỗi khi xóa sản phẩm khỏi giỏ hàng.");
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
