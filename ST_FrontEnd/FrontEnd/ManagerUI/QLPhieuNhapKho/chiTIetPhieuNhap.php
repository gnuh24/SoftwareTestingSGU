<?php
if (isset($_GET['MaPhieu'])) {
    require_once "../../../BackEnd/ManagerBE/ChiTietPhieuNhapKhoBE.php";
    $result = getAllChiTietphieunhapkho(1, $_GET['MaPhieu'], null);
    $totalPage = $result->totalPages;
    $Ketqua1 = $result->data;
    $MaNCC;
    foreach ($Ketqua1 as $record) {
        $MaNCC = $record['MaNCC'];
    }
}
?>
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
                                    if (!isset($_GET['id']))
                                        echo '
                                        <button style="margin-left: 1rem; font-family: Arial; font-size: 1.5rem; font-weight: 700; color: white; background-color: rgb(65, 64, 64); padding: 1rem; border-radius: 0.6rem; cursor: pointer;" onclick="setShowModal(true)">
                                            Thêm Sản Phẩm
                                        </button>';
                                    ?>
                                </div>
                            </div>
                            <div class="boxFeature">
                                <select style="height: 3rem; padding: 0.3rem; width: 50rem;" id="manhacungcap" <?php if (isset($_GET['MaPhieu']) && $_GET['trangthai'] !== 'ChoDuyet') echo 'disabled="true"'; ?>>
                                    <option value="">Chọn nhà cung cấp</option>
                                    <?php
                                    require_once "../../../BackEnd/ManagerBE/NhaCungCapBE.php";
                                    $result = getAllNhaCungCapNotPage();
                                    $result1 = $result->data;
                                    foreach ($result1 as $Ketqua) {
                                        echo $Ketqua["MaNCC"];
                                        if (isset($_GET['MaPhieu'])) {
                                            if ($Ketqua["MaNCC"] == $_GET['MaNCC1'])
                                                echo '<option value="' . $Ketqua["MaNCC"] . '" selected>' . $Ketqua["TenNCC"] . '</option>';
                                            else
                                                echo '<option value="' . $Ketqua["MaNCC"] . '">' . $Ketqua["TenNCC"] . '</option>';
                                        } else {
                                            echo '<option value="' . $Ketqua["MaNCC"] . '">' . $Ketqua["TenNCC"] . '</option>';
                                        }
                                    }
                                    ?>
                                </select>

                                <?php
                                if (!isset($_GET['trangthai']) || ($_GET['trangthai'] == 'ChoDuyet')) {
                                    echo '<button style="margin-left: auto; font-family: Arial; font-size: 1.5rem; font-weight: 700; color: white; background-color: rgb(65, 64, 64); padding: 1rem; border-radius: 0.6rem; cursor: pointer;" onclick="handleSubmit()">Lưu</button>';
                                }

                                ?>

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
                        <input class="input" placeholder="Tìm kiếm sản phẩm" id="timkiemsp" />
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
            </div>
        </div>';
    };
    ?>
</body>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    // Function to handle form submission
    function formatCurrency(input) {
        // Lấy giá trị nhập vào từ trường input
        let value = input.value;
        // Loại bỏ các dấu phân tách và ký tự không phải số
        value = value.replace(/[^\d]/g, '');
        // Định dạng lại giá trị thành định dạng tiền tệ
        input.value = Number(value).toLocaleString('en-US');
    }

    function clearFormat(input) {
        // Loại bỏ các dấu phân tách khi trường nhận trọng tâm
        let value = input.value;
        value = value.replace(/[,]/g, '');
        input.value = value;
    }

    function clearFormat1(value) {
        // Loại bỏ các dấu phân tách từ giá trị
        return value.replace(/[,]/g, '');
    }

    function handleSubmit() {
        var maNhaCungCap = document.getElementById('manhacungcap').value;
        var userData = sessionStorage.getItem("key");
        userData = JSON.parse(userData);
        try {
            var trangthai = document.getElementById("status").value;
            var maPNK = document.getElementById("maPNK").value;

        } catch (error) {}
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

    // Function to toggle modal display
    function setShowModal(show) {
        var modalOverlay = document.querySelector('.modal_overlay');
        modalOverlay.style.display = show ? '' : 'none';
    }

    document.addEventListener('DOMContentLoaded', function() {
        var quanLyData = JSON.parse(sessionStorage.getItem("key"));
        var inputElement = document.getElementById("maquanly");
        inputElement.innerHTML = '';
        if (quanLyData && !inputElement.value) {
            inputElement.value = quanLyData.HoTen;
        }
        try {
            loaddatasp();

        } catch (error) {

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





    // // Function to load product data
    // function loaddatasp() {
    //     $('#tableBody1').empty();
    //     $.ajax({
    //         url: '../../../BackEnd/ManagerBE/SanPhamBE.php',
    //         type: 'GET',
    //         dataType: "json",
    //         data: {
    //             search: timkiemsp.value
    //         },
    //         success: function(response) {
    //             var data = response.data;
    //             var tableBody = document.getElementById("tableBody1");
    //             var tableContent = "";
    //             data.forEach(function(record) {
    //                 var trContent = `
    //                 <tr style="text-align: center;">
    //                     <td style="padding: 0.5rem;">${record['MaSanPham']}</td>
    //                     <td style="padding: 0.5rem;">${record['TenSanPham']}</td>
    //                     <td style="padding: 0.5rem;">
    //                         <input type="checkbox" class="product_checkbox" id="${record['MaSanPham']}"/>
    //                     </td>
    //                 </tr>`;

    //                 tableContent += trContent;
    //             });

    //             tableBody.innerHTML = tableContent;
    //         },
    //         error: function(xhr, status, error) {
    //             console.error('Lỗi khi gọi API: ', error);
    //         }
    //     });
    // }
</script>