<style>

    /* Logo */
    #Home-img {
        width: 110px;
        height: 80px;
    }

    /* Tìm kiếm  */
    .input__wrapper {
        display: flex;
        align-items: center;
        position: relative;
        margin-left: 4%;
        gap: 10px;
    }
    .search-input {
        padding-left: 25px;
        background-image: url("../img/search.png");
        background-size: 20px;
        background-repeat: no-repeat;
        background-position: 5px center;
        width: 800px;
        height: 35px;
        border: 2px solid rgb(133, 6, 6);
        border-radius: 20px;
    }
    #filter-button {
        background-color: white;
        color: rgb(146, 26, 26);
        padding: 10px 20px;
        border: none;
        cursor: pointer;
        height: 35px;
        border-radius: 5px;
        margin-right: 10px;
    }



    /* Đăng nhập */
    .header-option, .header-option > *{
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: white; /* Màu nền */
        color: rgb(146, 26, 26); /* Màu chữ */
        padding: 5px 15px; /* Kích thước padding */
        border: none; /* Không viền */
        cursor: pointer; /* Con trỏ tương tác */
        border-radius: 5px; /* Bo góc */
    
    }



</style>
<header class="Home-container-header">
    <div id="Home-over-Header">
        <img id="Home-img" src="../GuestPage/img/logoWine.jpg" alt="" />
        <form id="search" class="input__wrapper" method="post" action="SignedProduct.php">
            <?php
                if (isset($_GET['searchFromAnotherPage'])) {
                    echo '<input value="' . $_GET['searchFromAnotherPage'] . '" id="searchSanPham" type="text" class="search-input" placeholder="Tìm kiếm" required/>';
                } else {
                    echo '<input id="searchSanPham" type="text" class="search-input" placeholder="Tìm kiếm" required/>';
                }
            ?>                    
            <button id="filter-button"><i class="fa-solid fa-magnifying-glass"></i></button>
            <div class="header-option" onclick="toCart()"><i class="fa-solid fa-cart-shopping"></i></div>
            <div class="header-option" onclick="toMyOrder()"><i class="fa-solid fa-truck-fast"></i></div>
            <div class="header-option"><a href="Profile.php"><i class="fa-solid fa-user"></i></a></div>
            <div class="header-option" onclick="logout()"><i class="fa-solid fa-right-from-bracket"></i></div>
        </form>
    </div>
</header>
<script>

    //Click vào ảnh về trang chủ
    document.getElementById("Home-img").addEventListener("click", function () {
        // Chuyển hướng về trang chủ khi click vào hình ảnh
        window.location.href = "SignedHomePage.php";
    });

    //Sự kiện đơn hàng cá nhân
    function toMyOrder() {
        const form = document.getElementById("search");
        if (form) {
            // Lấy dữ liệu từ localStorage
            const localStorageData = JSON.parse(localStorage.getItem("key"));
            const maTaiKhoan = localStorageData.MaTaiKhoan;

            // Thêm MaTaiKhoan vào action của form
            form.action = "MyOrder.php?maTaiKhoan=" + maTaiKhoan;

            // Gửi form đi
            form.submit();
        } else {
            console.error("Form not found!");
        }
    }
    

    //Sự kiện giỏ hàng
    function toCart() {
        const form = document.getElementById("search");
        if (form) {
            // Lấy dữ liệu từ localStorage
            const localStorageData = JSON.parse(localStorage.getItem("key"));
            const maTaiKhoan = localStorageData.MaTaiKhoan;

            // Thêm MaTaiKhoan vào action của form
            form.action = "Cart.php?maTaiKhoan=" + maTaiKhoan;
            // Gửi form đi
            form.submit();
        } else {
            console.error("Form not found!");
        }
    }


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
                localStorage.removeItem("key");
                window.location.href = "../GuestPage/GuestHomePage.php";

            }
        });
    }

</script>