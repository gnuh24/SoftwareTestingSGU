<?php
    require_once "../../../BackEnd/ManagerBE/TrangThaiDonHangBE.php";

    if (isset($_GET['maDonHang'])) {
        $maDonHang = $_GET['maDonHang'];
        // Gọi hàm PHP bạn muốn thực thi và trả về kết quả dưới dạng JSON
        $result = getTrangThaiDonHangByMaDonHang($maDonHang)->data;

    }
?>

<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
    <link rel="stylesheet" href="../GuestPage/HomePage.css" />
    <link rel="stylesheet" href="../GuestPage/login.css" />
    <link rel="stylesheet" href="MyOrderInDetail.css" />
    <link rel="stylesheet" href="CreateOrder.css" />


    <title>Chi tiết đơn hàng</title>
</head>
<body>
    <?php require_once "../Header/SignedHeader.php" ?>

    <section>
        <div class="center-text" style="margin-top: 20px;">
            <div class="title_section">
                <div class="bar"></div>
                <h2 class="center-text-share">Chi tiết đơn hàng</h2>
            </div>
        </div>
    </section>

    <section style="padding: 0 5%;">
        <div id="chiTietTrangThaiContent">
            <div id="circle-container1" class="circle-container">
                <div id="ele1" class="chiTietTrangThaiElement">
                    <i id="icon1" class="fa-solid fa-cart-shopping icon"></i>  
                    <p class="trangThai">Chờ duyệt</p>
                    <p id="thoiGian1" class="thoiGian"></p>
                </div>
            </div>

            <div id="line1" class="line">_____________________</div>

            <div id="circle-container2" class="circle-container">
                <div id="ele2" class="chiTietTrangThaiElement">
                    <i id="icon2" class="fa-solid fa-circle-user icon"></i>
                    <p class="trangThai">Đã duyệt</p>
                    <p id="thoiGian2" class="thoiGian"></p>
                </div>
            </div>

            <div id="line2" class="line">_____________________</div>

            <div id="circle-container3" class="circle-container">
                <div id="ele3" class="chiTietTrangThaiElement">
                    <i id="icon3" class="fa-solid fa-truck-fast icon"></i>  
                    <p class="trangThai">Đang giao</p>
                    <p id="thoiGian3" class="thoiGian"></p>
                </div>
            </div>

            <div id="line3" class="line">_____________________</div>
            
            <div id="circle-container4" class="circle-container">
                <div id="ele4" class="chiTietTrangThaiElement">
                    <i id="icon4" class="fa-solid fa-gift icon"></i>   
                    <p class="trangThai">Giao thành công</p>
                    <p id="thoiGian4" class="thoiGian"></p>
                </div>
            </div>

            <div id="line4" class="line">_____________________</div>
            
            <div id="circle-container5" class="circle-container">
                <div id="ele5" class="chiTietTrangThaiElement">
                    <i id="icon5" class="fa-solid fa-ban icon"></i>
                    <p class="trangThai">Hủy</p>
                    <p id="thoiGian5" class="thoiGian"></p>
                </div>
            </div>
        </div>
    </section>

    <section>
            <div class="layout__wrapper">
                <div class="checkout__wrapper containerPage" style="margin-top: 30px;">
                    <div class="payment_info__wrapper">
                        <div class="payment_info">
                            <div id='checkout_form'>
                                <div class='payment__wrapper'>
                                    <label>Các sản phẩm đặt mua</label>
                                    <?php require_once "../../../BackEnd/ManagerBE/ChiTietDonHangBe.php" ;

                                    function formatMoney($amount) {
                                        return number_format($amount, 0, ',', '.') . 'đ';
                                    }

                                    if (isset($_GET['maDonHang'])) {
                                        $totalPrice_Shipping = 0;
                                        $maDonHang = $_GET['maDonHang'];
                                        $result2 = getChiTietDonHangByMaDonHang($maDonHang)->data;
                                            foreach($result2 as $cartProduct){
                                                $totalPrice_Shipping +=  $cartProduct['ThanhTien'];
                                                $formattedPrice = formatMoney($cartProduct['DonGia']);
                                                $formattedTotalPrice = formatMoney($cartProduct['ThanhTien']);
                                                echo "
                                                <div class='radio__wrapper'>
                                                    <div>
                                                        <div class='cartItem' id='{$cartProduct['MaSanPham']}'>
                                                            <a href='#' class='img'><img class='img' src='{$cartProduct['AnhMinhHoa']}' /></a>
                                                            <div class='inforCart'>
                                                                <div class='nameAndPrice'>
                                                                    <a href='#' class='nameCart'>{$cartProduct['TenSanPham']}</a>
                                                                    <p class='priceCart'>$formattedPrice</p>
                                                                </div>
                                                                <div class='quantity'>
                                                                    <div class='txtQuantity'>{$cartProduct['SoLuong']}</div>
                                                                </div>
                                                            </div>
                                                            <div class='wrapTotalPriceOfCart'>
                                                                <div class='totalPriceOfCart'>
                                                                    <p class='lablelPrice'>Thành tiền</p>
                                                                    <p class='valueTotalPrice'>$formattedTotalPrice</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>";
                                                
                                            }
                                        }else{
                                            echo "<h1> Không in ra được =((( </h1>";
                                        }
                                        
                                    ?>
                                </div>
                             
                        

                                <p class='hotline'>
                                    * Để được hỗ trợ trực tiếp và nhanh nhất vui lòng liên hệ THug88
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="order_info__wrapper">
                        <div class="order_info">
                            <p class="title" style="text-align: center;">Thông tin đơn hàng</p>

                            <?php 

                            require_once "../../../BackEnd/ManagerBE/DonHangBE.php";


                            $donHang = getDonHangByMaDonHang($_GET['maDonHang'])->data;

                            echo '<div class="divider"></div>
                            <div class="info__wrapper order_info2">
                                <p><span class="span1">Họ tên người nhận:</span><span class="span2" id="spanHoTen">' . $donHang['HoTen'] . '</span></p>
                                <p><span class="span1">Số điện thoại:</span><span class="span2" id="spanSoDienThoai">' . $donHang['SoDienThoai'] . '</span></p>
                                <p><span class="span1">Địa chỉ giao hàng:</span><span class="span2" id="spanDiaChi">' . $donHang['DiaChiGiaoHang'] . '</span></p>
                                <p><span class="span1">Phương thức thanh tóan:</span><span class="span2" id="spanPhuongThucThanhToan">' . $donHang['TenPhuongThuc'] . '</span></p>
                                <p><span class="span1">Dịch vụ vận chuyển:</span><span class="span2" id="spanDichVuVanChuyen">' . $donHang['TenDichVu'] . '</span></p>
                            </div>
                            <div class="divider"></div>
                            <div class="info__wrapper total__info">
                                <p>Tổng cộng</p>
                                <p id="totalPrice">' . formatMoney($donHang['TongGiaTri']) . '</p>
                            </div>';
                      

                            ?>
                            
                        </div>
                    </div>
                </div>
            </div>
        </section>

  

    <?php require_once "../Footer/Footer.php" ?>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {
            // Lấy dữ liệu trạng thái đơn hàng từ PHP và chuyển đổi thành mảng JavaScript
            var trangThaiDonHang = <?php echo json_encode($result); ?>;

            // Lặp qua mỗi trạng thái trong mảng
            trangThaiDonHang.forEach(function(trangThai) {

                // Lấy thông tin trạng thái và thời gian
                var trangThaiValue = trangThai.TrangThai;
                var thoiGianValue = trangThai.NgayCapNhat;
                console.log(trangThaiValue);
                setColorAndTime(trangThaiValue, thoiGianValue);

                // if (trangThaiValue == "Huy"){
                //     setColorAndTime(trangThaiValue, thoiGianValue);

                //     // Cập nhật màu sắc và thời gian cho container tương ứng
                //     return;
                // }


                
            });
        });

      // Hàm cập nhật màu sắc và thời gian cho container được chỉ định
        function setColorAndTime(trangThaiValue, thoiGianValue) {
            console.log(`Đã vào được trong ${trangThaiValue} và ${thoiGianValue}`);
            
            // Chọn các phần tử sử dụng jQuery
            const $line1 = $('#line1');
            const $line2 = $('#line2');
            const $line3 = $('#line3');
            const $line4 = $('#line4');


            const $thoiGian1 = $('#thoiGian1');
            const $thoiGian2 = $('#thoiGian2');
            const $thoiGian3 = $('#thoiGian3');
            const $thoiGian4 = $('#thoiGian4');
            const $thoiGian5 = $('#thoiGian5');

            const $icon1 = $('#icon1');
            const $icon2 = $('#icon2');
            const $icon3 = $('#icon3');
            const $icon4 = $('#icon4');
            const $icon5 = $('#icon5');

            const $circleContainer1 = $('#circle-container1');
            const $circleContainer2 = $('#circle-container2');
            const $circleContainer3 = $('#circle-container3');
            const $circleContainer4 = $('#circle-container4');
            const $circleContainer5 = $('#circle-container5');


            // Thực hiện thay đổi CSS sử dụng jQuery
            switch (trangThaiValue) {
                case 'ChoDuyet':
                    $icon1.css("color", "green");
                    $circleContainer1.css("border-color", "green");
                    $thoiGian1.html(chuyenDoiNgayThang(thoiGianValue));
                    break;
                case 'DaDuyet':
                    $icon2.css("color", "green");
                    $line1.css("color", "green");
                    $circleContainer2.css("border-color", "green");
                    $thoiGian2.html(chuyenDoiNgayThang(thoiGianValue));

                    break;
                case 'DangGiao':
                    $icon3.css("color", "green");
                    $line2.css("color", "green");
                    $circleContainer3.css("border-color", "green");
                    $thoiGian3.html(chuyenDoiNgayThang(thoiGianValue));

                    break;
                case 'GiaoThanhCong':
                    $icon4.css("color", "green");
                    $line3.css("color", "green");
                    $circleContainer4.css("border-color", "green");
                    $thoiGian4.html(chuyenDoiNgayThang(thoiGianValue));

                    break;
                case 'Huy':

                    $icon1.css("color", "rgb(146, 26, 26)");
                    $circleContainer1.css("border-color", "rgb(146, 26, 26)");

                    $icon2.css("color", "rgb(146, 26, 26)");
                    $line1.css("color", "rgb(146, 26, 26)");
                    $circleContainer2.css("border-color", "rgb(146, 26, 26)");

                    $icon3.css("color", "rgb(146, 26, 26)");
                    $line2.css("color", "rgb(146, 26, 26)");
                    $circleContainer3.css("border-color", "rgb(146, 26, 26)");

                    $icon4.css("color", "rgb(146, 26, 26)");
                    $line3.css("color", "rgb(146, 26, 26)");
                    $circleContainer4.css("border-color", "rgb(146, 26, 26)");

                    $icon5.css("color", "rgb(146, 26, 26)");
                    $line4.css("color", "rgb(146, 26, 26)");
                    $circleContainer5.css("border-color", "rgb(146, 26, 26)");
                    $thoiGian5.html(chuyenDoiNgayThang(thoiGianValue));

                    break;
                default:
                    break;
            }
        }


        function chuyenDoiNgayThang(input) {
            // Tạo một đối tượng Date từ chuỗi đầu vào
            var date = new Date(input);

            // Lấy các thành phần của ngày tháng
            var gio = date.getHours();
            var phut = date.getMinutes();
            var giay = date.getSeconds();
            var ngay = date.getDate();
            var thang = date.getMonth() + 1; // Vì tháng trong JavaScript bắt đầu từ 0
            var nam = date.getFullYear();

            // Đảm bảo rằng các giá trị có dạng hai chữ số (ví dụ: 01 thay vì 1)
            gio = gio < 10 ? '0' + gio : gio;
            phut = phut < 10 ? '0' + phut : phut;
            giay = giay < 10 ? '0' + giay : giay;
            ngay = ngay < 10 ? '0' + ngay : ngay;
            thang = thang < 10 ? '0' + thang : thang;

            // Trả về chuỗi đã định dạng
            return gio + ':' + phut + ':' + giay + ' ' + ngay + '/' + thang + '/' + nam;
        }
    </script>
</body>
</html>
