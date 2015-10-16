<?php
class SubmitSurvey
{
    public $mLinkToHome;
    public $mLinkToSelf;
    public $mActiveLang;
    private $is_positive = 1;
    private $is_negative = 0;
    public $result = 0;

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

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->result = -2;
            return;
        }

        $sid = $_POST['sid'];


        if(isset($_POST['is_css']) && $_POST['is_css'] == 1) {

            $existingAnswers = Surveys::GetCustomerCssSurveyAnswers($sid, $email);

            if(count($existingAnswers)>0){
                $this->result = -1;
                return;
            }

            $surveyData = Surveys::GetCssSurveyData($sid, null);
            $queries = array();

            foreach ($surveyData as $value) {
                //echo "qid:". $value['qid'];
                if (!in_array($value['ccid'], $queries)) {
                    $queries[] = $value['ccid'];
                }
            }

            //print_r($queries);

            foreach ($queries as $value) {
                $answerId = $_POST["q" . $value];
                if (!isset($answerId)) {
                    return;
                }

                $this->result = Surveys::SubmitCssSurveyAnswer($email, $sid, $value, $answerId);
                if ($this->result != 1) {
                    break;
                }

            }
        } else {

            $existingAnswers = Surveys::GetCustomerSurveyAnswers($sid, $email);

            if(count($existingAnswers)>0){
                $this->result = -1;
                return;
            }

            $surveyData = Surveys::GetSurveyData($sid, null);
            $queries = array();

            foreach ($surveyData as $value) {
                //echo "qid:". $value['qid'];
                if (!in_array($value['qid'], $queries)) {
                    $queries[] = $value['qid'];
                }
            }

            //print_r($queries);

            foreach ($queries as $value) {
                $positiveAnswer = $_POST["q" . $value . $this->is_positive];
                $negativeAnswer = $_POST["q" . $value . $this->is_negative];
                if (!isset($positiveAnswer) || !isset($negativeAnswer)) {
                    return;
                }

                //echo $email.",".$sid.",".$value.",".$positiveAnswer.",".$negativeAnswer;
                $this->result = Surveys::SubmitSurveyAnswer($email, $sid, $value, $positiveAnswer, $negativeAnswer);
                if ($this->result != 1) {
                    break;
                }


                $attributeRate = $_POST["rate" . $value];

                Surveys::SubmitSurveyAttributeRate($email, $value, $attributeRate);

            }
        }

    }
}
?>
