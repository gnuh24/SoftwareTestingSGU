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

                                            </ul>
                                            <div class="transaction_info__wrapper">
                                                <div class="receive_info__wrapper">
                                                    <p class="title">Thông tin người nhận:</p>
                                                    <div class="divider"></div>
                                                    <div class="receive_info">
                                                        <p class='name' id='hoten'></p>
                                                        <p id='diachigiaohang'></p>
                                                        <p id='sodienthoai'></p>
                                                    </div>
                                                </div>
                                                <div class="payment_method__wrapper">
                                                    <p class="title">Phương thức thanh toán:</p>
                                                    <div class="divider"></div>
                                                    <p id="tenphuongthuc">
                                                        <!-- <span> CHỈ ÁP DỤNG TIỀN MẶT ĐỐI VỚI NỘI THÀNH TPHCM</span> -->
                                                    </p>
                                                </div>
                                                <div class="payment_method__wrapper">
                                                    <p class="title">Phương thức vận chuyển:</p>
                                                    <div class="divider"></div>
                                                    <p id="tendichvu">
                                                        <!-- <span> CHỈ ÁP DỤNG TIỀN MẶT ĐỐI VỚI NỘI THÀNH TPHCM</span> -->
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="transaction_items__wrapper">
                                                <p class="transaction_name">Trạng thái:
                                                    <span class="" id="trangthai">

                                                    </span>
                                                </p>
                                                <div class="divider"></div>
                                                <div class="transaction_list" id="transaction_list">
                                                    <!-- <?php

                                                            foreach ($dataChitiet as $sanPham) {
                                                                echo "
                                                                    <div class='transaction_item'><img  src='' alt=''>
                                                                        <div class='item_info__wrapper'>
                                                                            <div class='item_info'>
                                                                                <p class='name'>TenSanPham</p>
                                                                            </div>
                                                                            <div class='item_info'>
                                                                                <p class='quantity'>XSoLuong</p>
                                                                                <p class='price'>9999999999đ</p>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class='divider'></div>";
                                                            }

                                                            ?> -->

                                                </div>
                                            </div>
                                            <div class="order_total__wrapper">
                                                <div>
                                                    <p>Tổng tạm tính:</p>
                                                    <p id="tongTamTinh"></p>
                                                </div>
                                                <div>
                                                    <p>Giảm giá:</p>
                                                    <p id="giamGia">0 đ</p>
                                                </div>
                                                <div>
                                                    <p>Phí vận chuyển:</p>
                                                    <p id="phiVanChuyen">0 đ</p>
                                                </div>
                                                <div class="total">
                                                    <p>Thành tiền:</p>
                                                    <p id="totalPrice"></p>
                                                </div>
                                            </div>
                                        </div>


                                    </div>

                                </div>
                                <!--  -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

