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
    <title>Checkout</title>
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
                <h6 class="mb-0">Checkout</h6>
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
                    <li class="text-sm text-main-600"> Checkout </li>
                </ul>
            </div>
        </div>
    </div>
    <!-- ========================= Breadcrumb End =============================== -->

    <!-- ================================= Checkout Page Start ===================================== -->
    <section class="checkout py-80">
        <div class="container container-lg">
            <div class="border border-gray-100 rounded-8 px-30 py-20 mb-40">
                <span class="">Have a coupon? <a href="<?= getenv("BASE_URL") . "/cart" ?>"
                        class="fw-semibold text-gray-900 hover-text-decoration-underline hover-text-main-600">Click here
                        to enter your code</a> </span>
            </div>
            <div class="row">
                <div class="col-xl-9 col-lg-8">
                    <form action="" class="pe-xl-5 ">
                        <div class="row gy-3">
                            <div class="col-sm-6 col-xs-6">
                                <input type="text" class="common-input border-gray-100" placeholder="First Name">
                            </div>
                            <div class="col-sm-6 col-xs-6">
                                <input type="text" class="common-input border-gray-100" placeholder="Last Name">
                            </div>
                            <div class="col-12">
                                <input type="text" class="common-input border-gray-100" placeholder="Business Name">
                            </div>
                            <div class="col-12">
                                <input type="text" class="common-input border-gray-100"
                                    placeholder="United states (US)">
                            </div>
                            <div class="col-12">
                                <input type="text" class="common-input border-gray-100"
                                    placeholder="House number and street name">
                            </div>
                            <div class="col-12">
                                <input type="text" class="common-input border-gray-100"
                                    placeholder="Apartment, suite, unit, etc. (Optional)">
                            </div>
                            <div class="col-12">
                                <input type="text" class="common-input border-gray-100" placeholder="City">
                            </div>
                            <div class="col-12">
                                <input type="text" class="common-input border-gray-100" placeholder="Sans Fransisco">
                            </div>
                            <div class="col-12">
                                <input type="text" class="common-input border-gray-100" placeholder="Post Code">
                            </div>
                            <div class="col-12">
                                <input type="number" class="common-input border-gray-100" placeholder="Phone">
                            </div>
                            <div class="col-12">
                                <input type="email" class="common-input border-gray-100" placeholder="Email Address">
                            </div>

                            <div class="col-12">
                                <div class="my-40">
                                    <h6 class="text-lg mb-24">Additional Information</h6>
                                    <input type="text" class="common-input border-gray-100"
                                        placeholder="Notes about your order, e.g. special notes for delivery.">
                                </div>
                            </div>

                        </div>
                    </form>
                </div>
                <div class="col-xl-3 col-lg-4">
                    <div class="checkout-sidebar">
                        <div class="bg-color-three rounded-8 p-24 text-center">
                            <span class="text-gray-900 text-xl fw-semibold">Your Orders</span>
                        </div>

                        <div class="border border-gray-100 rounded-8 px-10 py-40 mt-24">
                            <div class="mb-32 pb-32 border-bottom border-gray-100 flex-between gap-8">
                                <span class="text-gray-900 fw-medium text-xl font-heading-two">Product</span>
                                <span class="text-gray-900 fw-medium text-xl font-heading-two">Subtotal</span>
                            </div>

                            <div class="product-list">
                                <div class="flex-between gap-24 mb-32">
                                    <div class="flex-align gap-12">
                                        <span class="text-gray-900 fw-normal text-md font-heading-two w-144">HP
                                            Chromebook
                                            With Intel Celeron</span>
                                        <span class="text-gray-900 fw-normal text-md font-heading-two"><i
                                                class="ph-bold ph-x"></i></span>
                                        <span class="text-gray-900 fw-semibold text-md font-heading-two">1</span>
                                    </div>
                                    <span class="text-gray-900 fw-bold text-md font-heading-two">$250.00</span>
                                </div>
                                <div class="flex-between gap-24 mb-32">
                                    <div class="flex-align gap-12">
                                        <span class="text-gray-900 fw-normal text-md font-heading-two w-144">HP
                                            Chromebook
                                            With Intel Celeron</span>
                                        <span class="text-gray-900 fw-normal text-md font-heading-two"><i
                                                class="ph-bold ph-x"></i></span>
                                        <span class="text-gray-900 fw-semibold text-md font-heading-two">1</span>
                                    </div>
                                    <span class="text-gray-900 fw-bold text-md font-heading-two">$250.00</span>
                                </div>
                                <div class="flex-between gap-24 mb-32">
                                    <div class="flex-align gap-12">
                                        <span class="text-gray-900 fw-normal text-md font-heading-two w-144">HP
                                            Chromebook
                                            With Intel Celeron</span>
                                        <span class="text-gray-900 fw-normal text-md font-heading-two"><i
                                                class="ph-bold ph-x"></i></span>
                                        <span class="text-gray-900 fw-semibold text-md font-heading-two">1</span>
                                    </div>
                                    <span class="text-gray-900 fw-bold text-md font-heading-two">$250.00</span>
                                </div>
                                <div class="flex-between gap-24 mb-32">
                                    <div class="flex-align gap-12">
                                        <span class="text-gray-900 fw-normal text-md font-heading-two w-144">HP
                                            Chromebook
                                            With Intel Celeron</span>
                                        <span class="text-gray-900 fw-normal text-md font-heading-two"><i
                                                class="ph-bold ph-x"></i></span>
                                        <span class="text-gray-900 fw-semibold text-md font-heading-two">1</span>
                                    </div>
                                    <span class="text-gray-900 fw-bold text-md font-heading-two">$250.00</span>
                                </div>
                            </div>

                          <!-- Update this section in your checkout page HTML -->
