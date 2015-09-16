<?php

// Cart actions
define('CART_ADD_PRODUCT', 1);
define('CART_REMOVE_PRODUCT', 2);
define('CART_UPDATE_PRODUCT_QUANTITY', 3);
define('CART_SAVE_PRODUCT_FOR_LATER', 4);
define('CART_MOVE_SAVED_PRODUCT_TOCART', 5);
define('CART_REMOVE_ALL_PRODUCTS', 6);
define('CART_REMOVE_ALL_SAVED_PRODUCTS', 7);
define('CART_GET_PRODUCTS', 8);
define('CART_GET_SAVED_PRODUCTS', 9);
define('CART_CREATE_ORDER', 10);

// Login
define('LOGININFO_VALID', 0);
define('UNRECOGNIZED_PASSW', 1);
define('UNRECOGNIZED_EMAIL', 2);
define('ACCOUNT_BLOCKED', 3);
define('LOGININFO_INVALID', 4);

// Random value used for hashing
define('HASH_PREFIX', 'S1-');

// Checkout steps
define('CHECKOUT_LOGIN', 'login');
define('CHECKOUT_SHIPPING', 'shipping');
define('CHECKOUT_CHANGE_SHIPPING', 'change_shipping');
define('CHECKOUT_PAYMENT', 'payment');
define('CHECKOUT_CONFIRM', 'confirm');
define('CHECKOUT_SUCCESS', 'ok');

// PayPal configuration
define('PAYPAL_URL', 'https://www.paypal.com/cgi-bin/webscr');
define('PAYPAL_EMAIL', 'youremail@example.com');
define('PAYPAL_CURRENCY_CODE', 'USD');
define('PAYPAL_RETURN_URL', 'http://www.example.com');
define('PAYPAL_CANCEL_RETURN_URL', 'http://www.example.com');

// Payment types
define('PAYMENT_METHOD_CC', 1);
define('PAYMENT_METHOD_COD', 2);

define('CUSTOMER_FIRST_NAME_MINLEN', 2);
define('CUSTOMER_LAST_NAME_MINLEN', 2);
define('CUSTOMER_STREET_ADDR_MINLEN', 4);
define('CUSTOMER_COMPANY_MINLEN', 2);
define('CUSTOMER_POSTCODE_MINLEN', 5);
define('CUSTOMER_CITY_MINLEN', 2);
define('CUSTOMER_STATE_MINLEN', 2);
define('CUSTOMER_PHONE_MINLEN', 10);
define('CUSTOMER_MOBILE_MINLEN', 10);
define('CUSTOMER_TAX_OFFICE_MINLEN', 2);

// Submit Result
define('SUBMIT_ERRORS',    false);
define('SUBMIT_SUCCESS',   true);

// MySQL Defines
define('MYSQL_FIND_IN_SET_LIMIT', 64);

// Friends Wish Lists
define('FRIENDS_WISHLISTS_ITEMS_PER_PAGE', 16);

// Max products to compare
define('COMPARE_PRODUCTS_MAX', 3);

// Report Types
define('REPORT_TYPE_VISITS', 0);
define('REPORT_TYPE_BUY', 1);

// Promotion types
define('PROMOTION_TYPE_PRODUCT_OFFER', 'offer');
define('PROMOTION_TYPE_PRODUCT_ARRIVAL', 'arrival');
define('PROMOTION_TYPE_PRODUCT_FRONTPAGE', 'frontpage');
define('PROMOTION_TYPE_BANNER', 'banner');
define('PROMOTION_TYPE_ARTICLE', 'article');
?>
