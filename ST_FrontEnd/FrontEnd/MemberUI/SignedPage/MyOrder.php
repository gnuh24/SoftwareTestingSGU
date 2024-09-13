<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
    <link rel="stylesheet" href="../GuestPage/HomePage.css" />
    <link rel="stylesheet" href="../GuestPage/login.css" />
    <link rel="stylesheet" href="MyOrder.css" />

    <!-- <link rel="stylesheet" href="MyOrder.css" /> -->
    <title>Đơn hàng của tôi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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
        <p id="emptyCartMessage" class="empty_cart" style="text-align: center;">Bạn chưa có đơn hàng nào!</p>
        <div id="orderHistory"></div>

    </div>
</body>


<?php require_once "../Footer/Footer.php" ?>
<script>
    function loadOrders() {
        var customerId = sessionStorage.getItem("id");
        var token = sessionStorage.getItem("token");

        $.ajax({
            url: 'http://localhost:8080/Order/MyOrder', // Đường dẫn API lấy đơn hàng
            type: 'GET',
            body: {
                sort: "orderTime,desc"
            },
            headers: {
                'Authorization': 'Bearer ' + token
            },
            success: function(response) {
                // Kiểm tra kiểu dữ liệu của response
                if (Array.isArray(response)) {
                    const orders = response;
                    const numberOfProducts = orders.length;

                    if (numberOfProducts <= 0) {
                        $('#emptyCartMessage').show();
                    } else {
                        $('#emptyCartMessage').hide();
                        displayOrders(orders);
                    }
                } else {
                    console.error('Dữ liệu trả về không phải là mảng.');
                }
            },
            error: function(xhr, status, error) {
                console.error('Đã xảy ra lỗi khi tải đơn hàng.');
            }
        });
    }

    function displayOrders(orders) {
        const orderHistory = document.getElementById('orderHistory');
        orderHistory.innerHTML = ''; // Xóa dữ liệu cũ

        orders.forEach(hoaDon => {
            var orderHtml = `
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
                            <tbody>`;
            var token = sessionStorage.getItem("token");
            // AJAX call to get chiTietDonHang
            $.ajax({
                url: `http://localhost:8080/Order/MyOrder/${hoaDon.id}`, // Đường dẫn API lấy chi tiết đơn hàng
                type: 'GET',
                headers: {
                    'Authorization': 'Bearer ' + token
                },
                async: false, // Đảm bảo AJAX này hoàn tất trước khi tiếp tục
                success: function(chiTietDonHangResponse) {

                    const listCTDH = chiTietDonHangResponse.orderDetails;

                    listCTDH.forEach(chiTiet => {
                        orderHtml += `
                            <tr class='orderManagement_order_detail'>
                                <td class='anhMinhHoa'><img style='width: auto; height: 100px;' src='https://res.cloudinary.com/djhoea2bo/image/upload/v1711511636/${chiTiet.image}'></td>
                                <td class='tenSanPham'>${chiTiet.productName}</td>
                                <td class='donGia'>${formatMoney(chiTiet.unitPrice)}</td>
                                <td class='soLuong'>${chiTiet.quantity}</td>
                                <td class='thanhTien'>${formatMoney(chiTiet.total)}</td>
                            </tr>`;
                    });
                    orderHtml += `
                            </tbody>
                        </table>
                        <div class='orderManagement_order_thanhTien'>
                            <p style="width: 50%;">Trạng thái: ${translateStatus(hoaDon.status)}</p>
                            <p>Tổng giá trị: ${formatMoney(hoaDon.totalPrice)}</p>
                        <button class='order_detail_button' onclick="toOrderDetail('${hoaDon.id}')"> Chi tiết</button>`;

                    if (hoaDon.status !== 'DangGiao' && hoaDon.status !== 'GiaoThanhCong' && hoaDon.status !== 'Huy') {
                        const listSanPham = JSON.stringify(listCTDH);
                        orderHtml += `<button class='cancel_order_button' onclick="cancelOrder('${hoaDon.id}')">Hủy đơn hàng</button>`;
                    }

                    orderHtml += `</div></div>`;

                    orderHistory.innerHTML += orderHtml;
                },
                error: function(xhr, status, error) {
                    console.error('Đã xảy ra lỗi khi tải chi tiết đơn hàng.');
                }
            });
        });
    }

    // Format tiền tệ (Giả định)
    function formatMoney(value) {
        return new Intl.NumberFormat('vi-VN', {
            style: 'currency',
            currency: 'VND'
        }).format(value);
    }

    // Chuyển đổi trạng thái
    function translateStatus(status) {
        switch (status) {
            case 'ChoDuyet':
                return 'Chờ duyệt';
            case 'DaDuyet':
                return 'Đã duyệt';
            case 'DangGiao':
                return 'Đang giao hàng';
            case 'GiaoThanhCong':
                return 'Giao thành công';
            case 'Huy':
                return 'Đã hủy';
            default:
                return status;
        }
    }

    // Hàm xử lý hủy đơn hàng
    function cancelOrder(maDonHang) {
        console.log(maDonHang);
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
                $.ajax({
                    url: 'http://localhost:8080/OrderStatus/User', // API hủy đơn hàng
                    type: 'POST',
                    data: {
                        orderId: maDonHang,
                        idStatus: "Huy"
                    },
                    headers: {
                        'Authorization': 'Bearer ' + sessionStorage.getItem("token")

                    },
                    success: function(response) {

                        // Hiển thị thông báo và reload trang
                        Swal.fire(
                            'Hủy đơn hàng thành công!',
                            '',
                            'success'
                        ).then((result) => {
                            console.log("Result: " + response);
                            if (result.isConfirmed) {
                                location.reload(); // Hoặc window.location.reload()
                            }
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error('Đã xảy ra lỗi khi hủy đơn hàng.');
                    }
                });


            }
        });

    }

    function toOrderDetail(maDonHang) {
        window.location.href = `MyOrderInDetail.php?maDonHang=${maDonHang}`;
    }

    // Gọi hàm loadOrders khi trang được load
    $(document).ready(function() {
        loadOrders();
    });
</script>


</html>