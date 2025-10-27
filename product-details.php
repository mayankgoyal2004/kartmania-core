<?php 
session_start();
require __DIR__ . "/api/api.php";
error_reporting(E_ALL);
ini_set("", 1);
require __DIR__ . "/utils/utils.php";

$utils = new Utils;

$urlPath = $_SERVER['REQUEST_URI'];
$segments = explode('/', trim($urlPath, '/'));
$slug = end($segments);

$fetchAllProductApi = getenv("FETCH_ALL_PRODUCT_BY_NAME_API") . "/" . $slug;
$fetchAllProductCategoryApi = getenv("FETCH_ALL_PRODUCT_CATEGORY_API");
$fetchAllProductsApi = getenv("FETCH_ALL_PRODUCT_API");
$allProducts = $utils->fetchFromApi($fetchAllProductsApi);



$resultProduct = $utils->fetchFromApi($fetchAllProductApi);
$resultProductCategory = $utils->fetchFromApi($fetchAllProductCategoryApi);

// products data by group 
$fetchAllProductByGroupApi = getenv("FETCH_ALL_PRODUCT_BY_GROUP_API") . "/" . ($resultProduct['data']['data']['groupId'] ?? 0);
$resultProductByGroup = $utils->fetchFromApi($fetchAllProductByGroupApi);

// Initialize
$variants = $resultProductByGroup['data']['data']['variants'] ?? [];
$colors = [];
$sizes = [];

// Get color and size from URL
$selectedColor = $_GET['color'] ?? '';
$selectedSize = $_GET['size'] ?? '';

// Step 1: Collect all unique colors
foreach ($variants as $variant) {
    if (!empty($variant['color']) && !in_array($variant['color'], $colors)) {
        $colors[] = $variant['color'];
    }
}

// Step 2: Default to first color if none selected
if (empty($selectedColor) && !empty($colors)) {
    $selectedColor = $colors[0];
}

// Step 3: Collect sizes only for the selected color
$sizes = [];
foreach ($variants as $variant) {
    if (strtolower($variant['color']) === strtolower($selectedColor) && !in_array($variant['size'], $sizes)) {
        $sizes[] = $variant['size'];
    }
}

// Step 4: Default to first size of that color if none selected
if (empty($selectedSize) && !empty($sizes)) {
    $selectedSize = $sizes[0];
}

// Step 5: Find the current variant based on color and size
$currentVariant = null;
foreach ($variants as $variant) {
    if (
        strtolower($variant['color']) === strtolower($selectedColor) &&
        $variant['size'] === $selectedSize
    ) {
        $currentVariant = $variant;
        break;
    }
}

// Step 6: Fallback if no match found
if (!$currentVariant && !empty($variants)) {
    $currentVariant = $variants[0];
    $selectedColor = $currentVariant['color'] ?? '';
    $selectedSize = $currentVariant['size'] ?? '';
}

// Prepare product grouping data
$productsGroupingData = [];
foreach ($resultProductByGroup['data']['data'] as $groupId => $productsArray) {
    $productsGroupingData = $productsArray;
}

// Attributes
$attributes = [];
foreach ($resultProduct['data']['data']['attributes'] as $key => $value) {
    $attributes = $value;
}

$price = 0.0;

// Prefer variant price, then mainProduct price, then product fallback
if (!empty($currentVariant['price']) || $currentVariant['price'] === '0') {
    $price = floatval($currentVariant['price']);
} elseif (!empty($resultProductByGroup['data']['data']['mainProduct']['price']) || $resultProductByGroup['data']['data']['mainProduct']['price'] === '0') {
    $price = floatval($resultProductByGroup['data']['data']['mainProduct']['price']);
} elseif (!empty($resultProduct['data']['data']['price']) || $resultProduct['data']['data']['price'] === '0') {
    $price = floatval($resultProduct['data']['data']['price']);
}

// Save original price for display
$originalPrice = $price;

// Calculate discounted price
// Calculate discounted price
$discountValue = 0;
$discountType = '';
$discountedPrice = $price; // default same as price

// Step 1: Find discount type & value (variant > mainProduct > fallback)
if (isset($currentVariant['discountValue']) && $currentVariant['discountValue'] !== '') {
    $discountValue = floatval($currentVariant['discountValue']);
    $discountType = strtoupper($currentVariant['discount'] ?? '');
} elseif (isset($resultProductByGroup['data']['data']['mainProduct']['discountValue']) && $resultProductByGroup['data']['data']['mainProduct']['discountValue'] !== '') {
    $discountValue = floatval($resultProductByGroup['data']['data']['mainProduct']['discountValue']);
    $discountType = strtoupper($resultProductByGroup['data']['data']['mainProduct']['discount'] ?? '');
} elseif (isset($resultProduct['data']['data']['discountValue']) && $resultProduct['data']['data']['discountValue'] !== '') {
    $discountValue = floatval($resultProduct['data']['data']['discountValue']);
    $discountType = strtoupper($resultProduct['data']['data']['discount'] ?? '');
}

// Step 2: Calculate discounted price
if ($discountValue > 0) {
    if ($discountType === 'CASH') {
        // Discount is in rupees
        $discountedPrice = max(0, $price - $discountValue);
    } elseif ($discountType === 'PERCENTAGE') {
        // Discount is percentage
        $discountedPrice = max(0, $price - ($price * $discountValue / 100));
    }
}

// Format for display (optional)
$originalPriceDisplay   = number_format($originalPrice, 2, '.', '');
$discountedPriceDisplay = number_format($discountedPrice, 2, '.', '');


$similarProducts = [];
if (isset($allProducts['data']['data']) && is_array($allProducts['data']['data'])) {
    $similarProducts = array_filter($allProducts['data']['data'], function($product) use ($resultProduct) {
        return $product['id'] != $resultProduct['data']['data']['id'];
    });

    // Sort by popularity in descending order
    usort($similarProducts, function($a, $b) {
        return ($b['popularity'] ?? 0) - ($a['popularity'] ?? 0);
    });

    // Take only first 4 products
    $similarProducts = array_slice($similarProducts, 0, 10);
}





// Calculate rating
$reviews = [];
if (!empty($resultProductByGroup['data']['data']['mainProduct']['reviews'])) {
    $reviews = $resultProductByGroup['data']['data']['mainProduct']['reviews'];
} elseif (!empty($resultProduct['data']['data']['reviews'])) {
    $reviews = $resultProduct['data']['data']['reviews'];
}

// Calculate rating
$rating = 0;
if (!empty($reviews)) {
    $totalRating = array_sum(array_column($reviews, 'rating'));
    $rating = $totalRating / count($reviews);
}

// Optional: default rating fallback
else {
    $rating = ($resultProductByGroup['data']['data']['mainProduct']['popularity'] ?? 0) / 2;
}


?>

<!DOCTYPE html>

