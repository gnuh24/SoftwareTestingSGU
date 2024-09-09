<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  <link rel="stylesheet" href="../AdminDemo.css" />
  <link rel="stylesheet" href="../QLLoaiSanPham/QLLoaiSanPham.css" />
  <title>Quản lý loại sản phẩm</title>
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
                      <h2>Loại Sản Phẩm</h2>
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
                          ">
                        <a href="./FromCreateLoaiSanPham.php"> Thêm Loại Sản Phẩm</a>
                      </button>
                    </div>
                    <br>
                    <div class="boxFeature">
                      <div style="position: relative">
                        <i class="fa fa-search"></i>
                        <input class="Admin_input__LtEE-" placeholder="Tìm kiếm loại sản phẩm" />
                        <button id="searchButton" style="cursor: pointer;"><i class="fa fa-search"></i></button>
                      </div>


                      <div style="margin-left: auto"></div>
                    </div>
                    <br>
                    <div class="boxTable">
                      <table class="Table_table__BWPy">
                        <thead class="Table_head__FTUog">
                          <tr>
                            <th class="Table_th__hCkcg" scope="col">Mã loại sản phẩm</th>
                            <th class="Table_th__hCkcg" scope="col">Loại sản phẩm</th>
                            <th class="Table_th__hCkcg" scope="col">Xoá</th>
                          </tr>
                        </thead>
                        <tbody id="tableBody">

                        </tbody>
                      </table>
                    </div>
                    <div class="pagination">
                      <?php
                      for ($i = 1; $i <= $totalPage; $i++) {
                        echo '<button class="pageButton" onclick="fetchDataAndUpdateTable(' . $i . ')">' . $i . '</button>';
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
    </div>
  </div>
</body>

</html>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> <!-- Thêm thư viện SweetAlert2 -->

<script>

  // Hàm để xóa hết các dòng trong bảng
  function clearTable() {
    var tableBody = document.querySelector('.Table_table__BWPy tbody');
    tableBody.innerHTML = ''; // Xóa nội dung trong tbody
  }

  // Hàm getAllLoaiSanPham
  function getAllLoaiSanPham(page, search) {
    // Lấy token JWT từ localStorage
    var token = localStorage.getItem('token');
    console.log(2222);
    $.ajax({   
      url: "http://localhost:8080/Category",
      type: "GET",
      dataType: "json",
      headers: {
        // Thêm JWT vào header
        'Authorization': 'Bearer ' + token
      },
      data: {
        page: page,
        search: search
      },
      success: function(response) {
        var data = response.data;
        console.log(response);
        var tableBody = document.getElementById("tableBody"); // Lấy thẻ tbody của bảng
        var tableContent = ""; // Chuỗi chứa nội dung mới của tbody

        // Duyệt qua mảng dữ liệu và tạo các hàng mới cho tbody
        
        // Tạo biến lưu trữ nội dung HTML mới
        var htmlContent = '';
        $.each(response.content, function(index, record) {
          console.log(response.content); // Kiểm tra xem có dữ liệu trả về đúng không
          var htmlContent = `
                <tr>
                    <td style="text-align:center">${record.id}</td>
                    <td style="text-align:center">${record.categoryName}</td>
                    <td style="text-align:center">`;

            // Kiểm tra nếu là Loại sản phẩm có ID là 1, thì in ra chữ "Mặc định"
            if (record.Id == 1) {
                htmlContent += `Mặc định`;
            } else {
                // Nếu không phải Loại sản phẩm có ID là 1, thì in ra nút sửa và nút xoá
                htmlContent += `
                    <button style="cursor:pointer" class="edit" onclick="updateLoaiSanPham(${record.Id}, '${record.CategoryName}')">Sửa</button>
                    <button style="cursor:pointer" class="delete" onclick="deleteLoaiSanPham(${record.Id}, '${record.CategoryName}')">Xoá</button>`;
            }

            htmlContent += `</td>
                </tr>`;
console.log(1111);
            tableContent += htmlContent; // Thêm nội dung của hàng vào chuỗi tableContent
        });
     

        // Thiết lập lại nội dung của tbody bằng chuỗi tableContent
        tableBody.innerHTML = tableContent;

        // Tạo phân trang
        createPagination(page, response.totalPages);
      },

      error: function(xhr, status, error) {
        // Nếu lỗi là do token hết hạn, chuyển hướng đến trang đăng nhập
        if (xhr.status === 401) {
          alert('Phiên đăng nhập của bạn đã hết hạn. Vui lòng đăng nhập lại.');
          window.location.href = '/login'; // Chuyển hướng đến trang đăng nhập
        } else {
          console.error('Lỗi khi gọi API: ', error);
        }
      }
    });
  }


  // Hàm để gọi getAllNhaCungCap và cập nhật dữ liệu và phân trang
  function fetchDataAndUpdateTable(page, search) {
    //Clear dữ liệu cũ
    clearTable();

    // Gọi hàm getAllTaiKhoan và truyền các giá trị tương ứng
    getAllLoaiSanPham(page, search);

    // Tạo phân trang
    createPagination(page);
  }

  // Khởi tạo trang hiện tại
  var currentPage = 1;
  fetchDataAndUpdateTable(currentPage, '');

  
  // Hàm tạo nút phân trang
  function createPagination(currentPage, totalPages) {
        var paginationContainer = document.querySelector('.pagination');
        var searchValue = document.querySelector('.Admin_input__LtEE-').value;

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
                    // Gọi hàm fetchDataAndUpdateTable khi người dùng click vào nút phân trang
                    fetchDataAndUpdateTable(index + 1, searchValue); // Thêm 1 vào index để chuyển đổi về trang 1-indexed
                });
            });

            // Đánh dấu trang hiện tại
            paginationContainer.querySelector('.pageButton:nth-child(' + currentPage + ')').classList.add('active'); // Sửa lại để chỉ chọn trang hiện tại
        }
    }



  // Hàm xử lý sự kiện khi nút tìm kiếm được click
  document.getElementById('searchButton').addEventListener('click', function() {
    var searchValue = document.querySelector('.Admin_input__LtEE-').value;

    // Truyền giá trị của biến currentPage vào hàm fetchDataAndUpdateTable
    fetchDataAndUpdateTable(currentPage, searchValue, '');
  });

  // Bắt sự kiện khi người dùng ấn phím Enter trong ô tìm kiếm
  document.querySelector('.Admin_input__LtEE-').addEventListener('keypress', function(event) {
    // Kiểm tra xem phím được ấn có phải là Enter không (mã phím 13)
    if (event.key === 'Enter') {
      // Ngăn chặn hành động mặc định của phím Enter (ví dụ: gửi form)
      event.preventDefault();

      // Lấy giá trị của ô tìm kiếm và của select quyền
      var searchValue = this.value;

      // Truyền giá trị của biến currentPage vào hàm fetchDataAndUpdateTable
      fetchDataAndUpdateTable(currentPage, searchValue);
    }
  });

  function deleteLoaiSanPham(Id, CategoryName) {
    // Sử dụng SweetAlert2 thay vì hộp thoại confirm
    Swal.fire({
      title: `Bạn có muốn xóa ${CategoryName} không?`,
      icon: 'question',
      showCancelButton: true,
      confirmButtonText: 'Đồng ý',
      cancelButtonText: 'Hủy'
    }).then((result) => {
      if (result.isConfirmed) {
        // Gọi Ajax để xóa loại sản phẩm
        $.ajax({
          url: 'http://localhost:8080/Category',
          type: 'GET',
          dataType: "json",
          data: {
            Id: Id
          },
          success: function(response) {
            console.log('Status:', response.status); // In mã trạng thái
            console.log('Message:', response.message); // In thông báo
            console.log('Id:', Id);

            if (response.status === 200) {
              // Hiển thị thông báo thành công bằng SweetAlert2
              Swal.fire('Thành công!', 'Xóa loại sản phẩm thành công !!', 'success');
              fetchDataAndUpdateTable(currentPage, ''); // Cập nhật bảng sau khi xóa
            } else {
              console.error('Lỗi khi xóa loại sản phẩm: ', response.message);
            }
          },
          error: function(xhr, status, error) {
            console.error('Lỗi khi gọi API: ', xhr, status, error);
          }
        });
      }
    });
  }

  function updateLoaiSanPham(Id, CategoryName) {
    
    // Lấy ra form bằng id của nó
    var form = document.querySelector("#updateForm");
    
    form.action = `FormUpdateLoaiSanPham.php?Id=${Id}&CategoryName=${CategoryName}`
    console.log(33333);
    // Gửi form đi
    form.submit();

  }
</script>
