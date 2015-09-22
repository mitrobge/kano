<?php
class SubmitSurvey
{
    public $mLinkToHome;
    public $mLinkToSelf;
    public $mActiveLang;

    public function __construct()
    {
        $this->mLinkToHome = Link::Build('');
        $this->mLinkToSelf = Link::ToSelf();
        $this->mActiveLang = Language::GetName();
    }

    public function init()
    {
        if (!isset($_POST['submit']))
            return;
        echo "email: ".$_POST['email']. "<br>";
        echo "sid: ".$_POST['sid']. "<br>";;

    }
}
?>
