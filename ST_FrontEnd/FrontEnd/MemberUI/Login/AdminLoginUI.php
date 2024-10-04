<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="LoginUI.css">
    <link rel="stylesheet" href="../../../Resources/bootstrap-5.3.2-dist/css/bootstrap.css">
    <title>Admin Login</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <div class="container" id="container">
        <div class="form-container sign-in" style="width: 100%">
            <form id="adminLoginForm">
                <h1>Login Admin</h1>
                <input type="email" placeholder="Email" style="width: 50%" id="adminEmail" name="email" required />
                <input type="password" placeholder="Password" style="width: 50%" id="adminPassword" name="password" required />
                <button type="button" class="btn btn-danger" id="adminLoginButton">Đăng nhập</button>
            </form>
        </div>
    </div>
</body>



<script>
    $(document).ready(function() {
        // Focus vào trường email khi trang vừa được tải
        $('#adminEmail').focus();

        $('#adminLoginButton').click(function(e) {
            e.preventDefault(); // Ngăn hành động mặc định của nút submit

            var email = $('#adminEmail').val();
            var password = $('#adminPassword').val();

            // Kiểm tra trường email và password không được để trống
            if (!email || !password) {
                Swal.fire({
                    title: 'Lỗi!',
                    text: 'Vui lòng nhập email và mật khẩu!',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
                // Focus lại trường email nếu email bị để trống
                if (!email) {
                    $('#adminEmail').focus();
                }
                return;
            }

            // Tạo đối tượng FormData
            var formData = new FormData();
            formData.append('email', email);
            formData.append('password', password);

            $.ajax({
                url: 'http://localhost:8080/Auth/LoginAdmin',
                type: 'POST',
                data: formData, // Gửi dữ liệu dưới dạng form-data
                contentType: false, // Không yêu cầu định dạng JSON
                processData: false, // Không xử lý dữ liệu thành chuỗi query
                success: function(response) {
                    // Kiểm tra nếu response có trường code và code = 8
                    if (response.code && response.code === 8) {
                        Swal.fire({
                            title: 'Lỗi!',
                            text: response.detailMessage || 'Đăng nhập thất bại!',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                        $('#adminEmail').focus(); // Focus lại vào trường email sau khi đăng nhập thất bại
                    } else {
                        sessionStorage.setItem('id', response.id);
                        sessionStorage.setItem('token', response.token);
                        sessionStorage.setItem('refreshToken', response.refreshToken);

                        Swal.fire({
                            title: 'Thành công!',
                            text: 'Đăng nhập thành công!',
                            icon: 'success',
                            confirmButtonText: 'OK'
                        }).then(() => {
                            // Chuyển hướng sau khi đăng nhập thành công
                            window.location.href = `../../ManagerUI/QLLoaiSanPham/QLLoaiSanPham.php`;
                        });
                    }
                },
                error: function(xhr) {
                    Swal.fire({
                        title: 'Lỗi!',
                        text: xhr.responseJSON.detailMessage || 'Đăng nhập thất bại!',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                    $('#adminEmail').focus(); // Focus lại vào trường email nếu có lỗi từ server
                }
            });
        });
    });
</script>


</html>