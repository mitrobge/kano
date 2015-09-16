<?php

class CustomerInfo
{
    public $mCustomerName;
    public $mLinkToAccount;
    public $mLinkToRegister;
    public $mLinkToLogout;
    public $mLinkToLogin;
    public $mLinkToAbout;
    public $mCustomerIsLoggedIn = false;

    public function __construct()
    {
        /* Make Links */
        $this->mLinkToRegister = Link::ToRegisterCustomer();
        $this->mLinkToAccount = Link::ToCustomerAccount();
        $this->mLinkToLogin = Link::ToCustomerLogin();
        $this->mLinkToLogout = Link::ToCustomerLogout();
        $this->mLinkToAbout = Link::Build('index.php?About');
    }

    public function init()
    {
        if (isset($_GET['CustomerLogout'])) {
            /* Logout Customer and redirect to home page */
            Customer::Logout();
            header('Location: ' .
                htmlspecialchars_decode(
                    Link::ToIndex()));
            exit();
        }

        if (Customer::IsAuthenticated()) {
            $this->mCustomerIsLoggedIn = true;
            $this->mCustomerName = $_SESSION['customer_first_name'] . ' ' . 
                $_SESSION['customer_last_name'];
        }
    } 
}

?>

