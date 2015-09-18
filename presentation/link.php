<?php

class Link
{
	public static function Build($link, $type = 'http')
	{
        $base = (($type == 'http' || USE_SSL == 'no') ? 'http://' : 'https://') .
            getenv('SERVER_NAME');

		// If HTTP_SERVER_PORT is defined and different than default
        if (defined('HTTP_SERVER_PORT') && HTTP_SERVER_PORT != '80' &&
            strpos($base, 'https') === false)
        {
			// Append server port
			$base .= ':' . HTTP_SERVER_PORT;
		}

        $link = $base . VIRTUAL_LOCATION . $link;

		// Escape html
		return htmlspecialchars($link, ENT_QUOTES);
	}

    public static function ToSelf()
    {
        $link = substr($_SERVER['REQUEST_URI'], strlen(VIRTUAL_LOCATION));

        if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != "off")
            return self::Build($link, 'https');
        else
            return self::Build($link);
    }
    
    public static function Redirect($url)
    {
        header('Location: ' . htmlspecialchars_decode($url));
        exit();
    }
    
    public static function RemoveUrlKey($key, $url = '')
    {
        if (empty($url))
            $url = $_SERVER['QUERY_STRING'];

        parse_str($url, $params);
        
        unset($params[$key]);
        
        $i = 0;
        $newquery = '';

        foreach($params as $k => $v) { 
            if ($i++ == 0)
                $newquery .= '?'.$k;
            else
                $newquery .= '&'.$k;
            
            if (!empty($v))
                $newquery .= '='.$v;
        }
        
        return self::Build($newquery);
    }

    public static function ToCalendar()
    {
        $link = 'calendar';
        return self::Build($link);
    }
    
    public static function ToAllSurveys()
    {
        $link = 'all-surveys';
        return self::Build($link);
    }

    public static function ToSurvey()
    {
        $link = 'survey';
       // $link .= '?sid=';
       //$link .=  $surveyId;
        return self::Build($link);
    }
    
    public static function ToDataEntry()
    {
        $link = 'data-entry';
        return self::Build($link);
    }

    public static function ToCustomerProfile($page = null)
    {
        $link = 'customer-profile';
        return self::Build($link);
    }

    public static function ToClusterData($page = null)
    {
        $link = 'cluster-data';
        if(!empty($page))
            $link .= '&page=' . $page;
        return self::Build($link);
    }
    public static function ToBeehiveData($page = null)
    {
        $link = 'beehive-data';
        if(!empty($page))
            $link .= '&page=' . $page;
        return self::Build($link);
    }
    
    public static function ToCluster($ClusterId)
	{
        $link = 'cluster-data';

        $link .= '&cluster_id=';
            $link .=  $ClusterId;
	return self::Build($link);
	}                           
    
    public static function ToBeehive($beehiveId, $ClusterId)
    {
    $link = '';

    $link .= 'cluster_id=' . $ClusterId . '&';
    
    $link .= 'beehive_id=' . $beehiveId;

            return self::Build($link);
    }
    
    public static function ToOrganization($page = null)
    {
        $link = 'organization';
        if(!empty($page))
            $link .= '&page=' . $page;
        return self::Build($link);
    }
    
    public static function ToServices()
    {
        $link = 'services';
        return self::Build($link);
    }
    
    public static function ToTuvTimes()
    {
        $link = 'tuvtimes-newsletter';
        return self::Build($link);
    }
    
    public static function ToTuvTimesDetailsAdmin($tuvtimesId)
    {
        $link = 'Page=TuvTimesDetails&tuvtimesId=' . $tuvtimesId; 
            
        return self::ToAdmin($link);
    }
    
    public static function ToBriefingDetailsAdmin($announcementId)
    {
        $link = 'Page=BriefingDetails&AnnouncementId=' . $announcementId; 
            
        return self::ToAdmin($link);
    }
    
    public static function ToEducation()
    {
        $link = 'education';
        return self::Build($link);
    }
    
    public static function ToCyprus()
    {
        $link = 'cyprus';
        return self::Build($link);
    }
    
    public static function ToSitemap()
    {
        $link = 'sitemap';
        return self::Build($link);
    }
    
    public static function ToTerms()
    {
        $link = 'terms';
        return self::Build($link);
    }
    
    public static function ToBriefing($category = null, $pageNo = 1)
    {
        $link = 'briefing';
        return self::Build($link);
    }
    
    public static function ToOnlineApplication()
    {
        $link = 'online_application';
        return self::Build($link);
    }
    
    public static function ToAccreditations()
    {
        $link = 'accreditations';
        return self::Build($link);
    }
    
    public static function ToNewsletter($page = null)
    {
        $link = 'newsletter-subscribe';
        if(!empty($page))
            $link .= '&page=' . $page;
        return self::Build($link);
    }
    
    public static function ToNewsletterUnsubscribe($page = null)
    {
        $link = 'newsletter-unsubscribe';
        if(!empty($page))
            $link .= '&page=' . $page;
        return self::Build($link);
    }

    public static function ToContact()
    {
        $link = 'contact';
        return self::Build($link);
    }

    public static function ToDownload($filename)
    {
        $link = 'download.php?f=' . $filename;
        return self::Build($link);
    }
    
    public static function ToOpenPdf($filename)
    {
        $link = 'openpdf.php?f=' . $filename;
        return self::Build($link);
    }
    
    public static function ToImageResize($image, $width, $height)
    {
        $link = 'imgsize.php?w=' . $width . '&h=' . $height . '&img=' . $image;
        return self::Build($link);
    }

    private static function __ToFilter($filterParams)
    {
        $link = '';

        if (count($filterParams)) {
            $link .= 'filter-by/';
            /* Append filter parameters */
            foreach($filterParams as $name => $value) {
                if (!empty($value)) {
                    $link .= $name . '=';
                    if (!strcmp($name, 'category')) {
                        if (isset($categoryId) && is_null($categoryId)) {
                            $j = 0;
                            $fullpath = Catalog::GetCategoryParents($value);
                            foreach ($fullpath as $key => $category) {
                                if (count($fullpath) == ++$j)
                                    $link .= self::CleanUrlText($category['name']) . '-c' . $category['category_id'];
                                else
                                    $link .= self::CleanUrlText($category['name']) . '-';
                            }
                        } else
                            $link .= self::CleanUrlText(Catalog::GetCategoryName($value)) . '-c' . $value;
                    } else if (!strcmp($name, 'brand'))
                        $link .= self::CleanUrlText(Manufacturer::GetName($value)) . '-b' . $value;
                    else if (!strcmp($name, 'attributename'))
                        $link .= self::CleanUrlText(Catalog::GetAttributeName($value)) . '-a' . $value;
                    else
                        $link .= $value;
                    $link .= '/';
                }
            }
        }
        return $link;
    }

    public static function ToOffers($filterParams = array())
    {
        $link = 'offers/' . self::__ToFilter($filterParams);
        
        return self::Build($link);
    }
    
    public static function ToArrivals($filterParams = array(), $page = 1)
    {
        $link = 'arrivals/' . self::__ToFilter($filterParams);
        
        if ($page > 1)
            $link .= 'page-' . $page . '/';
        
        return self::Build($link);
    }

    public static function ToCategory($categoryId, $page = 1)
    {
        $i = 0;
        $link = '';

        /* 
        if (!is_null($categoryId)) {
            $fullpath = Catalog::GetCategoryParents($categoryId);

            foreach ($fullpath as $key => $category) {
                if (count($fullpath) == ++$i)
                    $link .= self::CleanUrlText($category['name']) . '-c' . $category['category_id'] . '/';
                else
                    $link .= self::CleanUrlText($category['name']) . '/';
            }
         }
         */

        $link = 'category_id=' . $categoryId;
        
        if ($page > 1)
            $link .= 'page-' . $page . '/';

        return self::Build($link);
    }

	public static function ToService($serviceId, $categoryId = null)
	{
        $link = '';

        if (!is_null($categoryId))
            $link .= 'category_id=' . $categoryId . '&';
        
        $link .= 'service_id=' . $serviceId;

		return self::Build($link);
	}
	public static function ToAnnouncement($announcementcategoryTag, $announcementId)
        
	{
        $link = 'briefing&';

            $link .= 'page=' . $announcementcategoryTag . '&';
        
        $link .= 'item=' . $announcementId;

		return self::Build($link);
	}
        
        public static function ToAnnouncementPageIndex($categoryTag, $page = 1)
	{
            
                    
                    $link = 'briefing&page=';
		$link .= $categoryTag;

		if ($page > 1)
			$link .= '&pageNo=' . $page;

		return self::Build($link);
	}

    public static function ToProductExtras($extra, $productId, $categoryId = null, $page = 1)
    {
        $link = self::ToProduct($productId, null, $categoryId);
        $link .= $extra . '/';
		if ($page > 1)
            $link .= 'page-' . $page .'/';
        return $link;
    }
    
	public static function ToIndex($page = 1)
	{
		$link = '';

		if ($page > 1)
			$link .= 'page-' . $page .'/';

		return self::Build($link);
	}

	public static function QueryStringToArray($queryString)
	{
		$result = array();

		if ($queryString != '')
		{
			$elements = explode('&', $queryString);

			foreach($elements as $key => $value)
			{
				$element = explode('=', $value);
				$result[urldecode($element[0])] =
					isset($element[1]) ? urldecode($element[1]) : '';
			}
		}

		return $result;
	}

	public static function CleanUrlText($string)
	{
		// Remove all characters that aren't a-z, 0-9, dash, underscore or space
		$not_acceptable_characters_regex = '#[^-a-zA-Z0-9_ ]#';
		//$string = preg_replace ($not_acceptable_characters_regex, '', $string);
		
		// Remove all leading and trailing spaces
		$string = trim($string);
		
		// Change all dashes, underscores and spaces to dashes
		$string = preg_replace ('#[-_ ]+#', '-', $string);
		
		// Return the modified string
		return strtolower($string);
	}
	
	// Redirects to proper URL if not already there
	public static function CheckRequest()
	{
		$proper_url = '';

        if (isset($_GET['Search']) || isset($_GET['SearchResults']) || 
            isset($_GET['ShoppingCart']) || isset($_GET['CustomerRegister']) ||
            isset($_GET['CustomerAccount']) || isset($_GET['CustomerLogout']) ||
            isset($_GET['Checkout']) || isset($_GET['SendGift']) || 
            isset($_GET['ShowGifts']) || isset($_GET['WishList']) || 
            isset($_GET['WishListsList'])) {
            return;
        }
		// Obtain proper URL for product pages
		elseif (isset ($_GET['ProductId']) && isset ($_GET['CategoryId'])) {
            $proper_url = self::ToProduct($_GET['ProductId'], isset($_GET['UniqueCategoryId']) ? 
                $_GET['UniqueCategoryId'] : null, $_GET['CategoryId']);
		}
		// Obtain proper URL for category pages
        elseif (isset ($_GET['CategoryId'])) {
            $unique_category_id = null;
            if (isset($_GET['UniqueCategoryId']))
                $unique_category_id = $_GET['UniqueCategoryId'];
            
            if (isset ($_GET['Page']))
                $proper_url = self::ToCategory($_GET['CategoryId'], 
					$unique_category_id, null, $_GET['Page']);
			else
				$proper_url = self::ToCategory($_GET['CategoryId'], $unique_category_id);
		}
		// Obtain proper URL for the home page
		else {
			if (isset($_GET['Page']))
				$proper_url = self::ToIndex($_GET['Page']);
			else
				$proper_url = self::ToIndex();
        }

    	/* Remove the virtual location from the requested URL
    	    so we can compare paths */
		$requested_url = self::Build(substr($_SERVER['REQUEST_URI'], 
            strlen(VIRTUAL_LOCATION)));

        /* Remove AjaxReq variable from requested url in order to match with proper url */
        if (isset($_GET['AjaxReq']))
            $requested_url = substr($requested_url, 0, strpos($requested_url, "AjaxReq") - 1) . '/';

		// 404 redirect if the requested product or category doesn't exist
		if (strstr($proper_url, '/-'))
		{
			// Clean output buffer
			ob_clean();

			// Load the 404 page
			include '404.php';

			// Clear the output buffer and stop execution
			flush(); 
			ob_flush(); 
			ob_end_clean(); 
			exit();
		}

        // 301 redirect to the proper URL if necessary
		/*if ($requested_url != $proper_url)
		{
			// Clean output buffer
			ob_clean();

			// Redirect 301 
			header('HTTP/1.1 301 Moved Permanently');
			header('Location: ' . $proper_url);

			// Clear the output buffer and stop execution
			flush();
			ob_flush();
			ob_end_clean();
			exit();
        }*/
	}

      // Create link to the search page
      public static function ToSearch()
      {
        $link = 'Search';
        return self::Build($link);
      }

    // Create link to a search results page
    public static function ToSearchResults($searchParams, $page = 1)
    {

        $link = 'search-results=' .$searchParams['search_string'];
        
/*        $basicParams = array('search_string' => '', 
            'words' => 'all');

        print_r($basicParams);
     
        if (count(array_diff_key($searchParams, $basicParams)))
            $link = 'index.php?search-results=advanced-find';
        else
            $link = 'index.php?search-results=find';

        foreach($searchParams as $name => $value) {
            if (!strcmp($name, 'search_string')) {
                if (!empty($value))
                    $link .= '-' . self::CleanUrlText($value);
            } else {
                $link .= $name;
                if (!empty($value))
                    $link .= '-' . $value;
            }
            $link .= '/';
        }

        if ($page > 1)
            $link .= 'page-' . $page . '/';
 */
        return self::Build($link);
    }

        public static function ToArticle($articleId)
        {
            $link = 'articles/' . $articleId . '/';
            return self::Build($link);
        }
        
        // Create link to admin page
        public static function ToAdmin($params = '')
        {
            $link = 'admin.php';
            
            if ($params != '')
                $link .= '?' . $params;
            
            return self::Build($link, 'https');
        }
    
    // Create logout link
    public static function ToLogout()
    {
        return self::ToAdmin('Page=Logout');
    }

    // Create link to the categories administration page
    public static function ToCategoriesAdmin()
    {
        $link = 'Page=Categories';
        return self::ToAdmin($link);
    }
    
    // Create link to the accreditations administration page
    public static function ToAccreditationsAdmin()
    {
        $link = 'Page=Accreditations';
        return self::ToAdmin($link);
    }
    
    // Create link to the education forms administration page
    public static function ToEducationFormsAdmin()
    {
        $link = 'Page=EducationForms';
        return self::ToAdmin($link);
    }
    
    // Create link to the education forms administration page
    public static function ToEducationSeminarsAdmin()
    {
        $link = 'Page=EducationSeminars';
        return self::ToAdmin($link);
    }
    
    // Create link to the terms administration page
    public static function ToTermsAdmin()
    {
        $link = 'Page=Terms';
        return self::ToAdmin($link);
    }
    
    // Create link to the category attributes administration page
    public static function ToCategoryAttributesAdmin($categoryId)
    {
        $link = 'Page=CategoryAttributes&CategoryId=' . $categoryId;
        return self::ToAdmin($link);
    }
    
    // Create link to the category options administration page
    public static function ToCategoryOptionsAdmin($categoryId)
    {
        $link = 'Page=CategoryOptions&CategoryId=' . $categoryId;
        return self::ToAdmin($link);
    }
    
    // Create link to the category subcategories administration page
    public static function ToSubcategoriesAdmin($categoryId)
    {
        $link = 'Page=Subcategories&CategoryId=' . $categoryId;
        return self::ToAdmin($link);
    }
    
    // Create link to products compare page
    public static function ToProductsCompare($which = null)
    {
        $link = 'compare-products/';

        if (!is_null($which))
            $link .= $which . '/';

		return self::Build($link);
    }
    
    // Create link to a products administration page
    public static function ToProductsAdmin($storeId = null, $categoryId = null, $page = 1)
    {
        $link = 'Page=Products';
        
        if (!is_null($storeId))
            $link .= '&StoreId=' . $storeId;

        if (!is_null($categoryId))
            $link .= '&CategoryId=' . $categoryId;
        
        if ($page > 1)
            $link .= '&PageNo=' . $page;
        
        return self::ToAdmin($link);
    }
    
    // Create link to a product add administration page
    public static function ToProductAddAdmin($categoryId = null, $storeId = null)
    {
        $link = 'Page=AddProduct';
        
        if (!is_null($categoryId))
            $link .= '&CategoryId=' . $categoryId;
        
        if (!is_null($storeId))
            $link .= '&StoreId=' . $storeId;
        
        return self::ToAdmin($link);
    }
    
    // Create link to a products administration page
    public static function ToProductDetailsAdmin($productId, $storeId = null, $categoryId = null)
    {
        $link = 'Page=ProductDetails&ProductId=' . $productId;

        if (!is_null($storeId))
            $link .=  '&StoreId=' . $storeId;
        
        if (!is_null($categoryId))
            $link .=  '&CategoryId=' . $categoryId;

        return self::ToAdmin($link);
    }


    // Create link to checkout page
    public static function ToCheckout($step = null)
    {
        $link = 'checkout/';

        if (!is_null($step))
            $link .= $step . '/';
        
        return self::Build($link, 'https');
    }

    // Create link to shopping carts administration page
    public static function ToCartsAdmin()
    {
        return self::ToAdmin('Page=ShoppingCarts');
    }
    
    // Create link to orders administration page
    public static function ToOrganizationAdmin()
    {
        $link = 'Page=Organization';

        return self::ToAdmin($link);
    }
    
    // Create link to manufacturers administration page
    public static function ToManufacturersAdmin()
    {
        return self::ToAdmin('Page=Manufacturers');
    }
    
    // Create link to order details administration page
    public static function ToOrderDetailsAdmin($orderId, $storeId)
    {
        $link = 'Page=OrderDetails&OrderId=' . $orderId . '&StoreId=' . $storeId; 
            
        return self::ToAdmin($link);
    }

    // Create link to stores administration page
    public static function ToStoresAdmin()
    {
        $link = 'Page=Stores'; 
            
        return self::ToAdmin($link);
    }
    
    // Create link to files administration page
    public static function ToFilesAdmin()
    {
        $link = 'Page=Files'; 
            
        return self::ToAdmin($link);
    }
    
    // Create link to TÜV Times administration page
    public static function ToTuvTimesAdmin()
    {
        $link = 'Page=TuvTimes'; 
            
        return self::ToAdmin($link);
    }
    
    // Create link to administrators administration page
    public static function ToAdministratorsAdmin()
    {
        $link = 'Page=Administrators'; 
            
        return self::ToAdmin($link);
    }
    
    // Create link to reviews administration page
    public static function ToReviewsAdmin($page = 1, $reviewId = null)
    {
        $link = 'Page=Reviews'; 
        
        if ($page > 1)
            $link .= '&PageNo=' . $page;

        if (!is_null($reviewId))
            $link .= '&ReviewId=' . $reviewId; 
            
        return self::ToAdmin($link);
    }
    
    // Create link to questions administration page
    public static function ToQuestionsAdmin($page = 1)
    {
        $link = 'Page=Questions'; 
        
        if ($page > 1)
            $link .= '&PageNo=' . $page;

        return self::ToAdmin($link);
    }
    
    // Create link to question details administration page
    public static function ToQuestionDetailsAdmin($questionId)
    {
        $link = 'Page=QuestionDetails&QuestionId=' . $questionId; 
            
        return self::ToAdmin($link);
    }
    
    public static function ToPromotionAdmin($type = '', $page = 1)
    {
        $link = 'Page=Promotion';

        if ($type == PROMOTION_TYPE_PRODUCT_OFFER)
            $link .= '&PromotionType=Offers';
        else if ($type == PROMOTION_TYPE_PRODUCT_ARRIVAL)
            $link .= '&PromotionType=Arrivals';
        else if ($type == PROMOTION_TYPE_PRODUCT_FRONTPAGE)
            $link .= '&PromotionType=Frontpage';
        else if ($type == PROMOTION_TYPE_BANNER)
            $link .= '&PromotionType=Banners';
        else if ($type == PROMOTION_TYPE_ARTICLE)
            $link .= '&PromotionType=Articles';
        
        if ($page > 1)
            $link .= '&PageNo=' . $page;

        return self::ToAdmin($link);
    }
    
    public static function ToSponsorsAdmin()
    {
        $link = 'Page=Sponsors';
        return self::ToAdmin($link);
    }
    
    public static function ToBannersAdmin()
    {
        $link = 'Page=Promotion';
        return self::ToAdmin($link);
    }
    
    public static function ToBriefingAdmin()
    {
        $link = 'Page=Briefing'; 
            
        return self::ToAdmin($link);
    }
    
    // Create link to sponsor details administration page
    public static function ToSponsorDetailsAdmin($sponsorId)
    {
        $link = 'Page=SponsorDetails&SponsorId=' . $sponsorId; 
            
        return self::ToAdmin($link);
    }
    
    public static function ToNewsletterAdmin()
    {
        $link = 'Page=Newsletter';
        return self::ToAdmin($link);
    }
    
    public static function ToBannerDetailsAdmin($bannerId)
    {
        $link = 'Page=BannerDetails&BannerId=' . $bannerId;
        return self::ToAdmin($link);
    }
    
    public static function ToArticleDetailsAdmin($articleId)
    {
        $link = 'Page=ArticleDetails&ArticleId=' . $articleId;
        return self::ToAdmin($link);
    }
    
    // Create link to reports administration page
    public static function ToReportsAdmin()
    {
        return self::ToAdmin('Page=Reports');
    }
    
    // Create link to shipping charges administration page
    public static function ToShippingAdmin()
    {
        return self::ToAdmin('Page=Shipping');
    }
    
    // Create link to administrator details administration page
    public static function ToAdministratorDetailsAdmin($administratorId, $changePassword = false)
    {
        $link = 'Page=AdministratorDetails&AdministratorId=' . $administratorId; 
        
        if ($changePassword)
            $link .= '&ChangePassword'; 
            
        return self::ToAdmin($link);
    }
    
    // Create link to manufacturer details administration page
    public static function ToManufacturerDetailsAdmin($manufacturerId)
    {
        $link = 'Page=ManufacturerDetails&ManufacturerId=' . $manufacturerId; 
            
        return self::ToAdmin($link);
    }

    // Create link to store details administration page
    public static function ToStoreDetailsAdmin($storeId)
    {
        $link = 'Page=StoreDetails&StoreId=' . $storeId; 
            
        return self::ToAdmin($link);
    }

    // Create link to customer accounts administration page
    public static function ToCustomersAdmin()
    {
        return self::ToAdmin('Page=Customers');
    }
    
    // Create link to product search administration page
    public static function ToSearchAdmin()
    {
        return self::ToAdmin('Page=Search');
    }
    
    public static function ToSearchAdminResults($searchParams, $page = 1)
    {
        $link = 'Page=SearchResults';

        foreach($searchParams as $key => $value) {
            if (!empty($value))
                $link .= '&' . str_replace(' ', '', ucwords(str_replace('_', ' ', $key))) . '=' . $value;
        }

        if ($page > 1)
            $link .= '&PageNo=' . $page;
        
        return self::ToAdmin($link);
    }
    
    // Create link to register customer
    public static function ToRegisterCustomer()
    {
        return self::Build('customer/register/', 'https');
    }
    
    public static function ToRecoverPassword($rid = null, $user = null)
    {
        $link = 'index.php?RecoverPassword';
        
        if (!is_null($rid))
            $link .= '&rid=' . $rid;

        if (!is_null($user))
            $link .= '&user=' . $user;

        return self::Build($link, 'https');
    }
    
    // Create link to customer account
    public static function ToCustomerAccount($changePassword = null)
    {
        if (is_null($changePassword) || !$changePassword)
            $link = 'customer/account/';
        else
            $link = 'customer/account/change_password/';
        
        return self::Build($link, 'https');
    }
    
    // Create link to customer login
    public static function ToCustomerLogin()
    {
        return self::Build('customer/login/', 'https');
    }

    // Create link to customer logout
    public static function ToCustomerLogout()
    {
        return self::Build('customer/logout/');
    }
    
    public static function ToCustomerOrders()
    {
        return self::Build('customer/orders/');
    }

    public static function ToRecentlyViewed()
    {
        return self::Build('recently-viewed/');
    }

    public static function ToNewsletterSignupConfirm($email, $confirmationId)
    {
        $link = 'NewsletterSignupConfirm&confid=' . 
            $confirmationId . '&newsletter_email=' . $email;
        
        return self::Build($link, 'https');
    }
    
    // Create link to a organization administration page
    public static function ToOrganizationDetailsAdmin($organizationCategoryId)
    {
        $link = 'Page=OrganizationDetails&OrganizationCategoryId=' . $organizationCategoryId;
        
        return self::ToAdmin($link);
    }

    // Create link to a organization administration page
    public static function ToEducationApplicationFormsDetailsAdmin($applicationId)
    {
        $link = 'Page=EducationFormsDetails&ApplicationId=' . $applicationId;
        
        return self::ToAdmin($link);
    }


    public static function ToCategoryChildrenSorting($categoryId)
    {
        $link = 'Page=CategoryChildrenSorting&CategoryId=' . $categoryId;
        
        return self::ToAdmin($link);
    }
}
?>