<script>
    var MaDonHang = <?php echo isset($_GET['MaDonHang']) ? json_encode($_GET['MaDonHang']) : 'null'; ?>;

    // MaDonHang=getMaDonHang();
    // function getMaDonHang(){
    //     $.ajax({
    //         url: './QLDonHang.php',
    //         type: 'GET',
    //         dataType: "json",
    //         data: {
    //         },
    //         success: function(response) {
    //             console.log(response.MaDonHang);
    //         },

    //         error: function(xhr, status, error) {
    //             console.error('Lỗi khi gọi API: ', error);
    //         }
    //     });

    // }

    document.getElementById("orderID").innerText = MaDonHang;

    getChiTietDonHangByMaDonHang(MaDonHang);

    getDonHangByMaDonHang(MaDonHang);

    getTrangThaiDonHangByMaDonHang(MaDonHang);

    function number_format_vnd(number) {
        return Number(number).toLocaleString('vi-VN', {
            style: 'currency',
            currency: 'VND'
        });
    }

    function getChiTietDonHangByMaDonHang(MaDonHang) {
        $.ajax({
            url: '../../../BackEnd/ManagerBE/ChiTietDonHangBE.php',
            type: 'GET',
            dataType: "json",
            data: {
                MaDonHang: MaDonHang,
            },
            success: function(response) {
                console.log(response)
                var data = response.data;
                var transaction_list = document.getElementById("transaction_list");
                transaction_list.innerHTML = "";
                var items = "";

                data.forEach(element => {
                    items += `<div class='transaction_item'><img  src='${element.AnhMinhHoa}' alt=''>
                        <div class='item_info__wrapper'>
                                <div class='item_info'>
                                    <p class='name'>${element.TenSanPham}</p>
                                </div>
                                <div class='item_info'>
                                    <p class='quantity'>${element.SoLuong}</p>
                                    <p class='price'>${number_format_vnd(element.DonGia)}</p>
                                </div>
                            </div>
                        </div>
                    <div class='divider'></div>`;
                });
                transaction_list.innerHTML = items;
            },

            error: function(xhr, status, error) {
                console.error('Lỗi khi gọi API: ', error);
            }
        });
    }

    function getTenTrangThai(order_statuses) {
        if (order_statuses == 'ChoDuyet') {
            order_statuses = 'Chờ Duyệt';
        }
        if (order_statuses == 'Huy') {
            order_statuses = 'Đã Hủy';
        }
        if (order_statuses == 'DaDuyet') {
            order_statuses = 'Đã duyệt';
        }
        if (order_statuses == 'DangGiao') {
            order_statuses = 'Đang Giao';
        }
        if (order_statuses == 'GiaoThanhCong') {
            order_statuses = 'Giao Thành Công';
        }
        return order_statuses;
    }

    function getDonHangByMaDonHang(MaDonHang) {
        $.ajax({
            url: '../../../BackEnd/ManagerBE/DonHangBE.php',
            type: 'GET',
            dataType: "json",
            data: {
                MaDonHang: MaDonHang,
            },
            success: function(response) {

                console.log(response)
                var data = response.data;

                document.getElementById("hoten").innerHTML = `<span>Họ tên:</span>${data.HoTen}`;
                document.getElementById("diachigiaohang").innerHTML = `<span>Địa chỉ: </span>${data.SoDienThoai}`;
                document.getElementById("sodienthoai").innerHTML = `<span>Số điện thoại: </span>${data.DiaChiGiaoHang}`;
                document.getElementById("tenphuongthuc").innerHTML = `${data.TenPhuongThuc}<br>`;
                document.getElementById("tendichvu").innerHTML = `${data.TenDichVu}<br>`;
                document.getElementById("trangthai").innerText = getTenTrangThai(data.TrangThai);
                document.getElementById("tongTamTinh").innerText = number_format_vnd(data.TongGiaTri);
                document.getElementById("giamGia");
                document.getElementById("phiVanChuyen");
                document.getElementById("totalPrice").innerText = number_format_vnd(data.TongGiaTri);
            },

            error: function(xhr, status, error) {
                console.error('Lỗi khi gọi API: ', error);
            }
        });
    }

    function getTrangThaiDonHangByMaDonHang(MaDonHang) {
        $.ajax({
            url: '../../../BackEnd/ManagerBE/TrangThaiDonHangBE.php',
            type: 'GET',
            dataType: "json",
            data: {
                MaDonHang: MaDonHang,
            },
            success: function(response) {
                var trangThaiDonHang = response.data;
                console.log("trang thai");
                console.log(trangThaiDonHang);
                var choduyet=null;
                var daduyet=null;
                var danggiao=null;
                var giaothanhcong=null;
                var huy=null;
                trangThaiDonHang.forEach(data => {
                    if (data.TrangThai == 'Huy') {
                        huy=data;
                    }
                    if (data.TrangThai == 'ChoDuyet') {
                        choduyet=data;
                    }
                    if (data.TrangThai == 'DaDuyet') {
                        daduyet=data;
                    }
                    if (data.TrangThai == 'DangGiao') {
                        danggiao=data;
                    }
                    if (data.TrangThai == 'GiaoThanhCong') {
                        giaothanhcong=data;
                    }
                });
                var order_status = document.getElementById("order_status");
                if (huy != null) {
                    order_status.innerHTML = `  <div class="order_status completed">
                                                            <li>Đã đặt hàng<br>${formatDate(choduyet.NgayCapNhat)}</li>
                                                        </div>
                                                        <div class="order_status completed">
                                                            <li>Đã hủy<br>${formatDate(huy.NgayCapNhat)}</li>
                                                        </div>`;
                } else {
                    var order_status_content=`<div class="order_status completed">
                                                    <li>Đã đặt hàng<br>${formatDate(choduyet.NgayCapNhat)}</li>
                                                </div>`;
                    if(daduyet!=null){
                        order_status_content+=`<div class="order_status completed">
                                                    <li>Đã xác nhận<br>${formatDate(daduyet.NgayCapNhat)}</li>    
                                                </div>`;
                    }else{
                        order_status_content+=`<div class="order_status">
                                                    <li>Đã xác nhận<br></li>    
                                                </div>`;
                    }

                    if(danggiao!=null){
                        order_status_content+=`<div class="order_status completed">
                                                    <li>Đang giao<br>${formatDate(danggiao.NgayCapNhat)}</li>    
                                                </div>`;
                    }else{
                        order_status_content+=`<div class="order_status">
                                                    <li>Đang giao<br></li>    
                                                </div>`;
                    }

                    if(giaothanhcong!=null){
                        order_status_content+=`<div class="order_status completed">
                                                    <li>Giao thành công<br>${formatDate(giaothanhcong.NgayCapNhat)}</li>    
                                                </div>`;
                    }else{
                        order_status_content+=`<div class="order_status">
                                                    <li>Giao thành công<br></li>    
                                                </div>`;
                    }
                    order_status.innerHTML=order_status_content;
                }
            },

            error: function(xhr, status, error) {
                console.error('Lỗi khi gọi API: ', error);
            }
        });
    }
    
    function formatDate(originalDate) {
    var dateObj = new Date(originalDate);

    var month = dateObj.getMonth() + 1;
    var day = dateObj.getDate();
    var year = dateObj.getFullYear();
    var hours = dateObj.getHours();
    var minutes = dateObj.getMinutes();
    var seconds = dateObj.getSeconds();
    const pad = (num) => (num < 10 ? '0' : '') + num;

    const formattedDate = `${pad(hours)}:${pad(minutes)}:${pad(seconds)} ${pad(day)}/${pad(month)}/${year}`;
    return formattedDate;
  }
</script>

</html>