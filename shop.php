<?php
session_start();
// declare(strict_types=1);
require __DIR__ . "/api/api.php";
error_reporting(E_ALL);
ini_set("", 1);
require __DIR__ . "/utils/utils.php";

$utils = new Utils;

// api endpoints
$fetchAllBrandApi = getenv("FETCH_ALL_BRAND_API");
$fetchAllColorApi = getenv("FETCH_ALL_COLOR_API");
$fetchAllSizeApi = getenv("FETCH_ALL_SIZE_API");
$fetchAllProductCategoryApi = getenv("FETCH_ALL_PRODUCT_CATEGORY_API");


$fetchProductGraphQl = getenv("GRAPHQL");

$resultBrands = $utils->fetchFromApi($fetchAllBrandApi);
$resultColors = $utils->fetchFromApi($fetchAllColorApi);
$resultSizes = $utils->fetchFromApi($fetchAllSizeApi);
$resultProductCategory = $utils->fetchFromApi($fetchAllProductCategoryApi);



// Get query parameters from URL
// Get query parameters from URL
$category = isset($_GET['category']) ? $_GET['category'] : "";
$minPrice = isset($_GET['minPrice']) ? (float) $_GET['minPrice'] : 0;
$maxPrice = isset($_GET['maxPrice']) ? (float) $_GET['maxPrice'] : 15000;
$size = isset($_GET['size']) ? $_GET['size'] : "";
$brand = isset($_GET['brand']) ? $_GET['brand'] : "";
$color = isset($_GET['color']) ? $_GET['color'] : "";
$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
$limit = isset($_GET['limit']) ? (int) $_GET['limit'] : 12;
$sort = isset($_GET['sort']) ? $_GET['sort'] : "popularity";

// Build GraphQL query dynamically
$query = '
query ProductFilter($category: String, $minPrice: Float, $maxPrice:Float , $size: String, $brand: String,$color:String, $page: Int, $limit: Int, $sortBy: String) {
  productFilter(
    category: $category,
    minPrice: $minPrice,
    maxPrice: $maxPrice,
    size: $size,
    brand: $brand,
    color: $color,
    page: $page,
    limit: $limit,
    sortBy: $sortBy
  ) {
    data {
      id
      name
      price
      discountValue
      stock
      popularity
      brand {
      name
      }
      category {
        name
      }
      images {
        isPrimary
        imageUrl
      }
      reviews {
        rating
        review
      }
      attributes {
        color
        size
      }
    }
    pagination {
      currentPage
      lastPage
      total
      perPage
      hasNextPage
      hasPrevPage
      from
      to
    }
  }
}';

// Handle sorting based on the selected option
$sortBy = "";
switch($sort) {
    case "popularity":
        $sortBy = "popularity";
        break;
    case "latest":
        $sortBy = "latest";
        break;
    case "priceLowToHigh":
        $sortBy = "priceLowToHigh";
        break;
    case "priceHighToLow":
        $sortBy = "priceHighToLow";
        break;
    default:
        $sortBy = "popularity";
}

// Variables to send
$variables = [
    "category" => $category !== "" ? $category : "",
    "minPrice" => $minPrice,
    "maxPrice" => $maxPrice,
    "size" => $size !== "" ? $size : "",
    "brand" => $brand !== "" ? $brand : "",
    "color" => $color !== "" ? $color : "",
    "page" => $page,
    "limit" => $limit,
    "sortBy" => $sortBy
];

// Call GraphQL API using your utility function
$resultGraphQlProduct = $utils->fetchGraphQlFromApi($query, $variables, $fetchProductGraphQl);

// // Decode and check result
if (isset($resultGraphQlProduct['errors'])) {
    $_SESSION['error'] = "Error for fetching products";

} else {
    $hasProducts = !empty($resultGraphQlProduct['data']['productFilter']['data']);
    $pagination = $resultGraphQlProduct['data']['productFilter']['pagination'] ?? null;
}



