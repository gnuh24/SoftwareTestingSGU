<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />
    <link rel="stylesheet" href="LoginUI.css" />
    <link rel="stylesheet" href="../../../Resources/bootstrap-5.3.2-dist\css\bootstrap.css" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Login</title>
</head>

<body>
    <div class="container" id="container">
        <div class="form-container sign-up">
            <form>
                <h1>Create Account</h1>
                <input type="email" placeholder="Email" id="email" name="Email" />
                <input type="password" placeholder="Mật khẩu" id="matKhau" name="MatKhau" />
                <input type="password" placeholder="Xác thực mật khẩu" id="xacNhanMatKhau" name="XacThucMatKhau" />


                <button type="button" class="btn btn-danger" id="signUpButton">Đăng kí</button>
            </form>

        </div>



        <div class="form-container sign-in">
            <form>
                <h1>Sign In</h1>
                <input type="email" placeholder="Tên đăng nhập" id="tenDangNhapLogin" />
                <input type="password" placeholder="Password" id="passwordLogin" />
                <button type="button" class="btn btn-danger" id="signInButton">Đăng nhập</button>
            </form>
        </div>
        <div class="toggle-container">
            <div class="toggle">
                <div class="toggle-panel toggle-left">
                    <h1>Welcome Back!</h1>
                    <p>Enter your personal details to use all of site features</p>
                    <button type="button" class="btn btn-light" id="login">
                        Đăng nhập
                    </button>
                </div>
                <div class="toggle-panel toggle-right">
                    <h1>Hello, Friend!</h1>
                    <p>
                        Register with your personal details to use all of site features
                    </p>
                    <button type="button" class="btn btn-light" id="register">
                        Đăng kí
                    </button>
                </div>
            </div>
        </div>
    </div>
</body>




