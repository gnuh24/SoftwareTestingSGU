<style>
    /* Base Styles */
    #Home-img {
        width: 110px;
        height: 80px;
    }


    .input__wrapper {
        display: flex;
        align-items: center;
        position: relative;
        gap: 10px;
        justify-content: center;
    }

    .search-input {
        padding-left: 25px;
        /* background-image: url("../img/search.png"); */
        background-size: 20px;
        background-repeat: no-repeat;
        background-position: 5px center;
        border: 2px solid rgb(133, 6, 6);
        border-radius: 20px;
        width: 100%;
        max-width: 800px;
        height: 35px;
    }

    #filter-button {
        background-color: white;
        color: rgb(146, 26, 26);
        padding: 10px 20px;
        border: none;
        cursor: pointer;
        border-radius: 5px;
        margin-right: 10px;
    }

    .header-option {
        background-color: white;
        color: rgb(146, 26, 26);
        padding: 5px 15px;
        border: none;
        cursor: pointer;
        border-radius: 5px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-left: 5px;
    }

    .header-option a {
        color: inherit;
        text-decoration: none;
    }

    /* Responsive Styles */
    @media (max-width: 768px) {

        /* Adjust logo size */
        #Home-img {
            width: 100px;
            height: auto;
        }

        /* Adjust search input */
        .search-input {
            width: 100%;
            max-width: none;
            height: 30px;
        }

        /* Stack buttons vertically */
        .header-option {
            padding: 5px;
        }
    }

    @media (max-width: 576px) {

        /* Logo center alignment on small screens */
        .col-md-2 {
            text-align: center;
        }

        /* Center the search form on small screens */
        .input__wrapper {
            flex-direction: column;
            align-items: stretch;
            gap: 5px;
        }

        /* Stack login options vertically */
        .col-md-4 {
            flex-direction: column;
            align-items: center;
            gap: 10px;
        }
    }

    #Home-over-Header {
        height: 100px;
        /* Set a consistent height for the header */
    }

    #Home-img {
        max-height: 80px;
        /* Ensure the logo doesn't exceed a certain size */
    }

    .input__wrapper input,
    .input__wrapper button {
        height: 100%;
        /* Ensure the search form fields take the full height */
    }

    .header-option {
        cursor: pointer;
        font-size: 24px;
        /* Adjust icon size */
        display: flex;
        align-items: center;
        justify-content: center;
        width: 20%;
        height: 40px;
    }
</style>

<header class="container-fluid bg-danger" style="background-color: rgb(146, 26, 26) !important;">
    <div id="Home-over-Header" class="row align-items-center justify-content-between" style="height: fit-content;">

        <!-- Logo -->
        <div class="col-12 col-md-2 text-center mb-2 mb-md-0 d-flex align-items-center justify-content-center">
            <img id="Home-img" src="../GuestPage/img/logoWine.jpg" alt="Logo" class="img-fluid" />
        </div>

        <!-- Search Form -->
        <div class="col-12 col-md-6 mb-2 mb-md-0 d-flex justify-content-center align-items-center">
            <form id="search" class="input__wrapper d-flex w-100" method="post" action="SignedProduct.php">
                <input id="searchSanPham" name="searchFromAnotherPage" type="text" class="form-control me-2 search-input" placeholder="Tìm kiếm" style="width: 90%;" required="" />
                <button id="filter-button" class="btn btn-primary" type="submit" style="width: 10%;padding:5px 0;">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </button>
            </form>
        </div>

        <!-- Icons Section -->
        <div class="col-12 col-md-4 d-flex justify-content-center align-items-center gap-4" style="height: fit-content;">
            <div class="header-option" onclick="toCart()" style="height: fit-content;">
                <i class="fa-solid fa-cart-shopping"></i>
            </div>
            <div class="header-option" onclick="toMyOrder()" style="height: fit-content;">
                <i class="fa-solid fa-truck-fast"></i>
            </div>
            <div class="header-option" onclick="toProfile()" style="height: fit-content;">
                <i class="fa-solid fa-user"></i>
            </div>
            <div class="header-option" onclick="logout()" style="height: fit-content;">
                <i class="fa-solid fa-right-from-bracket"></i>
            </div>
        </div>

    </div>
