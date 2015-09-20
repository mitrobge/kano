<?php
class Index
{
   
    public $mUrl;
    public $mSiteImages;
    public $mLanguages;
    public $mContentsCell;
    public $mLinks;
    public $mPageTitle;
    public $mActiveLang;
    public $mTemplates;
    public $mOrganizationCategories = null;
    public $mCategories;
    public $mUserIsLoggedIn;

	// Class constructor
	public function __construct()
    {
	$this->mUrl = Link::Build('');
        /* Change the language. Do it here because we want to unset lang GET var before building links */
        if (isset($_GET['lang']))
            Language::Set($_GET['lang']);
        
        $this->mContentsCell = 'main_categories.tpl';
        
        $this->mLinks = array(
            'toCalendar' => Link::ToCalendar(),
            'toDataEntry' => Link::ToDataEntry(),
            'toCustomerProfile' => Link::ToCustomerProfile(),
            'toClusterData' => Link::ToClusterData(),
            'toBeehiveData' => Link::ToBeehiveData(),
            'toOrganization' => Link::ToOrganization(),
            'toServices' => Link::ToServices(),
            'toTuvTimes' => Link::ToTuvTimes(),
            'toBriefing' => Link::ToBriefing(),
            'toOnlineApplication' => Link::ToOnlineApplication(),
            'toAccreditations' => Link::ToAccreditations(),
            'toContact' => Link::ToContact(),
            'toEducation' => Link::ToEducation(),
            'toNewsletter' => Link::ToNewsletter(),
            'toNewsletterUnsubscribe' => Link::ToNewsletterUnsubscribe(),
            'toSitemap' => Link::ToSitemap(),
            'toTerms' => Link::ToTerms(),
            'toChangeLang' => Link::RemoveUrlKey('lang'), /* lang variable will pass using jquery */
            'toProfile' => Link::ToOrganization('profile'),
            'toVision' => Link::ToOrganization('vision'),
            'toMilestones' => Link::ToOrganization('history'),
            'toCodeOfEthics' => Link::ToOrganization('code_of_ethics'),
            'toHumanResources' => Link::ToOrganization('human_resources'),
            'toBranches' => Link::ToOrganization('branches'),
            'toCareers' => Link::ToOrganization('careers'),
            'toCareerDetails' => Link::ToOrganization('career-details'),
            'toAllSurveys' => Link::ToAllSurveys(),
        );
	}

	// Initialize presentation object
    public function init()
    { 


        if (isset ($_GET['CustomerAccount']))
            $this->mContentsCell = 'customer_account.tpl';
        else if (isset($_GET['calendar']))
            $this->mContentsCell = 'calendar.tpl';
        else if (isset($_GET['data-entry']))
            $this->mContentsCell = 'data_entry.tpl';
        if (isset($_GET['cluster-data']) && !isset($_GET['cluster_id']))
            $this->mContentsCell = 'cluster_data.tpl';
        if (isset($_GET['cluster-data']) && isset($_GET['cluster_id']))
            $this->mContentsCell = 'beehives_data.tpl';
        else if (isset($_GET['cluster_id']))
            $this->mContentsCell = 'beehive_data.tpl';
        else if (isset($_GET['customer-profile']))
            $this->mContentsCell = 'customer_profile.tpl';
        else if (isset ($_GET['CustomerLogin']))
            $this->mContentsCell = 'customer_login.tpl';
        else if (isset ($_GET['CustomerRegister']))
            $this->mContentsCell = 'customer_register.tpl';
        else if (isset ($_GET['all-surveys']))
            $this->mContentsCell = 'allsurveys.tpl';
        else if (isset ($_GET['survey']))
            $this->mContentsCell = 'survey.tpl';
        
        $this->mActiveLang = Language::GetName();
        $this->mPageTitle = $this->_GetPageTitle($this->mActiveLang);

        
    }


