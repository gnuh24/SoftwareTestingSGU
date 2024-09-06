<?php
require_once "../../../BackEnd/ManagerBE/ChiTietPhieuNhapKhoBE.php";
require_once "../../../BackEnd/ManagerBE/PhieuNhapKhoBE.php";
require_once "../../../BackEnd/ManagerBE/SanPhamBE.php";

$maNhaCungCap = $_GET['MaNhaCungCap'];
$maQuanLy = $_GET['MaQuanLy'];
$productData = json_decode($_GET['ProductData'], true);

// Kiểm tra xem có dữ liệu GET được gửi từ AJAX không
if (isset($_GET['MaNhaCungCap']) && isset($_GET['MaQuanLy']) && isset($_GET['ProductData']) && !isset($_GET['MaPhieuNhapKho'])) {
    // Lấy dữ liệu từ GET request


    // Create a new DateTime object and format the date as a string
    // Thiết lập múi giờ của Việt Nam
    $dateZone = new DateTimeZone('Asia/Ho_Chi_Minh');

    // Tạo đối tượng DateTime với múi giờ của Việt Nam
    $date1 = new DateTime('now', $dateZone);

    // Định dạng ngày giờ
    $formattedDate = $date1->format('Y-m-d H:i:s');
        $tong =0;
        foreach ($productData as $tmp) {
            $tong+=$tmp['SoLuong']*$tmp['DonGia'];
        }
        // Tạo phiếu nhập kho
        $ketqua1 = createPhieuNhapKho($formattedDate, $tong, $maNhaCungCap, $maQuanLy);
        echo $tong;
        if ($ketqua1->status === 200) {
            $idpnh = $ketqua1->data;
            // Tạo chi tiết phiếu nhập cho từng sản phẩm
            foreach ($productData as $tmp) {
                createChiTietPhieuNhap($tmp['SoLuong'], $tmp['DonGia'], $idpnh, $tmp['MaSanPham']);
            }
            echo "Phiếu nhập kho đã được tạo thành công.";
        } else 
            echo "Lỗi: Không thể tạo phiếu nhập kho.";
        
    
    return;
}
if(isset($_GET['trangthai'])) {
    $trangthai = $_GET['trangthai'];
    $maphieu = $_GET['MaPhieuNhapKho'];

    if($trangthai == 'choduyet'){
        $tong = 0;
        foreach ($productData as $tmp) {
            $tong+=$tmp['SoLuong']*$tmp['DonGia'];
        }
        $ketqua1 = updatePhieuNhapKho($maphieu, $tong, $maNhaCungCap, $trangthai);
        echo $ketqua1->status;
        if ($ketqua1->status == 200) {
            foreach ($productData as $tmp) {
                UpdateChiTietPhieuNhap( $maphieu, $tmp['MaSanPham'],$tmp['SoLuong'], $tmp['DonGia']);
            }
            echo "Phiếu nhập kho đã được cập nhật thành công.";
        } else {
            echo "Lỗi: Không thể cập nhật phiếu nhập kho.";
        }
        echo "1";
        return;
    } else if ($trangthai == 'daduyet') {
        $tong = 0;
        foreach ($productData as $tmp) {
            $tong+=$tmp['SoLuong']*$tmp['DonGia'];
        }
        $ketqua1 = updatePhieuNhapKho($maphieu, $tong, $maNhaCungCap, $trangthai);
        echo $ketqua1->status;
                if ($ketqua1->status == 300){
            foreach ($productData as $tmp) {
                UpdateChiTietPhieuNhap( $maphieu, $tmp['MaSanPham'],$tmp['SoLuong'], $tmp['DonGia']);
                tangSoLuongSanPham($tmp['MaSanPham'],$tmp['SoLuong']);
            }
            echo "Phiếu nhập kho đã được cập nhật thành công.";
        } else {
            echo "Lỗi: Không thể cập nhật phiếu nhập kho.";
        }
    } else if ($trangthai == 'huy'){
        $tong = 0;
        foreach ($productData as $tmp) {
            $tong+=$tmp['SoLuong']*$tmp['DonGia'];
        }
        $ketqua1 = updatePhieuNhapKho($maphieu, $tong, $maNhaCungCap, $trangthai);
        echo $ketqua1->status;
        if ($ketqua1->status == 300 || $ketqua1->status == 200){
            echo "Phiếu nhập kho đã được cập nhật thành công.";
        }else {
            echo "Lỗi: Không thể cập nhật phiếu nhập kho.";
        }

    }
} else {
    // Nếu không có dữ liệu GET hoặc dữ liệu không đủ, bạn có thể trả về thông báo lỗi.
    echo "Lỗi: Dữ liệu không hợp lệ.";
}
