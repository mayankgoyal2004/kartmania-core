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
$fetchBrandsApi = getenv('FETCH_ALL_BRAND_API');



// response data
$resultMedia = $utils->fetchFromApi($fetchAllMediaApi);
$resultProduct = $utils->fetchFromApi($fetchAllProductApi);
$resultProductCategory = $utils->fetchFromApi($fetchAllProductCategoryApi);
$resultBrands = $utils->fetchFromApi($fetchBrandsApi);


// echo "<pre>";
// print_r($fetchBrandsApi);
// exit;


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

?>

<!DOCTYPE html>
<html lang="en" class="">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Title -->
    <title> Kartmania </title>
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
    <?php if (isset($_SESSION['success'])) { ?>
        <script>
            const notyf = new Notyf({
                position: {
                    x: 'center',
                    y: 'top'
                },
                types: [
                    {
                        type: 'success',
                        background: '#4dc76f', // Change background color
                        textColor: '#FFFFFF',  // Change text color
                        dismissible: false,
                        duration: 4000
                    }
                ]
            });
            notyf.success("<?php echo $_SESSION['success']; ?>");
        </script>
        <?php
        unset($_SESSION['success']);
        ?>
    <?php } ?>

    <?php if (isset($_SESSION['error'])) { ?>
        <script>
            const notyf = new Notyf({
                position: {
                    x: 'center',
                    y: 'top'
                },
                types: [
                    {
                        type: 'error',
                        background: '#ff1916',
                        textColor: '#FFFFFF',
                        dismissible: false,
                        duration: 4000
                    }
                ]
            });
            notyf.error("<?php echo $_SESSION['error']; ?>");
        </script>
        <?php
        unset($_SESSION['error']);
        ?>
    <?php } ?>

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

    <!-- ============================ Banner Section start =============================== -->
    <div class="banner">
        <div class="container container-lg">
            <div class="banner-item rounded-24 overflow-hidden position-relative arrow-center">
                <a href="#featureSection"
                    class="scroll-down w-84 h-84 text-center flex-center bg-main-600 rounded-circle border border-5 text-white border-white position-absolute start-50 translate-middle-x bottom-0 hover-bg-main-800">
                    <span class="icon line-height-0"><i class="ph ph-caret-double-down"></i></span>
                </a>
                <img src="assets/images/bg/banner-bg.png" alt=""
                    class="banner-img position-absolute inset-block-start-0 inset-inline-start-0 w-100 h-100 z-n1 object-fit-cover rounded-24">

                <div class="flex-align">
                    <button type="button" id="banner-prev"
                        class="slick-prev slick-arrow flex-center rounded-circle box-shadow-4xl bg-white text-xl hover-bg-main-600 hover-text-white transition-1">
                        <i class="ph ph-caret-left"></i>
                    </button>
                    <button type="button" id="banner-next"
                        class="slick-next slick-arrow flex-center rounded-circle box-shadow-4xl bg-white text-xl hover-bg-main-600 hover-text-white transition-1">
                        <i class="ph ph-caret-right"></i>
                    </button>
                </div>

                <div id="main-banner" class="banner-slider">
                    <?php foreach ($bannerImages as $image): ?>
                        <div class="banner-slider__item">
                            <div class="banner-slider__inner flex-between position-relative">
                                <div class="banner-item__content">
                                    <span
                                        class="fw-semibold text-success-600 text-capitalize mb-8 animate-left-right animation-delay-08">Save
                                        up to 50% off on your first order</span>
                                    <h2 class="banner-item__title max-w-700 mb-30 animate-left-right animation-delay-1">
                                        Daily Grocery Order and Get <span class="text-main-600">Express</span> Delivery</h2>
                                    <div class="d-flex align-items-center gap-16 animate-left-right animation-delay-12">
                                        <a href="<?= getenv("BASE_URL") . "/product" ?>"
                                            class="btn btn-main d-inline-flex align-items-center rounded-pill gap-8">
                                            Explore Shop <span class="icon text-xl d-flex"><i
                                                    class="ph ph-shopping-cart-simple"></i> </span>
                                        </a>
                                        <div class="d-flex align-items-end gap-8">
                                            <span class="text-heading fst-italic text-sm">Starting at</span>
                                            <h6 class="text-danger-600 mb-0"> ₹60.99</h6>
                                        </div>
                                    </div>
                                </div>
                                <div class="banner-item__thumb animate-scale animation-delay-12">
                                    <img src="<?= $image['image'] ?>" alt="">
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>

                    <?php if (empty($bannerImages)): ?>
                        <div class="banner-slider__item">
                            <div class="banner-slider__inner flex-between position-relative">
                                <div class="banner-item__content">
                                    <span
                                        class="fw-semibold text-success-600 text-capitalize mb-8 animate-left-right animation-delay-08">Save
                                        up to 50% off on your first order</span>
                                    <h2 class="banner-item__title max-w-700 mb-30 animate-left-right animation-delay-1">
                                        Daily Grocery Order and Get <span class="text-main-600">Express</span> Delivery</h2>
                                    <div class="d-flex align-items-center gap-16 animate-left-right animation-delay-12">
                                        <a href="shop.php"
                                            class="btn btn-main d-inline-flex align-items-center rounded-pill gap-8">
                                            Explore Shop <span class="icon text-xl d-flex"><i
                                                    class="ph ph-shopping-cart-simple"></i> </span>
                                        </a>
                                        <div class="d-flex align-items-end gap-8">
                                            <span class="text-heading fst-italic text-sm">Starting at</span>
                                            <h6 class="text-danger-600 mb-0"> ₹60.99</h6>
                                        </div>
                                    </div>
                                </div>
                                <div class="banner-item__thumb animate-scale animation-delay-12">
                                    <img src="assets/images/thumbs/banner-img3.png" alt="">
                                </div>
                            </div>
                        </div>
                        <div class="banner-slider__item">
                            <div class="banner-slider__inner flex-between position-relative">
                                <div class="banner-item__content">
                                    <span
                                        class="fw-semibold text-success-600 text-capitalize mb-8 animate-left-right animation-delay-08">Save
                                        up to 50% off on your first order</span>
                                    <h2 class="banner-item__title max-w-700 mb-30 animate-left-right animation-delay-1">
                                        Daily Grocery Order and Get <span class="text-main-600">Express</span> Delivery</h2>
                                    <div class="d-flex align-items-center gap-16 animate-left-right animation-delay-12">
                                        <a href="shop.php"
                                            class="btn btn-main d-inline-flex align-items-center rounded-pill gap-8">
                                            Explore Shop <span class="icon text-xl d-flex"><i
                                                    class="ph ph-shopping-cart-simple"></i> </span>
                                        </a>
                                        <div class="d-flex align-items-end gap-8">
                                            <span class="text-heading fst-italic text-sm">Starting at</span>
                                            <h6 class="text-danger-600 mb-0"> $60.99</h6>
                                        </div>
                                    </div>
                                </div>
                                <div class="banner-item__thumb animate-scale animation-delay-12">
                                    <img src="assets/images/thumbs/banner-img1.png" alt="">
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <!-- ============================ Banner Section End =============================== -->

    <!-- ============================ Feature Section start =============================== -->
    <div class="feature" id="featureSection">
        <div class="container container-lg">
            <div class="position-relative arrow-center gradient-shadow">
                <div class="flex-align">
                    <button type="button" id="feature-item-wrapper-prev"
                        class="slick-prev slick-arrow flex-center rounded-circle bg-white text-xl hover-bg-main-600 hover-text-white transition-1">
                        <i class="ph ph-caret-left"></i>
                    </button>
                    <button type="button" id="feature-item-wrapper-next"
                        class="slick-next slick-arrow flex-center rounded-circle bg-white text-xl hover-bg-main-600 hover-text-white transition-1">
                        <i class="ph ph-caret-right"></i>
                    </button>
                </div>
                <div id="category-feature-wrapper" class="feature-item-wrapper">
                    <?php
                    $counter = 0;
                    foreach ($resultProductCategory['data']['data'] as $key => $category):
                        if ($counter >= 10) {
                            break;
                        }
                        $counter++;
                        ?>
                        <div class="feature-item text-center wow bounceIn" data-aos="fade-up" data-aos-duration="400">
                            <div class="feature-item__thumb rounded-circle">
                                <a href="<?= getenv("BASE_URL") . "/product/category/" . $utils->makeSlug($category['name']) ?>"
                                    class="w-100 h-100 flex-center">
                                    <img src="<?= isset($category['image']) ? $category['image'] : "assets/images/thumbs/features-three-img3.png" ?>"
                                        alt="">
                                </a>
                            </div>
                            <div class="feature-item__content mt-16">
                                <h6 class="text-lg mb-8">
                                    <a href="<?= getenv("BASE_URL") . "/product/category/" . $utils->makeSlug($category['name']) ?>"
                                        class="text-inherit"><?= $category['name'] ?></a>
                                </h6>
                                <span class="text-sm text-gray-400"><?= $category['_count']['products'] ?>+ Products</span>
                            </div>
                        </div>
                    <?php endforeach; ?>


                    <?php if (empty($resultProductCategory['data']['data'])): ?>


                        <div class="feature-item text-center wow bounceIn" data-aos="fade-up" data-aos-duration="400">
                            <div class="feature-item__thumb rounded-circle">
                                <a href="shop.php" class="w-100 h-100 flex-center">
                                    <img src="assets/images/product/shorts/dymamik_black/1 (1).jpg" alt="">
                                </a>
                            </div>
                            <div class="feature-item__content mt-16">
                                <h6 class="text-lg mb-8"><a href="shop.php" class="text-inherit">Vegetables</a></h6>
                                <span class="text-sm text-gray-400">125+ Products</span>
                            </div>
                        </div>
                        <div class="feature-item text-center wow bounceIn" data-aos="fade-up" data-aos-duration="600">
                            <div class="feature-item__thumb rounded-circle">
                                <a href="shop.php" class="w-100 h-100 flex-center">
                                    <img src="assets/images/product/shorts/dymamik_black/1 (2).jpg" alt="">
                                </a>
                            </div>
                            <div class="feature-item__content mt-16">
                                <h6 class="text-lg mb-8"><a href="shop.php" class="text-inherit">Fish & Meats</a></h6>
                                <span class="text-sm text-gray-400">125+ Products</span>
                            </div>
                        </div>
                        <div class="feature-item text-center wow bounceIn" data-aos="fade-up" data-aos-duration="800">
                            <div class="feature-item__thumb rounded-circle">
                                <a href="shop.php" class="w-100 h-100 flex-center">
                                    <img src="assets/images/product/shorts/dymamik_black/1 (3).jpg" alt="">
                                </a>
                            </div>
                            <div class="feature-item__content mt-16">
                                <h6 class="text-lg mb-8"><a href="shop.php" class="text-inherit">Desserts</a></h6>
                                <span class="text-sm text-gray-400">125+ Products</span>
                            </div>
                        </div>
                        <div class="feature-item text-center wow bounceIn" data-aos="fade-up" data-aos-duration="1000">
                            <div class="feature-item__thumb rounded-circle">
                                <a href="shop.php" class="w-100 h-100 flex-center">
                                    <img src="assets/images/product/shorts/dymamik_black/1 (4).jpg" alt="">
                                </a>
                            </div>
                            <div class="feature-item__content mt-16">
                                <h6 class="text-lg mb-8"><a href="shop.php" class="text-inherit">Drinks & Juice</a></h6>
                                <span class="text-sm text-gray-400">125+ Products</span>
                            </div>
                        </div>
                        <div class="feature-item text-center wow bounceIn" data-aos="fade-up" data-aos-duration="1200">
                            <div class="feature-item__thumb rounded-circle">
                                <a href="shop.php" class="w-100 h-100 flex-center">
                                    <img src="assets/images/product/shorts/dymamik_black/1 (5).jpg" alt="">
                                </a>
                            </div>
                            <div class="feature-item__content mt-16">
                                <h6 class="text-lg mb-8"><a href="shop.php" class="text-inherit">Animals Food</a></h6>
                                <span class="text-sm text-gray-400">125+ Products</span>
                            </div>
                        </div>
                        <div class="feature-item text-center wow bounceIn" data-aos="fade-up" data-aos-duration="1400">
                            <div class="feature-item__thumb rounded-circle">
                                <a href="shop.php" class="w-100 h-100 flex-center">
                                    <img src="assets/images/product/shorts/dymamik_black/1 (6).jpg" alt="">
                                </a>
                            </div>
                            <div class="feature-item__content mt-16">
                                <h6 class="text-lg mb-8"><a href="shop.php" class="text-inherit">Fresh Fruits</a></h6>
                                <span class="text-sm text-gray-400">125+ Products</span>
                            </div>
                        </div>
                        <div class="feature-item text-center wow bounceIn" data-aos="fade-up" data-aos-duration="1600">
                            <div class="feature-item__thumb rounded-circle">
                                <a href="shop.php" class="w-100 h-100 flex-center">
                                    <img src="assets/images/product/shorts/dymamik_black/1 (7).jpg" alt="">
                                </a>
                            </div>
                            <div class="feature-item__content mt-16">
                                <h6 class="text-lg mb-8"><a href="shop.php" class="text-inherit">Yummy Candy</a></h6>
                                <span class="text-sm text-gray-400">125+ Products</span>
                            </div>
                        </div>
                    <?php endif; ?>


                </div>
            </div>
        </div>
    </div>
    <!-- ============================ Feature Section End =============================== -->

    <!-- ======================== promotional banner Start ============================== -->
    <section class="promotional-banner pt-80">
        <div class="container container-lg">
            <div class="row gy-4">

                <?php foreach ($heroSectionImages as $key => $image): ?>
                    <div class="col-xl-3 col-sm-6 col-xs-6 wow bounceIn" data-aos="fade-up" data-aos-duration="400">
                        <div
                            class="promotional-banner-item position-relative rounded-24 overflow-hidden z-1 py-52 ps-40 pe-24 h-100">
                            <img src="<?= htmlspecialchars($image['image']) ?>" alt=""
                                class="position-absolute inset-block-start-0 inset-inline-start-0 w-100 h-100 object-fit-cover z-n1">
                            <div class="promotional-banner-item__content">
                                <h6 class="promotional-banner-item__title text-2xl max-w-184">
                                    <?= htmlspecialchars($image['title']) ?>
                                </h6>
                                <div class="d-flex align-items-end gap-8">
                                    <span class="text-heading fst-italic text-sm">Starting at</span>
                                    <h6 class="text-danger-600 mb-0 text-xl"> <?= htmlspecialchars($image['description']) ?>
                                    </h6>
                                </div>
                                <a href="shop.php"
                                    class="btn btn-main d-inline-flex align-items-center rounded-pill gap-8 mt-24">
                                    Shop Now
                                    <span class="icon text-xl d-flex"><i class="ph ph-arrow-right"></i></span>
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>

                <?php if (empty($heroSectionImages)): ?>
                    <div class="col-xl-3 col-sm-6 col-xs-6 wow bounceIn" data-aos="fade-up" data-aos-duration="400">
                        <div
                            class="promotional-banner-item position-relative rounded-24 overflow-hidden z-1 py-52 ps-40 pe-24 h-100">
                            <img src="assets/images/thumbs/promotional-banner-img1.png" alt=""
                                class="position-absolute inset-block-start-0 inset-inline-start-0 w-100 h-100 object-fit-cover z-n1">
                            <div class="promotional-banner-item__content">
                                <h6 class="promotional-banner-item__title text-2xl max-w-184">Everyday Fresh Meat</h6>
                                <div class="d-flex align-items-end gap-8">
                                    <span class="text-heading fst-italic text-sm">Starting at</span>
                                    <h6 class="text-danger-600 mb-0 text-xl"> $60.99</h6>
                                </div>
                                <a href="shop.php"
                                    class="btn btn-main d-inline-flex align-items-center rounded-pill gap-8 mt-24">
                                    Shop Now
                                    <span class="icon text-xl d-flex"><i class="ph ph-arrow-right"></i></span>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-sm-6 col-xs-6 wow bounceIn" data-aos="fade-up" data-aos-duration="600">
                        <div
                            class="promotional-banner-item position-relative rounded-24 overflow-hidden z-1 py-52 ps-40 pe-24 h-100">
                            <img src="assets/images/thumbs/promotional-banner-img2.png" alt=""
                                class="position-absolute inset-block-start-0 inset-inline-start-0 w-100 h-100 object-fit-cover z-n1">
                            <div class="promotional-banner-item__content">
                                <h6 class="promotional-banner-item__title text-2xl max-w-184">Daily Fresh Vegetables
                                </h6>
                                <div class="d-flex align-items-end gap-8">
                                    <span class="text-heading fst-italic text-sm">Starting at</span>
                                    <h6 class="text-danger-600 mb-0 text-xl"> $60.99</h6>
                                </div>
                                <a href="shop.php"
                                    class="btn btn-main d-inline-flex align-items-center rounded-pill gap-8 mt-24">
                                    Shop Now
                                    <span class="icon text-xl d-flex"><i class="ph ph-arrow-right"></i></span>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-sm-6 col-xs-6 wow bounceIn" data-aos="fade-up" data-aos-duration="800">
                        <div
                            class="promotional-banner-item position-relative rounded-24 overflow-hidden z-1 py-52 ps-40 pe-24 h-100">
                            <img src="assets/images/thumbs/promotional-banner-img3.png" alt=""
                                class="position-absolute inset-block-start-0 inset-inline-start-0 w-100 h-100 object-fit-cover z-n1">
                            <div class="promotional-banner-item__content">
                                <h6 class="promotional-banner-item__title text-2xl max-w-184">Everyday Fresh Milk</h6>
                                <div class="d-flex align-items-end gap-8">
                                    <span class="text-heading fst-italic text-sm">Starting at</span>
                                    <h6 class="text-danger-600 mb-0 text-xl"> $60.99</h6>
                                </div>
                                <a href="shop.php"
                                    class="btn btn-main d-inline-flex align-items-center rounded-pill gap-8 mt-24">
                                    Shop Now
                                    <span class="icon text-xl d-flex"><i class="ph ph-arrow-right"></i></span>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-sm-6 col-xs-6 wow bounceIn" data-aos="fade-up" data-aos-duration="1000">
                        <div
                            class="promotional-banner-item position-relative rounded-24 overflow-hidden z-1 py-52 ps-40 pe-24 h-100">
                            <img src="assets/images/thumbs/promotional-banner-img4.png" alt=""
                                class="position-absolute inset-block-start-0 inset-inline-start-0 w-100 h-100 object-fit-cover z-n1">
                            <div class="promotional-banner-item__content">
                                <h6 class="promotional-banner-item__title text-2xl max-w-184">Everyday Fresh Fruits</h6>

                                <a href="shop.php"
                                    class="btn btn-main d-inline-flex align-items-center rounded-pill gap-8 mt-24">
                                    Shop Now
                                    <span class="icon text-xl d-flex"><i class="ph ph-arrow-right"></i></span>
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>
    <!-- ======================== promotional banner End ============================== -->

    <div class="product pt-60">
        <div class="container container-lg">
            <div class="section-heading">
                <div class="flex-between flex-wrap gap-8">
                    <h5 class="mb-0 wow fadeInLeft">Flash Sales Today</h5>
                    <div class="flex-align gap-16 wow fadeInRight">
                        <a href="shop.php"
                            class="text-sm fw-medium text-gray-700 hover-text-main-600 hover-text-decoration-underline">View
                            All Deals</a>
                        <div class="flex-align gap-8">
                            <button type="button" id="product-one-prev"
                                class="slick-prev slick-arrow flex-center rounded-circle border border-gray-100 hover-border-main-600 text-xl hover-bg-main-600 hover-text-white transition-1">
                                <i class="ph ph-caret-left"></i>
                            </button>
                            <button type="button" id="product-one-next"
                                class="slick-next slick-arrow flex-center rounded-circle border border-gray-100 hover-border-main-600 text-xl hover-bg-main-600 hover-text-white transition-1">
                                <i class="ph ph-caret-right"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="product-one-slider g-12">
                <?php $counter = 0;
                foreach ($resultProduct['data']['data'] as $key => $product):

                    if ($counter >= 18) {
                        break;
                    }
                    $counter++;
                    // Find the primary image
                    $primaryImage = null;
                    foreach ($product['images'] as $image) {
                        if ($image['isPrimary']) {
                            $primaryImage = $image['imageUrl'];
                            break;
                        }
                    }
                    // Fallback to a placeholder image if no primary image is found
                    $primaryImage = $primaryImage ?: 'assets/images/thumbs/product-img28.png';

                    // Calculate discounted price
                    $originalPrice = floatval($product['price']);
                    $discountPercentage = floatval($product['discountValue']);
                    $discountedPrice = $originalPrice * (1 - $discountPercentage / 100);

                    // Calculate stock and sold percentage
                    $remainingStock = intval($product['stock']);
                    $sold = 18; // Assuming 18 sold as per static HTML
                    $totalStock = $remainingStock + $sold; // Total stock = remaining + sold
                    $soldPercentage = ($totalStock > 0) ? ($sold / $totalStock) * 100 : 0;


                    // Calculate rating: Use average of review ratings if available, else use popularity
                    $rating = 0;
                    $reviewCount = 0;

                    if (!empty($product['reviews'])) {
                        $totalRating = 0;
                        $validReviews = 0;

                        foreach ($product['reviews'] as $review) {
                            // Safely extract rating value
                            if (isset($review['rating'])) {
                                if (is_array($review['rating'])) {
                                    // If rating is an array, try to get numeric value
                                    $ratingValue = isset($review['rating']['value']) ? floatval($review['rating']['value']) : 0;
                                } else {
                                    // If rating is direct value
                                    $ratingValue = floatval($review['rating']);
                                }

                                if ($ratingValue > 0) {
                                    $totalRating += $ratingValue;
                                    $validReviews++;
                                }
                            }
                        }

                        if ($validReviews > 0) {
                            $rating = $totalRating / $validReviews;
                            $reviewCount = $validReviews;
                        }
                    }

                    // Fallback to popularity if no valid reviews
                    if ($rating === 0) {
                        $rating = ($product['popularity'] ?? 0) / 2;
                        $reviewCount = 0; // No actual reviews, just using popularity
                    }

                    // Format rating to 1 decimal place
                    $formattedRating = number_format($rating, 1);
                    ?>
                    <div class="" data-aos="fade-up" data-aos-duration="<?= 200 + $key * 200 ?>">
                        <div
                            class="product-card px-20 py-16 border border-gray-100 hover-border-main-600 rounded-16 position-relative transition-2">
                            <a href="javascript:void(0);" data-product-id="<?= htmlspecialchars($product['id']) ?>"
                                class="product-card__cart btn bg-main-50 text-main-600 hover-bg-main-600 hover-text-white py-11 px-24 rounded-pill flex-align gap-8 position-absolute inset-block-start-0 inset-inline-end-0 me-16 mt-16 add-to-cart">
                                Add <i class="ph ph-shopping-cart"></i>
                            </a>
                            <a href="<?= getenv("BASE_URL") . "/product/" . $utils->makeSlug($product['name']) ?>"
                                class="product-card__thumb flex-center overflow-hidden">
                                <img src="<?= htmlspecialchars($primaryImage) ?>"
                                    alt="<?= htmlspecialchars($product['name']) ?>">
                            </a>
                            <div class="product-card__content mt-12">
                                <div class="product-card__price mb-8 d-flex align-items-center gap-8">
                                    <span
                                        class="text-heading text-md fw-semibold">₹<?= number_format($discountedPrice, 2) ?>
                                        <span class="text-gray-500 fw-normal">/Qty</span></span>
                                    <span
                                        class="text-gray-400 text-md fw-semibold text-decoration-line-through">₹<?= number_format($originalPrice, 2) ?></span>
                                </div>
                                <div class="flex-align mb-20 mt-16 gap-6">
                                    <?php if ($reviewCount > 0): ?>
                                        <span class="text-xs fw-medium text-gray-500">
                                            <?= $formattedRating ?>
                                        </span>
                                        <span class="text-xs fw-medium text-warning-600 d-flex">
                                            <i class="ph-fill ph-star"></i>
                                        </span>
                                        <span class="text-xs fw-medium text-gray-500">
                                            (<?= $reviewCount ?>)
                                        </span>
                                    <?php else: ?>
                                        <span class="text-xs fw-medium text-gray-500">
                                            No reviews yet
                                        </span>
                                    <?php endif; ?>
                                </div>
                                <h6 class="title text-lg fw-semibold mt-12 mb-20">
                                    <a href="<?= getenv("BASE_URL") . "/product/" . $utils->makeSlug($product['name']) ?>"
                                        class="link text-line-2"><?= htmlspecialchars($product['name']) ?></a>
                                </h6>
                                <div class="mt-12">
                                    <div class="progress w-100 bg-color-three rounded-pill h-4" role="progressbar"
                                        aria-label="Basic example" aria-valuenow="<?= $soldPercentage ?>" aria-valuemin="0"
                                        aria-valuemax="100">
                                        <div class="progress-bar bg-main-600 rounded-pill"
                                            style="width: <?= $soldPercentage ?>%"></div>
                                    </div>
                                    <span class="text-gray-900 text-xs fw-medium mt-8">Sold:
                                        <?= $sold ?>/<?= $totalStock ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>

                <?php if (empty($resultProduct['data']['data'])): ?>
                    <div class="" data-aos="fade-up" data-aos-duration="200">
                        <div
                            class="product-card px-20 py-16 border border-gray-100 hover-border-main-600 rounded-16 position-relative transition-2">
                            <a href="cart.php"
                                class="product-card__cart btn bg-main-50 text-main-600 hover-bg-main-600 hover-text-white py-11 px-24 rounded-pill flex-align gap-8 position-absolute inset-block-start-0 inset-inline-end-0 me-16 mt-16">
                                Add <i class="ph ph-shopping-cart"></i>
                            </a>

                            <a href="product-details.php" class="product-card__thumb flex-center overflow-hidden">
                                <img src="assets/images/product/shorts/dynamic_dgrey/1 (1).jpg" alt="">
                            </a>
                            <div class="product-card__content mt-12">
                                <div class="product-card__price mb-8 d-flex align-items-center gap-8">
                                    <span class="text-heading text-md fw-semibold ">$14.99 <span
                                            class="text-gray-500 fw-normal">/Qty</span> </span>
                                    <span class="text-gray-400 text-md fw-semibold text-decoration-line-through">
                                        $28.99</span>
                                </div>
                                <div class="flex-align gap-6">
                                    <span class="text-xs fw-bold text-gray-600">4.8</span>
                                    <span class="text-15 fw-bold text-warning-600 d-flex"><i
                                            class="ph-fill ph-star"></i></span>
                                    <span class="text-xs fw-bold text-gray-600">(17k)</span>
                                </div>
                                <h6 class="title text-lg fw-semibold mt-12 mb-20">
                                    <a href="product-details.php" class="link text-line-2">Taylor Farms Broccoli Florets
                                        Vegetables</a>
                                </h6>
                                <div class="mt-12">
                                    <div class="progress w-100  bg-color-three rounded-pill h-4" role="progressbar"
                                        aria-label="Basic example" aria-valuenow="35" aria-valuemin="0" aria-valuemax="100">
                                        <div class="progress-bar bg-main-600 rounded-pill" style="width: 35%"></div>
                                    </div>
                                    <span class="text-gray-900 text-xs fw-medium mt-8">Sold: 18/35</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="" data-aos="fade-up" data-aos-duration="400">
                        <div
                            class="product-card px-20 py-16 border border-gray-100 hover-border-main-600 rounded-16 position-relative transition-2">
                            <a href="cart.php"
                                class="product-card__cart btn bg-main-50 text-main-600 hover-bg-main-600 hover-text-white py-11 px-24 rounded-pill flex-align gap-8 position-absolute inset-block-start-0 inset-inline-end-0 me-16 mt-16">
                                Add <i class="ph ph-shopping-cart"></i>
                            </a>
                            <a href="product-details.php" class="product-card__thumb flex-center overflow-hidden">
                                <img src="assets/images/product/shorts/dynamic_dgrey/1 (2).jpg" alt="">
                            </a>
                            <div class="product-card__content mt-12">
                                <div class="product-card__price mb-8 d-flex align-items-center gap-8">
                                    <span class="text-heading text-md fw-semibold ">$14.99 <span
                                            class="text-gray-500 fw-normal">/Qty</span> </span>
                                    <span class="text-gray-400 text-md fw-semibold text-decoration-line-through">
                                        $28.99</span>
                                </div>
                                <div class="flex-align gap-6">
                                    <span class="text-xs fw-bold text-gray-600">4.8</span>
                                    <span class="text-15 fw-bold text-warning-600 d-flex"><i
                                            class="ph-fill ph-star"></i></span>
                                    <span class="text-xs fw-bold text-gray-600">(17k)</span>
                                </div>
                                <h6 class="title text-lg fw-semibold mt-12 mb-20">
                                    <a href="product-details.php" class="link text-line-2">Taylor Farms Broccoli Florets
                                        Vegetables</a>
                                </h6>
                                <div class="mt-12">
                                    <div class="progress w-100  bg-color-three rounded-pill h-4" role="progressbar"
                                        aria-label="Basic example" aria-valuenow="35" aria-valuemin="0" aria-valuemax="100">
                                        <div class="progress-bar bg-main-600 rounded-pill" style="width: 35%"></div>
                                    </div>
                                    <span class="text-gray-900 text-xs fw-medium mt-8">Sold: 18/35</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="" data-aos="fade-up" data-aos-duration="600">
                        <div
                            class="product-card px-20 py-16 border border-gray-100 hover-border-main-600 rounded-16 position-relative transition-2">
                            <a href="cart.php"
                                class="product-card__cart btn bg-main-50 text-main-600 hover-bg-main-600 hover-text-white py-11 px-24 rounded-pill flex-align gap-8 position-absolute inset-block-start-0 inset-inline-end-0 me-16 mt-16">
                                Add <i class="ph ph-shopping-cart"></i>
                            </a>
                            <a href="product-details.php" class="product-card__thumb flex-center overflow-hidden">
                                <img src="assets/images/product/shorts/dynamic_dgrey/1 (3).jpg" alt="">
                            </a>
                            <div class="product-card__content mt-12">
                                <div class="product-card__price mb-8 d-flex align-items-center gap-8">
                                    <span class="text-heading text-md fw-semibold ">$14.99 <span
                                            class="text-gray-500 fw-normal">/Qty</span> </span>
                                    <span class="text-gray-400 text-md fw-semibold text-decoration-line-through">
                                        $28.99</span>
                                </div>
                                <div class="flex-align gap-6">
                                    <span class="text-xs fw-bold text-gray-600">4.8</span>
                                    <span class="text-15 fw-bold text-warning-600 d-flex"><i
                                            class="ph-fill ph-star"></i></span>
                                    <span class="text-xs fw-bold text-gray-600">(17k)</span>
                                </div>
                                <h6 class="title text-lg fw-semibold mt-12 mb-20">
                                    <a href="product-details.php" class="link text-line-2">Taylor Farms Broccoli Florets
                                        Vegetables</a>
                                </h6>
                                <div class="mt-12">
                                    <div class="progress w-100  bg-color-three rounded-pill h-4" role="progressbar"
                                        aria-label="Basic example" aria-valuenow="35" aria-valuemin="0" aria-valuemax="100">
                                        <div class="progress-bar bg-main-600 rounded-pill" style="width: 35%"></div>
                                    </div>
                                    <span class="text-gray-900 text-xs fw-medium mt-8">Sold: 18/35</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="" data-aos="fade-up" data-aos-duration="800">
                        <div
                            class="product-card px-20 py-16 border border-gray-100 hover-border-main-600 rounded-16 position-relative transition-2">
                            <a href="cart.php"
                                class="product-card__cart btn bg-main-50 text-main-600 hover-bg-main-600 hover-text-white py-11 px-24 rounded-pill flex-align gap-8 position-absolute inset-block-start-0 inset-inline-end-0 me-16 mt-16">
                                Add <i class="ph ph-shopping-cart"></i>
                            </a>
                            <a href="product-details.php" class="product-card__thumb flex-center overflow-hidden">
                                <img src="assets/images/product/sports-bra/PS-PULSE-SBRA-DGREY/PS-PULSE-SBRA-DGREY_1.JPG"
                                    alt="">
                            </a>
                            <div class="product-card__content mt-12">
                                <div class="product-card__price mb-8 d-flex align-items-center gap-8">
                                    <span class="text-heading text-md fw-semibold ">$14.99 <span
                                            class="text-gray-500 fw-normal">/Qty</span> </span>
                                    <span class="text-gray-400 text-md fw-semibold text-decoration-line-through">
                                        $28.99</span>
                                </div>
                                <div class="flex-align gap-6">
                                    <span class="text-xs fw-bold text-gray-600">4.8</span>
                                    <span class="text-15 fw-bold text-warning-600 d-flex"><i
                                            class="ph-fill ph-star"></i></span>
                                    <span class="text-xs fw-bold text-gray-600">(17k)</span>
                                </div>
                                <h6 class="title text-lg fw-semibold mt-12 mb-20">
                                    <a href="product-details.php" class="link text-line-2">Taylor Farms Broccoli Florets
                                        Vegetables</a>
                                </h6>
                                <div class="mt-12">
                                    <div class="progress w-100  bg-color-three rounded-pill h-4" role="progressbar"
                                        aria-label="Basic example" aria-valuenow="35" aria-valuemin="0" aria-valuemax="100">
                                        <div class="progress-bar bg-main-600 rounded-pill" style="width: 35%"></div>
                                    </div>
                                    <span class="text-gray-900 text-xs fw-medium mt-8">Sold: 18/35</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="" data-aos="fade-up" data-aos-duration="1000">
                        <div
                            class="product-card px-20 py-16 border border-gray-100 hover-border-main-600 rounded-16 position-relative transition-2">
                            <a href="cart.php"
                                class="product-card__cart btn bg-main-50 text-main-600 hover-bg-main-600 hover-text-white py-11 px-24 rounded-pill flex-align gap-8 position-absolute inset-block-start-0 inset-inline-end-0 me-16 mt-16">
                                Add <i class="ph ph-shopping-cart"></i>
                            </a>
                            <a href="product-details.php" class="product-card__thumb flex-center overflow-hidden">
                                <img src="assets/images/product/sports-bra/PS-PULSE-SBRA-DGREY/PS-PULSE-SBRA-DGREY_2.JPG"
                                    alt="">
                            </a>
                            <div class="product-card__content mt-12">
                                <div class="product-card__price mb-8 d-flex align-items-center gap-8">
                                    <span class="text-heading text-md fw-semibold ">$14.99 <span
                                            class="text-gray-500 fw-normal">/Qty</span> </span>
                                    <span class="text-gray-400 text-md fw-semibold text-decoration-line-through">
                                        $28.99</span>
                                </div>
                                <div class="flex-align gap-6">
                                    <span class="text-xs fw-bold text-gray-600">4.8</span>
                                    <span class="text-15 fw-bold text-warning-600 d-flex"><i
                                            class="ph-fill ph-star"></i></span>
                                    <span class="text-xs fw-bold text-gray-600">(17k)</span>
                                </div>
                                <h6 class="title text-lg fw-semibold mt-12 mb-20">
                                    <a href="product-details.php" class="link text-line-2">Taylor Farms Broccoli Florets
                                        Vegetables</a>
                                </h6>
                                <div class="mt-12">
                                    <div class="progress w-100  bg-color-three rounded-pill h-4" role="progressbar"
                                        aria-label="Basic example" aria-valuenow="35" aria-valuemin="0" aria-valuemax="100">
                                        <div class="progress-bar bg-main-600 rounded-pill" style="width: 35%"></div>
                                    </div>
                                    <span class="text-gray-900 text-xs fw-medium mt-8">Sold: 18/35</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="" data-aos="fade-up" data-aos-duration="1200">
                        <div
                            class="product-card px-20 py-16 border border-gray-100 hover-border-main-600 rounded-16 position-relative transition-2">
                            <a href="cart.php"
                                class="product-card__cart btn bg-main-50 text-main-600 hover-bg-main-600 hover-text-white py-11 px-24 rounded-pill flex-align gap-8 position-absolute inset-block-start-0 inset-inline-end-0 me-16 mt-16">
                                Add <i class="ph ph-shopping-cart"></i>
                            </a>
                            <a href="product-details.php" class="product-card__thumb flex-center overflow-hidden">
                                <img src="assets/images/product/trackpant/black/1 (1).jpg" alt="">
                            </a>
                            <div class="product-card__content mt-12">
                                <div class="product-card__price mb-8 d-flex align-items-center gap-8">
                                    <span class="text-heading text-md fw-semibold ">$14.99 <span
                                            class="text-gray-500 fw-normal">/Qty</span> </span>
                                    <span class="text-gray-400 text-md fw-semibold text-decoration-line-through">
                                        $28.99</span>
                                </div>
                                <div class="flex-align gap-6">
                                    <span class="text-xs fw-bold text-gray-600">4.8</span>
                                    <span class="text-15 fw-bold text-warning-600 d-flex"><i
                                            class="ph-fill ph-star"></i></span>
                                    <span class="text-xs fw-bold text-gray-600">(17k)</span>
                                </div>
                                <h6 class="title text-lg fw-semibold mt-12 mb-20">
                                    <a href="product-details.php" class="link text-line-2">Taylor Farms Broccoli Florets
                                        Vegetables</a>
                                </h6>
                                <div class="mt-12">
                                    <div class="progress w-100  bg-color-three rounded-pill h-4" role="progressbar"
                                        aria-label="Basic example" aria-valuenow="35" aria-valuemin="0" aria-valuemax="100">
                                        <div class="progress-bar bg-main-600 rounded-pill" style="width: 35%"></div>
                                    </div>
                                    <span class="text-gray-900 text-xs fw-medium mt-8">Sold: 18/35</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="" data-aos="fade-up" data-aos-duration="600">
                        <div
                            class="product-card px-20 py-16 border border-gray-100 hover-border-main-600 rounded-16 position-relative transition-2">
                            <a href="cart.php"
                                class="product-card__cart btn bg-main-50 text-main-600 hover-bg-main-600 hover-text-white py-11 px-24 rounded-pill flex-align gap-8 position-absolute inset-block-start-0 inset-inline-end-0 me-16 mt-16">
                                Add <i class="ph ph-shopping-cart"></i>
                            </a>
                            <a href="product-details.php" class="product-card__thumb flex-center overflow-hidden">
                                <img src="assets/images/product/sports-bra/PS-PULSE-SBRA-GREEN/PS-PULSE-SBRA-GREEN_3.JPG"
                                    alt="">
                            </a>
                            <div class="product-card__content mt-12">
                                <div class="product-card__price mb-8 d-flex align-items-center gap-8">
                                    <span class="text-heading text-md fw-semibold ">$14.99 <span
                                            class="text-gray-500 fw-normal">/Qty</span> </span>
                                    <span class="text-gray-400 text-md fw-semibold text-decoration-line-through">
                                        $28.99</span>
                                </div>
                                <div class="flex-align gap-6">
                                    <span class="text-xs fw-bold text-gray-600">4.8</span>
                                    <span class="text-15 fw-bold text-warning-600 d-flex"><i
                                            class="ph-fill ph-star"></i></span>
                                    <span class="text-xs fw-bold text-gray-600">(17k)</span>
                                </div>
                                <h6 class="title text-lg fw-semibold mt-12 mb-20">
                                    <a href="product-details.php" class="link text-line-2">Taylor Farms Broccoli Florets
                                        Vegetables</a>
                                </h6>
                                <div class="mt-12">
                                    <div class="progress w-100  bg-color-three rounded-pill h-4" role="progressbar"
                                        aria-label="Basic example" aria-valuenow="35" aria-valuemin="0" aria-valuemax="100">
                                        <div class="progress-bar bg-main-600 rounded-pill" style="width: 35%"></div>
                                    </div>
                                    <span class="text-gray-900 text-xs fw-medium mt-8">Sold: 18/35</span>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>

        </div>
    </div>

    <!-- ========================= flash sales Start ================================ -->
    <section class="flash-sales pt-80 overflow-hidden">
        <div class="container container-lg">
            <div class="row gy-4 arrow-style-two">
                <?php $initialDuration = 600;
                $increment = 200;
                foreach ($advertisementImages as $key => $image):
                    $duration = $initialDuration + ($key * $increment);
                    ?>
                    <div class="col-lg-6" data-aos="fade-up" data-aos-duration="<?= $duration ?>">
                        <div
                            class="flash-sales-item rounded-16 overflow-hidden z-1 position-relative flex-align flex-0 justify-content-between gap-8 ps-56-px">
                            <img src="<?= htmlspecialchars($image['image']) ?>" alt=""
                                class="position-absolute inset-block-start-0 inset-inline-start-0 w-100 h-100 object-fit-cover z-n1 flash-sales-item__bg">
                            <div class="flash-sales-item__content ms-sm-auto">
                                <h6 class="text-32 mb-8"><?= htmlspecialchars($image['title']) ?></h6>
                                <p class="text-neutral-500 mb-12">Time remaining until the end of the offer.</p>
                                <div class="countdown" id="countdown1">
                                    <ul class="countdown-list flex-align flex-wrap">
                                        <li
                                            class="countdown-list__item py-8 px-12 text-heading flex-align gap-4 text-sm fw-medium box-shadow-4xl rounded-5">
                                            <span class="days"></span> D
                                        </li>
                                        <li
                                            class="countdown-list__item py-8 px-12 text-heading flex-align gap-4 text-sm fw-medium box-shadow-4xl rounded-5">
                                            <span class="hours"></span> H
                                        </li>
                                        <li
                                            class="countdown-list__item py-8 px-12 text-heading flex-align gap-4 text-sm fw-medium box-shadow-4xl rounded-5">
                                            <span class="minutes"></span> M
                                        </li>
                                        <li
                                            class="countdown-list__item py-8 px-12 text-heading flex-align gap-4 text-sm fw-medium box-shadow-4xl rounded-5">
                                            <span class="seconds"></span> S
                                        </li>
                                    </ul>
                                </div>
                                <a href="shop.php"
                                    class="btn btn-main d-inline-flex align-items-center rounded-pill gap-8 mt-24">
                                    Shop Now
                                    <span class="icon text-xl d-flex"><i class="ph ph-arrow-right"></i></span>
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>

                <?php if (empty($advertisementImages)): ?>
                    <div class="col-lg-6" data-aos="fade-up" data-aos-duration="600">
                        <div
                            class="flash-sales-item rounded-16 overflow-hidden z-1 position-relative flex-align flex-0 justify-content-between gap-8 ps-56-px">
                            <img src="assets/images/bg/flash-sale-bg1.png" alt=""
                                class="position-absolute inset-block-start-0 inset-inline-start-0 w-100 h-100 object-fit-cover z-n1 flash-sales-item__bg">
                            <div class="flash-sales-item__content ms-sm-auto">
                                <h6 class="text-32 mb-8">X-Connect Smart Television</h6>
                                <p class="text-neutral-500 mb-12">Time remaining until the end of the offer.</p>
                                <div class="countdown" id="countdown1">
                                    <ul class="countdown-list flex-align flex-wrap">
                                        <li
                                            class="countdown-list__item py-8 px-12 text-heading flex-align gap-4 text-sm fw-medium box-shadow-4xl rounded-5">
                                            <span class="days"></span> D
                                        </li>
                                        <li
                                            class="countdown-list__item py-8 px-12 text-heading flex-align gap-4 text-sm fw-medium box-shadow-4xl rounded-5">
                                            <span class="hours"></span> H
                                        </li>
                                        <li
                                            class="countdown-list__item py-8 px-12 text-heading flex-align gap-4 text-sm fw-medium box-shadow-4xl rounded-5">
                                            <span class="minutes"></span> M
                                        </li>
                                        <li
                                            class="countdown-list__item py-8 px-12 text-heading flex-align gap-4 text-sm fw-medium box-shadow-4xl rounded-5">
                                            <span class="seconds"></span> S
                                        </li>
                                    </ul>
                                </div>
                                <a href="shop.php"
                                    class="btn btn-main d-inline-flex align-items-center rounded-pill gap-8 mt-24">
                                    Shop Now
                                    <span class="icon text-xl d-flex"><i class="ph ph-arrow-right"></i></span>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6" data-aos="fade-up" data-aos-duration="1000">
                        <div
                            class="flash-sales-item rounded-16 overflow-hidden z-1 position-relative flex-align flex-0 justify-content-between gap-8 ps-56-px">
                            <img src="assets/images/bg/flash-sale-bg2.png" alt=""
                                class="position-absolute inset-block-start-0 inset-inline-start-0 w-100 h-100 object-fit-cover z-n1 flash-sales-item__bg">
                            <div class="flash-sales-item__content">
                                <h6 class="text-32 mb-8">Vegetables Combo Box</h6>
                                <p class="text-heading mb-12">Time remaining until the end of the offer.</p>
                                <div class="countdown" id="countdown2">
                                    <ul class="countdown-list flex-align flex-wrap">
                                        <li
                                            class="countdown-list__item py-8 px-12 flex-align gap-4 text-sm fw-medium box-shadow-4xl rounded-5 bg-main-600 text-white">
                                            <span class="days"></span> D
                                        </li>
                                        <li
                                            class="countdown-list__item py-8 px-12 flex-align gap-4 text-sm fw-medium box-shadow-4xl rounded-5 bg-main-600 text-white">
                                            <span class="hours"></span> H
                                        </li>
                                        <li
                                            class="countdown-list__item py-8 px-12 flex-align gap-4 text-sm fw-medium box-shadow-4xl rounded-5 bg-main-600 text-white">
                                            <span class="minutes"></span> M
                                        </li>
                                        <li
                                            class="countdown-list__item py-8 px-12 flex-align gap-4 text-sm fw-medium box-shadow-4xl rounded-5 bg-main-600 text-white">
                                            <span class="seconds"></span> S
                                        </li>
                                    </ul>
                                </div>
                                <a href="shop.php"
                                    class="btn bg-success-600 hover-bg-success-700 d-inline-flex align-items-center rounded-pill gap-8 mt-24">
                                    Shop Now
                                    <span class="icon text-xl d-flex"><i class="ph ph-arrow-right"></i></span>
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>
    <!-- ========================= flash sales End ================================ -->

    <!-- ========================= Recommended Start ================================ -->
    <section class="recommended overflow-hidden pt-80">
        <div class="container container-lg">
            <div class="section-heading flex-between flex-wrap gap-16">
                <h5 class="mb-0 wow fadeInLeft">Recommended for you</h5>
            </div>

            <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade show active" id="pills-all" role="tabpanel" aria-labelledby="pills-all-tab"
                    tabindex="0">
                    <div class="row g-12 ">
                        <?php $counter = 0;
                        foreach ($resultProduct['data']['data'] as $key => $product):
                            if ($counter >= 12) {
                                break;
                            }
                            $counter++;
                            // Find the primary image
                            $primaryImage = null;
                            foreach ($product['images'] as $image) {
                                if ($image['isPrimary']) {
                                    $primaryImage = $image['imageUrl'];
                                    break;
                                }
                            }
                            // Fallback to a placeholder image if no primary image is found
                            $primaryImage = $primaryImage ?: 'assets/images/thumbs/product-img28.png';

                            // Calculate discounted price
                            $originalPrice = floatval($product['price']);
                            $discountPercentage = floatval($product['discountValue']);
                            $discountedPrice = $originalPrice * (1 - $discountPercentage / 100);

                            // Calculate stock and sold percentage
                            $remainingStock = intval($product['stock']);
                            $sold = 18; // Assuming 18 sold as per static HTML
                            $totalStock = $remainingStock + $sold; // Total stock = remaining + sold
                            $soldPercentage = ($totalStock > 0) ? ($sold / $totalStock) * 100 : 0;


                            // Calculate rating: Use average of review ratings if available, else use popularity
                            $rating = 0;
                            $reviewCount = 0;

                            if (!empty($product['reviews'])) {
                                $totalRating = 0;
                                $validReviews = 0;

                                foreach ($product['reviews'] as $review) {
                                    // Safely extract rating value
                                    if (isset($review['rating'])) {
                                        if (is_array($review['rating'])) {
                                            // If rating is an array, try to get numeric value
                                            $ratingValue = isset($review['rating']['value']) ? floatval($review['rating']['value']) : 0;
                                        } else {
                                            // If rating is direct value
                                            $ratingValue = floatval($review['rating']);
                                        }

                                        if ($ratingValue > 0) {
                                            $totalRating += $ratingValue;
                                            $validReviews++;
                                        }
                                    }
                                }

                                if ($validReviews > 0) {
                                    $rating = $totalRating / $validReviews;
                                    $reviewCount = $validReviews;
                                }
                            }

                            // Fallback to popularity if no valid reviews
                            if ($rating === 0) {
                                $rating = ($product['popularity'] ?? 0) / 2;
                                $reviewCount = 0; // No actual reviews, just using popularity
                            }

                            // Format rating to 1 decimal place
                            $formattedRating = number_format($rating, 1);
                            ?>
                            <div class="col-xxl-2 col-lg-3 col-sm-4 col-6" data-aos="fade-up"
                                data-aos-duration="<?= 200 + $key * 200 ?>">
                                <div
                                    class="product-card h-100 p-12 border border-gray-100 hover-border-main-600 rounded-16 position-relative transition-2 group-item">
                                   
                                    <a href="<?= getenv("BASE_URL") . "/product/" . $utils->makeSlug($product['name']) ?>"
                                        class="product-card__thumb flex-center overflow-hidden">
                                        <img src="<?= htmlspecialchars($primaryImage) ?>" alt="">
                                    </a>
                                    <div class="product-card__content p-sm-2 w-100">
                                        <h6 class="title text-lg fw-semibold my-12">
                                            <a href="<?= getenv("BASE_URL") . "/product/" . $utils->makeSlug($product['name']) ?>"
                                                class="link text-line-2"><?= htmlspecialchars($product['name']) ?></a>
                                        </h6>
                                        <div class="flex-align gap-4">
                                            <span class="text-main-600 text-md d-flex"><i
                                                    class="ph-fill ph-storefront"></i></span>
                                            <span class="text-gray-500 text-xs">By Lucky Supermarket</span>
                                        </div>

                                        <div class="product-card__content mt-12">
                                            <div class="product-card__price mb-8">
                                                <span
                                                    class="text-heading text-md fw-semibold ">₹<?= number_format($discountedPrice, 2) ?>
                                                    <span class="text-gray-500 fw-normal">/Qty</span> </span>
                                                <span
                                                    class="text-gray-400 text-md fw-semibold text-decoration-line-through">
                                                    ₹<?= number_format($originalPrice, 2) ?></span>
                                            </div>
                                            <div class="flex-align mb-20 mt-16 gap-6">
                                                <?php if ($reviewCount > 0): ?>
                                                    <span class="text-xs fw-medium text-gray-500">
                                                        <?= $formattedRating ?>
                                                    </span>
                                                    <span class="text-xs fw-medium text-warning-600 d-flex">
                                                        <i class="ph-fill ph-star"></i>
                                                    </span>
                                                    <span class="text-xs fw-medium text-gray-500">
                                                        (<?= $reviewCount ?>)
                                                    </span>
                                                <?php else: ?>
                                                    <span class="text-xs fw-medium text-gray-500">
                                                        No reviews yet
                                                    </span>
                                                <?php endif; ?>
                                            </div>
                                            <a href="javascript:void(0);"
                                                data-product-id="<?= htmlspecialchars($product['id']) ?>"
                                                class="product-card__cart btn bg-main-50 text-main-600 hover-bg-main-600 hover-text-white py-11 px-24 rounded-pill flex-align gap-8 mt-24 w-100 justify-content-center add-to-cart">
                                                Add To Cart <i class="ph ph-shopping-cart"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>

                        <?php if (empty($resultProduct['data']['data'])): ?>
                            <div class="col-xxl-2 col-lg-3 col-sm-4 col-6" data-aos="fade-up" data-aos-duration="200">
                                <div
                                    class="product-card h-100 p-12 border border-gray-100 hover-border-main-600 rounded-16 position-relative transition-2 group-item">
                                    <button type="button" class="wishlist-btn-two">
                                        <i class="ph-bold ph-heart"></i>
                                    </button>
                                    <a href="product-details.php" class="product-card__thumb flex-center overflow-hidden">
                                        <img src="assets/images/product/trackpant/light_grey/1 (1).jpg" alt="">
                                    </a>
                                    <div class="product-card__content p-sm-2 w-100">
                                        <h6 class="title text-lg fw-semibold my-12">
                                            <a href="product-details.php" class="link text-line-2">C-500 Antioxidant Protect
                                                Dietary Supplement</a>
                                        </h6>
                                        <div class="flex-align gap-4">
                                            <span class="text-main-600 text-md d-flex"><i
                                                    class="ph-fill ph-storefront"></i></span>
                                            <span class="text-gray-500 text-xs">By Lucky Supermarket</span>
                                        </div>

                                        <div class="product-card__content mt-12">
                                            <div class="product-card__price mb-8">
                                                <span class="text-heading text-md fw-semibold ">$14.99 <span
                                                        class="text-gray-500 fw-normal">/Qty</span> </span>
                                                <span
                                                    class="text-gray-400 text-md fw-semibold text-decoration-line-through">
                                                    $28.99</span>
                                            </div>
                                            <div class="flex-align gap-6">
                                                <span class="text-xs fw-bold text-gray-600">4.8</span>
                                                <span class="text-15 fw-bold text-warning-600 d-flex"><i
                                                        class="ph-fill ph-star"></i></span>
                                                <span class="text-xs fw-bold text-gray-600">(17k)</span>
                                            </div>
                                            <a href="cart.php"
                                                class="product-card__cart btn bg-main-50 text-main-600 hover-bg-main-600 hover-text-white py-11 px-24 rounded-pill flex-align gap-8 mt-24 w-100 justify-content-center">
                                                Add To Cart <i class="ph ph-shopping-cart"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xxl-2 col-lg-3 col-sm-4 col-6" data-aos="fade-up" data-aos-duration="400">
                                <div
                                    class="product-card h-100 p-12 border border-gray-100 hover-border-main-600 rounded-16 position-relative transition-2 group-item">
                                    <button type="button" class="wishlist-btn-two">
                                        <i class="ph-bold ph-heart"></i>
                                    </button>
                                    <span class="product-card__badge bg-danger-600 px-8 py-4 text-sm text-white">Sale 50%
                                    </span>
                                    <a href="product-details.php" class="product-card__thumb flex-center overflow-hidden">
                                        <img src="assets/images/product/trackpant/light_grey/1 (2).jpg" alt="">
                                    </a>
                                    <div class="product-card__content p-sm-2 w-100">
                                        <h6 class="title text-lg fw-semibold my-12">
                                            <a href="product-details.php" class="link text-line-2">Marcel's Modern Pantry
                                                Almond Unsweetened</a>
                                        </h6>
                                        <div class="flex-align gap-4">
                                            <span class="text-main-600 text-md d-flex"><i
                                                    class="ph-fill ph-storefront"></i></span>
                                            <span class="text-gray-500 text-xs">By Lucky Supermarket</span>
                                        </div>

                                        <div class="product-card__content mt-12">
                                            <div class="product-card__price mb-8">
                                                <span class="text-heading text-md fw-semibold ">$14.99 <span
                                                        class="text-gray-500 fw-normal">/Qty</span> </span>
                                                <span
                                                    class="text-gray-400 text-md fw-semibold text-decoration-line-through">
                                                    $28.99</span>
                                            </div>
                                            <div class="flex-align gap-6">
                                                <span class="text-xs fw-bold text-gray-600">4.8</span>
                                                <span class="text-15 fw-bold text-warning-600 d-flex"><i
                                                        class="ph-fill ph-star"></i></span>
                                                <span class="text-xs fw-bold text-gray-600">(17k)</span>
                                            </div>
                                            <a href="cart.php"
                                                class="product-card__cart btn bg-main-50 text-main-600 hover-bg-main-600 hover-text-white py-11 px-24 rounded-pill flex-align gap-8 mt-24 w-100 justify-content-center">
                                                Add To Cart <i class="ph ph-shopping-cart"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xxl-2 col-lg-3 col-sm-4 col-6" data-aos="fade-up" data-aos-duration="600">
                                <div
                                    class="product-card h-100 p-12 border border-gray-100 hover-border-main-600 rounded-16 position-relative transition-2 group-item">
                                    <button type="button" class="wishlist-btn-two">
                                        <i class="ph-bold ph-heart"></i>
                                    </button>
                                    <span class="product-card__badge bg-danger-600 px-8 py-4 text-sm text-white">Sale 50%
                                    </span>
                                    <a href="product-details.php" class="product-card__thumb flex-center overflow-hidden">
                                        <img src="assets/images/product/trackpant/light_grey/1 (3).jpg" alt="">
                                    </a>
                                    <div class="product-card__content p-sm-2 w-100">
                                        <h6 class="title text-lg fw-semibold my-12">
                                            <a href="product-details.php" class="link text-line-2">O Organics Milk, Whole,
                                                Vitamin D</a>
                                        </h6>
                                        <div class="flex-align gap-4">
                                            <span class="text-main-600 text-md d-flex"><i
                                                    class="ph-fill ph-storefront"></i></span>
                                            <span class="text-gray-500 text-xs">By Lucky Supermarket</span>
                                        </div>

                                        <div class="product-card__content mt-12">
                                            <div class="product-card__price mb-8">
                                                <span class="text-heading text-md fw-semibold ">$14.99 <span
                                                        class="text-gray-500 fw-normal">/Qty</span> </span>
                                                <span
                                                    class="text-gray-400 text-md fw-semibold text-decoration-line-through">
                                                    $28.99</span>
                                            </div>
                                            <div class="flex-align gap-6">
                                                <span class="text-xs fw-bold text-gray-600">4.8</span>
                                                <span class="text-15 fw-bold text-warning-600 d-flex"><i
                                                        class="ph-fill ph-star"></i></span>
                                                <span class="text-xs fw-bold text-gray-600">(17k)</span>
                                            </div>
                                            <a href="cart.php"
                                                class="product-card__cart btn bg-main-50 text-main-600 hover-bg-main-600 hover-text-white py-11 px-24 rounded-pill flex-align gap-8 mt-24 w-100 justify-content-center">
                                                Add To Cart <i class="ph ph-shopping-cart"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xxl-2 col-lg-3 col-sm-4 col-6" data-aos="fade-up" data-aos-duration="800">
                                <div
                                    class="product-card h-100 p-12 border border-gray-100 hover-border-main-600 rounded-16 position-relative transition-2 group-item">
                                    <button type="button" class="wishlist-btn-two">
                                        <i class="ph-bold ph-heart"></i>
                                    </button>
                                    <span class="product-card__badge bg-info-600 px-8 py-4 text-sm text-white">Best Sale
                                    </span>
                                    <a href="product-details.php" class="product-card__thumb flex-center overflow-hidden">
                                        <img src="assets/images/product/trackpant/navy/1 (3).jpg" alt="">
                                    </a>
                                    <div class="product-card__content p-sm-2 w-100">
                                        <h6 class="title text-lg fw-semibold my-12">
                                            <a href="product-details.php" class="link text-line-2">Whole Grains and Seeds
                                                Organic Bread</a>
                                        </h6>
                                        <div class="flex-align gap-4">
                                            <span class="text-main-600 text-md d-flex"><i
                                                    class="ph-fill ph-storefront"></i></span>
                                            <span class="text-gray-500 text-xs">By Lucky Supermarket</span>
                                        </div>

                                        <div class="product-card__content mt-12">
                                            <div class="product-card__price mb-8">
                                                <span class="text-heading text-md fw-semibold ">$14.99 <span
                                                        class="text-gray-500 fw-normal">/Qty</span> </span>
                                                <span
                                                    class="text-gray-400 text-md fw-semibold text-decoration-line-through">
                                                    $28.99</span>
                                            </div>
                                            <div class="flex-align gap-6">
                                                <span class="text-xs fw-bold text-gray-600">4.8</span>
                                                <span class="text-15 fw-bold text-warning-600 d-flex"><i
                                                        class="ph-fill ph-star"></i></span>
                                                <span class="text-xs fw-bold text-gray-600">(17k)</span>
                                            </div>
                                            <a href="cart.php"
                                                class="product-card__cart btn bg-main-50 text-main-600 hover-bg-main-600 hover-text-white py-11 px-24 rounded-pill flex-align gap-8 mt-24 w-100 justify-content-center">
                                                Add To Cart <i class="ph ph-shopping-cart"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xxl-2 col-lg-3 col-sm-4 col-6" data-aos="fade-up" data-aos-duration="1000">
                                <div
                                    class="product-card h-100 p-12 border border-gray-100 hover-border-main-600 rounded-16 position-relative transition-2 group-item">
                                    <button type="button" class="wishlist-btn-two">
                                        <i class="ph-bold ph-heart"></i>
                                    </button>
                                    <a href="product-details.php" class="product-card__thumb flex-center overflow-hidden">
                                        <img src="assets/images/product/trackpant/navy/1 (1).jpg" alt="">
                                    </a>
                                    <div class="product-card__content p-sm-2 w-100">
                                        <h6 class="title text-lg fw-semibold my-12">
                                            <a href="product-details.php" class="link text-line-2">Lucerne Yogurt, Lowfat,
                                                Strawberry</a>
                                        </h6>
                                        <div class="flex-align gap-4">
                                            <span class="text-main-600 text-md d-flex"><i
                                                    class="ph-fill ph-storefront"></i></span>
                                            <span class="text-gray-500 text-xs">By Lucky Supermarket</span>
                                        </div>

                                        <div class="product-card__content mt-12">
                                            <div class="product-card__price mb-8">
                                                <span class="text-heading text-md fw-semibold ">$14.99 <span
                                                        class="text-gray-500 fw-normal">/Qty</span> </span>
                                                <span
                                                    class="text-gray-400 text-md fw-semibold text-decoration-line-through">
                                                    $28.99</span>
                                            </div>
                                            <div class="flex-align gap-6">
                                                <span class="text-xs fw-bold text-gray-600">4.8</span>
                                                <span class="text-15 fw-bold text-warning-600 d-flex"><i
                                                        class="ph-fill ph-star"></i></span>
                                                <span class="text-xs fw-bold text-gray-600">(17k)</span>
                                            </div>
                                            <a href="cart.php"
                                                class="product-card__cart btn bg-main-50 text-main-600 hover-bg-main-600 hover-text-white py-11 px-24 rounded-pill flex-align gap-8 mt-24 w-100 justify-content-center">
                                                Add To Cart <i class="ph ph-shopping-cart"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xxl-2 col-lg-3 col-sm-4 col-6" data-aos="fade-up" data-aos-duration="1200">
                                <div
                                    class="product-card h-100 p-12 border border-gray-100 hover-border-main-600 rounded-16 position-relative transition-2 group-item">
                                    <button type="button" class="wishlist-btn-two">
                                        <i class="ph-bold ph-heart"></i>
                                    </button>
                                    <span class="product-card__badge bg-danger-600 px-8 py-4 text-sm text-white">Sale 50%
                                    </span>
                                    <a href="product-details.php" class="product-card__thumb flex-center overflow-hidden">
                                        <img src="assets/images/product/trackpant/navy/1 (7).jpg" alt="">
                                    </a>
                                    <div class="product-card__content p-sm-2 w-100">
                                        <h6 class="title text-lg fw-semibold my-12">
                                            <a href="product-details.php" class="link text-line-2">Nature Valley Whole Grain
                                                Oats and Honey Protein</a>
                                        </h6>
                                        <div class="flex-align gap-4">
                                            <span class="text-main-600 text-md d-flex"><i
                                                    class="ph-fill ph-storefront"></i></span>
                                            <span class="text-gray-500 text-xs">By Lucky Supermarket</span>
                                        </div>

                                        <div class="product-card__content mt-12">
                                            <div class="product-card__price mb-8">
                                                <span class="text-heading text-md fw-semibold ">$14.99 <span
                                                        class="text-gray-500 fw-normal">/Qty</span> </span>
                                                <span
                                                    class="text-gray-400 text-md fw-semibold text-decoration-line-through">
                                                    $28.99</span>
                                            </div>
                                            <div class="flex-align gap-6">
                                                <span class="text-xs fw-bold text-gray-600">4.8</span>
                                                <span class="text-15 fw-bold text-warning-600 d-flex"><i
                                                        class="ph-fill ph-star"></i></span>
                                                <span class="text-xs fw-bold text-gray-600">(17k)</span>
                                            </div>
                                            <a href="cart.php"
                                                class="product-card__cart btn bg-main-50 text-main-600 hover-bg-main-600 hover-text-white py-11 px-24 rounded-pill flex-align gap-8 mt-24 w-100 justify-content-center">
                                                Add To Cart <i class="ph ph-shopping-cart"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xxl-2 col-lg-3 col-sm-4 col-6" data-aos="fade-up" data-aos-duration="200">
                                <div
                                    class="product-card h-100 p-12 border border-gray-100 hover-border-main-600 rounded-16 position-relative transition-2 group-item">
                                    <button type="button" class="wishlist-btn-two">
                                        <i class="ph-bold ph-heart"></i>
                                    </button>
                                    <a href="product-details.php" class="product-card__thumb flex-center overflow-hidden">
                                        <img src="assets/images/product/sports-bra/PS-PULSE-SBRA-DGREY/PS-PULSE-SBRA-DGREY_1.JPG"
                                            alt="">
                                    </a>
                                    <div class="product-card__content p-sm-2 w-100">
                                        <h6 class="title text-lg fw-semibold my-12">
                                            <a href="product-details.php" class="link text-line-2">C-500 Antioxidant Protect
                                                Dietary Supplement</a>
                                        </h6>
                                        <div class="flex-align gap-4">
                                            <span class="text-main-600 text-md d-flex"><i
                                                    class="ph-fill ph-storefront"></i></span>
                                            <span class="text-gray-500 text-xs">By Lucky Supermarket</span>
                                        </div>

                                        <div class="product-card__content mt-12">
                                            <div class="product-card__price mb-8">
                                                <span class="text-heading text-md fw-semibold ">$14.99 <span
                                                        class="text-gray-500 fw-normal">/Qty</span> </span>
                                                <span
                                                    class="text-gray-400 text-md fw-semibold text-decoration-line-through">
                                                    $28.99</span>
                                            </div>
                                            <div class="flex-align gap-6">
                                                <span class="text-xs fw-bold text-gray-600">4.8</span>
                                                <span class="text-15 fw-bold text-warning-600 d-flex"><i
                                                        class="ph-fill ph-star"></i></span>
                                                <span class="text-xs fw-bold text-gray-600">(17k)</span>
                                            </div>
                                            <a href="cart.php"
                                                class="product-card__cart btn bg-main-50 text-main-600 hover-bg-main-600 hover-text-white py-11 px-24 rounded-pill flex-align gap-8 mt-24 w-100 justify-content-center">
                                                Add To Cart <i class="ph ph-shopping-cart"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xxl-2 col-lg-3 col-sm-4 col-6" data-aos="fade-up" data-aos-duration="400">
                                <div
                                    class="product-card h-100 p-12 border border-gray-100 hover-border-main-600 rounded-16 position-relative transition-2 group-item">
                                    <button type="button" class="wishlist-btn-two">
                                        <i class="ph-bold ph-heart"></i>
                                    </button>
                                    <span class="product-card__badge bg-danger-600 px-8 py-4 text-sm text-white">Sale 50%
                                    </span>
                                    <a href="product-details.php" class="product-card__thumb flex-center overflow-hidden">
                                        <img src="assets/images/product/sports-bra/PS-PULSE-SBRA-DGREY/PS-PULSE-SBRA-DGREY_7.JPG"
                                            alt="">
                                    </a>
                                    <div class="product-card__content p-sm-2 w-100">
                                        <h6 class="title text-lg fw-semibold my-12">
                                            <a href="product-details.php" class="link text-line-2">C-500 Antioxidant Protect
                                                Dietary Supplement</a>
                                        </h6>
                                        <div class="flex-align gap-4">
                                            <span class="text-main-600 text-md d-flex"><i
                                                    class="ph-fill ph-storefront"></i></span>
                                            <span class="text-gray-500 text-xs">By Lucky Supermarket</span>
                                        </div>

                                        <div class="product-card__content mt-12">
                                            <div class="product-card__price mb-8">
                                                <span class="text-heading text-md fw-semibold ">$14.99 <span
                                                        class="text-gray-500 fw-normal">/Qty</span> </span>
                                                <span
                                                    class="text-gray-400 text-md fw-semibold text-decoration-line-through">
                                                    $28.99</span>
                                            </div>
                                            <div class="flex-align gap-6">
                                                <span class="text-xs fw-bold text-gray-600">4.8</span>
                                                <span class="text-15 fw-bold text-warning-600 d-flex"><i
                                                        class="ph-fill ph-star"></i></span>
                                                <span class="text-xs fw-bold text-gray-600">(17k)</span>
                                            </div>
                                            <a href="cart.php"
                                                class="product-card__cart btn bg-main-50 text-main-600 hover-bg-main-600 hover-text-white py-11 px-24 rounded-pill flex-align gap-8 mt-24 w-100 justify-content-center">
                                                Add To Cart <i class="ph ph-shopping-cart"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xxl-2 col-lg-3 col-sm-4 col-6" data-aos="fade-up" data-aos-duration="600">
                                <div
                                    class="product-card h-100 p-12 border border-gray-100 hover-border-main-600 rounded-16 position-relative transition-2 group-item">
                                    <button type="button" class="wishlist-btn-two">
                                        <i class="ph-bold ph-heart"></i>
                                    </button>
                                    <span class="product-card__badge bg-warning-600 px-8 py-4 text-sm text-white">New</span>
                                    <a href="product-details.php" class="product-card__thumb flex-center overflow-hidden">
                                        <img src="assets/images/product/sports-bra/PS-PULSE-SBRA-DGREY/PS-PULSE-SBRA-DGREY_5.JPG"
                                            alt="">
                                    </a>
                                    <div class="product-card__content p-sm-2 w-100">
                                        <h6 class="title text-lg fw-semibold my-12">
                                            <a href="product-details.php" class="link text-line-2">C-500 Antioxidant Protect
                                                Dietary Supplement</a>
                                        </h6>
                                        <div class="flex-align gap-4">
                                            <span class="text-main-600 text-md d-flex"><i
                                                    class="ph-fill ph-storefront"></i></span>
                                            <span class="text-gray-500 text-xs">By Lucky Supermarket</span>
                                        </div>

                                        <div class="product-card__content mt-12">
                                            <div class="product-card__price mb-8">
                                                <span class="text-heading text-md fw-semibold ">$14.99 <span
                                                        class="text-gray-500 fw-normal">/Qty</span> </span>
                                                <span
                                                    class="text-gray-400 text-md fw-semibold text-decoration-line-through">
                                                    $28.99</span>
                                            </div>
                                            <div class="flex-align gap-6">
                                                <span class="text-xs fw-bold text-gray-600">4.8</span>
                                                <span class="text-15 fw-bold text-warning-600 d-flex"><i
                                                        class="ph-fill ph-star"></i></span>
                                                <span class="text-xs fw-bold text-gray-600">(17k)</span>
                                            </div>
                                            <a href="cart.php"
                                                class="product-card__cart btn bg-main-50 text-main-600 hover-bg-main-600 hover-text-white py-11 px-24 rounded-pill flex-align gap-8 mt-24 w-100 justify-content-center">
                                                Add To Cart <i class="ph ph-shopping-cart"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xxl-2 col-lg-3 col-sm-4 col-6" data-aos="fade-up" data-aos-duration="800">
                                <div
                                    class="product-card h-100 p-12 border border-gray-100 hover-border-main-600 rounded-16 position-relative transition-2 group-item">
                                    <button type="button" class="wishlist-btn-two">
                                        <i class="ph-bold ph-heart"></i>
                                    </button>
                                    <span class="product-card__badge bg-danger-600 px-8 py-4 text-sm text-white">Sale 50%
                                    </span>
                                    <a href="product-details.php" class="product-card__thumb flex-center overflow-hidden">
                                        <img src="assets/images/product/sports-bra/PS-PULSE-SBRA-MAGENTA/PS-PULSE-SBRA-MAGENTA_1.JPG"
                                            alt="">
                                    </a>
                                    <div class="product-card__content p-sm-2 w-100">
                                        <h6 class="title text-lg fw-semibold my-12">
                                            <a href="product-details.php" class="link text-line-2">Good & Gather Farmed
                                                Atlantic Salmon</a>
                                        </h6>
                                        <div class="flex-align gap-4">
                                            <span class="text-main-600 text-md d-flex"><i
                                                    class="ph-fill ph-storefront"></i></span>
                                            <span class="text-gray-500 text-xs">By Lucky Supermarket</span>
                                        </div>

                                        <div class="product-card__content mt-12">
                                            <div class="product-card__price mb-8">
                                                <span class="text-heading text-md fw-semibold ">$14.99 <span
                                                        class="text-gray-500 fw-normal">/Qty</span> </span>
                                                <span
                                                    class="text-gray-400 text-md fw-semibold text-decoration-line-through">
                                                    $28.99</span>
                                            </div>
                                            <div class="flex-align gap-6">
                                                <span class="text-xs fw-bold text-gray-600">4.8</span>
                                                <span class="text-15 fw-bold text-warning-600 d-flex"><i
                                                        class="ph-fill ph-star"></i></span>
                                                <span class="text-xs fw-bold text-gray-600">(17k)</span>
                                            </div>
                                            <a href="cart.php"
                                                class="product-card__cart btn bg-main-50 text-main-600 hover-bg-main-600 hover-text-white py-11 px-24 rounded-pill flex-align gap-8 mt-24 w-100 justify-content-center">
                                                Add To Cart <i class="ph ph-shopping-cart"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xxl-2 col-lg-3 col-sm-4 col-6" data-aos="fade-up" data-aos-duration="1000">
                                <div
                                    class="product-card h-100 p-12 border border-gray-100 hover-border-main-600 rounded-16 position-relative transition-2 group-item">
                                    <button type="button" class="wishlist-btn-two">
                                        <i class="ph-bold ph-heart"></i>
                                    </button>
                                    <span class="product-card__badge bg-danger-600 px-8 py-4 text-sm text-white">Sale 50%
                                    </span>
                                    <a href="product-details.php" class="product-card__thumb flex-center overflow-hidden">
                                        <img src="assets/images/product/sports-bra/PS-PULSE-SBRA-MAGENTA/PS-PULSE-SBRA-MAGENTA_7.JPG"
                                            alt="">
                                    </a>
                                    <div class="product-card__content p-sm-2 w-100">
                                        <h6 class="title text-lg fw-semibold my-12">
                                            <a href="product-details.php" class="link text-line-2">Market Pantry 41/50 Raw
                                                Tail-Off Large Raw Shrimp</a>
                                        </h6>
                                        <div class="flex-align gap-4">
                                            <span class="text-main-600 text-md d-flex"><i
                                                    class="ph-fill ph-storefront"></i></span>
                                            <span class="text-gray-500 text-xs">By Lucky Supermarket</span>
                                        </div>

                                        <div class="product-card__content mt-12">
                                            <div class="product-card__price mb-8">
                                                <span class="text-heading text-md fw-semibold ">$14.99 <span
                                                        class="text-gray-500 fw-normal">/Qty</span> </span>
                                                <span
                                                    class="text-gray-400 text-md fw-semibold text-decoration-line-through">
                                                    $28.99</span>
                                            </div>
                                            <div class="flex-align gap-6">
                                                <span class="text-xs fw-bold text-gray-600">4.8</span>
                                                <span class="text-15 fw-bold text-warning-600 d-flex"><i
                                                        class="ph-fill ph-star"></i></span>
                                                <span class="text-xs fw-bold text-gray-600">(17k)</span>
                                            </div>
                                            <a href="cart.php"
                                                class="product-card__cart btn bg-main-50 text-main-600 hover-bg-main-600 hover-text-white py-11 px-24 rounded-pill flex-align gap-8 mt-24 w-100 justify-content-center">
                                                Add To Cart <i class="ph ph-shopping-cart"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xxl-2 col-lg-3 col-sm-4 col-6" data-aos="fade-up" data-aos-duration="1200">
                                <div
                                    class="product-card h-100 p-12 border border-gray-100 hover-border-main-600 rounded-16 position-relative transition-2 group-item">
                                    <button type="button" class="wishlist-btn-two">
                                        <i class="ph-bold ph-heart"></i>
                                    </button>
                                    <span class="product-card__badge bg-warning-600 px-8 py-4 text-sm text-white">New</span>
                                    <a href="product-details.php" class="product-card__thumb flex-center overflow-hidden">
                                        <img src="assets/images/product/sports-bra/PS-PULSE-SBRA-PINK/PS-PULSE-SBRA-PINK_2.JPG"
                                            alt="">
                                    </a>
                                    <div class="product-card__content p-sm-2 w-100">
                                        <h6 class="title text-lg fw-semibold my-12">
                                            <a href="product-details.php" class="link text-line-2">Tropicana 100% Juice,
                                                Orange, No Pulp</a>
                                        </h6>
                                        <div class="flex-align gap-4">
                                            <span class="text-main-600 text-md d-flex"><i
                                                    class="ph-fill ph-storefront"></i></span>
                                            <span class="text-gray-500 text-xs">By Lucky Supermarket</span>
                                        </div>

                                        <div class="product-card__content mt-12">
                                            <div class="product-card__price mb-8">
                                                <span class="text-heading text-md fw-semibold ">$14.99 <span
                                                        class="text-gray-500 fw-normal">/Qty</span> </span>
                                                <span
                                                    class="text-gray-400 text-md fw-semibold text-decoration-line-through">
                                                    $28.99</span>
                                            </div>
                                            <div class="flex-align gap-6">
                                                <span class="text-xs fw-bold text-gray-600">4.8</span>
                                                <span class="text-15 fw-bold text-warning-600 d-flex"><i
                                                        class="ph-fill ph-star"></i></span>
                                                <span class="text-xs fw-bold text-gray-600">(17k)</span>
                                            </div>
                                            <a href="cart.php"
                                                class="product-card__cart btn bg-main-50 text-main-600 hover-bg-main-600 hover-text-white py-11 px-24 rounded-pill flex-align gap-8 mt-24 w-100 justify-content-center">
                                                Add To Cart <i class="ph ph-shopping-cart"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>

                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ========================= Recommended End ================================ -->


    <!-- =========================== Offer Section Start =============================== -->
    <section class="offer pt-80">
        <div class="container container-lg">
            <div class="row gy-4">
                <?php
                $initialDuration = 600;
                $increment = 200;
                foreach ($productsImages as $key => $image):
                    $duration = $initialDuration + ($key * $increment);
                    ?>
                    <div class="col-sm-6" data-aos="zoom-in" data-aos-duration="<?= $duration ?>">
                        <div class="offer-card position-relative rounded-16 overflow-hidden p-16 ps-56-px">
                            <img src="<?= htmlspecialchars($image['image']) ?>" alt=""
                                class="position-absolute inset-block-start-0 inset-inline-start-0 z-n1 w-100 h-100">
                            <div class="py-xl-4 max-w-392 ms-auto">
                                <div class="offer-card__logo mb-16 w-80 h-80 flex-center bg-white rounded-circle">
                                    <img src="assets/images/thumbs/offer-logo.png" alt="">
                                </div>
                                <h5 class="mb-8"><?= htmlspecialchars($image['title']) ?></h5>
                                <div class="flex-align gap-8">
                                    <span class="text-sm fw-medium text-heading">Delivery by 6:15am</span>
                                    <span class="text-xs text-heading">Expire Aug 5</span>
                                </div>
                                <a href="shop.php"
                                    class="mt-16 btn bg-success-600 hover-text-white hover-bg-success-700 text-white fw-medium d-inline-flex align-items-center rounded-pill gap-8"
                                    tabindex="0">
                                    Shop Now
                                    <span class="icon text-xl d-flex"><i class="ph ph-arrow-right"></i></span>
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>


                <?php if (empty($productsImages)): ?>
                    <div class="col-sm-6" data-aos="zoom-in" data-aos-duration="600">
                        <div class="offer-card position-relative rounded-16 overflow-hidden p-16 ps-56-px">
                            <img src="assets/images/bg/offer-bg-img1.png" alt=""
                                class="position-absolute inset-block-start-0 inset-inline-start-0 z-n1 w-100 h-100">
                            <div class="py-xl-4 max-w-392 ms-auto">
                                <div class="offer-card__logo mb-16 w-80 h-80 flex-center bg-white rounded-circle">
                                    <img src="assets/images/thumbs/offer-logo.png" alt="">
                                </div>
                                <h5 class="mb-8">$5 off your first order</h5>
                                <div class="flex-align gap-8">
                                    <span class="text-sm fw-medium text-heading">Delivery by 6:15am</span>
                                    <span class="text-xs text-heading">Expire Aug 5</span>
                                </div>
                                <a href="shop.php"
                                    class="mt-16 btn bg-success-600 hover-text-white hover-bg-success-700 text-white fw-medium d-inline-flex align-items-center rounded-pill gap-8"
                                    tabindex="0">
                                    Shop Now
                                    <span class="icon text-xl d-flex"><i class="ph ph-arrow-right"></i></span>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6" data-aos="zoom-in" data-aos-duration="800">
                        <div class="offer-card position-relative rounded-16 overflow-hidden p-16 ps-56-px">
                            <img src="assets/images/bg/offer-bg-img2.png" alt=""
                                class="position-absolute inset-block-start-0 inset-inline-start-0 z-n1 w-100 h-100">
                            <div class="py-xl-4 max-w-392">
                                <div class="offer-card__logo mb-16 w-80 h-80 flex-center bg-white rounded-circle">
                                    <img src="assets/images/thumbs/offer-logo.png" alt="">
                                </div>
                                <h5 class="mb-8">$5 off your first order</h5>
                                <div class="flex-align gap-8">
                                    <span class="text-sm fw-medium text-heading">Delivery by 6:15am</span>
                                    <span class="text-sm text-success-600">Expire Aug 5</span>
                                </div>
                                <a href="shop.php"
                                    class="mt-16 btn bg-white hover-text-white hover-bg-main-800 text-heading fw-medium d-inline-flex align-items-center rounded-pill gap-8"
                                    tabindex="0">
                                    Shop Now
                                    <span class="icon text-xl d-flex"><i class="ph ph-arrow-right"></i></span>
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>
    <!-- =========================== Offer Section End =============================== -->

    <!-- ========================= hot-deals Start ================================ -->
    <section class="hot-deals pt-80 overflow-hidden">
        <div class="container container-lg">
            <div class="section-heading">
                <div class="flex-between flex-wrap gap-8">
                    <h5 class="mb-0 wow fadeInLeft">Hot Deals Todays</h5>
                    <div class="flex-align gap-16 wow fadeInRight">
                        <a href="<?= getenv("BASE_URL") . "/product" ?>"
                            class="text-sm fw-medium text-gray-700 hover-text-main-600 hover-text-decoration-underline">View
                            All Deals</a>
                        <div class="flex-align gap-8">
                            <button type="button" id="deals-prev"
                                class="slick-prev slick-arrow flex-center rounded-circle border border-gray-100 hover-border-main-600 text-xl hover-bg-main-600 hover-text-white transition-1">
                                <i class="ph ph-caret-left"></i>
                            </button>
                            <button type="button" id="deals-next"
                                class="slick-next slick-arrow flex-center rounded-circle border border-gray-100 hover-border-main-600 text-xl hover-bg-main-600 hover-text-white transition-1">
                                <i class="ph ph-caret-right"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row g-12">
                <div class="col-md-4" data-aos="zoom-in">
                    <div
                        class="hot-deals position-relative rounded-16 bg-main-600 overflow-hidden ps-40 pe-24 pt-80 pb-120 z-1">
                        <img src="assets/images/shape/offer-shape.png" alt=""
                            class="position-absolute inset-block-start-0 inset-inline-start-0 z-n1 w-100 h-100 opacity-6">

                        <img src="assets/images/product/sports-bra/PS-PULSE-SBRA-SKIN/PS-PULSE-SBRA-SKIN_1.JPG"
                            alt="Basket Thumb" class="position-absolute inset-inline-end-0 inset-block-end-0">

                        <span
                            class="text-primary-600 bg-yellow text-heading py-4 px-12 rounded-4 text-sm fw-medium">Medical
                            equipment</span>
                        <div class="">
                            <h5 class="text-white mb-8 mt-12">Deals of the day</h5>
                            <p class="fw-semibold text-success-600">Save up to 50% off on your first order</p>
                            <div class="countdown mt-24 mb-24" id="countdown4">
                                <ul class="countdown-list d-flex align-items-center flex-wrap">
                                    <li
                                        class="countdown-list__item py-8 px-12 text-heading flex-align gap-4 text-sm fw-medium colon-white">
                                        <span class="days"></span> D
                                    </li>
                                    <li
                                        class="countdown-list__item py-8 px-12 text-heading flex-align gap-4 text-sm fw-medium colon-white">
                                        <span class="hours"></span> H
                                    </li>
                                    <li
                                        class="countdown-list__item py-8 px-12 text-heading flex-align gap-4 text-sm fw-medium colon-white">
                                        <span class="minutes"></span> M
                                    </li>
                                    <li
                                        class="countdown-list__item py-8 px-12 text-heading flex-align gap-4 text-sm fw-medium colon-white">
                                        <span class="seconds"></span> S
                                    </li>
                                </ul>
                            </div>
                            <a href="<?= getenv("BASE_URL") . "/product" ?>"
                                class="mt-16 btn bg-white hover-text-white hover-bg-main-800 text-main-600 fw-medium d-inline-flex align-items-center rounded-pill gap-8"
                                tabindex="0">
                                Explore Shop
                                <span class="icon text-xl d-flex"><i class="ph-bold ph-shopping-cart"></i></span>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-md-8">
                    <div class="hot-deals-slider arrow-style-two">

                        <?php
                        $counter = 0;
                        foreach ($resultProduct['data']['data'] as $key => $product):
                            if ($counter >= 10) {
                                break;
                            }
                            $counter++;

                            // Find the primary image
                            $primaryImage = null;
                            foreach ($product['images'] as $image) {
                                if ($image['isPrimary']) {
                                    $primaryImage = $image['imageUrl'];
                                    break;
                                }
                            }
                            // Fallback to a placeholder image if no primary image is found
                            $primaryImage = $primaryImage ?: 'assets/images/thumbs/product-img28.png';

                            // Calculate discounted price
                            $originalPrice = floatval($product['price']);
                            $discountPercentage = floatval($product['discountValue']);
                            $discountedPrice = $originalPrice * (1 - $discountPercentage / 100);

                            // Calculate stock and sold percentage
                            $remainingStock = intval($product['stock']);
                            $sold = 18; // Assuming 18 sold as per static HTML
                            $totalStock = $remainingStock + $sold; // Total stock = remaining + sold
                            $soldPercentage = ($totalStock > 0) ? ($sold / $totalStock) * 100 : 0;


                            // Calculate rating: Use average of review ratings if available, else use popularity
                            $rating = 0;
                            $reviewCount = 0;

                            if (!empty($product['reviews'])) {
                                $totalRating = 0;
                                $validReviews = 0;

                                foreach ($product['reviews'] as $review) {
                                    // Safely extract rating value
                                    if (isset($review['rating'])) {
                                        if (is_array($review['rating'])) {
                                            // If rating is an array, try to get numeric value
                                            $ratingValue = isset($review['rating']['value']) ? floatval($review['rating']['value']) : 0;
                                        } else {
                                            // If rating is direct value
                                            $ratingValue = floatval($review['rating']);
                                        }

                                        if ($ratingValue > 0) {
                                            $totalRating += $ratingValue;
                                            $validReviews++;
                                        }
                                    }
                                }

                                if ($validReviews > 0) {
                                    $rating = $totalRating / $validReviews;
                                    $reviewCount = $validReviews;
                                }
                            }

                            // Fallback to popularity if no valid reviews
                            if ($rating === 0) {
                                $rating = ($product['popularity'] ?? 0) / 2;
                                $reviewCount = 0; // No actual reviews, just using popularity
                            }

                            // Format rating to 1 decimal place
                            $formattedRating = number_format($rating, 1);
                            ?>
                            <div class="" data-aos="fade-up" data-aos-duration="200">
                                <div
                                    class="product-card px-20 pt-16 pb-40 border border-gray-100 hover-border-main-600 rounded-16 position-relative transition-2">
                                    <a href="javascript:void(0);" data-product-id="<?= htmlspecialchars($product['id']) ?>"
                                        class="product-card__cart btn bg-main-50 text-main-600 hover-bg-main-600 hover-text-white py-11 px-24 rounded-pill flex-align gap-8 position-absolute inset-block-start-0 inset-inline-end-0 me-16 mt-16 add-to-cart">
                                        Add <i class="ph ph-shopping-cart"></i>
                                    </a>

                                    <a href="<?= getenv("BASE_URL") . "/product/" . $utils->makeSlug($product['name']) ?>"
                                        class="product-card__thumb flex-center overflow-hidden">
                                        <img src="<?= $primaryImage ?>" alt="">
                                    </a>
                                    <div class="product-card__content mt-12">
                                        <div class="product-card__price mb-8 d-flex align-items-center gap-8">
                                            <span
                                                class="text-heading text-md fw-semibold ">₹<?= number_format($discountedPrice, 2) ?>
                                                <span class="text-gray-500 fw-normal">/Qty</span> </span>
                                            <span class="text-gray-400 text-md fw-semibold text-decoration-line-through">
                                                ₹<?= number_format($originalPrice, 2) ?></span>
                                        </div>
                                        <div class="flex-align mb-20 mt-16 gap-6">
                                            <?php if ($reviewCount > 0): ?>
                                                <span class="text-xs fw-medium text-gray-500">
                                                    <?= $formattedRating ?>
                                                </span>
                                                <span class="text-xs fw-medium text-warning-600 d-flex">
                                                    <i class="ph-fill ph-star"></i>
                                                </span>
                                                <span class="text-xs fw-medium text-gray-500">
                                                    (<?= $reviewCount ?>)
                                                </span>
                                            <?php else: ?>
                                                <span class="text-xs fw-medium text-gray-500">
                                                    No reviews yet
                                                </span>
                                            <?php endif; ?>
                                        </div>
                                        <h6 class="title text-lg fw-semibold mt-12 mb-20">
                                            <a href="<?= getenv("BASE_URL") . "/product/" . $utils->makeSlug($product['name']) ?>"
                                                class="link text-line-2"><?= htmlspecialchars($product['name']) ?></a>
                                        </h6>
                                        <div class="mt-12">
                                            <div class="progress w-100  bg-color-three rounded-pill h-4" role="progressbar"
                                                aria-label="Basic example" aria-valuenow="35" aria-valuemin="0"
                                                aria-valuemax="100">
                                                <div class="progress-bar bg-main-600 rounded-pill" style="width: 35%"></div>
                                            </div>
                                            <span class="text-gray-900 text-xs fw-medium mt-8">Sold: 18/35</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>

                        <?php if (empty($resultProduct['data']['data'])): ?>
                            <div class="" data-aos="fade-up" data-aos-duration="200">
                                <div
                                    class="product-card px-20 pt-16 pb-40 border border-gray-100 hover-border-main-600 rounded-16 position-relative transition-2">
                                    <a href="cart.php"
                                        class="product-card__cart btn bg-main-50 text-main-600 hover-bg-main-600 hover-text-white py-11 px-24 rounded-pill flex-align gap-8 position-absolute inset-block-start-0 inset-inline-end-0 me-16 mt-16">
                                        Add <i class="ph ph-shopping-cart"></i>
                                    </a>

                                    <a href="product-details.php" class="product-card__thumb flex-center overflow-hidden">
                                        <img src="assets/images/product/sports-bra/PS-PULSE-SBRA-PINK/PS-PULSE-SBRA-PINK_2.JPG"
                                            alt="">
                                    </a>
                                    <div class="product-card__content mt-12">
                                        <div class="product-card__price mb-8 d-flex align-items-center gap-8">
                                            <span class="text-heading text-md fw-semibold ">$14.99 <span
                                                    class="text-gray-500 fw-normal">/Qty</span> </span>
                                            <span class="text-gray-400 text-md fw-semibold text-decoration-line-through">
                                                $28.99</span>
                                        </div>
                                        <div class="flex-align gap-6">
                                            <span class="text-xs fw-bold text-gray-600">4.8</span>
                                            <span class="text-15 fw-bold text-warning-600 d-flex"><i
                                                    class="ph-fill ph-star"></i></span>
                                            <span class="text-xs fw-bold text-gray-600">(17k)</span>
                                        </div>
                                        <h6 class="title text-lg fw-semibold mt-12 mb-20">
                                            <a href="product-details.php" class="link text-line-2">Taylor Farms Broccoli
                                                Florets Vegetables</a>
                                        </h6>
                                        <div class="mt-12">
                                            <div class="progress w-100  bg-color-three rounded-pill h-4" role="progressbar"
                                                aria-label="Basic example" aria-valuenow="35" aria-valuemin="0"
                                                aria-valuemax="100">
                                                <div class="progress-bar bg-main-600 rounded-pill" style="width: 35%"></div>
                                            </div>
                                            <span class="text-gray-900 text-xs fw-medium mt-8">Sold: 18/35</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="" data-aos="fade-up" data-aos-duration="400">
                                <div
                                    class="product-card px-20 pt-16 pb-40 border border-gray-100 hover-border-main-600 rounded-16 position-relative transition-2">
                                    <a href="cart.php"
                                        class="product-card__cart btn bg-main-50 text-main-600 hover-bg-main-600 hover-text-white py-11 px-24 rounded-pill flex-align gap-8 position-absolute inset-block-start-0 inset-inline-end-0 me-16 mt-16">
                                        Add <i class="ph ph-shopping-cart"></i>
                                    </a>
                                    <a href="product-details.php" class="product-card__thumb flex-center overflow-hidden">
                                        <img src="assets/images/product/sports-bra/PS-PULSE-SBRA-SKIN/PS-PULSE-SBRA-SKIN_7.JPG"
                                            alt="">
                                    </a>
                                    <div class="product-card__content mt-12">
                                        <div class="product-card__price mb-8 d-flex align-items-center gap-8">
                                            <span class="text-heading text-md fw-semibold ">$14.99 <span
                                                    class="text-gray-500 fw-normal">/Qty</span> </span>
                                            <span class="text-gray-400 text-md fw-semibold text-decoration-line-through">
                                                $28.99</span>
                                        </div>
                                        <div class="flex-align gap-6">
                                            <span class="text-xs fw-bold text-gray-600">4.8</span>
                                            <span class="text-15 fw-bold text-warning-600 d-flex"><i
                                                    class="ph-fill ph-star"></i></span>
                                            <span class="text-xs fw-bold text-gray-600">(17k)</span>
                                        </div>
                                        <h6 class="title text-lg fw-semibold mt-12 mb-20">
                                            <a href="product-details.php" class="link text-line-2">Taylor Farms Broccoli
                                                Florets Vegetables</a>
                                        </h6>
                                        <div class="mt-12">
                                            <div class="progress w-100  bg-color-three rounded-pill h-4" role="progressbar"
                                                aria-label="Basic example" aria-valuenow="35" aria-valuemin="0"
                                                aria-valuemax="100">
                                                <div class="progress-bar bg-main-600 rounded-pill" style="width: 35%"></div>
                                            </div>
                                            <span class="text-gray-900 text-xs fw-medium mt-8">Sold: 18/35</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="" data-aos="fade-up" data-aos-duration="600">
                                <div
                                    class="product-card px-20 pt-16 pb-40 border border-gray-100 hover-border-main-600 rounded-16 position-relative transition-2">
                                    <a href="cart.php"
                                        class="product-card__cart btn bg-main-50 text-main-600 hover-bg-main-600 hover-text-white py-11 px-24 rounded-pill flex-align gap-8 position-absolute inset-block-start-0 inset-inline-end-0 me-16 mt-16">
                                        Add <i class="ph ph-shopping-cart"></i>
                                    </a>
                                    <a href="product-details.php" class="product-card__thumb flex-center overflow-hidden">
                                        <img src="assets/images/product/trackpant/carbon blue/1 (2).jpg" alt="">
                                    </a>
                                    <div class="product-card__content mt-12">
                                        <div class="product-card__price mb-8 d-flex align-items-center gap-8">
                                            <span class="text-heading text-md fw-semibold ">$14.99 <span
                                                    class="text-gray-500 fw-normal">/Qty</span> </span>
                                            <span class="text-gray-400 text-md fw-semibold text-decoration-line-through">
                                                $28.99</span>
                                        </div>
                                        <div class="flex-align gap-6">
                                            <span class="text-xs fw-bold text-gray-600">4.8</span>
                                            <span class="text-15 fw-bold text-warning-600 d-flex"><i
                                                    class="ph-fill ph-star"></i></span>
                                            <span class="text-xs fw-bold text-gray-600">(17k)</span>
                                        </div>
                                        <h6 class="title text-lg fw-semibold mt-12 mb-20">
                                            <a href="product-details.php" class="link text-line-2">Taylor Farms Broccoli
                                                Florets Vegetables</a>
                                        </h6>
                                        <div class="mt-12">
                                            <div class="progress w-100  bg-color-three rounded-pill h-4" role="progressbar"
                                                aria-label="Basic example" aria-valuenow="35" aria-valuemin="0"
                                                aria-valuemax="100">
                                                <div class="progress-bar bg-main-600 rounded-pill" style="width: 35%"></div>
                                            </div>
                                            <span class="text-gray-900 text-xs fw-medium mt-8">Sold: 18/35</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="" data-aos="fade-up" data-aos-duration="800">
                                <div
                                    class="product-card px-20 pt-16 pb-40 border border-gray-100 hover-border-main-600 rounded-16 position-relative transition-2">
                                    <a href="cart.php"
                                        class="product-card__cart btn bg-main-50 text-main-600 hover-bg-main-600 hover-text-white py-11 px-24 rounded-pill flex-align gap-8 position-absolute inset-block-start-0 inset-inline-end-0 me-16 mt-16">
                                        Add <i class="ph ph-shopping-cart"></i>
                                    </a>
                                    <a href="product-details.php" class="product-card__thumb flex-center overflow-hidden">
                                        <img src="assets/images/product/trackpant/carbon blue/1 (2).jpg" alt="">
                                    </a>
                                    <div class="product-card__content mt-12">
                                        <div class="product-card__price mb-8 d-flex align-items-center gap-8">
                                            <span class="text-heading text-md fw-semibold ">$14.99 <span
                                                    class="text-gray-500 fw-normal">/Qty</span> </span>
                                            <span class="text-gray-400 text-md fw-semibold text-decoration-line-through">
                                                $28.99</span>
                                        </div>
                                        <div class="flex-align gap-6">
                                            <span class="text-xs fw-bold text-gray-600">4.8</span>
                                            <span class="text-15 fw-bold text-warning-600 d-flex"><i
                                                    class="ph-fill ph-star"></i></span>
                                            <span class="text-xs fw-bold text-gray-600">(17k)</span>
                                        </div>
                                        <h6 class="title text-lg fw-semibold mt-12 mb-20">
                                            <a href="product-details.php" class="link text-line-2">Taylor Farms Broccoli
                                                Florets Vegetables</a>
                                        </h6>
                                        <div class="mt-12">
                                            <div class="progress w-100  bg-color-three rounded-pill h-4" role="progressbar"
                                                aria-label="Basic example" aria-valuenow="35" aria-valuemin="0"
                                                aria-valuemax="100">
                                                <div class="progress-bar bg-main-600 rounded-pill" style="width: 35%"></div>
                                            </div>
                                            <span class="text-gray-900 text-xs fw-medium mt-8">Sold: 18/35</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="" data-aos="fade-up" data-aos-duration="1000">
                                <div
                                    class="product-card px-20 pt-16 pb-40 border border-gray-100 hover-border-main-600 rounded-16 position-relative transition-2">
                                    <a href="cart.php"
                                        class="product-card__cart btn bg-main-50 text-main-600 hover-bg-main-600 hover-text-white py-11 px-24 rounded-pill flex-align gap-8 position-absolute inset-block-start-0 inset-inline-end-0 me-16 mt-16">
                                        Add <i class="ph ph-shopping-cart"></i>
                                    </a>
                                    <a href="product-details.php" class="product-card__thumb flex-center overflow-hidden">
                                        <img src="assets/images/product/sports-bra/PS-PULSE-SBRA-RED/PS-PULSE-SBRA-RED_2.JPG"
                                            alt="">
                                    </a>
                                    <div class="product-card__content mt-12">
                                        <div class="product-card__price mb-8 d-flex align-items-center gap-8">
                                            <span class="text-heading text-md fw-semibold ">$14.99 <span
                                                    class="text-gray-500 fw-normal">/Qty</span> </span>
                                            <span class="text-gray-400 text-md fw-semibold text-decoration-line-through">
                                                $28.99</span>
                                        </div>
                                        <div class="flex-align gap-6">
                                            <span class="text-xs fw-bold text-gray-600">4.8</span>
                                            <span class="text-15 fw-bold text-warning-600 d-flex"><i
                                                    class="ph-fill ph-star"></i></span>
                                            <span class="text-xs fw-bold text-gray-600">(17k)</span>
                                        </div>
                                        <h6 class="title text-lg fw-semibold mt-12 mb-20">
                                            <a href="product-details.php" class="link text-line-2">Taylor Farms Broccoli
                                                Florets Vegetables</a>
                                        </h6>
                                        <div class="mt-12">
                                            <div class="progress w-100  bg-color-three rounded-pill h-4" role="progressbar"
                                                aria-label="Basic example" aria-valuenow="35" aria-valuemin="0"
                                                aria-valuemax="100">
                                                <div class="progress-bar bg-main-600 rounded-pill" style="width: 35%"></div>
                                            </div>
                                            <span class="text-gray-900 text-xs fw-medium mt-8">Sold: 18/35</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="" data-aos="fade-up" data-aos-duration="1200">
                                <div
                                    class="product-card px-20 pt-16 pb-40 border border-gray-100 hover-border-main-600 rounded-16 position-relative transition-2">
                                    <a href="cart.php"
                                        class="product-card__cart btn bg-main-50 text-main-600 hover-bg-main-600 hover-text-white py-11 px-24 rounded-pill flex-align gap-8 position-absolute inset-block-start-0 inset-inline-end-0 me-16 mt-16">
                                        Add <i class="ph ph-shopping-cart"></i>
                                    </a>
                                    <a href="product-details.php" class="product-card__thumb flex-center overflow-hidden">
                                        <img src="assets/images/product/sports-bra/PS-PULSE-SBRA-DGREY/PS-PULSE-SBRA-DGREY_1.JPG"
                                            alt="">
                                    </a>
                                    <div class="product-card__content mt-12">
                                        <div class="product-card__price mb-8 d-flex align-items-center gap-8">
                                            <span class="text-heading text-md fw-semibold ">$14.99 <span
                                                    class="text-gray-500 fw-normal">/Qty</span> </span>
                                            <span class="text-gray-400 text-md fw-semibold text-decoration-line-through">
                                                $28.99</span>
                                        </div>
                                        <div class="flex-align gap-6">
                                            <span class="text-xs fw-bold text-gray-600">4.8</span>
                                            <span class="text-15 fw-bold text-warning-600 d-flex"><i
                                                    class="ph-fill ph-star"></i></span>
                                            <span class="text-xs fw-bold text-gray-600">(17k)</span>
                                        </div>
                                        <h6 class="title text-lg fw-semibold mt-12 mb-20">
                                            <a href="product-details.php" class="link text-line-2">Taylor Farms Broccoli
                                                Florets Vegetables</a>
                                        </h6>
                                        <div class="mt-12">
                                            <div class="progress w-100  bg-color-three rounded-pill h-4" role="progressbar"
                                                aria-label="Basic example" aria-valuenow="35" aria-valuemin="0"
                                                aria-valuemax="100">
                                                <div class="progress-bar bg-main-600 rounded-pill" style="width: 35%"></div>
                                            </div>
                                            <span class="text-gray-900 text-xs fw-medium mt-8">Sold: 18/35</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="" data-aos="fade-up" data-aos-duration="600">
                                <div
                                    class="product-card px-20 pt-16 pb-40 border border-gray-100 hover-border-main-600 rounded-16 position-relative transition-2">
                                    <a href="cart.php"
                                        class="product-card__cart btn bg-main-50 text-main-600 hover-bg-main-600 hover-text-white py-11 px-24 rounded-pill flex-align gap-8 position-absolute inset-block-start-0 inset-inline-end-0 me-16 mt-16">
                                        Add <i class="ph ph-shopping-cart"></i>
                                    </a>
                                    <a href="product-details.php" class="product-card__thumb flex-center overflow-hidden">
                                        <img src="assets/images/product/sports-bra/PS-PULSE-SBRA-GREEN/PS-PULSE-SBRA-GREEN_1.JPG"
                                            alt="">
                                    </a>
                                    <div class="product-card__content mt-12">
                                        <div class="product-card__price mb-8 d-flex align-items-center gap-8">
                                            <span class="text-heading text-md fw-semibold ">$14.99 <span
                                                    class="text-gray-500 fw-normal">/Qty</span> </span>
                                            <span class="text-gray-400 text-md fw-semibold text-decoration-line-through">
                                                $28.99</span>
                                        </div>
                                        <div class="flex-align gap-6">
                                            <span class="text-xs fw-bold text-gray-600">4.8</span>
                                            <span class="text-15 fw-bold text-warning-600 d-flex"><i
                                                    class="ph-fill ph-star"></i></span>
                                            <span class="text-xs fw-bold text-gray-600">(17k)</span>
                                        </div>
                                        <h6 class="title text-lg fw-semibold mt-12 mb-20">
                                            <a href="product-details.php" class="link text-line-2">Taylor Farms Broccoli
                                                Florets Vegetables</a>
                                        </h6>
                                        <div class="mt-12">
                                            <div class="progress w-100  bg-color-three rounded-pill h-4" role="progressbar"
                                                aria-label="Basic example" aria-valuenow="35" aria-valuemin="0"
                                                aria-valuemax="100">
                                                <div class="progress-bar bg-main-600 rounded-pill" style="width: 35%"></div>
                                            </div>
                                            <span class="text-gray-900 text-xs fw-medium mt-8">Sold: 18/35</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>

                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ========================= hot-deals End ================================ -->


    <!-- Super Discount Start -->
    <div class="pt-80">
        <div class="container container-lg">
            <div
                class="border border-main-500 bg-main-50 border-dashed rounded-8 py-20 d-flex align-items-center justify-content-evenly">
                <p class="h6 text-main-600 fw-normal">Super discount for your <a href="javascript:void(0)"
                        class="fw-bold text-decoration-underline text-main-600 hover-text-decoration-none hover-text-primary-600 ">first
                        purchase</a> </p>
                <div class="position-relative">
                    <button
                        class="copy-coupon-btn px-32 py-10 text-white text-uppercase bg-main-600 rounded-pill border-0 hover-bg-main-800 ">
                        FREE25BAC
                        <i class="ph ph-file-text text-lg line-height-1"></i>
                    </button>
                    <span
                        class="copy-text bg-main-600 text-white fw-normal position-absolute px-16 py-6 rounded-pill bottom-100 start-50 translate-middle-x min-w-max mb-8 text-xs"></span>
                </div>
                <p class="text-md text-main-600 fw-normal">Use discount code to get <span
                        class="fw-bold text-main-600">20% </span> discount for any item</p>
            </div>
        </div>
    </div>
    <!-- Super Discount End -->

    <!-- ========================== Short Product Section Start ============================== -->
    <div class="short-product pt-110">
        <div class="container container-lg">
            <div class="row gy-4">
                <div class="col-xxl-3 col-lg-4 col-sm-6" data-aos="fade-up" data-aos-duration="600">
                    <div
                        class="p-16 border border-gray-100 hover-border-main-600 rounded-16 position-relative transition-2 ">
                        <div class="p-16 bg-main-50 rounded-16 mb-32">
                            <h6 class="underlined-line position-relative mb-0 pb-16 d-inline-block">Featured Products
                            </h6>
                        </div>
                        <div class="short-product-list arrow-style-two max-h-unset">
                            <div class="d-flex flex-column gap-44">
                                <?php $counter = 0;
                                foreach ($resultProduct['data']['data'] as $key => $product):
                                    $counter++;
                                    if ($counter > 5) {
                                        break;
                                    }
                                    // Find the primary image
                                    $primaryImage = null;
                                    foreach ($product['images'] as $image) {
                                        if ($image['isPrimary']) {
                                            $primaryImage = $image['imageUrl'];
                                            break;
                                        }
                                    }
                                    // Fallback to a placeholder image if no primary image is found
                                    $primaryImage = $primaryImage ?: 'assets/images/thumbs/product-img28.png';

                                    // Calculate discounted price
                                    $originalPrice = floatval($product['price']);
                                    $discountPercentage = floatval($product['discountValue']);
                                    $discountedPrice = $originalPrice * (1 - $discountPercentage / 100);

                                    // Calculate stock and sold percentage
                                    $remainingStock = intval($product['stock']);
                                    $sold = 18; // Assuming 18 sold as per static HTML
                                    $totalStock = $remainingStock + $sold; // Total stock = remaining + sold
                                    $soldPercentage = ($totalStock > 0) ? ($sold / $totalStock) * 100 : 0;


                                    // Calculate rating: Use average of review  $rating = 0;
                                    $reviewCount = 0;

                                    if (!empty($product['reviews'])) {
                                        $totalRating = 0;
                                        $validReviews = 0;

                                        foreach ($product['reviews'] as $review) {
                                            // Safely extract rating value
                                            if (isset($review['rating'])) {
                                                if (is_array($review['rating'])) {
                                                    // If rating is an array, try to get numeric value
                                                    $ratingValue = isset($review['rating']['value']) ? floatval($review['rating']['value']) : 0;
                                                } else {
                                                    // If rating is direct value
                                                    $ratingValue = floatval($review['rating']);
                                                }

                                                if ($ratingValue > 0) {
                                                    $totalRating += $ratingValue;
                                                    $validReviews++;
                                                }
                                            }
                                        }

                                        if ($validReviews > 0) {
                                            $rating = $totalRating / $validReviews;
                                            $reviewCount = $validReviews;
                                        }
                                    }

                                    // Fallback to popularity if no valid reviews
                                    if ($rating === 0) {
                                        $rating = ($product['popularity'] ?? 0) / 2;
                                        $reviewCount = 0; // No actual reviews, just using popularity
                                    }

                                    // Format rating to 1 decimal place
                                    $formattedRating = number_format($rating, 1);
                                    ?>
                                    <div class="flex-align gap-16">
                                        <div class="w-90 h-90 rounded-12 border border-gray-100 flex-shrink-0">
                                            <a href="<?= getenv("BASE_URL") . "/product/" . $utils->makeSlug($product['name']) ?>"
                                                class="link"><img src="<?= htmlspecialchars($primaryImage) ?>" alt=""></a>
                                        </div>
                                        <div class="product-card__content mt-12">
                                            <div class="flex-align mb-20 mt-16 gap-6">
                                                <?php if ($reviewCount > 0): ?>
                                                    <span class="text-xs fw-medium text-gray-500">
                                                        <?= $formattedRating ?>
                                                    </span>
                                                    <span class="text-xs fw-medium text-warning-600 d-flex">
                                                        <i class="ph-fill ph-star"></i>
                                                    </span>
                                                    <span class="text-xs fw-medium text-gray-500">
                                                        (<?= $reviewCount ?>)
                                                    </span>
                                                <?php else: ?>
                                                    <span class="text-xs fw-medium text-gray-500">
                                                        No reviews yet
                                                    </span>
                                                <?php endif; ?>
                                            </div>
                                            <h6 class="title text-lg fw-semibold mt-8 mb-8">
                                                <a href="<?= getenv("BASE_URL") . "/product/" . $utils->makeSlug($product['name']) ?>"
                                                    class="link text-line-1"><?= htmlspecialchars($product['name']) ?></a>
                                            </h6>
                                            <div class="product-card__price flex-align gap-8">
                                                <span
                                                    class="text-heading text-md fw-semibold d-block">₹<?= number_format($discountedPrice, 2) ?></span>
                                                <span
                                                    class="text-gray-400 text-md fw-semibold d-block">₹<?= number_format($discountedPrice, 2) ?></span>
                                            </div>
                                        </div>
                                    </div>

                                <?php endforeach; ?>


                                <?php if (empty($resultProduct['data']['data'])): ?>
                                    <div class="flex-align gap-16">
                                        <div class="w-90 h-90 rounded-12 border border-gray-100 flex-shrink-0">
                                            <a href="product-details.php" class="link"><img
                                                    src="assets/images/product/shorts/dynamic_dgrey/1 (1).jpg" alt=""></a>
                                        </div>
                                        <div class="product-card__content mt-12">
                                            <div class="flex-align mb-20 mt-16 gap-6">
                                                <?php if ($reviewCount > 0): ?>
                                                    <span class="text-xs fw-medium text-gray-500">
                                                        <?= $formattedRating ?>
                                                    </span>
                                                    <span class="text-xs fw-medium text-warning-600 d-flex">
                                                        <i class="ph-fill ph-star"></i>
                                                    </span>
                                                    <span class="text-xs fw-medium text-gray-500">
                                                        (<?= $reviewCount ?>)
                                                    </span>
                                                <?php else: ?>
                                                    <span class="text-xs fw-medium text-gray-500">
                                                        No reviews yet
                                                    </span>
                                                <?php endif; ?>
                                            </div>
                                            <h6 class="title text-lg fw-semibold mt-8 mb-8">
                                                <a href="product-details.php" class="link text-line-1">Taylor Farms Broccoli
                                                    Florets Vegetables</a>
                                            </h6>
                                            <div class="product-card__price flex-align gap-8">
                                                <span class="text-heading text-md fw-semibold d-block">$1500.00</span>
                                                <span class="text-gray-400 text-md fw-semibold d-block">$1500.00</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex-align gap-16">
                                        <div class="w-90 h-90 rounded-12 border border-gray-100 flex-shrink-0">
                                            <a href="product-details.php" class="link"><img
                                                    src="assets/images/product/shorts/hawk_navy/1 (1).jpg" alt=""></a>
                                        </div>
                                        <div class="product-card__content mt-12">
                                            <div class="flex-align mb-20 mt-16 gap-6">
                                                <?php if ($reviewCount > 0): ?>
                                                    <span class="text-xs fw-medium text-gray-500">
                                                        <?= $formattedRating ?>
                                                    </span>
                                                    <span class="text-xs fw-medium text-warning-600 d-flex">
                                                        <i class="ph-fill ph-star"></i>
                                                    </span>
                                                    <span class="text-xs fw-medium text-gray-500">
                                                        (<?= $reviewCount ?>)
                                                    </span>
                                                <?php else: ?>
                                                    <span class="text-xs fw-medium text-gray-500">
                                                        No reviews yet
                                                    </span>
                                                <?php endif; ?>
                                            </div>
                                            <h6 class="title text-lg fw-semibold mt-8 mb-8">
                                                <a href="product-details.php" class="link text-line-1">Taylor Farms Broccoli
                                                    Florets Vegetables</a>
                                            </h6>
                                            <div class="product-card__price flex-align gap-8">
                                                <span class="text-heading text-md fw-semibold d-block">$1500.00</span>
                                                <span class="text-gray-400 text-md fw-semibold d-block">$1500.00</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex-align gap-16">
                                        <div class="w-90 h-90 rounded-12 border border-gray-100 flex-shrink-0">
                                            <a href="product-details.php" class="link"><img
                                                    src="assets/images/product/shorts/hawk_navy/1 (5).jpg" alt=""></a>
                                        </div>
                                        <div class="product-card__content mt-12">
                                            <div class="flex-align mb-20 mt-16 gap-6">
                                                <?php if ($reviewCount > 0): ?>
                                                    <span class="text-xs fw-medium text-gray-500">
                                                        <?= $formattedRating ?>
                                                    </span>
                                                    <span class="text-xs fw-medium text-warning-600 d-flex">
                                                        <i class="ph-fill ph-star"></i>
                                                    </span>
                                                    <span class="text-xs fw-medium text-gray-500">
                                                        (<?= $reviewCount ?>)
                                                    </span>
                                                <?php else: ?>
                                                    <span class="text-xs fw-medium text-gray-500">
                                                        No reviews yet
                                                    </span>
                                                <?php endif; ?>
                                            </div>
                                            <h6 class="title text-lg fw-semibold mt-8 mb-8">
                                                <a href="product-details.php" class="link text-line-1">Taylor Farms Broccoli
                                                    Florets Vegetables</a>
                                            </h6>
                                            <div class="product-card__price flex-align gap-8">
                                                <span class="text-heading text-md fw-semibold d-block">$1500.00</span>
                                                <span class="text-gray-400 text-md fw-semibold d-block">$1500.00</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex-align gap-16">
                                        <div class="w-90 h-90 rounded-12 border border-gray-100 flex-shrink-0">
                                            <a href="product-details.php" class="link"><img
                                                    src="assets/images/product/sports-bra/PS-PULSE-SBRA-PINK/PS-PULSE-SBRA-PINK_2.JPG"
                                                    alt=""></a>
                                        </div>
                                        <div class="product-card__content mt-12">
                                            <div class="flex-align mb-20 mt-16 gap-6">
                                                <?php if ($reviewCount > 0): ?>
                                                    <span class="text-xs fw-medium text-gray-500">
                                                        <?= $formattedRating ?>
                                                    </span>
                                                    <span class="text-xs fw-medium text-warning-600 d-flex">
                                                        <i class="ph-fill ph-star"></i>
                                                    </span>
                                                    <span class="text-xs fw-medium text-gray-500">
                                                        (<?= $reviewCount ?>)
                                                    </span>
                                                <?php else: ?>
                                                    <span class="text-xs fw-medium text-gray-500">
                                                        No reviews yet
                                                    </span>
                                                <?php endif; ?>
                                            </div>
                                            <h6 class="title text-lg fw-semibold mt-8 mb-8">
                                                <a href="product-details.php" class="link text-line-1">Taylor Farms Broccoli
                                                    Florets Vegetables</a>
                                            </h6>
                                            <div class="product-card__price flex-align gap-8">
                                                <span class="text-heading text-md fw-semibold d-block">$1500.00</span>
                                                <span class="text-gray-400 text-md fw-semibold d-block">$1500.00</span>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="d-flex flex-column gap-44">


                                <?php $counter = 0;
                                foreach ($resultProduct['data']['data'] as $key => $product):

                                    $counter++;
                                    if ($counter > 5) {
                                        break;
                                    }
                                    // Find the primary image
                                    $primaryImage = null;
                                    foreach ($product['images'] as $image) {
                                        if ($image['isPrimary']) {
                                            $primaryImage = $image['imageUrl'];
                                            break;
                                        }
                                    }
                                    // Fallback to a placeholder image if no primary image is found
                                    $primaryImage = $primaryImage ?: 'assets/images/thumbs/product-img28.png';

                                    // Calculate discounted price
                                    $originalPrice = floatval($product['price']);
                                    $discountPercentage = floatval($product['discountValue']);
                                    $discountedPrice = $originalPrice * (1 - $discountPercentage / 100);

                                    // Calculate stock and sold percentage
                                    $remainingStock = intval($product['stock']);
                                    $sold = 18; // Assuming 18 sold as per static HTML
                                    $totalStock = $remainingStock + $sold; // Total stock = remaining + sold
                                    $soldPercentage = ($totalStock > 0) ? ($sold / $totalStock) * 100 : 0;


                                    // Calculate rating: Use average of review ratings if available, else use popularity
                                    $rating = 0;
                                    $reviewCount = 0;

                                    if (!empty($product['reviews'])) {
                                        $totalRating = 0;
                                        $validReviews = 0;

                                        foreach ($product['reviews'] as $review) {
                                            // Safely extract rating value
                                            if (isset($review['rating'])) {
                                                if (is_array($review['rating'])) {
                                                    // If rating is an array, try to get numeric value
                                                    $ratingValue = isset($review['rating']['value']) ? floatval($review['rating']['value']) : 0;
                                                } else {
                                                    // If rating is direct value
                                                    $ratingValue = floatval($review['rating']);
                                                }

                                                if ($ratingValue > 0) {
                                                    $totalRating += $ratingValue;
                                                    $validReviews++;
                                                }
                                            }
                                        }

                                        if ($validReviews > 0) {
                                            $rating = $totalRating / $validReviews;
                                            $reviewCount = $validReviews;
                                        }
                                    }

                                    // Fallback to popularity if no valid reviews
                                    if ($rating === 0) {
                                        $rating = ($product['popularity'] ?? 0) / 2;
                                        $reviewCount = 0; // No actual reviews, just using popularity
                                    }

                                    // Format rating to 1 decimal place
                                    $formattedRating = number_format($rating, 1);
                                    ?>
                                    <div class="flex-align gap-16">
                                        <div class="w-90 h-90 rounded-12 border border-gray-100 flex-shrink-0">
                                            <a href="<?= getenv("BASE_URL") . "/product/" . $utils->makeSlug($product['name']) ?>"
                                                class="link"><img src="<?= htmlspecialchars($primaryImage) ?>" alt=""></a>
                                        </div>
                                        <div class="product-card__content mt-12">
                                            <div class="flex-align mb-20 mt-16 gap-6">
                                                <?php if ($reviewCount > 0): ?>
                                                    <span class="text-xs fw-medium text-gray-500">
                                                        <?= $formattedRating ?>
                                                    </span>
                                                    <span class="text-xs fw-medium text-warning-600 d-flex">
                                                        <i class="ph-fill ph-star"></i>
                                                    </span>
                                                    <span class="text-xs fw-medium text-gray-500">
                                                        (<?= $reviewCount ?>)
                                                    </span>
                                                <?php else: ?>
                                                    <span class="text-xs fw-medium text-gray-500">
                                                        No reviews yet
                                                    </span>
                                                <?php endif; ?>
                                            </div>
                                            <h6 class="title text-lg fw-semibold mt-8 mb-8">
                                                <a href="<?= getenv("BASE_URL") . "/product/" . $utils->makeSlug($product['name']) ?>"
                                                    class="link text-line-1"><?= htmlspecialchars($product['name']) ?></a>
                                            </h6>
                                            <div class="product-card__price flex-align gap-8">
                                                <span
                                                    class="text-heading text-md fw-semibold d-block">₹<?= number_format($discountedPrice, 2) ?></span>
                                                <span
                                                    class="text-gray-400 text-md fw-semibold d-block">₹<?= number_format($discountedPrice, 2) ?></span>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>

                                <?php if (empty($resultProduct['data']['data'])): ?>
                                    <div class="flex-align gap-16">
                                        <div class="w-90 h-90 rounded-12 border border-gray-100 flex-shrink-0">
                                            <a href="product-details.php" class="link"><img
                                                    src="assets/images/product/shorts/dynamic_geen/1 (1).jpg" alt=""></a>
                                        </div>
                                        <div class="product-card__content mt-12">
                                            <div class="flex-align mb-20 mt-16 gap-6">
                                                <?php if ($reviewCount > 0): ?>
                                                    <span class="text-xs fw-medium text-gray-500">
                                                        <?= $formattedRating ?>
                                                    </span>
                                                    <span class="text-xs fw-medium text-warning-600 d-flex">
                                                        <i class="ph-fill ph-star"></i>
                                                    </span>
                                                    <span class="text-xs fw-medium text-gray-500">
                                                        (<?= $reviewCount ?>)
                                                    </span>
                                                <?php else: ?>
                                                    <span class="text-xs fw-medium text-gray-500">
                                                        No reviews yet
                                                    </span>
                                                <?php endif; ?>
                                            </div>
                                            <h6 class="title text-lg fw-semibold mt-8 mb-8">
                                                <a href="product-details.php" class="link text-line-1">Taylor Farms Broccoli
                                                    Florets Vegetables</a>
                                            </h6>
                                            <div class="product-card__price flex-align gap-8">
                                                <span class="text-heading text-md fw-semibold d-block">$1500.00</span>
                                                <span class="text-gray-400 text-md fw-semibold d-block">$1500.00</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex-align gap-16">
                                        <div class="w-90 h-90 rounded-12 border border-gray-100 flex-shrink-0">
                                            <a href="product-details.php" class="link"><img
                                                    src="assets/images/product/trackpant/black/1 (1).jpg" alt=""></a>
                                        </div>
                                        <div class="product-card__content mt-12">
                                            <div class="flex-align mb-20 mt-16 gap-6">
                                                <?php if ($reviewCount > 0): ?>
                                                    <span class="text-xs fw-medium text-gray-500">
                                                        <?= $formattedRating ?>
                                                    </span>
                                                    <span class="text-xs fw-medium text-warning-600 d-flex">
                                                        <i class="ph-fill ph-star"></i>
                                                    </span>
                                                    <span class="text-xs fw-medium text-gray-500">
                                                        (<?= $reviewCount ?>)
                                                    </span>
                                                <?php else: ?>
                                                    <span class="text-xs fw-medium text-gray-500">
                                                        No reviews yet
                                                    </span>
                                                <?php endif; ?>
                                            </div>
                                            <h6 class="title text-lg fw-semibold mt-8 mb-8">
                                                <a href="product-details.php" class="link text-line-1">Taylor Farms Broccoli
                                                    Florets Vegetables</a>
                                            </h6>
                                            <div class="product-card__price flex-align gap-8">
                                                <span class="text-heading text-md fw-semibold d-block">$1500.00</span>
                                                <span class="text-gray-400 text-md fw-semibold d-block">$1500.00</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex-align gap-16">
                                        <div class="w-90 h-90 rounded-12 border border-gray-100 flex-shrink-0">
                                            <a href="product-details.php" class="link"><img
                                                    src="assets/images/product/sports-bra/PS-PULSE-SBRA-GREEN/PS-PULSE-SBRA-GREEN_4.JPG"
                                                    alt=""></a>
                                        </div>
                                        <div class="product-card__content mt-12">
                                            <div class="flex-align mb-20 mt-16 gap-6">
                                                <?php if ($reviewCount > 0): ?>
                                                    <span class="text-xs fw-medium text-gray-500">
                                                        <?= $formattedRating ?>
                                                    </span>
                                                    <span class="text-xs fw-medium text-warning-600 d-flex">
                                                        <i class="ph-fill ph-star"></i>
                                                    </span>
                                                    <span class="text-xs fw-medium text-gray-500">
                                                        (<?= $reviewCount ?>)
                                                    </span>
                                                <?php else: ?>
                                                    <span class="text-xs fw-medium text-gray-500">
                                                        No reviews yet
                                                    </span>
                                                <?php endif; ?>
                                            </div>
                                            <h6 class="title text-lg fw-semibold mt-8 mb-8">
                                                <a href="product-details.php" class="link text-line-1">Taylor Farms Broccoli
                                                    Florets Vegetables</a>
                                            </h6>
                                            <div class="product-card__price flex-align gap-8">
                                                <span class="text-heading text-md fw-semibold d-block">$1500.00</span>
                                                <span class="text-gray-400 text-md fw-semibold d-block">$1500.00</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex-align gap-16">
                                        <div class="w-90 h-90 rounded-12 border border-gray-100 flex-shrink-0">
                                            <a href="product-details.php" class="link"><img
                                                    src="assets/images/product/sports-bra/PS-PULSE-SBRA-PINK/PS-PULSE-SBRA-PINK_3.JPG"
                                                    alt=""></a>
                                        </div>
                                        <div class="product-card__content mt-12">
                                            <div class="flex-align mb-20 mt-16 gap-6">
                                                <?php if ($reviewCount > 0): ?>
                                                    <span class="text-xs fw-medium text-gray-500">
                                                        <?= $formattedRating ?>
                                                    </span>
                                                    <span class="text-xs fw-medium text-warning-600 d-flex">
                                                        <i class="ph-fill ph-star"></i>
                                                    </span>
                                                    <span class="text-xs fw-medium text-gray-500">
                                                        (<?= $reviewCount ?>)
                                                    </span>
                                                <?php else: ?>
                                                    <span class="text-xs fw-medium text-gray-500">
                                                        No reviews yet
                                                    </span>
                                                <?php endif; ?>
                                            </div>
                                            <h6 class="title text-lg fw-semibold mt-8 mb-8">
                                                <a href="product-details.php" class="link text-line-1">Taylor Farms Broccoli
                                                    Florets Vegetables</a>
                                            </h6>
                                            <div class="product-card__price flex-align gap-8">
                                                <span class="text-heading text-md fw-semibold d-block">$1500.00</span>
                                                <span class="text-gray-400 text-md fw-semibold d-block">$1500.00</span>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-3 col-lg-4 col-sm-6" data-aos="fade-up" data-aos-duration="700">
                    <div
                        class="p-16 border border-gray-100 hover-border-main-600 rounded-16 position-relative transition-2 ">
                        <div class="p-16 bg-main-50 rounded-16 mb-32">
                            <h6 class="underlined-line position-relative mb-0 pb-16 d-inline-block">Top Selling Products
                            </h6>
                        </div>
                        <div class="short-product-list arrow-style-two max-h-unset">
                            <div class="d-flex flex-column gap-44">
                                <?php $counter = 0;
                                foreach ($resultProduct['data']['data'] as $key => $product):
                                    $counter++;
                                    if ($counter > 5) {
                                        break;
                                    }
                                    // Find the primary image
                                    $primaryImage = null;
                                    foreach ($product['images'] as $image) {
                                        if ($image['isPrimary']) {
                                            $primaryImage = $image['imageUrl'];
                                            break;
                                        }
                                    }
                                    // Fallback to a placeholder image if no primary image is found
                                    $primaryImage = $primaryImage ?: 'assets/images/thumbs/product-img28.png';

                                    // Calculate discounted price
                                    $originalPrice = floatval($product['price']);
                                    $discountPercentage = floatval($product['discountValue']);
                                    $discountedPrice = $originalPrice * (1 - $discountPercentage / 100);

                                    // Calculate stock and sold percentage
                                    $remainingStock = intval($product['stock']);
                                    $sold = 18; // Assuming 18 sold as per static HTML
                                    $totalStock = $remainingStock + $sold; // Total stock = remaining + sold
                                    $soldPercentage = ($totalStock > 0) ? ($sold / $totalStock) * 100 : 0;


                                    // Calculate rating: Use average of review ratings if available, else use popularity
                                    $rating = 0;
                                    $reviewCount = 0;

                                    if (!empty($product['reviews'])) {
                                        $totalRating = 0;
                                        $validReviews = 0;

                                        foreach ($product['reviews'] as $review) {
                                            // Safely extract rating value
                                            if (isset($review['rating'])) {
                                                if (is_array($review['rating'])) {
                                                    // If rating is an array, try to get numeric value
                                                    $ratingValue = isset($review['rating']['value']) ? floatval($review['rating']['value']) : 0;
                                                } else {
                                                    // If rating is direct value
                                                    $ratingValue = floatval($review['rating']);
                                                }

                                                if ($ratingValue > 0) {
                                                    $totalRating += $ratingValue;
                                                    $validReviews++;
                                                }
                                            }
                                        }

                                        if ($validReviews > 0) {
                                            $rating = $totalRating / $validReviews;
                                            $reviewCount = $validReviews;
                                        }
                                    }

                                    // Fallback to popularity if no valid reviews
                                    if ($rating === 0) {
                                        $rating = ($product['popularity'] ?? 0) / 2;
                                        $reviewCount = 0; // No actual reviews, just using popularity
                                    }

                                    // Format rating to 1 decimal place
                                    $formattedRating = number_format($rating, 1);
                                    ?>
                                    <div class="flex-align gap-16">
                                        <div class="w-90 h-90 rounded-12 border border-gray-100 flex-shrink-0">
                                            <a href="<?= getenv("BASE_URL") . "/product/" . $utils->makeSlug($product['name']) ?>"
                                                class="link"><img src="<?= htmlspecialchars($primaryImage) ?>" alt=""></a>
                                        </div>
                                        <div class="product-card__content mt-12">
                                            <div class="flex-align mb-20 mt-16 gap-6">
                                                <?php if ($reviewCount > 0): ?>
                                                    <span class="text-xs fw-medium text-gray-500">
                                                        <?= $formattedRating ?>
                                                    </span>
                                                    <span class="text-xs fw-medium text-warning-600 d-flex">
                                                        <i class="ph-fill ph-star"></i>
                                                    </span>
                                                    <span class="text-xs fw-medium text-gray-500">
                                                        (<?= $reviewCount ?>)
                                                    </span>
                                                <?php else: ?>
                                                    <span class="text-xs fw-medium text-gray-500">
                                                        No reviews yet
                                                    </span>
                                                <?php endif; ?>
                                            </div>
                                            <h6 class="title text-lg fw-semibold mt-8 mb-8">
                                                <a href="<?= getenv("BASE_URL") . "/product/" . $utils->makeSlug($product['name']) ?>"
                                                    class="link text-line-1"><?= htmlspecialchars($product['name']) ?></a>
                                            </h6>
                                            <div class="product-card__price flex-align gap-8">
                                                <span
                                                    class="text-heading text-md fw-semibold d-block">₹<?= number_format($discountedPrice, 2) ?></span>
                                                <span
                                                    class="text-gray-400 text-md fw-semibold d-block">₹<?= number_format($discountedPrice, 2) ?></span>
                                            </div>
                                        </div>
                                    </div>

                                <?php endforeach; ?>

                                <?php if (empty($resultProduct['data']['data'])): ?>
                                    <div class="flex-align gap-16">
                                        <div class="w-90 h-90 rounded-12 border border-gray-100 flex-shrink-0">
                                            <a href="product-details.php" class="link"><img
                                                    src="assets/images/product/sports-bra/PS-PULSE-SBRA-RED/PS-PULSE-SBRA-RED_7.JPG"
                                                    alt=""></a>
                                        </div>
                                        <div class="product-card__content mt-12">
                                            <div class="flex-align mb-20 mt-16 gap-6">
                                                <?php if ($reviewCount > 0): ?>
                                                    <span class="text-xs fw-medium text-gray-500">
                                                        <?= $formattedRating ?>
                                                    </span>
                                                    <span class="text-xs fw-medium text-warning-600 d-flex">
                                                        <i class="ph-fill ph-star"></i>
                                                    </span>
                                                    <span class="text-xs fw-medium text-gray-500">
                                                        (<?= $reviewCount ?>)
                                                    </span>
                                                <?php else: ?>
                                                    <span class="text-xs fw-medium text-gray-500">
                                                        No reviews yet
                                                    </span>
                                                <?php endif; ?>
                                            </div>
                                            <h6 class="title text-lg fw-semibold mt-8 mb-8">
                                                <a href="product-details.php" class="link text-line-1">Taylor Farms Broccoli
                                                    Florets Vegetables</a>
                                            </h6>
                                            <div class="product-card__price flex-align gap-8">
                                                <span class="text-heading text-md fw-semibold d-block">$1500.00</span>
                                                <span class="text-gray-400 text-md fw-semibold d-block">$1500.00</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex-align gap-16">
                                        <div class="w-90 h-90 rounded-12 border border-gray-100 flex-shrink-0">
                                            <a href="product-details.php" class="link"><img
                                                    src="assets/images/product/sports-bra/PS-PULSE-SBRA-PINK/PS-PULSE-SBRA-PINK_2.JPG"
                                                    alt=""></a>
                                        </div>
                                        <div class="product-card__content mt-12">
                                            <div class="flex-align mb-20 mt-16 gap-6">
                                                <?php if ($reviewCount > 0): ?>
                                                    <span class="text-xs fw-medium text-gray-500">
                                                        <?= $formattedRating ?>
                                                    </span>
                                                    <span class="text-xs fw-medium text-warning-600 d-flex">
                                                        <i class="ph-fill ph-star"></i>
                                                    </span>
                                                    <span class="text-xs fw-medium text-gray-500">
                                                        (<?= $reviewCount ?>)
                                                    </span>
                                                <?php else: ?>
                                                    <span class="text-xs fw-medium text-gray-500">
                                                        No reviews yet
                                                    </span>
                                                <?php endif; ?>
                                            </div>
                                            <h6 class="title text-lg fw-semibold mt-8 mb-8">
                                                <a href="product-details.php" class="link text-line-1">Taylor Farms Broccoli
                                                    Florets Vegetables</a>
                                            </h6>
                                            <div class="product-card__price flex-align gap-8">
                                                <span class="text-heading text-md fw-semibold d-block">$1500.00</span>
                                                <span class="text-gray-400 text-md fw-semibold d-block">$1500.00</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex-align gap-16">
                                        <div class="w-90 h-90 rounded-12 border border-gray-100 flex-shrink-0">
                                            <a href="product-details.php" class="link"><img
                                                    src="assets/images/product/sports-bra/PS-PULSE-SBRA-RED/PS-PULSE-SBRA-RED_7.JPG"
                                                    alt=""></a>
                                        </div>
                                        <div class="product-card__content mt-12">
                                            <div class="flex-align mb-20 mt-16 gap-6">
                                                <?php if ($reviewCount > 0): ?>
                                                    <span class="text-xs fw-medium text-gray-500">
                                                        <?= $formattedRating ?>
                                                    </span>
                                                    <span class="text-xs fw-medium text-warning-600 d-flex">
                                                        <i class="ph-fill ph-star"></i>
                                                    </span>
                                                    <span class="text-xs fw-medium text-gray-500">
                                                        (<?= $reviewCount ?>)
                                                    </span>
                                                <?php else: ?>
                                                    <span class="text-xs fw-medium text-gray-500">
                                                        No reviews yet
                                                    </span>
                                                <?php endif; ?>
                                            </div>
                                            <h6 class="title text-lg fw-semibold mt-8 mb-8">
                                                <a href="product-details.php" class="link text-line-1">Taylor Farms Broccoli
                                                    Florets Vegetables</a>
                                            </h6>
                                            <div class="product-card__price flex-align gap-8">
                                                <span class="text-heading text-md fw-semibold d-block">$1500.00</span>
                                                <span class="text-gray-400 text-md fw-semibold d-block">$1500.00</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex-align gap-16">
                                        <div class="w-90 h-90 rounded-12 border border-gray-100 flex-shrink-0">
                                            <a href="product-details.php" class="link"><img
                                                    src="assets/images/product/shorts/hawk_navy/1 (7).jpg" alt=""></a>
                                        </div>
                                        <div class="product-card__content mt-12">
                                            <div class="flex-align mb-20 mt-16 gap-6">
                                                <?php if ($reviewCount > 0): ?>
                                                    <span class="text-xs fw-medium text-gray-500">
                                                        <?= $formattedRating ?>
                                                    </span>
                                                    <span class="text-xs fw-medium text-warning-600 d-flex">
                                                        <i class="ph-fill ph-star"></i>
                                                    </span>
                                                    <span class="text-xs fw-medium text-gray-500">
                                                        (<?= $reviewCount ?>)
                                                    </span>
                                                <?php else: ?>
                                                    <span class="text-xs fw-medium text-gray-500">
                                                        No reviews yet
                                                    </span>
                                                <?php endif; ?>
                                            </div>
                                            <h6 class="title text-lg fw-semibold mt-8 mb-8">
                                                <a href="product-details.php" class="link text-line-1">Taylor Farms Broccoli
                                                    Florets Vegetables</a>
                                            </h6>
                                            <div class="product-card__price flex-align gap-8">
                                                <span class="text-heading text-md fw-semibold d-block">$1500.00</span>
                                                <span class="text-gray-400 text-md fw-semibold d-block">$1500.00</span>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="d-flex flex-column gap-44">

                                <?php $counter = 0;
                                foreach ($resultProduct['data']['data'] as $key => $product):

                                    $counter++;
                                    if ($counter > 5) {
                                        break;
                                    }
                                    // Find the primary image
                                    $primaryImage = null;
                                    foreach ($product['images'] as $image) {
                                        if ($image['isPrimary']) {
                                            $primaryImage = $image['imageUrl'];
                                            break;
                                        }
                                    }
                                    // Fallback to a placeholder image if no primary image is found
                                    $primaryImage = $primaryImage ?: 'assets/images/thumbs/product-img28.png';

                                    // Calculate discounted price
                                    $originalPrice = floatval($product['price']);
                                    $discountPercentage = floatval($product['discountValue']);
                                    $discountedPrice = $originalPrice * (1 - $discountPercentage / 100);

                                    // Calculate stock and sold percentage
                                    $remainingStock = intval($product['stock']);
                                    $sold = 18; // Assuming 18 sold as per static HTML
                                    $totalStock = $remainingStock + $sold; // Total stock = remaining + sold
                                    $soldPercentage = ($totalStock > 0) ? ($sold / $totalStock) * 100 : 0;


                                    // Calculate rating: Use average of review ratings if available, else use popularity
                                    $rating = 0;
                                    $reviewCount = 0;

                                    if (!empty($product['reviews'])) {
                                        $totalRating = 0;
                                        $validReviews = 0;

                                        foreach ($product['reviews'] as $review) {
                                            // Safely extract rating value
                                            if (isset($review['rating'])) {
                                                if (is_array($review['rating'])) {
                                                    // If rating is an array, try to get numeric value
                                                    $ratingValue = isset($review['rating']['value']) ? floatval($review['rating']['value']) : 0;
                                                } else {
                                                    // If rating is direct value
                                                    $ratingValue = floatval($review['rating']);
                                                }

                                                if ($ratingValue > 0) {
                                                    $totalRating += $ratingValue;
                                                    $validReviews++;
                                                }
                                            }
                                        }

                                        if ($validReviews > 0) {
                                            $rating = $totalRating / $validReviews;
                                            $reviewCount = $validReviews;
                                        }
                                    }

                                    // Fallback to popularity if no valid reviews
                                    if ($rating === 0) {
                                        $rating = ($product['popularity'] ?? 0) / 2;
                                        $reviewCount = 0; // No actual reviews, just using popularity
                                    }

                                    // Format rating to 1 decimal place
                                    $formattedRating = number_format($rating, 1);
                                    ?>
                                    <div class="flex-align gap-16">
                                        <div class="w-90 h-90 rounded-12 border border-gray-100 flex-shrink-0">
                                            <a href="<?= getenv("BASE_URL") . "/product/" . $utils->makeSlug($product['name']) ?>"
                                                class="link"><img src="<?= htmlspecialchars($primaryImage) ?>" alt=""></a>
                                        </div>
                                        <div class="product-card__content mt-12">
                                            <div class="flex-align mb-20 mt-16 gap-6">
                                                <?php if ($reviewCount > 0): ?>
                                                    <span class="text-xs fw-medium text-gray-500">
                                                        <?= $formattedRating ?>
                                                    </span>
                                                    <span class="text-xs fw-medium text-warning-600 d-flex">
                                                        <i class="ph-fill ph-star"></i>
                                                    </span>
                                                    <span class="text-xs fw-medium text-gray-500">
                                                        (<?= $reviewCount ?>)
                                                    </span>
                                                <?php else: ?>
                                                    <span class="text-xs fw-medium text-gray-500">
                                                        No reviews yet
                                                    </span>
                                                <?php endif; ?>
                                            </div>
                                            <h6 class="title text-lg fw-semibold mt-8 mb-8">
                                                <a href="<?= getenv("BASE_URL") . "/product/" . $utils->makeSlug($product['name']) ?>"
                                                    class="link text-line-1"><?= htmlspecialchars($product['name']) ?></a>
                                            </h6>
                                            <div class="product-card__price flex-align gap-8">
                                                <span
                                                    class="text-heading text-md fw-semibold d-block">₹<?= number_format($discountedPrice, 2) ?></span>
                                                <span
                                                    class="text-gray-400 text-md fw-semibold d-block">₹<?= number_format($discountedPrice, 2) ?></span>
                                            </div>
                                        </div>
                                    </div>

                                <?php endforeach; ?>

                                <?php if (empty($resultProduct['data']['data'])): ?>
                                    <div class="flex-align gap-16">
                                        <div class="w-90 h-90 rounded-12 border border-gray-100 flex-shrink-0">
                                            <a href="product-details.php" class="link"><img
                                                    src="assets/images/product/shorts/hawk_navy/1 (7).jpg" alt=""></a>
                                        </div>
                                        <div class="product-card__content mt-12">
                                            <div class="flex-align mb-20 mt-16 gap-6">
                                                <?php if ($reviewCount > 0): ?>
                                                    <span class="text-xs fw-medium text-gray-500">
                                                        <?= $formattedRating ?>
                                                    </span>
                                                    <span class="text-xs fw-medium text-warning-600 d-flex">
                                                        <i class="ph-fill ph-star"></i>
                                                    </span>
                                                    <span class="text-xs fw-medium text-gray-500">
                                                        (<?= $reviewCount ?>)
                                                    </span>
                                                <?php else: ?>
                                                    <span class="text-xs fw-medium text-gray-500">
                                                        No reviews yet
                                                    </span>
                                                <?php endif; ?>
                                            </div>
                                            <h6 class="title text-lg fw-semibold mt-8 mb-8">
                                                <a href="product-details.php" class="link text-line-1">Taylor Farms Broccoli
                                                    Florets Vegetables</a>
                                            </h6>
                                            <div class="product-card__price flex-align gap-8">
                                                <span class="text-heading text-md fw-semibold d-block">$1500.00</span>
                                                <span class="text-gray-400 text-md fw-semibold d-block">$1500.00</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex-align gap-16">
                                        <div class="w-90 h-90 rounded-12 border border-gray-100 flex-shrink-0">
                                            <a href="product-details.php" class="link"><img
                                                    src="assets/images/product/shorts/hawk_black/1 (2).jpg" alt=""></a>
                                        </div>
                                        <div class="product-card__content mt-12">
                                            <div class="flex-align mb-20 mt-16 gap-6">
                                                <?php if ($reviewCount > 0): ?>
                                                    <span class="text-xs fw-medium text-gray-500">
                                                        <?= $formattedRating ?>
                                                    </span>
                                                    <span class="text-xs fw-medium text-warning-600 d-flex">
                                                        <i class="ph-fill ph-star"></i>
                                                    </span>
                                                    <span class="text-xs fw-medium text-gray-500">
                                                        (<?= $reviewCount ?>)
                                                    </span>
                                                <?php else: ?>
                                                    <span class="text-xs fw-medium text-gray-500">
                                                        No reviews yet
                                                    </span>
                                                <?php endif; ?>
                                            </div>
                                            <h6 class="title text-lg fw-semibold mt-8 mb-8">
                                                <a href="product-details.php" class="link text-line-1">Taylor Farms Broccoli
                                                    Florets Vegetables</a>
                                            </h6>
                                            <div class="product-card__price flex-align gap-8">
                                                <span class="text-heading text-md fw-semibold d-block">$1500.00</span>
                                                <span class="text-gray-400 text-md fw-semibold d-block">$1500.00</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex-align gap-16">
                                        <div class="w-90 h-90 rounded-12 border border-gray-100 flex-shrink-0">
                                            <a href="product-details.php" class="link"><img
                                                    src="assets/images/product/sports-bra/PS-PULSE-SBRA-RED/PS-PULSE-SBRA-RED_7.JPG"
                                                    alt=""></a>
                                        </div>
                                        <div class="product-card__content mt-12">
                                            <div class="flex-align mb-20 mt-16 gap-6">
                                                <?php if ($reviewCount > 0): ?>
                                                    <span class="text-xs fw-medium text-gray-500">
                                                        <?= $formattedRating ?>
                                                    </span>
                                                    <span class="text-xs fw-medium text-warning-600 d-flex">
                                                        <i class="ph-fill ph-star"></i>
                                                    </span>
                                                    <span class="text-xs fw-medium text-gray-500">
                                                        (<?= $reviewCount ?>)
                                                    </span>
                                                <?php else: ?>
                                                    <span class="text-xs fw-medium text-gray-500">
                                                        No reviews yet
                                                    </span>
                                                <?php endif; ?>
                                            </div>
                                            <h6 class="title text-lg fw-semibold mt-8 mb-8">
                                                <a href="product-details.php" class="link text-line-1">Taylor Farms Broccoli
                                                    Florets Vegetables</a>
                                            </h6>
                                            <div class="product-card__price flex-align gap-8">
                                                <span class="text-heading text-md fw-semibold d-block">$1500.00</span>
                                                <span class="text-gray-400 text-md fw-semibold d-block">$1500.00</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex-align gap-16">
                                        <div class="w-90 h-90 rounded-12 border border-gray-100 flex-shrink-0">
                                            <a href="product-details.php" class="link"><img
                                                    src="assets/images/product/sports-bra/PS-PULSE-SBRA-PINK/PS-PULSE-SBRA-PINK_2.JPG"
                                                    alt=""></a>
                                        </div>
                                        <div class="product-card__content mt-12">
                                            <div class="flex-align mb-20 mt-16 gap-6">
                                                <?php if ($reviewCount > 0): ?>
                                                    <span class="text-xs fw-medium text-gray-500">
                                                        <?= $formattedRating ?>
                                                    </span>
                                                    <span class="text-xs fw-medium text-warning-600 d-flex">
                                                        <i class="ph-fill ph-star"></i>
                                                    </span>
                                                    <span class="text-xs fw-medium text-gray-500">
                                                        (<?= $reviewCount ?>)
                                                    </span>
                                                <?php else: ?>
                                                    <span class="text-xs fw-medium text-gray-500">
                                                        No reviews yet
                                                    </span>
                                                <?php endif; ?>
                                            </div>
                                            <h6 class="title text-lg fw-semibold mt-8 mb-8">
                                                <a href="product-details.php" class="link text-line-1">Taylor Farms Broccoli
                                                    Florets Vegetables</a>
                                            </h6>
                                            <div class="product-card__price flex-align gap-8">
                                                <span class="text-heading text-md fw-semibold d-block">$1500.00</span>
                                                <span class="text-gray-400 text-md fw-semibold d-block">$1500.00</span>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-3 col-lg-4 col-sm-6" data-aos="fade-up" data-aos-duration="800">
                    <div
                        class="p-16 border border-gray-100 hover-border-main-600 rounded-16 position-relative transition-2 ">
                        <div class="p-16 bg-main-50 rounded-16 mb-32">
                            <h6 class="underlined-line position-relative mb-0 pb-16 d-inline-block">On-sale Products
                            </h6>
                        </div>
                        <div class="short-product-list arrow-style-two max-h-unset">
                            <div class="d-flex flex-column gap-44">

                                <?php $counter = 0;
                                foreach ($resultProduct['data']['data'] as $key => $product):
                                    if ($counter >= 5) {
                                        break;
                                    }
                                    $counter++;

                                    // Find the primary image
                                    $primaryImage = null;
                                    foreach ($product['images'] as $image) {
                                        if ($image['isPrimary']) {
                                            $primaryImage = $image['imageUrl'];
                                            break;
                                        }
                                    }
                                    // Fallback to a placeholder image if no primary image is found
                                    $primaryImage = $primaryImage ?: 'assets/images/thumbs/product-img28.png';

                                    // Calculate discounted price
                                    $originalPrice = floatval($product['price']);
                                    $discountPercentage = floatval($product['discountValue']);
                                    $discountedPrice = $originalPrice * (1 - $discountPercentage / 100);

                                    // Calculate stock and sold percentage
                                    $remainingStock = intval($product['stock']);
                                    $sold = 18; // Assuming 18 sold as per static HTML
                                    $totalStock = $remainingStock + $sold; // Total stock = remaining + sold
                                    $soldPercentage = ($totalStock > 0) ? ($sold / $totalStock) * 100 : 0;


                                    // Calculate rating: Use average of review ratings if available, else use popularity
                                    $rating = 0;
                                    $reviewCount = 0;

                                    if (!empty($product['reviews'])) {
                                        $totalRating = 0;
                                        $validReviews = 0;

                                        foreach ($product['reviews'] as $review) {
                                            // Safely extract rating value
                                            if (isset($review['rating'])) {
                                                if (is_array($review['rating'])) {
                                                    // If rating is an array, try to get numeric value
                                                    $ratingValue = isset($review['rating']['value']) ? floatval($review['rating']['value']) : 0;
                                                } else {
                                                    // If rating is direct value
                                                    $ratingValue = floatval($review['rating']);
                                                }

                                                if ($ratingValue > 0) {
                                                    $totalRating += $ratingValue;
                                                    $validReviews++;
                                                }
                                            }
                                        }

                                        if ($validReviews > 0) {
                                            $rating = $totalRating / $validReviews;
                                            $reviewCount = $validReviews;
                                        }
                                    }

                                    // Fallback to popularity if no valid reviews
                                    if ($rating === 0) {
                                        $rating = ($product['popularity'] ?? 0) / 2;
                                        $reviewCount = 0; // No actual reviews, just using popularity
                                    }

                                    // Format rating to 1 decimal place
                                    $formattedRating = number_format($rating, 1);
                                    ?>
                                    <div class="flex-align gap-16">
                                        <div class="w-90 h-90 rounded-12 border border-gray-100 flex-shrink-0">
                                            <a href="<?= getenv("BASE_URL") . "/product/" . $utils->makeSlug($product['name']) ?>"
                                                class="link"><img src="<?= htmlspecialchars($primaryImage) ?>" alt=""></a>
                                        </div>
                                        <div class="product-card__content mt-12">
                                            <div class="flex-align mb-20 mt-16 gap-6">
                                                <?php if ($reviewCount > 0): ?>
                                                    <span class="text-xs fw-medium text-gray-500">
                                                        <?= $formattedRating ?>
                                                    </span>
                                                    <span class="text-xs fw-medium text-warning-600 d-flex">
                                                        <i class="ph-fill ph-star"></i>
                                                    </span>
                                                    <span class="text-xs fw-medium text-gray-500">
                                                        (<?= $reviewCount ?>)
                                                    </span>
                                                <?php else: ?>
                                                    <span class="text-xs fw-medium text-gray-500">
                                                        No reviews yet
                                                    </span>
                                                <?php endif; ?>
                                            </div>
                                            <h6 class="title text-lg fw-semibold mt-8 mb-8">
                                                <a href="<?= getenv("BASE_URL") . "/product/" . $utils->makeSlug($product['name']) ?>"
                                                    class="link text-line-1"><?= htmlspecialchars($product['name']) ?></a>
                                            </h6>
                                            <div class="product-card__price flex-align gap-8">
                                                <span
                                                    class="text-heading text-md fw-semibold d-block">₹<?= number_format($discountedPrice, 2) ?></span>
                                                <span
                                                    class="text-gray-400 text-md fw-semibold d-block">₹<?= number_format($discountedPrice, 2) ?></span>
                                            </div>
                                        </div>
                                    </div>

                                <?php endforeach; ?>

                                <?php if (empty($resultProduct['data']['data'])): ?>
                                    <div class="flex-align gap-16">
                                        <div class="w-90 h-90 rounded-12 border border-gray-100 flex-shrink-0">
                                            <a href="product-details.php" class="link"><img
                                                    src="assets/images/product/sports-bra/PS-PULSE-SBRA-PINK/PS-PULSE-SBRA-PINK_2.JPG"
                                                    alt=""></a>
                                        </div>
                                        <div class="product-card__content mt-12">
                                            <div class="flex-align mb-20 mt-16 gap-6">
                                                <?php if ($reviewCount > 0): ?>
                                                    <span class="text-xs fw-medium text-gray-500">
                                                        <?= $formattedRating ?>
                                                    </span>
                                                    <span class="text-xs fw-medium text-warning-600 d-flex">
                                                        <i class="ph-fill ph-star"></i>
                                                    </span>
                                                    <span class="text-xs fw-medium text-gray-500">
                                                        (<?= $reviewCount ?>)
                                                    </span>
                                                <?php else: ?>
                                                    <span class="text-xs fw-medium text-gray-500">
                                                        No reviews yet
                                                    </span>
                                                <?php endif; ?>
                                            </div>
                                            <h6 class="title text-lg fw-semibold mt-8 mb-8">
                                                <a href="product-details.php" class="link text-line-1">Taylor Farms Broccoli
                                                    Florets Vegetables</a>
                                            </h6>
                                            <div class="product-card__price flex-align gap-8">
                                                <span class="text-heading text-md fw-semibold d-block">$1500.00</span>
                                                <span class="text-gray-400 text-md fw-semibold d-block">$1500.00</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex-align gap-16">
                                        <div class="w-90 h-90 rounded-12 border border-gray-100 flex-shrink-0">
                                            <a href="product-details.php" class="link"><img
                                                    src="assets/images/product/sports-bra/PS-PULSE-SBRA-PINK/PS-PULSE-SBRA-PINK_2.JPG"
                                                    alt=""></a>
                                        </div>
                                        <div class="product-card__content mt-12">
                                            <div class="flex-align mb-20 mt-16 gap-6">
                                                <?php if ($reviewCount > 0): ?>
                                                    <span class="text-xs fw-medium text-gray-500">
                                                        <?= $formattedRating ?>
                                                    </span>
                                                    <span class="text-xs fw-medium text-warning-600 d-flex">
                                                        <i class="ph-fill ph-star"></i>
                                                    </span>
                                                    <span class="text-xs fw-medium text-gray-500">
                                                        (<?= $reviewCount ?>)
                                                    </span>
                                                <?php else: ?>
                                                    <span class="text-xs fw-medium text-gray-500">
                                                        No reviews yet
                                                    </span>
                                                <?php endif; ?>
                                            </div>
                                            <h6 class="title text-lg fw-semibold mt-8 mb-8">
                                                <a href="product-details.php" class="link text-line-1">Taylor Farms Broccoli
                                                    Florets Vegetables</a>
                                            </h6>
                                            <div class="product-card__price flex-align gap-8">
                                                <span class="text-heading text-md fw-semibold d-block">$1500.00</span>
                                                <span class="text-gray-400 text-md fw-semibold d-block">$1500.00</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex-align gap-16">
                                        <div class="w-90 h-90 rounded-12 border border-gray-100 flex-shrink-0">
                                            <a href="product-details.php" class="link"><img
                                                    src="assets/images/product/sports-bra/PS-PULSE-SBRA-RED/PS-PULSE-SBRA-RED_7.JPG"
                                                    alt=""></a>
                                        </div>
                                        <div class="product-card__content mt-12">
                                            <div class="flex-align mb-20 mt-16 gap-6">
                                                <?php if ($reviewCount > 0): ?>
                                                    <span class="text-xs fw-medium text-gray-500">
                                                        <?= $formattedRating ?>
                                                    </span>
                                                    <span class="text-xs fw-medium text-warning-600 d-flex">
                                                        <i class="ph-fill ph-star"></i>
                                                    </span>
                                                    <span class="text-xs fw-medium text-gray-500">
                                                        (<?= $reviewCount ?>)
                                                    </span>
                                                <?php else: ?>
                                                    <span class="text-xs fw-medium text-gray-500">
                                                        No reviews yet
                                                    </span>
                                                <?php endif; ?>
                                            </div>
                                            <h6 class="title text-lg fw-semibold mt-8 mb-8">
                                                <a href="product-details.php" class="link text-line-1">Taylor Farms Broccoli
                                                    Florets Vegetables</a>
                                            </h6>
                                            <div class="product-card__price flex-align gap-8">
                                                <span class="text-heading text-md fw-semibold d-block">$1500.00</span>
                                                <span class="text-gray-400 text-md fw-semibold d-block">$1500.00</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex-align gap-16">
                                        <div class="w-90 h-90 rounded-12 border border-gray-100 flex-shrink-0">
                                            <a href="product-details.php" class="link"><img
                                                    src="assets/images/product/sports-bra/PS-PULSE-SBRA-PINK/PS-PULSE-SBRA-PINK_2.JPG"
                                                    alt=""></a>
                                        </div>
                                        <div class="product-card__content mt-12">
                                            <div class="flex-align mb-20 mt-16 gap-6">
                                                <?php if ($reviewCount > 0): ?>
                                                    <span class="text-xs fw-medium text-gray-500">
                                                        <?= $formattedRating ?>
                                                    </span>
                                                    <span class="text-xs fw-medium text-warning-600 d-flex">
                                                        <i class="ph-fill ph-star"></i>
                                                    </span>
                                                    <span class="text-xs fw-medium text-gray-500">
                                                        (<?= $reviewCount ?>)
                                                    </span>
                                                <?php else: ?>
                                                    <span class="text-xs fw-medium text-gray-500">
                                                        No reviews yet
                                                    </span>
                                                <?php endif; ?>
                                            </div>
                                            <h6 class="title text-lg fw-semibold mt-8 mb-8">
                                                <a href="product-details.php" class="link text-line-1">Taylor Farms Broccoli
                                                    Florets Vegetables</a>
                                            </h6>
                                            <div class="product-card__price flex-align gap-8">
                                                <span class="text-heading text-md fw-semibold d-block">$1500.00</span>
                                                <span class="text-gray-400 text-md fw-semibold d-block">$1500.00</span>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="d-flex flex-column gap-44">
                                <?php
                                $counter = 0;
                                foreach ($resultProduct['data']['data'] as $key => $product):
                                    if ($counter >= 5) {
                                        break;
                                    }
                                    $counter++;

                                    // Find the primary image
                                    $primaryImage = null;
                                    foreach ($product['images'] as $image) {
                                        if ($image['isPrimary']) {
                                            $primaryImage = $image['imageUrl'];
                                            break;
                                        }
                                    }
                                    // Fallback to a placeholder image if no primary image is found
                                    $primaryImage = $primaryImage ?: 'assets/images/thumbs/product-img28.png';

                                    // Calculate discounted price
                                    $originalPrice = floatval($product['price']);
                                    $discountPercentage = floatval($product['discountValue']);
                                    $discountedPrice = $originalPrice * (1 - $discountPercentage / 100);

                                    // Calculate stock and sold percentage
                                    $remainingStock = intval($product['stock']);
                                    $sold = 18; // Assuming 18 sold as per static HTML
                                    $totalStock = $remainingStock + $sold; // Total stock = remaining + sold
                                    $soldPercentage = ($totalStock > 0) ? ($sold / $totalStock) * 100 : 0;


                                    // Calculate rating: Use average of review ratings if available, else use popularity
                                    $rating = 0;
                                    $reviewCount = 0;

                                    if (!empty($product['reviews'])) {
                                        $totalRating = 0;
                                        $validReviews = 0;

                                        foreach ($product['reviews'] as $review) {
                                            // Safely extract rating value
                                            if (isset($review['rating'])) {
                                                if (is_array($review['rating'])) {
                                                    // If rating is an array, try to get numeric value
                                                    $ratingValue = isset($review['rating']['value']) ? floatval($review['rating']['value']) : 0;
                                                } else {
                                                    // If rating is direct value
                                                    $ratingValue = floatval($review['rating']);
                                                }

                                                if ($ratingValue > 0) {
                                                    $totalRating += $ratingValue;
                                                    $validReviews++;
                                                }
                                            }
                                        }

                                        if ($validReviews > 0) {
                                            $rating = $totalRating / $validReviews;
                                            $reviewCount = $validReviews;
                                        }
                                    }

                                    // Fallback to popularity if no valid reviews
                                    if ($rating === 0) {
                                        $rating = ($product['popularity'] ?? 0) / 2;
                                        $reviewCount = 0; // No actual reviews, just using popularity
                                    }

                                    // Format rating to 1 decimal place
                                    $formattedRating = number_format($rating, 1);
                                    ?>
                                    <div class="flex-align gap-16">
                                        <div class="w-90 h-90 rounded-12 border border-gray-100 flex-shrink-0">
                                            <a href="<?= getenv("BASE_URL") . "/product/" . $utils->makeSlug($product['name']) ?>"
                                                class="link"><img src="<?= htmlspecialchars($primaryImage) ?>" alt=""></a>
                                        </div>
                                        <div class="product-card__content mt-12">
                                            <div class="flex-align mb-20 mt-16 gap-6">
                                                <?php if ($reviewCount > 0): ?>
                                                    <span class="text-xs fw-medium text-gray-500">
                                                        <?= $formattedRating ?>
                                                    </span>
                                                    <span class="text-xs fw-medium text-warning-600 d-flex">
                                                        <i class="ph-fill ph-star"></i>
                                                    </span>
                                                    <span class="text-xs fw-medium text-gray-500">
                                                        (<?= $reviewCount ?>)
                                                    </span>
                                                <?php else: ?>
                                                    <span class="text-xs fw-medium text-gray-500">
                                                        No reviews yet
                                                    </span>
                                                <?php endif; ?>
                                            </div>
                                            <h6 class="title text-lg fw-semibold mt-8 mb-8">
                                                <a href="<?= getenv("BASE_URL") . "/product/" . $utils->makeSlug($product['name']) ?>"
                                                    class="link text-line-1"><?= htmlspecialchars($product['name']) ?></a>
                                            </h6>
                                            <div class="product-card__price flex-align gap-8">
                                                <span
                                                    class="text-heading text-md fw-semibold d-block">₹<?= number_format($discountedPrice, 2) ?></span>
                                                <span
                                                    class="text-gray-400 text-md fw-semibold d-block">₹<?= number_format($discountedPrice, 2) ?></span>
                                            </div>
                                        </div>
                                    </div>

                                <?php endforeach; ?>

                                <?php if (empty($resultProduct['data']['data'])): ?>
                                    <div class="flex-align gap-16">
                                        <div class="w-90 h-90 rounded-12 border border-gray-100 flex-shrink-0">
                                            <a href="product-details.php" class="link"><img
                                                    src="assets/images/product/sports-bra/PS-PULSE-SBRA-PINK/PS-PULSE-SBRA-PINK_2.JPG"
                                                    alt=""></a>
                                        </div>
                                        <div class="product-card__content mt-12">
                                            <div class="flex-align mb-20 mt-16 gap-6">
                                                <?php if ($reviewCount > 0): ?>
                                                    <span class="text-xs fw-medium text-gray-500">
                                                        <?= $formattedRating ?>
                                                    </span>
                                                    <span class="text-xs fw-medium text-warning-600 d-flex">
                                                        <i class="ph-fill ph-star"></i>
                                                    </span>
                                                    <span class="text-xs fw-medium text-gray-500">
                                                        (<?= $reviewCount ?>)
                                                    </span>
                                                <?php else: ?>
                                                    <span class="text-xs fw-medium text-gray-500">
                                                        No reviews yet
                                                    </span>
                                                <?php endif; ?>
                                            </div>
                                            <h6 class="title text-lg fw-semibold mt-8 mb-8">
                                                <a href="product-details.php" class="link text-line-1">Taylor Farms Broccoli
                                                    Florets Vegetables</a>
                                            </h6>
                                            <div class="product-card__price flex-align gap-8">
                                                <span class="text-heading text-md fw-semibold d-block">$1500.00</span>
                                                <span class="text-gray-400 text-md fw-semibold d-block">$1500.00</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex-align gap-16">
                                        <div class="w-90 h-90 rounded-12 border border-gray-100 flex-shrink-0">
                                            <a href="product-details.php" class="link"><img
                                                    src="assets/images/product/sports-bra/PS-PULSE-SBRA-PINK/PS-PULSE-SBRA-PINK_2.JPG"
                                                    alt=""></a>
                                        </div>
                                        <div class="product-card__content mt-12">
                                            <div class="flex-align mb-20 mt-16 gap-6">
                                                <?php if ($reviewCount > 0): ?>
                                                    <span class="text-xs fw-medium text-gray-500">
                                                        <?= $formattedRating ?>
                                                    </span>
                                                    <span class="text-xs fw-medium text-warning-600 d-flex">
                                                        <i class="ph-fill ph-star"></i>
                                                    </span>
                                                    <span class="text-xs fw-medium text-gray-500">
                                                        (<?= $reviewCount ?>)
                                                    </span>
                                                <?php else: ?>
                                                    <span class="text-xs fw-medium text-gray-500">
                                                        No reviews yet
                                                    </span>
                                                <?php endif; ?>
                                            </div>
                                            <h6 class="title text-lg fw-semibold mt-8 mb-8">
                                                <a href="product-details.php" class="link text-line-1">Taylor Farms Broccoli
                                                    Florets Vegetables</a>
                                            </h6>
                                            <div class="product-card__price flex-align gap-8">
                                                <span class="text-heading text-md fw-semibold d-block">$1500.00</span>
                                                <span class="text-gray-400 text-md fw-semibold d-block">$1500.00</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex-align gap-16">
                                        <div class="w-90 h-90 rounded-12 border border-gray-100 flex-shrink-0">
                                            <a href="product-details.php" class="link"><img
                                                    src="assets/images/product/sports-bra/PS-PULSE-SBRA-RED/PS-PULSE-SBRA-RED_7.JPG"
                                                    alt=""></a>
                                        </div>
                                        <div class="product-card__content mt-12">
                                            <div class="flex-align mb-20 mt-16 gap-6">
                                                <?php if ($reviewCount > 0): ?>
                                                    <span class="text-xs fw-medium text-gray-500">
                                                        <?= $formattedRating ?>
                                                    </span>
                                                    <span class="text-xs fw-medium text-warning-600 d-flex">
                                                        <i class="ph-fill ph-star"></i>
                                                    </span>
                                                    <span class="text-xs fw-medium text-gray-500">
                                                        (<?= $reviewCount ?>)
                                                    </span>
                                                <?php else: ?>
                                                    <span class="text-xs fw-medium text-gray-500">
                                                        No reviews yet
                                                    </span>
                                                <?php endif; ?>
                                            </div>
                                            <h6 class="title text-lg fw-semibold mt-8 mb-8">
                                                <a href="product-details.php" class="link text-line-1">Taylor Farms Broccoli
                                                    Florets Vegetables</a>
                                            </h6>
                                            <div class="product-card__price flex-align gap-8">
                                                <span class="text-heading text-md fw-semibold d-block">$1500.00</span>
                                                <span class="text-gray-400 text-md fw-semibold d-block">$1500.00</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex-align gap-16">
                                        <div class="w-90 h-90 rounded-12 border border-gray-100 flex-shrink-0">
                                            <a href="product-details.php" class="link"><img
                                                    src="assets/images/product/sports-bra/PS-PULSE-SBRA-PINK/PS-PULSE-SBRA-PINK_2.JPG"
                                                    alt=""></a>
                                        </div>
                                        <div class="product-card__content mt-12">
                                            <div class="flex-align mb-20 mt-16 gap-6">
                                                <?php if ($reviewCount > 0): ?>
                                                    <span class="text-xs fw-medium text-gray-500">
                                                        <?= $formattedRating ?>
                                                    </span>
                                                    <span class="text-xs fw-medium text-warning-600 d-flex">
                                                        <i class="ph-fill ph-star"></i>
                                                    </span>
                                                    <span class="text-xs fw-medium text-gray-500">
                                                        (<?= $reviewCount ?>)
                                                    </span>
                                                <?php else: ?>
                                                    <span class="text-xs fw-medium text-gray-500">
                                                        No reviews yet
                                                    </span>
                                                <?php endif; ?>
                                            </div>
                                            <h6 class="title text-lg fw-semibold mt-8 mb-8">
                                                <a href="product-details.php" class="link text-line-1">Taylor Farms Broccoli
                                                    Florets Vegetables</a>
                                            </h6>
                                            <div class="product-card__price flex-align gap-8">
                                                <span class="text-heading text-md fw-semibold d-block">$1500.00</span>
                                                <span class="text-gray-400 text-md fw-semibold d-block">$1500.00</span>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xxl-3 col-lg-4 col-sm-6" data-aos="fade-up" data-aos-duration="900">
                    <div
                        class="product-card h-100 p-24 pt-32 border border-gray-100 hover-border-main-600 rounded-16 position-relative transition-2 group-item pt-32">
                        <button type="button" class="wishlist-btn-two">
                            <i class="ph-bold ph-heart"></i>
                        </button>

                        <div class="">
                            <h6 class="position-relative mb-0 pb-12 d-inline-block">Deals of the week</h6>
                            <div class="countdown mb-10" id="countdown26">
                                <ul class="countdown-list flex-align flex-wrap">
                                    <li
                                        class="countdown-list__item colon-red py-8 px-12 flex-align gap-4 text-sm fw-medium box-shadow-4xl rounded-5 bg-main-600 text-white">
                                        <span class="days"></span> D
                                    </li>
                                    <li
                                        class="countdown-list__item colon-red py-8 px-12 flex-align gap-4 text-sm fw-medium box-shadow-4xl rounded-5 bg-main-600 text-white">
                                        <span class="hours"></span> H
                                    </li>
                                    <li
                                        class="countdown-list__item colon-red py-8 px-12 flex-align gap-4 text-sm fw-medium box-shadow-4xl rounded-5 bg-main-600 text-white">
                                        <span class="minutes"></span> M
                                    </li>
                                    <li
                                        class="countdown-list__item colon-red py-8 px-12 flex-align gap-4 text-sm fw-medium box-shadow-4xl rounded-5 bg-main-600 text-white">
                                        <span class="seconds"></span> S
                                    </li>
                                </ul>
                            </div>
                            <p class="text-neutral-300 fw-medium text-sm">Don't miss this opportunity at a special</p>
                        </div>

                        <a href="product-details.php" class="product-card__thumb flex-center overflow-hidden">
                            <img src="assets/images/thumbs/product-img32.png" alt="">
                        </a>
                        <div class="product-card__content w-100">
                            <div class="flex-align gap-4">
                                <div class="flex-align gap-2 me-4">
                                    <span class="text-12 fw-medium text-warning-600 d-flex"><i
                                            class="ph-fill ph-star"></i></span>
                                    <span class="text-12 fw-medium text-warning-600 d-flex"><i
                                            class="ph-fill ph-star"></i></span>
                                    <span class="text-12 fw-medium text-warning-600 d-flex"><i
                                            class="ph-fill ph-star"></i></span>
                                    <span class="text-12 fw-medium text-warning-600 d-flex"><i
                                            class="ph-fill ph-star"></i></span>
                                    <span class="text-12 fw-medium text-warning-600 d-flex"><i
                                            class="ph-fill ph-star"></i></span>
                                </div>
                                <span class="text-xs fw-medium text-heading">(3)</span>
                            </div>
                            <div class="d-flex align-items-center gap-12 mt-6">
                                <h6 class="text-danger-600 mb-0 text-lg"> ₹60.99</h6>
                                <h6 class="text-neutral-300 fw-medium mb-0 text-lg">$79.99</h6>
                            </div>

                            <h6 class="title text-md fw-semibold mt-10 mb-0">
                                <a href="product-details.php" class="link text-line-2 fw-bold">Perfectly Packed Meat
                                    Combos for Delicious and Flavorful Meals Every Day</a>
                            </h6>
                            <p class="text-gray-500 text-sm mt-12 pb-12 border-bottom border-neutral-100 mb-8">This
                                product is about to run out</p>

                            <div class="progress w-100 bg-gray-100 rounded-pill h-8" role="progressbar"
                                aria-label="Basic example" aria-valuenow="35" aria-valuemin="0" aria-valuemax="100">
                                <div class="progress-bar bg-success-600 rounded-pill" style="width: 35%"></div>
                            </div>
                            <div class="d-flex align-items-center gap-6 mt-6">
                                <span class="text-sm text-gray-500">available only:</span>
                                <h6 class="text-danger-600 mb-0 text-md fw-semibold"> ₹60.99</h6>
                            </div>
                            <a href="cart.php"
                                class="product-card__cart btn bg-success-600 text-white hover-bg-success-700 hover-text-white py-11 px-24 rounded-pill flex-align gap-8 mt-16 w-100 justify-content-center">
                                Add To Cart <i class="ph ph-shopping-cart"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ========================== Short Product Section End ============================== -->

    <!-- ============================== Brand Section Start =============================== -->
    <div class="brand py-80 overflow-hidden">
        <div class="container container-lg">
            <div class="brand-inner p-24 rounded-16">
                <div class="section-heading">
                    <div class="flex-between flex-wrap gap-8">
                        <h5 class="mb-0 wow fadeInLeft">Shop by Brands</h5>
                        <div class="flex-align gap-16 wow fadeInRight">
                            <a href="<?= getenv('BASE_URL') . "/product" ?>"
                                class="text-sm fw-medium text-gray-700 hover-text-main-600 hover-text-decoration-underline">View
                                All Deals</a>
                            <div class="flex-align gap-8">
                                <button type="button" id="brand-prev"
                                    class="slick-prev slick-arrow flex-center rounded-circle border border-gray-100 hover-border-main-600 text-xl hover-bg-main-600 hover-text-white transition-1">
                                    <i class="ph ph-caret-left"></i>
                                </button>
                                <button type="button" id="brand-next"
                                    class="slick-next slick-arrow flex-center rounded-circle border border-gray-100 hover-border-main-600 text-xl hover-bg-main-600 hover-text-white transition-1">
                                    <i class="ph ph-caret-right"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="brand-slider arrow-style-two">/

                    <?php $duration = 200;
                    foreach ($resultBrands['data']['data'] as $brands): ?>
                        <div class="brand-item" data-aos="zoom-in" data-aos-duration="<?= $duration ?>">
                            <a href="<?= getenv('BASE_URL') . "/product/brand/" . $utils->makeSlug($brands['name']) ?>">
                                <img src="<?= $brands['logo'] ?>" alt="<?= $brands['name'] ?>">
                            </a>
                        </div>
                        <?php $duration += 200; endforeach; ?>

                    <?php if (empty($resultBrands)): ?>
                        <div class="brand-item" data-aos="zoom-in" data-aos-duration="200">
                            <img src="assets/images/thumbs/brand-img1.png" alt="">
                        </div>
                        <div class="brand-item" data-aos="zoom-in" data-aos-duration="400">
                            <img src="assets/images/thumbs/brand-img2.png" alt="">
                        </div>
                        <div class="brand-item" data-aos="zoom-in" data-aos-duration="600">
                            <img src="assets/images/thumbs/brand-img3.png" alt="">
                        </div>
                        <div class="brand-item" data-aos="zoom-in" data-aos-duration="800">
                            <img src="assets/images/thumbs/brand-img4.png" alt="">
                        </div>
                        <div class="brand-item" data-aos="zoom-in" data-aos-duration="1000">
                            <img src="assets/images/thumbs/brand-img5.png" alt="">
                        </div>
                        <div class="brand-item" data-aos="zoom-in" data-aos-duration="1200">
                            <img src="assets/images/thumbs/brand-img6.png" alt="">
                        </div>
                        <div class="brand-item" data-aos="zoom-in" data-aos-duration="1400">
                            <img src="assets/images/thumbs/brand-img7.png" alt="">
                        </div>
                        <div class="brand-item" data-aos="zoom-in" data-aos-duration="1600">
                            <img src="assets/images/thumbs/brand-img8.png" alt="">
                        </div>
                        <div class="brand-item" data-aos="zoom-in" data-aos-duration="1800">
                            <img src="assets/images/thumbs/brand-img3.png" alt="">
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <!-- ============================== Brand Section End =============================== -->

    <!-- ========================= best sells Start ================================ -->
    <section class="best sells pb-80">
        <div class="container container-lg">
            <div class="section-heading">
                <div class="flex-between flex-wrap gap-8">
                    <h5 class="mb-0 wow fadeInLeft">Daily Best Sells</h5>
                </div>
            </div>

            <div class="row g-12">
                <div class="col-xxl-8">
                    <div class="row gy-4 daily-best-sells">
                        <div class="col-md-6" data-aos="fade-up" data-aos-duration="200">
                            <div
                                class="product-card style-two h-100 p-8 border border-gray-100 hover-border-main-600 rounded-16 position-relative transition-2 flex-align gap-16">
                                <div class="">
                                    <span class="product-card__badge bg-danger-600 px-8 py-4 text-sm text-white">Sale
                                        50% </span>
                                    <a href="product-details.php"
                                        class="product-card__thumb flex-center overflow-hidden">
                                        <img src="assets/images/product/sports-bra/PS-PULSE-SBRA-PINK/PS-PULSE-SBRA-PINK_2.JPG"
                                            alt="">
                                    </a>
                                    <div class="countdown" id="countdown6">
                                        <ul class="countdown-list style-three flex-align flex-wrap">
                                            <li
                                                class="countdown-list__item text-heading flex-align gap-4 text-sm fw-medium">
                                                <span class="days"></span>Days
                                            </li>
                                            <li
                                                class="countdown-list__item text-heading flex-align gap-4 text-sm fw-medium">
                                                <span class="hours"></span>Hours
                                            </li>
                                            <li
                                                class="countdown-list__item text-heading flex-align gap-4 text-sm fw-medium">
                                                <span class="minutes"></span>Min
                                            </li>
                                            <li
                                                class="countdown-list__item text-heading flex-align gap-4 text-sm fw-medium">
                                                <span class="seconds"></span>Sec
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="product-card__content">
                                    <div class="product-card__price mb-16">
                                        <span class="text-gray-400 text-md fw-semibold text-decoration-line-through">
                                            $28.99</span>
                                        <span class="text-heading text-md fw-semibold ">$14.99 <span
                                                class="text-gray-500 fw-normal">/Qty</span> </span>
                                    </div>
                                    <div class="flex-align gap-6">
                                        <span class="text-xs fw-bold text-gray-600">4.8</span>
                                        <span class="text-15 fw-bold text-warning-600 d-flex"><i
                                                class="ph-fill ph-star"></i></span>
                                        <span class="text-xs fw-bold text-gray-600">(17k)</span>
                                    </div>
                                    <h6 class="title text-lg fw-semibold mt-12 mb-8">
                                        <a href="product-details.php" class="link text-line-2">Taylor Farms Broccoli
                                            Florets Vegetables</a>
                                    </h6>
                                    <div class="flex-align gap-4">
                                        <span class="text-main-600 text-md d-flex"><i
                                                class="ph-fill ph-storefront"></i></span>
                                        <span class="text-gray-500 text-xs">By Lucky Supermarket</span>
                                    </div>
                                    <div class="mt-12">
                                        <div class="progress w-100  bg-color-three rounded-pill h-4" role="progressbar"
                                            aria-label="Basic example" aria-valuenow="35" aria-valuemin="0"
                                            aria-valuemax="100">
                                            <div class="progress-bar bg-main-600 rounded-pill" style="width: 35%"></div>
                                        </div>
                                        <span class="text-gray-900 text-xs fw-medium mt-8">Sold: 18/35</span>
                                    </div>
                                    <a href="cart.php"
                                        class="product-card__cart btn bg-main-50 text-main-600 hover-bg-main-600 hover-text-white py-11 px-24 rounded-pill flex-align gap-8 mt-24 w-100 justify-content-center">
                                        Add To Cart <i class="ph ph-shopping-cart"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6" data-aos="fade-up" data-aos-duration="400">
                            <div
                                class="product-card style-two h-100 p-8 border border-gray-100 hover-border-main-600 rounded-16 position-relative transition-2 flex-align gap-16">
                                <div class="">
                                    <span class="product-card__badge bg-danger-600 px-8 py-4 text-sm text-white">Sale
                                        50% </span>
                                    <a href="product-details.php"
                                        class="product-card__thumb flex-center overflow-hidden">
                                        <img src="assets/images/product/shorts/dymamik_black/1 (1).jpg" alt="">
                                    </a>
                                    <div class="countdown" id="countdown7">
                                        <ul class="countdown-list style-three flex-align flex-wrap">
                                            <li
                                                class="countdown-list__item text-heading flex-align gap-4 text-sm fw-medium">
                                                <span class="days"></span>Days
                                            </li>
                                            <li
                                                class="countdown-list__item text-heading flex-align gap-4 text-sm fw-medium">
                                                <span class="hours"></span>Hours
                                            </li>
                                            <li
                                                class="countdown-list__item text-heading flex-align gap-4 text-sm fw-medium">
                                                <span class="minutes"></span>Min
                                            </li>
                                            <li
                                                class="countdown-list__item text-heading flex-align gap-4 text-sm fw-medium">
                                                <span class="seconds"></span>Sec
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="product-card__content">
                                    <div class="product-card__price mb-16">
                                        <span class="text-gray-400 text-md fw-semibold text-decoration-line-through">
                                            $28.99</span>
                                        <span class="text-heading text-md fw-semibold ">$14.99 <span
                                                class="text-gray-500 fw-normal">/Qty</span> </span>
                                    </div>
                                    <div class="flex-align gap-6">
                                        <span class="text-xs fw-bold text-gray-600">4.8</span>
                                        <span class="text-15 fw-bold text-warning-600 d-flex"><i
                                                class="ph-fill ph-star"></i></span>
                                        <span class="text-xs fw-bold text-gray-600">(17k)</span>
                                    </div>
                                    <h6 class="title text-lg fw-semibold mt-12 mb-8">
                                        <a href="product-details.php" class="link text-line-2">Taylor Farms Broccoli
                                            Florets Vegetables</a>
                                    </h6>
                                    <div class="flex-align gap-4">
                                        <span class="text-main-600 text-md d-flex"><i
                                                class="ph-fill ph-storefront"></i></span>
                                        <span class="text-gray-500 text-xs">By Lucky Supermarket</span>
                                    </div>
                                    <div class="mt-12">
                                        <div class="progress w-100  bg-color-three rounded-pill h-4" role="progressbar"
                                            aria-label="Basic example" aria-valuenow="35" aria-valuemin="0"
                                            aria-valuemax="100">
                                            <div class="progress-bar bg-main-600 rounded-pill" style="width: 35%"></div>
                                        </div>
                                        <span class="text-gray-900 text-xs fw-medium mt-8">Sold: 18/35</span>
                                    </div>
                                    <a href="cart.php"
                                        class="product-card__cart btn bg-main-50 text-main-600 hover-bg-main-600 hover-text-white py-11 px-24 rounded-pill flex-align gap-8 mt-24 w-100 justify-content-center">
                                        Add To Cart <i class="ph ph-shopping-cart"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6" data-aos="fade-up" data-aos-duration="200">
                            <div
                                class="product-card style-two h-100 p-8 border border-gray-100 hover-border-main-600 rounded-16 position-relative transition-2 flex-align gap-16">
                                <div class="">
                                    <span class="product-card__badge bg-danger-600 px-8 py-4 text-sm text-white">Sale
                                        50% </span>
                                    <a href="product-details.php"
                                        class="product-card__thumb flex-center overflow-hidden">
                                        <img src="assets/images/product/sports-bra/PS-PULSE-SBRA-GREEN/PS-PULSE-SBRA-GREEN_7.JPG"
                                            alt="">
                                    </a>
                                    <div class="countdown" id="countdown8">
                                        <ul class="countdown-list style-three flex-align flex-wrap">
                                            <li
                                                class="countdown-list__item text-heading flex-align gap-4 text-sm fw-medium">
                                                <span class="days"></span>Days
                                            </li>
                                            <li
                                                class="countdown-list__item text-heading flex-align gap-4 text-sm fw-medium">
                                                <span class="hours"></span>Hours
                                            </li>
                                            <li
                                                class="countdown-list__item text-heading flex-align gap-4 text-sm fw-medium">
                                                <span class="minutes"></span>Min
                                            </li>
                                            <li
                                                class="countdown-list__item text-heading flex-align gap-4 text-sm fw-medium">
                                                <span class="seconds"></span>Sec
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="product-card__content">
                                    <div class="product-card__price mb-16">
                                        <span class="text-gray-400 text-md fw-semibold text-decoration-line-through">
                                            $28.99</span>
                                        <span class="text-heading text-md fw-semibold ">$14.99 <span
                                                class="text-gray-500 fw-normal">/Qty</span> </span>
                                    </div>
                                    <div class="flex-align gap-6">
                                        <span class="text-xs fw-bold text-gray-600">4.8</span>
                                        <span class="text-15 fw-bold text-warning-600 d-flex"><i
                                                class="ph-fill ph-star"></i></span>
                                        <span class="text-xs fw-bold text-gray-600">(17k)</span>
                                    </div>
                                    <h6 class="title text-lg fw-semibold mt-12 mb-8">
                                        <a href="product-details.php" class="link text-line-2">Taylor Farms Broccoli
                                            Florets Vegetables</a>
                                    </h6>
                                    <div class="flex-align gap-4">
                                        <span class="text-main-600 text-md d-flex"><i
                                                class="ph-fill ph-storefront"></i></span>
                                        <span class="text-gray-500 text-xs">By Lucky Supermarket</span>
                                    </div>
                                    <div class="mt-12">
                                        <div class="progress w-100  bg-color-three rounded-pill h-4" role="progressbar"
                                            aria-label="Basic example" aria-valuenow="35" aria-valuemin="0"
                                            aria-valuemax="100">
                                            <div class="progress-bar bg-main-600 rounded-pill" style="width: 35%"></div>
                                        </div>
                                        <span class="text-gray-900 text-xs fw-medium mt-8">Sold: 18/35</span>
                                    </div>
                                    <a href="cart.php"
                                        class="product-card__cart btn bg-main-50 text-main-600 hover-bg-main-600 hover-text-white py-11 px-24 rounded-pill flex-align gap-8 mt-24 w-100 justify-content-center">
                                        Add To Cart <i class="ph ph-shopping-cart"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6" data-aos="fade-up" data-aos-duration="400">
                            <div
                                class="product-card style-two h-100 p-8 border border-gray-100 hover-border-main-600 rounded-16 position-relative transition-2 flex-align gap-16">
                                <div class="">
                                    <span class="product-card__badge bg-danger-600 px-8 py-4 text-sm text-white">Sale
                                        50% </span>
                                    <a href="product-details.php"
                                        class="product-card__thumb flex-center overflow-hidden">
                                        <img src="assets/images/product/sports-bra/PS-PULSE-SBRA-PINK/PS-PULSE-SBRA-PINK_1.JPG"
                                            alt="">
                                    </a>
                                    <div class="countdown" id="countdown9">
                                        <ul class="countdown-list style-three flex-align flex-wrap">
                                            <li
                                                class="countdown-list__item text-heading flex-align gap-4 text-sm fw-medium">
                                                <span class="days"></span>Days
                                            </li>
                                            <li
                                                class="countdown-list__item text-heading flex-align gap-4 text-sm fw-medium">
                                                <span class="hours"></span>Hours
                                            </li>
                                            <li
                                                class="countdown-list__item text-heading flex-align gap-4 text-sm fw-medium">
                                                <span class="minutes"></span>Min
                                            </li>
                                            <li
                                                class="countdown-list__item text-heading flex-align gap-4 text-sm fw-medium">
                                                <span class="seconds"></span>Sec
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="product-card__content">
                                    <div class="product-card__price mb-16">
                                        <span class="text-gray-400 text-md fw-semibold text-decoration-line-through">
                                            $28.99</span>
                                        <span class="text-heading text-md fw-semibold ">$14.99 <span
                                                class="text-gray-500 fw-normal">/Qty</span> </span>
                                    </div>
                                    <div class="flex-align gap-6">
                                        <span class="text-xs fw-bold text-gray-600">4.8</span>
                                        <span class="text-15 fw-bold text-warning-600 d-flex"><i
                                                class="ph-fill ph-star"></i></span>
                                        <span class="text-xs fw-bold text-gray-600">(17k)</span>
                                    </div>
                                    <h6 class="title text-lg fw-semibold mt-12 mb-8">
                                        <a href="product-details.php" class="link text-line-2">Taylor Farms Broccoli
                                            Florets Vegetables</a>
                                    </h6>
                                    <div class="flex-align gap-4">
                                        <span class="text-main-600 text-md d-flex"><i
                                                class="ph-fill ph-storefront"></i></span>
                                        <span class="text-gray-500 text-xs">By Lucky Supermarket</span>
                                    </div>
                                    <div class="mt-12">
                                        <div class="progress w-100  bg-color-three rounded-pill h-4" role="progressbar"
                                            aria-label="Basic example" aria-valuenow="35" aria-valuemin="0"
                                            aria-valuemax="100">
                                            <div class="progress-bar bg-main-600 rounded-pill" style="width: 35%"></div>
                                        </div>
                                        <span class="text-gray-900 text-xs fw-medium mt-8">Sold: 18/35</span>
                                    </div>
                                    <a href="cart.php"
                                        class="product-card__cart btn bg-main-50 text-main-600 hover-bg-main-600 hover-text-white py-11 px-24 rounded-pill flex-align gap-8 mt-24 w-100 justify-content-center">
                                        Add To Cart <i class="ph ph-shopping-cart"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xxl-4" data-aos="zoom-in" data-aos-duration="600">
                    <div class="position-relative rounded-16 bg-light-purple overflow-hidden p-28 z-1 h-100">
                        <div class="">
                            <img src="assets/images/bg/special-snacks.png" alt=""
                                class="position-absolute inset-block-start-0 inset-inline-start-0 z-n1 w-100 h-100 cover-img">
                        </div>
                        <div class="py-xl-4">
                            <div class="offer-card__logo mb-16 w-80 h-80 flex-center bg-white rounded-circle">
                                <img src="assets/images/thumbs/offer-logo.png" alt="">
                            </div>
                            <h5 class="mb-8">$5 off your first order</h5>
                            <div class="flex-align gap-8">
                                <span class="text-sm fw-medium text-heading">Delivery by 6:15am</span>
                                <span class="text-xs text-heading">Expire Aug 5</span>
                            </div>
                            <a href="shop.php"
                                class="mt-16 btn bg-success-600 hover-text-white hover-bg-success-700 text-white fw-medium d-inline-flex align-items-center rounded-pill gap-8"
                                tabindex="0">
                                Shop Now
                                <span class="icon text-xl d-flex"><i class="ph ph-arrow-right"></i></span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ========================= best sells End ================================ -->


    <!-- ================================ Newsletter new section Start ================================== -->
    <section class="newsletter-new">
        <div class="container container-lg">
            <div
                class="py-20 px-80-px bg-neutral-100 rounded-12 d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap gap-32">
                <div class="max-w-700">
                    <h3 class="mb-30">Stay home & get your daily needs from our shop</h3>
                    <form id="subscribed" action="" class="d-flex gap-8 flex-wrap flex-sm-nowrap">
                        <input type="text"
                            class="form-control bg-white px-20 shadow-none py-16 rounded placeholder-text-14 flex-grow-1"
                            name="email" placeholder="Enter your mail">
                        <button type="submit"
                            class="btn py-20 px-32 bg-success-600 flex-shrink-0 hover-bg-success-700 flex-grow-1">Subscribe
                            now</button>
                    </form>
                    <p class="text-heading text-sm mt-20 fw-medium">I agree that my submitted data is being collected
                        and stored.</p>
                </div>
                <div class="d-lg-block d-none">
                    <img src="assets/images/thumbs/newsletter-img.png" alt="Thumbnail">
                </div>

            </div>
        </div>
    </section>
    <!-- ================================ Newsletter new section End ================================== -->


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

            function makeSlug(string) {
                return string.toLowerCase().replace(/\s+/g, "-");
            }

            $.ajax({
                url: "<?php echo getenv('FETCH_ALL_PRODUCT_API') ?>",
                type: "get",
                success: function (response, textStatus, xhr) {

                },
                error: function (xhr) {
                    console.log("Error fetching products:", xhr);

                }
            });


            $.ajax({
                url: "<?php echo getenv('FETCH_ALL_PRODUCT_API') ?>",
                type: "get",
                success: function (response, textStatus, xhr) {
                    if (response.message === "All product data fetched with related category and unit" && response.data.length > 0) {
                        // Get the container for the product cards
                        const productCardsContainer = $('.daily-best-sells').first();
                        let productHtml = '';
                        let baseUrl = `<?= getenv("BASE_URL") ?>`;

                        // Limit to 4 products to match the static layout
                        const products = response.data.slice(0, 4);
                        let countdownId = 6;

                        products.forEach(product => {
                            // Calculate discounted price
                            const originalPrice = parseFloat(product.price);
                            const discountPercentage = product.discountValue || 0;
                            const discountedPrice = originalPrice - (originalPrice * discountPercentage / 100);

                            // Calculate progress bar
                            const totalStock = product.stock || 100;
                            const sold = Math.floor(totalStock * 0.35);
                            const progressPercentage = (sold / totalStock) * 100;

                            // Calculate rating and review count
                            let rating = 0;
                            let reviewCount = 0;

                            if (product.reviews && product.reviews.length > 0) {
                                let totalRating = 0;
                                let validReviews = 0;

                                product.reviews.forEach(review => {
                                    if (review.rating) {
                                        let ratingValue = 0;
                                        if (typeof review.rating === 'object' && review.rating.value) {
                                            ratingValue = parseFloat(review.rating.value);
                                        } else {
                                            ratingValue = parseFloat(review.rating);
                                        }

                                        if (ratingValue > 0) {
                                            totalRating += ratingValue;
                                            validReviews++;
                                        }
                                    }
                                });

                                if (validReviews > 0) {
                                    rating = totalRating / validReviews;
                                    reviewCount = validReviews;
                                }
                            }

                            // Fallback to popularity if no valid reviews
                            if (rating === 0) {
                                rating = (product.popularity || 0) / 2;
                                reviewCount = 0;
                            }

                            // Format rating to 1 decimal place
                            const formattedRating = rating.toFixed(1);

                            // Generate HTML for each product card
                            productHtml += `
                    <div class="col-md-6" data-aos="fade-up" data-aos-duration="${200 + (countdownId - 6) * 200}">
                        <div class="product-card style-two h-100 p-8 border border-gray-100 hover-border-main-600 rounded-16 position-relative transition-2 flex-align gap-16">
                            <div>
                                <span class="product-card__badge bg-danger-600 px-8 py-4 text-sm text-white">Sale ${discountPercentage}%</span>
                                <a href="${baseUrl + "/product/" + makeSlug(product.name)}" class="product-card__thumb flex-center overflow-hidden">
                                    <img src="${product.images[0]?.imageUrl || baseUrl + '/assets/images/thumbs/best-sell2.png'}" alt="${product.name}">
                                </a>
                                <div class="countdown" id="countdown${countdownId}">
                                    <ul class="countdown-list style-three flex-align flex-wrap">
                                        <li class="countdown-list__item text-heading flex-align gap-4 text-sm fw-medium">
                                            <span class="days"></span>Days
                                        </li>
                                        <li class="countdown-list__item text-heading flex-align gap-4 text-sm fw-medium">
                                            <span class="hours"></span>Hours
                                        </li>
                                        <li class="countdown-list__item text-heading flex-align gap-4 text-sm fw-medium">
                                            <span class="minutes"></span>Min
                                        </li>
                                        <li class="countdown-list__item text-heading flex-align gap-4 text-sm fw-medium">
                                            <span class="seconds"></span>Sec
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="product-card__content">
                                <div class="product-card__price mb-16">
                                    <span class="text-gray-400 text-md fw-semibold text-decoration-line-through">₹${originalPrice.toFixed(2)}</span>
                                    <span class="text-heading text-md fw-semibold">₹${discountedPrice.toFixed(2)} <span class="text-gray-500 fw-normal">/Qty</span></span>
                                </div>
                                <div class="flex-align gap-6">
                                    ${reviewCount > 0 ? `
                                        <span class="text-xs fw-medium text-gray-500">${formattedRating}</span>
                                        <span class="text-15 fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                                        <span class="text-xs fw-medium text-gray-500">(${reviewCount})</span>
                                    ` : `
                                        <span class="text-xs fw-medium text-gray-500">No reviews yet</span>
                                    `}
                                </div>
                                <h6 class="title text-lg fw-semibold mt-12 mb-8">
                                    <a href="${baseUrl + "/product/" + makeSlug(product.name)}" class="link text-line-2">${product.name}</a>
                                </h6>
                                <div class="flex-align gap-4">
                                    <span class="text-main-600 text-md d-flex"><i class="ph-fill ph-storefront"></i></span>
                                    <span class="text-gray-500 text-xs">By ${product.category?.name || 'Unknown'}</span>
                                </div>
                                <div class="mt-12">
                                    <div class="progress w-100 bg-color-three rounded-pill h-4" role="progressbar" aria-label="Basic example" aria-valuenow="${progressPercentage}" aria-valuemin="0" aria-valuemax="100">
                                        <div class="progress-bar bg-main-600 rounded-pill" style="width: ${progressPercentage}%"></div>
                                    </div>
                                    <span class="text-gray-900 text-xs fw-medium mt-8">Sold: ${sold}/${totalStock}</span>
                                </div>
                                <a href="javascript:void(0);" data-product-id="${product.id}" class="product-card__cart btn bg-main-50 text-main-600 hover-bg-main-600 hover-text-white py-11 px-24 rounded-pill flex-align gap-8 mt-24 w-100 justify-content-center add-to-cart">
                                    Add To Cart <i class="ph ph-shopping-cart"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                `;
                            countdownId++;
                        });

                        // Update the product cards container
                        productCardsContainer.html(productHtml);

                        // Initialize countdown timers
                        products.forEach((product, index) => {
                            const expiryDate = new Date(product.expiryDate).getTime();
                            const countdownElement = document.getElementById(`countdown${6 + index}`);
                            if (countdownElement) {
                                const updateCountdown = () => {
                                    const now = new Date().getTime();
                                    const distance = expiryDate - now;

                                    if (distance < 0) {
                                        return;
                                    }

                                    const days = Math.floor(distance / (1000 * 60 * 60 * 24));
                                    const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                                    const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                                    const seconds = Math.floor((distance % (1000 * 60)) / 1000);

                                    countdownElement.querySelector('.days').textContent = days;
                                    countdownElement.querySelector('.hours').textContent = hours;
                                    countdownElement.querySelector('.minutes').textContent = minutes;
                                    countdownElement.querySelector('.seconds').textContent = seconds;
                                };

                                updateCountdown();
                                setInterval(updateCountdown, 1000);
                            }
                        });
                    } else {
                        console.log("No products found in the response.");
                        $('.row.gy-4').first().html('<p>No products available.</p>');
                    }
                },
                error: function (xhr) {
                    console.log("Error fetching products:", xhr);
                    $('.row.gy-4').first().html('<p>Failed to load products. Please try again later.</p>');
                }
            });

            $.ajax({
                url: "<?php echo getenv("FETCH_ALL_PRODUCT_CATEGORY_API") ?>",
                type: "get",
                success: function (response, textStatus, xhr) {
                    if (response.data.length > 0) {

                    } else {
                        console.log("No products found in the response.");
                        // Display a fallback message in all sections
                        $('.short-product-list').each(function () {
                            $(this).html('<p>No products available.</p>');
                        });
                    }
                },
                error: function (xhr) {
                    console.log(xhr);
                },
            });

            // $.ajax({
            //     url: "<?php //echo getenv('FETCH_ALL_BRAND_API') ?>",
            //     type: "get",
            //     success: function (response) {
            //         const brands = response.data;
            //         console.log("Brands received:", brands);

            //         const brandSlider = $(".brand-slider.arrow-style-two");
            //         brandSlider.empty();

            //         let duration = 200;


            //         brands.forEach((brand, index) => {
            //             const brandItem = `
            //             <div class="brand-item" data-aos="zoom-in" data-aos-duration="${duration}">
            //                 <img src="${brand.logo}" alt="Brand ${brand.id}">
            //             </div>
            //         `;

            //             duration += 200;
            //             brandSlider.append(brandItem);

            //             console.log(duration);

            //         });


            //     },
            //     error: function (xhr, status, error) {
            //         console.error("AJAX Error:", error);
            //     }
            // });





            $.ajax({
                url: "<?php echo getenv("FETCH_ALL_MEDIA_API") ?>",
                type: "get",
                success: function (response, textStatus, xhr) {

                    if (response.data && Array.isArray(response.data)) {

                        const logoItems = response.data.filter(item => item.category === "LOGO");
                        logoItems.forEach(item => {
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




            const notyf = new Notyf({
                duration: 3000,
                position: { x: 'right', y: 'top' },
                types: [
                    {
                        type: 'success',
                        background: '#4dc76f',
                        textColor: '#FFFFFF',
                        dismissible: false
                    },
                    {
                        type: 'error',
                        background: '#ff1916',
                        textColor: '#FFFFFF',
                        dismissible: false,
                        duration: 4000
                    }
                ]
            });

            $(document).on("submit", "#subscribed", function (e) {
                e.preventDefault();
                let email = $("#subscribed input[name=email]").val();

                $.ajax({
                    url: "<?php echo $subscribeNewsLetterApi ?>",
                    type: "post",
                    data: { email: email },
                    success: function (response, textStatus, xhr) {
                        if (xhr.status === 201) {
                            notyf.success(response.message ? response.message : "News-letter Subscribed");
                        } else if (xhr.status === 409) {
                            notyf.error(response.message ? response.message : "Email already subscribed.");
                        } else {
                            notyf.error("Something went wrong.");
                        }
                    },
                    error: function (xhr) {
                        console.log(xhr);

                        if (xhr.status === 409) {
                            notyf.error(xhr.responseJSON?.message || "Email already subscribed.");
                        } else if (xhr.status === 400) {
                            notyf.error(xhr.responseJSON?.message || "Invalid email address.");
                        } else {
                            notyf.error("Server error or invalid request.");
                        }
                    },
                });
            });

            $(document).on("click", ".add-to-cart", function (e) {
                e.preventDefault();

                // Get the product ID from data attribute
                let productId = $(this).data("product-id");
                console.log('Adding product ID:', productId);

                // Retrieve existing cart from localStorage or initialize empty array
                let cart = JSON.parse(localStorage.getItem('cart')) || [];

                // Add productId to cart if not already present
                if (productId && !cart.includes(productId)) {
                    cart.push(productId);
                    // Save updated cart to localStorage
                    localStorage.setItem('cart', JSON.stringify(cart));
                    console.log('Updated cart:', cart);

                    // Show success message using SweetAlert
                    Swal.fire({
                        title: 'Added to Cart',
                        text: 'Product added to cart successfully!',
                        icon: 'success',
                        confirmButtonText: 'Continue Shopping'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Optional: Redirect or refresh if needed
                            // window.location.href = '';
                        }
                    });
                } else if (cart.includes(productId)) {
                    // Show warning if product is already in cart
                    Swal.fire({
                        title: 'Already in Cart',
                        text: 'This product is already in your cart!',
                        icon: 'info',
                        confirmButtonText: 'Continue Shopping'
                    });
                } else {
                    // Show error if productId is invalid
                    Swal.fire({
                        title: 'Error',
                        text: 'Unable to add product to cart. Invalid product ID.',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                }
            });

            let productIdsCart = JSON.parse(localStorage.getItem('cart')) || [];
            // Always update count directly
            $(".cart-item-count").text(productIdsCart.length);

            let productIdsWishlist = JSON.parse(localStorage.getItem('wishlist')) || [];
            // Always update count directly
            $(".wishlist-item-count").text(productIdsWishlist.length);

        });

    </script>



</body>

</html>