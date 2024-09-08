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
                                    <button style="font-family: Arial; font-size: 1.5rem; font-weight: 700; color: white; color: rgb(65, 64, 64); border: 1px solid rgb(65, 64, 64); background-color: white; padding: 1rem; border-radius: 0.6rem; cursor: pointer;" onclick="clearSelectedProducts()">
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
                                    style="width: 40%;padding: 10px 0px"
                                    <?php if (isset($_GET['MaPhieu'])) echo 'disabled="true"' ?> />
                                <input
                                    type="text"
                                    class="form-control"
                                    id="sodienthoainhacungcap"
                                    placeholder="Nhập số điện thoại nhà cung cấp"
                                    style="width: 40%;padding: 10px 0;"
                                    <?php if (isset($_GET['MaPhieu'])) echo 'disabled="true"' ?> />
                                <button style="margin-left: 1rem; font-family: Arial; font-size: 1.5rem; font-weight: 700; color: white; background-color: rgb(65, 64, 64); padding: 1rem; border-radius: 0.6rem; cursor: pointer;" onclick="handleSubmit()">
                                    Tạo phiếu nhập
                                </button>
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
                                        <p style="font-size: 1.3rem; font-weight: 700; margin-top: 1rem;">Tổng Giá Trị</p>
                                        <input id="totalvalue" style="height: 3rem; padding: 0.5rem; width: 100%; background-color: white; font-weight: 700; margin-top: 0.5rem;" value="" disabled="true" />
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
        value = value.replace(/[^\d]/g, ''); // Loại bỏ ký tự không phải số
        input.value = Number(value).toLocaleString('en-US'); // Định dạng tiền tệ
    }

    function clearFormat(input) {
        let value = input.value;
        value = value.replace(/[,]/g, ''); // Loại bỏ dấu phân cách hàng nghìn
        input.value = value;
    }

    function validatePhoneNumber(sodienthoainhacungcap) {
        // Xóa các ký tự không phải số như khoảng trắng hoặc dấu gạch ngang
        let phoneNumber = sodienthoainhacungcap.replace(/\D/g, '');

        // Kiểm tra độ dài của số điện thoại (ví dụ, 10-11 chữ số cho số tại Việt Nam)
        if (phoneNumber.length < 10 || phoneNumber.length > 11) {
            Swal.fire({
                icon: 'error',
                title: 'Lỗi',
                text: 'Số điện thoại phải từ 10 đến 11 chữ số.',
            });
            return false;
        }

        // Kiểm tra xem số điện thoại chỉ chứa các chữ số
        if (!/^\d+$/.test(phoneNumber)) {
            Swal.fire({
                icon: 'error',
                title: 'Lỗi',
                text: 'Số điện thoại không hợp lệ. Chỉ bao gồm chữ số.',
            });
            return false;
        }

        return true; // Nếu số điện thoại hợp lệ
    }

    function clearCurrencyFormat(value) {
        return parseInt(value.replace(/[^\d]/g, ''), 10); // Loại bỏ tất cả các ký tự không phải số và chuyển đổi thành số nguyên
    }


    function handleSubmit() {
        var maNhaCungCap = document.getElementById('manhacungcap').value;
        var sodienthoainhacungcap = document.getElementById('sodienthoainhacungcap').value;
        var trangthai = document.getElementById("status");
        var maPNK = document.getElementById("maPNK");
        var totalValue = clearCurrencyFormat(document.getElementById('totalvalue').value);
        var productData = [];
        if (maNhaCungCap === '') {
            Swal.fire({
                icon: 'error',
                title: 'Lỗi',
                text: 'Vui lòng điền tên nhà cung cấp',
            });
            return; // Dừng hàm nếu nhà cung cấp chưa được chọn
        }
        if (sodienthoainhacungcap === '' || !validatePhoneNumber(sodienthoainhacungcap)) {
            Swal.fire({
                icon: 'error',
                title: 'Lỗi',
                text: 'Số điện thoại nhà cung cấp không hợp lệ',
            });
            return; // Dừng hàm nếu nhà cung cấp chưa được chọn
        }
        $('#tableBody tr').each(function() {
            var maSanPham = $(this).find('td:nth-child(1)').text().trim();
            var tenSanPham = $(this).find('td:nth-child(2)').text().trim();
            var donGia = $(this).find('td:nth-child(3) input').val().trim();
            var dongia = donGia;
            var soLuong = $(this).find('td:nth-child(4) input').val().trim();

            var totalItemValue = parseFloat(dongia) * parseInt(soLuong);

            var productItem = {
                'idProductId': maSanPham,
                'unitPrice': dongia,
                'quantity': soLuong,
                'total': totalItemValue
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
        const token = localStorage.getItem("token");
        var formData = new FormData();
        var totalPrice = parseInt(totalValue);
        if (isNaN(totalPrice)) {
            console.error("Invalid totalPrice");
            return;
        }
        formData.append('totalPrice', totalPrice);

        formData.append('supplier', maNhaCungCap);
        formData.append('supplierPhone', sodienthoainhacungcap);

        productData.forEach((item, index) => {
            var idProductId = parseInt(item.idProductId);
            var unitPrice = parseInt(item.unitPrice);
            var quantity = parseInt(item.quantity);
            var total = parseInt(item.total);

            if (isNaN(idProductId) || isNaN(unitPrice) || isNaN(quantity) || isNaN(total)) {
                console.error(`Invalid data for product ${index}`);
                return;
            }

            formData.append(`inventoryReportDetailCreateFormList[${index}].idProductId`, idProductId);
            formData.append(`inventoryReportDetailCreateFormList[${index}].unitPrice`, unitPrice);
            formData.append(`inventoryReportDetailCreateFormList[${index}].quantity`, quantity);
            formData.append(`inventoryReportDetailCreateFormList[${index}].total`, total);
        });
        $.ajax({
            type: 'POST',
            url: 'http://localhost:8080/InventoryReport',
            data: formData,
            contentType: false, // Không gửi tiêu đề Content-Type
            processData: false, // Không xử lý dữ liệu
            headers: {
                'Authorization': 'Bearer ' + token
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

    function calculateTotalPrice() {
        var totalPrice = 0; // Biến lưu tổng giá trị
        var tableRows = document.querySelectorAll('#tableBody tr'); // Lấy tất cả các dòng trong bảng

        // Duyệt qua từng dòng để tính tổng
        tableRows.forEach(function(row) {
            var quantityCell = row.querySelector('input[name="soLuong[]"]'); // Ô số lượng
            var priceCell = row.querySelector('input[name="donGia[]"]'); // Ô đơn giá

            // Kiểm tra nếu các ô tồn tại và có giá trị hợp lệ
            if (quantityCell && priceCell) {
                var quantity = parseInt(quantityCell.value) || 0; // Chuyển đổi số lượng thành số, nếu không hợp lệ thì mặc định là 0
                var price = parseFloat(priceCell.value.replace(/,/g, '')) || 0; // Chuyển đổi giá thành số, loại bỏ dấu phẩy nếu có, nếu không hợp lệ thì mặc định là 0

                // Tính giá trị cho dòng này và cộng vào tổng
                totalPrice += quantity * price;
            }
        });

        // Định dạng lại tổng giá trị thành chuỗi tiền tệ
        var formattedTongGiaTri = totalPrice.toLocaleString('vi-VN', {
            style: 'currency',
            currency: 'VND'
        });

        // Cập nhật vào ô hiển thị tổng giá trị
        var totalPriceElement = document.getElementById('totalvalue');
        if (totalPriceElement) {
            totalPriceElement.value = formattedTongGiaTri; // Gán giá trị đã định dạng vào ô tổng giá trị
        }
    }

    function saveSelectedProducts() {
        let selectedProducts = JSON.parse(localStorage.getItem('selectedProducts')) || [];
        let selectedMap = new Map(selectedProducts.map(product => [product.id, product]));

        $('.product_checkbox').each(function() {
            let productId = $(this).attr('id');
            let productName = $(this).closest('tr').find('td:eq(1)').text().trim();

            // Lấy giá và số lượng hiện tại của sản phẩm
            let donGiaElement = document.getElementById(`donGia${productId}`);
            let soLuongElement = document.getElementById(`soLuong${productId}`);

            // Nếu phần tử tồn tại, lấy giá trị, nếu không, đặt giá trị mặc định là "1"
            let donGia = donGiaElement ? donGiaElement.value : "1";
            let soLuong = soLuongElement ? soLuongElement.value : "1";

            if ($(this).prop('checked')) {
                if (!selectedMap.has(productId)) {
                    selectedMap.set(productId, {
                        id: productId,
                        name: productName,
                        donGia: donGia,
                        soLuong: soLuong
                    });
                } else {
                    // Cập nhật thông tin giá và số lượng nếu sản phẩm đã có trong danh sách
                    let product = selectedMap.get(productId);
                    product.donGia = donGia;
                    product.soLuong = soLuong;
                }
            } else {
                selectedMap.delete(productId);
            }
        });

        localStorage.setItem('selectedProducts', JSON.stringify([...selectedMap.values()]));

        // Tính toán lại tổng giá trị ngay sau khi lưu sản phẩm vào localStorage
        calculateTotalPrice();
    }


    $(document).on('input', 'input[name="donGia[]"], input[name="soLuong[]"]', function() {
        calculateTotalPrice();
        saveSelectedProducts(); // Cập nhật thông tin trong localStorage
    });


    function loadSelectedProducts() {
        let selectedProducts = JSON.parse(localStorage.getItem('selectedProducts')) || [];
        let selectedIds = new Set(selectedProducts.map(product => product.id));

        $('.product_checkbox').each(function() {
            $(this).prop('checked', selectedIds.has($(this).attr('id')));
        });
    }

    $(document).on('change', '.product_checkbox', function() {
        saveSelectedProducts(); // Lưu trạng thái của các sản phẩm đã chọn

        // Xóa nội dung hiện tại của bảng
        $('#tableBody').empty();

        // Tải tất cả sản phẩm từ localStorage
        let selectedProducts = JSON.parse(localStorage.getItem('selectedProducts')) || [];

        selectedProducts.forEach(function(product) {
            var selectedProductHTML = `
        <tr style="text-align: center;">
            <td style="padding: 0.5rem;" name="MaSanPham[]">${product.id}</td>
            <td style="padding: 0.5rem;">${product.name}</td>
            <td style="padding: 0.5rem;">
                <input type="text" name="donGia[]" id="donGia${product.id}" onblur="formatCurrency(this)" onfocus="clearFormat(this)" value="${product.donGia}" style="height: 3rem; padding: 0.5rem; width: 100%; background-color: white; font-weight: 700; margin-top: 0.5rem;text-align: right;">
            </td>
            <td style="padding: 0.5rem;">
                <input type="text" name="soLuong[]" id="soLuong${product.id}" value="${product.soLuong}" onblur="validateSoLuong(this)" style="height: 3rem; padding: 0.5rem; width: 100%; background-color: white; font-weight: 700; margin-top: 0.5rem;text-align: right;">
            </td>
        </tr>`;
            $('#tableBody').append(selectedProductHTML);
        });

        // Gọi ngay tính tổng sau khi thêm sản phẩm vào bảng
        calculateTotalPrice(); // Tính toán lại tổng giá trị ngay sau khi thêm sản phẩm
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
        localStorage.removeItem('selectedProducts');
        loadSelectedProducts();

        loaddatasp(1, ''); // Gọi hàm với trang đầu tiên và không có tìm kiếm mặc định
    });
</script>