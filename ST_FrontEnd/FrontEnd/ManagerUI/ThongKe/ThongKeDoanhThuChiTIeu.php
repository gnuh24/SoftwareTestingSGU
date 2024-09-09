<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../AdminDemo.css" />
    <link rel="stylesheet" href="ThongKeDonHang.css" />
    <link rel="stylesheet" href="ThongKeTaiChinh.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />

    <title>Thống kê sản phẩm bán chạy</title>
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
                                            <h2>Thống kê sản phẩm bán chạy</h2>
                                        </div>
                                        <div class="boxFeature">
                                            <span class="text">Ngày Bắt Đầu</span>
                                            <input id="from" type="date" style="height: 3rem; padding: 0.3rem;">
                                            <span class="text">Ngày Kết Thúc</span>
                                            <input id="to" type="date" style="height: 3rem; padding: 0.3rem;">
                                            
                                            <select id="topProductsSelect" style="height: 100%">
                                                <option value="10">Top 10</option>
                                                <option value="20">Top 20</option>
                                                <option value="50">Top 50</option>
                                                <option value="100">Top 100</option>
                                            </select>
                                            
                                            <div id="thongKeButton" style="display: flex; justify-content: center; align-items: center; width: 50px; height: 3rem; padding: 0.3rem; color: white; font-weight: 700; background-color: white;"><i style="color: black; font-size: 20px;" class="fa-solid fa-magnifying-glass"></i></div>
                                            <div id="resetButton" style="display: flex; justify-content: center; align-items: center; width: 50px; height: 3rem; padding: 0.3rem; color: white; font-weight: 700; background-color: white;"><i style="color: black; font-size: 20px;" class="fa-solid fa-rotate-right"></i></div>

                                            <p style="font-size: 1.3rem; margin-left: auto; color: rgb(100, 100, 100); font-weight: 700;">
                                                Mặc định được thống kê từ ngày 01/01/2010
                                            </p>
                                        </div>
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
<script>
    const resetButton = document.getElementById("resetButton");
    const thongKeButton = document.getElementById("thongKeButton");
    const from = document.getElementById("from");
    const to = document.getElementById("to");
    const limit = document.getElementById('topProductsSelect'); // Đổi tên biến ở đây

    thongKeButton.addEventListener("click", () => {
        let fromValue = from.value !== "" ? from.value : "2010-01-01";
        let toValue = to.value !== "" ? to.value : formattedDate;  
        let topCount = limit.value; // Đổi tên biến ở đây

        thongKeSanPhamBanChay(fromValue, toValue, topCount); // Gọi hàm để lấy dữ liệu sản phẩm
    });

    resetButton.addEventListener("click", () => {
        from.value = "";
        to.value = "";
        thongKeSanPhamBanChay("2010-01-01", formattedDate, 10);
    });

    var currentDate = new Date();
    var year = currentDate.getFullYear();
    var month = (currentDate.getMonth() + 1).toString().padStart(2, '0');
    var day = currentDate.getDate().toString().padStart(2, '0');
    var formattedDate = year + '-' + month + '-' + day;

    thongKeSanPhamBanChay("2010-01-01", formattedDate, 10);

    function thongKeSanPhamBanChay(from, to, topCount) {
        $.ajax({
            url: 'http://localhost:8080/Statistic/BestSeller', // Cập nhật URL API
            type: 'GET',
            dataType: "json",
            data: {
                minDate: from,
                maxDate: to,
                limit: topCount,

            },
            headers: {
                    'Authorization': 'Bearer ' + localStorage.getItem('token') // Thay 'yourTokenKey' bằng khóa lưu token của bạn
                },
            success: function(response) {
                var tableBody = document.querySelector("#sanPhamBanChayTable tbody");
                tableBody.innerHTML = ""; // Clear existing rows

                response.forEach(item => {
                    var row = document.createElement("tr");
                    row.innerHTML = `
                        <td>${item.productId}</td>
                        <td>${item.productName}</td>
                        <td>${item.quantity}</td>
                        <td>${item.total}</td>
                    `;
                    tableBody.appendChild(row);
                });
            },
            error: function(xhr, status, error) {
                console.error('Lỗi khi gọi API: ', error);
            }
        });
    }
</script>

</html>
