<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../QLTaiKhoan/UserUpdate.css" />
    <link rel="stylesheet" href="../QLTaiKhoan/oneForAll.css" />

    <title>Tạo sản phẩm</title>
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
                    <div>
                        <div>
                            <div class="Manager_wrapper__vOYy">

                                <div style="padding-left: 3%; width: 100%; padding-right: 2rem">
                                    <div class="wrapper">
                                        <div style="display: flex; padding-top: 1rem; align-items: center; gap: 1rem; padding-bottom: 1rem;"></div>
                                        <form id="submit-form" method="post">
                                            <div class="boxFeature">
                                                <div>
                                                    <h2 style="font-size: 2.3rem">Tạo sản phẩm mới</h2>
                                                </div>
                                                <div>
                                                    <a style="font-family: Arial; font-size: 1.5rem; font-weight: 700; border: 1px solid rgb(140, 140, 140); background-color: white; color: rgb(80, 80, 80); padding: 1rem 2rem 1rem 2rem; border-radius: 0.6rem; cursor: pointer;" href="QLSanPham.php">Hủy</a>
                                                    <button id="updateUser_save" style="margin-left: 1rem; font-family: Arial; font-size: 1.5rem; font-weight: 700; color: white; background-color: rgb(65, 64, 64); padding: 1rem 2rem 1rem 2rem; border-radius: 0.6rem; cursor: pointer;">Lưu</button>
                                                </div>
                                            </div>
                                            <div class="boxTable">
                                                <div style="display: flex; padding: 0rem 1rem 0rem 1rem; justify-content: space-around;">
                                                    <div style="padding-left: 1rem; margin-left: 25px;">

                                                        <p class="text">Tên sản phẩm</p>
                                                        <input id="tenSanPham" class="input" type="text" name="tenSanPham" style="width: 40rem" />
                                                        <span style="margin-left: 1rem; font-weight: 700; color: rgb(150, 150, 150);">*</span>

                                                        <p class="text">Loại sản phẩm</p>
                                                        <select name="loaiSanPham" id="loaiSanPham" class="input" style="width: 40rem"></select>
                                                        <span style="margin-left: 1rem; font-weight: 700; color: rgb(150, 150, 150);">*</span>


                                                        <p class="text">Xuất xứ</p>
                                                        <input id="xuatXu" class="input" name="xuatXu" style="width: 40rem" />
                                                        <span style="margin-left: 1rem; font-weight: 700; color: rgb(150, 150, 150);">*</span>

                                                        <p class="text">Thương hiệu</p>
                                                        <select id="thuongHieu" class="input" name="thuongHieu" style="width: 40rem"></select>
                                                        <span style="margin-left: 1rem; font-weight: 700; color: rgb(150, 150, 150);">*</span>

                                                        <p class="text">Thể tích</p>
                                                        <input id="theTich" class="input" type="text" name="theTich" style="width: 40rem" />
                                                        <span style="margin-left: 1rem; font-weight: 700; color: rgb(150, 150, 150);">*</span>

                                                        <p class="text">Nồng độ cồn</p>
                                                        <input id="nongDoCon" type="text" class="input" name="nongDoCon" style="width: 40rem" />
                                                        <span style="margin-left: 1rem; font-weight: 700; color: rgb(150, 150, 150);">*</span>


                                                        <p class="text">Giá</p>
                                                        <input id="gia" class="input" name="gia" style="width: 40rem" />
                                                        <span style="margin-left: 1rem; font-weight: 700; color: rgb(150, 150, 150);">*</span>
                                                        <p class="text">Mô Tả</p>
                                                        <input id="moTa" class="input" name="moTa" style="width: 40rem" />
                                                        <span style="margin-left: 1rem; font-weight: 700; color: rgb(150, 150, 150);">*</span>
                                                    </div>

                                                    <div style="    display: flex;
                                                                            flex-direction: column;
                                                                            justify-content: center;
                                                                            align-items: center;">
                                                        <p class="text">Ảnh minh họa</p>
                                                        <img id="xuatAnh" style="width: 350px; height: 400px;" src="../../public/img/anhMinhHoa.webp" alt="">
                                                        <input id="anhMinhHoa" type="file" name="anhMinhHoa" accept="image/*">
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
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    getCategories();
    getBrand();
    anhMinhHoa = document.getElementById("anhMinhHoa");
    anhMinhHoa.addEventListener("change", function() {

        // Lấy tệp hình ảnh được chọn
        var selectedFile = anhMinhHoa.files[0];


        // Tạo một đối tượng FileReader
        var reader = new FileReader();

        // Đọc tệp hình ảnh và chuyển đổi thành dạng Base64 khi hoàn thành
        reader.onload = function(event) {
            // Lấy chuỗi Base64 từ tệp hình ảnh
            var base64String = event.target.result;

            // Thiết lập đường dẫn ảnh trong src của phần tử img
            document.getElementById("xuatAnh").src = base64String;

        };

        // Bắt đầu đọc tệp hình ảnh dưới dạng Data URL (Base64)
        reader.readAsDataURL(selectedFile);
    });



    document.getElementById("submit-form").addEventListener('submit', function check(event) {
        event.preventDefault(); // Ngăn chặn hành động mặc định của form

        let tenSanPham = document.getElementById("tenSanPham");
        let loaiSanPham = document.getElementById("loaiSanPham");
        let xuatXu = document.getElementById("xuatXu");
        let thuongHieu = document.getElementById("thuongHieu");
        let theTich = document.getElementById("theTich");
        let nongDoCon = document.getElementById("nongDoCon");
        let gia = document.getElementById("gia");
        let anhMinhHoa = document.getElementById("anhMinhHoa");
        let moTa = document.getElementById("moTa");

        if (!tenSanPham.value.trim()) {
            showErrorAlert('Lỗi!', 'Tên sản phẩm không được để trống');
            tenSanPham.focus();
            event.preventDefault();
            return;
        }
        // Validate loại sản phẩm
        if (loaiSanPham.value === '') {
            showErrorAlert('Lỗi!', 'Vui lòng chọn loại sản phẩm');
            loaiSanPham.focus();
            event.preventDefault();
            return;
        }
        if (!xuatXu.value.trim()) {
            showErrorAlert('Lỗi!', 'Xuất xứ không được để trống');
            xuatXu.focus();
            event.preventDefault();
            return;
        }
        if (!thuongHieu.value.trim()) {
            showErrorAlert('Lỗi!', 'Thương hiệu không được để trống');
            thuongHieu.focus();
            event.preventDefault();
            return;
        }
        if (!theTich.value.trim()) {
            showErrorAlert('Lỗi!', 'Thể tích không được để trống');
            theTich.focus();
            event.preventDefault();
            return;
        }
        // Kiểm tra thể tích là số dương
        if (parseFloat(theTich.value) <= 0 || isNaN(parseFloat(theTich.value))) {
            showErrorAlert('Lỗi!', 'Thể tích phải là số dương');
            theTich.focus();
            event.preventDefault();
            return;
        }
        if (!nongDoCon.value.trim()) {
            showErrorAlert('Lỗi!', 'Nồng độ cồn không được để trống');
            nongDoCon.focus();
            event.preventDefault();
            return;
        }
        // Kiểm tra nồng độ cồn là số dương và có giá trị từ 0 đến 100
        if (parseFloat(nongDoCon.value) < 0 || parseFloat(nongDoCon.value) > 100 || isNaN(parseFloat(nongDoCon.value))) {
            showErrorAlert('Lỗi!', 'Nồng độ cồn phải là số dương và có giá trị từ 0 đến 100');
            nongDoCon.focus();
            event.preventDefault();
            return;
        }
        if (!gia.value.trim()) {
            showErrorAlert('Lỗi!', 'Giá không được để trống');
            gia.focus();
            event.preventDefault();
            return;
        }
        if (!moTa.value.trim()) {
            showErrorAlert('Lỗi!', 'Mô tả không được để trống');
            mota.focus();
            event.preventDefault();
            return;
        }
        // Kiểm tra giá là số dương
        if (parseFloat(gia.value) <= 0 || isNaN(parseFloat(gia.value))) {
            showErrorAlert('Lỗi!', 'Giá phải là số dương');
            gia.focus();
            event.preventDefault();
            return;
        }

        //Kiểm tra tên loại sản phẩm




        createSanPham(tenSanPham.value,
            loaiSanPham.value,
            xuatXu.value,
            thuongHieu.value,

            theTich.value,
            nongDoCon.value,
            gia.value,
            anhMinhHoa.files[0],
            moTa.value);





        //Sau khi tạo xong chuyển về trang QLSanPham
        showSuccessAlert('Thành công!', 'Tạo sản phẩm mới thành công !!', 'QLSanPham.php');
    });



    function getCategories() {
        $.ajax({
            url: "http://localhost:8080/Category/noPaging",
            method: "GET",
            dataType: "json",
            success: function(response) {
                console.log(response)
                if (response && response.length > 0) {
                    // Xóa tất cả các option hiện có trong dropdown
                    $('#loaiSanPham').empty();
                    // Thêm option "Tất cả"
                    $('#loaiSanPham').append('<option value="">Chọn loại sản phẩm</option>');
                    // Duyệt qua danh sách loại sản phẩm và thêm từng option vào dropdown
                    $.each(response, function(index, category) {
                        $('#loaiSanPham').append(`<option value="${category.id}">${category.categoryName}</option>`);
                    });
                } else {
                    console.log("Không có loại sản phẩm nào được trả về từ API.");
                }
            },
            error: function(xhr, status, error) {
                console.error("Error:", error);
            }
        });
    }

    function getBrand() {
        $.ajax({
            url: "http://localhost:8080/Brand/noPaging",
            method: "GET",
            dataType: "json",
            success: function(response) {
                console.log(response)
                if (response && response.length > 0) {
                    $('#thuongHieu').empty();
                    $('#thuongHieu').append('<option value="">Chọn thương hiệu sản phẩm</option>');
                    $.each(response, function(index, brand) {
                        $('#thuongHieu').append(`<option value="${brand.brandId}">${brand.brandName}</option>`);
                    });
                } else {
                    console.log("Không có thương hiệu sản phẩm nào được trả về từ API.");
                }
            },
            error: function(xhr, status, error) {
                console.error("Error:", error);
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





    function createSanPham(tenSanPham, maLoaiSanPham, xuatXu, thuongHieu, theTich, nongDoCon, gia, anhMinhHoa, moTa) {
        var formData = new FormData();
        formData.append("productName", tenSanPham);
        formData.append("categoryId", maLoaiSanPham);
        formData.append("origin", xuatXu);
        formData.append("brandId", thuongHieu);
        formData.append("capacity", theTich);
        formData.append("abv", nongDoCon);
        formData.append("price", gia);
        formData.append("image", anhMinhHoa);
        formData.append("description", moTa);
        for (var pair of formData.entries()) {
            console.log(pair[0] + ': ' + pair[1]);
        }

        $.ajax({
            url: 'http://localhost:8080/Product', // Kiểm tra URL chính xác
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                "Authorization": "Bearer " + sessionStorage.getItem('token') // Gửi token trong header
            },
            success: function(data) {
                console.log(data); // Log dữ liệu trả về để kiểm tra
                if (data) {
                    console.log("Sản phẩm được tạo thành công!");
                } else {
                    console.log("Đã xảy ra lỗi khi tạo sản phẩm!");
                }
            },
            error: function(xhr, status, error) {
                console.error('Error: ' + xhr.status + ' - ' + error);
                console.log(xhr.responseText); // Kiểm tra phản hồi lỗi từ máy chủ
            }
        });
    }
</script>

</html>