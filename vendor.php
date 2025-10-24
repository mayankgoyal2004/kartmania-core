<?php
session_start();
require __DIR__ . "/api/api.php";
error_reporting(E_ALL);
ini_set("", 1);
require __DIR__ . "/utils/utils.php";

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



function fetchFromApi($apiUrl)
{
    // Initialize cURL
    $ch = curl_init();

    // Set cURL options
    curl_setopt($ch, CURLOPT_URL, $apiUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Return response as string
    curl_setopt($ch, CURLOPT_HTTPGET, true);        // Explicit GET request

    // Optional: Set headers if needed
    // curl_setopt($ch, CURLOPT_HTTPHEADER, [
    //     'Authorization: Bearer your_token',
    //     'Accept: application/json'
    // ]);

    // Execute request
    $response = curl_exec($ch);

    // Check for cURL errors
    if (curl_errno($ch)) {
        curl_close($ch);
        return [
            'success' => false,
            'error' => curl_error($ch)
        ];
    }

    curl_close($ch);

    // Decode JSON response
    $data = json_decode($response, true);

    return [
        'success' => true,
        'data' => $data
    ];
}


?>
<!DOCTYPE html>
<html lang="en" class="">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Title -->
    <title> Vendors</title>
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
    <div class="breadcrumb mb-0 py-26 bg-main-50">
        <div class="container container-lg">
            <div class="breadcrumb-wrapper flex-between flex-wrap gap-16">
                <h6 class="mb-0">Shop</h6>
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
                    <li class="text-sm text-main-600"> Vendor List </li>
                </ul>
            </div>
        </div>
    </div>
    <!-- ========================= Breadcrumb End =============================== -->

    <!-- =================================== Vendors List section start ===================================== -->
    <section class="vendors-list py-80">
        <div class="container container-lg">

            <div class="flex-between flex-wrap gap-8 mb-40">
                <span class="text-neutral-600 fw-medium px-40 py-12 rounded-pill border border-neutral-100">Showing 1-20
                    of 85 results</span>

                <div class="flex-align gap-16">
                    <form action="#" class="search-form__wrapper position-relative d-block">
                        <input type="text" class="search-form__input common-input py-13 ps-16 pe-18 rounded-pill pe-44"
                            placeholder="Search vendors by name or ID...">
                        <button type="submit"
                            class="w-32 h-32 bg-main-600 rounded-circle flex-center text-xl text-white position-absolute top-50 translate-middle-y inset-inline-end-0 me-8"><i
                                class="ph ph-magnifying-glass"></i></button>
                    </form>
                    <div class="flex-align gap-8">
                        <span class="text-gray-900 flex-shrink-0">Sort by:</span>
                        <select
                            class="common-input form-select rounded-pill border border-gray-100 d-inline-block ps-20 pe-36 h-48 py-0 fw-medium">
                            <option value="1">Latest</option>
                            <option value="1">Old</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="row gy-4 vendor-card-wrapper">
                <div class="col-xxl-3 col-lg-4 col-sm-6" data-aos="zoom-in" data-aos-duration="200">
                    <div class="vendor-card text-center px-16 pb-24">
                        <div class="">
                            <img src="assets/images/thumbs/vendor-logo1.png" alt="" class="vendor-card__logo m-12">
                            <h6 class="title mt-32">
                                <a href="vendor-details.php" class="">Organic Market</a>
                            </h6>
                            <span class="text-heading text-sm d-block">Delivery by 6:15am</span>
                            <a href="shop.php"
                                class="bg-white text-neutral-600 hover-bg-main-600 hover-text-white rounded-pill py-6 px-16 text-12 mt-8">$5
                                off Snack & Candy</a>
                        </div>
                        <div class="vendor-card__list mt-22 flex-center flex-wrap gap-8">
                            <div class="vendor-card__item bg-white rounded-circle flex-center">
                                <img src="assets/images/thumbs/vendor-img1.png" alt="">
                            </div>
                            <div class="vendor-card__item bg-white rounded-circle flex-center">
                                <img src="assets/images/thumbs/vendor-img2.png" alt="">
                            </div>
                            <div class="vendor-card__item bg-white rounded-circle flex-center">
                                <img src="assets/images/thumbs/vendor-img3.png" alt="">
                            </div>
                            <div class="vendor-card__item bg-white rounded-circle flex-center">
                                <img src="assets/images/thumbs/vendor-img4.png" alt="">
                            </div>
                            <div class="vendor-card__item bg-white rounded-circle flex-center">
                                <img src="assets/images/thumbs/vendor-img5.png" alt="">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-3 col-lg-4 col-sm-6" data-aos="zoom-in" data-aos-duration="400">
                    <div class="vendor-card text-center px-16 pb-24">
                        <div class="">
                            <img src="assets/images/thumbs/vendor-logo2.png" alt="" class="vendor-card__logo m-12">
                            <h6 class="title mt-32">
                                <a href="vendor-details.php" class="">Safeway</a>
                            </h6>
                            <span class="text-heading text-sm d-block">Delivery by 6:15am</span>
                            <a href="shop.php"
                                class="bg-white text-neutral-600 hover-bg-main-600 hover-text-white rounded-pill py-6 px-16 text-12 mt-8">$5
                                off Snack & Candy</a>
                        </div>
                        <div class="vendor-card__list mt-22 flex-center flex-wrap gap-8">
                            <div class="vendor-card__item bg-white rounded-circle flex-center">
                                <img src="assets/images/thumbs/vendor-img1.png" alt="">
                            </div>
                            <div class="vendor-card__item bg-white rounded-circle flex-center">
                                <img src="assets/images/thumbs/vendor-img2.png" alt="">
                            </div>
                            <div class="vendor-card__item bg-white rounded-circle flex-center">
                                <img src="assets/images/thumbs/vendor-img3.png" alt="">
                            </div>
                            <div class="vendor-card__item bg-white rounded-circle flex-center">
                                <img src="assets/images/thumbs/vendor-img4.png" alt="">
                            </div>
                            <div class="vendor-card__item bg-white rounded-circle flex-center">
                                <img src="assets/images/thumbs/vendor-img5.png" alt="">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-3 col-lg-4 col-sm-6" data-aos="zoom-in" data-aos-duration="600">
                    <div class="vendor-card text-center px-16 pb-24">
                        <div class="">
                            <img src="assets/images/thumbs/vendor-logo3.png" alt="" class="vendor-card__logo m-12">
                            <h6 class="title mt-32">
                                <a href="vendor-details.php" class="">Food Max</a>
                            </h6>
                            <span class="text-heading text-sm d-block">Delivery by 6:15am</span>
                            <a href="shop.php"
                                class="bg-white text-neutral-600 hover-bg-main-600 hover-text-white rounded-pill py-6 px-16 text-12 mt-8">$5
                                off Snack & Candy</a>
                        </div>
                        <div class="vendor-card__list mt-22 flex-center flex-wrap gap-8">
                            <div class="vendor-card__item bg-white rounded-circle flex-center">
                                <img src="assets/images/thumbs/vendor-img1.png" alt="">
                            </div>
                            <div class="vendor-card__item bg-white rounded-circle flex-center">
                                <img src="assets/images/thumbs/vendor-img2.png" alt="">
                            </div>
                            <div class="vendor-card__item bg-white rounded-circle flex-center">
                                <img src="assets/images/thumbs/vendor-img3.png" alt="">
                            </div>
                            <div class="vendor-card__item bg-white rounded-circle flex-center">
                                <img src="assets/images/thumbs/vendor-img4.png" alt="">
                            </div>
                            <div class="vendor-card__item bg-white rounded-circle flex-center">
                                <img src="assets/images/thumbs/vendor-img5.png" alt="">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-3 col-lg-4 col-sm-6" data-aos="zoom-in" data-aos-duration="800">
                    <div class="vendor-card text-center px-16 pb-24">
                        <div class="">
                            <img src="assets/images/thumbs/vendor-logo4.png" alt="" class="vendor-card__logo m-12">
                            <h6 class="title mt-32">
                                <a href="vendor-details.php" class="">HRmart</a>
                            </h6>
                            <span class="text-heading text-sm d-block">Delivery by 6:15am</span>
                            <a href="shop.php"
                                class="bg-white text-neutral-600 hover-bg-main-600 hover-text-white rounded-pill py-6 px-16 text-12 mt-8">$5
                                off Snack & Candy</a>
                        </div>
                        <div class="vendor-card__list mt-22 flex-center flex-wrap gap-8">
                            <div class="vendor-card__item bg-white rounded-circle flex-center">
                                <img src="assets/images/thumbs/vendor-img1.png" alt="">
                            </div>
                            <div class="vendor-card__item bg-white rounded-circle flex-center">
                                <img src="assets/images/thumbs/vendor-img2.png" alt="">
                            </div>
                            <div class="vendor-card__item bg-white rounded-circle flex-center">
                                <img src="assets/images/thumbs/vendor-img3.png" alt="">
                            </div>
                            <div class="vendor-card__item bg-white rounded-circle flex-center">
                                <img src="assets/images/thumbs/vendor-img4.png" alt="">
                            </div>
                            <div class="vendor-card__item bg-white rounded-circle flex-center">
                                <img src="assets/images/thumbs/vendor-img5.png" alt="">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-3 col-lg-4 col-sm-6" data-aos="zoom-in" data-aos-duration="200">
                    <div class="vendor-card text-center px-16 pb-24">
                        <div class="">
                            <img src="assets/images/thumbs/vendor-logo5.png" alt="" class="vendor-card__logo m-12">
                            <h6 class="title mt-32">
                                <a href="vendor-details.php" class="">Lucky Supermarket</a>
                            </h6>
                            <span class="text-heading text-sm d-block">Delivery by 6:15am</span>
                            <a href="shop.php"
                                class="bg-white text-neutral-600 hover-bg-main-600 hover-text-white rounded-pill py-6 px-16 text-12 mt-8">$5
                                off Snack & Candy</a>
                        </div>
                        <div class="vendor-card__list mt-22 flex-center flex-wrap gap-8">
                            <div class="vendor-card__item bg-white rounded-circle flex-center">
                                <img src="assets/images/thumbs/vendor-img1.png" alt="">
                            </div>
                            <div class="vendor-card__item bg-white rounded-circle flex-center">
                                <img src="assets/images/thumbs/vendor-img2.png" alt="">
                            </div>
                            <div class="vendor-card__item bg-white rounded-circle flex-center">
                                <img src="assets/images/thumbs/vendor-img3.png" alt="">
                            </div>
                            <div class="vendor-card__item bg-white rounded-circle flex-center">
                                <img src="assets/images/thumbs/vendor-img4.png" alt="">
                            </div>
                            <div class="vendor-card__item bg-white rounded-circle flex-center">
                                <img src="assets/images/thumbs/vendor-img5.png" alt="">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-3 col-lg-4 col-sm-6" data-aos="zoom-in" data-aos-duration="400">
                    <div class="vendor-card text-center px-16 pb-24">
                        <div class="">
                            <img src="assets/images/thumbs/vendor-logo6.png" alt="" class="vendor-card__logo m-12">
                            <h6 class="title mt-32">
                                <a href="vendor-details.php" class="">Arico Farmer</a>
                            </h6>
                            <span class="text-heading text-sm d-block">Delivery by 6:15am</span>
                            <a href="shop.php"
                                class="bg-white text-neutral-600 hover-bg-main-600 hover-text-white rounded-pill py-6 px-16 text-12 mt-8">$5
                                off Snack & Candy</a>
                        </div>
                        <div class="vendor-card__list mt-22 flex-center flex-wrap gap-8">
                            <div class="vendor-card__item bg-white rounded-circle flex-center">
                                <img src="assets/images/thumbs/vendor-img1.png" alt="">
                            </div>
                            <div class="vendor-card__item bg-white rounded-circle flex-center">
                                <img src="assets/images/thumbs/vendor-img2.png" alt="">
                            </div>
                            <div class="vendor-card__item bg-white rounded-circle flex-center">
                                <img src="assets/images/thumbs/vendor-img3.png" alt="">
                            </div>
                            <div class="vendor-card__item bg-white rounded-circle flex-center">
                                <img src="assets/images/thumbs/vendor-img4.png" alt="">
                            </div>
                            <div class="vendor-card__item bg-white rounded-circle flex-center">
                                <img src="assets/images/thumbs/vendor-img5.png" alt="">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-3 col-lg-4 col-sm-6" data-aos="zoom-in" data-aos-duration="600">
                    <div class="vendor-card text-center px-16 pb-24">
                        <div class="">
                            <img src="assets/images/thumbs/vendor-logo7.png" alt="" class="vendor-card__logo m-12">
                            <h6 class="title mt-32">
                                <a href="vendor-details.php" class="">Farmer Market</a>
                            </h6>
                            <span class="text-heading text-sm d-block">Delivery by 6:15am</span>
                            <a href="shop.php"
                                class="bg-white text-neutral-600 hover-bg-main-600 hover-text-white rounded-pill py-6 px-16 text-12 mt-8">$5
                                off Snack & Candy</a>
                        </div>
                        <div class="vendor-card__list mt-22 flex-center flex-wrap gap-8">
                            <div class="vendor-card__item bg-white rounded-circle flex-center">
                                <img src="assets/images/thumbs/vendor-img1.png" alt="">
                            </div>
                            <div class="vendor-card__item bg-white rounded-circle flex-center">
                                <img src="assets/images/thumbs/vendor-img2.png" alt="">
                            </div>
                            <div class="vendor-card__item bg-white rounded-circle flex-center">
                                <img src="assets/images/thumbs/vendor-img3.png" alt="">
                            </div>
                            <div class="vendor-card__item bg-white rounded-circle flex-center">
                                <img src="assets/images/thumbs/vendor-img4.png" alt="">
                            </div>
                            <div class="vendor-card__item bg-white rounded-circle flex-center">
                                <img src="assets/images/thumbs/vendor-img5.png" alt="">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-3 col-lg-4 col-sm-6" data-aos="zoom-in" data-aos-duration="800">
                    <div class="vendor-card text-center px-16 pb-24">
                        <div class="">
                            <img src="assets/images/thumbs/vendor-logo8.png" alt="" class="vendor-card__logo m-12">
                            <h6 class="title mt-32">
                                <a href="vendor-details.php" class="">Foodsco</a>
                            </h6>
                            <span class="text-heading text-sm d-block">Delivery by 6:15am</span>
                            <a href="shop.php"
                                class="bg-white text-neutral-600 hover-bg-main-600 hover-text-white rounded-pill py-6 px-16 text-12 mt-8">$5
                                off Snack & Candy</a>
                        </div>
                        <div class="vendor-card__list mt-22 flex-center flex-wrap gap-8">
                            <div class="vendor-card__item bg-white rounded-circle flex-center">
                                <img src="assets/images/thumbs/vendor-img1.png" alt="">
                            </div>
                            <div class="vendor-card__item bg-white rounded-circle flex-center">
                                <img src="assets/images/thumbs/vendor-img2.png" alt="">
                            </div>
                            <div class="vendor-card__item bg-white rounded-circle flex-center">
                                <img src="assets/images/thumbs/vendor-img3.png" alt="">
                            </div>
                            <div class="vendor-card__item bg-white rounded-circle flex-center">
                                <img src="assets/images/thumbs/vendor-img4.png" alt="">
                            </div>
                            <div class="vendor-card__item bg-white rounded-circle flex-center">
                                <img src="assets/images/thumbs/vendor-img5.png" alt="">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-3 col-lg-4 col-sm-6" data-aos="zoom-in" data-aos-duration="200">
                    <div class="vendor-card text-center px-16 pb-24">
                        <div class="">
                            <img src="assets/images/thumbs/vendor-logo1.png" alt="" class="vendor-card__logo m-12">
                            <h6 class="title mt-32">
                                <a href="vendor-details.php" class="">Organic Market</a>
                            </h6>
                            <span class="text-heading text-sm d-block">Delivery by 6:15am</span>
                            <a href="shop.php"
                                class="bg-white text-neutral-600 hover-bg-main-600 hover-text-white rounded-pill py-6 px-16 text-12 mt-8">$5
                                off Snack & Candy</a>
                        </div>
                        <div class="vendor-card__list mt-22 flex-center flex-wrap gap-8">
                            <div class="vendor-card__item bg-white rounded-circle flex-center">
                                <img src="assets/images/thumbs/vendor-img1.png" alt="">
                            </div>
                            <div class="vendor-card__item bg-white rounded-circle flex-center">
                                <img src="assets/images/thumbs/vendor-img2.png" alt="">
                            </div>
                            <div class="vendor-card__item bg-white rounded-circle flex-center">
                                <img src="assets/images/thumbs/vendor-img3.png" alt="">
                            </div>
                            <div class="vendor-card__item bg-white rounded-circle flex-center">
                                <img src="assets/images/thumbs/vendor-img4.png" alt="">
                            </div>
                            <div class="vendor-card__item bg-white rounded-circle flex-center">
                                <img src="assets/images/thumbs/vendor-img5.png" alt="">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-3 col-lg-4 col-sm-6" data-aos="zoom-in" data-aos-duration="400">
                    <div class="vendor-card text-center px-16 pb-24">
                        <div class="">
                            <img src="assets/images/thumbs/vendor-logo2.png" alt="" class="vendor-card__logo m-12">
                            <h6 class="title mt-32">
                                <a href="vendor-details.php" class="">Safeway</a>
                            </h6>
                            <span class="text-heading text-sm d-block">Delivery by 6:15am</span>
                            <a href="shop.php"
                                class="bg-white text-neutral-600 hover-bg-main-600 hover-text-white rounded-pill py-6 px-16 text-12 mt-8">$5
                                off Snack & Candy</a>
                        </div>
                        <div class="vendor-card__list mt-22 flex-center flex-wrap gap-8">
                            <div class="vendor-card__item bg-white rounded-circle flex-center">
                                <img src="assets/images/thumbs/vendor-img1.png" alt="">
                            </div>
                            <div class="vendor-card__item bg-white rounded-circle flex-center">
                                <img src="assets/images/thumbs/vendor-img2.png" alt="">
                            </div>
                            <div class="vendor-card__item bg-white rounded-circle flex-center">
                                <img src="assets/images/thumbs/vendor-img3.png" alt="">
                            </div>
                            <div class="vendor-card__item bg-white rounded-circle flex-center">
                                <img src="assets/images/thumbs/vendor-img4.png" alt="">
                            </div>
                            <div class="vendor-card__item bg-white rounded-circle flex-center">
                                <img src="assets/images/thumbs/vendor-img5.png" alt="">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-3 col-lg-4 col-sm-6" data-aos="zoom-in" data-aos-duration="600">
                    <div class="vendor-card text-center px-16 pb-24">
                        <div class="">
                            <img src="assets/images/thumbs/vendor-logo3.png" alt="" class="vendor-card__logo m-12">
                            <h6 class="title mt-32">
                                <a href="vendor-details.php" class="">Food Max</a>
                            </h6>
                            <span class="text-heading text-sm d-block">Delivery by 6:15am</span>
                            <a href="shop.php"
                                class="bg-white text-neutral-600 hover-bg-main-600 hover-text-white rounded-pill py-6 px-16 text-12 mt-8">$5
                                off Snack & Candy</a>
                        </div>
                        <div class="vendor-card__list mt-22 flex-center flex-wrap gap-8">
                            <div class="vendor-card__item bg-white rounded-circle flex-center">
                                <img src="assets/images/thumbs/vendor-img1.png" alt="">
                            </div>
                            <div class="vendor-card__item bg-white rounded-circle flex-center">
                                <img src="assets/images/thumbs/vendor-img2.png" alt="">
                            </div>
                            <div class="vendor-card__item bg-white rounded-circle flex-center">
                                <img src="assets/images/thumbs/vendor-img3.png" alt="">
                            </div>
                            <div class="vendor-card__item bg-white rounded-circle flex-center">
                                <img src="assets/images/thumbs/vendor-img4.png" alt="">
                            </div>
                            <div class="vendor-card__item bg-white rounded-circle flex-center">
                                <img src="assets/images/thumbs/vendor-img5.png" alt="">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-3 col-lg-4 col-sm-6" data-aos="zoom-in" data-aos-duration="800">
                    <div class="vendor-card text-center px-16 pb-24">
                        <div class="">
                            <img src="assets/images/thumbs/vendor-logo4.png" alt="" class="vendor-card__logo m-12">
                            <h6 class="title mt-32">
                                <a href="vendor-details.php" class="">HRmart</a>
                            </h6>
                            <span class="text-heading text-sm d-block">Delivery by 6:15am</span>
                            <a href="shop.php"
                                class="bg-white text-neutral-600 hover-bg-main-600 hover-text-white rounded-pill py-6 px-16 text-12 mt-8">$5
                                off Snack & Candy</a>
                        </div>
                        <div class="vendor-card__list mt-22 flex-center flex-wrap gap-8">
                            <div class="vendor-card__item bg-white rounded-circle flex-center">
                                <img src="assets/images/thumbs/vendor-img1.png" alt="">
                            </div>
                            <div class="vendor-card__item bg-white rounded-circle flex-center">
                                <img src="assets/images/thumbs/vendor-img2.png" alt="">
                            </div>
                            <div class="vendor-card__item bg-white rounded-circle flex-center">
                                <img src="assets/images/thumbs/vendor-img3.png" alt="">
                            </div>
                            <div class="vendor-card__item bg-white rounded-circle flex-center">
                                <img src="assets/images/thumbs/vendor-img4.png" alt="">
                            </div>
                            <div class="vendor-card__item bg-white rounded-circle flex-center">
                                <img src="assets/images/thumbs/vendor-img5.png" alt="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <ul class="pagination flex-center flex-wrap gap-16">
                <li class="page-item">
                    <a class="page-link h-64 w-64 flex-center text-xxl rounded-circle fw-medium text-neutral-600 border border-gray-100"
                        href="#">
                        <i class="ph-bold ph-arrow-left"></i>
                    </a>
                </li>
                <li class="page-item active">
                    <a class="page-link h-64 w-64 flex-center text-md rounded-circle fw-medium text-neutral-600 border border-gray-100"
                        href="#">01</a>
                </li>
                <li class="page-item">
                    <a class="page-link h-64 w-64 flex-center text-md rounded-circle fw-medium text-neutral-600 border border-gray-100"
                        href="#">02</a>
                </li>
                <li class="page-item">
                    <a class="page-link h-64 w-64 flex-center text-md rounded-circle fw-medium text-neutral-600 border border-gray-100"
                        href="#">03</a>
                </li>
                <li class="page-item">
                    <a class="page-link h-64 w-64 flex-center text-md rounded-circle fw-medium text-neutral-600 border border-gray-100"
                        href="#">04</a>
                </li>
                <li class="page-item">
                    <a class="page-link h-64 w-64 flex-center text-md rounded-circle fw-medium text-neutral-600 border border-gray-100"
                        href="#">05</a>
                </li>
                <li class="page-item">
                    <a class="page-link h-64 w-64 flex-center text-md rounded-circle fw-medium text-neutral-600 border border-gray-100"
                        href="#">06</a>
                </li>
                <li class="page-item">
                    <a class="page-link h-64 w-64 flex-center text-md rounded-circle fw-medium text-neutral-600 border border-gray-100"
                        href="#">07</a>
                </li>
                <li class="page-item">
                    <a class="page-link h-64 w-64 flex-center text-xxl rounded-circle fw-medium text-neutral-600 border border-gray-100"
                        href="#">
                        <i class="ph-bold ph-arrow-right"></i>
                    </a>
                </li>
            </ul>
        </div>
    </section>
    <!-- =================================== Vendors List section End ===================================== -->

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

    <!-- =============================== Newsletter Section Start ============================ -->
    <div class="newsletter">
        <div class="container container-lg">
            <div class="newsletter-box position-relative rounded-16 flex-align gap-16 flex-wrap z-1">
                <img src="assets/images/bg/newsletter-bg.png" alt=""
                    class="position-absolute inset-block-start-0 inset-inline-start-0 z-n1 w-100 h-100 opacity-6">
                <div class="row align-items-center">
                    <div class="col-xl-6">
                        <div class="">
                            <h1 class="text-white mb-12" data-aos="fade-down" data-aos-duration="800">Don't Miss Out on
                                Grocery Deals</h1>
                            <p class="text-white h5 mb-0" data-aos="fade-up" data-aos-duration="800">SING UP FOR THE
                                UPDATE NEWSLETTER</p>
                            <form action="#" class="position-relative mt-40" data-aos="zoom-in" data-aos-duration="800">
                                <input type="email"
                                    class="form-control common-input rounded-pill text-white py-22 px-16 pe-144"
                                    placeholder="Your email address...">
                                <button type="submit"
                                    class="btn btn-main-two rounded-pill position-absolute top-50 translate-middle-y inset-inline-end-0 me-10">Subscribe
                                </button>
                            </form>
                        </div>
                    </div>
                    <div class="col-xl-6 text-center d-xl-block d-none">
                        <img src="assets/images/thumbs/newsletter-img.png" alt="" data-aos="zoom-in"
                            data-aos-duration="800">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- =============================== Newsletter Section End ============================ -->

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