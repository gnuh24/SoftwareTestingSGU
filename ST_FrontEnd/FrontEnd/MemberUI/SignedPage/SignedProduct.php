<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
    <link rel="stylesheet" href="SignedProduct.css" />
    <link rel="stylesheet" href="SignedHomePage.css" />
    <title>Các sản phẩm</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

</head>

<body>
    <?php require_once "../Header/SignedHeader.php" ?>
    <!-- Thanh lọc menu -->
    <div id="filter-menu" class="container-fluid bg-white p-3 rounded mb-4">
        <div class="row" style="width:80%">
            <div class="col-12 col-md-3 mb-2 mb-md-0">
                <label for="price-filter" class="form-label text-danger fw-bold">Giá:</label>
                <select id="price-filter" class="form-select form-select-sm bg-danger text-white">
                    <option value="">Tất cả</option>
                    <option value="low">Dưới 1 triệu</option>
                    <option value="medium">Từ 1 đến 3 triệu</option>
                    <option value="high">Trên 3 triệu</option>
                </select>
            </div>

            <div class="col-12 col-md-3 mb-2 mb-md-0">
                <label for="brand-filter" class="form-label text-danger fw-bold">Thương hiệu :</label>
                <select id="brand-filter" class="form-select form-select-sm bg-danger text-white">

                </select>
            </div>

            <div class="col-12 col-md-3 mb-2 mb-md-0">
                <label for="category-filter" class="form-label text-danger fw-bold">Loại sản phẩm:</label>
                <select id="category-filter" class="form-select form-select-sm bg-danger text-white">
                    <!-- Hiển thị menu LoaiSanPham -->
                </select>
            </div>

        </div>
        <button id="reset-button" class="btn btn-danger mt-2 mt-md-0">
            <i class="fa-solid fa-rotate-right"></i>
        </button>

    </div>

    <section id="product" style="padding: 0 5%;">
        <div class="products">
            <!-- Hiển thị vài sản phẩm nổi bật -->
        </div>

    </section>


    <div class="pagination" id="pagination"></div>

    <!-- Footer -->
    <?php require_once "../Footer/Footer.php" ?>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // Lắng nghe sự kiện click vào id "reset-button"
        document.getElementById("reset-button").addEventListener("click", function() {
            // Reset tất cả các thanh lọc về giá trị mặc định
            document.getElementById("searchSanPham").value = "";
            document.getElementById("price-filter").value = "";
            document.getElementById("brand-filter").value = "";
            document.getElementById("category-filter").value = "";
            currentPage = 1;

            // Gọi lại hàm getAllSanPham với các giá trị mặc định
            getAllSanPham(currentPage, "", 0, 10000000, 0, 0);

        });


        function formatCurrency(number) {
            // Chuyển đổi số thành chuỗi và đảm bảo nó là số nguyên
            number = parseInt(number);

            // Sử dụng hàm toLocaleString() để định dạng số tiền
            // và thêm đơn vị tiền tệ "đ" vào cuối chuỗi
            return number.toLocaleString('vi-VN', {
                style: 'currency',
                currency: 'VND'
            });
        }


        // Lắng nghe sự kiện change cho thanh lọc giá
        document.getElementById("price-filter").addEventListener("change", function() {
            currentPage = 1;

            // Gọi lại hàm lọc sản phẩm khi giá trị thay đổi
            filterProducts(currentPage);
        });

        document.getElementById("brand-filter").addEventListener("change", function() {
            currentPage = 1;

            // Gọi lại hàm lọc sản phẩm khi giá trị thay đổi
            filterProducts(currentPage);
        });
        // Lắng nghe sự kiện change cho thanh lọc loại sản phẩm
        document.getElementById("category-filter").addEventListener("change", function() {
            currentPage = 1;

            // Gọi lại hàm lọc sản phẩm khi giá trị thay đổi
            filterProducts(currentPage);
        });
        // Hàm lọc sản phẩm
        function filterProducts(page) {
            // Lấy giá trị từ thanh tìm kiếm (hoặc từ URL nếu có)
            var searchParams = new URLSearchParams(window.location.search);
            var searchText = searchParams.get('search') || document.getElementById("searchSanPham").value || " ";

            // Lấy giá trị từ thanh lọc giá
            var priceFilter = document.getElementById("price-filter").value;
            var minPrice, maxPrice;
            // Thiết lập giá trị min và max dựa trên giá trị của thanh lọc giá
            switch (priceFilter) {
                case "low":
                    minPrice = 0;
                    maxPrice = 1000000;
                    break;
                case "medium":
                    minPrice = 1000000;
                    maxPrice = 3000000;
                    break;
                case "high":
                    minPrice = 3000000;
                    maxPrice = 1000000000; // Trên 3 triệu, không giới hạn
                    break;
                default:
                    minPrice = 0;
                    maxPrice = 1000000000; // Không giới hạn
                    break;
            }

            // Lấy giá trị từ thanh lọc thương hiệu
            var brandFilter = document.getElementById("brand-filter").value;
            if (brandFilter == "") {
                brandFilter = 0;
            }

            // Lấy giá trị từ thanh lọc loại sản phẩm
            var categoryFilter = document.getElementById("category-filter").value;
            if (categoryFilter == "") {
                categoryFilter = 0;
            }

            // Gọi hàm lọc sản phẩm với các tham số vừa lấy được
            getAllSanPham(page, searchText, minPrice, maxPrice, brandFilter, categoryFilter);
        }

        // Lắng nghe sự kiện click vào nút search
        document.getElementById("filter-button").addEventListener("click", function(event) {
            currentPage = 1;
            event.preventDefault();

            // Lấy giá trị từ thanh tìm kiếm
            var searchText = document.getElementById("searchSanPham").value;
            // Lấy giá trị từ thanh lọc giá
            var priceFilter = document.getElementById("price-filter").value;
            var minPrice, maxPrice;

            // Thiết lập giá trị min và max dựa trên giá trị của thanh lọc giá
            switch (priceFilter) {
                case "low":
                    minPrice = 0;
                    maxPrice = 1000000;
                    break;
                case "medium":
                    minPrice = 1000000;
                    maxPrice = 3000000;
                    break;
                case "high":
                    minPrice = 3000000;
                    maxPrice = 1000000000; // Trên 3 triệu, không giới hạn
                    break;
                default:
                    minPrice = 0;
                    maxPrice = 1000000000; // Không giới hạn
                    break;
            }


            var brandFilter = document.getElementById("brand-filter").value;
            if (brandFilter == "") {
                brandFilter = 0;
            }


            // Lấy giá trị từ thanh lọc loại sản phẩm
            var categoryFilter = document.getElementById("category-filter").value;
            if (categoryFilter == "") {
                categoryFilter = 0;
            }

            getAllSanPham(currentPage, searchText, minPrice, maxPrice, brandFilter, categoryFilter);

        });


        // Gọi hàm getAllLoaiSanPham khi trang được tải
        $(document).ready(function() {
            getCategories();
            getBrands();
            var currentPage = 1;
            filterProducts(currentPage);

        });

        function getAllSanPham(page, search, minGia, maxGia, brandId, categoryId) {
            // Gọi API để lấy dữ liệu sản phẩm
            console.log(page, search, minGia, maxGia, brandId, categoryId)
            $.ajax({
                url: "http://localhost:8080/Product/CommonUser",
                method: "GET",
                dataType: "json",
                data: (function() {
                    var requestData = {
                        page: page,
                        minPrice: minGia,
                        maxPrice: maxGia,
                        pageSize: 12,
                    };

                    // Nếu search có giá trị, thêm vào requestData
                    if (search && search.trim() !== "") {
                        requestData.search = search;
                    }

                    // Nếu brandId khác 0, thêm vào requestData
                    if (brandId !== 0) {
                        requestData.brandId = brandId;
                    }

                    // Nếu categoryId khác 0, thêm vào requestData
                    if (categoryId !== 0) {
                        requestData.categoryId = categoryId;
                    }

                    return requestData;
                })(),
                success: function(response) {
                    var productContainer = $('#product .products');
                    if (response.content && response.content.length > 0) {
                        // Tạo biến lưu trữ nội dung HTML mới
                        var htmlContent = '';
                        // Duyệt qua từng sản phẩm và tạo nội dung HTML tương ứng
                        $.each(response.content, function(index, product) {
                            htmlContent += ` 
                                    <form id="productForm_${product.id}" method="post" action="SignedProductDetail.php?maSanPham=${product.id}">
                                        <div class="row">
                                            <a href="SignedProductDetail.php?maSanPham=${product.id}" class="text-center" style="display: block;">
                                                <img src="http://res.cloudinary.com/djhoea2bo/image/upload/v1711511636/${product.image}" alt="" style="height: 300px;">
                                                <div class="product-card-content">
                                                    <div class="price">
                                                        <h4 class="name-product">${product.productName}</h4>
                                                        <p class="price-tea">${formatCurrency(product.price)}</p>
                                                    </div>
                                                    <div class="buy-btn-container">
                                                        <span class="btn btn-primary" style="background:none; color:black;border:none;">Mua ngay</span>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    </form>
                                `;

                        });
                        // Trong hàm getAllSanPham, sau khi thay đổi nội dung HTML của sản phẩm, gọi lại hàm createPagination
                        productContainer.html(htmlContent);


                        // Đưa giao diện về đầu trang
                        window.scrollTo({
                            top: 0,
                            behavior: 'smooth' // Tuỳ chọn, nếu muốn di chuyển mượt hơn
                        });

                    } else {
                        // Hiển thị thông báo khi không có sản phẩm
                        productContainer.html('<p style="font-size: 24px; text-align: center; ">Không có sản phẩm nào.</p>');
                    }

                    createPagination(page, response.totalPages);

                },
                error: function(xhr, status, error) {
                    console.error("Error:", error);
                }
            });
        }

        // Hàm tạo nút phân trang
        function createPagination(currentPage, totalPages) {
            var paginationContainer = document.getElementById("pagination");

            // Xóa nút phân trang cũ (nếu có)
            paginationContainer.innerHTML = '';

            if (totalPages > 1) {

                // Tạo nút cho từng trang và thêm vào chuỗi HTML
                var paginationHTML = '';
                for (var i = 1; i <= totalPages; i++) {
                    paginationHTML += '<button class="pageButton">' + i + '</button>';
                }

                // Thiết lập nút phân trang vào paginationContainer
                paginationContainer.innerHTML = paginationHTML;

                // Thêm sự kiện click cho từng nút phân trang
                paginationContainer.querySelectorAll('.pageButton').forEach(function(button, index) {
                    button.addEventListener('click', function() {
                        // Gọi hàm filterProducts khi người dùng click vào nút phân trang
                        filterProducts(index + 1); // Thêm 1 vào index để chuyển đổi về trang 1-indexed
                    });
                });

                // Đánh dấu trang hiện tại
                paginationContainer.querySelector('.pageButton:nth-child(' + currentPage + ')').classList.add('active');
            }

        }


        function getCategories() {
            $.ajax({
                url: "http://localhost:8080/Category/noPaging",
                method: "GET",
                dataType: "json",
                success: function(response) {
                    if (response && response.length > 0) {
                        // Xóa tất cả các option hiện có trong dropdown
                        $('#category-filter').empty();
                        // Thêm option "Tất cả"
                        $('#category-filter').append('<option value="">Tất cả</option>');
                        // Duyệt qua danh sách loại sản phẩm và thêm từng option vào dropdown
                        $.each(response, function(index, category) {
                            $('#category-filter').append(`<option value="${category.id}">${category.categoryName}</option>`);
                        });
                    } else {
                        console.log("Không có loại sản phẩm nào được trả về từ API.");
                    }
                },
                error: function(xhr, status, error) {
                    console.error("Error:", error);
                }
            });
        }

        function getBrands() {
            $.ajax({
                url: "http://localhost:8080/Brand",
                method: "GET",
                dataType: "json",
                success: function(response) {
                    if (response.content && response.content.length > 0) {
                        // Xóa tất cả các option hiện có trong dropdown
                        $('#brand-filter').empty();
                        // Thêm option "Tất cả"
                        $('#brand-filter').append('<option value="">Tất cả</option>');
                        // Duyệt qua danh sách loại sản phẩm và thêm từng option vào dropdown
                        $.each(response.content, function(index, category) {
                            $('#brand-filter').append(`<option value="${category.brandId}">${category.brandName}</option>`);
                        });
                    } else {
                        console.log("Không có loại sản phẩm nào được trả về từ API.");
                    }
                },
                error: function(xhr, status, error) {
                    console.error("Error:", error);
                }
            });
        }

        function detail(maSanPham) {
            window.location.href = `SignedProductDetail.php?maSanPham=${maSanPham}`;
        }
    </script>
</body>

</html>