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
    <title> Blog</title>
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
                <h6 class="mb-0">Blog</h6>
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
                    <li class="text-sm text-main-600"> Blog </li>
                </ul>
            </div>
        </div>
    </div>
    <!-- ========================= Breadcrumb End =============================== -->

    <!-- =============================== Blog Section Start =========================== -->
    <section class="blog py-80">
        <div class="container container-lg">
            <div class="row gy-5">
                <div class="col-lg-8 pe-xl-4">
                    <div class="blog-item-wrapper">
                        <div class="blog-item">
                            <a href="blog-details.php" class="w-100 h-100 rounded-16 overflow-hidden">
                                <img src="assets/images/thumbs/blog-img1.png" alt="" class="cover-img">
                            </a>
                            <div class="blog-item__content mt-24">
                                <span class="bg-main-50 text-main-600 py-4 px-24 rounded-8 mb-16">Gadget</span>
                                <h6 class="text-2xl mb-24">
                                    <a href="blog-details.php" class="">Legal structure, can make profit buisness</a>
                                </h6>
                                <p class="text-gray-700 text-line-2">Re-engagement — objectives. As developers, we
                                    rightfully obsess about the customer experience, relentlessly working to squeeze
                                    every millisecond out of the critical rendering path, optimize input latency, and
                                    eliminate...</p>

                                <div class="flex-align flex-wrap gap-24 pt-24 mt-24 border-top border-gray-100">
                                    <div class="flex-align flex-wrap gap-8">
                                        <span class="text-lg text-main-600"><i class="ph ph-calendar-dots"></i></span>
                                        <span class="text-sm text-gray-500">
                                            <a href="blog-details.php" class="text-gray-500 hover-text-main-600">July
                                                12, 2025</a>
                                        </span>
                                    </div>
                                    <div class="flex-align flex-wrap gap-8">
                                        <span class="text-lg text-main-600"><i class="ph ph-chats-circle"></i></span>
                                        <span class="text-sm text-gray-500">
                                            <a href="blog-details.php" class="text-gray-500 hover-text-main-600">0
                                                Comments</a>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="blog-item">
                            <a href="blog-details.php" class="w-100 h-100 rounded-16 overflow-hidden">
                                <img src="assets/images/thumbs/blog-img2.png" alt="" class="cover-img">
                            </a>
                            <div class="blog-item__content mt-24">
                                <span class="bg-main-50 text-main-600 py-4 px-24 rounded-8 mb-16">Gadget</span>
                                <h6 class="text-2xl mb-24">
                                    <a href="blog-details.php" class="">Legal structure, can make profit buisness</a>
                                </h6>
                                <p class="text-gray-700 text-line-2">Re-engagement — objectives. As developers, we
                                    rightfully obsess about the customer experience, relentlessly working to squeeze
                                    every millisecond out of the critical rendering path, optimize input latency, and
                                    eliminate...</p>

                                <div class="flex-align flex-wrap gap-24 pt-24 mt-24 border-top border-gray-100">
                                    <div class="flex-align flex-wrap gap-8">
                                        <span class="text-lg text-main-600"><i class="ph ph-calendar-dots"></i></span>
                                        <span class="text-sm text-gray-500">
                                            <a href="blog-details.php" class="text-gray-500 hover-text-main-600">July
                                                12, 2025</a>
                                        </span>
                                    </div>
                                    <div class="flex-align flex-wrap gap-8">
                                        <span class="text-lg text-main-600"><i class="ph ph-chats-circle"></i></span>
                                        <span class="text-sm text-gray-500">
                                            <a href="blog-details.php" class="text-gray-500 hover-text-main-600">0
                                                Comments</a>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="blog-item">
                            <a href="blog-details.php" class="w-100 h-100 rounded-16 overflow-hidden">
                                <img src="assets/images/thumbs/blog-img3.png" alt="" class="cover-img">
                            </a>
                            <div class="blog-item__content mt-24">
                                <span class="bg-main-50 text-main-600 py-4 px-24 rounded-8 mb-16">Gadget</span>
                                <h6 class="text-2xl mb-24">
                                    <a href="blog-details.php" class="">Legal structure, can make profit buisness</a>
                                </h6>
                                <p class="text-gray-700 text-line-2">Re-engagement — objectives. As developers, we
                                    rightfully obsess about the customer experience, relentlessly working to squeeze
                                    every millisecond out of the critical rendering path, optimize input latency, and
                                    eliminate...</p>

                                <div class="flex-align flex-wrap gap-24 pt-24 mt-24 border-top border-gray-100">
                                    <div class="flex-align flex-wrap gap-8">
                                        <span class="text-lg text-main-600"><i class="ph ph-calendar-dots"></i></span>
                                        <span class="text-sm text-gray-500">
                                            <a href="blog-details.php" class="text-gray-500 hover-text-main-600">July
                                                12, 2025</a>
                                        </span>
                                    </div>
                                    <div class="flex-align flex-wrap gap-8">
                                        <span class="text-lg text-main-600"><i class="ph ph-chats-circle"></i></span>
                                        <span class="text-sm text-gray-500">
                                            <a href="blog-details.php" class="text-gray-500 hover-text-main-600">0
                                                Comments</a>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Pagination Start -->
                    <ul class="pagination flex-align flex-wrap gap-16">
                        <li class="page-item">
                            <a class="page-link h-64 w-64 flex-center text-xxl rounded-8 fw-medium text-neutral-600 border border-gray-100"
                                href="#">
                                <i class="ph-bold ph-arrow-left"></i>
                            </a>
                        </li>
                        <li class="page-item active">
                            <a class="page-link h-64 w-64 flex-center text-md rounded-8 fw-medium text-neutral-600 border border-gray-100"
                                href="#">01</a>
                        </li>
                        <li class="page-item">
                            <a class="page-link h-64 w-64 flex-center text-md rounded-8 fw-medium text-neutral-600 border border-gray-100"
                                href="#">02</a>
                        </li>
                        <li class="page-item">
                            <a class="page-link h-64 w-64 flex-center text-md rounded-8 fw-medium text-neutral-600 border border-gray-100"
                                href="#">03</a>
                        </li>
                        <li class="page-item">
                            <a class="page-link h-64 w-64 flex-center text-md rounded-8 fw-medium text-neutral-600 border border-gray-100"
                                href="#">04</a>
                        </li>
                        <li class="page-item">
                            <a class="page-link h-64 w-64 flex-center text-md rounded-8 fw-medium text-neutral-600 border border-gray-100"
                                href="#">05</a>
                        </li>
                        <li class="page-item">
                            <a class="page-link h-64 w-64 flex-center text-md rounded-8 fw-medium text-neutral-600 border border-gray-100"
                                href="#">06</a>
                        </li>
                        <li class="page-item">
                            <a class="page-link h-64 w-64 flex-center text-md rounded-8 fw-medium text-neutral-600 border border-gray-100"
                                href="#">07</a>
                        </li>
                        <li class="page-item">
                            <a class="page-link h-64 w-64 flex-center text-xxl rounded-8 fw-medium text-neutral-600 border border-gray-100"
                                href="#">
                                <i class="ph-bold ph-arrow-right"></i>
                            </a>
                        </li>
                    </ul>
                    <!-- Pagination End -->

                </div>
                <div class="col-lg-4 ps-xl-4">
                    <!-- Search Start -->
                    <div class="blog-sidebar border border-gray-100 rounded-8 p-32 mb-40">
                        <h6 class="text-xl mb-32 pb-32 border-bottom border-gray-100">Search Here</h6>
                        <form action="#">
                            <div class="input-group">
                                <input type="text" class="form-control common-input bg-color-three"
                                    placeholder="Searching...">
                                <button type="submit"
                                    class="btn btn-main text-2xl h-56 w-56 flex-center text-2xl input-group-text"><i
                                        class="ph ph-magnifying-glass"></i></button>
                            </div>
                        </form>
                    </div>
                    <!-- Search End -->

                    <!-- Recent Post Start -->
                    <div class="blog-sidebar border border-gray-100 rounded-8 p-32 mb-40">
                        <h6 class="text-xl mb-32 pb-32 border-bottom border-gray-100">Recent Posts</h6>
                        <div class="d-flex align-items-center flex-sm-nowrap flex-wrap gap-24 mb-16">
                            <a href="blog-details.php"
                                class="w-100 h-100 rounded-4 overflow-hidden w-120 h-120 flex-shrink-0">
                                <img src="assets/images/thumbs/recent-post1.png" alt="" class="cover-img">
                            </a>
                            <div class="flex-grow-1">
                                <h6 class="text-lg">
                                    <a href="blog-details.php" class="text-line-3">Once determined you need to come up
                                        with a name</a>
                                </h6>
                                <div class="flex-align flex-wrap gap-8">
                                    <span class="text-lg text-main-600"><i class="ph ph-calendar-dots"></i></span>
                                    <span class="text-sm text-gray-500">
                                        <a href="blog-details.php" class="text-gray-500 hover-text-main-600">July 12,
                                            2025</a>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex align-items-center flex-sm-nowrap flex-wrap gap-24 mb-16">
                            <a href="blog-details.php"
                                class="w-100 h-100 rounded-4 overflow-hidden w-120 h-120 flex-shrink-0">
                                <img src="assets/images/thumbs/recent-post2.png" alt="" class="cover-img">
                            </a>
                            <div class="flex-grow-1">
                                <h6 class="text-lg">
                                    <a href="blog-details.php" class="text-line-3">Once determined you need to come up
                                        with a name</a>
                                </h6>
                                <div class="flex-align flex-wrap gap-8">
                                    <span class="text-lg text-main-600"><i class="ph ph-calendar-dots"></i></span>
                                    <span class="text-sm text-gray-500">
                                        <a href="blog-details.php" class="text-gray-500 hover-text-main-600">July 12,
                                            2025</a>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex align-items-center flex-sm-nowrap flex-wrap gap-24 mb-16">
                            <a href="blog-details.php"
                                class="w-100 h-100 rounded-4 overflow-hidden w-120 h-120 flex-shrink-0">
                                <img src="assets/images/thumbs/recent-post3.png" alt="" class="cover-img">
                            </a>
                            <div class="flex-grow-1">
                                <h6 class="text-lg">
                                    <a href="blog-details.php" class="text-line-3">Once determined you need to come up
                                        with a name</a>
                                </h6>
                                <div class="flex-align flex-wrap gap-8">
                                    <span class="text-lg text-main-600"><i class="ph ph-calendar-dots"></i></span>
                                    <span class="text-sm text-gray-500">
                                        <a href="blog-details.php" class="text-gray-500 hover-text-main-600">July 12,
                                            2025</a>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex align-items-center flex-sm-nowrap flex-wrap gap-24 mb-0">
                            <a href="blog-details.php"
                                class="w-100 h-100 rounded-4 overflow-hidden w-120 h-120 flex-shrink-0">
                                <img src="assets/images/thumbs/recent-post4.png" alt="" class="cover-img">
                            </a>
                            <div class="flex-grow-1">
                                <h6 class="text-lg">
                                    <a href="blog-details.php" class="text-line-3">Once determined you need to come up
                                        with a name</a>
                                </h6>
                                <div class="flex-align flex-wrap gap-8">
                                    <span class="text-lg text-main-600"><i class="ph ph-calendar-dots"></i></span>
                                    <span class="text-sm text-gray-500">
                                        <a href="blog-details.php" class="text-gray-500 hover-text-main-600">July 12,
                                            2025</a>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Recent Post End -->

                    <!-- Tags Start -->
                    <div class="blog-sidebar border border-gray-100 rounded-8 p-32 mb-40">
                        <h6 class="text-xl mb-32 pb-32 border-bottom border-gray-100">Recent Posts</h6>
                        <ul>
                            <li class="mb-16">
                                <a href="blog-details.php"
                                    class="flex-between gap-8 text-gray-700 border border-gray-100 rounded-4 p-4 ps-16 hover-border-main-600 hover-text-main-600">
                                    <span>Gaming (12)</span>
                                    <span class="w-40 h-40 flex-center rounded-4 bg-main-50 text-main-600"><i
                                            class="ph ph-arrow-right"></i></span>
                                </a>
                            </li>
                            <li class="mb-16">
                                <a href="blog-details.php"
                                    class="flex-between gap-8 text-gray-700 border border-gray-100 rounded-4 p-4 ps-16 hover-border-main-600 hover-text-main-600">
                                    <span>Smart Gadget (05)</span>
                                    <span class="w-40 h-40 flex-center rounded-4 bg-main-50 text-main-600"><i
                                            class="ph ph-arrow-right"></i></span>
                                </a>
                            </li>
                            <li class="mb-16">
                                <a href="blog-details.php"
                                    class="flex-between gap-8 text-gray-700 border border-gray-100 rounded-4 p-4 ps-16 hover-border-main-600 hover-text-main-600">
                                    <span>Software (29)</span>
                                    <span class="w-40 h-40 flex-center rounded-4 bg-main-50 text-main-600"><i
                                            class="ph ph-arrow-right"></i></span>
                                </a>
                            </li>
                            <li class="mb-16">
                                <a href="blog-details.php"
                                    class="flex-between gap-8 text-gray-700 border border-gray-100 rounded-4 p-4 ps-16 hover-border-main-600 hover-text-main-600">
                                    <span>Electronics (24)</span>
                                    <span class="w-40 h-40 flex-center rounded-4 bg-main-50 text-main-600"><i
                                            class="ph ph-arrow-right"></i></span>
                                </a>
                            </li>
                            <li class="mb-16">
                                <a href="blog-details.php"
                                    class="flex-between gap-8 text-gray-700 border border-gray-100 rounded-4 p-4 ps-16 hover-border-main-600 hover-text-main-600">
                                    <span>Laptop (08)</span>
                                    <span class="w-40 h-40 flex-center rounded-4 bg-main-50 text-main-600"><i
                                            class="ph ph-arrow-right"></i></span>
                                </a>
                            </li>
                            <li class="mb-16">
                                <a href="blog-details.php"
                                    class="flex-between gap-8 text-gray-700 border border-gray-100 rounded-4 p-4 ps-16 hover-border-main-600 hover-text-main-600">
                                    <span>Mobile & Accessories (16)</span>
                                    <span class="w-40 h-40 flex-center rounded-4 bg-main-50 text-main-600"><i
                                            class="ph ph-arrow-right"></i></span>
                                </a>
                            </li>
                            <li class="mb-0">
                                <a href="blog-details.php"
                                    class="flex-between gap-8 text-gray-700 border border-gray-100 rounded-4 p-4 ps-16 hover-border-main-600 hover-text-main-600">
                                    <span>Apliance (24)</span>
                                    <span class="w-40 h-40 flex-center rounded-4 bg-main-50 text-main-600"><i
                                            class="ph ph-arrow-right"></i></span>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <!-- Tags End -->

                </div>
            </div>
        </div>
    </section>
    <!-- =============================== Blog Section End =========================== -->

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

<!-- Mirrored from wowtheme7.com/tf/marketpro/blog.php by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 16 Apr 2025 14:05:32 GMT -->

</html>