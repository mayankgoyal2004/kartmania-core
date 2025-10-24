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
    <title> Blog Details</title>
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

    <!-- =============================== Blog Details Section Start =========================== -->
    <section class="blog-details py-80">
        <div class="container container-lg">
            <div class="row gy-5">
                <div class="col-lg-8 pe-xl-4">
                    <div class="blog-item-wrapper">
                        <div class="blog-item">
                            <img src="assets/images/thumbs/blog-img1.png" alt="" class="cover-img rounded-16">
                            <div class="blog-item__content mt-24">
                                <span class="bg-main-50 text-main-600 py-4 px-24 rounded-8 mb-16">Gadget</span>
                                <h4 class="mb-24">Nice decoration make be distilled to a single house</h4>
                                <p class="text-gray-700 mb-24">A great commerce experience cannot be distilled to a
                                    single number. It's not a Lighthouse score, or a set of Core Web Vitals figures,
                                    although both are important inputs. A great commerce experience is a trilemma that
                                    carefully balances competing needs of delivering great customer experience, dynamic
                                    storefront capabilities, and long-term business — conversion, retention,
                                    re-engagement — objectives. As developers, we rightfully obsess about the customer
                                    experience, relentlessly working to squeeze every millisecond out of the critical
                                    rendering path, optimize input latency, and eliminate jank. At the limit, statically
                                    generated, edge delivered, and HTML-first pages look like the optimal strategy. That
                                    is until you are confronted with the realization that the next step function in
                                    improving conversion rates and business.</p>
                                <p class="text-gray-700 pb-24 mb-24 border-bottom border-gray-100">Re-engagement —
                                    objectives. As developers, we rightfully obsess about the customer experience,
                                    relentlessly working to squeeze every millisecond out of the critical rendering
                                    path, optimize input latency, and eliminate...</p>

                                <div class="flex-align flex-wrap gap-24">
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

                    <div class="mt-48">
                        <div class="row gy-4">
                            <div class="col-sm-6 col-xs-6">
                                <img src="assets/images/thumbs/blog-details-img1.png" alt="" class="rounded-16">
                            </div>
                            <div class="col-sm-6 col-xs-6">
                                <img src="assets/images/thumbs/blog-details-img2.png" alt="" class="rounded-16">
                            </div>
                        </div>
                    </div>

                    <div class="mt-48">
                        <p class="text-gray-700 mb-24">A great commerce experience cannot be distilled to a single
                            number. It’s not a Lighthouse score, or a set of Core Web Vitals figures, although both are
                            important inputs. A great commerce experience is a trilemma that carefully balances
                            competing needs of delivering great customer experience, dynamic storefront capabilities,
                            and long-term business.</p>
                    </div>

                    <div class="mt-48">
                        <h6 class="mb-32">The following are the four main market segments in which e-commerce is
                            present. These are the following:</h6>
                        <div class="row gy-4">
                            <div class="col-sm-6">
                                <ul>
                                    <li class="d-flex align-items-start gap-8 mb-20">
                                        <span class="text-xl d-flex flex-shrink-0"><i class="ph ph-check"></i></span>
                                        <span class="text-gray-700 flex-grow-1">A great commerce experience cannot be
                                            distilled to a single number. </span>
                                    </li>
                                    <li class="d-flex align-items-start gap-8 mb-20">
                                        <span class="text-xl d-flex flex-shrink-0"><i class="ph ph-check"></i></span>
                                        <span class="text-gray-700 flex-grow-1">A great commerce experience cannot be
                                            distilled to a single number. </span>
                                    </li>
                                    <li class="d-flex align-items-start gap-8 mb-0">
                                        <span class="text-xl d-flex flex-shrink-0"><i class="ph ph-check"></i></span>
                                        <span class="text-gray-700 flex-grow-1">A great commerce experience cannot be
                                            distilled to a single number. </span>
                                    </li>
                                </ul>
                            </div>
                            <div class="col-sm-6">
                                <ul>
                                    <li class="d-flex align-items-start gap-8 mb-20">
                                        <span class="text-xl d-flex flex-shrink-0"><i class="ph ph-check"></i></span>
                                        <span class="text-gray-700 flex-grow-1">A great commerce experience cannot be
                                            distilled to a single number. </span>
                                    </li>
                                    <li class="d-flex align-items-start gap-8 mb-20">
                                        <span class="text-xl d-flex flex-shrink-0"><i class="ph ph-check"></i></span>
                                        <span class="text-gray-700 flex-grow-1">A great commerce experience cannot be
                                            distilled to a single number. </span>
                                    </li>
                                    <li class="d-flex align-items-start gap-8 mb-0">
                                        <span class="text-xl d-flex flex-shrink-0"><i class="ph ph-check"></i></span>
                                        <span class="text-gray-700 flex-grow-1">A great commerce experience cannot be
                                            distilled to a single number. </span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="mt-48">
                        <div class="rounded-16 bg-main-50 p-24">
                            <span class="w-48 h-48 bg-main-600 text-white flex-center rounded-circle mb-24 text-2xl"><i
                                    class="ph ph-quotes"></i></span>
                            <p class="text-gray-700 mb-24">A great commerce experience cannot be distilled to a single
                                number. It’s not a Lighthouse score, or a set of Core Web Vitals figures, although both
                                are important inputs. A great commerce experience is a trilemma that carefully balances
                                competing needs of delivering great customer experience, dynamic storefront
                                capabilities, and long-term business.</p>
                            <div class="flex-align gap-8">
                                <span class="text-15 fw-medium text-neutral-600 d-flex"><i
                                        class="ph-fill ph-star"></i></span>
                                <span class="text-15 fw-medium text-neutral-600 d-flex"><i
                                        class="ph-fill ph-star"></i></span>
                                <span class="text-15 fw-medium text-neutral-600 d-flex"><i
                                        class="ph-fill ph-star"></i></span>
                                <span class="text-15 fw-medium text-neutral-600 d-flex"><i
                                        class="ph-fill ph-star"></i></span>
                                <span class="text-15 fw-medium text-neutral-600 d-flex"><i
                                        class="ph-fill ph-star"></i></span>
                            </div>
                        </div>
                    </div>

                    <div class="mt-48">
                        <div class="flex-align gap-8">
                            <h6 class="mb-0">Tag:</h6>
                            <a href="shop.php"
                                class="border border-gray-100 rounded-4 py-6 px-8 hover-bg-gray-100 text-gray-900">Mobile</a>
                            <a href="shop.php"
                                class="border border-gray-100 rounded-4 py-6 px-8 hover-bg-gray-100 text-gray-900">Laptop</a>
                            <a href="shop.php"
                                class="border border-gray-100 rounded-4 py-6 px-8 hover-bg-gray-100 text-gray-900">Gadget</a>
                        </div>
                    </div>

                    <div class="my-48">
                        <span class="border-bottom border-gray-100 d-block"></span>
                    </div>

                    <div class="my-48 flex-between flex-sm-nowrap flex-wrap gap-24">
                        <div class="">
                            <button type="button"
                                class="mb-20 h6 text-gray-500 text-lg fw-normal hover-text-main-600">Previous
                                Post</button>
                            <h6 class="text-lg mb-0">
                                <a href="blog-details.php" class="">A great commerce experience cannot be distilled to a
                                    single number. </a>
                            </h6>
                        </div>
                        <div class="text-end">
                            <button type="button"
                                class="mb-20 h6 text-gray-500 text-lg fw-normal hover-text-main-600">Next</button>
                            <h6 class="text-lg mb-0">
                                <a href="blog-details.php" class="">A great commerce experience cannot be distilled to a
                                    single number. </a>
                            </h6>
                        </div>
                    </div>

                    <div class="my-48">
                        <span class="border-bottom border-gray-100 d-block"></span>
                    </div>

                    <div class="my-48">
                        <form action="#">
                            <h6 class="mb-24">Leave a Comment</h6>
                            <div class="row gy-4">
                                <div class="col-sm-6 col-xs-6">
                                    <label for="name"
                                        class="text-sm font-heading-two text-gray-900 fw-semibold mb-4">Full
                                        Name</label>
                                    <input type="text" class="common-input px-16" id="name" placeholder="Full name">
                                </div>
                                <div class="col-sm-6 col-xs-6">
                                    <label for="email"
                                        class="text-sm font-heading-two text-gray-900 fw-semibold mb-4">Email
                                        Address</label>
                                    <input type="email" class="common-input px-16" id="email"
                                        placeholder="Email address">
                                </div>
                                <div class="col-sm-12">
                                    <label for="message"
                                        class="text-sm font-heading-two text-gray-900 fw-semibold mb-4">Message</label>
                                    <textarea class="common-input px-16" id="message"
                                        placeholder="What's your thought about this blog..."></textarea>
                                </div>
                                <div class="col-sm-12 mt-32">
                                    <button type="submit" class="btn btn-main py-18 px-32 rounded-8">Post
                                        Comment</button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="my-48">
                        <form action="#">
                            <h6 class="mb-48">Comments</h6>
                            <div class="d-flex align-items-start gap-16 mb-32 pb-32 border-bottom border-gray-100">
                                <img src="assets/images/thumbs/comment-img1.png" alt=""
                                    class="w-40 h-40 rounded-circle object-fit-cover flex-shrink-0">
                                <div class="flex-grow-1">
                                    <div class="flex-align gap-8">
                                        <h6 class="text-md fw-bold mb-0">Marvin McKinney</h6>
                                        <span class="w-6 h-6 bg-gray-500 rounded-circle"></span>
                                        <span class="text-sm fw-medium text-gray-700">26 Apr, 2024</span>
                                    </div>
                                    <p class="mt-16 text-gray-700">In a nisi commodo, porttitor ligula consequat,
                                        tincidunt dui. Nulla volutpat, metus eu aliquam malesuada, elit libero venenatis
                                        urna, consequat maximus arcu diam non diam.</p>
                                </div>
                            </div>
                            <div class="d-flex align-items-start gap-16 mb-32 pb-32 border-bottom border-gray-100">
                                <img src="assets/images/thumbs/comment-img2.png" alt=""
                                    class="w-40 h-40 rounded-circle object-fit-cover flex-shrink-0">
                                <div class="flex-grow-1">
                                    <div class="flex-align gap-8">
                                        <h6 class="text-md fw-bold mb-0">Kristin Watson</h6>
                                        <span class="w-6 h-6 bg-gray-500 rounded-circle"></span>
                                        <span class="text-sm fw-medium text-gray-700">24 Apr, 2024</span>
                                    </div>
                                    <p class="mt-16 text-gray-700">Quisque eget tortor lobortis, facilisis metus eu,
                                        elementum est. Nunc sit amet erat quis ex convallis suscipit. Nam hendrerit,
                                        velit ut aliquam euismod, nibh tortor rutrum nisi, ac sodales nunc eros porta
                                        nisi. Sed scelerisque, est eget aliquam venenatis, est sem tempor eros.</p>
                                </div>
                            </div>
                            <div class="d-flex align-items-start gap-16 mb-32 pb-32 border-bottom border-gray-100">
                                <img src="assets/images/thumbs/comment-img3.png" alt=""
                                    class="w-40 h-40 rounded-circle object-fit-cover flex-shrink-0">
                                <div class="flex-grow-1">
                                    <div class="flex-align gap-8">
                                        <h6 class="text-md fw-bold mb-0">Jenny Wilson</h6>
                                        <span class="w-6 h-6 bg-gray-500 rounded-circle"></span>
                                        <span class="text-sm fw-medium text-gray-700">20 Apr, 2024</span>
                                    </div>
                                    <p class="mt-16 text-gray-700">Vestibulum ante ipsum primis in faucibus orci luctus
                                        et ultrices posuere cubilia curae.</p>
                                </div>
                            </div>
                            <div class="d-flex align-items-start gap-16 mb-32 pb-32 border-bottom border-gray-100">
                                <img src="assets/images/thumbs/comment-img4.png" alt=""
                                    class="w-40 h-40 rounded-circle object-fit-cover flex-shrink-0">
                                <div class="flex-grow-1">
                                    <div class="flex-align gap-8">
                                        <h6 class="text-md fw-bold mb-0">Robert Fox</h6>
                                        <span class="w-6 h-6 bg-gray-500 rounded-circle"></span>
                                        <span class="text-sm fw-medium text-gray-700">18 Apr, 2024</span>
                                    </div>
                                    <p class="mt-16 text-gray-700">Pellentesque feugiat, nibh vel vehicula pretium, nibh
                                        nibh bibendum elit, a volutpat arcu dui nec orci. Aenean dui odio, ullamcorper
                                        quis turpis ac, volutpat imperdiet ex.</p>
                                </div>
                            </div>
                            <div class="d-flex align-items-start gap-16">
                                <img src="assets/images/thumbs/comment-img5.png" alt=""
                                    class="w-40 h-40 rounded-circle object-fit-cover flex-shrink-0">
                                <div class="flex-grow-1">
                                    <div class="flex-align gap-8">
                                        <h6 class="text-md fw-bold mb-0">Eleanor Pena</h6>
                                        <span class="w-6 h-6 bg-gray-500 rounded-circle"></span>
                                        <span class="text-sm fw-medium text-gray-700">7 Apr, 2024</span>
                                    </div>
                                    <p class="mt-16 text-gray-700">Nulla molestie interdum ultricies. </p>
                                </div>
                            </div>
                            <div class="mt-48">
                                <button type="submit" class="btn btn-main py-13 flex-align gap-8">
                                    Load More <i class="ph ph-spinner-gap text-2xl"></i>
                                </button>
                            </div>
                        </form>
                    </div>


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
    <!-- =============================== Blog Details Section End =========================== -->

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

</html>