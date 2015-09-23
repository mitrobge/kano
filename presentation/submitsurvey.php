<?php
class SubmitSurvey
{
    public $mLinkToHome;
    public $mLinkToSelf;
    public $mActiveLang;
    private $is_positive = 1;
    private $is_negative = 0;

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

        $email = $_POST['email'];
        $sid = $_POST['sid'];

        echo "email: ".$email. "<br>";
        echo "sid: ".$sid. "<br>";;

        //replace with distinct qids query
        $surveyData = Surveys::GetSurveyData($sid, null);
        $queries = array();

        foreach($surveyData as $value){
            echo "qid:". $value['qid'];
            if (!in_array($value['qid'], $queries)) {
                $queries[] = $value['qid'];
            }
        }

        //print_r($queries);

        foreach($queries as $value){
            $positiveAnswer = $_POST["q".$value.$this->is_positive];
            $negativeAnswer = $_POST["q".$value.$this->is_negative];
            if (!isset($_POST[$positiveAnswer]) || !isset($_POST[$negativeAnswer]))
                return;
            echo $_POST["q".$value.$this->is_positive];
        }


    }
}
?>
