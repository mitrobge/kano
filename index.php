<?php

// Include utility files
require_once 'include/config.php';
require_once 'include/defines.php';
require_once BUSINESS_DIR . 'error_handler.php';

// Set the error handler
ErrorHandler::SetHandler();

// Activate session
session_start();

// Start output buffer
ob_start();

// Load the application page template
require_once PRESENTATION_DIR . 'application.php';
require_once PRESENTATION_DIR . 'link.php';

// Load the database handler
require_once BUSINESS_DIR . '/database_handler.php'; 
require_once BUSINESS_DIR . 'language.php';
require_once BUSINESS_DIR . 'beehive.php';
require_once BUSINESS_DIR . 'customer.php';
require_once BUSINESS_DIR . 'password_hasher.php';
require_once BUSINESS_DIR . 'utils.php';
require_once BUSINESS_DIR . 'surveys.php';


// Load Business Tier
//require_once BUSINESS_DIR . 'content.php';

// URL correction
Link::CheckRequest();

// Load Smarty template file
$application = new Application();

// Display the page
$application->display('index.tpl');

// Close database connection
DatabaseHandler::Close();

// Output content from the buffer
flush();
ob_flush();
ob_end_clean();
?>
