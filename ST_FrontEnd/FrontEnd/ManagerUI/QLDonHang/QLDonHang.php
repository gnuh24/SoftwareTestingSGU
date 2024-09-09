<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../AdminDemo.css" />
    <link rel="stylesheet" href="./QLDonHang.css" />
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

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    var udPage = 1;
    var udminNgayTao = 0;
    var udmaxNgayTao = 0;
    var udtrangThai = "";

    $(document).ready(function() {
        loadDataToTable(udPage, null, null, null);

        $("#dateStart").on("change", function() {
            udminNgayTao = $(this).val();
            loadDataToTable(1, udminNgayTao, udmaxNgayTao, udtrangThai);
        });

        $("#dateEnd").on("change", function() {
            udmaxNgayTao = $(this).val();
            loadDataToTable(1, udminNgayTao, udmaxNgayTao, udtrangThai);
        });

        $("#TrangThai").on("change", function() {
            udtrangThai = $(this).val();
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
                        'Authorization': 'Bearer ' + localStorage.getItem('token') 
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
                        console.error('Error:', error);
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

            html += '<td>';
            html += '<a href="./ChiTietDonHang.php?id=' + record.id + '" class="edit">Chi tiết</a> '; // Nút Chi tiết

            // Kiểm tra trạng thái trước khi hiển thị nút Hủy
            if (record.status !== 'GiaoThanhCong') {
                html += `
                      <button 
                          type="button" 
                          class="cancel" 
                          onclick="updateStatus('${record.id}', 'Huy')"
                      >
                          Hủy
                      </button>`;        }

          // Nút Cập nhật trạng thái (màu xanh lá) với nội dung tùy thuộc vào trạng thái
            if (record.status !== 'GiaoThanhCong' && record.status !== 'DaHuy') {
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

    function loadDataToTable(page, minNgayTao, maxNgayTao, trangThai) {
        clearTable();

        if (!minNgayTao) {
            minNgayTao = null;
        }
        if (!maxNgayTao) {
            maxNgayTao = null;
        }

        $.ajax({
            type: "GET",
            url: "http://localhost:8080/Order/Admin",
            headers: {
                'Authorization': 'Bearer ' + localStorage.getItem('token') // Thay 'yourTokenKey' bằng khóa lưu token của bạn
            },
            data: {
                pageNumber: page,
                from: minNgayTao,
                to: maxNgayTao,
                status: trangThai,
            },
            success: function(response) {
                renderTableBody(response);
                renderPagination(response.totalPages, page);
            },
            error: function(error) {
                console.error('Error:', error);
            }
        });

    }

    function renderPagination(totalPages, currentPage) {
        var pagination = document.getElementById("pagination");
        var html = '';

        // Previous button
        if (currentPage > 1) {
            html += '<button class="pageButton" onclick="loadDataToTable(' + (currentPage - 1) + ', udminNgayTao, udmaxNgayTao, udtrangThai)">Trước</button>';
        }

        // Page numbers
        for (var i = 1; i <= totalPages; i++) {
            if (i === currentPage) {
                html += '<button class="pageButton active">' + i + '</button>';
            } else {
                html += '<button class="pageButton" onclick="loadDataToTable(' + i + ', udminNgayTao, udmaxNgayTao, udtrangThai)">' + i + '</button>';
            }
        }

        // Next button
        if (currentPage < totalPages) {
            html += '<button class="pageButton" onclick="loadDataToTable(' + (currentPage + 1) + ', udminNgayTao, udmaxNgayTao, udtrangThai)">Sau</button>';
        }

        pagination.innerHTML = html;
    }

    
</script>

</html>
