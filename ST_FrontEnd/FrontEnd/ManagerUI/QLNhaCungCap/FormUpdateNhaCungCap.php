<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../AdminDemo.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="../QLNhaCungCap/QLNhaCungCap.css" />

    <title>Cập nhật nhà cung cấp</title>
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
                                                    <h2 style="font-size: 2.3rem">Cập nhật thông tin thương hiệu</h2>
                                                </div>
                                                <div>
                                                    <a style="font-family: Arial; font-size: 1.5rem; font-weight: 700; border: 1px solid rgb(140, 140, 140); background-color: white; color: rgb(80, 80, 80); padding: 1rem 2rem 1rem 2rem; border-radius: 0.6rem; cursor: pointer;" href="./QLNhaCungCap.php">Hủy</a>
                                                    <button id="updateSupplier_save" style="margin-left: 1rem; font-family: Arial; font-size: 1.5rem; font-weight: 700; color: white; background-color: rgb(65, 64, 64); padding: 1rem 2rem 1rem 2rem; border-radius: 0.6rem; cursor: pointer;">Lưu</button>
                                                </div>
                                            </div>
                                            <div class="boxTable">
                                                <div style="display: flex; padding: 0rem 1rem 0rem 1rem; justify-content: space-between;">
                                                    <div>
                                                        <?php

                                                        $brandId = "";
                                                        $brandName =  "";

                                                        if (isset($_GET['brandId'])) {
                                                            // Lấy các tham số được gửi từ AJAX
                                                            $brandId = $_GET['brandId'];
                                                            $brandName = $_GET['brandName'];
                                                        }
                                                        echo '
                                                            <div style="padding-left: 1rem">

                                                                <div style="display: flex; gap: 2rem">
                                                                    <div>
                                                                        <p class="text">Mã thương hiệu<span style="color: red; margin-left: 10px;">🔒</span></p>
                                                                        <input style="user-select: none; pointer-events: none; caret-color: transparent;" id="brandId" class="input" name="brandId" readonly value="' . ($brandId) . '" />
                                                                    </div>
                                                                </div>

                                                                <p class="text">Thương hiệu</p>
                                                                <input id="brandName" class="input" type="text" name="brandName" style="width: 40rem" value="' . ($brandName) . '" />';

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

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

<script>
    document.getElementById("updateSupplier_save").addEventListener('click', function check(event) {
        event.preventDefault(); // Ngăn chặn hành động mặc định của form

        let brandId = document.getElementById("brandId");
        let brandName = document.getElementById("brandName");

        if (!brandName.value.trim()) {
            Swal.fire({
                icon: 'error',
                title: 'Lỗi!',
                text: 'Tên thương hiệu không được để trống',
            });
            brandName.focus();
            event.preventDefault();
            return;
        }
        updateNhaCungCap(brandId.value, brandName.value)
    })

    function updateNhaCungCap(brandId, brandName) {
        var token = sessionStorage.getItem('token');

        // Kiểm tra nếu token không tồn tại
        if (!token) {
            Swal.fire({
                icon: 'error',
                title: 'Lỗi!',
                text: 'Không tìm thấy token xác thực. Vui lòng đăng nhập lại!',
            });
            return;
        }

        var dataform = new FormData();
        dataform.append("brandId", brandId);
        dataform.append("brandName", brandName);

        $.ajax({
            url: 'http://localhost:8080/Brand',
            type: 'PATCH',
            dataType: "json",
            headers: {
                'Authorization': 'Bearer ' + token
            },
            data: dataform,
            contentType: false,
            processData: false,
            success: function(data) {
                Swal.fire({
                    icon: 'success',
                    title: 'Thành công!',
                    text: 'Thay đổi thương hiệu mới thành công !!',
                }).then(() => {
                    window.location.href = 'QLNhaCungCap.php';
                });
            },
            error: function(xhr, status, error) {
                console.error('Error: ' + xhr.status + ' - ' + error);

                // Hiển thị thông báo lỗi
                Swal.fire({
                    icon: 'error',
                    title: 'Lỗi!',
                    text: 'Đã xảy ra lỗi khi cập nhật thương hiệu. Mã lỗi: ' + xhr.status,
                });
            }
        });
    }
</script>

</html>