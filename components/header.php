<?php
// Get the current page URL
$currentUrl = $_SERVER['REQUEST_URI'];
?>
<div class="flex-align menu-category-wrapper position-relative">

    <!-- Category Dropdown Start -->
    <div class="">
        <button type="button"
            class="category-button d-flex align-items-center gap-12 text-white bg-success-600 px-20 py-16 rounded-6 hover-bg-success-700 transition-2">
            <span class="text-xl line-height-1"><i class="ph ph-squares-four"></i></span>
            <span class="">Browse Categories</span>
            <span class="line-height-1 icon transition-2"><i class="ph-bold ph-caret-down"></i></span>
        </button>

        <!-- Dropdown Start -->
        <div
            class="category-dropdown border border-success-200 shadow bg-white p-16 rounded-16 w-100 max-w-472 position-absolute inset-block-start-100 inset-inline-start-0 z-99 transition-2">
            <div id="categoryGrid" class="d-grid grid-cols-3-repeat gap-4 max-h-350 overflow-y-auto">
                <?php $count = 0;
                foreach ($resultProductCategory['data']['data'] as $key => $category):
                    if ($count >= 9)
                        break; // Stop after 9 iterations
                    $count++; ?>
                    <a href="<?= getenv("BASE_URL") . "/product/category/" . $utils->makeSlug($category['name']); ?>"
                        class="py-16 px-8 rounded-8 hover-bg-main-50 d-flex flex-column align-items-center text-center border border-white hover-border-main-100">
                        <span class="">
                            <img src=" <?= $category['logo'] ? $category['logo'] : getenv("BASE_URL") . "/assets/images/icon/category-1.png" ?>"
                                alt="Icon" class="w-40">
                        </span>
                        <span class="fw-semibold text-heading mt-16 text-sm"><?= $category['name'] ?></span>
                    </a>
                <?php endforeach; ?>

                <?php if (empty($resultProductCategory['data']['data'])): ?>
                    <a href="shop.php"
                        class="py-16 px-8 rounded-8 hover-bg-main-50 d-flex flex-column align-items-center text-center border border-white hover-border-main-100">
                        <span class="">
                            <img src="<?= getenv("BASE_URL") . "/assets/" ?>images/icon/category-1.png" alt="Icon"
                                class="w-40">
                        </span>
                        <span class="fw-semibold text-heading mt-16 text-sm">Vegetables</span>
                    </a>
                    <a href="shop.php"
                        class="py-16 px-8 rounded-8 hover-bg-main-50 d-flex flex-column align-items-center text-center border border-white hover-border-main-100">
                        <span class="">
                            <img src="<?= getenv("BASE_URL") . "/assets/" ?>images/icon/category-2.png" alt="Icon"
                                class="w-40">
                        </span>
                        <span class="fw-semibold text-heading mt-16 text-sm">Milk & Cake</span>
                    </a>
                    <a href="shop.php"
                        class="py-16 px-8 rounded-8 hover-bg-main-50 d-flex flex-column align-items-center text-center border border-white hover-border-main-100">
                        <span class="">
                            <img src="<?= getenv("BASE_URL") . "/assets/" ?>images/icon/category-3.png" alt="Icon"
                                class="w-40">
                        </span>
                        <span class="fw-semibold text-heading mt-16 text-sm">Grocery</span>
                    </a>
                    <a href="shop.php"
                        class="py-16 px-8 rounded-8 hover-bg-main-50 d-flex flex-column align-items-center text-center border border-white hover-border-main-100">
                        <span class="">
                            <img src="<?= getenv("BASE_URL") . "/assets/" ?>images/icon/category-4.png" alt="Icon"
                                class="w-40">
                        </span>
                        <span class="fw-semibold text-heading mt-16 text-sm"> Beauty</span>
                    </a>
                    <a href="shop.php"
                        class="py-16 px-8 rounded-8 hover-bg-main-50 d-flex flex-column align-items-center text-center border border-white hover-border-main-100">
                        <span class="">
                            <img src="<?= getenv("BASE_URL") . "/assets/" ?>images/icon/category-5.png" alt="Icon"
                                class="w-40">
                        </span>
                        <span class="fw-semibold text-heading mt-16 text-sm">Wines & Drinks</span>
                    </a>
                    <a href="shop.php"
                        class="py-16 px-8 rounded-8 hover-bg-main-50 d-flex flex-column align-items-center text-center border border-white hover-border-main-100">
                        <span class="">
                            <img src="<?= getenv("BASE_URL") . "/assets/" ?>images/icon/category-6.png" alt="Icon"
                                class="w-40">
                        </span>
                        <span class="fw-semibold text-heading mt-16 text-sm">Snacks</span>
                    </a>
                    <a href="shop.php"
                        class="py-16 px-8 rounded-8 hover-bg-main-50 d-flex flex-column align-items-center text-center border border-white hover-border-main-100">
                        <span class="">
                            <img src="<?= getenv("BASE_URL") . "/assets/" ?>images/icon/category-7.png" alt="Icon"
                                class="w-40">
                        </span>
                        <span class="fw-semibold text-heading mt-16 text-sm">Juice</span>
                    </a>
                    <a href="shop.php"
                        class="py-16 px-8 rounded-8 hover-bg-main-50 d-flex flex-column align-items-center text-center border border-white hover-border-main-100">
                        <span class="">
                            <img src="<?= getenv("BASE_URL") . "/assets/" ?>images/icon/category-8.png" alt="Icon"
                                class="w-40">
                        </span>
                        <span class="fw-semibold text-heading mt-16 text-sm">Fruits</span>
                    </a>
                    <a href="shop.php"
                        class="py-16 px-8 rounded-8 hover-bg-main-50 d-flex flex-column align-items-center text-center border border-white hover-border-main-100">
                        <span class="">
                            <img src="<?= getenv("BASE_URL") . "/assets/" ?>images/icon/category-9.png" alt="Icon"
                                class="w-40">
                        </span>
                        <span class="fw-semibold text-heading mt-16 text-sm">Tea & Coffee</span>
                    </a>
                <?php endif; ?>
            </div>
        </div>
        <!-- Dropdown End -->

    </div>
    <!-- Category Dropdown End -->

    <!-- Menu Start  -->
    <div class="header-menu d-lg-block d-none">
        <!-- Nav Menu Start -->
       <ul class="nav-menu flex-align">

    <a href="<?= getenv("BASE_URL") ?>" class="nav-menu__item <?= $currentUrl == '/' ? 'active' : '' ?>">Home</a>

    <li class="on-hover-item nav-menu__item">
        <a href="<?= getenv("BASE_URL") . "/product" ?>" class="nav-menu__link text-heading-two <?= $currentUrl == '/product' ? 'active' : '' ?>">Shop</a>
    </li>

    <li class="on-hover-item nav-menu__item">
        <a href="<?= getenv("BASE_URL") . "/vendor" ?>" class="nav-menu__link text-heading-two <?= $currentUrl == '/vendor' ? 'active' : '' ?>">Vendors</a>
    </li>

    <li class="on-hover-item nav-menu__item">
        <a href="<?= getenv("BASE_URL") . "/blog" ?>" class="nav-menu__link text-heading-two <?= $currentUrl == '/blog' ? 'active' : '' ?>">Blog</a>
    </li>

    <li class="nav-menu__item">
        <a href="<?= getenv("BASE_URL") . "/contact-us" ?>" class="nav-menu__link text-heading-two <?= $currentUrl == '/contact-us' ? 'active' : '' ?>">Contact Us</a>
    </li>

    <li class="on-hover-item nav-menu__item">
        <span class="badge-notification bg-warning-600 text-white text-sm py-2 px-8 rounded-4">New</span>
        <a href="<?= getenv("BASE_URL") . "/become-seller" ?>" class="nav-menu__link text-heading-two <?= $currentUrl == '/become-seller' ? 'active' : '' ?>">Become Vendor</a>
    </li>
</ul>

        <!-- Nav Menu End -->
    </div>
    <!-- Menu End  -->
</div>

<!-- Header Right start -->
<div class="header-right flex-align gap-20">
    <a href="tel:+(2)871382023" class="d-sm-flex align-items-center gap-16 d-none">
        <span class="d-flex text-32">
            <img src="<?= getenv("BASE_URL") . "/assets/" ?>images/icon/mobile.png" alt="Mobile Icon">
        </span>
        <span class="">
            <span class="d-block text-heading fw-medium">Need any Help! call Us</span>
            <span class="d-block fw-bold text-main-600 hover-text-decoration-underline">+(2) 871 382 023</span>
        </span>
    </a>
    <button type="button" class="toggle-mobileMenu d-lg-none ms-3n text-gray-800 text-4xl d-flex"> <i
            class="ph ph-list"></i> </button>
</div>
<!-- Header Right End  -->