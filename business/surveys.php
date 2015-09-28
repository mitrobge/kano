<?php

define('SEMINARS_SORT_BY_DATE', 0);
define('SEMINARS_SORT_BY_STATUS', 1);
define('SEMINARS_SORT_BY_CUSTOMER', 2);

// Database Queries
class Surveys 
{
  	/* Calculates how many pages of orders could be filled by the
  	   number of orders returned by the $countSql query */
	public static function HowManyPages($countSql, $countSqlParams, $itemsPerPage = SEMINARS_PER_PAGE_ADMIN)
        {
        // Execute the query
        $items_count = DatabaseHandler::GetOne($countSql, $countSqlParams);
        
        $itemsPerPage = 10;

        // Calculate the number of pages
        
        $how_many_pages = ceil($items_count / $itemsPerPage);

		// Return the number of pages    
		return $how_many_pages;
	}
        
        // Retrieves a category
	public static function GetCategory($categoryId, $languageId = null)
	{
        // Get current session's languageId if not specified
        if (is_null($languageId))
            $languageId = Language::Get();
        
        // Build SQL query
		$sql = 'CALL surveys_get_category(:category_id, :language_id)';
                
        // Build the parameters array
        $params = array(':category_id' => $categoryId, 
            ':language_id' => $languageId);

		// Execute the query and return the results
		return DatabaseHandler::GetRow($sql, $params);
	}
    
    // Retrieves all product categories
	public static function GetCategories($parentId = null, $languageId = null)
        {
        // Get current session's languageId if not specified
        if (is_null($languageId)) {
            $languageId = Language::Get();
        }
        
        // Build SQL query
		$sql = 'CALL surveys_get_categories(:parent_id, :language_id)';
                
        // Build the parameters array
        $params = array(':parent_id' => $parentId, 
            ':language_id' => $languageId);

		// Execute the query and return the results
		return DatabaseHandler::GetAll($sql, $params);
	}

  	/* Calculates how many pages of products could be filled by the
  	   number of products returned by the $countSql query */
	private static function aHowManyPages($countSql, $countSqlParams, $itemsPerPage = PRODUCTS_PER_PAGE)
	{
        //unset($_SESSION['last_count_hash']);
            //unset($_SESSION['how_many_pages']);
         

        // Create a hash for the sql query 
		$queryHashCode = md5($countSql . var_export($countSqlParams, true) . $itemsPerPage);


		// Verify if we have the query results in cache
		if (isset ($_SESSION['last_count_hash']) &&
			isset ($_SESSION['how_many_pages']) &&
			$_SESSION['last_count_hash'] == $queryHashCode)
		{
			// Retrieve the the cached value
			$how_many_pages = $_SESSION['how_many_pages'];
		}
		else
                {
			// Execute the query
                        $items_count = DatabaseHandler::GetOne($countSql, $countSqlParams);

			// Calculate the number of pages
			$how_many_pages = ceil($items_count / $itemsPerPage);

			// Save the query and its count result in the session
			$_SESSION['last_count_hash'] = $queryHashCode;
                        $_SESSION['how_many_pages'] = $how_many_pages;
		}

		// Return the number of pages    
		return $how_many_pages;
	}
        
    public static function GetSurveys($categoryId, $languageId = null)
    {
        // Get current session's languageId if not specified
        if (is_null($languageId))
            $languageId = Language::Get();
        
        // Build SQL query
		$sql = 'CALL surveys_get_surveys(:category_id, :language_id)';
                
        // Build the parameters array
        $params = array(':category_id' => $categoryId, 
            ':language_id' => $languageId);
        
        // Execute the query and return the results
		return DatabaseHandler::GetAll($sql, $params);
    }

	public static function GetSurveyDetails ($surveyId, $languageId = null)
	{
        // Get current session's languageId if not specified
        if (is_null($languageId))
            $languageId = Language::Get();
        
        // Build SQL query
		$sql = 'CALL surveys_get_survey_details(:survey_id, :language_id)';

		// Build the parameters array
        $params = array(':survey_id' => $surveyId, 
            ':language_id' => $languageId);

		// Execute the query and return the results
		return DatabaseHandler::GetRow($sql, $params);
	}

        public static function GetCategoryName($categoryId, $languageId = null)
        {
            // Get current session's languageId if not specified
            if (is_null($languageId))
                $languageId = Language::Get();

            // Build SQL query
            $sql = 'CALL surveys_get_category_name(:category_id, :language_id)';

            // Build the parameters array
            $params = array(':category_id' => $categoryId, ':language_id' => $languageId);

            // Execute the query and return the results
            return DatabaseHandler::GetOne($sql, $params);
        }
        
        public static function DeleteCategory($categoryId, $forceDelete = false)
        {
            // Build SQL query
            $sql = 'CALL surveys_delete_category(:category_id, :force_delete)';

            // Build the parameters array
            $params = array(':category_id' => $categoryId, 
                ':force_delete' => $forceDelete);

            // Execute the query and return the results
            return DatabaseHandler::GetOne($sql, $params);
        }
    
