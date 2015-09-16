<?php

class ClusterData
{
    // Public variables to be used in Smarty template
    public $mLinks;
    public $mLinkToHome;
    public $mLinkToSelf;
    public $mShowSuccessMessage = false;
    public $mShowErrorMessage = false;
    public $mCategories;
    public $mActiveLang;
    public $mUserIsLoggedIn;
    
    public $mCustomerClusters;
    
    public $mLon;


    public function pass_coordinates($longtitude, $latitude)
    {

        $query_string = 'http://api.openweathermap.org/data/2.5/weather'.'?lat='. $latitude . '&lon='. $longtitude . '&units=metric';
        return file_get_contents($query_string);
    }


    
    // Class constructor
    public function __construct()
    {
        $this->mLinkToHome = Link::Build('');
        $this->mLinkToSelf = Link::ToSelf();
    }



    public function init()
    {
        // If visitor is logged in ...
        $this->mUserIsLoggedIn = Customer::IsAuthenticated();

        if ($this->mUserIsLoggedIn == 1) {
        $this->mCustomerClusters =  Beehive::GetCustomerClusters($_SESSION['customer_id']);



        // Start XML file, create parent node
        /* create a dom document with encoding utf8 */
        $dom = new DOMDocument('1.0', 'UTF-8');
        $node = $dom->createElement("markers");
        $parnode = $dom->appendChild($node); 

        for ($i = 0; $i < count($this->mCustomerClusters); $i++)
        {
            // ADD TO XML DOCUMENT NODE
            $node = $dom->createElement("marker");
            $newnode = $parnode->appendChild($node);

            $newnode->setAttribute("name", $this->mCustomerClusters[$i]['cluster_name']);
            $newnode->setAttribute("lat", $this->mCustomerClusters[$i]['cluster_lat']);
            $newnode->setAttribute("lng", $this->mCustomerClusters[$i]['cluster_lon']);
            $newnode->setAttribute("size", $this->mCustomerClusters[$i]['cluster_size']);
        }

       

        /* get the xml printed */
        $dom->save("/opt/lampp/htdocs/beesness-better/tmp/clusters.xml");


for ($i = 0; $i < count($this->mCustomerClusters); $i++)
		{

                        $json_data[$i] = $this->pass_coordinates($this->mCustomerClusters[$i]['cluster_lon'], $this->mCustomerClusters[$i]['cluster_lat']);

                        $decoded_data[$i] = json_decode($json_data[$i]);

			$this->mCustomerClusters[$i]['link_to_cluster_details'] =
                                               Link::ToCluster($this->mCustomerClusters[$i]['cluster_id']); 
			$this->mCustomerClusters[$i]['lon'] =  $decoded_data[$i]->coord->lon;
			$this->mCustomerClusters[$i]['lat'] =  $decoded_data[$i]->coord->lat;
			$this->mCustomerClusters[$i]['icon'] =  $decoded_data[$i]->weather[0]->icon;
			$this->mCustomerClusters[$i]['Weather'] =  $decoded_data[$i]->weather[0]->description;
			$this->mCustomerClusters[$i]['Temperature'] =  $decoded_data[$i]->main->temp;
			$this->mCustomerClusters[$i]['Pressure'] =  $decoded_data[$i]->main->pressure;
			$this->mCustomerClusters[$i]['Humidity'] =  $decoded_data[$i]->main->humidity;
    
                } 
        }

    }

}

?>

