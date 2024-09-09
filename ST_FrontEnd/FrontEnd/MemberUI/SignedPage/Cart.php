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
            var maTaiKhoan = '<?php echo $_GET["maTaiKhoan"]; ?>'; // Lấy mã tài khoản từ PHP
            var token = localStorage.getItem("token"); // Lấy token từ localStorage

            // Hàm gọi API để lấy danh sách sản phẩm trong giỏ hàng
            function fetchCartItems() {
                $.ajax({
                    url: `http://localhost:8080/CartItem/${maTaiKhoan}`,
                    method: 'GET',
                    headers: {
                        'Authorization': `Bearer ${token}` // Thêm JWT token vào header
                    },
                    success: function(response) {
                        console.log(1);

                        var cartHTML = ''; // Dùng để chứa HTML của các sản phẩm
                        var totalAmount = 0; // Tổng tiền của giỏ hàng

                        response.forEach(function(item) {
                            cartHTML += `
                                <div class="cartItem" id="${item.productId}">
                                    <p>Sản phẩm ID: ${item.productId}</p>
                                    <img src="http://res.cloudinary.com/djhoea2bo/image/upload/v1711511636/${item.image}" alt="Image of product" style="width: 100px; height: auto;" />
                                    <p>Đơn giá: <span class="priceCart">${formatMoney(item.unitPrice)}</span></p>
                                    <p>Số lượng: <span class="txtQuantity">${item.quantity}</span></p>
                                    <p>Thành tiền: <span class="valueTotalPrice">${formatMoney(item.total)}</span></p>
                                    <button class="btnRemove">Xóa</button>
                                </div>`;

                            // Cộng dồn vào tổng tiền
                            totalAmount += item.total;
                        });

                        // Hiển thị danh sách sản phẩm lên trang
                        $('.listCart').html(cartHTML);

                        // Cập nhật tổng tiền
                        $('.priceTotal').text(formatMoney(totalAmount));

                        // Ẩn/hiển thị nút thanh toán
                        if (response.length === 0) {
                            $('.btnCheckout').addClass('hidden');
                        } else {
                            $('.btnCheckout').removeClass('hidden');
                        }

                        // Gọi lại các sự kiện như click "xóa sản phẩm" sau khi load xong giỏ hàng
                        bindCartItemEvents();
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                        // Xử lý lỗi nếu có
                    }
                });
            }

            // Gọi hàm fetchCartItems() khi trang tải xong
            fetchCartItems();

            // Hàm định dạng số tiền thành chuỗi có dấu chấm ngăn cách hàng nghìn
            function formatMoney(amount) {
                return amount.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") + "đ";
            }

            // Gắn sự kiện xóa sản phẩm sau khi sản phẩm được tải
            function bindCartItemEvents(accountId, productId) {
                $('.btnRemove').on('click', function() {
                    var productId = $(this).closest('.cartItem').attr('id');
                    $.ajax({
                        url: `http://localhost:8080/CartItem`,
                        method: 'DELETE',
                        data: {
                            accountId: accountId,
                            productId: productId
                        },
                        success: function(response) {
                            $('#' + productId).remove(); // Xóa sản phẩm khỏi giao diện
                            $('.priceTotal').text(formatMoney(response.totalAmount)); // Cập nhật tổng tiền
                        },
                        error: function(xhr, status, error) {
                            console.error(error);
                        }
                    });
                });
            }
        });
    </script>
</body>

</html>