	public static function GetCategoryDetails($categoryId, $languageId = null)
	{
        // Get current session's languageId if not specified
        if (is_null($languageId))
            $languageId = Language::Get();
        
        // Build SQL query
		$sql = 'CALL surveys_get_category_details(:category_id, :language_id)';

		// Build the parameters array
		$params = array(':category_id' => $categoryId, ':language_id' => $languageId);

		// Execute the query and return the results
		return DatabaseHandler::GetOne($sql, $params);
        }

    public static function GetCategoryFullName($categoryId, $languageId = null)
	{
        // Get current session's languageId if not specified
        if (is_null($languageId))
            $languageId = Language::Get();
        
        // Build SQL query
		$sql = 'CALL catalog_get_category_fullname(:category_id, :language_id)';

		// Build the parameters array
		$params = array(':category_id' => $categoryId, ':language_id' => $languageId);

		// Execute the query and return the results
		return DatabaseHandler::GetOne($sql, $params);
    }
    
    public static function Search($searchParams, $pageNo, &$rHowManyPages, $productsPerPage = PRODUCTS_PER_PAGE, $languageId)
    {


        $search_string = null;
        $is_advanced_search = false;
        $attribute_value_words = array();


        // The search result will be an array of this form
        $search_result = array ('original_phrase' => $searchParams['search_string'],
                                'accepted_words' => array(),
                                'ignored_words' => array(),
                                'products' => array());

        $searchParams['has_attribute_value'] = null;

        // Search string delimeters
        $delimeters = ',.; ';


        // Parse the search string if not empty, and find the search words
        if (!empty($searchParams['search_string'])) {
            /* On the first call to strtok you supply the whole
                search string and the list of delimiters.
                It returns the first word of the string */
            $word = strtok ($searchParams['search_string'], $delimeters);


            // Parse the string word by word until there are no more words
            while ($word) {
                if (strlen ($word) < FT_MIN_WORD_LEN)
                    $search_result['ignored_words'][] = $word;
                else
                    $search_result['accepted_words'][] = $word;

                // Get the next word of the search string
                $word = strtok ($delimeters);
            }
        }
        

        // If there aren't any accepted words and we are in basic search return the empty $search_result
        if (count($search_result['accepted_words']) == 0 && !$is_advanced_search)
            return $search_result;

        // If word mode is 'all' then we append a ' +' to each word
        if (!empty($searchParams['search_string'])) {
                $search_string = implode (" +", $search_result['accepted_words']);
                $search_string = "+" . $search_string;
        }


        // Report all PHP errors (see changelog)
         error_reporting(E_ALL);

        // Count the search results
        $sql = 'CALL services_count_search_results(:search_string, :words_mode, :language_id)';
        $params = array (':search_string' => $search_string,
                         ':words_mode' => 'all',
                         ':language_id' => $languageId);


        $rHowManyPages = Services::HowManyPages($sql, $params, $productsPerPage);

        $start_item = ($pageNo - 1) * $productsPerPage;

        if ($rHowManyPages == 1) {
            $productsPerPage = DatabaseHandler::GetOne($sql, $params);
            $short_product_description_length = FULL_PRODUCT_DESCRIPTION_LENGTH;
        } else {
            // Calculate the number of pages required to display the products
            $rHowManyPages = self::HowManyPages($sql, $params, $productsPerPage);
        }

        


        $start_item = ($pageNo - 1) * $productsPerPage;

        // Get the results from db
        $sql = 'CALL services_search(:search_string, :words_mode,
                                    :short_product_description_length, 
                                    :products_per_page, :start_item,
                                    :language_id)';

        $params = array (':search_string' => $search_string,
                         ':words_mode' => 'all',
                         ':short_product_description_length' => 200,
                         ':products_per_page' => 10,
                         ':start_item' => $start_item,
                         ':language_id' => $languageId);

        $search_result['products'] = DatabaseHandler::GetAll($sql, $params);

