<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="SignedHomePage.css">
    <link rel="stylesheet" href="CreateOrder.css">
    <title>Thanh toán</title>
</head>
<body>
    <?php require "../Header/SignedHeader.php"; ?>

    <div>
        <section>
            <div class="center-text">
                <div class="title_section">
                    <div class="bar"></div>
                    <h2 class="center-text-share">Thanh Toán</h2>
                </div>
            </div>
        </section>
        <section>
            <div class="layout__wrapper">
                <div class="checkout__wrapper containerPage">
                    <div class="payment_info__wrapper">
                        <div class="payment_info">
                            <div id='checkout_form'>
                                <div class='input__wrapper'>
                                    <label for='username'>Họ tên:  <i class="fa-solid fa-lock"></i></label>
                                    <input type='text' name='username' id='username' placeholder='Nhập họ tên' readonly/>
                                </div>
                                <div class='input__wrapper'>
                                    <label for='phonenumber'>Số điện thoại: <i class="fa-solid fa-lock"></i></label>
                                    <input type='number' name='phonenumber' id='phonenumber' placeholder='Nhập số điện thoại' readonly/>
                                </div>
                                <div class='input__wrapper'>
                                    <label for='address'>Địa chỉ nhận hàng:</label>
                                    <input type='text' name='address' id='address' placeholder='Nhập địa chỉ' />
                                </div>
                                <div class='payment__wrapper'>
                                    <label>Phương thức thanh toán:</label>
                                    <?php require_once "../../../BackEnd/ManagerBE/PhuongThucThanhToan.php" ;
                                        $result = getAllPhuongThucThanhToanNoPaging()->data;
                                        foreach($result as $row){
                                            echo "
                                            <div class='radio__wrapper'>
                                                <div>
                                                    <input value=" . $row['MaPhuongThuc'] . " type='radio' name='payment' id='ghtk' />
                                                    <label for='cash'>" . $row['TenPhuongThuc'] . "</label>
                                                </div>
                                            </div>";
                                        }
                                    ?>
                                </div>
                                <div class='payment__wrapper'>
                                    <label>Dịch vụ vận chuyển:</label>
                                    <?php require_once "../../../BackEnd/ManagerBE/DichVuVanChuyenBE.php" ;
                                        $result = getAllDichVuVanChuyenNoPaging()->data;
                                        foreach($result as $row){
                                            echo "
                                            <div class='radio__wrapper'>
                                                <div>
                                                    <input value=" . $row['MaDichVu'] . " type='radio' name='shipping' id='ghtk'/>
                                                    <label for='cash'>" . $row['TenDichVu'] . "</label>
                                                </div>
                                            </div>";
                                        }
                                    ?>
                                </div>   
                                <div class='payment__wrapper'>
                                    <label>Các sản phẩm đặt mua</label>
                                    <?php require_once "../../../BackEnd/ManagerBE/GioHangBe.php" ;
                                        function formatMoney($amount) {
                                            return number_format($amount, 0, ',', '.') . 'đ';
                                        }
                                        if (isset($_GET['maTaiKhoan'])) {
                                            $totalPrice_Shipping = 0;
                                            $maTaiKhoan = $_GET['maTaiKhoan'];
                                            $result = getAllGioHangByMaTaiKhoan($maTaiKhoan)->data;
                                            foreach($result as $cartProduct){
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
                            <div class="divider"></div>
                            <div class="info__wrapper order_info2">
                                <p><span class="span1">Họ tên người nhận:</span><span class="span2" id="spanHoTen"></span></p>
                                <p><span class="span1">Số điện thoại:</span><span class="span2" id="spanSoDienThoai"></span></p>
                                <p><span class="span1">Địa chỉ giao hàng:</span><span class="span2" id="spanDiaChi"></span></p>
                                <p><span class="span1">Phương thức thanh toán:</span><span class="span2" id="spanPhuongThucThanhToan"></span></p>
                                <p><span class="span1">Dịch vụ vận chuyển:</span><span class="span2" id="spanDichVuVanChuyen"></span></p>
                            </div>
                            <div class="divider"></div>
                            <div class="info__wrapper total__info">
                                <p>Tổng cộng</p>
                                <p id="totalPrice"></p>
                            </div>
                            <button class="button" id="createOrder">Đặt hàng</button>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <?php require_once "../Footer/Footer.php" ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
       $(document).ready(function() {
            fillUserDataToInputs();
            fillOrderInfo();
        });
        
        function convertPriceToNumber(priceString) {
            var priceWithoutDot = priceString.replace(/\./g, '');
            var priceWithoutDong = priceWithoutDot.replace('đ', '');
            var priceNumber = parseInt(priceWithoutDong);
            return priceNumber;
        }

        document.getElementById('createOrder').addEventListener('click', function() {
            const maTaiKhoan = '<?php echo $maTaiKhoan; ?>';
            const hoTen = document.getElementById('username').value;
            const soDienThoai = document.getElementById('phonenumber').value;
            const diaChi = document.getElementById('address').value;
            const selectedPayment = document.querySelector('input[name="payment"]:checked');
            const maPhuongThuc = selectedPayment ? selectedPayment.value : '';
            const selectedShipping = document.querySelector('input[name="shipping"]:checked');
            const maDichVu = selectedShipping ? selectedShipping.value : '';

            if (!maPhuongThuc || !maDichVu) {
                Swal.fire({
                    title: 'Vui lòng chọn phương thức thanh toán và dịch vụ vận chuyển.',
                    icon: 'info',
                    confirmButtonText: 'OK'
                });
                return;
            }

            if (diaChi == "") {
                Swal.fire({
                    title: 'Vui lòng không để trống địa chỉ giao hàng.',
                    icon: 'info',
                    confirmButtonText: 'OK'
                });
                return;
            }

            const tongGiaTri = '<?php echo $totalPrice_Shipping; ?>';
            const danhSachChiTietDonHang = [];
            const cartItems = document.querySelectorAll('.cartItem');
            cartItems.forEach(function(item) {
                const maSanPham = item.id;
                const tenSanPham = item.querySelector('.nameCart').textContent;
                const donGia = convertPriceToNumber(item.querySelector('.priceCart').textContent);
                const soLuong = item.querySelector('.txtQuantity').textContent;
                const thanhTien = convertPriceToNumber(item.querySelector('.valueTotalPrice').textContent);

                danhSachChiTietDonHang.push({
                    maSanPham: maSanPham,
                    tenSanPham: tenSanPham,
                    donGia: donGia,
                    soLuong: soLuong,
                    thanhTien: thanhTien
                });
            });

            if (hoTen && soDienThoai && diaChi && maPhuongThuc && maDichVu && tongGiaTri && danhSachChiTietDonHang.length > 0) {
                const diaChiGiaoHang = diaChi;
                Swal.fire({
                    title: 'Đặt hàng',
                    text: 'Bạn có chắc muốn đặt hàng?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Đồng ý'
                }).then((result) => {
                    if (result.isConfirmed) {

                        createDonHang(maTaiKhoan, tongGiaTri, maPhuongThuc, maDichVu, diaChiGiaoHang, danhSachChiTietDonHang);

                        // Redirect to SignedProduct.php after placing the order
                        Swal.fire({
                            title: 'Đặt hàng thành công!',
                            text: 'Cảm ơn bạn đã đặt hàng. Chúng tôi sẽ xử lý đơn hàng của bạn sớm nhất có thể.',
                            icon: 'success',
                            confirmButtonText: 'OK'
                        }).then((result1) => {
                            if (result1.isConfirmed) {
                                window.location.href = 'SignedProduct.php'; // Chuyển hướng đến trang sản phẩm
                            }
                        });
                    }
                });
            } else {
                console.log("Vui lòng điền đầy đủ thông tin và chọn sản phẩm.");
            }
        });

        document.getElementById('address').addEventListener('input', function() {
            fillOrderInfo();
        });

        var paymentMethods = document.querySelectorAll('input[name="payment"]');
        paymentMethods.forEach(function(method) {
            method.addEventListener('change', function() {
                fillOrderInfo();
            });
        });

        var shippingMethods = document.querySelectorAll('input[name="shipping"]');
        shippingMethods.forEach(function(method) {
            method.addEventListener('change', function() {
                fillOrderInfo();
            });
        });

        document.getElementById('address').addEventListener('input', function() {
            fillOrderInfo();
        });

        function fillUserDataToInputs() {
            var userData = JSON.parse(localStorage.getItem('key'));
            if (userData) {
                document.getElementById('username').value = userData.HoTen;
                document.getElementById('phonenumber').value = userData.SoDienThoai;
                document.getElementById('address').value = userData.DiaChi;
            }
        }

        function fillOrderInfo() {
            var hoTen = document.getElementById('username').value;
            var soDienThoai = document.getElementById('phonenumber').value;
            var diaChi = document.getElementById('address').value;
            var selectedPayment = document.querySelector('input[name="payment"]:checked');
            var phuongThucThanhToan = selectedPayment ? selectedPayment.nextElementSibling.textContent : '';
            var selectedShipping = document.querySelector('input[name="shipping"]:checked');
            var dichVuVanChuyen = selectedShipping ? selectedShipping.nextElementSibling.textContent : '';

            document.getElementById('spanHoTen').textContent = hoTen;
            document.getElementById('spanSoDienThoai').textContent = soDienThoai;
            document.getElementById('spanDiaChi').textContent = diaChi;
            document.getElementById('spanPhuongThucThanhToan').textContent = phuongThucThanhToan;
            document.getElementById('spanDichVuVanChuyen').textContent = dichVuVanChuyen;

            var totalPrice = '<?php echo number_format($totalPrice_Shipping, 0, ',', '.'); ?>&nbsp;đ';
            document.getElementById('totalPrice').innerHTML = totalPrice;
        }

        function createDonHang(maTaiKhoan, tongGiaTri, maPhuongThuc, maDichVu, diaChiGiaoHang, danhSachChiTietDonHang) {
            $.ajax({
                url: "../../../BackEnd/ManagerBE/DonHangBE.php",
                method: "POST",
                dataType: "json",
                data: {
                    action: 'add',
                    maTaiKhoan: maTaiKhoan,
                    tongGiaTri: tongGiaTri,
                    maPhuongThuc: maPhuongThuc,
                    maDichVu: maDichVu,
                    diaChiGiaoHang: diaChiGiaoHang
                },
                success: function(response) {
                    let maDonHang = response.data;
                    danhSachChiTietDonHang.forEach(function(chiTiet) {
                        createCTDH(maDonHang, chiTiet.maSanPham, chiTiet.donGia, chiTiet.soLuong, chiTiet.thanhTien);
                    });
                },
                error: function(xhr, status, error) {
                    console.error("Error:", error);
                }
            });
        }

        function createCTDH(maDonHang, maSanPham, donGia, soLuong, thanhTien) {
            $.ajax({
                url: "../../../BackEnd/ManagerBE/ChiTietDonHangBE.php",
                method: "POST",
                dataType: "json",
                data: {
                    action: 'add',
                    maDonHang: maDonHang,
                    maSanPham: maSanPham,
                    donGia: donGia,
                    soLuong: soLuong,
                    thanhTien: thanhTien
                },
                success: function(response) {
                    
                },
                error: function(xhr, status, error) {
                    console.error("Error:", error);
                }
            });
        }
    </script>
</body>
</html>
