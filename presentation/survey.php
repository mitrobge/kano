<?php

class Survey
{
// Public variables to be used in Smarty template
    //public $mLinks;
    public $mLinkToHome;
    public $mLinkToSelf;
    public $mActiveLang;
    public $mLinkToSubmitSurvey;
    public $data;
    public $links = array();
    private $surveyId = null;


// Class constructor
    public function __construct()
    {
        //parent::__construct();
        $this->mLinkToHome = Link::Build('');
        $this->mLinkToSelf = Link::ToSelf();
        $this->mActiveLang = Language::GetName();
        $this->mLinkToSubmitSurvey = Link::ToSubmitSurvey("submitsurvey.php");

        if (isset ($_GET['sid']))
            $this->surveyId = $_GET['sid'];
    }

    public function init()
    {
        $this->data = Surveys::GetSurveyData($this->surveyId, null);
        /*foreach ($this->data as $item) {
            echo "data: ". $item['question'];
        }*/

    }

}

?>

