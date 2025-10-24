<div class="mobile-menu__inner">
            <a href="index.php" class="mobile-menu__logo">
                <img src="<?= getenv("BASE_URL")."/assets/"?>/images/logo/logo.png" alt="Logo">
            </a>
            <div class="mobile-menu__menu">
                <!-- Nav Menu Start -->
                <ul class="nav-menu flex-align nav-menu--mobile">
                <li class="nav-menu__item">
                        <a href="index.php" class="nav-menu__link text-heading-two">Home</a>
                    </li>
                    <li class="on-hover-item nav-menu__item has-submenu">
                        <a href="javascript:void(0)" class="nav-menu__link text-heading-two">Shop</a>
                        <ul class="on-hover-dropdown common-dropdown nav-submenu scroll-sm">
                            <li class="common-dropdown__item nav-submenu__item">
                                <a href="shop.php" class="common-dropdown__link nav-submenu__link text-heading-two hover-bg-neutral-100"> Shop</a>
                            </li>
                            <li class="common-dropdown__item nav-submenu__item">
                                <a href="product-details.php" class="common-dropdown__link nav-submenu__link text-heading-two hover-bg-neutral-100"> Shop Details</a>
                            </li>
                          
                        </ul>
                    </li>
                    <li class="on-hover-item nav-menu__item has-submenu">
                        <span class="badge-notification bg-warning-600 text-white text-sm py-2 px-8 rounded-4">New</span>
                        <a href="javascript:void(0)" class="nav-menu__link text-heading-two">Pages</a>
                        <ul class="on-hover-dropdown common-dropdown nav-submenu scroll-sm">
                            <li class="common-dropdown__item nav-submenu__item">
                                <a href="cart.php" class="common-dropdown__link nav-submenu__link text-heading-two hover-bg-neutral-100"> Cart</a>
                            </li>
                            <li class="common-dropdown__item nav-submenu__item">
                                <a href="wishlist.php" class="common-dropdown__link nav-submenu__link text-heading-two hover-bg-neutral-100"> Wishlist</a>
                            </li>
                            <li class="common-dropdown__item nav-submenu__item">
                                <a href="checkout.php" class="common-dropdown__link nav-submenu__link text-heading-two hover-bg-neutral-100"> Checkout </a>
                            </li>
                            <li class="common-dropdown__item nav-submenu__item">
                                <a href="become-seller.php" class="common-dropdown__link nav-submenu__link text-heading-two hover-bg-neutral-100"> Become Seller</a>
                            </li>
                            <li class="common-dropdown__item nav-submenu__item">
                                <a href="account.php" class="common-dropdown__link nav-submenu__link text-heading-two hover-bg-neutral-100"> Account</a>
                            </li>
                        </ul>
                    </li>
                    <li class="on-hover-item nav-menu__item has-submenu">
                        <span class="badge-notification bg-tertiary-600 text-white text-sm py-2 px-8 rounded-4">New</span>
                        <a href="javascript:void(0)" class="nav-menu__link text-heading-two">Vendors</a>
                        <ul class="on-hover-dropdown common-dropdown nav-submenu scroll-sm">
                            <li class="common-dropdown__item nav-submenu__item">
                                <a href="vendor.php" class="common-dropdown__link nav-submenu__link text-heading-two hover-bg-neutral-100"> Vendors </a>
                            </li>
                            <li class="common-dropdown__item nav-submenu__item">
                                <a href="vendor-details.php" class="common-dropdown__link nav-submenu__link text-heading-two hover-bg-neutral-100"> Vendor Details </a>
                            </li>
                          
                        </ul>
                    </li>
                    <li class="on-hover-item nav-menu__item has-submenu">
                        <a href="javascript:void(0)" class="nav-menu__link text-heading-two">Blog</a>
                        <ul class="on-hover-dropdown common-dropdown nav-submenu scroll-sm">
                            <li class="common-dropdown__item nav-submenu__item">
                                <a href="blog.php" class="common-dropdown__link nav-submenu__link text-heading-two hover-bg-neutral-100"> Blog</a>
                            </li>
                            <li class="common-dropdown__item nav-submenu__item">
                                <a href="blog-details.php" class="common-dropdown__link nav-submenu__link text-heading-two hover-bg-neutral-100"> Blog Details</a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-menu__item">
                        <a href="contact-us.php" class="nav-menu__link text-heading-two">Contact Us</a>
                    </li>
                </ul>
                <!-- Nav Menu End -->
            </div>
        </div>