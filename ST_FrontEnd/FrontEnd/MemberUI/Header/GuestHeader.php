<header class="container-fluid bg-danger" style="height: fit-content;background-color:rgb(146, 26, 26) !important;">
    <div id="Home-over-Header" class="row align-items-center py-2 " style="height: fit-content;">
        <!-- Logo -->
        <div class="col-6 col-md-2 text-center">
            <img id="Home-img" src="img/logoWine.jpg" alt="Logo" class="img-fluid" />
        </div>

        <!-- Search Form -->
        <div class="col-12 col-md-8 my-2 my-md-0 text-center">
            <form id="search" class="input__wrapper d-flex" method="post" action="GuestProduct.php">
                <input id="searchSanPham" name="searchFromAnotherPage" type="text" class="form-control me-2" placeholder="Tìm kiếm" required="" />
                <button id="filter-button" class="btn btn-primary" type="submit">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </button>
            </form>
        </div>

        <!-- Login -->
        <div id="Home-login" class="col-6 col-md-2 text-end text-center">
            <button class="btn btn-light text-danger">Login</button>
        </div>
    </div>
</header>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

<script>
    // Lắng nghe sự kiện click vào id "Home-login"
    document.getElementById("Home-login").addEventListener("click", function() {
        window.location.href = '../Login/LoginUI.php';
    });
    document.getElementById("Home-img").addEventListener("click", function() {
        // Chuyển hướng về trang chủ khi click vào hình ảnh
        window.location.href = "GuestHomePage.php";
    });

    // Sự kiện tìm kiếm search 
    document.getElementById("filter-button").addEventListener("click", (event) => {
        event.preventDefault();
        const form = document.getElementById("search");
        const searchValue = document.getElementById("searchSanPham").value;
        if (searchValue != "") {
            form.action = `GuestProduct.php?searchFromAnotherPage=${searchValue}`;
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
</script>