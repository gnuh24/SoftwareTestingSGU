<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="SignedHomePage.css">
    <!-- <link rel="stylesheet" href="Cart.css"> -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <title>Giỏ hàng</title>
</head>

<body>
    <?php require_once "../Header/SignedHeader.php" ?>

    <div>

        <section>
            <div class="center-text" style="margin-top: 20px;">
                <div class="title_section">
                    <div class="bar"></div>
                    <h2 class="center-text-share">Giỏ Hàng Của Bạn</h2>
                </div>
            </div>
        </section>

        <section class="show_cart py-5">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8 mb-4">
                        <div class="wrapListCart">
                            <div class="listCart">
                                <!-- Cart items will be dynamically loaded here via Ajax -->
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="wrapInfoOrder p-4 bg-light border rounded">
                            <p class="titleOrder text-center fw-bold mb-4">Thông tin đơn hàng</p>
                            <div class="wrapPriceTotal d-flex justify-content-between">
                                <p class="titlePriceTotal">Tổng giá trị:</p>
                                <p class="priceTotal fw-bold">0đ</p>
                            </div>
                            <button class="btn btn-danger w-100 my-3 hidden btnCheckout" style="background-color:rgb(146, 26, 26) !important;">Tiến hành đặt hàng</button>
                            <a href="SignedProduct.php">
                                <button class="btn btn-outline-danger w-100" style=" border:1px solid rgb(146, 26, 26) !important;color:rgb(146, 26, 26) ;">Tiếp tục mua hàng</button>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>


        <!-- Footer -->
        <?php require_once "../Footer/Footer.php" ?>

    </div>
    <style>
        .btn-outline-danger:hover {
            background-color: rgb(146, 26, 26) !important;
            color: white !important;
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        var numberOfItemsInCart = $('.cartItem').length; // Đếm số lượng phần tử có class .cartItem

        function toCreateOrder(maTaiKhoan) {
            if (numberOfItemsInCart === 0) {
                Swal.fire({
                    title: 'Lỗi!',
                    text: 'Giỏ hàng của bạn đang trống. Vui lòng thêm sản phẩm vào giỏ hàng trước khi đặt hàng.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            } else {
                Swal.fire({
                    title: 'Xác nhận đặt hàng',
                    text: "Bạn có chắc chắn muốn đặt hàng không?",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Đồng ý',
                    cancelButtonText: 'Hủy bỏ'
                }).then((result) => {
                    if (result.isConfirmed) {
                        thanhToan(maTaiKhoan);
                    }
                });
            }
        }


        function thanhToan(maTaiKhoan) {
            window.location.href = `CreateOrder.php?maTaiKhoan=${maTaiKhoan}`;
        }

        $(document).ready(function() {

            // Kiểm tra số lượng sản phẩm và ẩn/hiển thị nút thanh toán
            if (numberOfItemsInCart === 0) {
                $('.btnCheckout').addClass('hidden');
            } else {
                $('.btnCheckout').removeClass('hidden');
            }


            $('.btnQuantity').on('click', function() {
                var btn = $(this);
                var quantityField = btn.siblings('.txtQuantity');
                var action = btn.hasClass('increase') ? 'increase' : 'decrease';
                var cartItem = btn.closest('.cartItem');
                var productId = cartItem.attr('id');
                var maTaiKhoan = '<?php echo $_GET["maTaiKhoan"]; ?>'; // Lấy mã tài khoản từ PHP
                var donGia = cartItem.find('.priceCart').text().replace(/\D/g, ''); // Lấy đơn giá từ phần tử DOM và loại bỏ ký tự không phải số

                var soLuong = parseInt(quantityField.text()); // Mặc định lấy giá trị số lượng từ quantityField

                var soLuongToiDa = <?php echo $soLuongToiDa; ?>;


                if (action == "increase") {
                    if (soLuong + 1 > soLuongToiDa) {
                        Swal.fire({
                            title: 'Lỗi!',
                            text: 'Bạn không thể mua hàng với số lượng lớn hơn số lượng tồn kho !!',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    } else {
                        soLuong += 1;
                    }
                } else {
                    if (soLuong - 1 <= 0) {
                        Swal.fire({
                            title: 'Lỗi!',
                            text: 'Bạn không thể để số lượng sản phẩm là 0 !!',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    } else {
                        soLuong -= 1;
                    }
                }


                var thanhTien = soLuong * donGia;

                // Set giá trị mới của số lượng
                quantityField.text(soLuong);

                // Tìm phần tử chứa giá trị thành tiền và cập nhật giá trị mới
                var totalPriceField = cartItem.find('.valueTotalPrice');
                totalPriceField.text(formatMoney(thanhTien));

                $.ajax({
                    url: '../../../BackEnd/ManagerBE/GioHangBE.php',
                    method: 'POST',
                    data: {
                        productId: productId,
                        maTaiKhoan: maTaiKhoan,
                        action: action,
                        donGia: donGia,
                        soLuong: soLuong,
                        thanhTien: thanhTien
                    },
                    success: function(response) {
                        console.log(response);

                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                    }
                });

                // Gọi hàm cập nhật tổng tiền sau mỗi lần cập nhật sản phẩm
                updateTotalPrice();
            });

            // Code hiện tại của bạn để xóa sản phẩm khỏi giỏ hàng
            $('.btnRemove').on('click', function() {
                var productId = $(this).closest('.cartItem').attr('id');
                var maTaiKhoan = '<?php echo $_GET["maTaiKhoan"]; ?>'; // Thêm mã tài khoản vào
                $.ajax({
                    url: '../../../BackEnd/ManagerBE/GioHangBE.php',
                    method: 'POST',
                    dataType: "json",

                    data: {
                        productId: productId,
                        maTaiKhoan: maTaiKhoan, // Thêm mã tài khoản vào dữ liệu gửi đi
                        action: 'deleteCart'
                    },
                    success: function(response) {

                        try {
                            // Loại bỏ JSON.parse() ở đây
                            $('#' + productId).remove();
                            $('.priceTotal').text(response.priceTotal);
                            $('.totalProducts').text(response.quantityCart);
                        } catch (error) {
                            console.error("Error parsing JSON: ", error);
                        }

                        // Gọi hàm cập nhật tổng tiền sau mỗi lần xóa sản phẩm
                        updateTotalPrice();
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                    }
                });
            });

            // Hàm cập nhật tổng tiền dựa trên các giá trị thành tiền của từng sản phẩm trong giỏ hàng
            function updateTotalPrice() {
                var totalPrice = 0;
                $('.valueTotalPrice').each(function() {
                    var price = parseFloat($(this).text().replace(/\D/g, ''));
                    totalPrice += price;
                });
                $('.priceTotal').text(formatMoney(totalPrice));
            }

            // Hàm định dạng số tiền thành chuỗi có dấu chấm ngăn cách hàng nghìn
            function formatMoney(amount) {
                return amount.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") + "đ";
            }



        });
    </script>
</body>

</html>