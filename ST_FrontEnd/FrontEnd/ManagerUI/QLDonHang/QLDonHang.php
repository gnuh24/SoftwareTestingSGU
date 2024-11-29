<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../AdminDemo.css" />
    <link rel="stylesheet" href="./QLDonHang.css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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
                                    <div class="Admin_rightBar__RXnS9">
                                        <div style="
                                                display: flex;
                                                margin-bottom: 1rem;
                                                align-items: center;
                                            ">
                                            <p class="Admin_title__1Tk48">Quản lí đơn hàng</p>
                                        </div>
                                        <div class="Admin_boxFeature__ECXnm">
                                            <label for=""> Lọc đơn hàng:</label>
                                            <div style="position: relative">
                                                <input class="Admin_input__LtEE-" type="date" id="dateStart" />
                                            </div>
                                            <label for=""> đến </label>
                                            <div style="position: relative">
                                                <input class="Admin_input__LtEE-" type="date" id="dateEnd" />
                                            </div>
                                            <div style="position: relative">
                                                <select style="height: 3rem; padding: 0.3rem;" class="Admin_input__LtEE-" id="TrangThai">
                                                    <option value="">Trạng thái : Tất Cả</option>
                                                    <option value="ChoDuyet">Chờ duyệt</option>
                                                    <option value="DaDuyet">Đã duyệt</option>
                                                    <option value="Huy">Hủy</option>
                                                    <option value="DangGiao">Đang giao</option>
                                                    <option value="GiaoThanhCong">Giao thành công</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="Admin_boxTable__hLXRJ">
                                            <table class="Table_table__BWPy">
                                                <thead class="Table_head__FTUog">
                                                    <tr>
                                                        <th class="Table_th__hCkcg">Mã đơn</th>
                                                        <th class="Table_th__hCkcg">Ngày đặt</th>
                                                        <th class="Table_th__hCkcg">Tổng đơn</th>
                                                        <th class="Table_th__hCkcg">Khách hàng</th>
                                                        <th class="Table_th__hCkcg">Số điện thoại</th>
                                                        <th class="Table_th__hCkcg">Trạng thái</th>
                                                        <th class="Table_th__hCkcg">Hành động</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="tableBody">
                                                </tbody>
                                            </table>
                                            <div id="pagination" class="pagination">
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
    var udPage = 1;
    var udminNgayTao = 0;
    var udmaxNgayTao = 0;
    var udtrangThai = "";

    $(document).ready(function() {
        // Khởi tạo giá trị cho các biến
        var udminNgayTao = null;
        var udmaxNgayTao = null;
        var udtrangThai = null;

        // Tải dữ liệu ban đầu
        loadDataToTable(udPage, null, null, null);

        // Xử lý thay đổi ngày bắt đầu
        $("#dateStart").on("change", function() {
            udminNgayTao = $(this).val();
            // Kiểm tra nếu ngày kết thúc đã được chọn
            if (udmaxNgayTao && udminNgayTao > udmaxNgayTao) {
                Swal.fire({
                    icon: 'error',
                    title: 'Ngày không hợp lệ',
                    text: 'Ngày bắt đầu không thể lớn hơn ngày kết thúc!'
                });
                $(this).val(''); // Đặt lại giá trị ngày bắt đầu
                udminNgayTao = null; // Reset biến ngày bắt đầu
                return; // Ngăn không cho hàm tiếp tục
            }
            loadDataToTable(1, udminNgayTao, udmaxNgayTao, udtrangThai);
        });

        // Xử lý thay đổi ngày kết thúc
        $("#dateEnd").on("change", function() {
            udmaxNgayTao = $(this).val();
            // Kiểm tra nếu ngày bắt đầu đã được chọn
            if (udminNgayTao && udmaxNgayTao < udminNgayTao) {
                Swal.fire({
                    icon: 'error',
                    title: 'Ngày không hợp lệ',
                    text: 'Ngày kết thúc không thể nhỏ hơn ngày bắt đầu!'
                });
                $(this).val(''); // Đặt lại giá trị ngày kết thúc
                udmaxNgayTao = null; // Reset biến ngày kết thúc
                return; // Ngăn không cho hàm tiếp tục
            }
            loadDataToTable(1, udminNgayTao, udmaxNgayTao, udtrangThai);
        });

        // Xử lý thay đổi trạng thái
        $("#TrangThai").on("change", function() {
            udtrangThai = $(this).val();
            loadDataToTable(1, udminNgayTao, udmaxNgayTao, udtrangThai);
        });

        // Gọi lại hàm loadDataToTable khi có thay đổi ở bất kỳ trường nào
        $("#dateStart, #dateEnd, #TrangThai").on("change", function() {
            loadDataToTable(1, udminNgayTao, udmaxNgayTao, udtrangThai);
        });
    });



    function clearTable() {
        var tableBody = document.getElementById("tableBody");
        tableBody.innerHTML = ''; // Xóa nội dung trong tbody
    }

    function number_format_vnd(number) {
        return Number(number).toLocaleString('vi-VN', {
            style: 'currency',
            currency: 'VND'
        });
    }

    function getUpdateStatusText(status) {
        switch (status) {
            case 'ChoDuyet':
                return 'Duyệt';
            case 'DaDuyet':
                return 'Giao hàng';
            case 'DangGiao':
                return 'Hoàn tất';
            default:
                return 'Cập nhật trạng thái'; // Nội dung mặc định nếu không khớp với bất kỳ trạng thái nào
        }
    }

    function getUpdateStatus(status) {
        switch (status) {
            case 'ChoDuyet':
                return 'DaDuyet';
            case 'DaDuyet':
                return 'DangGiao';
            case 'DangGiao':
                return 'GiaoThanhCong';
        }
    }

    function updateStatus(orderId, currentStatus) {
        Swal.fire({
            title: 'Bạn có chắc chắn?',
            text: "Bạn muốn cập nhật trạng thái của đơn hàng này?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Xác nhận'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "POST",
                    url: "http://localhost:8080/OrderStatus/Admin",
                    headers: {
                        'Authorization': 'Bearer ' + sessionStorage.getItem('token')
                    },
                    data: {
                        orderId: orderId,
                        idStatus: currentStatus
                    },
                    success: function(response) {
                        Swal.fire('Thành công!', 'Đã cập nhật trạng thái đơn hàng.', 'success');
                        loadDataToTable(udPage, udminNgayTao, udmaxNgayTao, udtrangThai);
                    },
                    error: function(error) {
                        Swal.fire('Thất bại!', error.responseJSON.detailMessage, 'error');
                    }
                });
            }
        });
    }

    function renderTableBody(data) {
        var tableBody = document.getElementById("tableBody");
        var html = '';
        $.each(data.content, function(index, record) {
            let totalPriceFormat = number_format_vnd(record.totalPrice);
            html += '<tr>';
            html += '<td>' + record.id + '</td>';
            html += '<td>' + record.orderTime + '</td>'; // Sử dụng orderTime trực tiếp từ BE
            html += '<td>' + totalPriceFormat + '</td>';
            html += '<td>' + record.fullname + '</td>';
            html += '<td>' + record.phoneNumber + '</td>';
            html += '<td>' + formatStatus(record.status) + '</td>';

            html += '<td style="display: flex; gap: 5px;">';
            html += '<a href="./ChiTietDonHang.php?id=' + record.id + '" class="edit">Chi tiết</a> '; // Nút Chi tiết

            // Nút Cập nhật trạng thái (màu xanh lá) với nội dung tùy thuộc vào trạng thái
            if (record.status !== 'GiaoThanhCong' && record.status !== 'Huy') {
                const updateStatusText = getUpdateStatusText(record.status);
                const nextStatus = getUpdateStatus(record.status);

                html += `
                    <button 
                        type="button" 
                        class="update-status" 
                        onclick="updateStatus('${record.id}', '${nextStatus}')"
                    >
                        ${updateStatusText}
                    </button>`;
            }

            // Kiểm tra trạng thái trước khi hiển thị nút Hủy
            if (record.status !== 'DaDuyet' && record.status !== 'GiaoThanhCong' && record.status !== 'Huy' && record.status !== 'DangGiao') {
                html += `
                      <button 
                          type="button" 
                          class="cancel" 
                          onclick="updateStatus('${record.id}', 'Huy')"
                      >
                          Hủy
                      </button>`;
            }
            html += '</td>';
            html += '</tr>';
        });
        tableBody.innerHTML = html;
    }

    function formatStatus(status) {
        switch (status) {
            case 'ChoDuyet':
                return 'Chờ Duyệt';
            case 'DaDuyet':
                return 'Đã duyệt';
            case 'Huy':
                return 'Đã Hủy';
            case 'DangGiao':
                return 'Đang Giao';
            case 'GiaoThanhCong':
                return 'Giao thành công';
            default:
                return status;
        }
    }

    function convertDateFormat(dateString) {
        // Kiểm tra định dạng đầu vào
        const regex = /^\d{4}-\d{2}-\d{2}$/;
        if (!regex.test(dateString)) {
            throw new Error("Định dạng ngày không hợp lệ. Vui lòng sử dụng 'yyyy-MM-dd'.");
        }

        // Tách các phần của ngày
        const parts = dateString.split('-');
        const year = parts[0];
        const month = parts[1];
        const day = parts[2];

        // Trả về định dạng mới
        return `${day}/${month}/${year}`;
    }

    function loadDataToTable(page, minNgayTao, maxNgayTao, trangThai) {
        clearTable();
        console.log(page, minNgayTao, maxNgayTao, trangThai);

        // Tạo đối tượng chứa các tham số
        var data = {
            pageNumber: page,
            // sort: "orderTime,desc" // Bỏ chú thích nếu bạn cần phân loại
        };

        // Chỉ thêm các tham số không null
        if (minNgayTao) {
            minNgayTao = convertDateFormat(minNgayTao);
            data.from = minNgayTao;
        }

        if (maxNgayTao) {
            maxNgayTao = convertDateFormat(maxNgayTao);
            data.to = maxNgayTao;
        }

        if (trangThai) {
            data.status = trangThai;
        }

        $.ajax({
            type: "GET",
            url: "http://localhost:8080/Order/Admin",
            headers: {
                'Authorization': 'Bearer ' + sessionStorage.getItem('token') // Thay 'yourTokenKey' bằng khóa lưu token của bạn
            },
            data: data, // Sử dụng đối tượng data
            success: function(response) {
                renderTableBody(response);

                // Kiểm tra số lượng đơn hàng
                if (response.totalElements > 0) {
                    renderPagination(response.totalPages, page);
                    $('#pagination').show(); // Hiển thị phân trang
                } else {
                    $('#pagination').hide(); // Ẩn phân trang
                }
            },
            error: function(error) {
                console.error('Error:', error);
            }
        });
    }


    function renderPagination(totalPages, currentPage) {
        var pagination = document.getElementById("pagination");
        var html = '';

        // First button
        if (currentPage > 1) {
            html += '<button class="pageButton" onclick="loadDataToTable(1, udminNgayTao, udmaxNgayTao, udtrangThai)" aria-label="Trang đầu tiên"><<</button>';
        }

        // Previous button
        if (currentPage > 1) {
            html += '<button class="pageButton" onclick="loadDataToTable(' + (currentPage - 1) + ', udminNgayTao, udmaxNgayTao, udtrangThai)" aria-label="Trang trước">Trước</button>';
        }

        // Calculate start and end page
        var maxPagesToShow = 5;
        var startPage = Math.max(1, currentPage - Math.floor(maxPagesToShow / 2));
        var endPage = Math.min(totalPages, startPage + maxPagesToShow - 1);

        // Adjust startPage if endPage is at the limit
        if (endPage - startPage < maxPagesToShow - 1) {
            startPage = Math.max(1, endPage - maxPagesToShow + 1);
        }

        // Page numbers
        for (var i = startPage; i <= endPage; i++) {
            if (i === currentPage) {
                html += '<button class="pageButton active" aria-current="page">' + i + '</button>';
            } else {
                html += '<button class="pageButton" onclick="loadDataToTable(' + i + ', udminNgayTao, udmaxNgayTao, udtrangThai)">' + i + '</button>';
            }
        }

        // Next button
        if (currentPage < totalPages) {
            html += '<button class="pageButton" onclick="loadDataToTable(' + (currentPage + 1) + ', udminNgayTao, udmaxNgayTao, udtrangThai)" aria-label="Trang tiếp theo">Sau</button>';
        }

        // Last button
        if (currentPage < totalPages) {
            html += '<button class="pageButton" onclick="loadDataToTable(' + totalPages + ', udminNgayTao, udmaxNgayTao, udtrangThai)" aria-label="Trang cuối cùng">>></button>';
        }

        pagination.innerHTML = html;
    }
</script>

</html>