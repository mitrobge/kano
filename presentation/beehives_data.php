<?php

class BeehivesData
{
    // Public variables to be used in Smarty template
    public $mLinks;
    public $mLinkToHome;
    public $mLinkToSelf;
    public $mShowSuccessMessage = false;
    public $mShowErrorMessage = false;
    public $mCategories;
    public $mActiveLang;
    
    public $mCustomerClusters;
    
    public $mClusterId;


    // Class constructor
    public function __construct()
    {
        $this->mLinkToHome = Link::Build('');
        $this->mLinkToSelf = Link::ToSelf();
    }
    

    public function init()
    {

        $this->mClusterId = $_GET['cluster_id'];

        $json_data = file_get_contents('http://api.openweathermap.org/data/2.5/weather?id=2643743&units=metric');
        $decoded_data = json_decode($json_data);


        $this->mClusterBeehives =  Beehive::GetClusterBeehives($this->mClusterId);
        
        $this->mClusterName =  Beehive::GetClusterName($this->mClusterId);

        //print_r($this->mClusterBeehives);

		for ($i = 0; $i < count($this->mClusterBeehives); $i++)
                {
                    $this->mBeehiveStatus[$i] =  Beehive::GetBeehiveLatestStatus($this->mClusterBeehives[$i]['beehive_id']);
    
                }


    }

}

?>

