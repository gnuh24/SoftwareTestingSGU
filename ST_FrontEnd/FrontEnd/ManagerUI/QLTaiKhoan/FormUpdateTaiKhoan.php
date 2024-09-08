<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="Admin.css" />
    <link rel="stylesheet" href="UserUpdate.css" />
    <link rel="stylesheet" href="oneForAll.css" />

    <title>Cập nhật tài khoản</title>
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
                                                    <h2 style="font-size: 2.3rem">Cập nhật tài khoản người dùng</h2>
                                                </div>
                                                <div>
                                                    <a style="font-family: Arial; font-size: 1.5rem; font-weight: 700; border: 1px solid rgb(140, 140, 140); background-color: white; color: rgb(80, 80, 80); padding: 1rem 2rem 1rem 2rem; border-radius: 0.6rem; cursor: pointer;" href="QLTaiKhoan.php">Hủy</a>
                                                    <button id="updateUser_save" style="margin-left: 1rem; font-family: Arial; font-size: 1.5rem; font-weight: 700; color: white; background-color: rgb(65, 64, 64); padding: 1rem 2rem 1rem 2rem; border-radius: 0.6rem; cursor: pointer;">Lưu</button>
                                                </div>
                                            </div>
                                            <div class="boxTable">
                                                <div style="display: flex; padding: 0rem 1rem 0rem 1rem; justify-content: space-between;">
                                                    <div>
                                                    <?php


$maTaiKhoan = "";
$quyen =  "";
$hoTen =  "";
$gioiTinh =  "";
$email =  "";
$ngaySinh =  "";
$diaChi =  "";
$soDienThoai =  "";

