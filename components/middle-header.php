<nav class="header-inner flex-between gap-8">
    <!-- Logo Start -->
    <div class="logo">
        <a href="<?= getenv("BASE_URL") ?>" class="link">
            <img src="<?= getenv("BASE_URL") . "/assets/" ?>images/logo/logo.png" alt="Logo">
        </a>
    </div>
    <!-- Logo End  -->

    <!-- form location Start -->
    <!-- <form action="#" class="flex-align flex-wrap form-location-wrapper max-w-840 w-100">
        <div
            class="search-category select-style-one d-flex select-border-end-0 search-form d-sm-flex d-none text-heading-two text-sm w-100">
            <select id="categorySelect" class="js-example-basic-single border border-neutral-40 border-end-0"
                name="state">
                <option value="1" selected disabled>All categories</option>
                <?php foreach ($resultProductCategory['data']['data'] as $key => $category): ?>
                    <option value="<?= $category['id'] ?>"><?= $category['name'] ?></option>
                <?php endforeach; ?>

                <?php if (empty($resultProductCategory['data']['data'])): ?>
                    <option value="1">Grocery</option>
                    <option value="1">Breakfast & Dairy</option>
                    <option value="1">Vegetables</option>
                    <option value="1">Milks and Dairies</option>
                    <option value="1">Pet Foods & Toy</option>
                    <option value="1">Breads & Bakery</option>
                    <option value="1">Fresh Seafood</option>
                    <option value="1">Fronzen Foods</option>
                    <option value="1">Noodles & Rice</option>
                    <option value="1">Ice Cream</option>
                <?php endif; ?>

            </select>

            <div class="search-form__wrapper position-relative border-half-start flex-grow-1">
                <input type="text"
                    class="common-input border-neutral-40 py-18 ps-16 pe-76 rounded-0 rounded-end pe-44 placeholder-italic placeholder-text-sm border-start-0"
                    placeholder="Search for products, categories or brands...">
                <button type="submit"
                    class="w-64 h-44 bg-main-600 hover-bg-main-800 rounded-4 flex-center text-xl text-white position-absolute top-50 translate-middle-y inset-inline-end-0 me-6"><i
                        class="ph ph-magnifying-glass"></i></button>
            </div>
        </div>
    </form> -->
    <!-- form location start -->

    <!-- Header Middle Right start -->
    <div class="header-right flex-align flex-shrink-0">
        <div class="flex-align gap-20">
            <button type="button" class="search-icon flex-align d-lg-none d-flex gap-4 item-hover">
                <span class="text-2xl text-gray-700 d-flex position-relative item-hover__text">
                    <i class="ph ph-magnifying-glass"></i>
                </span>
            </button>
            <?php if (empty($_SESSION['token'])) { ?>
                <a href="<?= getenv("BASE_URL") . "/login" ?>" class="flex-align gap-4 item-hover">
                    <span class="text-xl text-gray-700 d-flex position-relative item-hover__text">
                        <i class="ph ph-sign-in"></i>
                    </span>
                    <span class="text-md text-heading-three item-hover__text d-none d-lg-flex">Login</span>
                </a>
            <?php } else { ?>
                <a href="<?= getenv("BASE_URL") . "/profile" ?>" class="flex-align gap-4 item-hover">
                    <span class="text-xl text-gray-700 d-flex position-relative item-hover__text">
                        <i class="ph ph-user"></i>
                    </span>
                    <span class="text-md text-heading-three item-hover__text d-none d-lg-flex">Profile</span>
                </a>
            <?php } ?>
            <a href="<?= getenv("BASE_URL") . "/wishlist" ?>" class="flex-align gap-4 item-hover">
                <span class="text-xl text-gray-700 d-flex position-relative me-6 mt-6 item-hover__text">
                    <i class="ph ph-heart"></i>
                    <span
                        class="w-16 h-16 flex-center rounded-circle bg-main-600 text-white text-xs position-absolute top-n6 end-n4 wishlist-item-count">0</span>
                </span>
                <span class="text-md text-heading-three item-hover__text d-none d-lg-flex">Wishlist</span>
            </a>
            <a href="<?= getenv("BASE_URL") . "/cart" ?>" class="flex-align gap-4 item-hover">
                <span class="text-xl text-gray-700 d-flex position-relative me-6 mt-6 item-hover__text">
                    <i class="ph ph-shopping-cart-simple"></i>
                    <span
                        class="w-16 h-16 flex-center rounded-circle bg-main-600 text-white text-xs position-absolute top-n6 end-n4 cart-item-count">0</span>
                </span>
                <span class="text-md text-heading-three item-hover__text d-none d-lg-flex">Cart</span>
            </a>
        </div>
    </div>
    <!-- Header Middle Right End  -->
</nav>