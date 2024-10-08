<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
    <link rel="stylesheet" href="HomePage.css" />
    <link rel="stylesheet" href="GuestProductDetail.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="login.css" />
    <title>Chi tiết sản phẩm</title>
</head>
<style>
    .quantity-available {
        color: red;
    }

    .product__wrapper {
        padding: 20px;
    }

    .product_images__wrapper {
        display: flex;
        justify-content: center;
        margin-bottom: 20px;
    }

    .product_img {
        max-height: 400px;
        border: 2px solid black;
    }

    .info__wrapper {
        margin-left: 30px;
    }

    .price {
        font-size: 1.5rem;
        font-weight: bold;
        color: rgb(146, 26, 26);
    }

    .quantity-available .title {
        color: rgb(146, 26, 26);
    }

    .button__wrapper {
        margin-top: 20px;
    }

    .btn-secondary {
        background-color: rgb(146, 26, 26);
        border: none;
    }

    .btn-secondary:hover {
        background-color: #a31e1e;
    }
</style>

<body>
    <?php require_once "../Header/GuestHeader.php"; ?>

    <section>
        <div class="text-center mb-4">
            <div class="title_section">
                <h2 class="text-danger" style="color:rgb(146, 26, 26) !important">Chi tiết sản phẩm</h2>
            </div>
        </div>
    </section>

    <section>
        <div class="product-detail-wrapper">
            <div class="product__wrapper containerPage">
                <!-- HTML sẽ được cập nhật qua JavaScript -->
            </div>
        </div>
    </section>

    <?php require_once "../Footer/Footer.php"; ?>



</body>


