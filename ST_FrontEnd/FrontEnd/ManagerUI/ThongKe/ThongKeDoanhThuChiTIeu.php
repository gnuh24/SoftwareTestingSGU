<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../AdminDemo.css" />
    <link rel="stylesheet" href="ThongKeDonHang.css" />
    <link rel="stylesheet" href="ThongKeTaiChinh.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />

    <title>Thống kê doanh thu, chi tiêu</title>
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
                                                <h2>Thống kê tài chính</h2>
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
                                            <div class="boxTable1">
                                                
                                            </div>
                                            <hr>

                                            <div class="boxTable2">
                                                
                                            </div>
                                            <hr>

                                            <div class="boxTable3">
                                                <h1 id="title">THỐNG KÊ SẢN PHẨM BÁN CHẠY</h1>
                                                <table id="sanPhamBanChayTable">
                                                    <thead>
                                                        <th>Mã sản phẩm</th>
                                                        <th>Tên sản phẩm</th>
                                                        <th>Tổng số lượng</th>
                                                        <th style="border-right: 0px">Tổng giá trị</th>
                                                    </thead>
                                                    <tbody>

                                                    </tbody>
                                                </table>
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>

        const resetButton = document.getElementById("resetButton");
        const thongKeButton = document.getElementById("thongKeButton");
        const from = document.getElementById("from");
        const to = document.getElementById("to");

        thongKeButton.addEventListener("click", () => {
            fromValue = from.value !== "" ? from.value : "2010-01-01";
            toValue = to.value !== "" ? to.value : formattedDate;  

            // Gọi thongKeDoanhThu và thongKeChiTieu
            thongKeDoanhThu(fromValue, toValue, function(dataDoanhThu) {
                    thongKeChiTieu(fromValue, toValue, function(dataChiTieu) {
                            // Tại đây, cả hai cuộc gọi AJAX đã hoàn tất và bạn có thể thực hiện các hàm khác
                            fetchTable(dataDoanhThu, dataChiTieu);
                            // Hoặc bất kỳ hành động nào khác bạn muốn thực hiện
                    });
            });
            thongKeSanPhamBanChay(fromValue, toValue);

        });


        resetButton.addEventListener("click", () => {
            from.value = "";
            to.value = "";
            // Gọi thongKeDoanhThu và thongKeChiTieu
            thongKeDoanhThu("2010-01-01", formattedDate, function(dataDoanhThu) {
                    thongKeChiTieu("2010-01-01", formattedDate, function(dataChiTieu) {
                            // Tại đây, cả hai cuộc gọi AJAX đã hoàn tất và bạn có thể thực hiện các hàm khác
                            fetchTable(dataDoanhThu, dataChiTieu);
                            // Hoặc bất kỳ hành động nào khác bạn muốn thực hiện
                    });
            });
            thongKeSanPhamBanChay("2010-01-01", formattedDate);
        })  

        var currentDate = new Date();

        var year = currentDate.getFullYear();
        var month = (currentDate.getMonth() + 1).toString().padStart(2, '0'); // Thêm số 0 phía trước nếu cần
        var day = currentDate.getDate().toString().padStart(2, '0'); // Thêm số 0 phía trước nếu cần

        var formattedDate = year + '-' + month + '-' + day;

        // Gọi thongKeDoanhThu và thongKeChiTieu
        thongKeDoanhThu("2010-01-01", formattedDate, function(dataDoanhThu) {
                thongKeChiTieu("2010-01-01", formattedDate, function(dataChiTieu) {
                        // Tại đây, cả hai cuộc gọi AJAX đã hoàn tất và bạn có thể thực hiện các hàm khác
                        fetchTable(dataDoanhThu, dataChiTieu);
                        // Hoặc bất kỳ hành động nào khác bạn muốn thực hiện
                });
        });


        thongKeSanPhamBanChay("2010-01-01", formattedDate);

        function fetchTable(thongKeDoanhThu, thongKeChiTieu) {

            // Thực hiện các phép tính thống kê dữ liệu ở đây, hoặc bạn có thể truyền các biến đã tính sẵn vào hàm này.
            var totalChiTieu = 0; 
            var totalSanPhamNhap = 0; 
            var totalDoanhThu = 0; 
            var totalSanPhamBan = 0; 

            var mapLabelsDoanhThu = new Map();
            var mapLabelsChiTieu = new Map();

            var mapLabelsSanPhamBan = new Map();
            var mapLabelsSanPhamNhap = new Map();


            var labels = [];
            var dataChiTieu = [];
            var dataSanPhamNhap = [];
            var dataDoanhThu = [];
            var dataSanPhamBan = [];

            // Duyệt qua từng phần tử trong mảng thongKeDoanhThu
            thongKeDoanhThu.forEach(function(item) {
                

               labels.push(item.NgayThongKe);

               totalDoanhThu += parseInt(item.DoanhThu);
               totalSanPhamBan += parseInt(item.SoLuongDaBan);

               mapLabelsDoanhThu.set(item.NgayThongKe, item.DoanhThu);
               mapLabelsSanPhamBan.set(item.NgayThongKe, item.SoLuongDaBan);

 
            });


                // Duyệt qua từng phần tử trong mảng thongKeDoanhThu
                thongKeChiTieu.forEach(function(item) {
                        labels.push(item.NgayNhap);

                        totalChiTieu += parseInt(item.ChiTieu);
                        totalSanPhamNhap += parseInt(item.SoLuongDaNhap);

                        mapLabelsChiTieu.set(item.NgayNhap, item.ChiTieu);
                        mapLabelsSanPhamNhap.set(item.NgayNhap, item.SoLuongDaNhap);
                });

                labels.sort(function(a, b) {
                        return new Date(a) - new Date(b);
                });
                
                var uniqueLabels = [...new Set(labels)];

                uniqueLabels.forEach(function(time) {
                    
                    dataDoanhThu.push( mapLabelsDoanhThu.has(time) ? mapLabelsDoanhThu.get(time) : 0);
                    dataChiTieu.push( mapLabelsChiTieu.has(time) ? mapLabelsChiTieu.get(time) : 0);

                    dataSanPhamBan.push( mapLabelsSanPhamBan.has(time) ? mapLabelsSanPhamBan.get(time) : 0);
                    dataSanPhamNhap.push( mapLabelsSanPhamNhap.has(time) ? mapLabelsSanPhamNhap.get(time) : 0);

                });


                
            var boxTable = document.querySelector('.boxTable1');
            var boxTable2 = document.querySelector('.boxTable2');

            function formatCurrency(amount) {
                // Sử dụng hàm toLocaleString để chuyển đổi số thành định dạng tiền tệ với đơn vị tiền tệ mặc định của trình duyệt
                return amount.toLocaleString('vi-VN', { style: 'currency', currency: 'VND' });
            }
            // Tạo các phần tử HTML và thêm nội dung vào
            var htmlContent = `
                <div style="display: flex; gap: 1.5rem;">
                    <div style="display: flex; align-items: center; gap: 1rem; background-color: #e91e63; width: 60rem; padding: 1rem;">
                        <div>
                            <p style="color: white; font-weight: 700;">Tổng chi tiêu</p>
                            <p style="color: white; font-weight: 700; font-size: 2.5rem;">${formatCurrency(totalChiTieu)}</p>
                        </div>
                    </div>
                    <div style="display: flex; align-items: center; gap: 1rem; background-color: #8bc34a; width: 60rem; padding: 1rem;">
                        <div>
                            <p style="color: white; font-weight: 700;">Tổng doanh thu</p>
                            <p style="color: white; font-weight: 700; font-size: 2.5rem;">${formatCurrency(totalDoanhThu)}</p>
                        </div>
                    </div>
                </div>
                <div>
                        <canvas id="myChart1" width="400" height="120" margin-bottom: 40px;></canvas>
                </div>
            `;

            var htmlContent2 = ` 
            <div style="display: flex; gap: 1.5rem;">
                <div style="display: flex; align-items: center; gap: 1rem; background-color: #00bcd4; width: 60rem; padding: 1rem;">
                        <div>
                            <p style="color: white; font-weight: 700;">Tổng số sản phẩm nhập kho</p>
                            <p style="color: white; font-weight: 700; font-size: 2.5rem;">${totalSanPhamNhap}</p>
                        </div>
                    </div>
                    <div style="display: flex; align-items: center; gap: 1rem; background-color: #ff9800; width: 60rem; padding: 1rem;">
                        <div>
                            <p style="color: white; font-weight: 700;">Tổng số sản phẩm bán được</p>
                            <p style="color: white; font-weight: 700; font-size: 2.5rem;">${totalSanPhamBan}</p>
                        </div>
                    </div>
                </div>
                <div>
                        <canvas id="myChart2" width="400" height="120" margin-bottom: 40px;></canvas>
                </div>`
            
            // Thêm nội dung vào boxTable
            boxTable.innerHTML = htmlContent;
            boxTable2.innerHTML = htmlContent2;

            // Lấy tham chiếu đến thẻ canvas
            var ctx1 = document.getElementById('myChart1').getContext('2d');
            var ctx2 = document.getElementById('myChart2').getContext('2d');


            uniqueLabels = uniqueLabels.map(function(label) {
                return formatNgay(label);
            });

    
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
            var myChart = new Chart(ctx1,  {
                        type: 'line',
                        data: {
                            labels: uniqueLabels,
                            datasets: [
                                {
                                    label: 'Tổng chi tiêu',
                                    backgroundColor: 'rgb(255, 99, 132)',
                                    borderColor: 'rgb(255, 99, 132)',
                                    data: dataChiTieu
                                },
                                {
                                    label: 'Tổng doanh thu',
                                    backgroundColor: '#8bc34a',
                                    borderColor: '#8bc34a',
                                    data: dataDoanhThu
                                }
                            ]
                        },
                        options: options
            });
              // Tạo một biểu đồ đường mới
              var myChart = new Chart(ctx2,  {
                        type: 'line',
                        data: {
                            labels: uniqueLabels,
                            datasets: [
                                {
                                    label: 'Tổng số sản phẩm nhập kho',
                                    backgroundColor: '#00bcd4',
                                    borderColor: '#00bcd4',
                                    data: dataSanPhamNhap
                                },
                                {
                                    label: 'Tổng số sản phẩm bán được',
                                    backgroundColor: '#ff9800',
                                    borderColor: '#ff9800',
                                    data: dataSanPhamBan
                                }
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


        function thongKeDoanhThu(from, to, callback) {
            $.ajax({
                url: '../../../BackEnd/ManagerBE/ThongKeBE.php',
                type: 'GET',
                dataType: "json",
                data: {
                        from: from,
                        to: to,
                        thongKeDoanhThu: true
                },
                success: function(response) {
                        // Xử lý dữ liệu trả về từ API ở đây
                        callback(response.data); // Gọi callback và truyền dữ liệu cho nó
                },
                error: function(xhr, status, error) {
                        console.error('Lỗi khi gọi API: ', error);
                }
            });
        }

        function thongKeChiTieu(from, to, callback) {
            $.ajax({
                url: '../../../BackEnd/ManagerBE/ThongKeBE.php',
                type: 'GET',
                dataType: "json",
                data: {
                            from: from,
                            to: to,
                            thongKeChiTieu: true
                },
                success: function(response) {
                        // Xử lý dữ liệu trả về từ API ở đây
                        callback(response.data); // Gọi callback và truyền dữ liệu cho nó
                },
                error: function(xhr, status, error) {
                        console.error('Lỗi khi gọi API: ', error);
                }
            });
        }

        function thongKeSanPhamBanChay(from, to){
            $.ajax({
                url: '../../../BackEnd/ManagerBE/ThongKeBE.php',
                type: 'GET',
                dataType: "json",
                data: {
                    from: from,
                    to: to,
                    thongKeSanPhamBanChay: true
                },
                success: function(response) {
                    // Lấy thẻ tbody của bảng
                    var tbody = document.getElementById("sanPhamBanChayTable").getElementsByTagName('tbody')[0];
                    tbody.innerHTML = ""; // Xóa dữ liệu cũ trước khi thêm dữ liệu mới
                    
                    // Lặp qua dữ liệu từ API để tạo các dòng trong tbody của bảng
                    for (var i = 0; i < response.data.length; i++) {
                        var row = tbody.insertRow();
                        var cell1 = row.insertCell(0);
                        var cell2 = row.insertCell(1);
                        var cell3 = row.insertCell(2);
                        var cell4 = row.insertCell(3);
                        cell1.innerHTML = response.data[i].MaSanPham;
                        cell2.innerHTML = response.data[i].TenSanPham;
                        cell3.innerHTML = response.data[i].TongSoLuong;
                        cell4.innerHTML = formatCurrency(parseInt(response.data[i].TongDoanhThu));

                        if (i % 2 == 0){
                            cell1.style.backgroundColor = "whitesmoke";
                            cell2.style.backgroundColor = "whitesmoke";
                            cell3.style.backgroundColor = "whitesmoke";
                            cell4.style.backgroundColor = "whitesmoke";
                        }


                        cell1.style.borderRight = "2px solid black";
                        cell2.style.borderRight = "2px solid black";
                        cell3.style.borderRight = "2px solid black";
                        cell4.style.borderRight = "0px";

                        cell1.style.borderBottom = "2px solid black";
                        cell2.style.borderBottom = "2px solid black";
                        cell3.style.borderBottom = "2px solid black";
                        cell4.style.borderBottom = "2px solid black";

                    }
                },
                error: function(xhr, status, error) {
                    console.error('Lỗi khi gọi API: ', error);
                }
            });
        }
        function formatCurrency(amount) {
                // Sử dụng hàm toLocaleString để chuyển đổi số thành định dạng tiền tệ với đơn vị tiền tệ mặc định của trình duyệt
                return amount.toLocaleString('vi-VN', { style: 'currency', currency: 'VND' });
            }



       



       
  </script>
</html>
