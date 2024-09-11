<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="SignedHomePage.css">
    <link rel="stylesheet" href="Cart.css">
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
                            <button class="btn btn-danger w-100 my-3 hidden btnCheckout" style="background-color:rgb(146, 26, 26) !important;" onclick="toCreateOrder()">Tiến hành đặt hàng</button>
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
        var maTaiKhoan = JSON.parse(localStorage.getItem("id"));

        function toCreateOrder() {
            var numberOfItemsInCart = $('.cartItem').length;
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

        function bindCartItemEvents() {
            $('.increase').on('click', function() {
                var productId = $(this).closest('.cartItem').attr('id');
                var quantityElem = $(`#quantity_${productId}`);
                var currentQuantity = parseInt(quantityElem.text());
                updateQuantity(productId, currentQuantity + 1);
            });

            $('.decrease').on('click', function() {
                var productId = $(this).closest('.cartItem').attr('id');
                var quantityElem = $(`#quantity_${productId}`);
                var currentQuantity = parseInt(quantityElem.text());
                if (currentQuantity > 1) {
                    updateQuantity(productId, currentQuantity - 1);
                }
            });

            $('.btnRemove').on('click', function() {
                var productId = $(this).closest('.cartItem').attr('id');
                $.ajax({
                    url: `http://localhost:8080/CartItem`,
                    method: 'DELETE',
                    data: {
                        accountId: maTaiKhoan,
                        productId: productId
                    },
                    success: function(response) {
                        $('#' + productId).remove();
                        $('.priceTotal').text(formatMoney(response.totalAmount));
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                    }
                });
            });
        }

        $(document).ready(function() {
            var maTaiKhoan = '<?php echo $_GET["maTaiKhoan"]; ?>';
            var token = localStorage.getItem("token");

            function fetchCartItems() {
                $.ajax({
                    url: `http://localhost:8080/CartItem/${maTaiKhoan}`,
                    method: 'GET',
                    headers: {
                        'Authorization': `Bearer ${token}`
                    },
                    success: function(response) {
                        var cartHTML = '';
                        var totalAmount = 0;

                        response.forEach(function(item) {
                            cartHTML += `
                            <div class='cartItem' id='${item.productId}'>
                                <a href='#' class='img'><img class='img' src='http://res.cloudinary.com/djhoea2bo/image/upload/v1711511636/${item.image}' /></a>
                                <div class='inforCart'>
                                    <div class='quantity'>
                                        <label for='quantity_${item.productId}' class='labelQuantity'>Số lượng:</label>
<<<<<<< HEAD
                                        <div style="display:flex;">
                                            <button class='btnQuantity decrease' data-id='${item.productId}'>-</button>
                                            <div class='txtQuantity' id='quantity_${item.productId}'>${item.quantity}</div>
                                            <button class='btnQuantity increase' data-id='${item.productId}'>+</button>
                                        </div>
=======
                                        <div style="display:flex;">            
                                        <button class='btnQuantity decrease' style="visibility: hidden">-</button>
                                        <div class='txtQuantity' id='quantity_${item.productId}'>${item.quantity}</div>
                                        <button class='btnQuantity increase' style="visibility: hidden">+</button></div>
>>>>>>> 99952cd18f974dfdeb66d51c66dceffd9fffa23a
                                    </div>
                                    <div class='unitPrice'>
                                        <label for='unitPrice_${item.productId}' class='labelUnitPrice'>Đơn giá:</label>
                                        <div class='txtUnitPrice' id='unitPrice_${item.productId}'>${item.unitPrice}</div>
                                    </div>
                                </div>
                                <div class='wrapTotalPriceOfCart'>
                                    <div class='totalPriceOfCart'>
                                        <label for='totalPrice_${item.productId}' class='labelTotalPrice'>Thành tiền:</label>
                                        <p class='valueTotalPrice' id='totalPrice_${item.productId}'>${formatMoney(item.total)}</p>
                                    </div>
                                    <button class='btnRemove'>
                                        <i class='fa-solid fa-xmark'></i>
                                    </button>
                                </div>
                            </div>`;
                            totalAmount += item.total;
                        });

                        $('.listCart').html(cartHTML);
                        $('.priceTotal').text(formatMoney(totalAmount));

                        if (response.length === 0) {
                            $('.btnCheckout').addClass('hidden');
                        } else {
                            $('.btnCheckout').removeClass('hidden');
                        }

                        bindCartItemEvents();
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                    }
                });
            }

            fetchCartItems();

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
                            accountId: localStorage.getItem('id') ,
                            productId: productId
                        },
                        headers: {
                            "Authorization": "Bearer " + localStorage.getItem('token') // Gửi token trong header
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

<<<<<<< HEAD
        function updateQuantity(productId, quantity) {
            var token = localStorage.getItem("token");
=======
        function updateQuantity(productId) {
            var token = localStorage.getItem("token"); // Lấy token từ localStorage
            // Lấy số lượng của sản phẩm dựa trên id
            var quantityElem = document.getElementById(`quantity_${productId}`);
            var quantity = quantityElem ? quantityElem.innerText : '';

            // Lấy đơn giá của sản phẩm dựa trên id
>>>>>>> 99952cd18f974dfdeb66d51c66dceffd9fffa23a
            var unitPriceElem = document.getElementById(`unitPrice_${productId}`);
            var unitPrice = parseInt(unitPriceElem ? unitPriceElem.innerText.replace(/[^0-9]/g, '') : 0);

            var totalPrice = unitPrice * quantity;

            var form = new FormData();
            form.append("accountId", maTaiKhoan);
            form.append("productId", productId);
            form.append("unitPrice", unitPrice);
            form.append('quantity', quantity);
            form.append('total', totalPrice);
            $.ajax({
                url: `http://localhost:8080/CartItem`,
                type: 'PATCH',
                dataType: 'json',
                headers: {
                    'Authorization': 'Bearer ' + localStorage.getItem('token')
                },
                data: form,
                processData: false,
                contentType: false,
                success: function(response) {
                    fetchCartItems();
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        }
    </script>

</body>

</html>