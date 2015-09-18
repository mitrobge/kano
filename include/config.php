<?php
// SITE_ROOT contains the full path to the kano folder
define('SITE_ROOT', dirname(dirname(__FILE__)));

// Application directories
define('PRESENTATION_DIR', SITE_ROOT . '/presentation/');
define('BUSINESS_DIR', SITE_ROOT . '/business/');

// Settings needed to configure the Smarty template engine
define('SMARTY_DIR', SITE_ROOT . '/libs/smarty/');
define('CONFIG_DIR', SITE_ROOT . '/include/configs');
define('TEMPLATE_DIR', PRESENTATION_DIR . 'templates');
define('COMPILE_DIR', PRESENTATION_DIR . 'templates_c');
define('SWIFTMAIL_DIR', SITE_ROOT . '/libs/swiftmailer-5.x/lib/');

// MPDF Platform
define('MPDF_DIR', SITE_ROOT . '/libs/mpdf/');

// These should be true while developing the web site
define('IS_WARNING_FATAL', true);
define('DEBUGGING', true);

// The error types to be reported
define('ERROR_TYPES', E_ALL);

// Settings about mailing the error messages to admin
define('SEND_ERROR_MAIL', false);
define('ADMIN_ERROR_MAIL', 'Administrator@example.com');
define('SENDMAIL_FROM', 'Errors@example.com');
ini_set('sendmail_from', SENDMAIL_FROM);

// By default we don't log errors to a file
define('LOG_ERRORS', true);
// define('LOG_ERRORS_FILE', 'c:\\kano\\errors_log.txt'); // Windows
define('LOG_ERRORS_FILE', '/opt/lampp/htdocs/kano/errors.log'); // Linux

/* Generic error message to be displayed instead of debug info
   (when DEBUGGING is false) */
define('SITE_GENERIC_ERROR_MESSAGE', '<h1>E-Shop Error!</h1>');

// Database connectivity setup
define('DB_PERSISTENCY', 'true');
define('DB_SERVER', 'localhost;port=3306');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', 'root123');
define('DB_DATABASE', 'kano');
//define('DB_USERNAME', 'bb_user');
//define('DB_PASSWORD', 'zA6m8s~5');
//define('DB_DATABASE', 'kano');
define('PDO_DSN', 'mysql:host=' . DB_SERVER . ';dbname=' . DB_DATABASE);

// Server HTTP port (can omit if the default 80 is used)
define('HTTP_SERVER_PORT', '80');
/* Name of the virtual directory the site runs in, for example:
   '/kano/' if the site runs at http://www.example.com/kano/
   '/' if the site runs at http://www.example.com/ */
define('VIRTUAL_LOCATION', '/kano/');

/*
require_once(PRESENTATION_DIR . 'link.php');
define('SITE_IMAGES', Link::Build('images/'));
*/

require_once(SWIFTMAIL_DIR . 'swift_required.php');

define('PRODUCTS_PER_PAGE_ADMIN',18);
define('PRODUCTS_PER_PAGE',18);
define('SHORT_PRODUCT_DESCRIPTION_LENGTH',30);
define('FULL_PRODUCT_DESCRIPTION_LENGTH',1000);

define('ANNOUNCEMENTS_PER_PAGE', 6);
define('ANNOUNCEMENTS_SHORT_DESC_LENGTH', 110);
define('LATEST_NEWS_SHORT_DESC_LENGTH', 55);

define('SEMINARS_PER_PAGE_ADMIN',5);


/* Minimum word length for searches; this constant must be kept in sync
    * with the ft_min_word_len MySQL variable */
define('FT_MIN_WORD_LEN', 4);

define('USE_SSL', 'no');

define('SMTP_HOST', 'smtp.gmail.com');
define('SMTP_PORT', 465);
define('SMTP_CRYPTO', 'ssl');

define('MAIL_SENDER', 'admin@eparxis.com');
define('MAIL_SENDER_PASS', 'admineparxis');

?>
