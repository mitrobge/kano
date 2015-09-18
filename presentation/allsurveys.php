<?php

class AllSurveys extends Index
{
// Public variables to be used in Smarty template
    //public $mLinks;
    public $mLinkToHome;
    public $mLinkToSelf;
    public $mActiveLang;
    public $mSurveys;


// Class constructor
    public function __construct()
    {
        parent::__construct();
        $this->mLinkToHome = Link::Build('');
        $this->mLinkToSelf = Link::ToSelf();
        $this->mActiveLang = Language::GetName();

    }

    public function init()
    {
        $this->mSurveys = Surveys::GetActiveSurveys(null);

    }

}

?>