<script>
    document.addEventListener('DOMContentLoaded', function() {
        const container = document.getElementById('container');
        const emailSignUp = document.getElementById('email'); // Ô email của form đăng ký
        const emailLogin = document.getElementById('tenDangNhapLogin'); // Ô email của form đăng nhập
        const registerBtn = document.getElementById('register'); // Nút chuyển sang form đăng ký
        const loginBtn = document.getElementById('login'); // Nút chuyển sang form đăng nhập

        // Focus vào ô email khi trang vừa tải
        if (container.classList.contains('active')) {
            emailSignUp.focus(); // Focus vào email của form đăng ký nếu đang ở form đăng ký
        } else {
            emailLogin.focus(); // Focus vào email của form đăng nhập nếu đang ở form đăng nhập
        }

        // Thêm sự kiện khi người dùng nhấn vào nút Đăng ký
        registerBtn.addEventListener('click', () => {
            container.classList.add('active');
            setTimeout(() => {
                emailSignUp.focus(); // Focus vào email của form đăng ký sau khi chuyển form
            }, 300); // Đợi một khoảng thời gian ngắn để đảm bảo form đã chuyển đổi hoàn toàn
        });

        // Thêm sự kiện khi người dùng nhấn vào nút Đăng nhập
        loginBtn.addEventListener('click', () => {
            container.classList.remove('active');
            setTimeout(() => {
                emailLogin.focus(); // Focus vào email của form đăng nhập sau khi chuyển form
            }, 300); // Đợi một khoảng thời gian ngắn để đảm bảo form đã chuyển đổi hoàn toàn
        });
    });



    //Script xử lý Registation
    const container = document.getElementById("container");
    const registerBtn = document.getElementById("register");
    const loginBtn = document.getElementById("login");

    registerBtn.addEventListener("click", () => {
        container.classList.add("active");
    });

    loginBtn.addEventListener("click", () => {
        container.classList.remove("active");
    });

    const signUpButton = document.getElementById("signUpButton");

    signUpButton.addEventListener('click', async function check(event) {
        event.preventDefault(); // Ngăn chặn hành động mặc định của form

        let matKhau = document.getElementById("matKhau");
        let xacNhanMatKhau = document.getElementById("xacNhanMatKhau");
        let email = document.getElementById("email");

        if (!matKhau.value.trim()) {
            Swal.fire({
                title: 'Lỗi!',
                text: 'Mật khẩu không được để trống',
                icon: 'error',
                confirmButtonText: 'OK'
            });
            matKhau.focus();
            return;
        }

        // Kiểm tra độ dài mật khẩu
        if (matKhau.value.length < 8) {
            Swal.fire({
                title: 'Lỗi!',
                text: 'Mật khẩu phải có ít nhất 8 ký tự',
                icon: 'error',
                confirmButtonText: 'OK'
            });
            matKhau.focus();
            return;
        }

        if (!xacNhanMatKhau.value.trim()) {
            Swal.fire({
                title: 'Lỗi!',
                text: 'Mật khẩu xác nhận không được để trống',
                icon: 'error',
                confirmButtonText: 'OK'
            });
            xacNhanMatKhau.focus();
            return;
        }
        if (matKhau.value !== xacNhanMatKhau.value) {
            Swal.fire({
                title: 'Lỗi!',
                text: 'Mật khẩu xác nhận và mật khẩu phải giống nhau',
                icon: 'error',
                confirmButtonText: 'OK'
            });
            xacNhanMatKhau.focus();
            return;
        }

        if (!email.value.trim()) {
            Swal.fire({
                title: 'Lỗi!',
                text: 'Email không được để trống',
                icon: 'error',
                confirmButtonText: 'OK'
            });
            email.focus();
            return;
        }

        // Kiểm tra định dạng Email
        if (!isValidEmail(email.value.trim())) {
            Swal.fire({
                title: 'Lỗi!',
                text: 'Email không hợp lệ',
                icon: 'error',
                confirmButtonText: 'OK'
            });
            email.focus();
            return;
        }

        try {
            const emailExists = await checkEmail(email.value); // đợi kết quả
            if (emailExists === true) {
                Swal.fire({
                    title: 'Lỗi!',
                    text: 'Email tồn tại',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
                email.focus();
                return;
            }
        } catch (error) {
            Swal.fire({
                title: 'Lỗi!',
                text: 'Đã xảy ra lỗi khi kiểm tra tài khoản!',
                icon: 'error',
                confirmButtonText: 'OK'
            });
        }

        var formData = new FormData();
        formData.append('email', email.value.trim());
        formData.append('password', matKhau.value);

        $.ajax({
            url: 'http://localhost:8080/Auth/Registration',
            type: 'POST',
            data: formData, // Gửi FormData
            processData: false,
            contentType: false,
            beforeSend: function() {
                // Hiện thông báo "Đang xử lý"
                Swal.fire({
                    title: 'Đang xử lý...',
                    text: 'Vui lòng chờ trong giây lát.',
                    icon: 'info',
                    showConfirmButton: false,
                    allowOutsideClick: false
                });
            },
            success: function(response) {
                // Đóng thông báo "Đang xử lý"
                Swal.close();

                // Kiểm tra xem phản hồi có thành công hay không
                Swal.fire({
                    title: response.message,
                    text: "Vui lòng xác thực email",
                    icon: 'success',
                    confirmButtonText: 'OK'
                });
            },
            error: function(xhr, status, error) {
                // Đóng thông báo "Đang xử lý"
                Swal.close();

                console.error('Lỗi:', error);
                Swal.fire({
                    title: 'Lỗi!',
                    text: 'Đã xảy ra lỗi khi đăng kí tài khoản!',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            }
        });
    });


    function isValidEmail(email) {
        // Thực hiện kiểm tra định dạng Email và trả về true hoặc false
        // Bạn có thể sử dụng biểu thức chính quy hoặc các phương thức khác để kiểm tra định dạng Email
        return /[^\s@]+@[^\s@]+\.[^\s@]+/.test(email);
    }

    async function checkEmail(email) {
        return new Promise((resolve, reject) => {
            $.ajax({
                url: 'http://localhost:8080/Account/isThisEmailExists',
                type: 'GET',
                data: {
                    email: email
                },
                success: function(response) {
                    resolve(response); // Resolve the promise with the response
                },
                error: function(error) {
                    reject(error); // Reject the promise if there's an error
                }
            });
        });
    }

    const loginButton = document.getElementById("signInButton");
    const tenDangNhap = document.getElementById("tenDangNhapLogin");
    const matKhau = document.getElementById("passwordLogin");
    loginButton.addEventListener("click", (event) => {
        event.preventDefault();
        if (tenDangNhap.value.trim() === "") {
            Swal.fire({
                title: 'Lỗi!',
                text: 'Bạn không được để trống tên đăng nhập !!',
                icon: 'error',
                confirmButtonText: 'OK'
            });
            tenDangNhap.focus();
            return
        }
        if (matKhau.value.trim() === "") {
            Swal.fire({
                title: 'Lỗi!',
                text: 'Bạn không được để trống mật khẩu !!',
                icon: 'error',
                confirmButtonText: 'OK'
            });
            matKhau.focus();
            return
        }

        checkTaiKhoan(tenDangNhap.value, matKhau.value)
    });

    // Lắng nghe sự kiện nhấn phím Enter trong các form
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Enter') {
            event.preventDefault(); // Ngăn chặn hành động mặc định của form

            // Kiểm tra xem người dùng đang ở form nào dựa trên class của container
            if (container.classList.contains('active')) {
                signUpButton.click(); // Gọi sự kiện đăng ký nếu đang ở form đăng ký
            } else {
                loginButton.click(); // Gọi sự kiện đăng nhập nếu đang ở form đăng nhập
            }
        }
    });

    // Hàm xử lý kiểm tra tài khoản
    function checkTaiKhoan(email, password) {
        // Tạo đối tượng FormData
        var formData = new FormData();
        formData.append('email', email);
        formData.append('password', password);

        $.ajax({
            url: 'http://localhost:8080/Auth/SignIn',
            type: 'POST',
            data: formData, // Gửi FormData
            processData: false, // Ngăn jQuery tự động xử lý dữ liệu
            contentType: false, // Đảm bảo tiêu đề nội dung là multipart/form-data
            success: function(response) {
                // Kiểm tra xem phản hồi có thành công hay không
                if (response.code === 8) {
                    Swal.fire({
                        title: response.message,
                        text: response.detailMessage,
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                    return;
                }
                if (response.statusCode === 200) {
                    Swal.fire({
                        title: 'Thành công!',
                        text: response.message,
                        icon: 'success',
                        confirmButtonText: 'OK'
                    }).then((result) => {
                        if (result) {
                            const quyen = response.role;

                            sessionStorage.setItem('id', response.id);
                            sessionStorage.setItem('token', response.token);
                            sessionStorage.setItem('refreshToken', response.refreshToken);
                            switch (quyen) {
                                case 'Admin':
                                    window.location.href = `../../AdminUI/QLTaiKhoan.php`;
                                    break;
                                case 'Manager':
                                    window.location.href = `../../ManagerUI/QLLoaiSanPham/QLLoaiSanPham.php`;
                                    break;
                                default:
                                    window.location.href = `../SignedPage/SignedHomePage.php`;
                                    break;
                            }
                        }
                    });
                } else {
                    // Trường hợp đăng nhập thất bại
                    Swal.fire({
                        title: 'Lỗi!',
                        text: 'Đăng nhập thất bại, hãy kiểm tra lại tên đăng nhập và mật khẩu !!',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                }
            },
            error: function(xhr, status, error) {
                console.error('Lỗi:', error);
                Swal.fire({
                    title: 'Lỗi!',
                    text: 'Đã xảy ra lỗi khi kiểm tra tài khoản!',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            }
        });
    }
</script>


</html>