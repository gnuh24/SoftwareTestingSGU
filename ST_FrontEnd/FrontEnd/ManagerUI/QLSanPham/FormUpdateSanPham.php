<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../QLTaiKhoan/UserUpdate.css" />
    <link rel="stylesheet" href="../QLTaiKhoan/oneForAll.css" />
    <style>
        .batch-item {
            background-color: white;
            border: 2px solid black;
            margin-top: 25px;
            padding: 5px;
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <title>Cập nhật sản phẩm số <?php echo $_GET['maSanPham'] ?></title>
</head>

<body>
    <div id="root">
        <div>
            <div class="App">
                <div class="StaffLayout_wrapper__CegPk">
                    <div class="StaffHeader_wrapper__IQw-U">
                        <p class="StaffHeader_title__QxjW4">Dekanta</p>
                        <button class="StaffHeader_signOut__i2pcu">
                            <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="arrow-right-from-bracket" class="svg-inline--fa fa-arrow-right-from-bracket" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" style="width: 2rem; height: 2rem; color: white"></svg>
                        </button>
                    </div>
                    <div class="Manager_wrapper__vOYy" style="height: auto;">
                        <div style="padding-left: 3%; width: 100%; padding-right: 2rem;height:auto">
                            <div class="wrapper">
                                <div style="display: flex; padding-top: 1rem; align-items: center; gap: 1rem; padding-bottom: 1rem;"></div>
                                <form id="submit-form" method="post">
                                    <div class="boxFeature">
                                        <div>
                                            <h2 style="font-size: 2.3rem">Update sản phẩm mới</h2>
                                        </div>
                                        <div>
                                            <a style="font-family: Arial; font-size: 1.5rem; font-weight: 700; border: 1px solid rgb(140, 140, 140); background-color: white; color: rgb(80, 80, 80); padding: 1rem 2rem 1rem 2rem; border-radius: 0.6rem; cursor: pointer;" href="QLSanPham.php">Hủy</a>
                                            <button id="updateUser_save" style="margin-left: 1rem; font-family: Arial; font-size: 1.5rem; font-weight: 700; color: white; background-color: rgb(65, 64, 64); padding: 1rem 2rem 1rem 2rem; border-radius: 0.6rem; cursor: pointer;">Lưu</button>
                                        </div>
                                    </div>
                                    <div class="boxTable" style="height: auto;">
                                        <div style="display: flex; padding: 0rem 1rem 0rem 1rem; justify-content: space-around;">
                                            <div style="padding-left: 1rem; margin-left: 25px;">

                                                <p class="text">Tên sản phẩm</p>
                                                <input disabled id="tenSanPham" class="input" type="text" name="tenSanPham" style="width: 40rem" />
                                                <span style="margin-left: 1rem; font-weight: 700; color: rgb(150, 150, 150);">*</span>


                                                <p class="text">Xuất xứ</p>
                                                <input id="xuatXu" class="input" name="xuatXu" style="width: 40rem" />
                                                <span style="margin-left: 1rem; font-weight: 700; color: rgb(150, 150, 150);">*</span>

                                                <p class="text">Loại sản phẩm</p>
                                                <select name="loaiSanPham" id="loaiSanPham" class="input" style="width: 40rem">
                                                    <!-- Options sẽ được thêm từ JavaScript -->
                                                </select>
                                                <span style="margin-left: 1rem; font-weight: 700; color: rgb(150, 150, 150);">*</span>

                                                <p class="text">Thương hiệu</p>
                                                <select id="thuongHieu" class="input" name="thuongHieu" style="width: 40rem">
                                                    <!-- Options sẽ được thêm từ JavaScript -->
                                                </select>
                                                <span style="margin-left: 1rem; font-weight: 700; color: rgb(150, 150, 150);">*</span>

                                                <p class="text">Thể tích (ml)</p>
                                                <input id="theTich" class="input" type="text" name="theTich" style="width: 40rem" />
                                                <span style="margin-left: 1rem; font-weight: 700; color: rgb(150, 150, 150);">*</span>

                                                <p class="text">Nồng độ cồn (%)</p>
                                                <input id="nongDoCon" type="text" class="input" name="nongDoCon" style="width: 40rem" />
                                                <span style="margin-left: 1rem; font-weight: 700; color: rgb(150, 150, 150);">*</span>


                                                <p class="text">Trạng thái</p>
                                                <input disabled id="status" class="input" name="status" style="width: 40rem" readonly />

                                                <p class="text">Thời gian tạo</p>
                                                <input disabled id="createTime" class="input" name="createTime" style="width: 40rem" readonly />


                                                <p class="text">Mô tả sản phẩm</p>
                                                <textarea id="moTa" class="input" name="moTa" style="width: 40rem; height: 8rem;"></textarea>
                                            </div>





                                            <div style="display: flex; flex-direction: column; justify-content: center; align-items: center;">
                                                <p class="text">Ảnh minh họa</p>
                                                <img id="xuatAnh" style="width: 350px; height: 400px;" alt="">
                                                <input id="anhMinhHoa" type="file" name="anhMinhHoa" accept="image/*">

                                                <div id="batch" style="padding-left: 1rem; margin-left: 25px;">


                                                </div>

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
</body>


<script>
    document.addEventListener("DOMContentLoaded", function() {
        getCategories();
        getBrand();
        fetchProductDetails(<?php echo $_GET['maSanPham'] ?>);
    })

    anhMinhHoa = document.getElementById("anhMinhHoa");

    // Bắt sự kiện change trên input file
    document.getElementById('anhMinhHoa').addEventListener('change', function(event) {
        const file = event.target.files[0]; // Lấy file đầu tiên được chọn
        if (file) {
            const imageUrl = URL.createObjectURL(file); // Tạo URL tạm thời từ file
            document.getElementById('xuatAnh').src = imageUrl; // Gán URL tạm thời cho thẻ img
        }
    });


    document.getElementById("submit-form").addEventListener('submit', function check(event) {
        event.preventDefault(); // Ngăn chặn hành động mặc định của form

        let tenSanPham = document.getElementById("tenSanPham");
        let loaiSanPham = document.getElementById("loaiSanPham");
        let xuatXu = document.getElementById("xuatXu");
        let thuongHieu = document.getElementById("thuongHieu");
        let theTich = document.getElementById("theTich");
        let nongDoCon = document.getElementById("nongDoCon");
        let anhMinhHoa = document.getElementById("anhMinhHoa");
        let moTa = document.getElementById("moTa");

        // Hàm hiển thị lỗi
        function showErrorAlert(title, message) {
            Swal.fire({
                icon: 'error',
                title: title,
                text: message,
            });
        }

        // Hàm hiển thị thành công
        function showSuccessAlert(title, message, redirectUrl) {
            Swal.fire({
                icon: 'success',
                title: title,
                text: message,
            }).then(() => {
                window.location.href = redirectUrl;
            });
        }
        if (!moTa.value.trim()) {
            showErrorAlert('Lỗi!', 'Mô tả không được để trống');
            moTa.focus();
            return;
        }

        // Kiểm tra thể tích
        if (parseFloat(theTich.value) <= 0 || isNaN(parseFloat(theTich.value))) {
            showErrorAlert('Lỗi!', 'Thể tích phải là số dương');
            theTich.focus();
            return;
        }

        // Kiểm tra nồng độ cồn
        if (parseFloat(nongDoCon.value) < 0 || parseFloat(nongDoCon.value) > 100 || isNaN(parseFloat(nongDoCon.value))) {
            showErrorAlert('Lỗi!', 'Nồng độ cồn phải là số dương và có giá trị từ 0 đến 100');
            nongDoCon.focus();
            return;
        }

        // Kiểm tra xuất xứ: 1 - 100 ký tự, không chứa ký tự đặc biệt
        let xuatXuRegex = /^[a-zA-Z0-9À-ỹ\s]{1,100}$/;
        if (!xuatXuRegex.test(xuatXu.value)) {
            showErrorAlert('Lỗi!', 'Xuất xứ phải từ 1 - 100 ký tự và không chứa ký tự đặc biệt.');
            xuatXu.focus();
            return;
        }

        // Nếu mọi kiểm tra hợp lệ, gọi hàm updateSanPham
        updateSanPham(
            <?php echo $_GET['maSanPham'] ?>,
            anhMinhHoa.files[0],
            xuatXu.value,
            theTich.value,
            nongDoCon.value,
            thuongHieu.value,
            loaiSanPham.value,
            moTa.value
        );

        //Sau khi tạo xong chuyển về trang QLSanPham
        showSuccessAlert('Thành công!', 'Cập nhật sản phẩm thành công !!', 'QLSanPham.php');
    });

    function fetchProductDetails(productId) {
        $.ajax({
            url: `http://localhost:8080/Product/Admin/${productId}`,
            type: 'GET',
            dataType: 'json',
            headers: {
                "Authorization": "Bearer " + sessionStorage.getItem('token') // Gửi token trong header
            },
            success: function(data) {
                // Điền dữ liệu vào form
                $('#tenSanPham').val(data.productName);
                $('#xuatXu').val(data.origin);
                $('#thuongHieu').val(data.brand.id); // Sử dụng ID của thương hiệu
                $('#loaiSanPham').val(data.category.id); // Sử dụng ID của loại sản phẩm
                $('#theTich').val(data.capacity);
                $('#nongDoCon').val(data.abv);
                $('#status').val(data.status ? 'Đang bán' : 'Ngừng bán'); // Trạng thái
                $('#createTime').val(data.createTime); // Thời gian tạo
                $('#quantity').val(data.quantity); // Số lượng
                $('#moTa').val(data.description); // Mô tả

                console.log(data);

                // Cập nhật hình ảnh
                $('#xuatAnh').attr('src', 'http://res.cloudinary.com/djhoea2bo/image/upload/v1711511636/' + data.image);

                // Xử lý phần batches
                const batchesContainer = $('#batch');
                batchesContainer.empty(); // Clear the current content in the #batch div

                if (data.batches && data.batches.length > 0) {
                    // Loop through each batch and add it to the #batch div
                    data.batches.forEach((batch, index) => {
                        const batchHTML = `
                                <div class="batch-item">
                                    <h4>Lô số ${index + 1}</h4>
                                    <p>Đơn giá: ${batch.price} VND</p>
                                    <p>Số lượng: ${batch.quantity}</p>
                                    <p>Ngày nhập: ${batch.receivingTime}</p>
                                </div>
                            `;
                        batchesContainer.append(batchHTML); // Append each batch to the #batch div
                    });
                } else {
                    // If no batches are available, show a message
                    batchesContainer.append('<p>No batches available</p>');
                }
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
            }
        });
    }




    function getCategories() {
        $.ajax({
            url: 'http://localhost:8080/Category/noPaging', // API lấy danh sách loại sản phẩm
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                let categorySelect = $('#loaiSanPham');
                categorySelect.empty(); // Xóa các options cũ
                data.forEach(function(category) {
                    categorySelect.append(new Option(category.categoryName, category.id));
                });
            },
            error: function(xhr, status, error) {
                console.error('Error loading categories:', error);
            }
        });
    }

    function getBrand() {
        $.ajax({
            url: 'http://localhost:8080/Brand/noPaging', // API lấy danh sách thương hiệu
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                let brandSelect = $('#thuongHieu');
                brandSelect.empty(); // Xóa các options cũ
                data.forEach(function(brand) {
                    brandSelect.append(new Option(brand.brandName, brand.brandId));
                });
            },
            error: function(xhr, status, error) {
                console.error('Error loading brands:', error);
            }
        });
    }



    function showErrorAlert(title, message) {
        Swal.fire({
            title: title,
            text: message,
            icon: 'error',
            confirmButtonText: 'OK'
        });
    }

    function showSuccessAlert(title, message, redirectUrl) {
        Swal.fire({
            title: title,
            text: message,
            icon: 'success',
            confirmButtonText: 'OK'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = redirectUrl;
            }
        });
    }




    function updateSanPham(id, anhMinhHoa, xuatXu, theTich, nongDoCon, thuongHieu, maLoaiSanPham, moTa) {
        var formData = new FormData();
        formData.append("id", id); // ID là bắt buộc cho việc cập nhật
        formData.append("categoryId", Number(maLoaiSanPham)); // Ép kiểu số nguyên cho categoryId
        formData.append("origin", xuatXu);
        formData.append("brandId", Number(thuongHieu)); // Ép kiểu số nguyên cho brandId
        formData.append("capacity", theTich);
        formData.append("abv", nongDoCon);
        formData.append("description", moTa);

        // Thêm file ảnh nếu có
        if (anhMinhHoa) {
            formData.append("image", anhMinhHoa); // Gửi file ảnh kèm theo formData
        }

        $.ajax({
            url: 'http://localhost:8080/Product', // Thay URL bằng đúng API của bạn
            type: 'PATCH', // Sử dụng PATCH cho việc cập nhật
            data: formData,
            processData: false, // Không xử lý dữ liệu vì chúng ta đang gửi formData
            contentType: false, // Không đặt kiểu content-type, để jQuery tự động xử lý
            headers: {
                "Authorization": "Bearer " + sessionStorage.getItem('token') // Gửi token trong header
            },
            success: function(data) {
                console.log("Sản phẩm được cập nhật thành công!");
            },
            error: function(xhr, status, error) {
                console.error('Error: ' + xhr.status + ' - ' + error);
            }
        });
    }
</script>

</html>