// echo "<pre>";
// print_r($resultSizes);

// // foreach ($resultGraphQlProduct['data']['productFilter']['data'] as $key => $value) {
// //     # code...
// //     // echo $value['groupId'] . ": " . $value['name'] . "<br>";
// //     print_r($value['id'] );
// // }
// exit;
?>

<!DOCTYPE html>
<html lang="en" class="color-two font-exo header-style-two">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Title -->
    <title> MarketPro - E-commerce HTML Template</title>
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

    <!-- notyfy -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">
    <script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>

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

    <!-- ========================= Breadcrumb Start =============================== -->
    <div class="breadcrumb mb-0 py-26 bg-main-two-50">
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
                    <li class="text-sm text-main-600"> Product Shop </li>
                </ul>
            </div>
        </div>
    </div>
    <!-- ========================= Breadcrumb End =============================== -->

    <!-- =============================== Shop Section Start ======================================== -->
    <section class="shop py-80">
        <div class="container container-lg">
            <div class="row">

                <!-- Sidebar Start -->
                <div class="col-lg-3">
                    <div class="shop-sidebar">
                        <button type="button"
                            class="shop-sidebar__close d-lg-none d-flex w-32 h-32 flex-center border border-gray-100 rounded-circle hover-bg-main-600 position-absolute inset-inline-end-0 me-10 mt-8 hover-text-white hover-border-main-600">
                            <i class="ph ph-x"></i>
                        </button>
                        <div class="shop-sidebar__box border border-gray-100 rounded-8 p-32 mb-32">
                            <h6 class="text-xl border-bottom border-gray-100 pb-24 mb-24">Product Category</h6>
                            <ul class="max-h-540 overflow-y-auto scroll-sm">
                                <?php foreach ($resultProductCategory['data']['data'] as $key => $category): ?>
                                    <li class="mb-24">
                                        <a href="<?= getenv("BASE_URL") . "/product/category/" . $utils->makeSlug($category['name']) ?>"
                                            class="text-gray-900 hover-text-main-600"><?= $category['name'] ?>
                                            (<?= $category['_count']['products'] ?>)</a>
                                    </li>
                                <?php endforeach; ?>

                                <?php if (empty($resultProductCategory['data']['data'])): ?>
                                    <li class="mb-24">
                                        No category found
                                    </li>

                                <?php endif; ?>
                            </ul>
                        </div>
                        <div class="shop-sidebar__box border border-gray-100 rounded-8 p-32 mb-32">
                            <h6 class="text-xl border-bottom border-gray-100 pb-24 mb-24">Filter by Price</h6>
                            <div class="custom--range">
                                <div id="slider-range"></div>
                                <div class="flex-between flex-wrap-reverse gap-8 mt-24 ">
                                    <button type="button" class="btn btn-main h-40 flex-align">Filter </button>
                                    <div class="custom--range__content flex-align gap-8">
                                        <span class="text-gray-500 text-md flex-shrink-0">Price:</span>
                                        <input type="text" class="" id="amount" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="shop-sidebar__box border border-gray-100 rounded-8 p-32 mb-32">
                            <h6 class="text-xl border-bottom border-gray-100 pb-24 mb-24">Filter by Size</h6>
                            <ul class="max-h-540 overflow-y-auto scroll-sm">
                                <?php $count = 1;
                                foreach ($resultSizes['data']['sizes'] as $key => $size): ?>
                                    <li class="mb-24">
                                        <div class="form-check common-check common-radio checked-black">
                                            <input class="form-check-input size-filter" type="radio" name="color"
                                                id="color<?= $count ?>" data-size="<?= $size['size'] ?>">
                                            <label class="form-check-label"
                                                for="color<?= $count ?>"><?= $size['size'] ?></label>
                                        </div>
                                    </li>
                                <?php endforeach; ?>

                                <?php if (empty($resultSizes)): ?>
                                    <li class="mb-24">
                                        <div class="form-check common-check common-radio checked-primary">
                                            No size found
                                        </div>
                                    </li>
                                <?php endif; ?>
                            </ul>
                        </div>

                        <div class="shop-sidebar__box border border-gray-100 rounded-8 p-32 mb-32">
                            <h6 class="text-xl border-bottom border-gray-100 pb-24 mb-24">Filter by Color</h6>
                            <ul class="max-h-540 overflow-y-auto scroll-sm">

                                <?php foreach ($resultColors['data']['colors'] as $key => $colors): ?>
                                    <li class="mb-24">
                                        <div class="form-check common-check common-radio checked-black">
                                            <input class="form-check-input color-filter" type="radio" name="color"
                                                id="color1" data-color="<?= $colors ?>">
                                            <label class="form-check-label" for="color1"><?= $colors ?></label>
                                        </div>
                                    </li>
                                <?php endforeach; ?>

                                <?php if (empty($resultColors)): ?>
                                    <li class="mb-24">
                                        <div class="form-check common-check common-radio checked-primary">
                                            No color found
                                        </div>
                                    </li>
                                <?php endif; ?>
                            </ul>
                        </div>
                        <div class="shop-sidebar__box border border-gray-100 rounded-8 p-32 mb-32">
                            <h6 class="text-xl border-bottom border-gray-100 pb-24 mb-24">Filter by Brand</h6>
                            <ul class="max-h-540 overflow-y-auto scroll-sm">

                                <?php $count = 1;
                                foreach ($resultBrands['data']['data'] as $key => $brand): ?>
                                    <li class="mb-24">
                                        <div class="form-check common-check common-radio">
                                            <input class="form-check-input brand-filter" type="radio" name="color"
                                                id="brand<?= $count ?>" data-brand="<?= $brand['name'] ?>">
                                            <label class="form-check-label" for="brand<?= $count ?>"> <?= $brand['name'] ?>
                                            </label>
                                        </div>
                                    </li>
                                <?php endforeach; ?>
                                <?php if (empty($resultBrands['data']['data'])): ?>
                                    <li class="mb-24">
                                        <div class="form-check common-check common-radio">
                                            <label class="form-check-label" for="brand1"> No brand found </label>
                                        </div>
                                    </li>
                                <?php endif; ?>

                            </ul>
                        </div>
                        <div class="shop-sidebar__box rounded-8">
                            <img src="<?= getenv("BASE_URL") . "/assets/" ?>images/thumbs/advertise-img1.png" alt="">
                        </div>
                    </div>
                </div>
                <!-- Sidebar End -->

                <!-- Content Start -->
                <div class="col-lg-9">
                    <!-- Top Start -->
                    <div class="flex-between gap-16 flex-wrap mb-40 ">
                        <?php if ($hasProducts && $pagination): ?>
                            <span class="text-gray-900">Showing <?= number_format($pagination['from']) ?> -
                                <?= number_format($pagination['to']) ?> of
                                <?= number_format($pagination['total']) ?>
                                result</span>
                        <?php endif; ?>
                        <div class="position-relative flex-align gap-16 flex-wrap">
                            <div class="list-grid-btns flex-align gap-16">
                                <button type="button"
                                    class="w-44 h-44 flex-center border border-gray-100 rounded-6 text-2xl list-btn">
                                    <i class="ph-bold ph-list-dashes"></i>
                                </button>
                                <button type="button"
                                    class="w-44 h-44 flex-center border border-main-600 text-white bg-main-600 rounded-6 text-2xl grid-btn">
                                    <i class="ph ph-squares-four"></i>
                                </button>
                            </div>
                            <div class="position-relative text-gray-500 flex-align gap-4 text-14">
                                <label for="sorting" class="text-inherit flex-shrink-0">Sort by: </label>
                                <select class="form-control common-input px-14 py-14 text-inherit rounded-06 w-auto"
                                    id="sorting">
                                    <option value="popularity" <?= (isset($_GET['sort']) && $_GET['sort'] === 'popularity') ? 'selected' : '' ?>>Popular</option>
                                    <option value="latest" <?= (isset($_GET['sort']) && $_GET['sort'] === 'latest') ? 'selected' : '' ?>>Latest</option>
                                    <option value="priceLowToHigh" <?= (isset($_GET['sort']) && $_GET['sort'] === 'priceLowToHigh') ? 'selected' : '' ?>>Price: Low to High
                                    </option>
                                    <option value="priceHighToLow" <?= (isset($_GET['sort']) && $_GET['sort'] === 'priceHighToLow') ? 'selected' : '' ?>>Price: High to Low
                                    </option>
                                </select>
                            </div>
                            <button type="button"
                                class="w-44 h-44 d-lg-none d-flex flex-center border border-gray-100 rounded-6 text-2xl sidebar-btn"><i
                                    class="ph-bold ph-funnel"></i></button>
                        </div>
                    </div>
                    <div class="list-grid-wrapper">
                        <?php


                        if ($hasProducts):
                            foreach ($resultGraphQlProduct['data']['productFilter']['data'] as $key => $product):
                                // Find the primary image
                                $primaryImage = null;
                                if (!empty($product['images'])) {
                                    foreach ($product['images'] as $image) {
                                        if ($image['isPrimary']) {
                                            $primaryImage = $image['imageUrl'];
                                            break;
                                        }
                                    }
                                }
                                // Fallback to a placeholder image if no primary image is found
                                $primaryImage = $primaryImage ?: 'assets/images/thumbs/photo.png';

                                // Calculate discounted price
                                $originalPrice = floatval($product['price']);
                                $discountPercentage = floatval($product['discountValue'] ?? 0);
                                $discountedPrice = $originalPrice * (1 - $discountPercentage / 100);

                                // Calculate stock and sold percentage
                                $remainingStock = intval($product['stock'] ?? 0);
                                $sold = 18; // Assuming 18 sold as per static HTML
                                $totalStock = $remainingStock + $sold; // Total stock = remaining + sold
                                $soldPercentage = ($totalStock > 0) ? ($sold / $totalStock) * 100 : 0;

                                // Calculate rating: Use average of review ratings if available, else use popularity
                                // Calculate rating safely
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

                                <div
                                    class="product-card h-100 p-16 border border-gray-100 hover-border-main-600 rounded-16 position-relative transition-2">
                                    <a href="<?= getenv("BASE_URL") . "/product/" . $utils->makeSlug($product['name']) ?>"
                                        class="product-card__thumb flex-center rounded-8 bg-gray-50 position-relative overflow-hidden">
                                        <img src="<?= htmlspecialchars($primaryImage, ENT_QUOTES, 'UTF-8') ?>"
                                            alt="<?= htmlspecialchars($product['name'], ENT_QUOTES, 'UTF-8') ?>"
                                            class="w-100 h-100 object-fit-cover">
                                        <span
                                            class="product-card__badge bg-primary-600 px-8 py-4 text-sm text-white position-absolute inset-inline-start-0 inset-block-start-0">
                                            Best Sale
                                        </span>
                                    </a>
                                    <div class="product-card__content mt-16">
                                        <h6 class="title text-lg fw-semibold mt-12 mb-8">
                                            <a href="<?= getenv("BASE_URL") . "/product/" . $utils->makeSlug($product['name']) ?>"
                                                class="link text-line-2"
                                                tabindex="0"><?= htmlspecialchars($product['name'], ENT_QUOTES, 'UTF-8') ?></a>
                                        </h6>

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

                                        <div class="mt-8">
                                            <div class="progress w-100 bg-color-three rounded-pill h-4" role="progressbar"
                                                aria-label="Sales progress" aria-valuenow="<?= $sold ?>" aria-valuemin="0"
                                                aria-valuemax="<?= $totalStock ?>">
                                                <div class="progress-bar bg-main-two-600 rounded-pill"
                                                    style="width: <?= $soldPercentage ?>%"></div>
                                            </div>
                                            <span class="text-gray-900 text-xs fw-medium mt-8">Sold:
                                                <?= $sold ?>/<?= $totalStock ?></span>
                                        </div>

                                        <div class="product-card__price my-20">
                                            <?php if ($discountPercentage > 0): ?>
                                                <span class="text-gray-400 text-md fw-semibold text-decoration-line-through">
                                                    ₹<?= number_format($originalPrice, 2) ?>
                                                </span>
                                            <?php endif; ?>
                                            <span class="text-heading text-md fw-semibold">
                                                ₹<?= number_format($discountedPrice, 2) ?>
                                                <span class="text-gray-500 fw-normal">/Qty</span>
                                            </span>
                                            <?php if ($discountPercentage > 0): ?>
                                                <span class="text-success text-sm fw-medium ms-2">
                                                    (<?= number_format($discountPercentage, 0) ?>% OFF)
                                                </span>
                                            <?php endif; ?>
                                        </div>

                                        <div class="d-flex align-items-center gap-12">
                                            <a href="javascript:void(0);"
                                                data-product-id="<?= htmlspecialchars($product['id'], ENT_QUOTES, 'UTF-8') ?>"
                                                class="product-card__cart btn text-heading hover-bg-main-600 hover-text-white py-11 px-24 rounded-8 flex-center gap-8 fw-medium add-to-cart"
                                                tabindex="0">
                                                Add To Cart <i class="ph ph-shopping-cart"></i>
                                            </a>

                                            <a href="javascript:void(0);"
                                                data-product-id="<?= htmlspecialchars($product['id'], ENT_QUOTES, 'UTF-8') ?>"
                                                class="btn text-heading hover-text-danger-600 py-11 px-16 rounded-8 flex-center add-to-wishlist"
                                                tabindex="0" title="Add to Wishlist">
                                                <i class="ph ph-heart"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <!-- Improved Products Not Found Section -->
                            <div class="text-center py-5">
                                <div class="empty-state-container">
                                    <div class="empty-icon mb-4">
                                        <i class="ph ph-shopping-bag text-gray-400" style="font-size: 4rem;"></i>
                                    </div>
                                    <h3 class="text-gray-600 mb-2">No Products Found</h3>
                                    <p class="text-gray-500 mb-4">
                                        We couldn't find any products matching your search criteria.
                                    </p>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- Pagination Start -->
                    <?php if ($hasProducts && $pagination): ?>
                        <ul class="pagination flex-center flex-wrap gap-16">
                            <!-- Previous Button -->
                            <li class="page-item <?= $pagination['currentPage'] <= 1 ? 'disabled' : '' ?>">
                                <a class="page-link h-64 w-64 flex-center text-xxl rounded-8 fw-medium text-neutral-600 border border-gray-100"
                                    href="<?= $pagination['currentPage'] > 1 ? '?' . http_build_query(array_merge($_GET, ['page' => $pagination['currentPage'] - 1])) : '#' ?>"
                                    <?= $pagination['currentPage'] <= 1 ? 'onclick="return false;"' : '' ?>>
                                    <i class="ph-bold ph-arrow-left"></i>
                                </a>
                            </li>

                            <!-- First Page -->
                            <?php if ($pagination['currentPage'] > 3): ?>
                                <li class="page-item">
                                    <a class="page-link h-64 w-64 flex-center text-md rounded-8 fw-medium text-neutral-600 border border-gray-100"
                                        href="?<?= http_build_query(array_merge($_GET, ['page' => 1])) ?>">01</a>
                                </li>
                                <?php if ($pagination['currentPage'] > 4): ?>
                                    <li class="page-item disabled">
                                        <span
                                            class="page-link h-64 w-64 flex-center text-md rounded-8 fw-medium text-neutral-600 border border-gray-100">...</span>
                                    </li>
                                <?php endif; ?>
                            <?php endif; ?>

                            <!-- Page Numbers -->
                            <?php
                            $startPage = max(1, $pagination['currentPage'] - 2);
                            $endPage = min($pagination['lastPage'], $pagination['currentPage'] + 2);

                            for ($i = $startPage; $i <= $endPage; $i++): ?>
                                <li class="page-item <?= $i == $pagination['currentPage'] ? 'active' : '' ?>">
                                    <a class="page-link h-64 w-64 flex-center text-md rounded-8 fw-medium text-neutral-600 border border-gray-100
                    <?= $i == $pagination['currentPage'] ? 'bg-main-600 text-white border-main-600' : '' ?>"
                                        href="?<?= http_build_query(array_merge($_GET, ['page' => $i])) ?>">
                                        <?= str_pad($i, 2, '0', STR_PAD_LEFT) ?>
                                    </a>
                                </li>
                            <?php endfor; ?>

                            <!-- Last Page -->
                            <?php if ($pagination['currentPage'] < $pagination['lastPage'] - 2): ?>
                                <?php if ($pagination['currentPage'] < $pagination['lastPage'] - 3): ?>
                                    <li class="page-item disabled">
                                        <span
                                            class="page-link h-64 w-64 flex-center text-md rounded-8 fw-medium text-neutral-600 border border-gray-100">...</span>
                                    </li>
                                <?php endif; ?>
                                <li class="page-item">
                                    <a class="page-link h-64 w-64 flex-center text-md rounded-8 fw-medium text-neutral-600 border border-gray-100"
                                        href="?<?= http_build_query(array_merge($_GET, ['page' => $pagination['lastPage']])) ?>">
                                        <?= str_pad($pagination['lastPage'], 2, '0', STR_PAD_LEFT) ?>
                                    </a>
                                </li>
                            <?php endif; ?>

                            <!-- Next Button -->
                            <li
                                class="page-item <?= $pagination['currentPage'] >= $pagination['lastPage'] ? 'disabled' : '' ?>">
                                <a class="page-link h-64 w-64 flex-center text-xxl rounded-8 fw-medium text-neutral-600 border border-gray-100"
                                    href="<?= $pagination['currentPage'] < $pagination['lastPage'] ? '?' . http_build_query(array_merge($_GET, ['page' => $pagination['currentPage'] + 1])) : '#' ?>"
                                    <?= $pagination['currentPage'] >= $pagination['lastPage'] ? 'onclick="return false;"' : '' ?>>
                                    <i class="ph-bold ph-arrow-right"></i>
                                </a>
                            </li>
                        </ul>
                    <?php endif; ?>
                    <!-- Pagination End -->


                </div>
            </div>
    </section>
    <!-- =============================== Shop Section End ======================================== -->

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
            let productIds = JSON.parse(localStorage.getItem('cart')) || [];
            // Always update count directly
            $(".cart-item-count").text(productIds.length);

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
                        confirmButtonText: 'Continue Shopping',
                        timer: 3000,
                        showConfirmButton: false,
                        timerProgressBar: true,
                    }).then((result) => {
                        // Optional: Redirect or refresh if needed
                        window.location.href = '';

                    });
                } else if (cart.includes(productId)) {
                    // Show warning if product is already in cart
                    Swal.fire({
                        title: 'Already in Cart',
                        text: 'This product is already in your cart!',
                        icon: 'info',
                        confirmButtonText: 'Continue Shopping',
                        timer: 3000,
                        showConfirmButton: false,
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

            $(document).on("click", ".add-to-wishlist", function (e) {
                e.preventDefault();

                // Get the product ID from data attribute
                let productId = $(this).data("product-id");
                console.log('Adding product ID:', productId);



                // Retrieve existing cart from localStorage or initialize empty array
                let wishlist = JSON.parse(localStorage.getItem('wishlist')) || [];


                // Add productId to cart if not already present
                if (productId && !wishlist.includes(productId)) {
                    wishlist.push(productId);
                    // Save updated cart to localStorage
                    localStorage.setItem('wishlist', JSON.stringify(wishlist));


                    // Show success message using SweetAlert
                    Swal.fire({
                        title: 'Added to Wishlist',
                        text: 'Product added to wishlist successfully!',
                        icon: 'success',
                        timer: 3000,
                        showConfirmButton: false,
                        timerProgressBar: true,
                        willClose: () => {
                            window.location.href = '';
                        }
                    });

                } else if (wishlist.includes(productId)) {
                    // Show warning if product is already in cart
                    Swal.fire({
                        title: 'Already in Wishlist',
                        text: 'This product is already in your wishlist!',
                        icon: 'info',
                        confirmButtonText: 'Continue Shopping',
                        timer: 3000,
                        showConfirmButton: false,
                        timerProgressBar: true,
                    });
                } else {
                    // Show error if productId is invalid
                    Swal.fire({
                        text: 'Unable to add product to wishlist. Invalid product ID.',
                        icon: 'error',
                        confirmButtonText: 'OK',
                        timer: 3000,
                        showConfirmButton: false,
                        timerProgressBar: true,
                    });
                }

                // Always update count directly


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




            // Handle filter button click
            $(document).on("click", ".btn.btn-main", function (e) {
                e.preventDefault();
                // Get current price range
                const minPrice = $("#slider-range").slider("values", 0);
                const maxPrice = $("#slider-range").slider("values", 1);

                window.location.href = `${window.location.origin}${window.location.pathname}?minPrice=${minPrice}?maxPrice=${maxPrice}`;
            });

            $(document).on("change", ".size-filter", function (e) {
                let size = $(this).data("size");
                window.location.href = `${window.location.origin}${window.location.pathname}?size=${size}`;
            });
            $(document).on("change", ".color-filter", function (e) {
                let color = $(this).data("color");
                window.location.href = `${window.location.origin}${window.location.pathname}?color=${color}`;
            });
            $(document).on("change", ".brand-filter", function (e) {
                let brand = $(this).data("brand");
                window.location.href = `${window.location.origin}${window.location.pathname}?brand=${brand}`;
            });


            // Your filter function
            function applyFilters() {
                // Get current price range
                const minPrice = $("#slider-range").slider("values", 0);
                const maxPrice = $("#slider-range").slider("values", 1);

                console.log({
                    minPrice: minPrice,
                    maxPrice: maxPrice,
                });
            }


        })



        $(document).ready(function () {
            // Initialize price range slider
            function initializePriceSlider() {
                // Get current price values from URL or use defaults
                const urlParams = new URLSearchParams(window.location.search);
                const currentMinPrice = parseFloat(urlParams.get('minPrice')) || 0;
                const currentMaxPrice = parseFloat(urlParams.get('maxPrice')) || 15000;

                $("#slider-range").slider({
                    range: true,
                    min: 0,
                    max: 15000,
                    values: [currentMinPrice, currentMaxPrice],
                    slide: function (event, ui) {
                        $("#amount").val("₹" + ui.values[0] + " - ₹" + ui.values[1]);
                    },
                    change: function (event, ui) {
                        // Optional: Auto-apply filter on change
                        // applyPriceFilter(ui.values[0], ui.values[1]);
                    }
                });

                // Set initial display
                $("#amount").val("₹" + $("#slider-range").slider("values", 0) +
                    " - ₹" + $("#slider-range").slider("values", 1));
            }

            // Apply price filter function
            function applyPriceFilter(minPrice, maxPrice) {
                const url = new URL(window.location);

                // Update or add price parameters
                url.searchParams.set('minPrice', minPrice);
                url.searchParams.set('maxPrice', maxPrice);

                // Reset to page 1 when applying new filters
                url.searchParams.set('page', 1);

                window.location.href = url.toString();
            }

            // Initialize the slider
            initializePriceSlider();

            // Handle filter button click
            $(document).on("click", ".btn.btn-main", function (e) {
                e.preventDefault();

                // Get current price range from slider
                const minPrice = $("#slider-range").slider("values", 0);
                const maxPrice = $("#slider-range").slider("values", 1);

                applyPriceFilter(minPrice, maxPrice);
            });

            // Your existing code for other filters...
            $(document).on("change", ".size-filter", function (e) {
                let size = $(this).data("size");
                updateUrlParameter('size', size);
            });

            $(document).on("change", ".color-filter", function (e) {
                let color = $(this).data("color");
                updateUrlParameter('color', color);
            });

            $(document).on("change", ".brand-filter", function (e) {
                let brand = $(this).data("brand");
                updateUrlParameter('brand', brand);
            });

            // Helper function to update URL parameters
            function updateUrlParameter(key, value) {
                const url = new URL(window.location);

                if (value) {
                    url.searchParams.set(key, value);
                } else {
                    url.searchParams.delete(key);
                }

                // Reset to page 1 when applying new filters
                url.searchParams.set('page', 1);

                window.location.href = url.toString();
            }
        });

        $(document).ready(function () {
    // Handle sorting change
    $(document).on("change", "#sorting", function (e) {
        const sortValue = $(this).val();
        updateUrlParameter('sort', sortValue);
    });

    // Helper function to update URL parameters
    function updateUrlParameter(key, value) {
        const url = new URL(window.location);

        if (value) {
            url.searchParams.set(key, value);
        } else {
            url.searchParams.delete(key);
        }

        // Reset to page 1 when applying new filters/sorting
        url.searchParams.set('page', 1);

        window.location.href = url.toString();
    }

    // Your existing price slider and filter code...
    function initializePriceSlider() {
        const urlParams = new URLSearchParams(window.location.search);
        const currentMinPrice = parseFloat(urlParams.get('minPrice')) || 0;
        const currentMaxPrice = parseFloat(urlParams.get('maxPrice')) || 15000;

        $("#slider-range").slider({
            range: true,
            min: 0,
            max: 15000,
            values: [currentMinPrice, currentMaxPrice],
            slide: function (event, ui) {
                $("#amount").val("₹" + ui.values[0] + " - ₹" + ui.values[1]);
            }
        });

        $("#amount").val("₹" + $("#slider-range").slider("values", 0) +
            " - ₹" + $("#slider-range").slider("values", 1));
    }

    // Apply price filter function
    function applyPriceFilter(minPrice, maxPrice) {
        const url = new URL(window.location);
        url.searchParams.set('minPrice', minPrice);
        url.searchParams.set('maxPrice', maxPrice);
        url.searchParams.set('page', 1);
        window.location.href = url.toString();
    }

    // Initialize the slider
    initializePriceSlider();

    // Handle filter button click
    $(document).on("click", ".btn.btn-main", function (e) {
        e.preventDefault();
        const minPrice = $("#slider-range").slider("values", 0);
        const maxPrice = $("#slider-range").slider("values", 1);
        applyPriceFilter(minPrice, maxPrice);
    });

    // Your existing filter handlers
    $(document).on("change", ".size-filter", function (e) {
        let size = $(this).data("size");
        updateUrlParameter('size', size);
    });

    $(document).on("change", ".color-filter", function (e) {
        let color = $(this).data("color");
        updateUrlParameter('color', color);
    });

    $(document).on("change", ".brand-filter", function (e) {
        let brand = $(this).data("brand");
        updateUrlParameter('brand', brand);
    });
});

    </script>



</body>

</html>