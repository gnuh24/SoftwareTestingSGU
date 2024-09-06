<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
    <link rel="stylesheet" href="HomePage.css" />
    <link rel="stylesheet" href="login.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <title>Kinh doanh rượu</title>
</head>

<body>

    <?php require_once "../Header/GuestHeader.php"; ?>

    <section id="poster" style="width: 100%; height: auto; padding: 0 5%;">
        <img src="img/poster.jpg" style="max-width: 100%;">
    </section>


    <section>
        <div class="center-text">
            <div class="title_section">
                <div class="bar"></div>
                <h2 class="center-text-share">SẢN PHẨM NỔI BẬT</h2>
            </div>
        </div>
        <div class="icon-bottom-title">
            <img src="#" alt="" />
        </div>
    </section>


    <section id="product">
        <div class="container">
            <div class="row products">
                <!-- Hiển thị vài sản phẩm nổi bật -->
            </div>
        </div>
    </section>
    <div class="text-center my-4">
        <button id="btn-load-more" class="btn btn-primary">Xem thêm các sản phẩm</button>
    </div>



    <!-- Dịch vụ -->
    <section class="Home-service container py-5" style="height: fit-content;">
        <div class="row" style="width:100%;height:fit-content;">
            <!-- Service 1 -->
            <div class="Home-service-child col-12 col-md-4 text-center mb-4">
                <div>
                    <img class="Home-service-img img-fluid" src="img/service-1.jpg" alt="" />
                </div>
                <h2 class="home-heading-service">Giao Hàng nhanh</h2>
                <p class="home-txt-service">
                    Winemart sẽ luôn cố gắng giao hàng nhanh nhất có thể
                </p>
            </div>

            <!-- Service 2 -->
            <div class="Home-service-child col-12 col-md-4 text-center mb-4">
                <div>
                    <img class="Home-service-img img-fluid" src="img/service2.jpg" alt="" />
                </div>
                <h2 class="home-heading-service">Hỗ trợ khách hàng</h2>
                <p class="home-txt-service">
                    Chăm sóc, tư vấn và hỗ trợ khách hàng gọi ngay <br>
                    1900.636.035
                </p>
            </div>

            <!-- Service 3 -->
            <div class="Home-service-child col-12 col-md-4 text-center mb-4">
                <div>
                    <img class="Home-service-img img-fluid" src="img/service3.jpg" alt="" />
                </div>
                <h2 class="home-heading-service">Thanh toán thuận tiện</h2>
                <p class="home-txt-service">
                    Winemart hỗ trợ thanh toán<br />
                    COD "Trong nội thành TP.HCM" và chuyển khoản
                </p>
            </div>
        </div>
    </section>


    <?php require_once "../Footer/Footer.php" ?>
</body>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
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

    // Lắng nghe sự kiện click vào Poster
    document
        .getElementById("poster")
        .addEventListener("click", function() {
            window.location.href = 'GuestProduct.php';
        });


    // Lắng nghe sự kiện click vào Xem thêm
    document
        .getElementById("btn-load-more")
        .addEventListener("click", function() {
            window.location.href = 'GuestProduct.php';
        });

    // Gọi hàm getAllLoaiSanPham khi trang được tải
    $(document).ready(function() {
        getAllSanPham();
    });


    // Hàm getAllSanPham
    function getAllSanPham() {
        // Gọi API để lấy dữ liệu sản phẩm
        $.ajax({
            url: "http://localhost:8080/Product/CommonUser",
            method: "GET",
            dataType: "json",

            success: function(response) {
                var productContainer = $('#product .products');
                if (response.content && response.content.length > 0) {
                    // Tạo biến lưu trữ nội dung HTML mới
                    var htmlContent = '';
                    // Biến đếm số lượng sản phẩm
                    var count = 0;
                    // Duyệt qua từng sản phẩm và tạo nội dung HTML tương ứng
                    $.each(response.content, function(index, product) {
                        // Kiểm tra nếu số lượng sản phẩm đã đạt tới 4 thì dừng lại
                        if (count >= 3) {
                            return false;
                        }
                        var imageSrc = product.AnhMinhHoa;
                        htmlContent += `
                        <div class="col-md-4 col-sm-6 mb-4">
                            <div class="product-card-content">
                                <a href="GuestProductDetail.php?maSanPham=${product.id}">
                                    <img src="http://res.cloudinary.com/djhoea2bo/image/upload/v1711511636/${product.image}" alt="" style="height: 300px;">
                                    <div class="product-card-details">
                                        <h4 class="name-product">${product.productName}</h4>
                                        <p class="price-tea">${formatCurrency(product.price)}</p>
                                        <div class="buy-btn-container">
                                            <a href="GuestProductDetail.php?maSanPham=${product.id}" class="btn ">Mua ngay</a>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    `;
                        // Tăng biến đếm lên 1 sau mỗi sản phẩm được thêm vào
                        count++;
                    });
                    // Thay đổi nội dung HTML của phần tử sản phẩm
                    productContainer.html(htmlContent);
                } else {
                    // Hiển thị thông báo khi không có sản phẩm
                    productContainer.html('<p>Không có sản phẩm nào.</p>');
                }
            },
            error: function(xhr, status, error) {
                console.error("Error:", error);
            }
        });
    }

    function detail(maSanPham) {
        // Chuyển hướng về trang chủ khi click vào hình ảnh
        window.location.href = `GuestProductDetail.php?maSanPham=${maSanPham}`;
    }
</script>

</html>