<?php
session_start();
require __DIR__ . "/api/api.php";
require __DIR__ . "/utils/utils.php";
error_reporting(E_ALL);
ini_set("", 1);

$utils = new Utils;

// api endpoints
$fetchAllMediaApi = getenv("FETCH_ALL_MEDIA_API");
$fetchAllProductApi = getenv("FETCH_ALL_PRODUCT_API");
$fetchAllProductCategoryApi = getenv("FETCH_ALL_PRODUCT_CATEGORY_API");
$subscribeNewsLetterApi = getenv("NEWSLETTER_SUBSCRIBE");

// response data
$resultMedia = $utils->fetchFromApi($fetchAllMediaApi);
$resultProduct = $utils->fetchFromApi($fetchAllProductApi);
$resultProductCategory = $utils->fetchFromApi($fetchAllProductCategoryApi);


// Filter the data to include only items with category "BANNER"
$bannerImages = array_filter($resultMedia['data']['data'], function ($item) {
    return isset($item['category']) && $item['category'] === 'BANNER';
});

$heroSectionImages = array_filter($resultMedia['data']['data'], function ($item) {
    return isset($item['category']) && $item['category'] === 'HEROSECTION';
});

$advertisementImages = array_filter($resultMedia['data']['data'], function ($item) {
    return isset($item['category']) && $item['category'] === 'ADVERTISEMENT';
});

$productsImages = array_filter($resultMedia['data']['data'], function ($item) {
    return isset($item['category']) && $item['category'] === 'PRODUCT';
});

// echo "<pre>";
// print_r($advertisementImages);
// exit;




?>

<!DOCTYPE html>
<html lang="en" class="color-two font-exo header-style-two">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Title -->
    <title> Wishlist</title>
    <!-- Favicon -->
    <link rel="shortcut icon" href="assets/images/logo/favicon.png">

    <!-- Bootstrap -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <!-- select 2 -->
    <link rel="stylesheet" href="assets/css/select2.min.css">
    <!-- Slick -->
    <link rel="stylesheet" href="assets/css/slick.css">
    <!-- Jquery Ui -->
    <link rel="stylesheet" href="assets/css/jquery-ui.css">
    <!-- animate -->
    <link rel="stylesheet" href="assets/css/animate.css">
    <!-- AOS Animation -->
    <link rel="stylesheet" href="assets/css/aos.css">
    <!-- Main css -->
    <link rel="stylesheet" href="assets/css/main.css">
    <!-- notyfy -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">
    <script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>
    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>

