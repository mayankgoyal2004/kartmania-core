<?php
session_start();
require __DIR__ . "/api/api.php";
require __DIR__ . "/utils/utils.php";
error_reporting(E_ALL);
ini_set("", 1);

$utils = new Utils;

// Add these API endpoints that are required by header component
$fetchAllProductCategoryApi = getenv("FETCH_ALL_PRODUCT_CATEGORY_API");
$fetchAllMediaApi = getenv("FETCH_ALL_MEDIA_API");

// Fetch data required by header component
$resultProductCategory = $utils->fetchFromApi($fetchAllProductCategoryApi);
$resultMedia = $utils->fetchFromApi($fetchAllMediaApi);

// Get the blog parameter from URL (matches your .htaccess rule)
$slug = isset($_GET['blog']) ? $_GET['blog'] : '';

// Fetch blog details
$fetchSingleBlogApi = getenv("FETCH_Single_Blog_API");
$blogDetails = $utils->fetchFromApi($fetchSingleBlogApi . '/' . $slug);

// Check if blog exists
if (isset($blogDetails['data']) && !empty($blogDetails['data'])) {
    $blog = $blogDetails['data']["data"];
    $title = $blog['title'] ?? 'Blog Details';
    $content = $blog['content'] ?? '';
    $categoryName = $blog['category']['name'] ?? 'Uncategorized';
    
    // Function to get primary image
    function getPrimaryImage($images) {
        foreach ($images as $image) {
            if ($image['isPrimary'] === true) {
                return $image['imageUrl'];
            }
        }
       $images[0]['imageUrl'] ;
    }
    
    $primaryImage = getPrimaryImage($blog['images'] ?? []);
    
    // Function to format date
    function formatDate($dateString) {
        $date = DateTime::createFromFormat('Y-m-d\TH:i:s.v\Z', $dateString);
        return $date ? $date->format('F j, Y') : 'Date not available';
    }
    
    $createdAt = formatDate($blog['createdAt'] ?? '');
} else {
    // Blog not found
    header("HTTP/1.0 404 Not Found");
    $title = "Blog Not Found";
    $content = "<p class='text-center py-5'>The blog post you're looking for doesn't exist.</p>";
    $categoryName = "Not Found";
    $primaryImage = 'assets/images/thumbs/blog-placeholder.png';
    $createdAt = 'Date not available';
}
?>
<!DOCTYPE html>
<html lang="en" class="color-two font-exo header-style-two">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Title -->
    <title><?= htmlspecialchars($title) ?> - Blog Details</title>
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
                <h6 class="mb-0"><?= htmlspecialchars($title) ?></h6>
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
                  
                   
                    <li class="text-sm text-main-600"><?= htmlspecialchars($title) ?></li>
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
                            <img src="<?= $primaryImage ?>" alt="<?= htmlspecialchars($title) ?>" class="cover-img rounded-16" style="height: 400px; object-fit: cover;">
                            <div class="blog-item__content mt-24">
                                <span class="bg-main-50 text-main-600 py-4 px-24 rounded-8 mb-16">
                                    <?= htmlspecialchars($categoryName) ?>
                                </span>
                                <h4 class="mb-24"><?= htmlspecialchars($title) ?></h4>
                                
                                <!-- Display the actual blog content -->
                                <div class="blog-content text-gray-700">
                                    <?= nl2br(htmlspecialchars($content)) ?>
                                </div>

                                <div class="flex-align flex-wrap gap-24 pt-24 mt-24 border-top border-gray-100">
                                    <div class="flex-align flex-wrap gap-8">
                                        <span class="text-lg text-main-600"><i class="ph ph-calendar-dots"></i></span>
                                        <span class="text-sm text-gray-500">
                                            <?= $createdAt ?>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Navigation between blog posts -->
                    <!-- <div class="my-48 flex-between flex-sm-nowrap flex-wrap gap-24">
                        <div class="">
                            <button type="button"
                                class="mb-20 h6 text-gray-500 text-lg fw-normal hover-text-main-600">Previous
                                Post</button>
                          
                        </div>
                        <div class="text-end">
                            <button type="button"
                                class="mb-20 h6 text-gray-500 text-lg fw-normal hover-text-main-600">Next</button>
                            <h6 class="text-lg mb-0">
                                <a href="blog" class="">More Blog Posts</a>
                            </h6>
                        </div>
                    </div> -->

                </div>
                <!-- <div class="col-lg-4 ps-xl-4">
                 
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
                    </div> -->
                    <!-- Search End -->

                    <!-- Recent Post Start -->
                    <!-- <div class="blog-sidebar border border-gray-100 rounded-8 p-32 mb-40">
                        <h6 class="text-xl mb-32 pb-32 border-bottom border-gray-100">Recent Posts</h6>
                        <div class="d-flex align-items-center flex-sm-nowrap flex-wrap gap-24 mb-16"> -->
                            <!-- <a href="blog"
                                class="w-100 h-100 rounded-4 overflow-hidden w-120 h-120 flex-shrink-0">
                                <img src="assets/images/thumbs/recent-post1.png" alt="" class="cover-img">
                            </a> -->
                            <!-- <div class="flex-grow-1">
                                <h6 class="text-lg">
                                    <a href="blog" class="text-line-3">Explore more blog posts</a>
                                </h6>
                                <div class="flex-align flex-wrap gap-8">
                                    <span class="text-lg text-main-600"><i class="ph ph-calendar-dots"></i></span>
                                    <span class="text-sm text-gray-500">
                                        <a href="blog" class="text-gray-500 hover-text-main-600">Recent</a>
                                    </span>
                                </div>
                            </div>
                        </div> -->
                        <!-- Add more static recent posts or make them dynamic -->
                    </div>
                    <!-- Recent Post End -->

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
            let productIdsCart = JSON.parse(localStorage.getItem('cart')) || [];
            $(".cart-item-count").text(productIdsCart.length);

            let productIdsWishlist = JSON.parse(localStorage.getItem('wishlist')) || [];
            $(".wishlist-item-count").text(productIdsWishlist.length);

            $.ajax({
                url: "<?php echo getenv("FETCH_ALL_MEDIA_API") ?>",
                type: "get",
                success: function (response, textStatus, xhr) {
                    if (response.data && Array.isArray(response.data)) {
                        const logoItems = response.data.filter(item => item.category === "LOGO");
                        logoItems.forEach(item => {
                            let logoSection = $(".logo .link");
                            logoSection.empty();
                            logoSection.append(`<img src="${item.image}" alt="${item.title}"/>`);
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