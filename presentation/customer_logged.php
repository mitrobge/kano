<?php

class CustomerLogged
{
    public $mCustomerFirstName;
    public $mCustomerLastName;
    public $mLinkToAccount;
    public $mLinkToLogout;

    public function __construct()
    {
        /* Make Links */
        $this->mLinkToAccount = Link::ToCustomerAccount();
        $this->mLinkToLogout = Link::ToCustomerLogout();
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

        /* Get Customer Name */
        $this->mCustomerFirstName = $_SESSION['customer_first_name'];
        $this->mCustomerLastName = $_SESSION['customer_last_name'];
    } 
}

?>