	// Returns the page title
	private function _GetPageTitle($inLang)
	{
            $page_title = '';

                if(isset($_GET['organization']))
                {
                    if($inLang=='gr'){ 
                        $page_title .= 'Οργανισμός';
                        if(isset($_GET['page'])){
                        if(($_GET['page'])=='vision')
                        $page_title .= ': '.'Εταιρική ταυτότητα';
                        if(($_GET['page'])=='history')
                        $page_title .= ': '.'Ιστορικοί σταθμοί';
                        if(($_GET['page'])=='code_of_ethics')
                        $page_title .= ': '.'Κοινωνική ευθύνη';
                        if(($_GET['page'])=='human_resources')
                        $page_title .= ': '.'Ανθρώπινο δυναμικό';
                        if(($_GET['page'])=='branches')
                        $page_title .= ': '.'Γραφεία/Θυγατρικές';
                        if(($_GET['page'])=='careers')
                        $page_title .= ': '.'Καριέρα μαζί μας';
                        }
                    }
                    else{
                        $page_title .= 'Organization';
                        if(isset($_GET['page'])){
                        if(($_GET['page'])=='vision')
                        $page_title .= ': '.'Corporate Profile';
                        if(($_GET['page'])=='history')
                        $page_title .= ': '.'History';
                        if(($_GET['page'])=='code_of_ethics')
                        $page_title .= ': '.'Social Responsibility';
                        if(($_GET['page'])=='human_resources')
                        $page_title .= ': '.'Human resources';
                        if(($_GET['page'])=='branches')
                        $page_title .= ': '.'Offices';
                        if(($_GET['page'])=='careers')
                        $page_title .= ': '.'Careers';
                    }
                    }
                }
                
                if(isset($_GET['briefing']))
                {
                    if($inLang=='gr'){ 
                        $page_title .= 'Ενημέρωση';
                        if(isset($_GET['page']))
			$page_title .= ': ' . Announcements::GetCategoryTag($_GET['page']);
                        if(isset($_GET['item'])){
                            $item_info = Announcements::GetAnnouncement($_GET['item']);
			    $page_title .= ' - ' . $item_info['title'];
                        }
                    }
                    else{
                        $page_title .= 'Briefing';
                        if(isset($_GET['page']))
			$page_title .= ': ' . Announcements::GetCategoryTag($_GET['page']);
                        if(isset($_GET['item'])){
                            $item_info = Announcements::GetAnnouncement($_GET['item']);
			    $page_title .= ' - ' . $item_info['title'];
                        }
                    }
                }
                
                if(isset($_GET['services']))
                    if($inLang=='gr') 
			$page_title .= 'Υπηρεσίες';
                    else
			$page_title .= 'Services';
                    
                if(isset($_GET['category_id']))
                {
                    if($inLang=='gr') 
                    {
			$page_title .= 'Υπηρεσίες: ' . Services::GetCategoryName($_GET['category_id']);
                        if(isset($_GET['service_id']))
			$page_title .= ' - ' . Services::GetServiceName($_GET['service_id']);
                    }
                    else
                    {
			$page_title .= 'Services: ' . Services::GetCategoryName($_GET['category_id']);
                        if(isset($_GET['service_id']))
			$page_title .= ' - ' . Services::GetServiceName($_GET['service_id']);
                    }
                }
                
                if(isset($_GET['tuvtimes']))
                    $page_title .= 'TÜV TIMES';
                
                if(isset($_GET['cyprus']))
                    $page_title .= 'TÜV Austria Cyprus';
                
                if(isset($_GET['accreditations']))
                    if($inLang=='gr') 
                    $page_title .= 'Διαπιστεύσεις';
                    else
                    $page_title .= 'Accreditations';
                if(isset($_GET['contact']))
                    if($inLang=='gr') 
                    $page_title .= 'Επικοινωνία';
                    else
                    $page_title .= 'Contact';
                if(isset($_GET['sitemap']))
                    if($inLang=='gr') 
                    $page_title .= 'Χάρτης Ιστότοπου';
                    else
                    $page_title .= 'Site map';
                if(isset($_GET['education']))
                    if($inLang=='gr') 
                    $page_title .= 'Εκπαίδευση';
                    else
                    $page_title .= 'Training';
                if(isset($_GET['newsletter']))
                    $page_title .= 'Newsletter';


        if (isset ($_GET['search-results']))
        {
            if($inLang=='gr') 
                $page_title = 'Αποτελέσματα Αναζήτήσης: ';
            else
                $page_title = 'Search Results: ';
            // Display the search string
            $page_title .= trim(str_replace('-', ' ', $_GET['search-results'])) ;
            
            
            // Display page number
            if (isset ($_GET['Page']) && ((int)$_GET['Page']) > 1)
                $page_title .= ', page ' . ((int)$_GET['Page']);
            
        }

        if (!empty($page_title))
            $page_title .= ' | ';

		return $page_title . 'Beesness Better';
	}
}
?>
