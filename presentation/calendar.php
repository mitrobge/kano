<?php

class Calendar
{
    // Public variables to be used in Smarty template
    public $mLinks;
    public $mLinkToHome;
    public $mLinkToSelf;
    public $mShowSuccessMessage = false;
    public $mShowErrorMessage = false;
    public $mCategories;
    public $mActiveLang;


    // Class constructor
    public function __construct()
    {
        $this->mLinkToHome = Link::Build('');
        $this->mLinkToSelf = Link::ToSelf();
    }
    

    public function init()
    {
       
        
        if (isset($_GET['data_submit'])) {
            
            $rec = Beehive::AddDataEntry($_GET['id'], $_GET['weight'], $_GET['int_temp'], $_GET['ext_temp'], $_GET['ext_hum'], $_GET['lum'], $_GET['Latitude'], $_GET['Longtitude'] );
                
        }
        
        if (isset($_GET['health_status_submit'])) {
            
            $rec = Beehive::AddHealthStatusEntry($_GET['id'], $_GET['uc_battery'], $_GET['gsm_battery'], $_GET['rssi'] );
                
        }
        


    }

}

?>