        return $search_result;
    }
    
    public static function SearchNews($searchParams, $pageNo, &$rHowManyPages, $productsPerPage = PRODUCTS_PER_PAGE, $languageId)
    {
        $search_string = null;
        $is_advanced_search = false;
        $attribute_value_words = array();


        // The search result will be an array of this form
        $search_result = array ('original_phrase' => $searchParams['search_string'],
                                'accepted_words' => array(),
                                'ignored_words' => array(),
                                'products' => array());



        $searchParams['has_attribute_value'] = null;

        // Search string delimeters
        $delimeters = ',.; ';


        // Parse the search string if not empty, and find the search words
        if (!empty($searchParams['search_string'])) {
            /* On the first call to strtok you supply the whole
                search string and the list of delimiters.
                It returns the first word of the string */
            $word = strtok ($searchParams['search_string'], $delimeters);


            // Parse the string word by word until there are no more words
            while ($word) {
                if (strlen ($word) < FT_MIN_WORD_LEN)
                    $search_result['ignored_words'][] = $word;
                else
                    $search_result['accepted_words'][] = $word;

                // Get the next word of the search string
                $word = strtok ($delimeters);
            }
        }
        

        // If there aren't any accepted words and we are in basic search return the empty $search_result
        if (count($search_result['accepted_words']) == 0 && !$is_advanced_search)
            return $search_result;

        // If word mode is 'all' then we append a ' +' to each word
        if (!empty($searchParams['search_string'])) {
                $search_string = implode (" +", $search_result['accepted_words']);
                $search_string = "+" . $search_string;
        }


        // Report all PHP errors (see changelog)
         error_reporting(E_ALL);

        // Count the search results
        $sql = 'CALL services_count_search_news_results(:search_string, :words_mode, :language_id)';
        $params = array (':search_string' => $search_string,
                         ':words_mode' => 'all',
                         ':language_id' => $languageId);


        $rHowManyPages = Services::HowManyPages($sql, $params, $productsPerPage);

        $start_item = ($pageNo - 1) * $productsPerPage;

        if ($rHowManyPages == 1) {
            $productsPerPage = DatabaseHandler::GetOne($sql, $params);
            $short_product_description_length = FULL_PRODUCT_DESCRIPTION_LENGTH;
        } else {
            // Calculate the number of pages required to display the products
            $rHowManyPages = self::HowManyPages($sql, $params, $productsPerPage);
        }

        


        $start_item = ($pageNo - 1) * $productsPerPage;

        // Get the results from db
        $sql = 'CALL services_search_news(:search_string, :words_mode,
                                    :short_product_description_length, 
                                    :products_per_page, :start_item,
                                    :language_id)';

        $params = array (':search_string' => $search_string,
                         ':words_mode' => 'all',
                         ':short_product_description_length' => 200,
                         ':products_per_page' => 10,
                         ':start_item' => $start_item,
                         ':language_id' => $languageId);

        $search_result['products'] = DatabaseHandler::GetAll($sql, $params);

        return $search_result;
    }

    public static function AddCategory($parentId = null)
    {
        // Build SQL query
        $sql = 'CALL surveys_add_category(:parent_id)';

        // Build the parameters array
        $params = array(':parent_id' => $parentId);
        
        // Execute the query
        return DatabaseHandler::GetOne($sql, $params);
    }
    
    public static function UpdateCategory($categoryId, $categoryName, $languageId)
    {
		// Build SQL query
        $sql = 'CALL catalog_update_category(:category_id, 
                                            :category_name,
                                            :language_id)';

		// Build the parameters array
        $params = array(':category_id' => $categoryId, 
            ':category_name' => $categoryName,
            ':language_id' => $languageId);

		// Execute the query
		DatabaseHandler::Execute($sql, $params);
    }
    
    public static function SetCategoryName($categoryId, $categoryName, $languageId)
    {
		// Build SQL query
        $sql = 'CALL surveys_set_category_name(:category_id, 
            :category_name, :language_id)';

		// Build the parameters array
        $params = array(':category_id' => $categoryId, 
            ':category_name' => $categoryName,
            ':language_id' => $languageId);

		// Execute the query and return the results
		DatabaseHandler::Execute($sql, $params);
    }
    
    public static function SetCategoryImage($categoryId, $imageName)
    {
		// Build SQL query
        $sql = 'CALL services_set_category_image(:category_id, :image_name)';
        
        // Build the parameters array
        $params = array(':category_id' => $categoryId,
                        ':image_name' => $imageName);

		// Execute the query
		DatabaseHandler::Execute($sql, $params);
    }
    
    public static function AddProduct($storeId, $categoryId, $erpCode, $manufacturerId, $productPrice, $isBulky)
    {
		// Build SQL query
        $sql = 'CALL catalog_add_product(:store_id, :category_id, :erp_code, :manufacturer_id, :product_price, :isbulky)';

		// Build the parameters array
        $params = array(':store_id' => $storeId,
                        ':category_id' => $categoryId,
                        ':erp_code' => empty($erpCode) ? null : $erpCode,
                        ':manufacturer_id' => empty($manufacturerId) ? null : $manufacturerId,
                        ':product_price' => $productPrice,
                        ':isbulky' => $isBulky);

		// Execute the query
		return DatabaseHandler::GetOne($sql, $params);
    }

    public static function GetProductCategories($productId, $languageId = null)
    {
        // Get current session's languageId if not specified
        if (is_null($languageId))
            $languageId = Language::Get();
        
        // Build SQL query
		$sql = 'CALL catalog_get_product_categories(:product_id, :language_id)';

		// Build the parameters array
        $params = array(':product_id' => $productId, 
                        ':language_id' => $languageId);

		// Execute the query and return the results
		return DatabaseHandler::GetAll($sql, $params);
    }

    public static function GetNotProductCategories($productId, $languageId = null)
    {
        // Get current session's languageId if not specified
        if (is_null($languageId))
            $languageId = Language::Get();
        
        // Build SQL query
        $sql = 'CALL catalog_get_not_product_categories(
                    :product_id, :language_id)';

		// Build the parameters array
        $params = array(':product_id' => $productId, 
                        ':language_id' => $languageId);

		// Execute the query and return the results
		return DatabaseHandler::GetAll($sql, $params);
    }

    public static function UpdateProductInfo($productId, $erpCode, $manufacturerId, $quantity, 
                                                $productPrice, $productDiscountPrice, $isBulky)
    {
		// Build SQL query
        $sql = 'CALL catalog_update_product_info(:product_id, :erp_code, :manufacturer_id, :product_quantity,  
                                                    :product_price, :product_discount_price, :isbulky)';
		// Build the parameters array
        $params = array(':product_id' => $productId,
                        ':erp_code' => empty($erpCode) ? null : $erpCode,
                        ':manufacturer_id' => $manufacturerId,
                        ':product_quantity' => $quantity, 
                        ':product_price' => $productPrice, 
                        ':product_price' => $productPrice, 
                        ':product_discount_price' => $productDiscountPrice,
                        ':isbulky' => $isBulky);

		// Execute the query
		DatabaseHandler::Execute($sql, $params);
    }
 
    public static function AssignProductToCategory($productId, $categoryId)
    {
		// Build SQL query
        $sql = 'CALL catalog_assign_product_to_category(:product_id, :category_id)';
        
        // Build the parameters array
        $params = array(':product_id' => $productId,
                        ':category_id' => $categoryId);

		// Execute the query
		DatabaseHandler::Execute($sql, $params);
    }

    public static function UpdateProductAttribute($productId, $attributeId, 
                                                    $languageId, $attributeValue)
    {
		// Build SQL query
        $sql = 'CALL catalog_update_product_attribute(:product_id, :attribute_id, 
                                                      :language_id, :attribute_value)';
		// Build the parameters array
        $params = array(':product_id' => $productId,
                        ':attribute_id' => $attributeId, 
                        ':language_id' => $languageId, 
                        ':attribute_value' => $attributeValue);

		// Execute the query
		DatabaseHandler::Execute($sql, $params);
    }

    public static function DeleteProduct($productId)
    {
		// Build SQL query
        $sql = 'CALL catalog_delete_product(:product_id)';
        
        // Build the parameters array
        $params = array(':product_id' => $productId);

		// Execute the query
		DatabaseHandler::Execute($sql, $params);
    }
    
    public static function RemoveProductFromCategory($productId, $categoryId)
    {
		// Build SQL query
        $sql = 'CALL catalog_remove_product_from_category(:product_id, :category_id)';
        
        // Build the parameters array
        $params = array(':product_id' => $productId,
                        ':category_id' => $categoryId);

		// Execute the query
		DatabaseHandler::Execute($sql, $params);
    }

    public static function MoveProductToCategory($productId, $oldCategoryId, 
                                                $newCategoryId)
    {
        self::AssignProductToCategory($productId, $newCategoryId);
        self::RemoveProductFromCategory($productId, $oldCategoryId);
    }

    public static function SetServiceName($serviceId, $serviceName, 
       $serviceDescription, $languageId)
    {
		// Build SQL query
        $sql = 'CALL services_set_service_name(:service_id, :service_name, 
            :service_description, :language_id)';
        
        // Build the parameters array
        $params = array(':service_id' => $serviceId,
            ':service_name' => $serviceName,
            ':service_description' => $serviceDescription,
            ':language_id' => $languageId);

		// Execute the query
		DatabaseHandler::Execute($sql, $params);
    }
    
    public static function SetServiceImage($serviceId, $imageName)
    {
		// Build SQL query
        $sql = 'CALL services_set_service_image(:service_id, :image_name)';
        
        // Build the parameters array
        $params = array(':service_id' => $serviceId,
                        ':image_name' => $imageName);

		// Execute the query
		DatabaseHandler::Execute($sql, $params);
    }

    public static function SetServiceResources($resourceId, $theResource, $visibility, $resourceTypeDesc)
    {
		// Build SQL query
        $sql = 'CALL services_set_service_resources(:resource_id, :the_resource, :visibility, :resource_type_desc)';

        // Build the parameters array
        $params = array(':resource_id' => $resourceId,
                        ':the_resource' => $theResource,
                        ':visibility' => $visibility,
                        ':resource_type_desc' => $resourceTypeDesc);

		// Execute the query
		DatabaseHandler::Execute($sql, $params);
    }
    
    public static function AddResourceToService($serviceId, $languageId, $resourceType)
    {
		// Build SQL query
        $sql = 'CALL services_add_resource_to_service(:service_id, :language_id, :resource_type)';

        // Build the parameters array
        $params = array(':service_id' => $serviceId,
                        ':language_id' => $languageId,
                        ':resource_type' => $resourceType);

		// Execute the query
		DatabaseHandler::Execute($sql, $params);
    }
    
    public static function GetSurveyDefaultTabs($serviceId, $languageId)
    {
		// Build SQL query
        $sql = 'CALL surveys_get_service_available_default_tabs(:service_id, :language_id)';

        // Build the parameters array
        $params = array(':service_id' => $serviceId,
                        ':language_id' => $languageId);

		// Execute the query
                return DatabaseHandler::GetAll($sql, $params);
    }
    
    public static function SetProductImage($productId, $imageName)
    {
		// Build SQL query
        $sql = 'CALL catalog_set_product_image(:product_id, :image_name)';
        
        // Build the parameters array
        $params = array(':product_id' => $productId,
                        ':image_name' => $imageName);

		// Execute the query
		DatabaseHandler::Execute($sql, $params);
    }
    
    public static function SetProductImage2($productId, $image2Name)
    {
		// Build SQL query
        $sql = 'CALL catalog_set_product_image2(:product_id, :image2_name)';
        
        // Build the parameters array
        $params = array(':product_id' => $productId,
                        ':image2_name' => $image2Name);

		// Execute the query
		DatabaseHandler::Execute($sql, $params);
    }
    
    public static function SetProductThumbnail($productId, $thumbnailName)
    {
		// Build SQL query
        $sql = 'CALL catalog_set_product_thumbnail(:product_id, :thumbnail_name)';
        
        // Build the parameters array
        $params = array(':product_id' => $productId,
                        ':thumbnail_name' => $thumbnailName);

		// Execute the query
		DatabaseHandler::Execute($sql, $params);
    }
    
    public static function AddProductResource($productId, $theResource, $resourceType = null)
    {
		// Build SQL query
        $sql = 'CALL catalog_add_product_resource(:product_id, :resource_type, :the_resource)';
        
        // Build the parameters array
        $params = array(':product_id' => $productId,
                        ':resource_type' => $resourceType,
                        ':the_resource' => $theResource);

		// Execute the query
		DatabaseHandler::Execute($sql, $params);
    }
    
    public static function AddService($categoryId)
    {
		// Build SQL query
        $sql = 'CALL services_add_service(:category_id)';
        
        // Build the parameters array
        $params = array(':category_id' => $categoryId);

		// Execute the query
		return DatabaseHandler::GetOne($sql, $params);
    }
    
    public static function DeleteService($serviceId)
    {
		// Build SQL query
        $sql = 'CALL services_delete_service(:service_id)';
        
        // Build the parameters array
        $params = array(':service_id' => $serviceId);

		// Execute the query
		DatabaseHandler::Execute($sql, $params);
    }
    
    public static function RemoveProductResource($resourceId)
    {
		// Build SQL query
        $sql = 'CALL catalog_remove_product_resource(:resource_id)';
        
        // Build the parameters array
        $params = array(':resource_id' => $resourceId);

		// Execute the query
		DatabaseHandler::Execute($sql, $params);
    }

    public static function CheckCategoryName($parentId, $categoryId, $categoryName, $languageId)
    {
        // Build SQL query
        $sql = 'CALL catalog_check_category_name(:parent_id, :category_id, 
                    :category_name, :language_id)';
		// Build the parameters array
        $params = array(':parent_id' => $parentId, 
                        ':category_id' => $categoryId,
                        ':category_name' => $categoryName,
                        ':language_id' => $languageId);

		// Execute the query
        return DatabaseHandler::GetOne($sql, $params);
    }
    
    public static function GetSurveyParent($serviceId, $languageId)
    {
        // Build SQL query
        $sql = 'CALL surveys_get_service_parent(:service_id, :language_id)';
	// Build the parameters array
        $params = array(':service_id' => $serviceId, 
                        ':language_id' => $languageId);

	// Execute the query
        return DatabaseHandler::GetOne($sql, $params);
    }
    
    public static function GetCategoryParents($categoryId, $languageId = null)
    {
        // Get current session's languageId if not specified
        if (is_null($languageId))
            $languageId = Language::Get();
        
        // Build SQL query
        $sql = 'CALL catalog_get_category_parents(:category_id, :language_id)';
		// Build the parameters array
        $params = array(':category_id' => $categoryId,
                        ':language_id' => $languageId);

		// Execute the query
        return DatabaseHandler::GetAll($sql, $params);
    }
    
    public static function GetCategoriesTree($startingCategoryId = null, $languageId = null)
    {
        // Get current session's languageId if not specified
        if (is_null($languageId))
            $languageId = Language::Get();
        
        // Build SQL query
        $sql = 'CALL catalog_get_categories_tree(:starting_category_id, :language_id)';
        
        // Build the parameters array
        $params = array(':starting_category_id' => $startingCategoryId,
            ':language_id' => $languageId);
        
        // Execute the query
        return DatabaseHandler::GetAll($sql, $params);
    }

    public static function GetSurveyName($serviceId, $languageId = null)
    {
        // Get current session's languageId if not specified
        if (is_null($languageId))
            $languageId = Language::Get();

		// Build SQL query
		$sql = 'CALL surveys_get_survey_name(:service_id, :language_id)';

		// Build the parameters array
		$params = array(':service_id' => $serviceId, ':language_id' => $languageId);

		// Execute the query and return the results
		return DatabaseHandler::GetOne($sql, $params);
	}
    
    public static function GetSurveyDescription($surveyId, $languageId = null)
    {
        // Get current session's languageId if not specified
        if (is_null($languageId))
            $languageId = Language::Get();

		// Build SQL query
		$sql = 'CALL surveys_get_survey_description(:survey_id, :language_id)';

		// Build the parameters array
		$params = array(':survey_id' => $surveyId, ':language_id' => $languageId);

		// Execute the query and return the results
		return DatabaseHandler::GetOne($sql, $params);
	}
    
    public static function GetSurveyResources($serviceId, $resourceType = null, $languageId = null)
    {
        // Get current session's languageId if not specified
        if (is_null($languageId))
            $languageId = Language::Get();
        
        // Build SQL query
        $sql = 'CALL surveys_get_service_resources(:service_id, :resource_type, :language_id)';

		// Build the parameters array
        $params = array(':service_id' => $serviceId,
                        ':resource_type' => $resourceType,
                        ':language_id' => $languageId);

		// Execute the query
        return DatabaseHandler::GetAll($sql, $params);
    }
    
    public static function GetSurveyAllResources($serviceId, $languageId = null)
    {
        // Get current session's languageId if not specified
        if (is_null($languageId))
            $languageId = Language::Get();
        
        // Build SQL query
        $sql = 'CALL surveys_get_service_all_resources(:service_id, :language_id)';

		// Build the parameters array
        $params = array(':service_id' => $serviceId,
                        ':language_id' => $languageId);

		// Execute the query
        return DatabaseHandler::GetAll($sql, $params);
    }
    
    public static function GetSurveyRelatedNews($serviceId)
    {
        
        // Build SQL query
        $sql = 'CALL surveys_get_service_related_news(:service_id)';

		// Build the parameters array
        $params = array(':service_id' => $serviceId);

		// Execute the query
        return DatabaseHandler::GetAll($sql, $params);
    }
    
    public static function RemoveNewFromService($serviceId, $relatedNewId)
    {
		// Build SQL query
        $sql = 'CALL services_remove_new_from_service(:service_id, :related_announcement_id)';
        
        // Build the parameters array
        $params = array(':service_id' => $serviceId,
                        ':related_announcement_id' => $relatedNewId);

		// Execute the query
		DatabaseHandler::Execute($sql, $params);
    }
    
    public static function AddNewToService($serviceId, $relatedNewId)
    {
		// Build SQL query
        $sql = 'CALL services_add_new_to_service(:service_id, :related_announcement_id)';
        
        // Build the parameters array
        $params = array(':service_id' => $serviceId,
                        ':related_announcement_id' => $relatedNewId);

		// Execute the query
		DatabaseHandler::Execute($sql, $params);
    }
        public static function GetCategoryChildren($categoryId = null, $languageId = null)
    {
        // Get current session's languageId if not specified
        if (is_null($languageId))
            $languageId = Language::Get();
        
        // Build SQL query
		$sql = 'CALL surveys_get_category_children(:category_id, :language_id)';
                
        // Build the parameters array
        $params = array(':category_id' => $categoryId, 
            ':language_id' => $languageId);
        
        // Execute the query and return the results
		return DatabaseHandler::GetAll($sql, $params);
    }
    
    public static function SetCategoryChildrenSortingId($id, $sortingId, $isService)
    {
        // Build SQL query
		$sql = 'CALL services_set_category_children_sorting_id(:id, :sorting_id, :is_service)';
                
        // Build the parameters array
        $params = array(':id' => $id, 
            ':sorting_id' => $sortingId,
            ':is_service' => $isService
        );

		// Execute the query and return the results
		DatabaseHandler::Execute($sql, $params);
    }
    
    public static function AddEduApplication($service_id, $status, $name, $surname, $company_position,
            $name_latin, $surname_latin, $phone, $mobile, $email, $vegeterian, $webinar,
            $invoice_name, $invoice_type, $invoice_laek, $invoice_afm, $invoice_doy, $invoice_field,
            $invoice_address, $invoice_postcode, $invoice_city, $invoice_phone, $invoice_fax, $invoice_address, $invoice_postcode, $invoice_city,
            $is_student, $is_certified_company)
    {
        
        // Build SQL query
        $sql = 'CALL services_add_edu_application(:service_id, :status, :name, :surname, :company_position,
                                                  :name_latin, :surname_latin, :phone, :mobile, :email,
                                                  :vegeterian, :webinar, :invoice_name, :invoice_type, :invoice_laek,
                                                  :invoice_afm, :invoice_doy, :invoice_field, :invoice_address,
                                                  :invoice_postcode, :invoice_city, :invoice_phone, :invoice_fax,
                                                  :is_student, :is_certified_company)';

        // Build the parameters array
        $params = array(
            ':service_id'           => $service_id, 
            ':status'               => $status, 
            ':name'                 => $name,
            ':surname'              => $surname,
            ':company_position'     => $company_position,
            ':name_latin'           => $name_latin,
            ':surname_latin'        => $surname_latin,
            ':phone'                => $phone,
            ':mobile'               => $mobile,
            ':email'                => $email,
            ':vegeterian'           => $vegeterian,
            ':webinar'              => $webinar,
            ':invoice_name'         => $invoice_name,
            ':invoice_type'         => $invoice_type,
            ':invoice_laek'         => $invoice_laek,
            ':invoice_afm'          => $invoice_afm,
            ':invoice_doy'          => $invoice_doy,
            ':invoice_field'        => $invoice_field,
            ':invoice_address'      => $invoice_address,
            ':invoice_postcode'     => $invoice_postcode,
            ':invoice_city'         => $invoice_city,
            ':invoice_phone'        => $invoice_phone,
            ':invoice_fax'          => $invoice_fax,
            ':is_student'           => $is_student,
            ':is_certified_company' =>$is_certified_company
        );

        // Execute the query and return the results
	DatabaseHandler::Execute($sql, $params);

    }
    
    // Retrieves all education application forms
    public static function GetEduApplicationForms()
    {
    
    // Build SQL query
    $sql = 'CALL surveys_get_education_application_forms()';
            
    // Build the parameters array
    $params = array();

    // Execute the query and return the results
    return DatabaseHandler::GetAll($sql, $params);
    }
    
    // Retrieves specific education application form
    public static function GetEduApplicationFormDetails($applicationId)
    {
        
    // Build SQL query
    $sql = 'CALL surveys_get_education_application_form_details(:application_id)';
            
    // Build the parameters array
    $params = array(':application_id' => $applicationId); 

    // Execute the query and return the results
    return DatabaseHandler::GetRow($sql, $params);
    }
    
    
    // Retrieves specific education application form
    public static function UpdateEduApplicationFormStatus($applicationId, $status)
    {
        
    // Build SQL query
    $sql = 'CALL services_set_education_application_form_status(:application_id, :status)';
            
    // Build the parameters array
    $params = array(':application_id' => $applicationId,
                    ':status' => $status); 

    // Execute the query and return the results
    DatabaseHandler::Execute($sql, $params);
    }
    
    public static function AddCompanyEduApplication($service_id, $status, $company_name, $company_address, $company_city, $company_afm, $company_doy, $company_responsible, $company_phone, $company_email, $seminar_place, $company_participants, $company_laek, $company_certified)
    {
        
        // Build SQL query
        $sql = 'CALL services_add_company_edu_application(:service_id, :status, :company_name, :company_address, :company_city, :company_afm,
               :company_doy, :company_responsible, :company_phone, :company_email, :seminar_place, :company_participants, :company_laek, :company_certified)';

        // Build the parameters array
        $params = array(
            ':service_id'           => $service_id, 
            ':status'               => $status, 
            ':company_name'         => $company_name,
            ':company_address'      => $company_address,
            ':company_city'         => $company_city,
            ':company_afm'          => $company_afm,
            ':company_doy'          => $company_doy,
            ':company_responsible'  => $company_responsible,
            ':company_phone'        => $company_phone,
            ':company_email'        => $company_email,
            ':seminar_place'        => $seminar_place,
            ':company_participants' => $company_participants,
            ':company_laek'         => $company_laek,
            ':company_certified'    => $company_certified);

        // Execute the query and return the results
	DatabaseHandler::Execute($sql, $params);

    }
    
    public static function GetSurveyRelatedSeminars($serviceId)
    {
        
        // Build SQL query
        $sql = 'CALL surveys_get_education_seminars(:service_id)';

		// Build the parameters array
        $params = array(':service_id' => $serviceId);

		// Execute the query
        return DatabaseHandler::GetAll($sql, $params);
    }
    
    public static function GetSurveyRelatedSeminar($seminarId)
    {
        
        // Build SQL query
        $sql = 'CALL surveys_get_education_seminar(:seminar_id)';

		// Build the parameters array
        $params = array(':seminar_id' => $seminarId);

		// Execute the query
        return DatabaseHandler::GetRow($sql, $params);
    }
    
    public static function AddSeminarToService($serviceId, $seminarCode, $seminarStartDate, $seminarEndDate, $seminarDuration, 
                                               $seminarCity, $seminarIndex, $seminarCost, $seminarDiscount, $seminarRemarks)
    {
	// Build SQL query
        $sql = 'CALL services_add_seminar_to_service(:service_id, :seminar_code, :seminar_sdate, :seminar_edate, :seminar_duration, :seminar_city, :seminar_index, :seminar_cost, :seminar_discount, :seminar_remarks)';
        
        // Build the parameters array
        $params = array(':service_id' => $serviceId,
                        ':seminar_code' => $seminarCode,
                        ':seminar_sdate' => $seminarStartDate,
                        ':seminar_edate' => $seminarEndDate,
                        ':seminar_duration' => $seminarDuration,
                        ':seminar_city' => $seminarCity,
                        ':seminar_index' => $seminarIndex,
                        ':seminar_cost' => $seminarCost,
                        ':seminar_discount' => $seminarDiscount,
                        ':seminar_remarks' => $seminarRemarks
        );

	// Execute the query
	DatabaseHandler::Execute($sql, $params);
    }
    
    public static function RemoveSeminarFromService($seminarId)
    {
	// Build SQL query
        $sql = 'CALL services_delete_seminar(:seminar_id)';
        
        // Build the parameters array
        $params = array(':seminar_id' => $seminarId);

        // Execute the query
        DatabaseHandler::Execute($sql, $params);
    }
    
    public static function UpdateSeminar($seminarId, $seminarCode, $seminarStartDate, $seminarEndDate, $seminarDuration, $seminarCity, $seminarIndex, $seminarCost, $seminarDiscount, $seminarStatus, $seminarRemarks)
    {
	// Build SQL query
        $sql = 'CALL services_update_seminar(:seminar_id, :seminar_code, :seminar_sdate, :seminar_edate, :seminar_duration, :seminar_city, :seminar_index, :seminar_cost,
            :seminar_discount, :seminar_status, :seminar_remarks)';

        
        // Build the parameters array
        $params = array(':seminar_id' => $seminarId,
                        ':seminar_code' => $seminarCode,
                        ':seminar_sdate' => $seminarStartDate,
                        ':seminar_edate' => $seminarEndDate,
                        ':seminar_duration' => $seminarDuration,
                        ':seminar_city' => $seminarCity,
                        ':seminar_index' => $seminarIndex,
                        ':seminar_cost' => $seminarCost,
                        ':seminar_discount' => $seminarDiscount,
                        ':seminar_status' => $seminarStatus,
                        ':seminar_remarks' => $seminarRemarks);

        // Execute the query
        DatabaseHandler::Execute($sql, $params);
    
    }
    
    // Retrieves all education application forms
    public static function GetEduSeminars()
    {
    
    // Build SQL query
    $sql = 'CALL surveys_get_education_seminars()';
            
    // Build the parameters array
    $params = array();

    // Execute the query and return the results
    return DatabaseHandler::GetAll($sql, $params);
    }
    
    public static function GetByFilters($filters, $pageNo = 1, &$rHowManyPages = 1, 
                               $seminarsPerPage = SEMINARS_PER_PAGE_ADMIN)
    {
        if (!is_array($filters)) {
            trigger_error('Filters must be an array');
            exit();
        }

        // Query that returns the number of products in the category
        $sql = 'CALL services_count_seminars_by_filters(:customer_id, :status, :start_date, :end_date)';

        // Build the parameters array
        $params = array(':customer_id' => $filters['customer_id'],
                        ':status' => $filters['status_id'],
                        ':start_date' => $filters['start_date'],
                        ':end_date' => $filters['end_date']);

        if ($rHowManyPages == 1) {
            $seminarsPerPage = DatabaseHandler::GetOne($sql, $params);
        } else {
            // Calculate the number of pages required to display the products
            $rHowManyPages = self::HowManyPages($sql, $params, SEMINARS_PER_PAGE_ADMIN);
        }


        // Calculate the start item
        $start_item = ($pageNo - 1) * $seminarsPerPage;



        // Build the SQL query
        $sql = 'CALL surveys_get_seminars_by_filters(:customer_id, :status, :start_date, 
            :end_date, :sort_by, :seminars_per_page, :start_item)';


        // Build the parameters array
        $params = array(':customer_id' => $filters['customer_id'],
                        ':status' => $filters['status_id'],
                        ':start_date' => $filters['start_date'],
                        ':end_date' => $filters['end_date'],
                        ':sort_by' => (!is_null($filters['sort_by'])) ? $filters['sort_by'] : SEMINARS_SORT_BY_DATE,
                        ':seminars_per_page' => $seminarsPerPage,
                        ':start_item' => $start_item);
        
        // Execute the query and return the results
        return DatabaseHandler::GetAll($sql, $params);
    }
    
    public static function Get($pageNo = 1, &$rHowManyPages = 1, 
                               $seminarsPerPage = SEMINARS_PER_PAGE_ADMIN)
    {
        // Query that returns the number of products in the category
        $sql = 'CALL services_count_seminars()';

        if ($rHowManyPages == 1) {
            $seminarsPerPage = DatabaseHandler::GetOne($sql, null);
        } else {
            // Calculate the number of pages required to display the products
            $rHowManyPages = self::HowManyPages($sql, null, $seminarsPerPage);
        }

        // Calculate the start item
        $start_item = ($pageNo - 1) * $seminarsPerPage;
        
        // Build the SQL query
        $sql = 'CALL surveys_get_seminars(:seminars_per_page, :start_item)';

        // Build the parameters array
        $params = array(':seminars_per_page' => $seminarsPerPage,
            ':start_item' => $start_item);

        // Execute the query and return the results
        return DatabaseHandler::GetAll($sql, $params);
    }

    public static function GetActiveSurveys($languageId = null)
    {
        // Get current session's languageId if not specified
        if (is_null($languageId))
            $languageId = Language::Get();

        // Build SQL query
        $sql = 'CALL surveys_get_active_surveys(:language_id)';

        // Build the parameters array
        $params = array(':language_id' => $languageId);

        // Execute the query and return the results
        return DatabaseHandler::GetAll($sql, $params);
    }

    public static function GetSurveyData($surveyId, $languageId = null)
    {
        // Get current session's languageId if not specified
        if (is_null($languageId))
            $languageId = Language::Get();

        // Build SQL query
        $sql = 'CALL surveys_get_survey_data(:survey_id, :language_id)';

        // Build the parameters array
        $params = array(':survey_id' => $surveyId, ':language_id' => $languageId);

        // Execute the query and return the results
        return DatabaseHandler::GetAll($sql, $params);
    }

    public static function GetCustomerSurveyAnswers($surveyId, $customerEmail)
    {

        // Build SQL query
        $sql = 'CALL surveys_get_customer_survey_answers(:survey_id, :email)';

        // Build the parameters array
        $params = array(':survey_id' => $surveyId, ':email' => $customerEmail);

        // Execute the query and return the results
        return DatabaseHandler::GetAll($sql, $params);
    }

    public static function SubmitSurveyAnswer($customerEmail, $surveyId,
                                              $characteristicId, $positiveAnswer, $negativeAnswer)
    {
        // Build SQL query
        $sql = 'CALL survey_submit_answer(:email, :survey_id, :qid, :pos, :neg, @res)';

        // Build the parameters array
        $params = array(':email' => $customerEmail, ':survey_id' => $surveyId,
            ':qid' => $characteristicId, ':pos' => $positiveAnswer, ':neg' => $negativeAnswer);

        $result = DatabaseHandler::ExecuteSingleOutput($sql, $params);
        return $result;
    }

}
?>
