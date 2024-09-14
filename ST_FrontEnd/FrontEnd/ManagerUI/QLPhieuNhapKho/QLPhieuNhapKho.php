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

                        <!-- Từ ngày -->
                        <div>
                          <label>
                            <span style="font-size: 1.3rem; font-weight: 700">Từ Ngày :</span>
                            <input class="input datesearch" name="toDate" style="width: 20rem" type="date" />
                          </label>
                        </div>

                        <!-- Đến ngày -->
                        <div>
                          <label>
                            <span style="font-size: 1.3rem; font-weight: 700">Đến Ngày :</span>
                            <input class="input datesearch" name="fromDate" style="width: 20rem" type="date" />
                          </label>
                        </div>

                        <!-- Tìm kiếm -->
                        <div>
                          <label>
                            <span style="font-size: 1.3rem; font-weight: 700">Tìm kiếm :</span>
                            <input class="input datesearch" name="search" style="width: 20rem" type="text" />
                          </label>
                        </div>

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
    function getAllphieunhapkho(page, dateFrom, dateTo, searchTerm) {
      const token = sessionStorage.getItem("token");

      // Tạo object `data` và chỉ thêm các trường nếu chúng có giá trị
      let data = {
        pageNumber: page
      };

      if (dateFrom) {
        data.form = dateFrom; // Chỉ thêm vào nếu có dateFrom
      }

      if (dateTo) {
        data.to = dateTo; // Chỉ thêm vào nếu có dateTo
      }

      if (searchTerm) {
        data.search = searchTerm; // Chỉ thêm vào nếu có searchTerm
      }

      $.ajax({
        url: 'http://localhost:8080/InventoryReport',
        type: 'GET',
        dataType: "json",
        data: data, // Truyền object data đã được kiểm tra
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

            // Định dạng lại chuỗi ngày giờ
            var ngayNhapKhoFormatted = date.toLocaleTimeString('vi-VN') + ' ' + date.toLocaleDateString('vi-VN');

            var formattedTongGiaTri = formatCurrency(record['totalPrice']);

            var trContent = `
          <form id="updateForm_${record['id']}" method="post" action="taoPhieuNhapKho.php?MaPhieu=${record['id']}">
            <tr>
              <td class="Table_data" style="width: 130px;">${record['id']}</td>
              <td class="Table_data">${ngayNhapKhoFormatted}</td>
              <td class="Table_data">${record['supplier']}</td>
              <td class="Table_data">${record['supplierPhone']}</td>
              <td class="Table_data">${formattedTongGiaTri}</td>
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
          createPagination(page, response.totalPages, dateFrom, dateTo, searchTerm);
        },
        error: function(xhr, status, error) {
          console.error('Lỗi khi gọi API: ', error);
        }
      });
    }


    // Hàm để gọi getAllphieunhapkho và cập nhật dữ liệu và phân trang
    function fetchDataAndUpdateTable(page, dateFrom, dateTo, searchTerm) {
      //Clear dữ liệu cũ
      clearTable();
      // Gọi hàm getAllphieunhapkho và truyền các giá trị tương ứng
      getAllphieunhapkho(page, dateFrom, dateTo, searchTerm);
    }

    function update(MaPhieu) {
      // Lấy ra form bằng id của nó
      var form = document.querySelector(`#updateForm_${MaPhieu}`);

      // Gửi form đi
      form.submit();
    }

    function createPagination(currentPage, totalPages, dateFrom, dateTo, searchTerm) {
      var paginationContainer = document.querySelector('.pagination');

      // Xóa nút phân trang cũ (nếu có)
      paginationContainer.innerHTML = '';

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
            // Gọi hàm fetchDataAndUpdateTable với số trang mới và các giá trị input
            fetchDataAndUpdateTable(pageNumber, dateFrom, dateTo, searchTerm);
          });
        });

        // Đánh dấu trang hiện tại
        paginationContainer.querySelector('.pageButton[data-page="' + currentPage + '"]').classList.add('active');
      }
    }

    // Sự kiện DOMContentLoaded
    document.addEventListener('DOMContentLoaded', function() {
      var dateFromInput = document.querySelector('input[type="date"][name="fromDate"]');
      var dateToInput = document.querySelector('input[type="date"][name="toDate"]');
      var searchInput = document.querySelector('input[type="text"][name="search"]');

      function handleInputChange() {
        var dateFrom = dateFromInput.value;
        var dateTo = dateToInput.value;
        var searchTerm = searchInput.value;

        fetchDataAndUpdateTable(1, dateFrom, dateTo, searchTerm);
      }

      // Thêm sự kiện 'change' cho các input
      dateFromInput.addEventListener('change', handleInputChange);
      dateToInput.addEventListener('change', handleInputChange);
      searchInput.addEventListener('input', handleInputChange);

      // Khởi tạo trang đầu tiên
      fetchDataAndUpdateTable(1, '', '', '');
    });
  </script>