</header>


<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    //Click vào ảnh về trang chủ
    document.getElementById("Home-img").addEventListener("click", function() {
        // Chuyển hướng về trang chủ khi click vào hình ảnh
        window.location.href = "SignedHomePage.php";
    });

    // Sự kiện tìm kiếm search 
    document.getElementById("filter-button").addEventListener("click", function(event) {
        event.preventDefault();
        const form = document.getElementById("search");
        const searchValue = document.getElementById("searchSanPham").value;
        console.log(searchValue);
        if (searchValue != "") {
            form.action = `SignedProduct.php?searchFromAnotherPage=${searchValue}`;
            form.submit();
        } else {
            Swal.fire({
                title: 'Lỗi!',
                text: 'Bạn cần phải nhập gì đó vào thanh tìm kiếm trước khi ấn nút tìm kiếm.',
                icon: 'error',
                confirmButtonText: 'OK'
            });
        }
    });

    //Sự kiện giỏ hàng
    function toCart() {
        const form = document.getElementById("search");
        if (form) {
            // Lấy dữ liệu từ localStorage
            const localStorageData = JSON.parse(localStorage.getItem("id"));
            const maTaiKhoan = localStorageData;



            // Thêm MaTaiKhoan vào action của form
            form.action = "Cart.php?maTaiKhoan=" + maTaiKhoan;
            // Gửi form đi
            form.submit();
        } else {
            console.error("Form not found!");
        }
    }
    //profile
    function toProfile() {
        const form = document.getElementById("search");
        if (form) {
            // Lấy dữ liệu từ localStorage
            const localStorageData = JSON.parse(localStorage.getItem("id"));
            const maTaiKhoan = localStorageData;

            // Thêm MaTaiKhoan vào action của form
            form.action = "Profile.php?maTaiKhoan=" + maTaiKhoan;
            // Gửi form đi
            form.submit();
        } else {
            console.error("Form not found!");
        }
    }
    //Sự kiện đơn hàng cá nhân
    function toMyOrder() {
        const form = document.getElementById("search");
        if (form) {
            // Lấy dữ liệu từ localStorage
            const localStorageData = JSON.parse(localStorage.getItem("id"));
            const maTaiKhoan = localStorageData;


            // Thêm MaTaiKhoan vào action của form
            form.action = "MyOrder.php?maTaiKhoan=" + maTaiKhoan;

            // Gửi form đi
            form.submit();
        } else {
            console.error("Form not found!");
        }
    }


        // Sự kiện đăng xuất
        function logout() {
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
                // Lấy refreshToken từ localStorage
                const refreshToken = localStorage.getItem("refreshToken");

                if (refreshToken) {
                    // Gọi API logout qua Ajax
                    logoutApi(refreshToken).then(() => {
                        // Xóa các item trong localStorage sau khi API thành công
                        localStorage.removeItem("key");
                        localStorage.removeItem("refreshToken");

                        // Chuyển hướng về trang chủ khách
                        window.location.href = "../GuestPage/GuestHomePage.php";
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
    }

    // Hàm gọi API logout sử dụng Ajax với FormData
    function logoutApi(refreshToken) {
        return new Promise((resolve, reject) => {
            // Tạo đối tượng FormData và thêm refreshToken vào
            const formData = new FormData();
            formData.append("refreshToken", refreshToken);

            $.ajax({
                url: 'http://localhost:8080/Auth/Logout',
                type: 'POST',
                data: formData,
                processData: false,  // Không xử lý dữ liệu (FormData cần giữ nguyên)
                contentType: false,  // Đặt là false để sử dụng multipart/form-data mặc định
                headers: {
                    'Authorization': 'Bearer ' + localStorage.getItem('token') // Thay 'yourTokenKey' bằng khóa lưu token của bạn
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