<!DOCTYPE html>
<html lang="en" class="color-two font-exo header-style-two">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Title -->
    <title> <?= htmlspecialchars($resultProduct['data']['data']['name']) ?></title>
    <!-- Favicon -->
    <link rel="shortcut icon" href="<?= getenv("BASE_URL") . "/assets/" ?>images/logo/favicon.png">

    <!-- Bootstrap -->
    <link rel="stylesheet" href="<?= getenv("BASE_URL") . "/assets/" ?>css/bootstrap.min.css">
    <!-- select 2 -->
    <link rel="stylesheet" href="<?= getenv("BASE_URL") . "/assets/" ?>css/select2.min.css">
    <!-- Slick -->
    <link rel="stylesheet" href="<?= getenv("BASE_URL") . "/assets/" ?>css/slick.css">
    <!-- Jquery Ui -->
    <link rel="stylesheet" href="<?= getenv("BASE_URL") . "/assets/" ?>css/jquery-ui.css">
    <!-- animate -->
    <link rel="stylesheet" href="<?= getenv("BASE_URL") . "/assets/" ?>css/animate.css">
    <!-- AOS Animation -->
    <link rel="stylesheet" href="<?= getenv("BASE_URL") . "/assets/" ?>css/aos.css">
    <!-- Main css -->
    <link rel="stylesheet" href="<?= getenv("BASE_URL") . "/assets/" ?>css/main.css">
    <!-- js-image-zoom -->
    <script src="https://unpkg.com/js-image-zoom@0.4.1/js-image-zoom.js" type="application/javascript"></script>
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
        <img src="<?= getenv("BASE_URL") . "/assets/" ?>images/icon/preloader.gif" alt="">
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
                <h6 class="mb-0">Product Details</h6>
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
                    <li class="text-sm text-main-600"> <?= htmlspecialchars($resultProduct['data']['data']['name']) ?>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <!-- ========================= Breadcrumb End =============================== -->

    <!-- ========================== Product Details Two Start =========================== -->
    <section class="product-details py-80">
        <div class="container container-lg">
            <div class="row gy-4">
                <div class="col-xl-9">
                    <div class="row gy-4">
                        <div class="col-xl-6">
                            <div class="product-details__left">

                               <div class="product-details__thumb-slider border border-gray-100 rounded-16">
    <?php 
    $displayImages = $currentVariant['images'] ?? $resultProduct['data']['data']['images'];
    foreach ($displayImages as $key => $image): ?>
        <div class="">
            <div class="product-details__thumb flex-center h-100">
                <img src="<?= htmlspecialchars($image['imageUrl']) ?>" alt="">
            </div>
        </div>
    <?php endforeach; ?>

    <?php if (empty($displayImages)): ?>
        <!-- Your fallback images here -->
    <?php endif; ?>
</div>
  <div class="mt-24">
        <div class="product-details__images-slider">
            <?php 
            if (!empty($displayImages)):
                foreach ($displayImages as $image): ?>
                    <div>
                        <div class="max-w-120 max-h-120 h-100 flex-center border border-gray-100 rounded-16 p-8">
                            <img src="<?= htmlspecialchars($image['imageUrl']) ?>" alt="">
                        </div>
                    </div>
                <?php endforeach;
            else: ?>
                <!-- Fallback thumbnails -->
                <div><div class="max-w-120 max-h-120 h-100 flex-center border border-gray-100 rounded-16 p-8"><img src="<?= getenv("BASE_URL") ?>/assets/images/thumbs/product-details-two-thumb1.png" alt=""></div></div>
                <div><div class="max-w-120 max-h-120 h-100 flex-center border border-gray-100 rounded-16 p-8"><img src="<?= getenv("BASE_URL") ?>/assets/images/thumbs/product-details-two-thumb2.png" alt=""></div></div>
                <div><div class="max-w-120 max-h-120 h-100 flex-center border border-gray-100 rounded-16 p-8"><img src="<?= getenv("BASE_URL") ?>/assets/images/thumbs/product-details-two-thumb3.png" alt=""></div></div>
            <?php endif; ?>
        </div>
    </div>
                            </div>
                        </div>
                        <div class="col-xl-6">
                            <div class="product-details__content">

                                <div
                                    class="flex-center mb-24 flex-wrap gap-16 bg-color-one rounded-8 py-16 px-24 position-relative z-1">
                                    <img src="<?= getenv("BASE_URL") . "/assets/" ?>images/bg/details-offer-bg.png"
                                        alt=""
                                        class="position-absolute inset-block-start-0 inset-inline-start-0 w-100 h-100 z-n1">
                                    <div class="flex-align gap-16">
                                        <span class="text-white text-sm">Special Offer:</span>
                                    </div>
                                    <div class="countdown" id="countdown11">
                                        <ul class="countdown-list flex-align flex-wrap">
                                            <li
                                                class="countdown-list__item text-heading flex-align gap-4 text-xs fw-medium w-28 h-28 rounded-4 border border-main-600 p-0 flex-center">
                                                <span class="days"></span>
                                            </li>
                                            <li
                                                class="countdown-list__item text-heading flex-align gap-4 text-xs fw-medium w-28 h-28 rounded-4 border border-main-600 p-0 flex-center">
                                                <span class="hours"></span>
                                            </li>
                                            <li
                                                class="countdown-list__item text-heading flex-align gap-4 text-xs fw-medium w-28 h-28 rounded-4 border border-main-600 p-0 flex-center">
                                                <span class="minutes"></span>
                                            </li>
                                            <li
                                                class="countdown-list__item text-heading flex-align gap-4 text-xs fw-medium w-28 h-28 rounded-4 border border-main-600 p-0 flex-center">
                                                <span class="seconds"></span>
                                            </li>
                                        </ul>
                                    </div>
                                    <span class="text-white text-xs">Remains untill the end of the offer</span>
                                </div>

                                <h5 class="mb-12"><?= htmlspecialchars($resultProduct['data']['data']['name']) ?>
                                </h5>
                                <div class="flex-align flex-wrap gap-12">
                                    <div class="flex-align gap-12 flex-wrap">
                                        <div class="flex-align gap-8">
                                           <?php
            $ratingValue = round($rating ?? 0); // round average rating to nearest integer
            for ($i = 1; $i <= 5; $i++):
                if ($i <= $ratingValue):
            ?>
                <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
            <?php else: ?>
                <span class="text-xs fw-medium text-gray-400 d-flex"><i class="ph-fill ph-star"></i></span>
            <?php endif; endfor; ?>
                                        </div>
                                       <span class="text-sm fw-medium text-neutral-600"><?= number_format($rating ?? 0, 1); ?> Star Rating</span>
        <span class="text-sm fw-medium text-gray-500">(<?= count($reviews ?? []); ?> Reviews)</span>
                                    </div>
                                    <span class="text-sm fw-medium text-gray-500">|</span>
                                   <span class="text-gray-900">
    <span class="text-gray-400">SKU:</span>
    <span id="product-sku"><?= htmlspecialchars($currentVariant['sku'] ?? $resultProduct['data']['data']['sku']) ?></span>
</span>
                                </div>
                                <span class="mt-32 pt-32 text-gray-700 border-top border-gray-100 d-block"></span>
                             <p class="text-gray-700">
    <?= htmlspecialchars(
        isset($currentVariant['description']) && !empty($currentVariant['description']) 
            ? $currentVariant['description'] 
            : $resultProduct['data']['data']['description'] ?? "No description available."
    ) ?>
