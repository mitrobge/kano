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


        $existingAnswers = Surveys::GetCustomerSurveyAnswers($sid, $email);

        if(count($existingAnswers)>0){
            echo "Already submitted";
            return;
        }

        $surveyData = Surveys::GetSurveyData($sid, null);
        $queries = array();

        foreach($surveyData as $value){
            //echo "qid:". $value['qid'];
            if (!in_array($value['qid'], $queries)) {
                $queries[] = $value['qid'];
            }
        }

        //print_r($queries);

        foreach($queries as $value) {
            $positiveAnswer = $_POST["q" . $value . $this->is_positive];
            $negativeAnswer = $_POST["q" . $value . $this->is_negative];
            if (!isset($positiveAnswer) || !isset($negativeAnswer)) {
                return;
            }

            //echo $email.",".$sid.",".$value.",".$positiveAnswer.",".$negativeAnswer;
            Surveys::SubmitSurveyAnswer($email, $sid, $value, $positiveAnswer, $negativeAnswer);
        }


    }
}
?>
