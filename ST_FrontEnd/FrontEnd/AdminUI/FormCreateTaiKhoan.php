<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="Admin.css" />
    <link rel="stylesheet" href="UserUpdate.css" />
    <link rel="stylesheet" href="oneForAll.css" />

    <title>Tạo tài khoản</title>
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
                                            <input type="hidden" name="action" value="createUser">
                                            <div class="boxFeature">
                                                <div>
                                                    <h2 style="font-size: 2.3rem">Tạo tài khoản người dùng</h2>
                                                </div>
                                                <div>
                                                    <a style="font-family: Arial; font-size: 1.5rem; font-weight: 700; border: 1px solid rgb(140, 140, 140); background-color: white; color: rgb(80, 80, 80); padding: 1rem 2rem 1rem 2rem; border-radius: 0.6rem; cursor: pointer;" href="QLTaiKhoan.php">Hủy</a>
                                                    <button id="updateUser_save" style="margin-left: 1rem; font-family: Arial; font-size: 1.5rem; font-weight: 700; color: white; background-color: rgb(65, 64, 64); padding: 1rem 2rem 1rem 2rem; border-radius: 0.6rem; cursor: pointer;">Lưu</button>
                                                </div>
                                            </div>
                                            <div class="boxTable">
                                                <div style="display: flex; padding: 0rem 1rem 0rem 1rem; justify-content: space-between;">
                                                    <div>
                                                        <div style="padding-left: 1rem">
                                                            <p class="text">Tên đăng nhập</p>
                                                            <input id="tenDangNhap" class="input" type="text" name="tenDangNhap" style="width: 40rem" />
                                                            <span style="margin-left: 1rem; font-weight: 700; color: rgb(150, 150, 150);">*</span>
                                                            <p class="text">Mật khẩu</p>
                                                            <input id="matKhau" class="input" type="password" name="matKhau" style="width: 40rem" />
                                                            <span style="margin-left: 1rem; font-weight: 700; color: rgb(150, 150, 150);">*</span>
                                                            <p class="text">Xác nhận mật khẩu</p>
                                                            <input id="xacNhanMatKhau" class="input" type="password" name="xacNhanMatKhau" style="width: 40rem" />
                                                            <span style="margin-left: 1rem; font-weight: 700; color: rgb(150, 150, 150);">*</span>
                                                            <p class="text">Họ Tên</p>
                                                            <input id="hoTen" class="input" type="text" name="hoTen" style="width: 40rem" />
                                                            <span style="margin-left: 1rem; font-weight: 700; color: rgb(150, 150, 150);">*</span>
                                                            <div style="display: flex; gap: 2rem">
                                                                <div>
                                                                    <p class="text">Email</p>
                                                                    <input id="email" type="text" class="input" name="email" />
                                                                </div>
                                                                <div>
                                                                    <p class="text">Địa chỉ</p>
                                                                    <input id="diaChi" class="input" name="diaChi" />
                                                                </div>
                                                            </div>
                                                            <div id="Emailtontai"></div>
                                                            <div style="display: flex; gap: 4rem">
                                                                <div style="display: flex; gap: 2rem ; align-items: center; text-align: center;">
                                                                    <p class="text">Giới Tính</p>
                                                                    <input type="radio" id="gioiTinhMale" name="gender" value="Male">
                                                                    <p for="html">Male</p>
                                                                    <input type="radio" id="gioiTinhFemale" name="gender" value="Female" />
                                                                    <label for="css">Female</label><br>
                                                                </div>
                                                                <div>
                                                                    <p class="text">Ngày sinh</p>
                                                                    <input id="ngaySinh" type="date" class="input" name="ngaySinh" />
                                                                </div>
                                                            </div>
                                                            <div style="display: flex; gap: 2rem">
                                                                <div>
                                                                    <p class="text">Số điện thoại</p>
                                                                    <input id="sdt" class="input" style="width: 30rem" name="sdt" />
                                                                </div>
                                                                <div>
                                                                    <p class="text">Quyền</p>
                                                                    <select name="quyen" id="quyen" class="input">
                                                                        <option value="Manager">Manager</option>
                                                                        <option value="Member" selected>Member</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div></div>
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
    document.getElementById("submit-form").addEventListener('submit', function check(event) {
        event.preventDefault(); // Ngăn chặn hành động mặc định của form

        let tenDangNhap = document.getElementById("tenDangNhap");
        let matKhau = document.getElementById("matKhau");
        let xacNhanMatKhau = document.getElementById("xacNhanMatKhau");
        let hoTen = document.getElementById("hoTen");
        let sdt = document.getElementById("sdt");
        let diaChi = document.getElementById("diaChi");
        let gioiTinhMale = document.getElementById("gioiTinhMale");
        let gioiTinhFemale = document.getElementById("gioiTinhFemale");
        let vaiTro = document.getElementById("vaiTro");
        let email = document.getElementById("email");
        let ngaySinh = document.getElementById("ngaySinh");

        if (!tenDangNhap.value.trim()) {
            showErrorAlert('Lỗi!', 'Tên đăng nhập không được để trống');
            tenDangNhap.focus();
            event.preventDefault();
            return;
        }
        if (!matKhau.value.trim()) {
            showErrorAlert('Lỗi!', 'Mật khẩu không được để trống');
            matKhau.focus();
            event.preventDefault();
            return;
        }

        if (!xacNhanMatKhau.value.trim()) {
            showErrorAlert('Lỗi!', 'Mật khẩu xác nhận không được để trống');
            xacNhanMatKhau.focus();
            event.preventDefault();
            return;
        }
        if (matKhau.value !== xacNhanMatKhau.value) {
            showErrorAlert('Lỗi!', 'Mật khẩu xác nhận và mật khẩu phải giống nhau');
            xacNhanMatKhau.focus();
            event.preventDefault();
            return;
        }
        if (!hoTen.value.trim()) {
            showErrorAlert('Lỗi!', 'Họ Tên không được để trống');
            hoTen.focus();
            event.preventDefault();
            return;
        }
        if (!email.value.trim()) {
            showErrorAlert('Lỗi!', 'Email không được để trống');
            email.focus();
            event.preventDefault();
            return;
        }
        if (!sdt.value.trim()) {
            showErrorAlert('Lỗi!', 'Số điện thoại không được để trống');
            sdt.focus();
            event.preventDefault();
            return;
        }
        if (!diaChi.value.trim()) {
            showErrorAlert('Lỗi!', 'Địa chỉ không được để trống');
            diaChi.focus();
            event.preventDefault();
            return;
        }
        if (!gioiTinhMale.checked && !gioiTinhFemale.checked) {
            showErrorAlert('Lỗi!', 'Vui lòng chọn giới tính');
            event.preventDefault();
            return;
        }

        if (!ngaySinh.value.trim()) {
            showErrorAlert('Lỗi!', 'Ngày sinh không được để trống');
            ngaySinh.focus();
            event.preventDefault();
            return;
        }

        // Kiểm tra tuổi
        let ngaySinhDate = new Date(ngaySinh.value);
        let tuoi = new Date().getFullYear() - ngaySinhDate.getFullYear();
        if (tuoi < 18) {
            showErrorAlert('Lỗi!', 'Bạn phải đủ 18 tuổi để đăng ký tài khoản');
            ngaySinh.focus();
            event.preventDefault();
            return;
        }

        // Kiểm tra định dạng Email
        if (!isValidEmail(email.value.trim())) {
            showErrorAlert('Lỗi!', 'Email không hợp lệ');
            email.focus();
            event.preventDefault();
            return;
        }

        //Kiểm tra tên đăng nhập
        if (checkTenDangNhap(tenDangNhap.value.trim())) {
            showErrorAlert('Lỗi!', 'Tên đăng nhập đã tồn tại');
            tenDangNhap.focus();
            event.preventDefault();
            return;
        }

        //Kiểm tra xem email đã tồn tại hay chưa
        if (checkEmailTonTai(email.value.trim())) {
            showErrorAlert('Lỗi!', 'Email đã tồn tại');
            email.focus();
            event.preventDefault();
            return;
        }

        //Sau khi qua được tất cả ta bắt đầu tạo TaiKhoan
        let isCreateTaiKhoanComplete = createTaiKhoan(tenDangNhap.value,
                        matKhau.value,
                        quyen.value);

        var gioiTinhValue = "Female";

        //XỬ lý giới tính
        if (gioiTinhMale.checked){
            gioiTinhValue = "Male";
        }
        

        //Tạo thông tin người dùng đi kèm
        let isCreateNguoiDungComplete = createNguoiDung(hoTen.value,
                        ngaySinh.value, 
                        gioiTinhValue, 
                        sdt.value, 
                        email.value, 
                        diaChi.value)

        
        //Sau khi tạo xong chuyển về trang QLTaiKHoan
        showSuccessAlert('Thành công!', 'Tạo tài khoản mới thành công !!', 'QLTaiKhoan.php');
    });

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

    function isValidEmail(email) {
        return /[^\s@]+@[^\s@]+\.[^\s@]+/.test(email);
    }


    function checkTenDangNhap(value) {
        let exists = false;
        $.ajax({
            url: '../../BackEnd/AdminBE/TaiKhoanBE.php',
            type: 'GET',
            dataType: "json",
            async: false, // Đảm bảo AJAX request được thực hiện đồng bộ
            data: {
                tenDangNhap: value
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


    function checkEmailTonTai(value) {
        let exists = false;
        $.ajax({
            url: '../../BackEnd/AdminBE/NguoiDungBE.php',
            type: 'GET',
            dataType: "json",
            async: false, // Đảm bảo AJAX request được thực hiện đồng bộ
            data: {
                email: value
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

    function createTaiKhoan(tenDangNhap, matKhau, quyen) {
        $.ajax({
            url: '../../BackEnd/AdminBE/TaiKhoanBE.php',
            type: 'POST',
            dataType: "json",
            data: {
                tenDangNhap: tenDangNhap,
                matKhau: matKhau,
                quyen: quyen
            },
            success: function(data) {
                return data.status === 200;
            },
            error: function(xhr, status, error) {
                console.error('Error: ' + xhr.status + ' - ' + error);
            }
        });
    }

    function createNguoiDung(hoTen, ngaySinh, gioiTinh, soDienThoai, email, diaChi) {
        $.ajax({
            url: '../../BackEnd/AdminBE/NguoiDungBE.php',
            type: 'POST',
            dataType: "json",
            data: {
                hoTen: hoTen,
                ngaySinh: ngaySinh,
                gioiTinh: gioiTinh,
                soDienThoai: soDienThoai,
                email: email,
                diaChi: diaChi
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