</p>


                                <div class="my-32 flex-align gap-16 flex-wrap">
    <div class="flex-align gap-8">
        <?php if ($discountValue > 0): ?>
            <div class="flex-align gap-8 text-main-two-600">
                <i class="ph-fill ph-seal-percent text-xl"></i>
                -<?= htmlspecialchars($discountValue) ?>
                <?= ($discountType === 'PERCENTAGE') ? '%' : '₹' ?>
            </div>
        <?php endif; ?>

        <h6 class="mb-0">Rs <?= htmlspecialchars($discountedPriceDisplay) ?></h6>
    </div>

    <?php if ($discountedPrice < $originalPrice): ?>
        <div class="flex-align gap-8">
            <span class="text-gray-700">Regular Price</span>
            <h6 class="text-xl text-gray-400 mb-0 fw-medium text-decoration-line-through">
                Rs <?= htmlspecialchars($originalPriceDisplay) ?>
            </h6>
        </div>
    <?php endif; ?>
</div>


                                <div class="my-32 flex-align flex-wrap gap-12">
                                    <a href="#"
                                        class="px-12 py-8 text-sm rounded-8 flex-align gap-8 text-gray-900 border border-gray-200 hover-border-main-600 hover-text-main-600">
                                        Monthyly EMI USD 15.00
                                        <i class="ph ph-caret-right"></i>
                                    </a>
                                    <a href="#"
                                        class="px-12 py-8 text-sm rounded-8 flex-align gap-8 text-gray-900 border border-gray-200 hover-border-main-600 hover-text-main-600">
                                        Shipping Charge
                                        <i class="ph ph-caret-right"></i>
                                    </a>
                                    <a href="#"
                                        class="px-12 py-8 text-sm rounded-8 flex-align gap-8 text-gray-900 border border-gray-200 hover-border-main-600 hover-text-main-600">
                                        Security & Privacy
                                        <i class="ph ph-caret-right"></i>
                                    </a>
                                </div>

                                <span class="mt-32 pt-32 text-gray-700 border-top border-gray-100 d-block"></span>

                            <div class="mt-32">
    <h6 class="mb-16">Quick Overview</h6>
    <div class="flex flex-col gap-16">                                                   

        <!-- Colors --> 
        <div>
            <span class="text-gray-900 d-block mb-12">
                Color: <span class="fw-medium"><?= htmlspecialchars($selectedColor) ?></span>
            </span>
            <div class="color-list flex-align gap-8">
                <?php foreach ($colors as $color): ?>
                    <?php
                        $colorClass = '';
                        switch (strtolower($color)) {
                            case 'green': $colorClass = 'bg-success-600'; break;
                            case 'pink': $colorClass = 'bg-pink-500'; break;
                            case 'blue': $colorClass = 'bg-info-600'; break;
                            case 'red': $colorClass = 'bg-danger-600'; break;
                            case 'black': $colorClass = 'bg-gray-900'; break;
                            case 'white': $colorClass = 'bg-gray-100 border border-gray-300'; break;
                            default: $colorClass = 'bg-gray-400'; break;
                        }
                        $isSelected = strtolower($selectedColor) === strtolower($color);
                    ?>
                    <a href="?color=<?= urlencode($color) ?>&size=<?= urlencode($selectedSize) ?>"
                       class="color-list__button w-20 h-20 border-2 rounded-circle <?= $colorClass ?> <?= $isSelected ? 'border-main-600' : 'border-gray-200' ?>">
                    </a>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Sizes -->
        <div>
            <span class="text-gray-900 d-block mb-12">
                Size: <span class="fw-medium"><?= htmlspecialchars($selectedSize) ?></span>
            </span>
            <div class="flex-align gap-8 flex-wrap">
                <?php foreach ($sizes as $size): ?>
                    <?php $isSelectedSize = $selectedSize === $size; ?>
                    <a href="?color=<?= urlencode($selectedColor) ?>&size=<?= urlencode($size) ?>"
                       class="px-12 py-8 text-sm rounded-8 text-gray-900 border <?= $isSelectedSize ? 'border-main-600 bg-main-50 text-main-600' : 'border-gray-200 hover-border-main-600 hover-text-main-600' ?>">
                        <?= htmlspecialchars($size) ?>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>

    </div>
</div>


                                <span class="mt-32 pt-32 text-gray-700 border-top border-gray-100 d-block"></span>

                                <a href="https://www.whatsapp.com/"
                                    class="btn btn-black flex-center gap-8 rounded-8 py-16">
                                    <i class="ph ph-whatsapp-logo text-lg"></i>
                                    Request More Information
                                </a>

                                <div class="mt-32">
                                    <span class="fw-medium text-gray-900">100% Guarantee Safe Checkout</span>
                                    <div class="mt-10">
                                        <img src="<?= getenv("BASE_URL") . "/assets/" ?>images/thumbs/gateway-img.png"
                                            alt="">
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3">
                    <div class="product-details__sidebar py-40 px-32 border border-gray-100 rounded-16">
                        <div class="mb-32">
                            <label for="delivery"
                                class="h6 activePage mb-8 text-heading fw-semibold d-block">Delivery</label>
                            <div class="flex-align border border-gray-100 rounded-4 px-16">
                                <span class="text-xl d-flex text-main-600">
                                    <i class="ph ph-map-pin"></i>
                                </span>
                                <select class="common-input border-0 px-8 rounded-4" id="delivery">
                                    <option value="1">Maymansign</option>
                                    <option value="1">Khulna</option>
                                    <option value="1">Rajshahi</option>
                                    <option value="1">Rangpur</option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-32">
                           <label for="stock" class="text-lg mb-8 text-heading fw-semibold d-block">
    Total Stock: <span id="total-stock"><?= htmlspecialchars($currentVariant['stock'] ?? 0) ?></span>
</label>
                            <span class="text-xl d-flex">
                                <i class="ph ph-location"></i>
                            </span>
                            <div class="d-flex rounded-4 overflow-hidden">
                                <button type="button"
                                    class="quantity__minus flex-shrink-0 h-48 w-48 text-neutral-600 bg-gray-50 flex-center hover-bg-main-600 hover-text-white">
                                    <i class="ph ph-minus"></i>
                                </button>
                                <input type="number"
                                    class="quantity__input flex-grow-1 border border-gray-100 border-start-0 border-end-0 text-center w-32 px-16"
                                    id="stock" value="1" min="1">
                                <button type="button"
                                    class="quantity__plus flex-shrink-0 h-48 w-48 text-neutral-600 bg-gray-50 flex-center hover-bg-main-600 hover-text-white">
                                    <i class="ph ph-plus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="mb-32">
                          <div class="flex-between flex-wrap gap-8 border-bottom border-gray-100 pb-16 mb-16">
    <span class="text-gray-500">Price</span>
    <h6 class="text-lg mb-0">
        ₹<?= isset($discountedPrice) ? number_format($discountedPrice, 2) : '32000.00' ?></h6>
