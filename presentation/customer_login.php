<?php

class CustomerLogin 
{
    public $mErrorMessage;
    public $mLinkToLogin;
    public $mEmail;
    public $mLinkToRegister;
    public $mLinkToRecoverPassword;

    public function __construct()
    {
        if (USE_SSL == 'yes' /*&& getenv('HTTPS') != 'on'*/)
            $this->mLinkToLogin =
                Link::Build(str_replace(VIRTUAL_LOCATION, '', 
                    getenv('REQUEST_URI')), 'https');
        else
            $this->mLinkToLogin =
                Link::Build(str_replace(VIRTUAL_LOCATION, '', 
                    getenv('REQUEST_URI')));

        $this->mLinkToRegister = Link::ToRegisterCustomer();
        
        $this->mLinkToRecoverPassword = Link::ToRecoverPassword();
    }

    public function init($redirect = null)
    {
        if (!isset ($_POST['Login']))
            return;

        /* Check if submitted info is valid */
        $login_status = Customer::Login($_POST['email'], 
            $_POST['password']);

        switch ($login_status) {
        case ACCOUNT_BLOCKED:
            $this->mErrorMessage = 'O λογαριασμός είναι μπλοκαρισμένος<br><br>';
            $this->mEmail = $_POST['email'];
            break;
        case UNRECOGNIZED_EMAIL:
            $this->mErrorMessage = 'Λανθασμένη διεύθυνση email<br><br>';
            $this->mEmail = $_POST['email'];
            break;
        case UNRECOGNIZED_PASSW:
            $this->mErrorMessage = 'Λανθασμένος κωδικός<br><br>';
            $this->mEmail = $_POST['email'];
            break;
        case LOGININFO_VALID:
            if (is_null($redirect))
                $redirect = Link::ToIndex();
            header('Location:' . $redirect);
            exit();
        }
    }
}

?>
