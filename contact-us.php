<?php
session_start();
require __DIR__ . "/api/api.php";
require __DIR__ . "/utils/utils.php";
error_reporting(E_ALL);
ini_set("display_errors", 1);
$utils = new Utils;

// Handle contact form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['contact_submit'])) {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $subject = trim($_POST['subject'] ?? '');
    $message = trim($_POST['message'] ?? '');

    // Basic validation
    $errors = [];
    if (empty($name)) {
        $errors[] = "Name is required";
    }
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Valid email is required";
    }
    if (empty($phone)) {
        $errors[] = "Phone number is required";
    }
    if (empty($subject)) {
        $errors[] = "Subject is required";
    }
    if (empty($message)) {
        $errors[] = "Message is required";
    }

    if (empty($errors)) {
        // Prepare contact data
        $contactData = [
            "name" => $name,
            "email" => $email,
            "phone" => $phone,
            "subject" => $subject,
            "message" => $message
        ];

        // Get contact API endpoint
        $contactApi = getenv("Create_Contact_API");
        if ($contactApi) {
            // Send data to API
            $result = $utils->sendToApi($contactData, $contactApi);
            if ($result && $result['success']) {
                $_SESSION['notyf'] = [
                    'type' => 'success',
                    'message' => "Thank you for your message! We'll get back to you soon."
                ];
                // Clear form data after successful submission
                unset($_SESSION['form_data']);
            } else {
                $errorMessage = $result['message'] ?? 'Failed to send message. Please try again.';
                $_SESSION['notyf'] = [
                    'type' => 'error',
                    'message' => $errorMessage
                ];
                $_SESSION['form_data'] = $_POST; // Store form data for repopulation
            }
        } else {
            $_SESSION['notyf'] = [
                'type' => 'error',
                'message' => "Contact API endpoint not configured."
            ];
            $_SESSION['form_data'] = $_POST;
        }

        // Redirect to prevent form resubmission
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    } else {
        $_SESSION['notyf'] = [
            'type' => 'error',
            'message' => implode(", ", $errors)
        ];
        $_SESSION['form_data'] = $_POST; // Store form data for repopulation
    }
}

// Get stored form data if available
$formData = $_SESSION['form_data'] ?? [];
unset($_SESSION['form_data']); // Clear after use

// Your existing API endpoints and data fetching
$fetchAllMediaApi = getenv("FETCH_ALL_MEDIA_API");
$fetchAllProductApi = getenv("FETCH_ALL_PRODUCT_API");
$fetchAllProductCategoryApi = getenv("FETCH_ALL_PRODUCT_CATEGORY_API");
$subscribeNewsLetterApi = getenv("NEWSLETTER_SUBSCRIBE");

// response data
$resultMedia = $utils->fetchFromApi($fetchAllMediaApi);
$resultProduct = $utils->fetchFromApi($fetchAllProductApi);
$resultProductCategory = $utils->fetchFromApi($fetchAllProductCategoryApi);

// Filter the data to include only items with category "BANNER"
$bannerImages = array_filter($resultMedia['data']['data'] ?? [], function ($item) {
    return isset($item['category']) && $item['category'] === 'BANNER';
});

$heroSectionImages = array_filter($resultMedia['data']['data'] ?? [], function ($item) {
    return isset($item['category']) && $item['category'] === 'HEROSECTION';
});

$advertisementImages = array_filter($resultMedia['data']['data'] ?? [], function ($item) {
    return isset($item['category']) && $item['category'] === 'ADVERTISEMENT';
});

$productsImages = array_filter($resultMedia['data']['data'] ?? [], function ($item) {
    return isset($item['category']) && $item['category'] === 'PRODUCT';
});
?>

