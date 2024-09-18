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
        background-image: url("../img/search.png");
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
</style>
<header class="container-fluid bg-danger" style="background-color: rgb(146, 26, 26) !important;">
    <div id="Home-over-Header" class="row align-items-center justify-content-center" style="height: fit-content;">
        <!-- Logo -->
        <div class="col-12 col-md-2 text-center mb-2 mb-md-0">
            <img id="Home-img" src="../GuestPage/img/logoWine.jpg" alt="Logo" class="img-fluid mx-auto" />
        </div>

        <!-- Search Form -->
        <div class="col-12 col-md-6 mb-2 mb-md-0 d-flex justify-content-center">
            <form id="search" class="input__wrapper d-flex justify-content-center" method="post" action="SignedProduct.php" style="width:100%">
                <input id="searchSanPham" name="searchFromAnotherPage" type="text" class="form-control me-2 search-input" placeholder="Tìm kiếm" style="width:90%" required="" />
                <button id="filter-button" class="btn btn-primary" type="submit" style="width:10%">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </button>
            </form>
        </div>

        <div id="Home-login" class="col-6 col-md-2 text-end text-center">
            <button class="btn btn-light text-danger" style="color:rgb(146, 26, 26) !important;font-weight:bold;">Login</button>
        </div>

    </div>
</header>

<script src=" https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

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