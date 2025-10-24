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

<!-- Mirrored from wowtheme7.com/tf/marketpro/become-seller.php by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 16 Apr 2025 14:05:13 GMT -->

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Title -->
    <title> Become Seller</title>
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
        <div class="mobile-menu__inner">
            <a href="index.php" class="mobile-menu__logo">
                <img src="assets/images/logo/logo.png" alt="Logo">
            </a>
            <div class="mobile-menu__menu">
                <!-- Nav Menu Start -->
                <ul class="nav-menu flex-align nav-menu--mobile">
                    <li class="on-hover-item nav-menu__item has-submenu activePage">
                        <a href="javascript:void(0)" class="nav-menu__link text-heading-two">Home</a>
                        <ul class="on-hover-dropdown common-dropdown nav-submenu scroll-sm">
                            <li class="common-dropdown__item nav-submenu__item activePage">
                                <a href="index.php"
                                    class="common-dropdown__link nav-submenu__link text-heading-two hover-bg-neutral-100">
                                    Home Grocery</a>
                            </li>
                            <li class="common-dropdown__item nav-submenu__item">
                                <a href="index-two.php"
                                    class="common-dropdown__link nav-submenu__link text-heading-two hover-bg-neutral-100">
                                    Home Electronics</a>
                            </li>
                            <li class="common-dropdown__item nav-submenu__item">
                                <a href="index-three.php"
                                    class="common-dropdown__link nav-submenu__link text-heading-two hover-bg-neutral-100">
                                    Home Fashion</a>
                            </li>
                        </ul>
                    </li>
                    <li class="on-hover-item nav-menu__item has-submenu">
                        <a href="javascript:void(0)" class="nav-menu__link text-heading-two">Shop</a>
                        <ul class="on-hover-dropdown common-dropdown nav-submenu scroll-sm">
                            <li class="common-dropdown__item nav-submenu__item">
                                <a href="shop.php"
                                    class="common-dropdown__link nav-submenu__link text-heading-two hover-bg-neutral-100">
                                    Shop</a>
                            </li>
                            <li class="common-dropdown__item nav-submenu__item">
                                <a href="product-details.php"
                                    class="common-dropdown__link nav-submenu__link text-heading-two hover-bg-neutral-100">
                                    Shop Details</a>
                            </li>
                            <li class="common-dropdown__item nav-submenu__item">
                                <a href="product-details-two.php"
                                    class="common-dropdown__link nav-submenu__link text-heading-two hover-bg-neutral-100">
                                    Shop Details Two</a>
                            </li>
                        </ul>
                    </li>
                    <li class="on-hover-item nav-menu__item has-submenu">
                        <span
                            class="badge-notification bg-warning-600 text-white text-sm py-2 px-8 rounded-4">New</span>
                        <a href="javascript:void(0)" class="nav-menu__link text-heading-two">Pages</a>
                        <ul class="on-hover-dropdown common-dropdown nav-submenu scroll-sm">
                            <li class="common-dropdown__item nav-submenu__item">
                                <a href="cart.php"
                                    class="common-dropdown__link nav-submenu__link text-heading-two hover-bg-neutral-100">
                                    Cart</a>
                            </li>
                            <li class="common-dropdown__item nav-submenu__item">
                                <a href="wishlist.php"
                                    class="common-dropdown__link nav-submenu__link text-heading-two hover-bg-neutral-100">
                                    Wishlist</a>
                            </li>
                            <li class="common-dropdown__item nav-submenu__item">
                                <a href="checkout.php"
                                    class="common-dropdown__link nav-submenu__link text-heading-two hover-bg-neutral-100">
                                    Checkout </a>
                            </li>
                            <li class="common-dropdown__item nav-submenu__item">
                                <a href="become-seller.php"
                                    class="common-dropdown__link nav-submenu__link text-heading-two hover-bg-neutral-100">
                                    Become Seller</a>
                            </li>
                            <li class="common-dropdown__item nav-submenu__item">
                                <a href="<?= getenv("BASE_URL") . "/maintenance" ?>"
                                    class="common-dropdown__link nav-submenu__link text-heading-two hover-bg-neutral-100">
                                    Account</a>
                            </li>
                        </ul>
                    </li>
                    <li class="on-hover-item nav-menu__item has-submenu">
                        <span
                            class="badge-notification bg-tertiary-600 text-white text-sm py-2 px-8 rounded-4">New</span>
                        <a href="javascript:void(0)" class="nav-menu__link text-heading-two">Vendors</a>
                        <ul class="on-hover-dropdown common-dropdown nav-submenu scroll-sm">
                            <li class="common-dropdown__item nav-submenu__item">
                                <a href="vendor.php"
                                    class="common-dropdown__link nav-submenu__link text-heading-two hover-bg-neutral-100">
                                    Vendors </a>
                            </li>
                            <li class="common-dropdown__item nav-submenu__item">
                                <a href="vendor-details.php"
                                    class="common-dropdown__link nav-submenu__link text-heading-two hover-bg-neutral-100">
                                    Vendor Details </a>
                            </li>
                            <li class="common-dropdown__item nav-submenu__item">
                                <a href="vendor-two.php"
                                    class="common-dropdown__link nav-submenu__link text-heading-two hover-bg-neutral-100">
                                    Vendors Two</a>
                            </li>
                            <li class="common-dropdown__item nav-submenu__item">
                                <a href="vendor-two-details.php"
                                    class="common-dropdown__link nav-submenu__link text-heading-two hover-bg-neutral-100">
                                    Vendors Two Details</a>
                            </li>
                        </ul>
                    </li>
                    <li class="on-hover-item nav-menu__item has-submenu">
                        <a href="javascript:void(0)" class="nav-menu__link text-heading-two">Blog</a>
                        <ul class="on-hover-dropdown common-dropdown nav-submenu scroll-sm">
                            <li class="common-dropdown__item nav-submenu__item">
                                <a href="blog.php"
                                    class="common-dropdown__link nav-submenu__link text-heading-two hover-bg-neutral-100">
                                    Blog</a>
                            </li>
                            <li class="common-dropdown__item nav-submenu__item">
                                <a href="blog-details.php"
                                    class="common-dropdown__link nav-submenu__link text-heading-two hover-bg-neutral-100">
                                    Blog Details</a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-menu__item">
                        <a href="contact.php" class="nav-menu__link text-heading-two">Contact Us</a>
                    </li>
                </ul>
                <!-- Nav Menu End -->
            </div>
        </div>
    </div>
    <!-- ==================== Mobile Menu End Here ==================== -->


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
                <h6 class="mb-0">Become Seller</h6>
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
                    <li class="text-sm text-main-600"> Become Seller </li>
                </ul>
            </div>
        </div>
    </div>
    <!-- ========================= Breadcrumb End =============================== -->

    <!-- ============================== Banner Inner Start ================================ -->
    <section class="banner-inner bg-overlay z-1 position-relative py-72 bg-img bg-start"
        data-background-image="assets/images/thumbs/banner-inner-bg.png">
        <div
            class="banner-inner__img position-absolute inset-inline-end-0 top-50 translate-middle-y h-100 arrow-left-clip w-30-percent d-xxl-block d-none">
            <img src="assets/images/thumbs/banner-inner-img.png" alt="" class="h-100">
        </div>
        <div class="container">
            <div class="banner-inner__content text-center">
                <h4 class="text-white mb-20 fw-semibold">Become A MarketPro Seller</h4>
                <p class="text-white my-20">More than half the units sold in our stores from independent sellers.</p>
                <a href="<?= getenv("BASE_URL") . "/maintenance" ?>" class="btn btn-main-two rounded-8">Create An Account</a>
            </div>
        </div>
    </section>
    <!-- ============================== Banner Inner End ================================ -->

    <!-- ========================= Why Become Seller section start =================================== -->
    <section class="why-seller py-80">
        <div class="container">
            <div class="section-heading text-center mx-auto">
                <h5 class="">Why become a seller on Marketpro?</h5>
                <span class="text-gray-600">More than half the units sold in our stores from independent sellers.</span>
            </div>
            <div class="row gy-4 justify-content-center">
                <div class="col-lg-4 col-sm-6">
                    <div class="why-seller-item text-center">
                        <span class="text-main-two-600 text-72 d-inline-flex">
                            <i class="ph ph-gift"></i>
                        </span>
                        <h6 class="my-28">Free Shipping</h6>
                        <p class="text-gray-600 max-w-392 mx-auto">Explore insightful content that keeps you ahead of
                            the curve and connected to the pulse of what'shappening.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6">
                    <div class="why-seller-item text-center">
                        <span class="text-main-two-600 text-72 d-inline-flex">
                            <i class="ph ph-credit-card"></i>
                        </span>
                        <h6 class="my-28">Flexible Payment</h6>
                        <p class="text-gray-600 max-w-392 mx-auto">Explore insightful content that keeps you ahead of
                            the curve and connected to the pulse of what'shappening.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6">
                    <div class="why-seller-item text-center">
                        <span class="text-main-two-600 text-72 d-inline-flex">
                            <i class="ph ph-chats"></i>
                        </span>
                        <h6 class="my-28">Online Support</h6>
                        <p class="text-gray-600 max-w-392 mx-auto">Explore insightful content that keeps you ahead of
                            the curve and connected to the pulse of what'shappening.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ========================= Why Become Seller section End =================================== -->

    <!-- ========================== Counter Section Start ========================== -->
    <section class="counter">
        <div class="container container-lg">
            <div class="row justify-content-center">
                <div class="col-xxl-11">
                    <div class="bg-neutral-600 rounded-16 px-xxl-5 px-xl-4">
                        <div class="row gy-lg-0 gy-4 line-wrapper">
                            <div class="col-lg-3 col-sm-6 col-xs-6">
                                <div class="counter-item text-center py-100 px-8">
                                    <h3 class="text-main-600 counter mb-8 fw-semibold">185+</h3>
                                    <p class="text-white text-xl font-heading-two fw-semibold">Store around the world
                                    </p>
                                </div>
                            </div>
                            <div class="col-lg-3 col-sm-6 col-xs-6">
                                <div class="counter-item text-center py-100 px-8">
                                    <h3 class="text-main-600 counter mb-8 fw-semibold">152K</h3>
                                    <p class="text-white text-xl font-heading-two fw-semibold">Product Sold</p>
                                </div>
                            </div>
                            <div class="col-lg-3 col-sm-6 col-xs-6">
                                <div class="counter-item text-center py-100 px-8">
                                    <h3 class="text-main-600 counter mb-8 fw-semibold">15K+</h3>
                                    <p class="text-white text-xl font-heading-two fw-semibold">Registered Users</p>
                                </div>
                            </div>
                            <div class="col-lg-3 col-sm-6 col-xs-6">
                                <div class="counter-item text-center py-100 px-8">
                                    <h3 class="text-main-600 counter mb-8 fw-semibold">2K+</h3>
                                    <p class="text-white text-xl font-heading-two fw-semibold">Top Brands Available in
                                        store</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ========================== Counter Section End ========================== -->

    <!-- ============================= Steps Section start ================================= -->
    <section class="step py-80">
        <div class="position-relative z-1">
            <img src="assets/images/shape/curve-line-shape.png" alt=""
                class="position-absolute top-0 inset-inline-end-0 z-n1 me-60 d-lg-block d-none">

            <div class="container container-lg">
                <div class="row gy-4">
                    <div class="col-lg-6">
                        <div class="step-content">
                            <div class="section-heading ms-auto text-end">
                                <h5 class="">Over $200k in potential benefits</h5>
                                <span class="text-gray-600">Ready to sell? Launch your brand today with a powerful for
                                    new sellers and over $200k in potential benefits</span>
                            </div>
                            <div class="d-flex flex-column align-items-end gap-56">
                                <div class="d-flex align-items-center gap-32">
                                    <div class="text-end">
                                        <h5 class="mb-8">Step 01</h5>
                                        <p class="text-gray-600">Create an account on our website. It is fast and free.
                                        </p>
                                    </div>
                                    <div class="w-90 h-90 flex-center bg-main-two-100 rounded-circle">
                                        <h6
                                            class="mb-0 w-60 h-60 bg-main-two-600 text-white d-flex align-items-center justify-content-center rounded-circle border border-5 border-white fw-medium">
                                            01</h6>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center gap-32">
                                    <div class="text-end">
                                        <h5 class="mb-8">Step 02</h5>
                                        <p class="text-gray-600"> Upload your products and the display in your shop.</p>
                                    </div>
                                    <div class="w-90 h-90 flex-center bg-main-two-100 rounded-circle">
                                        <h6
                                            class="mb-0 w-60 h-60 bg-main-two-600 text-white d-flex align-items-center justify-content-center rounded-circle border border-5 border-white fw-medium">
                                            02</h6>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center gap-32">
                                    <div class="text-end">
                                        <h5 class="mb-8">Step 03</h5>
                                        <p class="text-gray-600">We'll verify your account and then you can start
                                            selling!</p>
                                    </div>
                                    <div class="w-90 h-90 flex-center bg-main-two-100 rounded-circle">
                                        <h6
                                            class="mb-0 w-60 h-60 bg-main-two-600 text-white d-flex align-items-center justify-content-center rounded-circle border border-5 border-white fw-medium">
                                            03</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="text-center">
                            <img src="assets/images/thumbs/steps.png" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ============================= Steps Section End ================================= -->

    <!-- ============================== Testimonial section start ======================= -->
    <section class="testimonials py-120 bg-neutral-600 bg-img overflow-hidden"
        data-background-image="assets/images/bg/pattern-two.png">
        <div class="container container-lg">
            <div class="row gy-4 align-items-center">
                <div class="col-xl-1">
                    <div class="section-heading mb-0 d-flex flex-column align-items-center writing-mode wow fadeInLeft">
                        <p class="text-white">Share information about your brand with your customers.</p>
                        <h5 class="text-white mb-0 text-uppercase">Customers Feedback</h5>
                    </div>
                </div>
                <div class="col-xl-11">
                    <div class="position-relative">
                        <div class="testimonials-slider mb-60">
                            <div class="testimonials-item">
                                <h6 class="text-white text-uppercase mb-8 fw-medium">ROBIUL HASAN</h6>
                                <span class="text-md text-white fw-normal">Business Owner</span>
                                <div class="flex-align gap-8 mt-24">
                                    <span class="text-xs fw-medium text-warning-600 d-flex"><i
                                            class="ph-fill ph-star"></i></span>
                                    <span class="text-xs fw-medium text-warning-600 d-flex"><i
                                            class="ph-fill ph-star"></i></span>
                                    <span class="text-xs fw-medium text-warning-600 d-flex"><i
                                            class="ph-fill ph-star"></i></span>
                                    <span class="text-xs fw-medium text-warning-600 d-flex"><i
                                            class="ph-fill ph-star"></i></span>
                                    <span class="text-xs fw-medium text-warning-600 d-flex"><i
                                            class="ph-fill ph-star"></i></span>
                                </div>
                                <p class="testimonials-item__desc text-white text-2xl fw-normal mt-40 max-w-990">
                                    Customers expressed that shopping at Asiana Fashion was a "delightful experience,"
                                    highlighting the vibrant colors and unique designs that made them feel special at
                                    events </p>
                            </div>
                            <div class="testimonials-item">
                                <h6 class="text-white text-uppercase mb-8 fw-medium">SAMIYA AKTER</h6>
                                <span class="text-md text-white fw-normal">Front End Developer</span>
                                <div class="flex-align gap-8 mt-24">
                                    <span class="text-xs fw-medium text-warning-600 d-flex"><i
                                            class="ph-fill ph-star"></i></span>
                                    <span class="text-xs fw-medium text-warning-600 d-flex"><i
                                            class="ph-fill ph-star"></i></span>
                                    <span class="text-xs fw-medium text-warning-600 d-flex"><i
                                            class="ph-fill ph-star"></i></span>
                                    <span class="text-xs fw-medium text-warning-600 d-flex"><i
                                            class="ph-fill ph-star"></i></span>
                                    <span class="text-xs fw-medium text-warning-600 d-flex"><i
                                            class="ph-fill ph-star"></i></span>
                                </div>
                                <p class="testimonials-item__desc text-white text-2xl fw-normal mt-40 max-w-990">
                                    Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a
                                    piece of classical Latin literature from 45 BC, making it over 2000 years old.
                                    Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia</p>
                            </div>
                            <div class="testimonials-item">
                                <h6 class="text-white text-uppercase mb-8 fw-medium">JOHN DOE</h6>
                                <span class="text-md text-white fw-normal">Max Model</span>
                                <div class="flex-align gap-8 mt-24">
                                    <span class="text-xs fw-medium text-warning-600 d-flex"><i
                                            class="ph-fill ph-star"></i></span>
                                    <span class="text-xs fw-medium text-warning-600 d-flex"><i
                                            class="ph-fill ph-star"></i></span>
                                    <span class="text-xs fw-medium text-warning-600 d-flex"><i
                                            class="ph-fill ph-star"></i></span>
                                    <span class="text-xs fw-medium text-warning-600 d-flex"><i
                                            class="ph-fill ph-star"></i></span>
                                    <span class="text-xs fw-medium text-warning-600 d-flex"><i
                                            class="ph-fill ph-star"></i></span>
                                </div>
                                <p class="testimonials-item__desc text-white text-2xl fw-normal mt-40 max-w-990">It is a
                                    long established fact that a reader will be distracted by the readable content of a
                                    page when looking at its layout. The point of using Lorem Ipsum is that it has a
                                    more-or-less normal distribution of letters, as opposed to using 'Content here,
                                    content here'</p>
                            </div>
                            <div class="testimonials-item">
                                <h6 class="text-white text-uppercase mb-8 fw-medium">MICHEL SMITH</h6>
                                <span class="text-md text-white fw-normal">Former Model</span>
                                <div class="flex-align gap-8 mt-24">
                                    <span class="text-xs fw-medium text-warning-600 d-flex"><i
                                            class="ph-fill ph-star"></i></span>
                                    <span class="text-xs fw-medium text-warning-600 d-flex"><i
                                            class="ph-fill ph-star"></i></span>
                                    <span class="text-xs fw-medium text-warning-600 d-flex"><i
                                            class="ph-fill ph-star"></i></span>
                                    <span class="text-xs fw-medium text-warning-600 d-flex"><i
                                            class="ph-fill ph-star"></i></span>
                                    <span class="text-xs fw-medium text-warning-600 d-flex"><i
                                            class="ph-fill ph-star"></i></span>
                                </div>
                                <p class="testimonials-item__desc text-white text-2xl fw-normal mt-40 max-w-990">Many
                                    desktop publishing packages and web page editors now use Lorem Ipsum as their
                                    default model text, and a search for 'lorem ipsum' will uncover many web sites still
                                    in their infancy. </p>
                            </div>
                            <div class="testimonials-item">
                                <h6 class="text-white text-uppercase mb-8 fw-medium">ALEX</h6>
                                <span class="text-md text-white fw-normal">Back End Developer</span>
                                <div class="flex-align gap-8 mt-24">
                                    <span class="text-xs fw-medium text-warning-600 d-flex"><i
                                            class="ph-fill ph-star"></i></span>
                                    <span class="text-xs fw-medium text-warning-600 d-flex"><i
                                            class="ph-fill ph-star"></i></span>
                                    <span class="text-xs fw-medium text-warning-600 d-flex"><i
                                            class="ph-fill ph-star"></i></span>
                                    <span class="text-xs fw-medium text-warning-600 d-flex"><i
                                            class="ph-fill ph-star"></i></span>
                                    <span class="text-xs fw-medium text-warning-600 d-flex"><i
                                            class="ph-fill ph-star"></i></span>
                                </div>
                                <p class="testimonials-item__desc text-white text-2xl fw-normal mt-40 max-w-990">There
                                    are many variations of passages of Lorem Ipsum available, but the majority have
                                    suffered alteration in some form, by injected humour, or randomised words which
                                    don't look even slightly believable. If you are going to use a passage of Lorem
                                    Ipsum, you need to be sure there isn't anything embarrassing hidden in the middle of
                                    text.</p>
                            </div>
                        </div>
                        <div class="testimonials-thumbs-slider">
                            <div
                                class="testimonials-thumbs d-flex position-relative align-items-end justify-content-end">
                                <div class="testimonials-thumbs__img">
                                    <img src="assets/images/thumbs/testimonials-img1.png" alt="" class="cover-img">
                                </div>
                                <div
                                    class="testimonials-thumbs__content position-absolute transition-2 bottom-0 start-50 translate-middle-x mb-16 text-center hidden opacity-0">
                                    <h6 class="text-white text-uppercase mb-8 fw-medium">ROBIUL HASAN</h6>
                                    <span class="text-md text-white fw-normal">Business Owner</span>
                                </div>
                            </div>
                            <div
                                class="testimonials-thumbs d-flex position-relative align-items-end justify-content-end">
                                <div class="testimonials-thumbs__img">
                                    <img src="assets/images/thumbs/testimonials-img2.png" alt="" class="cover-img">
                                </div>
                                <div
                                    class="testimonials-thumbs__content position-absolute transition-2 bottom-0 start-50 translate-middle-x mb-16 text-center hidden opacity-0">
                                    <h6 class="text-white text-uppercase mb-8 fw-medium">SAMIYA AKTER</h6>
                                    <span class="text-md text-white fw-normal">Front End Developer</span>
                                </div>
                            </div>
                            <div
                                class="testimonials-thumbs d-flex position-relative align-items-end justify-content-end">
                                <div class="testimonials-thumbs__img">
                                    <img src="assets/images/thumbs/testimonials-img3.png" alt="" class="cover-img">
                                </div>
                                <div
                                    class="testimonials-thumbs__content position-absolute transition-2 bottom-0 start-50 translate-middle-x mb-16 text-center hidden opacity-0">
                                    <h6 class="text-white text-uppercase mb-8 fw-medium">JOHN DOE</h6>
                                    <span class="text-md text-white fw-normal">Max Model</span>
                                </div>
                            </div>
                            <div
                                class="testimonials-thumbs d-flex position-relative align-items-end justify-content-end">
                                <div class="testimonials-thumbs__img">
                                    <img src="assets/images/thumbs/testimonials-img4.png" alt="" class="cover-img">
                                </div>
                                <div
                                    class="testimonials-thumbs__content position-absolute transition-2 bottom-0 start-50 translate-middle-x mb-16 text-center hidden opacity-0">
                                    <h6 class="text-white text-uppercase mb-8 fw-medium">MICHEL SMITH</h6>
                                    <span class="text-md text-white fw-normal">Former Model</span>
                                </div>
                            </div>
                            <div
                                class="testimonials-thumbs d-flex position-relative align-items-end justify-content-end">
                                <div class="testimonials-thumbs__img">
                                    <img src="assets/images/thumbs/testimonials-img2.png" alt="" class="cover-img">
                                </div>
                                <div
                                    class="testimonials-thumbs__content position-absolute transition-2 bottom-0 start-50 translate-middle-x mb-16 text-center hidden opacity-0">
                                    <h6 class="text-white text-uppercase mb-8 fw-medium">ALEX</h6>
                                    <span class="text-md text-white fw-normal">Back End Developer</span>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="flex-center gap-8 mt-48">
                <button type="button" id="testi-prev"
                    class="slick-prev slick-arrow flex-center rounded-circle border border-gray-100 hover-border-main-600 text-xl hover-bg-main-600 text-white transition-1">
                    <i class="ph ph-caret-left"></i>
                </button>
                <button type="button" id="testi-next"
                    class="slick-next slick-arrow flex-center rounded-circle border border-gray-100 hover-border-main-600 text-xl hover-bg-main-600 text-white transition-1">
                    <i class="ph ph-caret-right"></i>
                </button>
            </div>
        </div>
    </section>
    <!-- ============================== Testimonial section start ======================= -->

    <!-- ========================== Shipping Section Start ============================ -->
    <section class="shipping mb-24 mt-80" id="shipping">
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

<!-- Mirrored from wowtheme7.com/tf/marketpro/become-seller.php by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 16 Apr 2025 14:05:15 GMT -->

</html>