if (isset($_GET['maTaiKhoan'])) {
    // Lấy các tham số được gửi từ AJAX
    $maTaiKhoan = $_GET['maTaiKhoan'];
    $quyen = $_GET['quyen'];
    $hoTen = $_GET['hoTen'];
    $gioiTinh = $_GET['gioiTinh'];
    $email = $_GET['email'];
    $ngaySinh = $_GET['ngaySinh'];
    $diaChi = $_GET['diaChi'];
    $soDienThoai = $_GET['soDienThoai'];

}
                                                            echo '
                                                            <div style="padding-left: 1rem">

                                                                <div style="display: flex; gap: 2rem">
                                                                    <div>
                                                                        <p class="text">Mã tài khoản<span style="color: red; margin-left: 10px;">🔒</span></p>
                                                                        <input style="user-select: none; pointer-events: none; caret-color: transparent;" id="maTaiKhoan" class="input" name="maTaiKhoan" readonly value="' . ($maTaiKhoan) . '" />
                                                                    </div>
                                                                </div>

                                                                <p class="text">Họ Tên</p>
                                                                <input id="hoTen" class="input" type="text" name="hoTen" style="width: 40rem" value="' . ($hoTen) . '" />

                                                                <div style="display: flex; gap: 2rem">
                                                                    <div>
                                                                        <p class="text">Email<span style="color: red; margin-left: 10px;">🔒</span></p>
                                                                        <input style="user-select: none; pointer-events: none; caret-color: transparent;" id="email" class="input" name="email" readonly value="' . ($email) . '" />
                                                                    </div>
                                                                </div>

                                                                <div style="display: flex; gap: 2rem">
                                                                    <div>
                                                                        <p class="text">Địa chỉ</p>
                                                                        <input id="diaChi" class="input" name="diaChi" value="' . ($diaChi) . '" />
                                                                    </div>
                                                                </div>
                                                                <div style="display: flex; gap: 4rem">
                                                                    <div style="display: flex; gap: 2rem; align-items: center; text-align: center;">
                                                                        <p class="text">Giới Tính</p>
                                                                        <input type="radio" id="gioiTinhMale" name="gender" value="Male" ' . ($gioiTinh === "Male" ? "checked" : "") . '>
                                                                        <p for="html">Male</p>
                                                                        <input type="radio" id="gioiTinhFemale" name="gender" value="Female" ' . ($gioiTinh === "Female" ? "checked" : "") . ' />
                                                                        <label for="css">Female</label><br>
                                                                    </div>
                                                                    <div>
                                                                        <p class="text">Ngày sinh</p>
                                                                        <input id="ngaySinh" type="date" class="input" name="ngaySinh" value="' . ($ngaySinh ?? '') . '" />
                                                                    </div>
                                                                </div>
                                                                <div style="display: flex; gap: 2rem">
                                                                    <div>
                                                                        <p class="text">Số điện thoại</p>
                                                                        <input id="sdt" class="input" style="width: 30rem" name="sdt" value="' . ($soDienThoai) . '" />
                                                                    </div>
                                                                    <div>
                                                                        <p class="text">Quyền</p>
                                                                        <select name="quyen" id="quyen" class="input">
                                                                            <option value="Manager" ' . ($quyen === "Manager" ? "selected" : "") . '>Manager</option>
                                                                            <option value="Member" ' . (($quyen ?? "Member") === "Member" ? "selected" : "") . '>Member</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
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

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    document.getElementById("updateUser_save").addEventListener('click', function check(event) {
    event.preventDefault(); // Ngăn chặn hành động mặc định của form

    let maTaiKhoan = document.getElementById("maTaiKhoan");
    let hoTen = document.getElementById("hoTen");
    let sdt = document.getElementById("sdt");
    let diaChi = document.getElementById("diaChi");
    let gioiTinhMale = document.getElementById("gioiTinhMale");
    let gioiTinhFemale = document.getElementById("gioiTinhFemale");
    let vaiTro = document.getElementById("vaiTro");
    let ngaySinh = document.getElementById("ngaySinh");

    if (!hoTen.value.trim()) {
        showErrorAlert('Lỗi!', 'Họ Tên không được để trống');
        hoTen.focus();
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

    
    // Kiểm tra tuổi
    let ngaySinhDate = new Date(ngaySinh.value);
    let tuoi = new Date().getFullYear() - ngaySinhDate.getFullYear();
    if (tuoi < 18) {
        showErrorAlert('Lỗi!', 'Bạn phải trên 18 tuổi để có thể sử dụng dịch vụ này.');
        ngaySinh.focus();
        event.preventDefault();
        return;
    }

    if (!ngaySinh.value.trim()) {
        showErrorAlert('Lỗi!', 'Ngày sinh không được để trống');
        ngaySinh.focus();
        event.preventDefault();
        return;
    }

    //Sau khi qua được tất cả ta bắt đầu tạo TaiKhoan
    let isUpdateTaiKhoanComplete = updateTaiKhoan(maTaiKhoan.value, quyen.value);

    var gioiTinhValue = "Female";

    //XỬ lý giới tính
    if (gioiTinhMale.checked){
        gioiTinhValue = "Male";
    }
    

    //Tạo thông tin người dùng đi kèm
    let isUpdateNguoiDungComplete = updateNguoiDung(
                    maTaiKhoan.value,
                    hoTen.value,
                    ngaySinh.value, 
                    gioiTinhValue, 
                    sdt.value, 
                    email.value, 
                    diaChi.value)

    //Sau khi tạo xong chuyển về trang QLTaiKHoan
    showSuccessAlert('Thành công!', 'Cập nhật tài khoản thành công !!', 'QLTaiKhoan.php');
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


    function updateTaiKhoan(maTaiKhoan, quyen) {
        let flag=false;
        $.ajax({
            url: '../../BackEnd/AdminBE/TaiKhoanBE.php',
            type: 'POST',
            dataType: "json",
            data: {
                maTaiKhoan: maTaiKhoan,
                quyen: quyen
            },
            success: function(data) {
                if (data.status == 200){
                    flag = true;
                }
            },
            error: function(xhr, status, error) {
                console.error('Error: ' + xhr.status + ' - ' + error);
            }
        });
        return flag;
    }

    function updateNguoiDung(maNguoiDung, hoTen, ngaySinh, gioiTinh, soDienThoai, email, diaChi) {
        $.ajax({
            url: '../../BackEnd/AdminBE/NguoiDungBE.php',
            type: 'POST',
            dataType: "json",
            data: {
                maNguoiDung: maNguoiDung,
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