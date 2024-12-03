<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../AdminDemo.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <link rel="stylesheet" href="../QLNhaCungCap/QLNhaCungCap.css" />
    <title>Cập nhật loại sản phẩm</title>
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
                                <div style="padding-left: 3%; width: 100%; padding-right: 2rem">
                                    <div class="wrapper">
                                        <div style="display: flex; padding-top: 1rem; align-items: center; gap: 1rem; padding-bottom: 1rem;"></div>
                                        <form id="submit-form" method="post">
                                            <input type="hidden" name="action" value="updateSupplier">
                                            <div class="boxFeature">
                                                <div>
                                                    <h2 style="font-size: 2.3rem">Cập nhật thông tin loại sản phẩm</h2>
                                                </div>
                                                <div>
                                                    <a style="font-family: Arial; font-size: 1.5rem; font-weight: 700; border: 1px solid rgb(140, 140, 140); background-color: white; color: rgb(80, 80, 80); padding: 1rem 2rem 1rem 2rem; border-radius: 0.6rem; cursor: pointer;" href="./QLLoaiSanPham.php">Hủy</a>
                                                    <button id="updateLoaiSanPham_save" style="margin-left: 1rem; font-family: Arial; font-size: 1.5rem; font-weight: 700; color: white; background-color: rgb(65, 64, 64); padding: 1rem 2rem 1rem 2rem; border-radius: 0.6rem; cursor: pointer;">Lưu</button>
                                                </div>
                                            </div>
                                            <div class="boxTable">
                                                <div style="display: flex; padding: 0rem 1rem 0rem 1rem; justify-content: space-between;">
                                                    <div>
                                                        <?php

                                                        $id = "";
                                                        $categoryName =  "";

                                                        if (isset($_GET['id'])) {
                                                            // Lấy các tham số được gửi từ AJAX
                                                            $id = $_GET['id'];
                                                            $categoryName = $_GET['categoryName'];
                                                        }
                                                        echo '
                                                            <div style="padding-left: 1rem">

                                                                <div style="display: flex; gap: 2rem">
                                                                    <div>
                                                                        <p class="text">Mã loại sản phẩm<span style="color: red; margin-left: 10px;">🔒</span></p>
                                                                        <input style="user-select: none; pointer-events: none; caret-color: transparent;" id="Id" class="input" name="Id" readonly value="' . ($id) . '" />
                                                                    </div>
                                                                </div>

                                                                <p class="text">Loại sản phẩm</p>
                                                                <input id="CategoryName" class="input" type="text" name="CategoryName" style="width: 40rem" value="' . ($categoryName) . '" />

                                                            </div>';

                                                        ?>

                                                    </div>
                                                </div>
                                            </div>
                                        </form>
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
    const urlParams = new URLSearchParams(window.location.search);
    const categoryNamePara = urlParams.get('categoryName');
    document.getElementById("updateLoaiSanPham_save").addEventListener('click', function check(event) {
        event.preventDefault(); // Ngăn chặn hành động mặc định của form

        let Id = document.getElementById("Id");
        let Category = document.getElementById("CategoryName");
        let trimmedCategoryName = Category.value.trim();

        // Kiểm tra độ dài tên loại sản phẩm
        if (trimmedCategoryName.length < 3 || trimmedCategoryName.length > 100) {
            Swal.fire({
                icon: 'error',
                title: 'Lỗi!',
                text: 'Tên loại sản phẩm phải từ 3 đến 100 ký tự',
            });
            categoryName.focus();
            return;
        }

        // Kiểm tra tên loại sản phẩm chỉ chứa chữ
        const namePattern = /^[a-zA-ZÀÁÂÃÈÉÊÌÍÒÓÔÕÙÚĂĐĨŨƠàáâãèéêìíòóôõùúăđĩũơƯĂẰẲẴẶẤẦẨẪẬẮẰẴẸẺẼỀỀỂưăằẳẵặấầẩẫậắằẵẹẻẽềềể]+(?:\s[a-zA-ZÀÁÂÃÈÉÊÌÍÒÓÔÕÙÚĂĐĨŨƠàáâãèéêìíòóôõùúăđĩũơƯĂẰẲẴẶẤẦẨẪẬẮẰẴẸẺẼỀỀỂưăằẳẵặấầẩẫậắằẵẹẻẽềềể]+)*$/u;
        if (!namePattern.test(trimmedCategoryName)) {
            Swal.fire({
                icon: 'error',
                title: 'Lỗi!',
                text: 'Tên loại sản phẩm chỉ được chứa chữ và khoảng trắng',
            });
            categoryName.focus();
            return;
        }
        let categorynametrim = CategoryName.value.trim();
       

        //Bắt đầu cập nhật thông tin loại sản phẩm sau khi đã qua các bước xác nhận
        let isUpdateLoaiSanPhamComplete = updateLoaiSanPham(
            Id.value,
            CategoryName.value)

        
        if (isUpdateLoaiSanPhamComplete === 200){
            //Sau khi tạo xong chuyển về trang QLLoaiSanPham
            Swal.fire({
                icon: 'success',
                title: 'Thành công!',
                text: 'Cập nhật loại sản phẩm thành công !!',
            }).then(function() {
                window.location.href = 'QLLoaiSanPham.php';
            });
        }
        

    });

    function updateLoaiSanPham(Id, CategoryName) {
        var token = sessionStorage.getItem('token');
        $.ajax({
            url: 'http://localhost:8080/Category',
            type: 'PATCH',
            dataType: "json",
            headers: {
                'Authorization': 'Bearer ' + token
            },
            data: {
                Id: Id,
                CategoryName: CategoryName
            },
            success: function(data) {
                return data.status === 200;
            },
            error: function(xhr, status, error) {
                console.error('Error: ' + xhr.status + ' - ' + error);
                Swal.fire({
                    icon: 'error',
                    title: 'Lỗi!',
                    text: xhr.responseJSON.detailMessage,
                });
            }
        });
    }
</script>


</html>