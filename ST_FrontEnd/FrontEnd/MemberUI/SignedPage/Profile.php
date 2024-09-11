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
        var email = '';

        function formatDateToYYYYMMDD(dateString) {
            // Kiểm tra nếu dữ liệu đầu vào rỗng hoặc không hợp lệ
            if (!dateString || dateString.trim() === '') {
                return ''; // Trả về rỗng nếu đầu vào không hợp lệ
            }

            var parts = dateString.split('/'); // Tách chuỗi theo dấu '/'

            // Kiểm tra nếu định dạng ngày không đúng (không đủ 3 phần: ngày, tháng, năm)
            if (parts.length !== 3) {
                return ''; // Trả về rỗng nếu không đúng định dạng
            }

            var day = parts[0]; // Ngày
            var month = parts[1]; // Tháng
            var year = parts[2]; // Năm

            // Trả về định dạng yyyy-MM-dd
            return `${year}-${month.padStart(2, '0')}-${day.padStart(2, '0')}`;
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
                    email = response.email;
                    var infoPage = document.getElementById("contentprofile");
                    infoPage.innerHTML = `
                        <div class='col-xxl-8 mb-5 mb-xxl-0'>
                            <form name="profileForm" action="Profile.php?maTaiKhoan=${response.accountId}" method="POST" onsubmit="return validateForm()">
                                <div class='bg-secondary-soft px-4 py-5 rounded'>
                                    <div class='row g-3' style='text-align:left;'>
                                        <div class='col-md-6'>
                                            <label class='form-label'>Họ tên *</label>
                                            <input type='text' class='form-control' name='hoten' value='${response.fullname ? response.fullname : ''}'>
                                        </div>
                                        <div class='col-md-6'>
                                            <label class='form-label'>Số điện thoại *</label>
                                            <input type='text' class='form-control' name='sodienthoai' value='${response.phoneNumber ? response.phoneNumber : ''}'>
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
                                            <input type='email' class='form-control' id='inputEmail4' name='email' value='${response.email}' readonly >
                                        </div>
                                        <div class='col-md-6'>
                                            <label class='form-label'>Địa chỉ *</label>
                                            <input type='text' class='form-control' name='diachi' value='${response.address ? response.address : ''}'>
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
            var formData1 = new FormData();
            var tokenChange = '';
            // $.ajax({
            //     url: 'http://localhost:8080/Account/GetKeyForUpdateEmail',
            //     type: 'GET',
            //     data: {
            //         newEmail: email
            //     },
            //     headers: {
            //         'Authorization': 'Bearer ' + token
            //     },
            //     success: function(response) {
            //         console.log(response)
            //     },
            //     error: function(xhr, status, error) {
            //         Swal.fire({
            //             icon: 'error',
            //             title: 'Lỗi',
            //             text: 'Có lỗi xảy ra khi cập nhật thông tin!'
            //         });
            //     }
            // });
            $.ajax({
                url: 'http://localhost:8080/Account/UpdateInformation',
                type: 'PATCH',
                data: formData,
                contentType: false,
                processData: false,
                headers: {
                    'Authorization': 'Bearer ' + token
                },
                success: function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Thành công',
                        text: 'Cập nhật thông tin thành công!'
                    }).then(() => {
                        location.reload();
                    });
                },
                error: function(xhr, status, error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Lỗi',
                        text: 'Có lỗi xảy ra khi cập nhật thông tin!'
                    });
                }
            });

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