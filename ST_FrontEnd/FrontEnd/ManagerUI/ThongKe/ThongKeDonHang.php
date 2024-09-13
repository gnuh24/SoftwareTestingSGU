<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../AdminDemo.css" />
    <link rel="stylesheet" href="ThongKeDonHang.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <title>Thống kê đơn hàng</title>
</head>

<body>
    <div id="root">
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
                                        <div style="display: flex; padding-top: 1rem; padding-bottom: 1rem;">
                                            <h2>Thống kê đơn hàng</h2>
                                        </div>
                                        <div class="boxFeature">
                                            <span class="text">Ngày Bắt Đầu</span>
                                            <input id="from" type="date" style="height: 3rem; padding: 0.3rem;">
                                            <span class="text">Ngày Kết Thúc</span>
                                            <input id="to" type="date" style="height: 3rem; padding: 0.3rem;">
                                            <div id="thongKeButton" style="display: flex; justify-content: center; align-items: center; width: 50px; height: 3rem; padding: 0.3rem; color: white; font-weight: 700; background-color: white;"><i style="color: black; font-size: 20px;" class="fa-solid fa-magnifying-glass"></i></div>
                                            <div id="resetButton" style="display: flex; justify-content: center; align-items: center; width: 50px; height: 3rem; padding: 0.3rem; color: white; font-weight: 700; background-color: white;"><i style="color: black; font-size: 20px;" class="fa-solid fa-rotate-right"></i></div>

                                            <p style="font-size: 1.3rem; margin-left: auto; color: rgb(100, 100, 100); font-weight: 700;">
                                                Mặc định được thống kê từ ngày 01/01/2010
                                            </p>

                                        </div>
                                        <div class="boxTable">

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
    const resetButton = document.getElementById("resetButton");
    const thongKeButton = document.getElementById("thongKeButton");
    const from = document.getElementById("from");
    const to = document.getElementById("to");

    thongKeButton.addEventListener("click", () => {
        fromValue = from.value !== "" ? from.value : "2010-01-01";
        toValue = to.value !== "" ? to.value : formattedDate;

        thongKeDonHang(fromValue, toValue);
    });


    resetButton.addEventListener("click", () => {
        from.value = "";
        to.value = "";
        thongKeDonHang("2010-01-01", formattedDate);
    })


    var currentDate = new Date();

    var year = currentDate.getFullYear();
    var month = (currentDate.getMonth() + 1).toString().padStart(2, '0'); // Thêm số 0 phía trước nếu cần
    var day = currentDate.getDate().toString().padStart(2, '0'); // Thêm số 0 phía trước nếu cần

    var formattedDate = year + '-' + month + '-' + day;

    thongKeDonHang("2010-01-01", formattedDate);

    function fetchTable(thongKe) {
        // Thực hiện các phép tính thống kê dữ liệu ở đây, hoặc bạn có thể truyền các biến đã tính sẵn vào hàm này.
        var totalHuy = 0;
        var totalChoDuyet = 0;
        var totalGiaoThanhCong = 0;
        var totalDonHang = 0;
        var totalDangGiao = 0;
        var totalDaDuyet = 0;

        var labels = [];
        var dataHuy = [];
        var dataChoDuyet = [];
        var dataGiaoThanhCong = [];
        var dataDonHang = [];
        var dataDangGiao = [];
        var dataDaDuyet = [];


        var tempHuy = 0;
        var tempChoDuyet = 0;
        var tempGiaoThanhCong = 0;
        var tempDonHang = 0;
        var tempDangGiao = 0;
        var tempDaDuyet = 0;

        // Duyệt qua từng phần tử trong mảng thongKe
        thongKe.forEach(function(item) {
            // Tính tổng số lượng đơn hàng
            totalDonHang += item.quantity;

            // Kiểm tra trạng thái của đơn hàng và cập nhật các tổng tương ứng
            switch (item.status) {
                case "Huy":
                    totalHuy += item.quantity;
                    break;
                case "ChoDuyet":
                    totalChoDuyet += item.quantity;
                    break;
                case "GiaoThanhCong":
                    totalGiaoThanhCong += item.quantity;
                    break;
                case "DangGiao":
                    totalDangGiao += item.quantity;
                    break;
                case "DaDuyet":
                    totalDaDuyet += item.quantity;
                    break;
            }

            // Chuyển đổi ngày tháng từ dạng yyyy-MM-dd sang dd/MM/yyyy
            var ngayFormatted = item.updateDate;

            //tempDonHang += item.quantity;


            if (labels.length === 0) {
                labels.push(ngayFormatted);
                tempDonHang += item.quantity;

                // Thêm số lượng đơn hàng vào các mảng dữ liệu tương ứng
                switch (item.status) {
                    case "Huy":
                        tempHuy += item.quantity;
                        break;
                    case "ChoDuyet":
                        tempChoDuyet += item.quantity;
                        break;
                    case "GiaoThanhCong":
                        tempGiaoThanhCong += item.quantity;
                        break;
                    case "DangGiao":
                        tempDangGiao += item.quantity;
                        break;
                    case "DaDuyet":
                        tempDaDuyet += item.quantity;
                        break;
                }

            } else {
                if (!labels.includes(ngayFormatted)) {
                    labels.push(ngayFormatted);
                    dataDonHang.push(tempDonHang);
                    dataHuy.push(tempHuy);
                    dataChoDuyet.push(tempChoDuyet);
                    dataGiaoThanhCong.push(tempGiaoThanhCong);
                    dataDangGiao.push(tempDangGiao);
                    dataDaDuyet.push(tempDaDuyet);

                    tempDonHang = 0;
                    tempHuy = 0;
                    tempChoDuyet = 0;
                    tempGiaoThanhCong = 0;
                    tempDangGiao = 0;
                    tempDaDuyet = 0;
                }

                tempDonHang += item.quantity;
                // Thêm số lượng đơn hàng vào các mảng dữ liệu tương ứng
                switch (item.status) {
                    case "Huy":
                        tempHuy += item.quantity;
                        break;
                    case "ChoDuyet":
                        tempChoDuyet += item.quantity;
                        break;
                    case "GiaoThanhCong":
                        tempGiaoThanhCong += item.quantity;
                        break;
                    case "DangGiao":
                        tempDangGiao += item.quantity;
                        break;
                    case "DaDuyet":
                        tempDaDuyet += item.quantity;
                        break;
                }


            }


        });

        dataDonHang.push(tempDonHang);
        dataHuy.push(tempHuy);
        dataChoDuyet.push(tempChoDuyet);
        dataGiaoThanhCong.push(tempGiaoThanhCong);
        dataDangGiao.push(tempDangGiao);
        dataDaDuyet.push(tempDaDuyet);


        var boxTable = document.querySelector('.boxTable');

        // Tạo các phần tử HTML và thêm nội dung vào
        var htmlContent = `
                <div style="display: flex; gap: 1.5rem;">
                <div class="dashboard-item canceled">
                    <div>
                        <p>Số đơn bị hủy</p>
                        <p>${totalHuy}</p>
                    </div>
                </div>
                <div class="dashboard-item waiting-approval">
                    <div>
                        <p>Số đơn chờ duyệt</p>
                        <p>${totalChoDuyet}</p>
                    </div>
                </div>
                <div class="dashboard-item approved">
                    <div>
                        <p>Số đơn đã duyệt</p>
                        <p>${totalDaDuyet}</p>
                    </div>
                </div>
                <div class="dashboard-item delivering">
                    <div>
                        <p>Số đơn đang giao</p>
                        <p>${totalDangGiao}</p>
                    </div>
                </div>
                <div class="dashboard-item delivered">
                    <div>
                        <p>Số đơn hoàn tất</p>
                        <p>${totalGiaoThanhCong}</p>
                    </div>
                </div>
                <div class="dashboard-item total">
                    <div>
                        <p>Tổng số đơn hàng</p>
                        <p>${totalDonHang}</p>
                    </div>
                </div>
                </div>
                <div>
                    <canvas id="myChart" width="400" height="120"></canvas>
                </div>
            `;

        // Thêm nội dung vào boxTable
        boxTable.innerHTML = htmlContent;

        // Lấy tham chiếu đến thẻ canvas
        var ctx = document.getElementById('myChart').getContext('2d');


        // Cấu hình các tùy chọn cho biểu đồ
        var options = {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        };

        // Tạo một biểu đồ đường mới
        var myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                        label: 'Số đơn bị hủy',
                        backgroundColor: 'rgb(255, 99, 132)',
                        borderColor: 'rgb(255, 99, 132)',
                        data: dataHuy
                    },
                    {
                        label: 'Số đơn chờ duyệt',
                        backgroundColor: '#00bcd4',
                        borderColor: '#00bcd4',
                        data: dataChoDuyet
                    },
                    {
                        label: 'Số đơn đã duyệt',
                        backgroundColor: '#8100ff',
                        borderColor: '#8100ff',
                        data: dataDaDuyet
                    },
                    {
                        label: 'Số đơn đang giao',
                        backgroundColor: '#ff9800',
                        borderColor: '#ff9800',
                        data: dataDangGiao
                    },
                    {
                        label: 'Số đơn giao thành công',
                        backgroundColor: '#8bc34a',
                        borderColor: '#8bc34a',
                        data: dataGiaoThanhCong
                    },

                    {
                        label: 'Tổng số đơn hàng',
                        backgroundColor: 'rgb(52, 51, 51)',
                        borderColor: 'rgb(52, 51, 51)',
                        data: dataDonHang
                    },



                ]
            },
            options: options
        });
    }

    // Hàm chuyển đổi ngày tháng từ yyyy-MM-dd sang dd/MM/yyyy
    function formatNgay(ngay) {
        var parts = ngay.split('-');
        return parts[2] + '/' + parts[1] + '/' + parts[0];
    }



    //Call API Thống kê đơn hàng
    function thongKeDonHang(from, to) {
        $.ajax({
            url: 'http://localhost:8080/Statistic/OrderStatus',
            type: 'GET',
            dataType: "json",
            headers: {
                'Authorization': 'Bearer ' + sessionStorage.getItem('token') // Thay 'yourTokenKey' bằng khóa lưu token của bạn
            },
            data: {
                minDate: formatNgay(from),
                maxDate: formatNgay(to),
            },
            success: function(response) {
                // Xử lý dữ liệu trả về từ API ở đây
                fetchTable(response);
            },
            error: function(xhr, status, error) {
                console.error('Lỗi khi gọi API: ', error);
            }
        });
    }
</script>

</html>