<?php
require_once "../../../BackEnd/ManagerBE/DonHangBE.php";

if (isset($_GET['maTaiKhoan'])) {
    $maTaiKhoan = $_GET['maTaiKhoan'];
    // Gọi hàm PHP bạn muốn thực thi và trả về kết quả dưới dạng JSON
    $data = getAllDonHangByMaKH($maTaiKhoan);
}

function convertNumberToVND($number)
{
    // Sử dụng number_format để định dạng số với dấu chấm ngăn cách hàng nghìn và không có phần thập phân
    $formattedNumber = number_format($number, 0, ',', '.');

    // Thêm ký tự 'đ' ở cuối số
    $vndString = $formattedNumber . 'đ';

    return $vndString;
}
?>

<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
    <link rel="stylesheet" href="../GuestPage/HomePage.css" />
    <link rel="stylesheet" href="../GuestPage/login.css" />
    <!-- <link rel="stylesheet" href="MyOrder.css" /> -->
    <title>Đơn hàng của tôi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

</head>

<body>
    <?php require_once "../Header/SignedHeader.php" ?>

    <section>
        <div class="center-text" style="margin-top: 20px;">
            <div class="title_section">
                <div class="bar"></div>
                <h2 class="center-text-share">Đơn hàng của bạn</h2>
            </div>
        </div>
    </section>

    <!-- Phần hiển thị đơn hàng -->
    <div class="orderManagement_order_history">
        <?php
        function formatMoney($amount)
        {
            return number_format($amount, 0, ',', '.') . 'đ';
        }

        // Kiểm tra số lượng đơn hàng
        $numberOfProducts = count(array_unique(array_column($data->data, 'MaDonHang')));

        if ($numberOfProducts <= 0) {
            echo '<p class="emty_cart" style="text-align: center;">Bạn chưa có đơn hàng nào!</p>';
        }

        // Hiển thị thông tin đơn hàng
        foreach ($data->data as $hoaDon) {
        ?>
            <div class='orderManagement_order_list'>
                <table class='orderManagement_order_info'>
                    <thead>
                        <tr class='orderManagement_order_title'>
                            <th class='anhMinhHoa'>Ảnh minh họa</th>
                            <th class='tenSanPham'>Tên sản phẩm</th>
                            <th class='donGia'>Đơn giá</th>
                            <th class='soLuong'>Số lượng</th>
                            <th class='thanhTien'>Thành tiền</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        require_once "../../../BackEnd/ManagerBE/ChiTietDonHangBE.php";

                        $listCTDH = getChiTietDonHangByMaDonHang($hoaDon["MaDonHang"])->data;

                        foreach ($listCTDH as $chiTiet) {
                        ?>
                            <tr class='orderManagement_order_detail'>
                                <td class='anhMinhHoa'><img style='width: auto; height: 100px;' src='<?= $chiTiet['AnhMinhHoa'] ?>'></td>
                                <td class='tenSanPham'><?= $chiTiet['TenSanPham'] ?></td>
                                <td class='donGia'><?= formatMoney($chiTiet['DonGia']) ?></td>
                                <td class='soLuong'><?= $chiTiet['SoLuong'] ?></td>
                                <td class='thanhTien'><?= formatMoney($chiTiet['ThanhTien']) ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
                <div class='orderManagement_order_thanhTien'>


                    <p style="width: 50%;">Trạng thái:
                        <?php
                        switch ($hoaDon['TrangThai']) {
                            case 'ChoDuyet':
                                echo "Chờ duyệt";
                                break;
                            case 'DaDuyet':
                                echo "Đã được duyệt";
                                break;
                            case 'DangGiao':
                                echo "Đang giao hàng";
                                break;
                            case 'GiaoThanhCong':
                                echo "Giao thành công";
                                break;
                            case 'Huy':
                                echo "Đã hủy";
                                break;
                            default:
                                echo $hoaDon['TrangThai'];
                        }
                        ?>
                    </p>
                    <p>Tổng giá trị: <?= convertNumberToVND($hoaDon['TongGiaTri']) ?></p>
                    <?php
                    // Chuyển danh sách sản phẩm thành chuỗi JSON để truyền vào hàm cancel

                    $listSanPham = json_encode($listCTDH);

                    if ($hoaDon['TrangThai'] == 'GiaoThanhCong' || $hoaDon['TrangThai'] == 'Huy') {
                        echo "<button class='order_detail_button' onclick='toOrderDetail({$hoaDon["MaDonHang"]})'> Chi tiết</button>";
                    } else {
                        echo "<button class='order_detail_button' onclick='toOrderDetail({$hoaDon["MaDonHang"]}, {$hoaDon["MaKH"]})'> Chi tiết</button>" .
                            "<button class='cancel_order_button' onclick='cancel({$hoaDon["MaDonHang"]}, \"{$hoaDon['TrangThai']}\", " . $listSanPham . ")'>Hủy đơn hàng</button>";
                    }
                    ?>
                </div>
                <!-- <div class='orderManagement_order_actions'>
                    
                </div> -->
            </div>
        <?php } ?>
    </div>


    <?php require_once "../Footer/Footer.php" ?>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function cancel(maDonHang, trangThai, listSanPham) {

            // Hiển thị hộp thoại xác thực
            Swal.fire({
                title: 'Xác nhận hủy đơn hàng?',
                text: "Bạn có chắc muốn hủy đơn hàng này?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Hủy đơn hàng'
            }).then((result) => {
                // Nếu người dùng xác nhận hủy đơn hàng
                if (result.isConfirmed) {
                    // Nếu trạng thái đơn hàng không phải là "Chờ duyệt"
                    if (trangThai !== "ChoDuyet") {
                        // Duyệt danh sách sản phẩm và gọi hàm tangSoLuongSanPham để hoàn trả số lượng
                        listSanPham.forEach(function(sanPham) {
                            var maSanPham = sanPham.MaSanPham;
                            var soLuong = sanPham.SoLuong;

                            tangSoLuongSanPham(maSanPham, soLuong);
                        });
                    }

                    // Gọi hàm createTrangThaiDonHang để cập nhật trạng thái đơn hàng
                    createTrangThaiDonHang(maDonHang);

                    // Hiển thị thông báo và reload trang
                    Swal.fire(
                        'Hủy đơn hàng thành công!',
                        '',
                        'success'
                    ).then((result) => {
                        if (result.isConfirmed) {
                            location.reload(); // Hoặc window.location.reload()
                        }
                    });
                }
            });
        }


        function createTrangThaiDonHang(maDonHang) {
            $.ajax({
                url: "../../../BackEnd/ManagerBE/TrangThaiDonHangBE.php",
                method: "POST",
                dataType: "json",
                data: {
                    MaDonHang: maDonHang,
                    TrangThai: "Huy"
                },
                success: function(response) {},
                error: function(xhr, status, error) {
                    console.error("Error:", error);
                }
            });
        }

        function tangSoLuongSanPham(maSanPham, soLuongTang) {
            $.ajax({
                url: '../../../BackEnd/ManagerBE/SanPhamBE.php',
                method: 'POST',
                dataType: 'json',
                data: {
                    action: 'up',
                    maSanPham: maSanPham,
                    soLuongTang: soLuongTang // Đảm bảo đặt tên trường đúng
                },
                success: function(response) {},
                error: function(xhr, status, error) {
                    console.error("Error:", error);
                }
            });
        }

        function toOrderDetail(maDonHang, maTaiKhoan) {
            window.location.href = `MyOrderInDetail.php?maDonHang=${maDonHang}&maTaiKhoan=${maTaiKhoan}`;
        }
    </script>
</body>

</html>