<!DOCTYPE html>
<html lang="en" class="color-two font-exo header-style-two">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Title -->
    <title>Contact Us</title>
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
    <!-- Notyf -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">
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
        <button type="button" class="close-button">
            <i class="ph ph-x"></i>
        </button>
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
                <h6 class="mb-0">Contact</h6>
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
                    <li class="text-sm text-main-600">Contact</li>
                </ul>
            </div>
        </div>
    </div>
    <!-- ========================= Breadcrumb End =============================== -->

    <!-- ============================ Contact Section Start ================================== -->
    <section class="contact py-80">
        <div class="container container-lg">
            <div class="row gy-5">
                <div class="col-lg-8">
                    <div class="contact-box border border-gray-100 rounded-16 px-24 py-40">
                        <form action="" method="POST" id="contactForm">
                            <h6 class="mb-32">Make Custom Request</h6>
                            <div class="row gy-4">
                                <div class="col-sm-6 col-xs-6">
                                    <label for="name"
                                        class="flex-align gap-4 text-sm font-heading-two text-gray-900 fw-semibold mb-4">Full
                                        Name <span class="text-danger text-xl line-height-1">*</span></label>
                                    <input type="text" class="common-input px-16" id="name" name="name"
                                        placeholder="Full name" value="<?= htmlspecialchars($formData['name'] ?? '') ?>"
                                        required>
                                </div>
                                <div class="col-sm-6 col-xs-6">
                                    <label for="email"
                                        class="flex-align gap-4 text-sm font-heading-two text-gray-900 fw-semibold mb-4">Email
                                        Address <span class="text-danger text-xl line-height-1">*</span></label>
                                    <input type="email" class="common-input px-16" id="email" name="email"
                                        placeholder="Email address"
                                        value="<?= htmlspecialchars($formData['email'] ?? '') ?>" required>
                                </div>
                                <div class="col-sm-6 col-xs-6">
                                    <label for="phone"
                                        class="flex-align gap-4 text-sm font-heading-two text-gray-900 fw-semibold mb-4">Phone
                                        Number<span class="text-danger text-xl line-height-1">*</span></label>
                                    <input type="tel" class="common-input px-16" id="phone" name="phone"
                                        placeholder="Phone Number"
                                        value="<?= htmlspecialchars($formData['phone'] ?? '') ?>" required>
                                </div>
                                <div class="col-sm-6 col-xs-6">
                                    <label for="subject"
                                        class="flex-align gap-4 text-sm font-heading-two text-gray-900 fw-semibold mb-4">Subject
                                        <span class="text-danger text-xl line-height-1">*</span></label>
                                    <input type="text" class="common-input px-16" id="subject" name="subject"
                                        placeholder="Subject"
                                        value="<?= htmlspecialchars($formData['subject'] ?? '') ?>" required>
                                </div>
                                <div class="col-sm-12">
                                    <label for="message"
                                        class="flex-align gap-4 text-sm font-heading-two text-gray-900 fw-semibold mb-4">Message
                                        <span class="text-danger text-xl line-height-1">*</span></label>
                                    <textarea class="common-input px-16" id="message" name="message"
                                        placeholder="Type your message" rows="5"
                                        required><?= htmlspecialchars($formData['message'] ?? '') ?></textarea>
                                </div>
                                <div class="col-sm-12 mt-32">
                                    <button type="submit" name="contact_submit"
                                        class="btn btn-main py-18 px-32 rounded-8">
                                        Get a Quote
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="contact-box border border-gray-100 rounded-16 px-24 py-40">
                        <h6 class="mb-48">Get In Touch</h6>
                        <div class="flex-align gap-16 mb-16">
                            <span
                                class="w-40 h-40 flex-center rounded-circle border border-gray-100 text-main-two-600 text-2xl flex-shrink-0"><i
                                    class="ph-fill ph-phone-call"></i></span>
                            <a href="tel:+00123456789" class="text-md text-gray-900 hover-text-main-600">+00 123 456
                                789</a>
                        </div>
                        <div class="flex-align gap-16 mb-16">
                            <span
                                class="w-40 h-40 flex-center rounded-circle border border-gray-100 text-main-two-600 text-2xl flex-shrink-0"><i
                                    class="ph-fill ph-envelope"></i></span>
                            <a href="mailto:support24@marketpro.com"
                                class="text-md text-gray-900 hover-text-main-600">support24@marketpro.com</a>
                        </div>
                        <div class="flex-align gap-16 mb-0">
                            <span
                                class="w-40 h-40 flex-center rounded-circle border border-gray-100 text-main-two-600 text-2xl flex-shrink-0"><i
                                    class="ph-fill ph-map-pin"></i></span>
                            <span class="text-md text-gray-900 ">789 Inner Lane, California, USA</span>
                        </div>
                    </div>
                    <div class="mt-24 flex-align flex-wrap gap-16">
                        <a href="#"
                            class="bg-neutral-600 hover-bg-main-600 rounded-8 p-10 px-16 flex-between flex-wrap gap-8 flex-grow-1">
                            <span class="text-white fw-medium">Get Support On Call</span>
                            <span class="w-36 h-36 bg-main-600 rounded-8 flex-center text-xl text-white"><i
                                    class="ph ph-headset"></i></span>
                        </a>
                        <a href="#"
                            class="bg-neutral-600 hover-bg-main-600 rounded-8 p-10 px-16 flex-between flex-wrap gap-8 flex-grow-1">
                            <span class="text-white fw-medium">Get Direction</span>
                            <span class="w-36 h-36 bg-main-600 rounded-8 flex-center text-xl text-white"><i
                                    class="ph ph-map-pin"></i></span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ============================ Contact Section End ================================== -->

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
                            <h6 class="mb-0">100% Satisfaction</h6>
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
                            <h6 class="mb-0">Secure Payments</h6>
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
                            <h6 class="mb-0">24/7 Support</h6>
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
    <!-- Notyf -->
    <script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>
    <!-- main js -->
    <script src="assets/js/main.js"></script>

    <script>
        // Initialize Notyf
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


        // Show notification if exists
        <?php if (isset($_SESSION['notyf'])): ?>
            <?php $notyf = $_SESSION['notyf'];
            unset($_SESSION['notyf']); ?>
            notyf.<?= $notyf['type'] ?>("<?= $notyf['message'] ?>");
        <?php endif; ?>

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
                            logoSection.append(`<img src="${item.image}" alt="${item.title}"/>`);
                        });
                    }
                },
                error: function (xhr) {
                    console.log(xhr);
                },
            });

            // AJAX contact form submission (optional - you can keep the current PHP submission)
            $(document).on("submit", "#contactForm", function (e) {
                // You can implement AJAX submission here if needed
                // For now, the form will submit normally via PHP
            });
        })
    </script>
</body>

</html>