<body>

    <!--==================== Preloader Start ====================-->
    <div class="preloader">
        <img src="assets/images/icon/preloader.gif" alt="">
    </div>
    <!--==================== Preloader End ====================-->

    <!--==================== Overlay Start ====================-->
    <div class="overlay"></div>
    <!--==================== Overlay End ====================-->

    <!--==================== Sidebar Overlay End ====================-->
    <div class="side-overlay"></div>
    <!--==================== Sidebar Overlay End ====================-->

    <!-- ==================== Scroll to Top End Here ==================== -->
    <div class="progress-wrap">
        <svg class="progress-circle svg-content" width="100%" height="100%" viewBox="-1 -1 102 102">
            <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98" />
        </svg>
    </div>
    <!-- ==================== Scroll to Top End Here ==================== -->

    <!-- ==================== Search Box Start Here ==================== -->
    <form action="#" class="search-box">
        <button type="button"
            class="search-box__close position-absolute inset-block-start-0 inset-inline-end-0 m-16 w-48 h-48 border border-gray-100 rounded-circle flex-center text-white hover-text-gray-800 hover-bg-white text-2xl transition-1">
            <i class="ph ph-x"></i>
        </button>
        <div class="container">
            <div class="position-relative">
                <input type="text" class="form-control py-16 px-24 text-xl rounded-pill pe-64"
                    placeholder="Search for a product or brand">
                <button type="submit"
                    class="w-48 h-48 bg-main-600 rounded-circle flex-center text-xl text-white position-absolute top-50 translate-middle-y inset-inline-end-0 me-8">
                    <i class="ph ph-magnifying-glass"></i>
                </button>
            </div>
        </div>
    </form>
    <!-- ==================== Search Box End Here ==================== -->

    <!-- ==================== Mobile Menu Start Here ==================== -->
    <div class="mobile-menu scroll-sm d-lg-none d-block">
        <button type="button" class="close-button"> <i class="ph ph-x"></i> </button>
        <?php require_once 'components/mobile-menu.php' ?>
    </div>
    <!-- ==================== Mobile Menu End Here ==================== -->


    <!-- ======================= Middle Top Start ========================= -->
    <div class="header-top bg-main-600 flex-between">
        <div class="container container-lg">
            <?php require_once 'components/top-header.php' ?>
        </div>
    </div>
    <!-- ======================= Middle Top End ========================= -->

    <!-- ======================= Middle Header Start ========================= -->
    <header class="header-middle border-bottom border-gray-100">
        <div class="container container-lg">
            <?php require_once 'components/middle-header.php' ?>
        </div>
    </header>
    <!-- ======================= Middle Header End ========================= -->

    <!-- ==================== Header Start Here ==================== -->
    <header class="header bg-white border-bottom-0 box-shadow-3xl py-10 z-2">
        <div class="container container-lg">
            <nav class="header-inner d-flex justify-content-between gap-8">
                <?php require_once 'components/header.php' ?>
            </nav>
        </div>
    </header>
    <!-- ==================== Header End Here ==================== -->

    <!-- ========================= Breadcrumb Start =============================== -->
    <div class="breadcrumb mb-0 py-26 bg-main-two-50">
        <div class="container container-lg">
            <div class="breadcrumb-wrapper flex-between flex-wrap gap-16">
                <h6 class="mb-0">My Wishlist</h6>
                <ul class="flex-align gap-8 flex-wrap">
                    <li class="text-sm">
                        <a href="<?= getenv("BASE_URL") ?>" class="text-gray-900 flex-align gap-8 hover-text-main-600">
                            <i class="ph ph-house"></i>
                            Home
                        </a>
                    </li>
                    <li class="flex-align">
                        <i class="ph ph-caret-right"></i>
                    </li>
                    <li class="text-sm text-main-600"> Wishlist </li>
                </ul>
            </div>
        </div>
    </div>
    <!-- ========================= Breadcrumb End =============================== -->

    <!-- ================================ Cart Section Start ================================ -->
    <section class="cart py-80">
        <div class="container container-lg">
            <div class="row gy-4">
                <div class="col-lg-11">
                    <div class="cart-table border border-gray-100 rounded-8">
                        <div class="overflow-x-auto scroll-sm scroll-sm-horizontal">
                            <table class="table rounded-8 overflow-hidden">
                                <thead>
                                    <tr class="border-bottom border-neutral-100">
                                        <th class="h6 mb-0 text-lg fw-bold px-40 py-32 border-end border-neutral-100">
                                            Delete</th>
                                        <th class="h6 mb-0 text-lg fw-bold px-40 py-32 border-end border-neutral-100">
                                            Product Name</th>
                                        <th class="h6 mb-0 text-lg fw-bold px-40 py-32 border-end border-neutral-100">
                                            Unit Price</th>
                                        <th class="h6 mb-0 text-lg fw-bold px-40 py-32 border-end border-neutral-100">
                                            Stock Status</th>
                                        <th class="h6 mb-0 text-lg fw-bold px-40 py-32"></th>
                                    </tr>
                                </thead>
                                <tbody id="wishlistTableBody">
                                    <tr class="">
                                        <td class="px-40 py-32 border-end border-neutral-100">
                                            <button type="button"
                                                class="remove-tr-btn flex-align gap-12 hover-text-danger-600">
                                                <i class="ph ph-x-circle text-2xl d-flex"></i>
                                                Remove
                                            </button>
                                        </td>
                                        <td class="px-40 py-32 border-end border-neutral-100">
                                            <div class="table-product d-flex align-items-center gap-24">
                                                <a href="product-details-two.php"
                                                    class="table-product__thumb border border-gray-100 rounded-8 flex-center ">
                                                    <img src="assets/images/thumbs/product-two-img1.png" alt="">
                                                </a>
                                                <div class="table-product__content text-start">

                                                    <h6 class="title text-lg fw-semibold mb-8">
                                                        <a href="product-details.php" class="link text-line-2"
                                                            tabindex="0">Taylor Farms Broccoli Florets Vegetables</a>
                                                    </h6>

                                                    <div class="flex-align gap-16 mb-16">
                                                        <div class="flex-align gap-6">
                                                            <span class="text-md fw-medium text-warning-600 d-flex"><i
                                                                    class="ph-fill ph-star"></i></span>
                                                            <span class="text-md fw-semibold text-gray-900">4.8</span>
                                                        </div>
                                                        <span class="text-sm fw-medium text-gray-200">|</span>
                                                        <span class="text-neutral-600 text-sm">128 Reviews</span>
                                                    </div>

                                                    <div class="flex-align gap-16">
                                                        <a href="cart.php"
                                                            class="product-card__cart btn bg-gray-50 text-heading text-sm hover-bg-main-600 hover-text-white py-7 px-8 rounded-8 flex-center gap-8 fw-medium">
                                                            Camera
                                                        </a>
                                                        <a href="cart.php"
                                                            class="product-card__cart btn bg-gray-50 text-heading text-sm hover-bg-main-600 hover-text-white py-7 px-8 rounded-8 flex-center gap-8 fw-medium">
                                                            Videos
                                                        </a>
                                                    </div>

                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-40 py-32 border-end border-neutral-100">
                                            <span class="text-lg h6 mb-0 fw-semibold">$125.00</span>
                                        </td>
                                        <td class="px-40 py-32 border-end border-neutral-100">
                                            <span class="text-lg h6 mb-0 fw-semibold">In Stock</span>
                                        </td>
                                        <td class="px-40 py-32">
                                            <a href="cart.php" class="btn btn-main-two rounded-8 px-64">
                                                Add To Cart <i class="ph ph-shopping-cart"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    <tr class="">
                                        <td class="px-40 py-32 border-end border-neutral-100">
                                            <button type="button"
                                                class="remove-tr-btn flex-align gap-12 hover-text-danger-600">
                                                <i class="ph ph-x-circle text-2xl d-flex"></i>
                                                Remove
                                            </button>
                                        </td>
                                        <td class="px-40 py-32 border-end border-neutral-100">
                                            <div class="table-product d-flex align-items-center gap-24">
                                                <a href="product-details-two.php"
                                                    class="table-product__thumb border border-gray-100 rounded-8 flex-center ">
                                                    <img src="assets/images/thumbs/product-two-img3.png" alt="">
                                                </a>
                                                <div class="table-product__content text-start">

                                                    <h6 class="title text-lg fw-semibold mb-8">
                                                        <a href="product-details.php" class="link text-line-2"
                                                            tabindex="0">Smart Phone With Intel Celeron</a>
                                                    </h6>

                                                    <div class="flex-align gap-16 mb-16">
                                                        <div class="flex-align gap-6">
                                                            <span class="text-md fw-medium text-warning-600 d-flex"><i
                                                                    class="ph-fill ph-star"></i></span>
                                                            <span class="text-md fw-semibold text-gray-900">4.8</span>
                                                        </div>
                                                        <span class="text-sm fw-medium text-gray-200">|</span>
                                                        <span class="text-neutral-600 text-sm">128 Reviews</span>
                                                    </div>

                                                    <div class="flex-align gap-16">
                                                        <a href="cart.php"
                                                            class="product-card__cart btn bg-gray-50 text-heading text-sm hover-bg-main-600 hover-text-white py-7 px-8 rounded-8 flex-center gap-8 fw-medium">
                                                            Camera
                                                        </a>
                                                        <a href="cart.php"
                                                            class="product-card__cart btn bg-gray-50 text-heading text-sm hover-bg-main-600 hover-text-white py-7 px-8 rounded-8 flex-center gap-8 fw-medium">
                                                            Videos
                                                        </a>
                                                    </div>

                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-40 py-32 border-end border-neutral-100">
                                            <span class="text-lg h6 mb-0 fw-semibold">$125.00</span>
                                        </td>
                                        <td class="px-40 py-32 border-end border-neutral-100">
                                            <span class="text-lg h6 mb-0 fw-semibold">In Stock</span>
                                        </td>
                                        <td class="px-40 py-32">
                                            <a href="cart.php" class="btn btn-main-two rounded-8 px-64">
                                                Add To Cart <i class="ph ph-shopping-cart"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    <tr class="">
                                        <td class="px-40 py-32 border-end border-neutral-100">
                                            <button type="button"
                                                class="remove-tr-btn flex-align gap-12 hover-text-danger-600">
                                                <i class="ph ph-x-circle text-2xl d-flex"></i>
                                                Remove
                                            </button>
                                        </td>
                                        <td class="px-40 py-32 border-end border-neutral-100">
                                            <div class="table-product d-flex align-items-center gap-24">
                                                <a href="product-details-two.php"
                                                    class="table-product__thumb border border-gray-100 rounded-8 flex-center ">
                                                    <img src="assets/images/thumbs/product-two-img14.png" alt="">
                                                </a>
                                                <div class="table-product__content text-start">

                                                    <h6 class="title text-lg fw-semibold mb-8">
                                                        <a href="product-details.php" class="link text-line-2"
                                                            tabindex="0">HP Chromebook With Intel Celeron</a>
                                                    </h6>

                                                    <div class="flex-align gap-16 mb-16">
                                                        <div class="flex-align gap-6">
                                                            <span class="text-md fw-medium text-warning-600 d-flex"><i
                                                                    class="ph-fill ph-star"></i></span>
                                                            <span class="text-md fw-semibold text-gray-900">4.8</span>
                                                        </div>
                                                        <span class="text-sm fw-medium text-gray-200">|</span>
                                                        <span class="text-neutral-600 text-sm">128 Reviews</span>
                                                    </div>

                                                    <div class="flex-align gap-16">
                                                        <a href="cart.php"
                                                            class="product-card__cart btn bg-gray-50 text-heading text-sm hover-bg-main-600 hover-text-white py-7 px-8 rounded-8 flex-center gap-8 fw-medium">
                                                            Camera
                                                        </a>
                                                        <a href="cart.php"
                                                            class="product-card__cart btn bg-gray-50 text-heading text-sm hover-bg-main-600 hover-text-white py-7 px-8 rounded-8 flex-center gap-8 fw-medium">
                                                            Videos
                                                        </a>
                                                    </div>

                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-40 py-32 border-end border-neutral-100">
                                            <span class="text-lg h6 mb-0 fw-semibold">$125.00</span>
                                        </td>
                                        <td class="px-40 py-32 border-end border-neutral-100">
                                            <span class="text-lg h6 mb-0 fw-semibold">In Stock</span>
                                        </td>
                                        <td class="px-40 py-32">
                                            <a href="cart.php" class="btn btn-main-two rounded-8 px-64">
                                                Add To Cart <i class="ph ph-shopping-cart"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    <tr class="">
                                        <td class="px-40 py-32 border-end border-neutral-100">
                                            <button type="button"
                                                class="remove-tr-btn flex-align gap-12 hover-text-danger-600">
                                                <i class="ph ph-x-circle text-2xl d-flex"></i>
                                                Remove
                                            </button>
                                        </td>
                                        <td class="px-40 py-32 border-end border-neutral-100">
                                            <div class="table-product d-flex align-items-center gap-24">
                                                <a href="product-details-two.php"
                                                    class="table-product__thumb border border-gray-100 rounded-8 flex-center ">
                                                    <img src="assets/images/thumbs/product-two-img2.png" alt="">
                                                </a>
                                                <div class="table-product__content text-start">

                                                    <h6 class="title text-lg fw-semibold mb-8">
                                                        <a href="product-details.php" class="link text-line-2"
                                                            tabindex="0">Smart watch With Intel Celeron</a>
                                                    </h6>

                                                    <div class="flex-align gap-16 mb-16">
                                                        <div class="flex-align gap-6">
                                                            <span class="text-md fw-medium text-warning-600 d-flex"><i
                                                                    class="ph-fill ph-star"></i></span>
                                                            <span class="text-md fw-semibold text-gray-900">4.8</span>
                                                        </div>
                                                        <span class="text-sm fw-medium text-gray-200">|</span>
                                                        <span class="text-neutral-600 text-sm">128 Reviews</span>
                                                    </div>

                                                    <div class="flex-align gap-16">
                                                        <a href="cart.php"
                                                            class="product-card__cart btn bg-gray-50 text-heading text-sm hover-bg-main-600 hover-text-white py-7 px-8 rounded-8 flex-center gap-8 fw-medium">
                                                            Camera
                                                        </a>
                                                        <a href="cart.php"
                                                            class="product-card__cart btn bg-gray-50 text-heading text-sm hover-bg-main-600 hover-text-white py-7 px-8 rounded-8 flex-center gap-8 fw-medium">
                                                            Videos
                                                        </a>
                                                    </div>

                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-40 py-32 border-end border-neutral-100">
                                            <span class="text-lg h6 mb-0 fw-semibold">$125.00</span>
                                        </td>
                                        <td class="px-40 py-32 border-end border-neutral-100">
                                            <span class="text-lg h6 mb-0 fw-semibold">In Stock</span>
                                        </td>
                                        <td class="px-40 py-32">
                                            <a href="cart.php" class="btn btn-main-two rounded-8 px-64">
                                                Add To Cart <i class="ph ph-shopping-cart"></i>
                                            </a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ================================ Cart Section End ================================ -->

    <!-- ========================== Shipping Section Start ============================ -->
    <section class="shipping mb-24" id="shipping">
        <div class="container container-lg">
            <div class="row gy-4">
                <div class="col-xxl-3 col-sm-6" data-aos="zoom-in" data-aos-duration="400">
                    <div class="shipping-item flex-align gap-16 rounded-16 bg-main-50 hover-bg-main-100 transition-2">
                        <span
                            class="w-56 h-56 flex-center rounded-circle bg-main-600 text-white text-32 flex-shrink-0"><i
                                class="ph-fill ph-car-profile"></i></span>
                        <div class="">
                            <h6 class="mb-0">Free Shipping</h6>
                            <span class="text-sm text-heading">Free shipping all over the US</span>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-3 col-sm-6" data-aos="zoom-in" data-aos-duration="600">
                    <div class="shipping-item flex-align gap-16 rounded-16 bg-main-50 hover-bg-main-100 transition-2">
                        <span
                            class="w-56 h-56 flex-center rounded-circle bg-main-600 text-white text-32 flex-shrink-0"><i
                                class="ph-fill ph-hand-heart"></i></span>
                        <div class="">
                            <h6 class="mb-0"> 100% Satisfaction</h6>
                            <span class="text-sm text-heading">Free shipping all over the US</span>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-3 col-sm-6" data-aos="zoom-in" data-aos-duration="800">
                    <div class="shipping-item flex-align gap-16 rounded-16 bg-main-50 hover-bg-main-100 transition-2">
                        <span
                            class="w-56 h-56 flex-center rounded-circle bg-main-600 text-white text-32 flex-shrink-0"><i
                                class="ph-fill ph-credit-card"></i></span>
                        <div class="">
                            <h6 class="mb-0"> Secure Payments</h6>
                            <span class="text-sm text-heading">Free shipping all over the US</span>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-3 col-sm-6" data-aos="zoom-in" data-aos-duration="1000">
                    <div class="shipping-item flex-align gap-16 rounded-16 bg-main-50 hover-bg-main-100 transition-2">
                        <span
                            class="w-56 h-56 flex-center rounded-circle bg-main-600 text-white text-32 flex-shrink-0"><i
                                class="ph-fill ph-chats"></i></span>
                        <div class="">
                            <h6 class="mb-0"> 24/7 Support</h6>
                            <span class="text-sm text-heading">Free shipping all over the US</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ========================== Shipping Section End ============================ -->

    <!-- ==================== Footer Start Here ==================== -->
    <footer class="footer py-120">
        <div class="container container-lg">
            <?php require_once 'components/top-footer.php' ?>
        </div>
    </footer>

    <!-- bottom Footer -->
    <div class="bottom-footer py-8">
        <div class="container container-lg">
            <?php require_once 'components/bottom-footer.php' ?>
        </div>
    </div>
    <!-- ==================== Footer End Here ==================== -->




    <!-- Jquery js -->
    <script src="assets/js/jquery-3.7.1.min.js"></script>
    <!-- Bootstrap Bundle Js -->
    <script src="assets/js/boostrap.bundle.min.js"></script>
    <!-- Bootstrap Bundle Js -->
    <script src="assets/js/phosphor-icon.js"></script>
    <!-- Select 2 -->
    <script src="assets/js/select2.min.js"></script>
    <!-- Slick js -->
    <script src="assets/js/slick.min.js"></script>
    <!-- count down js -->
    <script src="assets/js/count-down.js"></script>
    <!-- jquery UI js -->
    <script src="assets/js/jquery-ui.js"></script>
    <!-- wow js -->
    <script src="assets/js/wow.min.js"></script>
    <!-- AOS Animation -->
    <script src="assets/js/aos.js"></script>
    <!-- marque -->
    <script src="assets/js/marque.min.js"></script>
    <!-- marque -->
    <script src="assets/js/vanilla-tilt.min.js"></script>
    <!-- Counter -->
    <script src="assets/js/counter.min.js"></script>
    <!-- main js -->
    <script src="assets/js/main.js"></script>

    <script>
        $(document).ready(function () {
            let productIdsCart = JSON.parse(localStorage.getItem('cart')) || [];
            // Always update count directly
            $(".cart-item-count").text(productIdsCart.length);

            let productIdsWishlist = JSON.parse(localStorage.getItem('wishlist')) || [];
            // Always update count directly
            $(".wishlist-item-count").text(productIdsWishlist.length);


            let baseUrl = `<?= getenv("BASE_URL") ?>`;
            let productIds = JSON.parse(localStorage.getItem('wishlist'));

            if (productIds.length === 0) {
                Swal.fire({
                    title: 'Empty Wishlist',
                    text: 'Your Wishlist is empty. Add some products!',
                    icon: 'info',
                    confirmButtonText: 'Shop Now'
                }).then(() => {
                    // Redirect to shop page if needed
                    window.location.href = `${baseUrl}/product`;
                });
                return;
            }

            let products = [];

            function makeSlug(string) {
                return string.toLowerCase().replace(/\s+/g, "-");
            }

            $.when(...productIds.map(id =>
                $.ajax({
                    url: `<?php echo getenv("FETCH_ALL_PRODUCT_API") ?>/${id}`,
                    type: 'GET',
                    headers: {
                        'Accept': 'application/json'
                    }
                }).then(response => {
                    if (response.data) {
                        products.push(response.data);
                        console.log(response.data);

                    }
                })
            )).then(() => {
                // Function to populate the table with product data
                function populateWishlistTable(products) {
                    let tableBody = $('#wishlistTableBody');
                    tableBody.empty(); // Clear existing rows

                    products.forEach(product => {
                        let primaryImageUrl = product.images.find(img => img.isPrimary)?.imageUrl || `${baseUrl}/assets/images/thumbs/product-two-img1.png`;
                        let rating = product.reviews.length > 0 ? product.reviews[0].rating : 'No reviews';


                        let row = `
                        <tr class="">
                                        <td class="px-40 py-32 border-end border-neutral-100">
                                            <button type="button" data-product-id="${product.id}"
                                                class="remove-tr-btn flex-align gap-12 hover-text-danger-600">
                                                <i class="ph ph-x-circle text-2xl d-flex"></i>
                                                Remove
                                            </button>
                                        </td>
                                        <td class="px-40 py-32 border-end border-neutral-100">
                                            <div class="table-product d-flex align-items-center gap-24">
                                                <a href="product-details-two.php"
                                                    class="table-product__thumb border border-gray-100 rounded-8 flex-center ">
                                                    <img src="assets/images/thumbs/product-two-img1.png" alt="">
                                                </a>
                                                <div class="table-product__content text-start">

                                                    <h6 class="title text-lg fw-semibold mb-8">
                                                        <a href="${baseUrl + '/product/' + makeSlug(product.name)}" class="link text-line-2"
                                                            tabindex="0">${product.name}</a>
                                                    </h6>

                                                    <div class="flex-align gap-16 mb-16">
                                                        <div class="flex-align gap-6">
                                                            <span class="text-md fw-medium text-warning-600 d-flex"><i
                                                                    class="ph-fill ph-star"></i></span>
                                                            <span class="text-md fw-semibold text-gray-900">${rating}</span>
                                                        </div>
                                                        <span class="text-sm fw-medium text-gray-200">|</span>
                                                        <span class="text-neutral-600 text-sm">${product.reviews.length} Reviews</span>
                                                    </div>

                                                    <div class="flex-align gap-16">
                                                        <a href="${baseUrl + '/cart'}"
                                                            class="product-card__cart btn bg-gray-50 text-heading text-sm hover-bg-main-600 hover-text-white py-7 px-8 rounded-8 flex-center gap-8 fw-medium">
                                                            ${product.category.name}
                                                        </a>
                                                        <a href="cart.php"
                                                            class="product-card__cart btn bg-gray-50 text-heading text-sm hover-bg-main-600 hover-text-white py-7 px-8 rounded-8 flex-center gap-8 fw-medium">
                                                            ${product.subCategory.name}
                                                        </a>
                                                    </div>

                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-40 py-32 border-end border-neutral-100">
                                            <span class="text-lg h6 mb-0 fw-semibold">₹${product.price}</span>
                                        </td>
                                        <td class="px-40 py-32 border-end border-neutral-100">
                                            <span class="text-lg h6 mb-0 fw-semibold">In Stock</span>
                                        </td>
                                        <td class="px-40 py-32">
                                            <a href="cart.php" class="btn btn-main-two rounded-8 px-64">
                                                Add To Cart <i class="ph ph-shopping-cart"></i>
                                            </a>
                                        </td>
                                    </tr>
                        `;

                        tableBody.append(row);
                    });

                    updateCartSubtotal();

                }

                // Call the function to populate the table
                populateWishlistTable(products);

                if (products.length === 0) {
                    Swal.fire({
                        title: 'Empty Cart',
                        title: 'Error',
                        text: 'No products found in cart.',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                    return;
                }
            });

            $(document).on('click', '.remove-tr-btn', function (e) {
                e.preventDefault();
                let productId = $(this).data("product-id");
                let wishlist = JSON.parse(localStorage.getItem('wishlist')) || [];
                wishlist = wishlist.filter(id => id != productId);
                localStorage.setItem('wishlist', JSON.stringify(wishlist));
                $(this).closest('tr').remove();

                Swal.fire({
                    title: 'Product Removed',
                    text: 'Product removed from wishlist!',
                    icon: 'success',
                    timer: 1500,
                    showConfirmButton: false,
                    timerProgressBar: true,
                    willClose: () => {
                        window.location.reload();
                    }
                });
            });

            $.ajax({
                url: "<?php echo getenv("FETCH_ALL_MEDIA_API") ?>",
                type: "get",
                success: function (response, textStatus, xhr) {

                    if (response.data && Array.isArray(response.data)) {
                        const logoItems = response.data.filter(item => item.category === "LOGO");
                        logoItems.forEach(item => {
                            console.log(item.image);
                            let logoSection = $(".logo .link");
                            logoSection.empty();

                            logoSection.append(`
                            <img src="${item.image}" alt="${item.title}"/>
                        `);;
                        });
                    }

                },
                error: function (xhr) {
                    console.log(xhr);
                },
            });
        })
    </script>



</body>

</html>