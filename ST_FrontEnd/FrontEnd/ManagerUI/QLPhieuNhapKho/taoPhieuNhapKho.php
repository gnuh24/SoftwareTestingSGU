<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../adminDemo.css" />
    <link rel="stylesheet" href="taoPhieuNhapKho.css" />
    <title>Chi tiết phiếu nhập kho</title>
</head>

<body>
    <div id="root">
        <div class="App">
            <div class="StaffLayout_wrapper__CegPk">
                <div class="StaffHeader_wrapper__IQw-U">
                    <p class="StaffHeader_title__QxjW4">Dekanta</p>
                    <button class="StaffHeader_signOut__i2pcu">
                        <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="arrow-right-from-bracket" class="svg-inline--fa fa-arrow-right-from-bracket" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" style="width: 2rem; height: 2rem; color: white">
                            <path fill="currentColor" d="M502.6 278.6c12.5-12.5 12.5-32.8 0-45.3l-128-128c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L402.7 224 192 224c-17.7 0-32 14.3-32 32s14.3 32 32 32l210.7 0-73.4 73.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0l128-128zM160 96c17.7 0 32-14.3 32-32s-14.3-32-32-32L96 32C43 32 0 75 0 128L0 384c0 53 43 96 96 96l64 0c17.7 0 32-14.3 32-32s-14.3-32-32-32l-64 0c-17.7 0-32-14.3-32-32l0-256c0-17.7 14.3-32 32-32l64 0z"></path>
                        </svg>
                    </button>
                </div>
                <div class="Manager_wrapper__vOYy">
                    <div class="Sidebar_sideBar__CC4MK">
                        <a class="MenuItemSidebar_menuItem__56b1m" href="../QLLoaiSanPham/QLLoaiSanPham.php">
                            <span class="MenuItemSidebar_title__LLBtx">Loại Sản Phẩm</span>
                        </a>
                        <a class="MenuItemSidebar_menuItem__56b1m" href="../QLSanPham/QLSanPham.php">
                            <span class="MenuItemSidebar_title__LLBtx">Sản Phẩm</span>
                        </a>
                        <a class="MenuItemSidebar_menuItem__56b1m" href="../QLNhaCungCap/QLNhaCungCap.php">
                            <span class="MenuItemSidebar_title__LLBtx">Nhà Cung Cấp</span>
                        </a>
                        <a class="MenuItemSidebar_menuItem__56b1m" href="../QLPhieuNhapKho/QLPhieuNhapKho.php">
                            <span class="MenuItemSidebar_title__LLBtx">Phiếu Nhập Kho</span>
                        </a>
                        <a class="MenuItemSidebar_menuItem__56b1m" href="../QLDonHang/QLDonHang.php">
                            <span class="MenuItemSidebar_title__LLBtx">Đơn Hàng</span>
                        </a>
                        <a class="MenuItemSidebar_menuItem__56b1m" href="../ThongKe/ThongKeDoanhThuChiTieu.php">
                            <span class="MenuItemSidebar_title__LLBtx">Thống Kê Tài Chính</span>
                        </a>
                        </a>
                        <a class="MenuItemSidebar_menuItem__56b1m" href="../ThongKe/ThongKeDonHang.php">
                            <span class="MenuItemSidebar_title__LLBtx">Thống Kê Đơn Hàng</span>
                        </a>
                    </div>

                    <div style="padding-left: 16%; width: 100%; padding-right: 2rem">
                        <div class="wrapper">
                            <div style="display: flex; padding-top: 1rem; padding-bottom: 1rem;">
                                <h2>Phiếu Nhập Kho</h2>
                                <div style="margin-left: auto;">
                                    <button style="font-family: Arial; font-size: 1.5rem; font-weight: 700; color: white; color: rgb(65, 64, 64); border: 1px solid rgb(65, 64, 64); background-color: white; padding: 1rem; border-radius: 0.6rem; cursor: pointer;">
                                        <a href="QLPhieuNhapKho.php">
                                            <?php
                                            if (!isset($_GET['MaPhieu'])) echo 'Hủy';
                                            else echo 'Quay lại';
                                            ?>
                                        </a>
                                    </button>
                                    <?php
                                    if (!isset($_GET['MaPhieu']))
                                        echo '
                                        <button style="margin-left: 1rem; font-family: Arial; font-size: 1.5rem; font-weight: 700; color: white; background-color: rgb(65, 64, 64); padding: 1rem; border-radius: 0.6rem; cursor: pointer;" onclick="setShowModal(true)">
                                            Thêm Sản Phẩm
                                        </button>';
                                    ?>
                                </div>
                            </div>
                            <div class="boxFeature d-flex flex-wrap" style="gap: 2rem;">
                                <input
                                    type="text"
                                    class="form-control"
                                    id="manhacungcap"
                                    placeholder="Nhập tên nhà cung cấp"
                                    style="width: 40%;padding: 10px 0px" />
                                <input
                                    type="text"
                                    class="form-control"
                                    id="sodienthoainhacungcap"
                                    placeholder="Nhập số điện thoại nhà cung cấp"
                                    style="width: 40%;padding: 10px 0;" />
                            </div>



                            <div class="boxTable">
                                <div style="background-color: rgb(236, 233, 233); width: 75%;">
                                    <table style="border-collapse: collapse; width: 100%; margin-top: 1rem; border-radius: 1rem;">
                                        <thead>
                                            <tr style="background-color: rgb(40, 40, 40); color: white;">
                                                <th style="padding: 0.5rem;">Mã Sản Phẩm</th>
                                                <th style="padding: 0.5rem;">Tên Sản Phẩm</th>
                                                <th style="padding: 0.5rem;">Đơn giá</th>
                                                <th style="padding: 0.5rem;">Số lượng</th>
                                            </tr>
                                        </thead>
                                        <tbody id="tableBody">
                                            <?php
                                            require_once "../../../BackEnd/ManagerBE/ChiTietPhieuNhapKhoBE.php";

                                            if (isset($_GET['MaPhieu'])) {
                                                $data = getChiTietPhieuNhapByMaPhieuNhap($_GET["MaPhieu"]);
                                                $data1 = $data->data;
                                                if (!empty($data1) && $_GET['trangthai'] == 'ChoDuyet') {
                                                    foreach ($data1 as $tmp) {
                                                        echo '<tr style="text-align: center;">
                                                                <td style="padding: 0.5rem; name=MaSanPham[]">' . $tmp['MaSanPham'] . '</td>
                                                                <td style="padding: 0.5rem;">' . $tmp['TenSanPham'] . '</td>
                                                                <td style="padding: 0.5rem;">
                                                                <input type="text" name="donGia[]" onblur="formatCurrency(this)" onfocus="clearFormat(this)" value="' . number_format($tmp['DonGiaNhap'], 0, '.', ',') . '"  style=" height: 3rem; padding: 0.5rem; width: 100%; background-color: white; font-weight: 700; margin-top: 0.5rem;text-align: right;" >
                                                            </td>
                                                             <td style="padding: 0.5rem;"><input type="text" name="soLuong[]"  onblur="validateSoLuong(this)" value="' . $tmp['SoLuong'] . '" style=" height: 3rem; padding: 0.5rem; width: 100%; background-color: white; font-weight: 700; margin-top: 0.5rem;text-align: right;"></td>
                                                            </tr>';
                                                    }
                                                } else
                                                    foreach ($data1 as $tmp) {
                                                        echo '<tr style="text-align: center;">
                                                            <td style="padding: 0.5rem; name=MaSanPham[]">' . $tmp['MaSanPham'] . '</td>
                                                            <td style="padding: 0.5rem;">' . $tmp['TenSanPham'] . '</td>
                                                            <td style="padding: 0.5rem;"><input type="text" name="donGia[]" onblur="validateDonGia(this)" value="' . number_format($tmp['DonGiaNhap'], 0, '.', ',') . '" disabled="true" style=" height: 3rem; padding: 0.5rem; width: 100%; background-color: white; font-weight: 700; margin-top: 0.5rem;text-align: right;" ></td>
                                                            <td style="padding: 0.5rem;"><input type="text" name="soLuong[]" onblur="validateSoLuong(this)" value="' . $tmp['SoLuong'] . '" disabled="true" style=" height: 3rem; padding: 0.5rem; width: 100%; background-color: white; font-weight: 700; margin-top: 0.5rem;text-align: right;"></td>
                                                        </tr>';
                                                    }
                                            }

                                            ?>

                                        </tbody>
                                    </table>
                                </div>
                                <div style="width: 25%; background-color: rgb(236, 233, 233); padding: 1rem;">
                                    <label>
                                        <p style="font-size: 1.3rem; font-weight: 700;">Mã Phiếu</p>
                                        <input id="maPNK" style="height: 3rem; padding: 0.5rem; width: 100%; background-color: white; font-weight: 700; margin-top: 0.5rem;" value="<?php if (isset($_GET['MaPhieu'])) echo $_GET['MaPhieu']; ?>" disabled="true" />
                                    </label>
                                    <label>
                                        <p style="font-size: 1.3rem; font-weight: 700; margin-top: 1rem;">Tên Người Quản Lý</p>
                                        <input id="maquanly" style="height: 3rem; padding: 0.5rem; width: 100%; background-color: white; font-weight: 700; margin-top: 0.5rem;" value="<?php if (isset($_GET['MaPhieu'])) echo $_GET['HoTen']; ?>" disabled="true" ;>

                                        </input>
                                    </label>
                                    <label>
                                        <p style="font-size: 1.3rem; font-weight: 700; margin-top: 1rem;">Tổng Giá Trị</p>
                                        <input id="totalvalue" style="height: 3rem; padding: 0.5rem; width: 100%; background-color: white; font-weight: 700; margin-top: 0.5rem;" value="<?php echo (isset($_GET['MaPhieu'])) ? number_format($_GET['TongTien'], 0, '.', ',') . ' ₫' : ''; ?>" <?php echo (isset($_GET['MaPhieu'])) ? 'disabled="true"' : ''; ?> />
                                    </label>
                                    <?php
                                    if (isset($_GET['MaPhieu']))
                                        if ($_GET['trangthai'] == 'DaDuyet') {
                                            echo ' <select id="status" disabled="true">
                                                <option value="choduyet">Chờ duyệt</option>
                                                <option value="daduyet" selected>Đã duyệt</option>
                                                <option value="huy">Hủy</option>
                                              </select>';
                                        } elseif ($_GET['trangthai'] == 'ChoDuyet') {
                                            echo ' <select id="status">
                                                <option value="choduyet" selected>Chờ duyệt</option>
                                                <option value="daduyet">Đã duyệt</option>
                                                <option value="huy">Hủy</option>
                                              </select>';
                                        } else {
                                            echo ' <select id="status" disabled="true">
                                                <option value="ChoDuyet">Chờ duyệt</option>
                                                <option value="DaDuyet">Đã duyệt</option>
                                                <option value="Huy" selected>Hủy</option>
                                              </select>';
                                        }

                                    ?>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
    if (!isset($_GET['MaPhieu'])) {
        echo '
        <div class="modal_overlay">
            <div class="modal_content">
                <!-- Đầu modal_content -->
                <span class="close_btn">
                    <h3>Chọn Sản Phẩm</h3>
                    <i onclick="setShowModal(false)">X</i>
                </span>
                <div style="margin-top: 1rem;">
                    <div style="position: relative;">
                        <i class="fa fa-search"></i>
                        <input class="input" placeholder="Tìm kiếm sản phẩm" id="timkiemsp" onkeyup="handleSearchChange(event)"/>
                    </div>
                    <div class="table_wrapper"> 
                        <table class="product_table"> 
                            <thead>
                                <tr style="background-color: rgb(40, 40, 40); color: white;">
                                    <th style="padding: 0.5rem;">Mã Sản Phẩm</th>
                                    <th style="padding: 0.5rem;width: 477px;">Tên Sản Phẩm</th>
                                    <th style="padding: 0.5rem;">Thao Tác</th>
                                </tr>
                            </thead>
                            <tbody id="tableBody1">                                
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="pagination" id="pagination"></div>

            </div>
        </div>';
    };
    ?>
