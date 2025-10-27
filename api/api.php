<?php

require_once __DIR__ . '/../env.php';
$baseApiUrl = getenv('BASE_API_URL');
$apiEndpoints = [
    'FETCH_ALL_MEDIA_API' => '/common/media/read',
    "Create_Contact_API" => '/common/contact-us/create',


    'FETCH_ALL_BRAND_API' => '/common/brand/read',

    'FETCH_ALL_COLOR_API' => '/common/color/read',

    'FETCH_ALL_SIZE_API' => '/common/size/read',
    'FETCH_ALL_Blog_API' => '/common/blog/read',
    'FETCH_Single_Blog_API' => '/common/blog/read/slug',



    'FETCH_ALL_PRODUCT_API' => '/common/product/read',
    'FETCH_ALL_PRODUCT_API_PAGINATION' => '/common/product/read/pagination',
    'FETCH_ALL_PRODUCT_BY_NAME_API' => '/common/product/read/name',
    'FETCH_ALL_PRODUCT_BY_CATEGORY_API' => '/common/product/read/category',
    'FETCH_ALL_PRODUCT_BY_CATEGORY_WITH_PAGINATION_API' => '/common/product/read/category/pagination',
    'FETCH_ALL_PRODUCT_CATEGORY_API' => '/common/product-category/read',
    'FETCH_ALL_PRODUCT_BY_GROUP_API' => '/common/product/read/group/style',

    'CUSTOMER_LOGIN_REGISTER' => '/customer/auth/register',
    'CUSTOMER_LOGIN_LOGIN' => '/customer/auth/login',
    'NEWSLETTER_SUBSCRIBE' => '/customer/news-letter/create',


    'GRAPHQL' => '/graphql'
];

foreach ($apiEndpoints as $key => $endpoint) {
    putenv("{$key}={$baseApiUrl}{$endpoint}");
}


?>