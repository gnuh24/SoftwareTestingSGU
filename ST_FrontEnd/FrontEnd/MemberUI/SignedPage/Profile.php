<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="SignedHomePage.css">
    <link rel="stylesheet" href="Profile.css">
    <link rel="stylesheet" href="../../../Resources/bootstrap-5.3.2-dist/css/bootstrap.min.css">
    <title>Thông tin cá nhân</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
    <?php require_once "../Header/SignedHeader.php" ?>
    <div class="col-12">
        <div class="my-2 d-flex justify-content-center">
            <h3 style="z-index: 1; font-size: 32px; color: #7b181a; position: relative; background-color: white; padding: 0 20px; margin: 30px 0; font-family: Roboto; font-weight: bold !important;">My Profile</h3>
            <hr>
        </div>
        <div class="row mb-5 gx-5 d-flex justify-content-center" id="contentprofile" style="height: fit-content; margin: 0px;"></div>
    </div>
    <?php require_once "../Footer/Footer.php" ?>
    <script>
        function formatDateToYYYYMMDD(dateString) {
            var parts = dateString.split('/'); // Tách chuỗi theo dấu '/'
            var day = parts[0]; // Ngày
            var month = parts[1]; // Tháng
            var year = parts[2]; // Năm

            // Trả về định dạng yyyy-MM-dd
            return `${year}-${month}-${day}`;
        }

        function loadUserInfoFromLocalStorage() {
            const token = localStorage.getItem("token");
            var userData = localStorage.getItem("id");
            $.ajax({
                url: "http://localhost:8080/Account/" + userData,
                method: "GET",
                dataType: "json",
                headers: {
                    'Authorization': 'Bearer ' + token
                },
                success: function(response) {
                    var infoPage = document.getElementById("contentprofile");
                    infoPage.innerHTML = `
                        <div class='col-xxl-8 mb-5 mb-xxl-0'>
                            <form name="profileForm" action="Profile.php?maTaiKhoan=${response.accountId}" method="POST" onsubmit="return validateForm()">
                                <div class='bg-secondary-soft px-4 py-5 rounded'>
                                    <div class='row g-3' style='text-align:left;'>
                                        <div class='col-md-6'>
                                            <label class='form-label'>Họ tên *</label>
                                            <input type='text' class='form-control' name='hoten' value='${response.fullname}'>
                                        </div>
                                        <div class='col-md-6'>
                                            <label class='form-label'>Số điện thoại *</label>
                                            <input type='text' class='form-control' name='sodienthoai' value='${response.phoneNumber}'>
                                        </div>
                                        <div class='col-md-6'>
                                            <label for='gioitinh'>Giới tính</label>
                                            <div class='form-check form-check-inline'>
                                                <input class='form-check-input' type='radio' name='gioitinh' id='inlineRadio1' value='Male' ${response.gender === 'Male' ? 'checked' : ''}>
                                                <label class='form-check-label' for='inlineRadio1'>Nam</label>
                                            </div>
                                            <div class='form-check form-check-inline'>
                                                <input class='form-check-input' type='radio' name='gioitinh' id='inlineRadio2' value='Female' ${response.gender === 'Female' ? 'checked' : ''}>
                                                <label class='form-check-label' for='inlineRadio2'>Nữ</label>
                                            </div>
                                        </div>
                                        <div class='col-md-6'>
                                            <label for='birthday'>Ngày sinh</label>
                                            <input type='date' class='form-control' id='birthday' name='ngaysinh' value='${formatDateToYYYYMMDD(response.birthday)}'>
                                        </div>
                                        <div class='col-md-6'>
                                            <label for='inputEmail4' class='form-label'>Email *</label>
                                            <input type='email' class='form-control' id='inputEmail4' name='email' value='${response.email}' readonly>
                                        </div>
                                        <div class='col-md-6'>
                                            <label class='form-label'>Địa chỉ *</label>
                                            <input type='text' class='form-control' name='diachi' value='${response.address}'>
                                        </div>

                                        <!-- Nút đổi mật khẩu -->
                                        <div class='col-md-12'>
                                            <button type="button" class="btn btn-outline-secondary" id="changePasswordButton" onclick="togglePasswordFields()">Đổi mật khẩu</button>
                                        </div>

                                        <!-- Các trường mật khẩu, mặc định ẩn -->
                                        <div id="passwordFields" style="display: none;">
                                            <div class='col-md-6'>
                                                <label for='currentPassword' class='form-label'>Mật khẩu cũ</label>
                                                <input type='password' class='form-control' id='currentPassword' name='currentPassword'>
                                            </div>
                                            <div class='col-md-6'>
                                                <label for='newPassword' class='form-label'>Mật khẩu mới</label>
                                                <input type='password' class='form-control' id='newPassword' name='newPassword'>
                                            </div>
                                            <div class='col-md-6'>
                                                <label for='confirmPassword' class='form-label'>Xác nhận mật khẩu mới</label>
                                                <input type='password' class='form-control' id='confirmPassword' name='confirmPassword'>
                                            </div>
                                        </div>

                                        <button class='btn btn-primary' type='submit' style='background-color: rgb(146, 26, 26);'>Thay đổi thông tin</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    `;
                },
                error: function(xhr, status, error) {
                    console.error("Error:", error);
                }
            });
        }

        window.onload = loadUserInfoFromLocalStorage;

        function togglePasswordFields() {
            const passwordFields = document.getElementById('passwordFields');
            if (passwordFields.style.display === 'none') {
                passwordFields.style.display = 'block';
            } else {
                passwordFields.style.display = 'none';
            }
        }

        function validateForm() {
            var form = document.forms["profileForm"];
            var formData = new FormData();

            // Lấy accountId từ URL
            var accountId = new URLSearchParams(window.location.search).get('maTaiKhoan');

            // Lấy các giá trị từ form
            var fullname = form['hoten'].value.trim();
            var phone = form['sodienthoai'].value.trim();
            var birthday = form['ngaysinh'].value.trim();
            var gender = form['gioitinh'].value;
            var address = form['diachi'].value.trim();

            // Kiểm tra các trường bắt buộc
            if (!fullname || !phone || !birthday || !address) {
                Swal.fire({
                    icon: 'error',
                    title: 'Lỗi',
                    text: 'Vui lòng điền đầy đủ thông tin!'
                });
                return false;
            }

            // Thêm các thông tin bắt buộc vào formData
            formData.append('accountId', accountId);
            formData.append('fullname', fullname);
            formData.append('phone', phone);
            formData.append('birthday', formatDateToDDMMYYYY(birthday));
            formData.append('gender', gender);
            formData.append('address', address);
            const token = localStorage.getItem("token");

            // Kiểm tra nếu có đổi mật khẩu
            var currentPassword = form['currentPassword'].value.trim();
            var newPassword = form['newPassword'].value.trim();
            var confirmPassword = form['confirmPassword'].value.trim();

            if (currentPassword || newPassword || confirmPassword) {
                if (!currentPassword || !newPassword || !confirmPassword) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Lỗi',
                        text: 'Vui lòng điền đầy đủ thông tin mật khẩu!'
                    });
                    return false;
                }

                if (newPassword !== confirmPassword) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Lỗi',
                        text: 'Mật khẩu mới và xác nhận mật khẩu không khớp!'
                    });
                    return false;
                }
                var formData1 = new FormData();
                // Thêm các thông tin mật khẩu vào formData
                formData1.append('oldPassword', currentPassword);
                formData1.append('token', token);
                formData1.append('newPassword', newPassword);
                $.ajax({
                    url: 'http://localhost:8080/Account/NewPassword',
                    type: 'PATCH',
                    contentType: false,
                    processData: false,
                    headers: {
                        'Authorization': 'Bearer ' + token
                    },
                    data: formData,
                    success: function(response) {
                        console.log(1)
                    },
                    error: function(xhr, status, error) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Lỗi',
                            text: 'Có lỗi xảy ra khi cập nhật thông tin!'
                        });
                    }
                });
            }

            // Gửi yêu cầu AJAX
            // $.ajax({
            //     url: 'http://localhost:8080/Account/UpdateInformation',
            //     type: 'PATCH',
            //     data: formData,
            //     contentType: false,
            //     processData: false,
            //     headers: {
            //         'Authorization': 'Bearer ' + token
            //     },
            //     success: function(response) {
            //         Swal.fire({
            //             icon: 'success',
            //             title: 'Thành công',
            //             text: 'Cập nhật thông tin thành công!'
            //         }).then(() => {
            //             location.reload();
            //         });
            //     },
            //     error: function(xhr, status, error) {
            //         Swal.fire({
            //             icon: 'error',
            //             title: 'Lỗi',
            //             text: 'Có lỗi xảy ra khi cập nhật thông tin!'
            //         });
            //     }
            // });

            return false; // Ngăn chặn form gửi theo cách truyền thống
        }

        function formatDateToDDMMYYYY(dateString) {
            // Tách chuỗi theo dấu gạch ngang "-"
            var parts = dateString.split("-");

            // Đảm bảo chuỗi có đủ các phần (năm, tháng, ngày)
            if (parts.length === 3) {
                var year = parts[0];
                var month = parts[1];
                var day = parts[2];

                // Trả về định dạng dd/mm/yyyy
                return `${day}/${month}/${year}`;
            } else {
                // Nếu chuỗi không hợp lệ, trả về giá trị ban đầu
                return dateString;
            }
        }
    </script>
</body>

</html>