</body>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    function formatCurrency(input) {
        let value = input.value;
        value = value.replace(/[^\d]/g, '');
        input.value = Number(value).toLocaleString('en-US');
    }

    function handleSubmit() {
        var maNhaCungCap = document.getElementById('manhacungcap').value;
        var userData = localStorage.getItem("key");
        userData = JSON.parse(userData);
        var trangthai = document.getElementById("status").value;
        var maPNK = document.getElementById("maPNK").value;
        var maQuanLy = userData.MaTaiKhoan;
        var totalValue = document.getElementById('totalvalue').value;
        var productData = [];
        if (maNhaCungCap === '') {
            Swal.fire({
                icon: 'error',
                title: 'Lỗi',
                text: 'Vui lòng chọn nhà cung cấp',
            });
            return; // Dừng hàm nếu nhà cung cấp chưa được chọn
        }
        $('#tableBody tr').each(function() {
            var maSanPham = $(this).find('td:nth-child(1)').text().trim();
            var tenSanPham = $(this).find('td:nth-child(2)').text().trim();
            var donGia = $(this).find('td:nth-child(3) input').val().trim();
            var dongia = clearFormat1(donGia);
            var soLuong = $(this).find('td:nth-child(4) input').val().trim();

            var productItem = {
                'MaSanPham': maSanPham,
                'TenSanPham': tenSanPham,
                'DonGia': dongia,
                'SoLuong': soLuong
            };

            productData.push(productItem);
        });
        if (productData.length === 0) {
            Swal.fire({
                icon: 'error',
                title: 'Lỗi',
                text: 'Vui lòng thêm ít nhất một sản phẩm.',
            });
            return false; // Dừng việc gửi form nếu productData trống
        }
        $.ajax({
            type: 'GET',
            url: 'xulyPhieuNhapKho.php',
            data: {
                'MaNhaCungCap': maNhaCungCap,
                'trangthai': trangthai,
                'MaQuanLy': maQuanLy,
                'MaPhieuNhapKho': maPNK,
                'ProductData': JSON.stringify(productData)
            },
            success: function(response) {
                Swal.fire({
                    icon: 'success',
                    title: 'Thành công',
                    text: 'Tạo phiếu nhập kho thành công',
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = 'QLPhieuNhapKho.php';
                    }
                });
            },
            error: function(xhr, status, error) {
                console.error('Đã xảy ra lỗi khi gửi yêu cầu.');
            }
        });
    }

    function setShowModal(show) {
        var modalOverlay = document.querySelector('.modal_overlay');
        modalOverlay.style.display = show ? '' : 'none';
    }

    function clearSelectedProducts() {
        localStorage.removeItem('selectedProducts');
    }

    function saveSelectedProducts() {
        let selectedProducts = [];
        $('.product_checkbox:checked').each(function() {
            selectedProducts.push($(this).attr('id'));
        });
        localStorage.setItem('selectedProducts', JSON.stringify(selectedProducts));
    }

    function loadSelectedProducts() {
        let selectedProducts = JSON.parse(localStorage.getItem('selectedProducts')) || [];
        $('.product_checkbox').each(function() {
            if (selectedProducts.includes($(this).attr('id'))) {
                $(this).prop('checked', true);
            }
        });
    }

    document.addEventListener('DOMContentLoaded', function() {
        var quanLyData = JSON.parse(localStorage.getItem("key"));
        var inputElement = document.getElementById("maquanly");
        inputElement.innerHTML = '';
        if (quanLyData && !inputElement.value) {
            inputElement.value = quanLyData.HoTen;
        }
        calculateTotalPrice();
        setInterval(calculateTotalPrice, 2000);

        function calculateTotalPrice() {
            var totalPrice = 0;
            var tableRows = document.querySelectorAll('#tableBody tr');
            tableRows.forEach(function(row) {
                var quantityCell = row.querySelector('td:nth-child(4) input');
                var priceCell = row.querySelector('td:nth-child(3) input');
                if (quantityCell && priceCell) {
                    var quantity = parseInt(quantityCell.value);
                    var price = clearFormat1(priceCell.value);
                    if (!isNaN(quantity) && !isNaN(price)) { // Kiểm tra nếu quantity và price là số hợp lệ
                        totalPrice += quantity * price;
                    }
                }
            });
            var formattedTongGiaTri = totalPrice.toLocaleString('vi-VN', {
                style: 'currency',
                currency: 'VND'
            });
            var totalPriceElement = document.getElementById('totalvalue');
            if (totalPriceElement) {
                totalPriceElement.value = formattedTongGiaTri;
            }
        }
    });

    $(document).on('change', '.product_checkbox', function() {
        saveSelectedProducts(); // Lưu trạng thái của các sản phẩm đã chọn
        $('#tableBody').empty();
        $('.product_checkbox').each(function() {
            if ($(this).prop('checked')) {
                var productId = $(this).attr('id');
                var productName = $(this).closest('tr').find('td:eq(1)').text().trim();

                var selectedProductHTML = '<tr style="text-align: center;">' +
                    '<td style="padding: 0.5rem; name=MaSanPham[]">' + productId + '</td>' +
                    '<td style="padding: 0.5rem;">' + productName + '</td>' +
                    '<td style="padding: 0.5rem;"><input type="text" name="donGia[]" onblur="validateDonGia(this)" value="1" style="height: 3rem; padding: 0.5rem; width: 100%; background-color: white; font-weight: 700; margin-top: 0.5rem;text-align: right;"></td>' +
                    '<td style="padding: 0.5rem;"><input type="text" name="soLuong[]" value="1" onblur="validateSoLuong(this)" style="height: 3rem; padding: 0.5rem; width: 100%; background-color: white; font-weight: 700; margin-top: 0.5rem;text-align: right;"></td>' +
                    '</tr>';
                $('#tableBody').append(selectedProductHTML);
            }
        });
    });


    function validateDonGia(input) {
        var donGia = parseFloat(input.value);
        if (donGia < 1 || isNaN(donGia)) {
            Swal.fire({
                icon: 'error',
                title: 'Lỗi',
                text: 'Đơn giá không được nhỏ hơn 1',
            });

            input.value = "1";
        }
    }

    function validateSoLuong(input) {
        var soLuong = parseInt(input.value);
        if (soLuong < 1 || isNaN(soLuong)) {
            Swal.fire({
                icon: 'error',
                title: 'Lỗi',
                text: "Số lượng phải là một số nguyên lớn hơn hoặc bằng 1",
            });
            input.value = "1";
        }
    }
    let currentSearch = ''; // Biến toàn cục để lưu trữ giá trị tìm kiếm hiện tại

    function handleSearchChange(event) {
        // Lưu giá trị tìm kiếm và gọi hàm load dữ liệu cho trang đầu tiên
        currentSearch = event.target.value.trim();
        loaddatasp(1, currentSearch);
    }

    function loaddatasp(page, search) {
        const token = localStorage.getItem("token");

        $('#tableBody1').empty(); // Xóa nội dung cũ của bảng
        let ajaxData = {
            pageNumber: page
        }; // Thêm tham số trang vào AJAX

        // Nếu search có giá trị, thêm tham số vào object data
        if (search) {
            ajaxData.search = search;
        }

        $.ajax({
            url: 'http://localhost:8080/Product/Admin',
            type: 'GET',
            dataType: "json",
            data: ajaxData, // Truyền object ajaxData
            headers: {
                'Authorization': 'Bearer ' + token
            },
            success: function(response) {
                var data = response.content;
                var tableBody = document.getElementById("tableBody1");
                var tableContent = "";
                data.forEach(function(record) {
                    var checked = localStorage.getItem('selectedProducts') ?
                        JSON.parse(localStorage.getItem('selectedProducts')).includes(record['id']) :
                        false;
                    var trContent = `
                <tr style="text-align: center;">
                    <td style="padding: 0.5rem;">${record['id']}</td>
                    <td style="padding: 0.5rem;">${record['productName']}</td>
                    <td style="padding: 0.5rem;">
                        <input type="checkbox" class="product_checkbox" id="${record['id']}" ${checked ? 'checked' : ''}/>
                    </td>
                </tr>`;
                    tableContent += trContent;
                });

                tableBody.innerHTML = tableContent;
                loadSelectedProducts(); // Khôi phục trạng thái các sản phẩm đã chọn
                createPagination(page, response.totalPages);
            },
            error: function(xhr, status, error) {
                console.error('Lỗi khi gọi API: ', error);
            }
        });
    }


    function createPagination(currentPage, totalPages) {
        var paginationContainer = document.getElementById("pagination");

        // Xóa nút phân trang cũ (nếu có)
        paginationContainer.innerHTML = '';

        if (totalPages > 1) {
            // Tạo nút cho từng trang và thêm vào chuỗi HTML
            var paginationHTML = '';
            for (var i = 1; i <= totalPages; i++) {
                paginationHTML += '<button class="pageButton">' + i + '</button>';
            }

            // Thiết lập nút phân trang vào paginationContainer
            paginationContainer.innerHTML = paginationHTML;

            // Thêm sự kiện click cho từng nút phân trang
            paginationContainer.querySelectorAll('.pageButton').forEach(function(button, index) {
                button.addEventListener('click', function() {
                    // Gọi hàm loaddatasp khi người dùng click vào nút phân trang
                    loaddatasp(index + 1, currentSearch); // Sử dụng currentSearch thay vì lấy từ input
                });
            });

            // Đánh dấu trang hiện tại
            paginationContainer.querySelector('.pageButton:nth-child(' + currentPage + ')').classList.add('active');
        }
    }

    $(document).ready(function() {
        loaddatasp(1, ''); // Gọi hàm với trang đầu tiên và không có tìm kiếm mặc định
    });
</script>