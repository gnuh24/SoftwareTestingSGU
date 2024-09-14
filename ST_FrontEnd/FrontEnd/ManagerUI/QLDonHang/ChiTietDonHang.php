<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../AdminDemo.css" />
    <link rel="stylesheet" href="QLDonHang.css" />
    <link rel="stylesheet" href="detail_donhang.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <title>Quản lý đơn hàng</title>
</head>

<body>
    <div>
        <div class="App">
            <div class="StaffLayout_wrapper__CegPk">
                <?php require_once "../ManagerHeader.php" ?>

                <div>
                    <div>
                        <div class="Manager_wrapper__vOYy">
                            <?php require_once "../ManagerMenu.php" ?>

                            <div style="padding-left: 16%; width: 100%; padding-right: 2rem">
                                <div class="wrapper">
                                    <div class="orderManagement_order_history">
                                        <div class="detail__wrapper">
                                            <p class="title">Chi tiết đơn hàng: <span id="orderID"></span></p>
                                            <ul class="order_status__wrapper" id="order_status">
                                                <!-- Order status will be populated here -->
                                            </ul>
                                            <div class="transaction_info__wrapper">
                                                <div class="receive_info__wrapper">
                                                    <p class="title">Thông tin người nhận:</p>
                                                    <div class="divider"></div>
                                                    <div class="receive_info">
                                                        <p class='name' id='hoten'></p>
                                                        <p id='diachigiaohang'></p>
                                                        <p id='sodienthoai'></p>
                                                        <p id='ngaysinh'></p> <!-- Added birthday -->
                                                        <p id='gioitinh'></p> <!-- Added gender -->
                                                        <p id="orderTime"></p> <!-- Added order time -->

                                                    </div>
                                                </div>
                                                <div class="payment_method__wrapper">
                                                    <p class="title">Phương thức thanh toán:</p>
                                                    <div class="divider"></div>
                                                    <p id="tenphuongthuc">Chưa có thông tin<br></p>
                                                </div>
                                                <div class="note_wrapper">
                                                    <p class="title">Ghi chú:</p>
                                                    <div class="divider"></div>
                                                    <p id="note"></p> <!-- Added note -->
                                                </div>
                                            </div>
                                            <div class="transaction_items__wrapper">
                                                <p class="transaction_name">Trạng thái:
                                                    <span class="" id="trangthai"></span>
                                                </p>
                                                <div class="divider"></div>
                                                <div class="transaction_list" id="transaction_list">
                                                    <!-- Order details will be populated here -->
                                                </div>
                                            </div>
                                            <div class="order_total__wrapper">
                                                <div>
                                                    <p>Thành tiền:</p>
                                                    <p id="totalPrice"></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

<script>
    var orderId = new URLSearchParams(window.location.search).get('id');

    document.getElementById("orderID").innerText = orderId;

    getOrderDetailsAndStatus(orderId);

    function number_format_vnd(number) {
        return Number(number).toLocaleString('vi-VN', {
            style: 'currency',
            currency: 'VND'
        });
    }

    function getOrderDetailsAndStatus(orderId) {
        $.ajax({
            url: `http://localhost:8080/Order/Admin/${orderId}`,
            type: 'GET',
            dataType: "json",
            headers: {
                'Authorization': 'Bearer ' + sessionStorage.getItem('token') // Thay 'yourTokenKey' bằng khóa lưu token của bạn
            },
            success: function(response) {
                var data = response;

                // Handle order details
                var transaction_list = document.getElementById("transaction_list");
                transaction_list.innerHTML = "";
                var items = "";

                data.orderDetails.forEach(element => {
                    items += `<div class='transaction_item'>
                        <img src='http://res.cloudinary.com/djhoea2bo/image/upload/v1711511636/${element.image}' alt=''>
                        <div class='item_info__wrapper'>
                            <div class='item_info'>
                                <p class='name'>${element.productName}</p>
                            </div>
                            <div class='item_info'>
                                <p class='quantity'>${element.quantity}</p>
                                <p class='price'>${number_format_vnd(element.unitPrice)}</p>
                            </div>
                        </div>
                    </div>
                    <div class='divider'></div>`;
                });
                transaction_list.innerHTML = items;

                document.getElementById("hoten").innerHTML = `<span>Họ tên:</span> ${data.userInformation.fullname}`;
                document.getElementById("diachigiaohang").innerHTML = `<span>Địa chỉ: </span>${data.userInformation.address}`;
                document.getElementById("sodienthoai").innerHTML = `<span>Số điện thoại: </span>${data.userInformation.phoneNumber}`;
                document.getElementById("note").innerText = data.note; // Added note
                document.getElementById("totalPrice").innerText = number_format_vnd(data.totalPrice);
                document.getElementById("orderTime").innerHTML = `<span>Thời gian đặt: </span>${data.orderTime}`; // Added order time

                // Handle order status
                var order_status = document.getElementById("order_status");
                var order_status_content = '';

                data.orderStatuses.forEach(status => {
                    if (status.status === 'Huy') {
                        order_status_content += `<div class="order_status cancelled">
                            <li>${getTenTrangThai(status.status)}<br>${status.updateTime}</li>
                        </div>`;
                    } else {
                        order_status_content += `<div class="order_status completed">
                            <li>${getTenTrangThai(status.status)}<br>${status.updateTime}</li>
                        </div>`;
                    }
                });

                order_status.innerHTML = order_status_content;
            },
            error: function(xhr, status, error) {
                console.error('Lỗi khi gọi API: ', error);
            }
        });
    }

    function getTenTrangThai(status) {
        switch (status) {
            case 'ChoDuyet':
                return 'Chờ Duyệt';
            case 'DaDuyet':
                return 'Đã duyệt';
            case 'DangGiao':
                return 'Đang Giao';
            case 'GiaoThanhCong':
                return 'Giao Thành Công';
            case 'Huy':
                return 'Đã hủy';
            default:
                return 'Chưa rõ';
        }
    }
</script>

</html>