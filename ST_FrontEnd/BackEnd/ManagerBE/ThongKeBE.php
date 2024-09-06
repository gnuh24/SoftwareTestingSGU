<?php 
    require_once __DIR__ . "/../../Configure/MysqlConfig.php";

    if (isset($_GET['from']) && isset($_GET['to'])){

        $from = $_GET['from'];
        $to = $_GET['to'];

        if (isset($_GET['thongKeDonHang'])){

            $result = thongKeDonHang($from, $to);

            echo json_encode($result);

        }else if(isset($_GET['thongKeDoanhThu'])){

            $result = thongKeDoanhThu($from, $to);

            echo json_encode($result);

        }else if(isset($_GET['thongKeChiTieu'])){

            $result = thongKeChiTieu($from, $to);

            echo json_encode($result);
        }else if (isset($_GET['thongKeSanPhamBanChay'])){
            $result = thongKeSanPhamBanChay($from, $to);

            echo json_encode($result);
        }


    }

    function thongKeDonHang($from, $to){
        // Chuẩn bị kết nối
        $connection = null;

        // Chuẩn bị câu truy vấn
        $query = "SELECT DATE(dh.NgayDat) AS ngayLapDon, tdh.TrangThai AS trangThai, COUNT(*) AS soLuongDon
                FROM TrangThaiDonHang tdh
                INNER JOIN DonHang dh ON tdh.MaDonHang = dh.MaDonHang
                WHERE DATE(dh.NgayDat) BETWEEN COALESCE(:minDate, '2010-01-01') AND COALESCE(:maxDate, CURRENT_DATE())
                AND tdh.NgayCapNhat = (
                    SELECT MAX(tdh2.NgayCapNhat)
                    FROM TrangThaiDonHang tdh2
                    WHERE tdh2.MaDonHang = tdh.MaDonHang
                )
                GROUP BY DATE(dh.NgayDat), tdh.TrangThai
                ORDER BY DATE(dh.NgayDat)";

        try {
            // Khởi tạo kết nối
            $connection = MysqlConfig::getConnection();
            $statement = $connection->prepare($query);

            // Bind các giá trị tham số
            $statement->bindValue(':minDate', $from, PDO::PARAM_STR);
            $statement->bindValue(':maxDate', $to, PDO::PARAM_STR);

            // Thực thi truy vấn
            $statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);

            // Trả về kết quả
            return (object) [
                "status" => 200,
                "message" => "Thống kê thành công !!",
                "data" => $result
            ];
        } catch (PDOException $e) {
            // Xử lý nếu có lỗi
            return (object) [
                "status" => 400,
                "message" => "Lỗi không thể thống kê đơn hàng",
                "data" => []
            ];
        } finally {
            // Đóng kết nối
            $connection = null;
        }
    }

    function thongKeDoanhThu($from, $to){
        // Chuẩn bị kết nối
        $connection = null;

        // Chuẩn bị câu truy vấn
        $query = "  SELECT DATE(dh.NgayDat) as NgayThongKe, SUM(ct.SoLuong) AS SoLuongDaBan, SUM(ct.ThanhTien) AS DoanhThu
                    FROM DonHang dh
                    JOIN TrangThaiDonHang tt ON dh.maDonHang = tt.maDonHang
                    JOIN CTDH ct ON dh.maDonHang = ct.maDonHang
                    WHERE tt.ngayCapNhat = (
                            SELECT MAX(tdh2.ngayCapNhat)
                            FROM TrangThaiDonHang tdh2
                            WHERE tdh2.maDonHang = tt.maDonHang
                        )
                        AND tt.TrangThai = 'GiaoThanhCong'
                    AND DATE(dh.NgayDat) BETWEEN COALESCE(:minDate, '2010-01-01') AND COALESCE(:maxDate, CURRENT_DATE() )
                    GROUP BY DATE(dh.NgayDat)
                    ORDER BY DATE(dh.NgayDat);";

        try {
            // Khởi tạo kết nối
            $connection = MysqlConfig::getConnection();
            $statement = $connection->prepare($query);

            // Bind các giá trị tham số
            $statement->bindValue(':minDate', $from, PDO::PARAM_STR);
            $statement->bindValue(':maxDate', $to, PDO::PARAM_STR);

            // Thực thi truy vấn
            $statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);

            // Trả về kết quả
            return (object) [
                "status" => 200,
                "message" => "Thống kê thành công !!",
                "data" => $result
            ];
        } catch (PDOException $e) {
            // Xử lý nếu có lỗi
            return (object) [
                "status" => 400,
                "message" => "Lỗi không thể thống kê đơn hàng",
                "data" => []
            ];
        } finally {
            // Đóng kết nối
            $connection = null;
        }
    }

    function thongKeChiTieu($from, $to){
        // Chuẩn bị kết nối
        $connection = null;

        // Chuẩn bị câu truy vấn
        $query = "SELECT DATE(pnk.ngayNhapKho) AS NgayNhap,
                            SUM(ct.SoLuong) AS SoLuongDaNhap,
                            SUM(ct.ThanhTien) AS ChiTieu
                    FROM PhieuNhapKho pnk
                    JOIN CTPNK ct ON pnk.MaPhieu = ct.MaPhieu
                    WHERE DATE(pnk.ngayNhapKho) BETWEEN COALESCE(:minDate, '2010-01-01') AND COALESCE(:maxDate, CURRENT_DATE())
                    AND pnk.`TrangThai` = 'DaDuyet'
                    GROUP BY DATE(pnk.ngayNhapKho)
                    ORDER BY DATE(pnk.ngayNhapKho);";

        try {
            // Khởi tạo kết nối
            $connection = MysqlConfig::getConnection();
            $statement = $connection->prepare($query);

            // Bind các giá trị tham số
            $statement->bindValue(':minDate', $from, PDO::PARAM_STR);
            $statement->bindValue(':maxDate', $to, PDO::PARAM_STR);

            // Thực thi truy vấn
            $statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);

            // Trả về kết quả
            return (object) [
                "status" => 200,
                "message" => "Thống kê thành công !!",
                "data" => $result
            ];
        } catch (PDOException $e) {
            // Xử lý nếu có lỗi
            return (object) [
                "status" => 400,
                "message" => "Lỗi không thể thống kê đơn hàng",
                "data" => []
            ];
        } finally {
            // Đóng kết nối
            $connection = null;
        }
    }

    function thongKeSanPhamBanChay($from, $to){
        // Chuẩn bị kết nối
        $connection = null;

        // Chuẩn bị câu truy vấn
        $query = "SELECT sp.`MaSanPham` as `MaSanPham`, sp.`TenSanPham` as `TenSanPham`, SUM(ct.`SoLuong`) as `TongSoLuong`, SUM(ct.`ThanhTien`) as `TongDoanhThu` 
                    FROM `DonHang` dh 
                    JOIN `TrangThaiDonHang` tt ON dh.`MaDonHang` = tt.`MaDonHang`
                    JOIN `CTDH` ct ON dh.`MaDonHang` = ct.`MaDonHang`
                    JOIN `SanPham` sp ON sp.`MaSanPham` = ct.`MaSanPham` 
                    WHERE  tt.`NgayCapNhat` = (
                        SELECT MAX(stt.`NgayCapNhat`) FROM `TrangThaiDonHang` stt
                        WHERE dh.`MaDonHang` = stt.`MaDonHang`
                    )AND tt.`TrangThai` = 'GiaoThanhCong'
                    AND DATE(dh.`NgayDat`) BETWEEN COALESCE(:minDate ,'2010-01-01') AND COALESCE(:maxDate ,CURRENT_DATE)
                    GROUP BY sp.`MaSanPham`, sp.`TenSanPham`
                    ORDER BY `TongDoanhThu` desc, `TongSoLuong` desc;";

        try {
            // Khởi tạo kết nối
            $connection = MysqlConfig::getConnection();
            $statement = $connection->prepare($query);

            // Bind các giá trị tham số
            $statement->bindValue(':minDate', $from, PDO::PARAM_STR);
            $statement->bindValue(':maxDate', $to, PDO::PARAM_STR);

            // Thực thi truy vấn
            $statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);

            // Trả về kết quả
            return (object) [
                "status" => 200,
                "message" => "Thống kê thành công !!",
                "data" => $result
            ];
        } catch (PDOException $e) {
            // Xử lý nếu có lỗi
            return (object) [
                "status" => 400,
                "message" => "Lỗi không thể thống kê đơn hàng",
                "data" => []
            ];
        } finally {
            // Đóng kết nối
            $connection = null;
        }
    }

?>