</div>
                            <div class="flex-between flex-wrap gap-8">
                                <span class="text-gray-500">Shipping</span>
                                <h6 class="text-lg mb-0">From ₹10.00</h6>
                            </div>
                        </div>

                        <a href="javascript:void(0);"
                            data-product-id="<?= htmlspecialchars($currentVariant['id'] ?? $resultProduct['data']['data']['id']) ?>"
                            class="btn btn-main flex-center gap-8 rounded-8 py-16 fw-normal mt-48 add-to-cart">
                            <i class="ph ph-shopping-cart-simple text-lg"></i>
                            Add To Cart
                        </a>
                        <a href="checkout.php?id=<?= htmlspecialchars($currentVariant['id'] ?? $resultProduct['data']['data']['id']) ?>"
                            class="btn btn-outline-main rounded-8 py-16 fw-normal mt-16 w-100">
                            Buy Now
                        </a>

                        <div class="mt-32">
                            <div class="px-16 py-8 bg-main-50 rounded-8 flex-between gap-24 mb-14">
                                <span
                                    class="w-32 h-32 bg-white text-main-600 rounded-circle flex-center text-xl flex-shrink-0">
                                    <i class="ph-fill ph-truck"></i>
                                </span>
                                <span class="text-sm text-neutral-600">Ship from <span
                                        class="fw-semibold">MarketPro</span> </span>
                            </div>
                            <div class="px-16 py-8 bg-main-50 rounded-8 flex-between gap-24 mb-0">
                                <span
                                    class="w-32 h-32 bg-white text-main-600 rounded-circle flex-center text-xl flex-shrink-0">
                                    <i class="ph-fill ph-storefront"></i>
                                </span>
                                <span class="text-sm text-neutral-600">Sold by: <span class="fw-semibold">MR
                                        Distribution LLC</span> </span>
                            </div>
                        </div>

                        <div class="mt-32">
                            <div class="px-32 py-16 rounded-8 border border-gray-100 flex-between gap-8">
                                <a href="#" class="d-flex text-main-600 text-28"><i
                                        class="ph-fill ph-chats-teardrop"></i></a>
                                <span class="h-26 border border-gray-100"></span>

                                <div class="dropdown on-hover-item">
                                    <button class="d-flex text-main-600 text-28" type="button">
                                        <i class="ph-fill ph-share-network"></i>
                                    </button>
                                    <div
                                        class="on-hover-dropdown common-dropdown border-0 inset-inline-start-auto inset-inline-end-0">
                                        <ul class="flex-align gap-16">
                                            <li>
                                                <a href="https://www.facebook.com/"
                                                    class="w-44 h-44 flex-center bg-main-100 text-main-600 text-xl rounded-circle hover-bg-main-600 hover-text-white">
                                                    <i class="ph-fill ph-facebook-logo"></i>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="https://www.twitter.com/"
                                                    class="w-44 h-44 flex-center bg-main-100 text-main-600 text-xl rounded-circle hover-bg-main-600 hover-text-white">
                                                    <i class="ph-fill ph-twitter-logo"></i>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="https://www.linkedin.com/"
                                                    class="w-44 h-44 flex-center bg-main-100 text-main-600 text-xl rounded-circle hover-bg-main-600 hover-text-white">
                                                    <i class="ph-fill ph-instagram-logo"></i>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="https://www.pinterest.com/"
                                                    class="w-44 h-44 flex-center bg-main-100 text-main-600 text-xl rounded-circle hover-bg-main-600 hover-text-white">
                                                    <i class="ph-fill ph-linkedin-logo"></i>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <div class="pt-80">
                <div class="product-dContent border rounded-24">
                    <div class="product-dContent__header border-bottom border-gray-100 flex-between flex-wrap gap-16">
                        <ul class="nav common-tab nav-pills mb-3" id="pills-tab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="pills-description-tab" data-bs-toggle="pill"
                                    data-bs-target="#pills-description" type="button" role="tab"
                                    aria-controls="pills-description" aria-selected="true">Description</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="pills-reviews-tab" data-bs-toggle="pill"
                                    data-bs-target="#pills-reviews" type="button" role="tab"
                                    aria-controls="pills-reviews" aria-selected="false">Reviews</button>
                            </li>
                        </ul>
                        <a href="#"
                            class="btn bg-color-one rounded-16 flex-align gap-8 text-main-600 hover-bg-main-600 hover-text-white">
                            <img src="<?= getenv("BASE_URL") . "/assets/" ?>images/icon/satisfaction-icon.png" alt="">
                            100% Satisfaction Guaranteed
                        </a>
                    </div>
                    <div class="product-dContent__box">
                        <div class="tab-content" id="pills-tabContent">
                            <div class="tab-pane fade show active" id="pills-description" role="tabpanel"
                                aria-labelledby="pills-description-tab" tabindex="0">
                                <div class="mb-40">
                                    <h6 class="mb-24">Product Description</h6>
                                <p class="text-gray-700">
    <?= htmlspecialchars(
        isset($currentVariant['description']) && !empty($currentVariant['description']) 
            ? $currentVariant['description'] 
            : $resultProduct['data']['data']['description'] ?? "No description available."
    ) ?>