<script>
    // Kiểm tra sự kiện của khi người dùng "cố tình" nhập vào số lượng lớn hơn hoặc để trống.
    function checkQuantity(input) {
        var maxQuantity = parseInt(input.getAttribute("max")); // Lấy giá trị cận trên
        var enteredQuantity = parseInt(input.value); // Lấy giá trị số lượng nhập vào

        // Kiểm tra nếu giá trị nhập vào không phải là một số hoặc là một chuỗi rỗng
        if (isNaN(enteredQuantity) || input.value.trim() === "") {
            // Đặt giá trị là 1
            input.value = 1;
        } else if (enteredQuantity < 0) { // Nếu số lượng nhập vào nhỏ hơn 0
            input.value = 0; // Đặt giá trị là 0
        } else if (enteredQuantity > maxQuantity) { // Nếu số lượng nhập vào lớn hơn số lượng tối đa
            input.value = maxQuantity; // Đặt giá trị là số lượng tối đa
        }
    }

    $(document).ready(function() {
        const queryString = window.location.search;
        const urlParams = new URLSearchParams(queryString);
        const maSanPham = urlParams.get('maSanPham');

        if (maSanPham) {
            $.ajax({
                url: `http://localhost:8080/Product/CommonUser/` + maSanPham,
                method: "GET",
                dataType: "json",
                success: function(response) {
                    const product = response;
                    const soLuongConLai = product.quantity;
                    const quantityMessage = soLuongConLai > 0 ?
                        `Còn ${soLuongConLai} sản phẩm` :
                        `<span style='color: red;'>Sản phẩm đã hết hàng</span>`;
                    const productImage = product.image ? product.image : 'placeholder-image-url';
                    const productName = product.productName ? product.productName : 'Tên sản phẩm chưa cập nhật';
                    const origin = product.origin ? product.origin : 'Xuất xứ chưa cập nhật';
                    const categoryName = product.category && product.category.categoryName ? product.category.categoryName : 'Loại sản phẩm chưa cập nhật';
                    const brandName = product.brand && product.brand.brandName ? product.brand.brandName : 'Thương hiệu chưa cập nhật';
                    const abv = product.abv ? product.abv : 'N/A';
                    const capacity = product.capacity ? product.capacity : 'N/A';
                    const description = product.description ? product.description : 'Thông tin chi tiết chưa được cập nhật.';
                    const price = product.price ? product.price : 'Giá chưa cập nhật';

                    let htmlContent = `
                        <div class="product_images__wrapper">
                            <div class="image">
                                <img src="http://res.cloudinary.com/djhoea2bo/image/upload/v1711511636/${productImage}" alt="${product.productName}" class="product_img">
                            </div>
                        </div>
                        <div class="info__wrapper">
                            <div class="title__wrapper">
                                <h2 class="title__wrapper">${productName}</h2>
                            </div>
                            <div class="price__wrapper">
                                <p class="price">${formatCurrency(price)}</p>
                            </div>
                            <div class="quantity-available">
                                <p class="title">${quantityMessage}</p>
                            </div>
                            <div class="divider" style="border-bottom: 1px solid #ccc; margin: 20px 0;"></div>
                            <div class="detail_info__wrapper">
                                <div class="specification__wrapper">
                                    <span class="origin specification_item">
                                        <i class="fa-solid fa-plane"></i>
                                        <p>${origin}</p>
                                    </span>
                                    <span class="specification_item">
                                        <i class="fa-solid fa-wine-bottle"></i>
                                        <p>${categoryName}</p>
                                    </span>
                                    <span class="origin specification_item">
                                        <i class="fa-solid fa-tag"></i>
                                        <p>${brandName}</p>
                                    </span>                              
                                </div>
                                <div class="size__wrapper">
                                    <p class="title">Nồng độ cồn</p>
                                    <p>${abv}%</p>
                                </div>
                                <div class="size__wrapper">
                                    <p class="title">Dung tích</p>
                                    <p>${capacity}ml</p>
                                </div>
                                <div class="quantity__wrapper" style="display: flex; align-items: center;">`;

                    if (soLuongConLai > 0) {
                        htmlContent += `
                            <p class="title">Số lượng</p>
                            <div class="quantity d-flex align-items-center">
                                <button class="btn btn-outline-secondary minusBtn"><i class="fa-solid fa-minus"></i></button>
                                <input type="number" value="1" min="1" max="${soLuongConLai}" class="form-control mx-2" oninput="checkQuantity(this)">
                                <button class="btn btn-outline-secondary plusBtn"><i class="fa-solid fa-plus"></i></button>
                            </div>`;
                    }

                    htmlContent += `</div>
                            <div class="button__wrapper">`;


                    htmlContent += `
                            <button class="btn btn-secondary" >
                                <span>Mua ngay</span>
                            </button>
                        </div>
                    </div>
                    </div>

                    `;
                    htmlContent += `<div class="description text-center"><h1>Thông tin chi tiết</h1>
                    <div> ${description}</div>
                    </div>`;
                    $('.product__wrapper').html(htmlContent);
                    // Lắng nghe sự kiện click vào nút "Thêm vào giỏ hàng"
                    // Gắn các sự kiện cho nút "Mua ngay" sau khi HTML đã được thêm vào DOM
                    document.querySelector(".btn-primary").addEventListener("click", function() {
                        window.location.href = '../Login/LoginUI.php'; // Chuyển hướng đến trang Login khi click
                    });

                    // Gắn các sự kiện cho nút "Thêm vào giỏ hàng" sau khi HTML đã được thêm vào DOM
                    document.querySelector(".btn-secondary").addEventListener("click", function() {
                        window.location.href = '../Login/LoginUI.php'; // Chuyển hướng đến trang Login khi click
                    });
                    // Gắn các sự kiện sau khi HTML đã được thêm vào DOM
                    document.querySelector(".minusBtn").addEventListener("click", function() {
                        var quantityInput = document.querySelector("input[type='number']");
                        var currentQuantity = parseInt(quantityInput.value);
                        if (currentQuantity > 1) {
                            quantityInput.value = currentQuantity - 1;
                        }
                    });

                    document.querySelector(".plusBtn").addEventListener("click", function() {
                        var quantityInput = document.querySelector("input[type='number']");
                        var currentQuantity = parseInt(quantityInput.value);
                        var maxQuantity = parseInt(quantityInput.getAttribute("max"));
                        if (currentQuantity < maxQuantity) {
                            quantityInput.value = currentQuantity + 1;
                        }
                    });
                },
                error: function(xhr, status, error) {
                    console.error("Error fetching product data:", error);
                }
            });
        } else {
            $('.product__wrapper').html('<p>Không có mã sản phẩm được cung cấp!</p>');
        }
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
</script>

</html>