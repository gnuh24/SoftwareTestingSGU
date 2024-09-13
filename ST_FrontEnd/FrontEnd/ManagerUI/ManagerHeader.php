<div class="StaffHeader_wrapper__IQw-U">
    <p class="StaffHeader_title__QxjW4">Dekanta</p>
    <button id="logoutButton" class="StaffHeader_signOut__i2pcu">
        <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="arrow-right-from-bracket" class="svg-inline--fa fa-arrow-right-from-bracket" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" style="width: 2rem; height: 2rem; color: white">
            <path fill="currentColor" d="M502.6 278.6c12.5-12.5 12.5-32.8 0-45.3l-128-128c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L402.7 224 192 224c-17.7 0-32 14.3-32 32s14.3 32 32 32l210.7 0-73.4 73.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0l128-128zM160 96c17.7 0 32-14.3 32-32s-14.3-32-32-32L96 32C43 32 0 75 0 128L0 384c0 53 43 96 96 96l64 0c17.7 0 32-14.3 32-32s-14.3-32-32-32l-64 0c-17.7 0-32-14.3-32-32l0-256c0-17.7 14.3-32 32-32l64 0z"></path>
        </svg>
    </button>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    document.getElementById("logoutButton").addEventListener("click", () => {
        Swal.fire({
            title: 'Xác nhận đăng xuất',
            text: 'Bạn có chắc chắn muốn đăng xuất?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Đồng ý',
            cancelButtonText: 'Hủy'
        }).then((result) => {
            if (result.isConfirmed) {
                const refreshToken = sessionStorage.getItem("refreshToken");
                if (refreshToken) {
                    // Gọi API logout qua Ajax
                    logout(refreshToken).then(() => {

                        sessionStorage.removeItem('id');
                        sessionStorage.removeItem('token');
                        sessionStorage.removeItem('refreshToken');
                        // Chuyển hướng về trang đăng nhập
                        window.location.href = "../../MemberUI/Login/LoginUI.php";
                    }).catch(error => {
                        // Xử lý lỗi (nếu có)
                        console.error('Lỗi khi gọi API logout:', error);
                        Swal.fire({
                            icon: 'error',
                            title: 'Lỗi',
                            text: 'Không thể đăng xuất. Vui lòng thử lại sau!',
                        });
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Lỗi',
                        text: 'Không tìm thấy refreshToken',
                    });
                }
            }
        });
    });

    // Hàm gọi API logout sử dụng Ajax với FormData
    function logout(refreshToken) {
        return new Promise((resolve, reject) => {
            // Tạo đối tượng FormData và thêm refreshToken vào
            const formData = new FormData();
            formData.append("refreshToken", refreshToken);

            $.ajax({
                url: 'http://localhost:8080/Auth/Logout',
                type: 'POST',
                data: formData,
                processData: false, // Không xử lý dữ liệu (FormData cần giữ nguyên)
                contentType: false, // Đặt là false để sử dụng multipart/form-data mặc định
                headers: {
                    'Authorization': 'Bearer ' + sessionStorage.getItem('token') // Thay 'yourTokenKey' bằng khóa lưu token của bạn
                },
                success: function(response) {
                    // Nếu thành công, resolve promise
                    resolve(response);
                },
                error: function(xhr, status, error) {
                    // Nếu có lỗi, reject promise
                    reject(error);
                }
            });
        });
    }
</script>