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


    <?php require_once "../Footer/Footer.php" ?>

    <script>
        function loadOrders() {
            var customerId = localStorage.getItem("id");
            var token = localStorage.getItem("token");

            $.ajax({
                url: 'http://localhost:8080/Order/MyOrder', // Đường dẫn API lấy đơn hàng
                type: 'GET',
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
                var token = localStorage.getItem("token");
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

                        if (hoaDon.TrangThai !== 'GiaoThanhCong' && hoaDon.TrangThai !== 'Huy') {
                            const listSanPham = JSON.stringify(listCTDH);
                            orderHtml += `<button class='cancel_order_button' onclick='cancelOrder(${hoaDon.id}, "${hoaDon.status}", ${listSanPham})'>Hủy đơn hàng</button>`;
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
        function cancelOrder(maDonHang, trangThai, listSanPham) {
            if (trangThai === 'Huy') {
                alert('Đơn hàng đã bị hủy trước đó.');
                return;
            }

            $.ajax({
                url: 'http://localhost:8080/api/cancelOrder', // API hủy đơn hàng
                type: 'POST',
                data: {
                    MaDonHang: maDonHang,
                    listSanPham: listSanPham
                },
                success: function(response) {
                    alert('Đơn hàng đã được hủy thành công.');
                    loadOrders(); // Tải lại danh sách đơn hàng sau khi hủy
                },
                error: function(xhr, status, error) {
                    console.error('Đã xảy ra lỗi khi hủy đơn hàng.');
                }
            });
        }

        // Gọi hàm loadOrders khi trang được load
        $(document).ready(function() {
            loadOrders();
        });
    </script>
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

        function toOrderDetail(maDonHang) {
            window.location.href = `MyOrderInDetail.php?maDonHang=${maDonHang}`;
        }
    </script>
</body>

</html>