</p>
                                    <!-- <p>Morbi ut sapien vitae odio accumsan gravida. Morbi vitae erat auctor, eleifend
                                        nunc a, lobortis neque. Praesent aliquam dignissim viverra. Maecenas lacus odio,
                                        feugiat eu nunc sit amet, maximus sagittis dolor. Vivamus nisi sapien, elementum
                                        sit amet eros sit amet, ultricies cursus ipsum. Sed consequat luctus ligula.
                                        Curabitur laoreet rhoncus blandit. Aenean vel diam ut arcu pharetra dignissim ut
                                        sed leo. Vivamus faucibus, ipsum in vestibulum vulputate, lorem orci convallis
                                        quam, sit amet consequat nulla felis pharetra lacus. Duis semper erat mauris,
                                        sed egestas purus commodo vel.</p> -->
                                    <!-- <ul class="list-inside mt-32 ms-16">
                                        <li class="text-gray-400 mb-4">8.0 oz. bag of LAY'S Classic Potato Chips</li>
                                        <li class="text-gray-400 mb-4">Tasty LAY's potato chips are a great snack</li>
                                        <li class="text-gray-400 mb-4">Includes three ingredients: potatoes, oil, and
                                            salt</li>
                                        <li class="text-gray-400 mb-4">Gluten free product</li>
                                    </ul>
                                    <ul class="mt-32">
                                        <li class="text-gray-400 mb-4">Made in USA</li>
                                        <li class="text-gray-400 mb-4">Ready To Eat.</li>
                                    </ul> -->
                                </div>
                                <!-- <div class="mb-40">
                                    <h6 class="mb-24">Product Specifications</h6>
                                    <ul class="mt-32">
                                        <li class="text-gray-400 mb-14 flex-align gap-14">
                                            <span
                                                class="w-20 h-20 bg-main-50 text-main-600 text-xs flex-center rounded-circle">
                                                <i class="ph ph-check"></i>
                                            </span>
                                            <span class="text-heading fw-medium">
                                                Product Type:
                                                <span class="text-gray-500"> Chips & Dips</span>
                                            </span>
                                        </li>
                                        <li class="text-gray-400 mb-14 flex-align gap-14">
                                            <span
                                                class="w-20 h-20 bg-main-50 text-main-600 text-xs flex-center rounded-circle">
                                                <i class="ph ph-check"></i>
                                            </span>
                                            <span class="text-heading fw-medium">
                                                Product Name:
                                                <span class="text-gray-500"> Potato Chips Classic </span>
                                            </span>
                                        </li>
                                        <li class="text-gray-400 mb-14 flex-align gap-14">
                                            <span
                                                class="w-20 h-20 bg-main-50 text-main-600 text-xs flex-center rounded-circle">
                                                <i class="ph ph-check"></i>
                                            </span>
                                            <span class="text-heading fw-medium">
                                                Brand:
                                                <span class="text-gray-500"> Lay's</span>
                                            </span>
                                        </li>
                                        <li class="text-gray-400 mb-14 flex-align gap-14">
                                            <span
                                                class="w-20 h-20 bg-main-50 text-main-600 text-xs flex-center rounded-circle">
                                                <i class="ph ph-check"></i>
                                            </span>
                                            <span class="text-heading fw-medium">
                                                FSA Eligible:
                                                <span class="text-gray-500"> No</span>
                                            </span>
                                        </li>
                                        <li class="text-gray-400 mb-14 flex-align gap-14">
                                            <span
                                                class="w-20 h-20 bg-main-50 text-main-600 text-xs flex-center rounded-circle">
                                                <i class="ph ph-check"></i>
                                            </span>
                                            <span class="text-heading fw-medium">
                                                Size/Count:
                                                <span class="text-gray-500"> 8.0oz</span>
                                            </span>
                                        </li>
                                        <li class="text-gray-400 mb-14 flex-align gap-14">
                                            <span
                                                class="w-20 h-20 bg-main-50 text-main-600 text-xs flex-center rounded-circle">
                                                <i class="ph ph-check"></i>
                                            </span>
                                            <span class="text-heading fw-medium">
                                                Item Code:
                                                <span class="text-gray-500"> 331539</span>
                                            </span>
                                        </li>
                                        <li class="text-gray-400 mb-14 flex-align gap-14">
                                            <span
                                                class="w-20 h-20 bg-main-50 text-main-600 text-xs flex-center rounded-circle">
                                                <i class="ph ph-check"></i>
                                            </span>
                                            <span class="text-heading fw-medium">
                                                Ingredients:
                                                <span class="text-gray-500"> Potatoes, Vegetable Oil, and Salt.</span>
                                            </span>
                                        </li>
                                    </ul>
                                </div> -->
                                <!-- <div class="mb-40">
                                    <h6 class="mb-24">Nutrition Facts</h6>
                                    <ul class="mt-32">
                                        <li class="text-gray-400 mb-14 flex-align gap-14">
                                            <span
                                                class="w-20 h-20 bg-main-50 text-main-600 text-xs flex-center rounded-circle">
                                                <i class="ph ph-check"></i>
                                            </span>
                                            <span class="text-heading fw-medium"> Total Fat 10g 13%</span>
                                        </li>
                                        <li class="text-gray-400 mb-14 flex-align gap-14">
                                            <span
                                                class="w-20 h-20 bg-main-50 text-main-600 text-xs flex-center rounded-circle">
                                                <i class="ph ph-check"></i>
                                            </span>
                                            <span class="text-heading fw-medium"> Saturated Fat 1.5g 7%</span>
                                        </li>
                                        <li class="text-gray-400 mb-14 flex-align gap-14">
                                            <span
                                                class="w-20 h-20 bg-main-50 text-main-600 text-xs flex-center rounded-circle">
                                                <i class="ph ph-check"></i>
                                            </span>
                                            <span class="text-heading fw-medium"> Cholesterol 0mg 0%</span>
                                        </li>
                                        <li class="text-gray-400 mb-14 flex-align gap-14">
                                            <span
                                                class="w-20 h-20 bg-main-50 text-main-600 text-xs flex-center rounded-circle">
                                                <i class="ph ph-check"></i>
                                            </span>
                                            <span class="text-heading fw-medium"> Sodium 170mg 7%</span>
                                        </li>
                                        <li class="text-gray-400 mb-14 flex-align gap-14">
                                            <span
                                                class="w-20 h-20 bg-main-50 text-main-600 text-xs flex-center rounded-circle">
                                                <i class="ph ph-check"></i>
                                            </span>
                                            <span class="text-heading fw-medium"> Potassium 350mg 6%</span>
                                        </li>
                                    </ul>
                                </div> -->
                                <!-- <div class="mb-0">
                                    <h6 class="mb-24">More Details</h6>
                                    <ul class="mt-32">
                                        <li class="text-gray-400 mb-14 flex-align gap-14">
                                            <span
                                                class="w-20 h-20 bg-main-50 text-main-600 text-xs flex-center rounded-circle">
                                                <i class="ph ph-check"></i>
                                            </span>
                                            <span class="text-gray-500"> Lunarlon midsole delivers ultra-plush
                                                responsiveness</span>
                                        </li>
                                        <li class="text-gray-400 mb-14 flex-align gap-14">
                                            <span
                                                class="w-20 h-20 bg-main-50 text-main-600 text-xs flex-center rounded-circle">
                                                <i class="ph ph-check"></i>
                                            </span>
                                            <span class="text-gray-500"> Encapsulated Air-Sole heel unit for lightweight
                                                cushioning</span>
                                        </li>
                                        <li class="text-gray-400 mb-14 flex-align gap-14">
                                            <span
                                                class="w-20 h-20 bg-main-50 text-main-600 text-xs flex-center rounded-circle">
                                                <i class="ph ph-check"></i>
                                            </span>
                                            <span class="text-gray-500"> Colour Shown: Ale Brown/Black/Goldtone/Ale
                                                Brown</span>
                                        </li>
                                        <li class="text-gray-400 mb-14 flex-align gap-14">
                                            <span
                                                class="w-20 h-20 bg-main-50 text-main-600 text-xs flex-center rounded-circle">
                                                <i class="ph ph-check"></i>
                                            </span>
                                            <span class="text-gray-500"> Style: 805899-202</span>
                                        </li>
                                    </ul>
                                </div> -->

                            </div>
                            <div class="tab-pane fade" id="pills-reviews" role="tabpanel"
                                aria-labelledby="pills-reviews-tab" tabindex="0">
                                <div class="row g-4">
        <div class="col-lg-6">
            <h6 class="mb-24">Product Reviews</h6>

            <?php 
            $reviews = $resultProductByGroup['data']['data']['mainProduct']['reviews'] ?? [];

            if(!empty($reviews)):
                foreach($reviews as $review): 
            ?>
            <div class="d-flex align-items-start gap-24 pb-44 border-bottom border-gray-100 mb-44">
                <img src="<?= getenv("BASE_URL") . "/assets/" ?>images/thumbs/comment-img1.png"
                    alt="" class="w-52 h-52 object-fit-cover rounded-circle flex-shrink-0">
                <div class="flex-grow-1">
                    <div class="flex-between align-items-start gap-8 ">
                        <div class="">
                            <h6 class="mb-12 text-md"><?= htmlspecialchars($review['customer']['name'] ?? 'Anonymous') ?></h6>
                            <div class="flex-align gap-8">
                                <?php
                                    $rating = intval($review['rating'] ?? 0);
                                    for($i=1; $i<=5; $i++):
                                        if($i <= $rating):
                                ?>
                                    <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                                <?php else: ?>
                                    <span class="text-xs fw-medium text-gray-400 d-flex"><i class="ph-fill ph-star"></i></span>
                                <?php endif; endfor; ?>
                            </div>
                        </div>
                        <span class="text-gray-800 text-xs"><?= date('d M Y', strtotime($review['createdAt'] ?? 'now')) ?></span>
                    </div>
                    <h6 class="mb-14 text-md mt-24"><?= htmlspecialchars($review['title'] ?? 'Review') ?></h6>
                    <p class="text-gray-700"><?= htmlspecialchars($review['review'] ?? '') ?></p>

                    <!-- <div class="flex-align gap-20 mt-44">
                        <button class="flex-align gap-12 text-gray-700 hover-text-main-600">
                            <i class="ph-bold ph-thumbs-up"></i>
                            Like
                        </button>
                        <a href="#comment-form"
                            class="flex-align gap-12 text-gray-700 hover-text-main-600">
                            <i class="ph-bold ph-arrow-bend-up-left"></i>
                            Reply
                        </a>
                    </div> -->
                </div>
            </div>
            <?php 
                endforeach; 
            else: 
            ?>
            <p>No reviews found for this product.</p>
            <?php endif; ?>
        </div>

                                        <!-- <div
                                            class="d-flex align-items-start gap-24 pb-44 border-bottom border-gray-100 mb-44">
                                            <img src="<?= getenv("BASE_URL") . "/assets/" ?>images/thumbs/comment-img1.png"
                                                alt="" class="w-52 h-52 object-fit-cover rounded-circle flex-shrink-0">
                                            <div class="flex-grow-1">
                                                <div class="flex-between align-items-start gap-8 ">
                                                    <div class="">
                                                        <h6 class="mb-12 text-md">Nicolas cage</h6>
                                                        <div class="flex-align gap-8">
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
                                                    </div>
                                                    <span class="text-gray-800 text-xs">3 Days ago</span>
                                                </div>
                                                <h6 class="mb-14 text-md mt-24">Greate Product</h6>
                                                <p class="text-gray-700">There are many variations of passages of Lorem
                                                    Ipsum available, but the majority have suffered alteration in some
                                                    form, by injected humour</p>

                                                <div class="flex-align gap-20 mt-44">
                                                    <button class="flex-align gap-12 text-gray-700 hover-text-main-600">
                                                        <i class="ph-bold ph-thumbs-up"></i>
                                                        Like
                                                    </button>
                                                    <a href="#comment-form"
                                                        class="flex-align gap-12 text-gray-700 hover-text-main-600">
                                                        <i class="ph-bold ph-arrow-bend-up-left"></i>
                                                        Replay
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-start gap-24">
                                            <img src="<?= getenv("BASE_URL") . "/assets/" ?>images/thumbs/comment-img1.png"
                                                alt="" class="w-52 h-52 object-fit-cover rounded-circle flex-shrink-0">
                                            <div class="flex-grow-1">
                                                <div class="flex-between align-items-start gap-8 ">
                                                    <div class="">
                                                        <h6 class="mb-12 text-md">Nicolas cage</h6>
                                                        <div class="flex-align gap-8">
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
                                                    </div>
                                                    <span class="text-gray-800 text-xs">3 Days ago</span>
                                                </div>
                                                <h6 class="mb-14 text-md mt-24">Greate Product</h6>
                                                <p class="text-gray-700">There are many variations of passages of Lorem
                                                    Ipsum available, but the majority have suffered alteration in some
                                                    form, by injected humour</p>

                                                <div class="flex-align gap-20 mt-44">
                                                    <button class="flex-align gap-12 text-gray-700 hover-text-main-600">
                                                        <i class="ph-bold ph-thumbs-up"></i>
                                                        Like
                                                    </button>
                                                    <a href="#comment-form"
                                                        class="flex-align gap-12 text-gray-700 hover-text-main-600">
                                                        <i class="ph-bold ph-arrow-bend-up-left"></i>
                                                        Replay
                                                    </a>
                                                </div>
                                            </div>
                                        </div> -->

                                        <div class="mt-56">
                                            <div class="">
                                                <h6 class="mb-24">Write a Review</h6>
                                                <span class="text-heading mb-8">What is it like to Product?</span>
                                                <div class="flex-align gap-8">
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
                                            </div>
                                            <div class="mt-32">
                                                <form action="#">
                                                    <div class="mb-32">
                                                        <label for="title" class="text-neutral-600 mb-8">Review
                                                            Title</label>
                                                        <input type="text" class="common-input rounded-8" id="title"
                                                            placeholder="Great Products">
                                                    </div>
                                                    <div class="mb-32">
                                                        <label for="desc" class="text-neutral-600 mb-8">Review
                                                            Content</label>
                                                        <textarea class="common-input rounded-8"
                                                            id="desc">It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, content here', making it look like readable English.</textarea>
                                                    </div>
                                                    <button type="submit" class="btn btn-main rounded-pill mt-48">Submit
                                                        Review</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- <div class="col-lg-6">
                                        <div class="ms-xxl-5">
                                            <h6 class="mb-24">Customers Feedback</h6>
                                            <div class="d-flex flex-wrap gap-44">
                                                <div
                                                    class="border border-gray-100 rounded-8 px-40 py-52 flex-center flex-column flex-shrink-0 text-center">
                                                    <h2 class="mb-6 text-main-600">4.8</h2>
                                                    <div class="flex-center gap-8">
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
                                                    <span class="mt-16 text-gray-500">Average Product Rating</span>
                                                </div>
                                                <div class="border border-gray-100 rounded-8 px-24 py-40 flex-grow-1">
                                                    <div class="flex-align gap-8 mb-20">
                                                        <span class="text-gray-900 flex-shrink-0">5</span>
                                                        <div class="progress w-100 bg-gray-100 rounded-pill h-8"
                                                            role="progressbar" aria-label="Basic example"
                                                            aria-valuenow="70" aria-valuemin="0" aria-valuemax="100">
                                                            <div class="progress-bar bg-main-600 rounded-pill"
                                                                style="width: 70%"></div>
                                                        </div>
                                                        <div class="flex-align gap-4">
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
                                                        <span class="text-gray-900 flex-shrink-0">124</span>
                                                    </div>
                                                    <div class="flex-align gap-8 mb-20">
                                                        <span class="text-gray-900 flex-shrink-0">4</span>
                                                        <div class="progress w-100 bg-gray-100 rounded-pill h-8"
                                                            role="progressbar" aria-label="Basic example"
                                                            aria-valuenow="50" aria-valuemin="0" aria-valuemax="100">
                                                            <div class="progress-bar bg-main-600 rounded-pill"
                                                                style="width: 50%"></div>
                                                        </div>
                                                        <div class="flex-align gap-4">
                                                            <span class="text-xs fw-medium text-warning-600 d-flex"><i
                                                                    class="ph-fill ph-star"></i></span>
                                                            <span class="text-xs fw-medium text-warning-600 d-flex"><i
                                                                    class="ph-fill ph-star"></i></span>
                                                            <span class="text-xs fw-medium text-warning-600 d-flex"><i
                                                                    class="ph-fill ph-star"></i></span>
                                                            <span class="text-xs fw-medium text-warning-600 d-flex"><i
                                                                    class="ph-fill ph-star"></i></span>
                                                            <span class="text-xs fw-medium text-gray-400 d-flex"><i
                                                                    class="ph-fill ph-star"></i></span>
                                                        </div>
                                                        <span class="text-gray-900 flex-shrink-0">52</span>
                                                    </div>
                                                    <div class="flex-align gap-8 mb-20">
                                                        <span class="text-gray-900 flex-shrink-0">3</span>
                                                        <div class="progress w-100 bg-gray-100 rounded-pill h-8"
                                                            role="progressbar" aria-label="Basic example"
                                                            aria-valuenow="35" aria-valuemin="0" aria-valuemax="100">
                                                            <div class="progress-bar bg-main-600 rounded-pill"
                                                                style="width: 35%"></div>
                                                        </div>
                                                        <div class="flex-align gap-4">
                                                            <span class="text-xs fw-medium text-warning-600 d-flex"><i
                                                                    class="ph-fill ph-star"></i></span>
                                                            <span class="text-xs fw-medium text-warning-600 d-flex"><i
                                                                    class="ph-fill ph-star"></i></span>
                                                            <span class="text-xs fw-medium text-warning-600 d-flex"><i
                                                                    class="ph-fill ph-star"></i></span>
                                                            <span class="text-xs fw-medium text-gray-400 d-flex"><i
                                                                    class="ph-fill ph-star"></i></span>
                                                            <span class="text-xs fw-medium text-gray-400 d-flex"><i
                                                                    class="ph-fill ph-star"></i></span>
                                                        </div>
                                                        <span class="text-gray-900 flex-shrink-0">12</span>
                                                    </div>
                                                    <div class="flex-align gap-8 mb-20">
                                                        <span class="text-gray-900 flex-shrink-0">2</span>
                                                        <div class="progress w-100 bg-gray-100 rounded-pill h-8"
                                                            role="progressbar" aria-label="Basic example"
                                                            aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                                                            <div class="progress-bar bg-main-600 rounded-pill"
                                                                style="width: 20%"></div>
                                                        </div>
                                                        <div class="flex-align gap-4">
                                                            <span class="text-xs fw-medium text-warning-600 d-flex"><i
                                                                    class="ph-fill ph-star"></i></span>
                                                            <span class="text-xs fw-medium text-warning-600 d-flex"><i
                                                                    class="ph-fill ph-star"></i></span>
                                                            <span class="text-xs fw-medium text-gray-400 d-flex"><i
                                                                    class="ph-fill ph-star"></i></span>
                                                            <span class="text-xs fw-medium text-gray-400 d-flex"><i
                                                                    class="ph-fill ph-star"></i></span>
                                                            <span class="text-xs fw-medium text-gray-400 d-flex"><i
                                                                    class="ph-fill ph-star"></i></span>
                                                        </div>
                                                        <span class="text-gray-900 flex-shrink-0">5</span>
                                                    </div>
                                                    <div class="flex-align gap-8 mb-0">
                                                        <span class="text-gray-900 flex-shrink-0">1</span>
                                                        <div class="progress w-100 bg-gray-100 rounded-pill h-8"
                                                            role="progressbar" aria-label="Basic example"
                                                            aria-valuenow="5" aria-valuemin="0" aria-valuemax="100">
                                                            <div class="progress-bar bg-main-600 rounded-pill"
                                                                style="width: 5%"></div>
                                                        </div>
                                                        <div class="flex-align gap-4">
                                                            <span class="text-xs fw-medium text-warning-600 d-flex"><i
                                                                    class="ph-fill ph-star"></i></span>
                                                            <span class="text-xs fw-medium text-gray-400 d-flex"><i
                                                                    class="ph-fill ph-star"></i></span>
                                                            <span class="text-xs fw-medium text-gray-400 d-flex"><i
                                                                    class="ph-fill ph-star"></i></span>
                                                            <span class="text-xs fw-medium text-gray-400 d-flex"><i
                                                                    class="ph-fill ph-star"></i></span>
                                                            <span class="text-xs fw-medium text-gray-400 d-flex"><i
                                                                    class="ph-fill ph-star"></i></span>
                                                        </div>
                                                        <span class="text-gray-900 flex-shrink-0">2</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div> -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ========================== Product Details Two End =========================== -->

        <!-- ========================== Similar Product Start ============================= -->
     <section class="new-arrival pb-80">
        <div class="container container-lg">
            <div class="section-heading">
                <div class="flex-between flex-wrap gap-8">
                    <h5 class="mb-0">You Might Also Like</h5>
                    <div class="flex-align gap-16">
                        <a href="shop.php"
                            class="text-sm fw-medium text-gray-700 hover-text-main-600 hover-text-decoration-underline">All
                            Products</a>
                        <div class="flex-align gap-8">
                            <button type="button" id="new-arrival-prev"
                                class="slick-prev slick-arrow flex-center rounded-circle border border-gray-100 hover-border-main-600 text-xl hover-bg-main-600 hover-text-white transition-1">
                                <i class="ph ph-caret-left"></i>
                            </button>
                            <button type="button" id="new-arrival-next"
                                class="slick-next slick-arrow flex-center rounded-circle border border-gray-100 hover-border-main-600 text-xl hover-bg-main-600 hover-text-white transition-1">
                                <i class="ph ph-caret-right"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="new-arrival__slider arrow-style-two">
                <?php
                // Ensure $similarProducts is defined (it is prepared above). If not, try to derive from $allProducts.
                if (empty($similarProducts) && isset($allProducts['data']['data']) && is_array($allProducts['data']['data'])) {
                    $similarProducts = $allProducts['data']['data'];
                    $currentId = $resultProduct['data']['data']['id'] ?? null;
                    if ($currentId) {
                        $similarProducts = array_filter($similarProducts, fn($p) => ($p['id'] ?? null) != $currentId);
                    }
                    usort($similarProducts, function($a, $b) {
                        return ($b['popularity'] ?? 0) - ($a['popularity'] ?? 0);
                    });
                    $similarProducts = array_slice($similarProducts, 0, 8);
                }

                foreach ($similarProducts as $product):
                    // normalize fields
                    $pid = $product['id'] ?? '';
                    $pname = $product['name'] ?? ($product['title'] ?? 'Product');
                    $images = $product['images'] ?? [];
                    $primary = null;
                    foreach ($images as $img) {
                        if (!empty($img['isPrimary'])) { $primary = $img['imageUrl']; break; }
                    }
                    if (!$primary && !empty($images)) { $primary = $images[0]['imageUrl']; }
                    $primary = $primary ?: getenv("BASE_URL") . "/assets/images/thumbs/product-img-placeholder.png";

                    // price & discount
                    $originalPrice = floatval($product['price'] ?? 0);
                    $discountedPrice = $originalPrice;
                    $discountValue = $product['discountValue'] ?? null;
                    $discountType = strtoupper($product['discount'] ?? '');
                    if ($discountValue !== null && $discountValue !== '') {
                        if ($discountType === 'CASH') {
                            $discountedPrice = max(0, $originalPrice - floatval($discountValue));
                        } else { // assume PERCENTAGE or fallback
                            $discountedPrice = max(0, $originalPrice - ($originalPrice * floatval($discountValue) / 100));
                        }
                    }

                    // percent off for badge
                    $percentOff = 0;
                    if ($originalPrice > 0 && $discountedPrice < $originalPrice) {
                        $percentOff = round((($originalPrice - $discountedPrice) / $originalPrice) * 100);
                    }

                    // rating
                    $reviewsArr = $product['reviews'] ?? [];
                    $rating = 0;
                    if (!empty($reviewsArr) && is_array($reviewsArr)) {
                        $totalR = array_sum(array_column($reviewsArr, 'rating'));
                        $rating = count($reviewsArr) ? ($totalR / count($reviewsArr)) : 0;
                    } else {
                        $rating = ($product['popularity'] ?? 0) / 2;
                    }
                    $ratingDisplay = number_format($rating, 1);
                    $reviewsCount = is_array($reviewsArr) ? count($reviewsArr) : 0;

                    $productUrl = getenv('BASE_URL') . '/product/' . $utils->makeSlug($pname);
                ?>
                <div>
                    <div class="product-card h-100 p-8 border border-gray-100 hover-border-main-600 rounded-16 position-relative transition-2">
                        <?php if ($percentOff > 0): ?>
                           
                        <?php elseif (!empty($product['popularity'])): ?>
                            <span class="product-card__badge bg-info-600 px-8 py-4 text-sm text-white">Popularity <?= intval($product['popularity']) ?></span>
                        <?php endif; ?>

                        <a href="<?= htmlspecialchars($productUrl) ?>" class="product-card__thumb flex-center overflow-hidden">
                            <img src="<?= htmlspecialchars($primary) ?>" alt="<?= htmlspecialchars($pname) ?>">
                        </a>
                        <div class="product-card__content p-sm-2 w-100">
                            <h6 class="title text-lg fw-semibold mt-12 mb-8">
                                <a href="<?= htmlspecialchars($productUrl) ?>" class="link text-line-2"><?= htmlspecialchars($pname) ?></a>
                            </h6>
                            <div class="flex-align gap-4">
                                <span class="text-main-600 text-md d-flex"><i class="ph-fill ph-storefront"></i></span>
                                <span class="text-gray-500 text-xs"><?= htmlspecialchars($product['category']['name'] ?? 'Store') ?></span>
                            </div>

                            <div class="product-card__content mt-12">
                                <div class="product-card__price mb-8">
                                    <span class="text-heading text-md fw-semibold ">₹<?= number_format($discountedPrice, 2) ?> <span class="text-gray-500 fw-normal">/Qty</span> </span>
                                    <?php if ($discountedPrice < $originalPrice): ?>
                                        <span class="text-gray-400 text-md fw-semibold text-decoration-line-through">₹<?= number_format($originalPrice, 2) ?></span>
                                    <?php endif; ?>
                                </div>
                                <div class="flex-align gap-6">
                                    <span class="text-xs fw-bold text-gray-600"><?= $ratingDisplay ?></span>
                                    <span class="text-15 fw-bold text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                                    <span class="text-xs fw-bold text-gray-600">(<?= $reviewsCount ?>)</span>
                                </div>
                               <a href="javascript:void(0);"
    data-product-id="<?= htmlspecialchars($product['id'] ?? '') ?>"
    class="product-card__cart btn bg-main-50 text-main-600 hover-bg-main-600 hover-text-white py-11 px-24 rounded-pill flex-align gap-8 mt-24 w-100 justify-content-center add-to-cart">
    Add To Cart <i class="ph ph-shopping-cart"></i>
