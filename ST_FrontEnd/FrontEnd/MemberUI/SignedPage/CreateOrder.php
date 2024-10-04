<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="SignedHomePage.css">
    <link rel="stylesheet" href="CreateOrder.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Thanh toán</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
                                    <label for='username'>Họ tên: </label>
                                    <input type='text' name='username' id='username' placeholder='Nhập họ tên' />
                                </div>
                                <div class='input__wrapper'>
                                    <label for='phonenumber'>Số điện thoại: </label>
                                    <input type='text' name='phonenumber' id='phonenumber' placeholder='Nhập số điện thoại' pattern="^(0|\+84)[0-9]{9}$" required />
                                    <small class="text-danger" id="phoneError" style="display:none;">Số điện thoại không hợp lệ. Vui lòng nhập lại.</small>
                                </div>

                                <div class='input__wrapper'>
                                    <label for='address'>Ghi chú:</label>
                                    <input type='text' name='address' id='address' placeholder='Nhập ghi chú' />
                                </div>
                                <div class='input__wrapper'>
                                    <label for='address1'>Địa chỉ: </label>
                                    <input type='text' name='address1' id='address1' placeholder='Địa chỉ' />
                                </div>
                                <div class='payment__wrapper'>
                                    <label>Các sản phẩm đặt mua</label>
                                    <div id="cartItems"></div>
                                </div>
                                <p class='hotline'>
                                    * Để được hỗ trợ trực tiếp và nhanh nhất vui lòng liên hệ THug88
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="order_info__wrapper">
                        <div class="order_info" style="padding: 20px">
                            <p class="title" style="text-align: center;">Thông tin đơn hàng</p>
                            <div class="divider"></div>
                            <div class="info__wrapper order_info2">
                                <p><span class="span1">Họ tên người nhận:</span><span class="span2" id="spanHoTen"></span></p>
                                <p><span class="span1">Số điện thoại:</span><span class="span2" id="spanSoDienThoai"></span></p>
                                <p><span class="span1">Địa chỉ:</span><span class="span2" id="spanDiaChi1"></span></p>
                                <p><span class="span1">Ghi chú:</span><span class="span2" id="spanDiaChi"></span></p>
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
</body>

