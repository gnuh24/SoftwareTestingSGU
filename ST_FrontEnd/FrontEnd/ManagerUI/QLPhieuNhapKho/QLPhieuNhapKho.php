  <!DOCTYPE html>
  <html lang="en">

  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../AdminDemo.css" />
    <link rel="stylesheet" href="QLPhieuNhapKho.css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <title>Quản lý đơn hàng</title>
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
                      <div style="
                            display: flex;
                            padding-top: 1rem;
                            padding-bottom: 1rem;
                          ">
                        <h2>Phiếu Nhập Kho</h2>
                        <button style="
                              margin-left: auto;
                              font-family: Arial;
                              font-size: 1.5rem;
                              font-weight: 700;
                              color: white;
                              background-color: rgb(65, 64, 64);
                              padding: 1rem;
                              border-radius: 0.6rem;
                              cursor: pointer;
                            "><a href="taoPhieuNhapKho.php">Tạo Phiếu Nhập</a>
                        </button>
                      </div>
                      <div class="boxFeature">
                        <div>
                          <label>
                            <span style="font-size: 1.3rem; font-weight: 700">Đơn Trong Tháng :
                            </span>
                            <input class="input datesearch" style="width: 20rem" type="month" />
                          </label>
                        </div>
                        <div style="margin-left: auto"></div>
                      </div>
                      <div class="Admin_boxTable__hLXRJ">
                        <table class="Table_table__BWPy">
                          <thead class="Table_head__FTUog">
                            <tr>
                              <th class="Table_th__hCkcg">Mã Phiếu</th>
                              <th class="Table_th__hCkcg">Ngày Nhập Kho</th>
                              <th class="Table_th__hCkcg">Tên Nhà Cung Cấp</th>
                              <th class="Table_th__hCkcg">Tên Người Quản Lý</th>
                              <th class="Table_th__hCkcg"> Tổng Giá Trị</th>
                              <th class="Table_th__hCkcg"> Trạng thái</th>
                              <th class="Table_th__hCkcg">Thao Tác</th>
                            </tr>
                          </thead>
                          <tbody id="tableBody">
                            <!-- Các hàng dữ liệu sẽ được thêm ở đây -->

                          </tbody>
                        </table>
                        <div class="pagination">

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

  </html>
  <script>
    // Hàm để xóa hết các dòng trong bảng
    function clearTable() {
      var tableBody = document.querySelector('#tableBody');
      tableBody.innerHTML = ''; // Xóa nội dung trong tbody
    }

    function formatCurrency(number) {
      // Chuyển đổi số thành chuỗi và đảm bảo nó là số nguyên
      number = parseInt(number);

      // Sử dụng hàm toLocaleString() để định dạng số tiền
      // và thêm đơn vị tiền tệ "đ" vào cuối chuỗi
      return number.toLocaleString('vi-VN', {
        style: 'currency',
        currency: 'VND'
      });
    }
    // Hàm getAllphieunhapkho
    function getAllphieunhapkho(page, datenhapkho) {
      const token = sessionStorage.getItem("token");

      $.ajax({
        url: 'http://localhost:8080/InventoryReport',
        type: 'GET',
        dataType: "json",
        data: {
          pageNumber: page
        },
        headers: {
          'Authorization': 'Bearer ' + token
        },
        success: function(response) {
          var data = response.content;
          var tableBody = document.getElementById("tableBody"); // Lấy thẻ tbody của bảng
          var tableContent = ""; // Chuỗi chứa nội dung mới của tbody
          // Duyệt qua mảng dữ liệu và tạo các hàng mới cho tbody
          data.forEach(function(record) {
            var ngayNhapKho = record['createTime'];

            // Chuyển đổi ngày nhập kho sang đối tượng Date
            var date = new Date(ngayNhapKho);

            // Lấy các thành phần của ngày nhập kho (giờ, phút, giây, ngày, tháng, năm)
            var gio = date.getHours();
            var phut = date.getMinutes();
            var giay = date.getSeconds();
            var ngay = date.getDate();
            var thang = date.getMonth() + 1; // Tháng trong JavaScript đếm từ 0, nên cần cộng thêm 1
            var nam = date.getFullYear();
            // Định dạng lại chuỗi ngày giờ
            var ngayNhapKhoFormatted = gio + ":" + phut + ":" + giay + " " + ngay + "/" + thang + "/" + nam;

            var formattedTongGiaTri = formatCurrency(record['totalPrice'])
            var trangthai = "";

            if (record['status'] === 'DaNhapKho')
              trangthai = "Đã nhập kho";
            else if (record['status'] === 'ChoNhapKho')
              trangthai = "Chờ nhập kho";
            else
              trangthai = "Hủy";

            var trContent = `
                    <form id="updateForm_${record['id']}" method="post" action="taoPhieuNhapKho.php?MaPhieu=${record['id']}">
                        <tr>
                            <td class="Table_data" style="width: 130px;">${record['id']}</td>
                            <td class="Table_data">${ngayNhapKhoFormatted}</td>
                            <td class="Table_data">${record['supplier']}</td>
                            <td class="Table_data">${record['supplierPhone']}</td>
                            <td class="Table_data">${formattedTongGiaTri}</td>
                            <td class="Table_data">${trangthai}</td>
                            <td class="Table_data">
                                <button class="edit" onclick="update(${record['id']})">Xem chi tiết</button>
                            </td>
                        </tr>
                    </form>
                `;

            tableContent += trContent; // Thêm nội dung của hàng vào chuỗi tableContent
          });

          // Thiết lập lại nội dung của tbody bằng chuỗi tableContent
          tableBody.innerHTML = tableContent;
          // Tạo phân trang
          console.log(response.totalPages);
          createPagination(page, response.totalPages);
        },
        error: function(xhr, status, error) {
          console.error('Lỗi khi gọi API: ', error);
        }
      });
    }


    // Hàm để gọi getAllphieunhapkho và cập nhật dữ liệu và phân trang
    function fetchDataAndUpdateTable(page, datenhapkho) {
      //Clear dữ liệu cũ
      clearTable();
      // Gọi hàm getAllphieunhapkho và truyền các giá trị tương ứng
      getAllphieunhapkho(page, datenhapkho);
    }

    function update(MaPhieu) {
      // Lấy ra form bằng id của nó
      var form = document.querySelector(`#updateForm_${MaPhieu}`);

      // Gửi form đi
      form.submit();
    }

    function createPagination(currentPage, totalPages) {
      var paginationContainer = document.querySelector('.pagination');
      var date = document.querySelector('.datesearch').value;

      // Xóa nút phân trang cũ (nếu có)
      paginationContainer.innerHTML = '';

      // Tạo nút cho từng trang và thêm vào chuỗi HTML
      if (totalPages > 1) {
        // Tạo nút cho từng trang và thêm vào chuỗi HTML
        var paginationHTML = '';
        for (var i = 1; i <= totalPages; i++) {
          paginationHTML += '<button class="pageButton" data-page="' + i + '">' + i + '</button>';
        }

        // Thiết lập nút phân trang vào paginationContainer
        paginationContainer.innerHTML = paginationHTML;

        // Thêm sự kiện click cho từng nút phân trang
        paginationContainer.querySelectorAll('.pageButton').forEach(function(button) {
          button.addEventListener('click', function() {
            // Lấy số trang từ thuộc tính data-page của nút được nhấn
            var pageNumber = parseInt(this.getAttribute('data-page'));
            // Gọi hàm fetchDataAndUpdateTable với số trang mới
            fetchDataAndUpdateTable(pageNumber, date);
          });
        });

        // Đánh dấu trang hiện tại
        paginationContainer.querySelector('.pageButton[data-page="' + currentPage + '"]').classList.add('active');
      }
    }

    // Sự kiện DOMContentLoaded
    document.addEventListener('DOMContentLoaded', function() {
      // Lấy thẻ input
      var inputElement = document.querySelector('.datesearch');

      // Thêm sự kiện 'change' vào input
      inputElement.addEventListener('change', function(event) {
        // Lấy giá trị mới của input khi nó thay đổi
        var newValue = event.target.value;

        // Kiểm tra xem input có giá trị hay không
        if (newValue) {
          // Gọi hàm fetchDataAndUpdateTable với trang đầu tiên và giá trị mới của input
          fetchDataAndUpdateTable(1, newValue);
        } else {
          // Nếu input không có giá trị, gán giá trị rỗng cho date
          var date = '';
          // Gọi lại hàm fetchDataAndUpdateTable với trang đầu tiên và giá trị date rỗng
          fetchDataAndUpdateTable(1, date);
        }
      });

      // Khởi tạo trang hiện tại
      var currentPage = 1;
      fetchDataAndUpdateTable(currentPage, null);
    });
  </script>