</a>

                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <!-- ========================== Similar Product End ============================= -->
   

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
                <img src="<?= getenv("BASE_URL") . "/assets/" ?>images/bg/newsletter-bg.png" alt=""
                    class="position-absolute inset-block-start-0 inset-inline-start-0 z-n1 w-100 h-100 opacity-6">
                <div class="row align-items-center">
                    <div class="col-xl-6">
                        <div class="">
                            <h1 class="text-white mb-12" data-aos="fade-down" data-aos-duration="800">Don't Miss Out on
                                Grocery Deals</h1>
                            <p class="text-white h5 mb-0" data-aos="fade-up" data-aos-duration="800">SING UP FOR THE
                                UPDATE NEWSLETTER</p>
                            <form id="subscribed" class="position-relative mt-40" data-aos="zoom-in"
                                data-aos-duration="800">
                                <input type="email" name="email"
                                    class="form-control common-input rounded-pill text-light py-22 px-16 pe-144"
                                    placeholder="Your email address...">
                                <button type="submit"
                                    class="btn btn-main-two rounded-pill position-absolute top-50 translate-middle-y inset-inline-end-0 me-10">Subscribe
                                </button>
                            </form>
                        </div>
                    </div>
                    <div class="col-xl-6 text-center d-xl-block d-none">
                        <img src="<?= getenv("BASE_URL") . "/assets/" ?>images/thumbs/newsletter-img.png" alt=""
                            data-aos="zoom-in" data-aos-duration="800">
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
    <script src="<?= getenv("BASE_URL") . "/assets/" ?>js/jquery-3.7.1.min.js"></script>
    <!-- Bootstrap Bundle Js -->
    <script src="<?= getenv("BASE_URL") . "/assets/" ?>js/boostrap.bundle.min.js"></script>
    <!-- Bootstrap Bundle Js -->
    <script src="<?= getenv("BASE_URL") . "/assets/" ?>js/phosphor-icon.js"></script>
    <!-- Select 2 -->
    <script src="<?= getenv("BASE_URL") . "/assets/" ?>js/select2.min.js"></script>
    <!-- Slick js -->
    <script src="<?= getenv("BASE_URL") . "/assets/" ?>js/slick.min.js"></script>
    <!-- count down js -->
    <script src="<?= getenv("BASE_URL") . "/assets/" ?>js/count-down.js"></script>
    <!-- jquery UI js -->
    <script src="<?= getenv("BASE_URL") . "/assets/" ?>js/jquery-ui.js"></script>
    <!-- wow js -->
    <script src="<?= getenv("BASE_URL") . "/assets/" ?>js/wow.min.js"></script>
    <!-- AOS Animation -->
    <script src="<?= getenv("BASE_URL") . "/assets/" ?>js/aos.js"></script>
    <!-- marque -->
    <script src="<?= getenv("BASE_URL") . "/assets/" ?>js/marque.min.js"></script>
    <!-- marque -->
    <script src="<?= getenv("BASE_URL") . "/assets/" ?>js/vanilla-tilt.min.js"></script>
    <!-- Counter -->
    <script src="<?= getenv("BASE_URL") . "/assets/" ?>js/counter.min.js"></script>
    <!-- main js -->
    <script src="<?= getenv("BASE_URL") . "/assets/" ?>js/main.js"></script>

    <script>
        $(document).ready(function () {

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
                    url: "<?php echo getenv("NEWSLETTER_SUBSCRIBE") ?>",
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
                        text: 'Product added to cart successfully!',
                        icon: 'success',
                        confirmButtonText: 'Continue Shopping',
                        timer: 3000,
                        showConfirmButton: false,
                        timerProgressBar: true,
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Optional: Redirect or refresh if needed
                            // window.location.href = '';
                        }
                    });
                } else if (cart.includes(productId)) {
                    // Show warning if product is already in cart
                    Swal.fire({
                        text: 'This product is already in your cart!',
                        icon: 'info',
                        confirmButtonText: 'Continue Shopping',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
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

        });

    </script>



</body>

</html>