<script>
    $(document).ready(function() {
        // fillUserDataToInputs();
        // fillOrderInfo();
        loadCart();
        loadUserInfoFromsessionStorage();
    });
    var listproduct = [];
    var totalpriceall = 0;

    function convertPriceToNumber(priceString) {
        var priceWithoutDot = priceString.replace(/\./g, '');
        var priceWithoutDong = priceWithoutDot.replace('đ', '');
        var priceNumber = parseInt(priceWithoutDong);
        return priceNumber;
    }

    function loadCart() {
        var token = sessionStorage.getItem("token");
        var maTaiKhoan = sessionStorage.getItem("id");
        $.ajax({
            url: 'http://localhost:8080/CartItem/' + maTaiKhoan, // URL của file PHP API
            method: 'GET',
            dataType: 'json',
            headers: {
                'Authorization': `Bearer ${token}` // Thêm JWT token vào header
            },
            success: function(response) {
                let cartHTML = '';
                let totalPrice = 0;

                // Duyệt qua các sản phẩm trong giỏ hàng và tạo HTML
                response.forEach(function(cartProduct) {
                    totalPrice += cartProduct.total;
                    var maSanPham = cartProduct.productId;
                    var donGia = cartProduct.unitPrice;
                    var soLuong = cartProduct.quantity;
                    var total1 = cartProduct.total;

                    var productItem = {
                        'idProductId': maSanPham,
                        'unitPrice': donGia,
                        'quantity': soLuong,
                        'total': total1
                    };
                    listproduct.push(productItem);
                    cartHTML += `
                        <div class='radio__wrapper'>
                            <div>
                                <div class='cartItem' id='${cartProduct.productId}'>
                                    <a href='#' class='img'><img class='img' src='http://res.cloudinary.com/djhoea2bo/image/upload/v1711511636/${cartProduct.image}' /></a>
                                    <div class='inforCart'>
                                        <div class='nameAndPrice'>
                                            <p class='priceCart'>${formatCurrency(cartProduct.unitPrice)}</p>
                                        </div>
                                        <div class='quantity'>
                                            <div class='txtQuantity'>${cartProduct.quantity}</div>
                                        </div>
                                    </div>
                                    <div class='wrapTotalPriceOfCart'>
                                        <div class='totalPriceOfCart'>
                                            <p class='lablelPrice'>Thành tiền</p>
                                            <p class='valueTotalPrice'>${formatCurrency(cartProduct.total)}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>`;
                });

                // Hiển thị giỏ hàng trên trang
                $('#cartItems').html(cartHTML);
                totalpriceall = totalPrice;
                $('#totalPrice').text(formatCurrency(totalPrice));

            },
            error: function(xhr, status, error) {
                console.error('Có lỗi xảy ra: ', error);
            }
        });
    }

    function formatCurrency(number) {
        // Chuyển đổi số thành chuỗi và đảm bảo nó là số nguyên
        number = parseInt(number);

        // Sử dụng hàm toLocaleString() để định dạng số tiền
        // và thêm đơn vị tiền tệ "đ" vào cuối chuỗi
        return number.toLocaleString('vi-VN', {
            style: 'currency',
            currency: 'VND'
        });
    }
    document.getElementById('address').addEventListener('input', function() {
        fillOrderInfo();
    });
    document.getElementById('username').addEventListener('input', function() {
        fillOrderInfo();
    });
    document.getElementById('phonenumber').addEventListener('input', function() {
        fillOrderInfo();
    });
    document.getElementById('address1').addEventListener('input', function() {
        fillOrderInfo();
    });

    function loadUserInfoFromsessionStorage() {
        const token = sessionStorage.getItem("token");
        var userData = sessionStorage.getItem("id");
        $.ajax({
            url: "http://localhost:8080/Account/" + userData,
            method: "GET",
            dataType: "json",
            headers: {
                'Authorization': 'Bearer ' + token
            },
            success: function(response) {
                console.log(response)
                document.getElementById('spanHoTen').textContent = response.fullname;
                document.getElementById('spanSoDienThoai').textContent = response.phoneNumber;
                document.getElementById('spanDiaChi1').textContent = response.address;

                document.getElementById('username').value = response.fullname;
                document.getElementById('address1').value = response.address;

                document.getElementById('phonenumber').value = response.phoneNumber;
            },
            error: function(xhr, status, error) {
                console.error("Error:", error);
            }
        });
    }

    function fillOrderInfo() {

        var diaChi = document.getElementById('username').value;
        document.getElementById('spanHoTen').textContent = diaChi;
        diaChi = document.getElementById('phonenumber').value;
        document.getElementById('spanSoDienThoai').textContent = diaChi;
        diaChi = document.getElementById('address').value;
        document.getElementById('spanDiaChi').textContent = diaChi;
        diaChi = document.getElementById('address1').value;
        document.getElementById('spanDiaChi1').textContent = diaChi;
    }
    document.getElementById('createOrder').addEventListener('click', function() {
        const maTaiKhoan = sessionStorage.getItem("id");
        const hoTen = document.getElementById('username').value.trim(); // Lấy giá trị của trường Họ tên
        const soDienThoai = document.getElementById('phonenumber').value.trim(); // Lấy giá trị của trường Số điện thoại
        const diaChi = document.getElementById('address1').value.trim(); // Lấy giá trị của trường Địa chỉ
        const ghiChu = document.getElementById('address').value.trim(); // Lấy giá trị của trường Ghi chú
        const phonePattern = /^(0|\+84)[0-9]{9}$/;
        if (!phonePattern.test(soDienThoai)) {
            document.getElementById('phoneError').style.display = 'block';
            return; // Ngăn không cho hàm tiếp tục
        } else {
            document.getElementById('phoneError').style.display = 'none'; // Ẩn thông báo lỗi nếu số điện thoại hợp lệ
        }
        // Kiểm tra nếu bất kỳ trường nào bị trống
        if (!hoTen || !soDienThoai || !diaChi) {
            Swal.fire({
                title: 'Vui lòng điền đầy đủ thông tin!',
                text: 'Các trường Họ tên, Số điện thoại và Địa chỉ là bắt buộc.',
                icon: 'warning',
                confirmButtonText: 'OK'
            });
            return; // Ngăn không cho hàm createDonHang thực hiện
        }

        // Xác nhận đặt hàng nếu tất cả các trường đều được điền
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
                updateInfor();
                createDonHang(); // Gọi hàm tạo đơn hàng
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
    });

    function updateInfor() {
        var formData = new FormData();
        const maTaiKhoan = sessionStorage.getItem("id");

        formData.append('accountId', maTaiKhoan);
        formData.append('fullname', document.getElementById('username').value);
        formData.append('phone', document.getElementById('phonenumber').value);
        formData.append('address', document.getElementById('address1').value);
        const token = sessionStorage.getItem("token");
        $.ajax({
            url: 'http://localhost:8080/Account/UpdateInformation',
            type: 'PATCH',
            data: formData,
            contentType: false,
            processData: false,
            headers: {
                'Authorization': 'Bearer ' + token
            },
            success: function(response) {},
            error: function(xhr, status, error) {
                console.error("Error:", error);
            }
        });
    }


    function createDonHang() {
        var token = sessionStorage.getItem("token");
        var userData = sessionStorage.getItem("id");
        var formData = new FormData();
        formData.append('totalPrice', totalpriceall);
        var diaChi = document.getElementById('address').value;

        formData.append('accountId', userData);
        formData.append('note', diaChi);

        listproduct.forEach((item, index) => {
            formData.append(`listOrderDetail[${index}].productId`, item.idProductId);
            formData.append(`listOrderDetail[${index}].unitPrice`, item.unitPrice);
            formData.append(`listOrderDetail[${index}].quantity`, item.quantity);
            formData.append(`listOrderDetail[${index}].total`, item.total);
        });
        $.ajax({
            url: "http://localhost:8080/Order/User",
            method: "POST",
            data: formData,
            processData: false, // Ngăn jQuery xử lý dữ liệu
            contentType: false, // Ngăn jQuery thiết lập tiêu đề `Content-Type`
            headers: {
                'Authorization': 'Bearer ' + token
            },
            success: function(response) {},
            error: function(xhr, status, error) {
                console.error("Error:", error);
            }
        });
        listproduct.forEach((item, index) => {
            var formData1 = new FormData();
            formData1.append('accountId', userData);
            formData1.append('productId', item.idProductId);
            $.ajax({
                url: "http://localhost:8080/CartItem",
                method: "DELETE",
                data: formData1,
                processData: false, // Ngăn jQuery xử lý dữ liệu
                contentType: false, // Ngăn jQuery thiết lập tiêu đề `Content-Type`
                headers: {
                    'Authorization': 'Bearer ' + token
                },
                success: function(response) {},
                error: function(xhr, status, error) {
                    console.error("Error:", error);
                }
            });
        });

    }
</script>

</html>