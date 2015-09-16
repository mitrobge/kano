<?php
class AdminLogin
{
    public $mEmail;
    public $mLoginMessage = '';
    public $mLinkToAdmin;
    public $mLinkToIndex;

    public function __construct()
    {
        $this->mLinkToAdmin = Link::ToAdmin();
        $this->mLinkToIndex = Link::ToIndex();
    }

    public function init()
    {
        if (!isset($_POST['submit']))
            return;
        
        $login_status = Administrator::Login(
            $_POST['email'], $_POST['password']);

        switch ($login_status) {
        case UNRECOGNIZED_EMAIL:
            $this->mLoginMessage = 'Άγνωστο Email.';
            $this->mEmail = $_POST['email'];
            break;
        case UNRECOGNIZED_PASSW:
            $this->mLoginMessage = 'Άγνωστος κωδικός.';
            $this->mEmail = $_POST['email'];
            break;
        case ACCOUNT_BLOCKED:
            $this->mLoginMessage = 'Ο λογαριασμός έχει μπλοκαριστεί.';
            $this->mEmail = $_POST['email'];
            break;
        case LOGININFO_VALID:
            header('Location:' . Link::Build(
                str_replace(VIRTUAL_LOCATION, '',
                        getenv('REQUEST_URI'))));
            exit();
        }
    }
}
?>
