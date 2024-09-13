<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../AdminDemo.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="../QLNhaCungCap/QLNhaCungCap.css" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <title>Thêm Nhà Cung Cấp</title>
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
                                        <form id="submit-form" method="POST">
                                            <input type="hidden" name="action" value="createSupplier">
                                            <div class="boxFeature">
                                                <div>
                                                    <h2 style="font-size: 2.3rem">Thêm thương hiệu</h2>

                                                </div>
                                                <div>
                                                    <a style="
                                                    font-family: Arial;
                                                    font-size: 1.5rem;
                                                    font-weight: 700;
                                                    border: 1px solid rgb(140, 140, 140);
                                                    background-color: white;
                                                    color: rgb(80, 80, 80);
                                                    padding: 1rem 2rem 1rem 2rem;
                                                    border-radius: 0.6rem;
                                                    cursor: pointer;
                                                    " href="./QLNhaCungCap.php">
                                                        Hủy
                                                    </a>
                                                    <button id="updateSupplier_save" style="margin-left: 1rem; font-family: Arial; font-size: 1.5rem; font-weight: 700; color: white;  background-color: rgb(65, 64, 64); padding: 1rem 2rem 1rem 2rem; border-radius: 0.6rem; cursor: pointer;">
                                                        Lưu
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="boxTable">

                                                <div style=" display: flex; padding: 0rem 1rem 0rem 1rem; justify-content: space-between;">
                                                    <div>

                                                        <div style="padding-left: 1rem">
                                                            <p class="text">Thương hiệu</p>
                                                            <input id="brandName" class="input" type="text" name="brandName" style="width: 40rem" />
                                                            <span style="
                                                            margin-left: 1rem;
                                                            font-weight: 700;
                                                            color: rgb(150, 150, 150);
                                                            ">*</span>


                                                        </div>

                                                    </div>
                                                    <div>


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
                <div>


                </div>
            </div>
        </div>

    </div>
</body>


<script>
    document.getElementById("submit-form").addEventListener('submit', function check(event) {
        event.preventDefault(); // Ngăn chặn hành động mặc định của form

        let brandName = document.getElementById("brandName");
        // let Email = document.getElementById("Email");
        // let SoDienThoai = document.getElementById("SoDienThoai");

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


        //Kiểm tra tên thương hiệu
        if (isTenNhaCungCapExists(brandName.value.trim())) {
            Swal.fire({
                icon: 'error',
                title: 'Lỗi!',
                text: 'Tên thương hiệu đã tồn tại',
            });
            brandName.focus();
            event.preventDefault();
            return;
        }
        let isCreateNhaCungCapComplete = createNhaCungCap(
            brandName.value,
            // Email.value,
            // SoDienThoai.value
        );

        //Sau khi tạo xong chuyển về trang QLNhaCungCap
        Swal.fire({
            icon: 'success',
            title: 'Thành công!',
            text: 'Thêm thương hiệu mới thành công !!',
        }).then(() => {
            window.location.href = 'QLNhaCungCap.php';
        });

    });

    function isTenNhaCungCapExists(value) {
        let exists = false;
        var token = sessionStorage.getItem('token');
        $.ajax({
            url: 'http://localhost:8080/Brand',
            type: 'GET',
            dataType: "json",
            headers: {
                'Authorization': 'Bearer ' + token
            },
            async: false, // Đảm bảo AJAX request được thực hiện đồng bộ
            data: {
                action: "isExists",
                brandName: value
            },
            success: function(data) {
                if (data.status === 200) {
                    exists = data.isExists == 1;
                } else {
                    console.error('Error:', data.message);
                }
            },
            error: function(xhr, status, error) {
                console.error('Error: ' + xhr.status + ' - ' + error);
            }
        });
        return exists;
    }

    function createNhaCungCap(brandName) {
        var token = sessionStorage.getItem('token');
        $.ajax({
            url: 'http://localhost:8080/Brand',
            type: 'POST',
            dataType: "json",
            headers: {
                'Authorization': 'Bearer ' + token
            },
            data: {
                action: "create",
                brandName: brandName
                // Email: Email,
                // SoDienThoai: SoDienThoai
            },
            success: function(data) {
                return data.status === 200;
            },
            error: function(xhr, status, error) {
                console.error('Error: ' + xhr.status + ' - ' + error);
            }
        });
    }
</script>

</html>