<div class="border-top border-gray-100 pt-30 mt-30">
    <div class="mb-24 flex-between gap-8">
        <span class="text-gray-900 font-heading-two text-xl fw-semibold">Subtotal</span>
        <span class="text-gray-900 font-heading-two text-md fw-bold checkout-subtotal">₹00.00</span>
    </div>
    <!-- Discount row will be dynamically inserted here -->
    <!-- <div class="mb-24 flex-between gap-8">
        <span class="text-gray-900 font-heading-two text-md fw-semibold">Tax</span>
        <span class="text-gray-900 font-heading-two text-md fw-bold">₹10.00</span>
    </div> -->
    <div class="mb-24 flex-between gap-8">
        <span class="text-gray-900 font-heading-two text-md fw-semibold">Shipping</span>
        <span class="text-success-600 font-heading-two text-md fw-bold">Free</span>
    </div>
    <div class="mb-0 flex-between gap-8">
        <span class="text-gray-900 font-heading-two text-xl fw-semibold">Total</span>
        <span class="text-gray-900 font-heading-two text-md fw-bold checkout-total">₹00.00</span>
    </div>
</div>
                        </div>

                        <div class="mt-32">
                            <div class="payment-item">
                                <div class="form-check common-check common-radio py-16 mb-0">
                                    <input class="form-check-input" type="radio" name="payment" id="payment1" checked>
                                    <label class="form-check-label fw-semibold text-neutral-600" for="payment1">Direct
                                        Bank transfer</label>
                                </div>
                                <div class="payment-item__content px-16 py-24 rounded-8 bg-main-50 position-relative">
                                    <p class="text-gray-800">Make your payment directly into our bank account. Please
                                        use your Order ID as the payment reference. Your order will not be shipped until
                                        the funds have cleared in our account.</p>
                                </div>
                            </div>
                            <div class="payment-item">
                                <div class="form-check common-check common-radio py-16 mb-0">
                                    <input class="form-check-input" type="radio" name="payment" id="payment2">
                                    <label class="form-check-label fw-semibold text-neutral-600" for="payment2">Check
                                        payments</label>
                                </div>
                                <div class="payment-item__content px-16 py-24 rounded-8 bg-main-50 position-relative">
                                    <p class="text-gray-800">Make your payment directly into our bank account. Please
                                        use your Order ID as the payment reference. Your order will not be shipped until
                                        the funds have cleared in our account.</p>
                                </div>
                            </div>
                            <div class="payment-item">
                                <div class="form-check common-check common-radio py-16 mb-0">
                                    <input class="form-check-input" type="radio" name="payment" id="payment3">
                                    <label class="form-check-label fw-semibold text-neutral-600" for="payment3">Cash on
                                        delivery</label>
                                </div>
                                <div class="payment-item__content px-16 py-24 rounded-8 bg-main-50 position-relative">
                                    <p class="text-gray-800">Make your payment directly into our bank account. Please
                                        use your Order ID as the payment reference. Your order will not be shipped until
                                        the funds have cleared in our account.</p>
                                </div>
                            </div>
                        </div>

                        <div class="mt-32 pt-32 border-top border-gray-100">
                            <p class="text-gray-500">Your personal data will be used to process your order, support your
                                experience throughout this website, and for other purposes described in our <a href="#"
                                    class="text-main-600 text-decoration-underline"> privacy policy</a> .</p>
                        </div>

                        <a href="javascript:void(0);"
                            class="btn btn-main mt-40 py-18 w-100 rounded-8 mt-56 checkout-form">Place
                            Order</a>

                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ================================= Checkout Page End ===================================== -->

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

        let baseUrl = `<?= getenv("BASE_URL") ?>`;
        let productIds = JSON.parse(localStorage.getItem('cart')) || [];
        let cartQuantities = JSON.parse(localStorage.getItem('cartQuantities')) || {};

        if (productIds.length === 0) {
            Swal.fire({
                title: 'Empty Cart',
                text: 'Your cart is empty. Add some products!',
                icon: 'info',
                confirmButtonText: 'Shop Now'
            }).then(() => {
                window.location.href = `${baseUrl}/product`;
            });
            return;
        }

        let products = [];

        // Function to calculate discounted price (matching cart page logic)
        function calculateDiscountedPrice(originalPrice, discountValue, discountType) {
            let discountedPrice = originalPrice;
            
            if (discountValue > 0) {
                if (discountType === 'CASH') {
                    // Discount is in rupees
                    discountedPrice = Math.max(0, originalPrice - discountValue);
                } else if (discountType === 'PERCENTAGE') {
                    // Discount is percentage
                    discountedPrice = Math.max(0, originalPrice - (originalPrice * discountValue / 100));
                }
            }
            
            return discountedPrice;
        }

        // Function to get discount display text
        function getDiscountDisplay(discountValue, discountType) {
            if (discountValue > 0) {
                if (discountType === 'PERCENTAGE') {
                    return `-${discountValue}% OFF`;
                } else if (discountType === 'CASH') {
                    return `-₹${discountValue} OFF`;
                }
            }
            return '';
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
                }
            })
        )).then(() => {
            // Function to populate the order list with product data
            function populateOrderList(products) {
                let orderList = $('.product-list');
                orderList.empty();

                let subtotal = 0;
                let totalDiscount = 0;

                products.forEach(product => {
                    // Get discount values (matching cart page logic)
                    let originalPrice = parseFloat(product.price) || 0;
                    let discountValue = parseFloat(product.discountValue) || 0;
                    let discountType = (product.discount || '').toUpperCase();
                    
                    // Calculate discounted price
                    let discountedPrice = calculateDiscountedPrice(originalPrice, discountValue, discountType);
                    let discountAmount = originalPrice - discountedPrice;
                    
                    // Get quantity from localStorage or default to 1
                    let quantity = cartQuantities[product.id] || 1;
                    
                    let productSubtotal = discountedPrice * quantity;
                    let productDiscount = discountAmount * quantity;
                    
                    subtotal += productSubtotal;
                    totalDiscount += productDiscount;

                    let list = `
                        <div class="flex-between gap-24 mb-32" data-product-id="${product.id}">
                            <div class="flex-align gap-12">
                                <span class="text-gray-900 fw-normal text-md font-heading-two w-144">${product.name}</span>
                                <span class="text-gray-900 fw-normal text-md font-heading-two"><i class="ph-bold ph-x"></i></span>
                                <span class="text-gray-900 fw-semibold text-md font-heading-two">${quantity}</span>
                            </div>
                            <div class="text-right">
                                ${discountValue > 0 ? `
                                <div class="text-sm text-gray-400 text-decoration-line-through">₹${(originalPrice * quantity).toFixed(2)}</div>
                                ` : ''}
                                <span class="text-gray-900 fw-bold text-md font-heading-two">₹${productSubtotal.toFixed(2)}</span>
                                ${discountValue > 0 ? `
                                <div class="text-xs text-success-600">Saved: ₹${productDiscount.toFixed(2)}</div>
                                ` : ''}
                            </div>
                        </div>
                    `;
                    orderList.append(list);
                });

                // Update totals
                updateCheckoutTotals(subtotal, totalDiscount);
            }

            // Function to update checkout totals
            function updateCheckoutTotals(subtotal, totalDiscount) {
                // let tax = 10.00;
                let shipping = 0;
                let finalTotal = subtotal + shipping;

                // Update the display
                $('.checkout-subtotal').text(`₹${subtotal.toFixed(2)}`);
                $('.checkout-total').text(`₹${finalTotal.toFixed(2)}`);

                // Remove existing discount row if any
                $('.discount-row').remove();

                // Add discount row if there's any discount
                if (totalDiscount > 0) {
                    $('.checkout-subtotal').closest('.flex-between').after(`
                        <div class="mb-24 flex-between gap-8 discount-row">
                            <span class="text-gray-900 font-heading-two text-md fw-semibold">Discount</span>
                            <span class="text-success-600 font-heading-two text-md fw-bold">-₹${totalDiscount.toFixed(2)}</span>
                        </div>
                    `);
                }
            }

            // Call the function to populate the order list
            populateOrderList(products);

            if (products.length === 0) {
                Swal.fire({
                    title: 'Error',
                    text: 'No products found in cart.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
                return;
            }
        });

        $(document).on('click', '.checkout-form', function (e) {
            e.preventDefault();

            // Basic form validation
            let firstName = $('input[placeholder="First Name"]').val();
            let lastName = $('input[placeholder="Last Name"]').val();
            let email = $('input[placeholder="Email Address"]').val();
            let phone = $('input[placeholder="Phone"]').val();
            let address = $('input[placeholder="House number and street name"]').val();
            let city = $('input[placeholder="City"]').val();

            if (!firstName || !lastName || !email || !phone || !address || !city) {
                Swal.fire({
                    title: 'Missing Information',
                    text: 'Please fill in all required fields.',
                    icon: 'warning',
                    confirmButtonText: 'OK'
                });
                return;
            }

            // Validate email format
            let emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(email)) {
                Swal.fire({
                    title: 'Invalid Email',
                    text: 'Please enter a valid email address.',
                    icon: 'warning',
                    confirmButtonText: 'OK'
                });
                return;
            }

            // Get selected payment method
            let paymentMethod = $('input[name="payment"]:checked').next('label').text();

            // Prepare order data
            let orderData = {
                customer: {
                    firstName: firstName,
                    lastName: lastName,
                    email: email,
                    phone: phone,
                    address: address,
                    city: city,
                    businessName: $('input[placeholder="Business Name"]').val(),
                    country: $('input[placeholder="United states (US)"]').val(),
                    apartment: $('input[placeholder="Apartment, suite, unit, etc. (Optional)"]').val(),
                    state: $('input[placeholder="Sans Fransisco"]').val(),
                    postCode: $('input[placeholder="Post Code"]').val(),
                    notes: $('input[placeholder="Notes about your order..."]').val()
                },
                products: productIds.map(id => ({
                    productId: id,
                    quantity: cartQuantities[id] || 1
                })),
                paymentMethod: paymentMethod,
                subtotal: parseFloat($('.checkout-subtotal').text().replace('₹', '')),
                total: parseFloat($('.checkout-total').text().replace('₹', '')),
                timestamp: new Date().toISOString()
            };

            console.log('Order Data:', orderData);

            // Show success message
            Swal.fire({
                title: 'Order Placed Successfully!',
                html: `
                    <div class="text-left">
                        <p><strong>Order Summary:</strong></p>
                        <p>Items: ${productIds.length}</p>
                        <p>Total: ${$('.checkout-total').text()}</p>
                        <p>Payment: ${paymentMethod}</p>
                        <p>We'll send a confirmation email to ${email}</p>
                    </div>
                `,
                icon: 'success',
                confirmButtonText: 'Continue Shopping',
                showCancelButton: true,
                cancelButtonText: 'View Order Details'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Clear cart and redirect to products
                    localStorage.removeItem('cart');
                    localStorage.removeItem('cartQuantities');
                    window.location.href = `${baseUrl}/product`;
                } else if (result.dismiss === Swal.DismissReason.cancel) {
                    // Keep cart for now and redirect to home or order details page
                    window.location.href = `${baseUrl}`;
                }
            });
        });

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
    });
</script>


</body>


</html>