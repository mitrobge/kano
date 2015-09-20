<?php

class AllSurveys
{
// Public variables to be used in Smarty template
    //public $mLinks;
    public $mLinkToHome;
    public $mLinkToSelf;
    public $mActiveLang;
    public $mSurveys;
    public $links = array();


// Class constructor
    public function __construct()
    {
        //parent::__construct();
        $this->mLinkToHome = Link::Build('');
        $this->mLinkToSelf = Link::ToSelf();
        $this->mActiveLang = Language::GetName();
        $this->mLinks = array(
            'toSurvey' => Link::ToSurvey(null),
        );

    }

    public function init()
    {
        $this->mSurveys = Surveys::GetActiveSurveys(null);
        foreach ($this->mSurveys as $item) {
            $this->links[$item['survey_id']] = Link::ToSurvey($item['survey_id']);
        }

    }

}

?>

