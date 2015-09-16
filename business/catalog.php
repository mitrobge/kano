<?php

// Database Queries

class Catalog 
{
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
        if (is_null($languageId))
            $languageId = Language::Get();
        
        // Build SQL query
		$sql = 'CALL services_get_categories(:parent_id, :language_id)';
                
        // Build the parameters array
        $params = array(':parent_id' => $parentId, 
            ':language_id' => $languageId);

		// Execute the query and return the results
		return DatabaseHandler::GetAll($sql, $params);
	}

  	/* Calculates how many pages of products could be filled by the
  	   number of products returned by the $countSql query */
	private static function HowManyPages($countSql, $countSqlParams, $itemsPerPage = PRODUCTS_PER_PAGE)
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
        
    public static function GetRecentlyArrivedProducts ($filterParams, $pageNo = 1, &$rHowManyPages = 1, 
        $productsPerPage = PRODUCTS_PER_PAGE, $languageId = null)
    {
        require_once BUSINESS_DIR . 'promotion.php';
        $sql = '';
        $params = array();
        $short_product_description_length = SHORT_PRODUCT_DESCRIPTION_LENGTH;
        $added_after = date('Y-m-d H:i:s', strtotime('-' . Promotion::GetNewArrivalInterval() . ' days'));
        
        /* Filter params */
        $category_id = null;
        $manufacturer_id = null;
        $have_max_price = null;
        $have_attribute_id = null;
        $have_attribute_value = null;
        $attribute_value_words = array();

        /* Get filter Paramaters */
        if (is_array($filterParams) && count($filterParams)) {
            $category_id = (isset($filterParams['category']) && 
                    !empty($filterParams['category'])) ? 
                $filterParams['category'] : null;
            $manufacturer_id = (isset($filterParams['brand']) && 
                    !empty($filterParams['brand'])) ? 
                $filterParams['brand'] : null;
            $have_max_price = (isset($filterParams['maxprice']) && 
                    !empty($filterParams['maxprice'])) ? 
                $filterParams['maxprice'] : null;
            $have_attribute_id = (isset($filterParams['attributename']) && 
                    !empty($filterParams['attributename'])) ? 
                $filterParams['attributename'] : null;
            $have_attribute_value = (isset($filterParams['attributevalue']) && 
                    !empty($filterParams['attributevalue'])) ? 
                $filterParams['attributevalue'] : null;
        
            /* Parse the string of attribute value if exist, and find the search words */
            if (!is_null($have_attribute_value)) {
                // Search string delimeters
                $delimeters = ',.; ';
                $word = strtok ($have_attribute_value, $delimeters);
                // Parse the string word by word until there are no more words
                while ($word) {
                    if (strlen ($word) >= FT_MIN_WORD_LEN)
                        $attribute_value_words[] = $word;
                    // Get the next word of the search string
                    $word = strtok ($delimeters);
                }
                // XXX OR searching for attribute value
                $have_attribute_value = implode (" ", $attribute_value_words);
            }
        }

        // Query to return the number of new arrival products 
        $sql = 'CALL catalog_count_search_results(:search_string, :words_mode, 
            :category_id, :unique_category_id, :manufacturer_id, :have_max_price, 
            :have_attribute_id, :have_attribute_value, :promoted_only, :promotion_type, 
            :added_after)';
        $params = array (':search_string' => null,
                         ':words_mode' => null,
                         ':category_id' => $category_id,
                         ':unique_category_id' => null,
                         ':manufacturer_id' => $manufacturer_id,
                         ':have_max_price' => $have_max_price,
                         ':have_attribute_id' => $have_attribute_id,
                         ':have_attribute_value' => $have_attribute_value,
                         ':promoted_only' => false,
                         ':promotion_type' => null,
                         ':added_after' => $added_after);

        if ($rHowManyPages == 1) {
            $productsPerPage = DatabaseHandler::GetOne($sql, $params);
            $short_product_description_length = FULL_PRODUCT_DESCRIPTION_LENGTH;
        } else {
            // Calculate the number of pages required to display the products
            $rHowManyPages = self::HowManyPages($sql, $params, $productsPerPage);
        }
        
        // Calculate the start item
        $start_item = ($pageNo - 1) * $productsPerPage;

        // Get current session's languageId if not specified
        if (is_null($languageId))
            $languageId = Language::Get();

        // Retrieve the list of products
        $sql = 'CALL catalog_search(:search_string, :words_mode,
                                    :category_id, :unique_category_id, 
                                    :manufacturer_id, :have_max_price, 
                                    :have_attribute_id, :have_attribute_value, 
                                    :promoted_only, :promotion_type, :added_after,
                                    :short_product_description_length, 
                                    :products_per_page, :start_item,
                                    :language_id)';

        $params = array (':search_string' => null,
                         ':words_mode' => null,
                         ':category_id' => $category_id,
                         ':unique_category_id' => null,
                         ':manufacturer_id' => $manufacturer_id,
                         ':have_max_price' => $have_max_price,
                         ':have_attribute_id' => $have_attribute_id,
                         ':have_attribute_value' => $have_attribute_value,
                         ':promoted_only' => false,
                         ':promotion_type' => null,
                         ':added_after' => $added_after,
                         ':short_product_description_length' => $short_product_description_length,
                         ':products_per_page' => $productsPerPage,
                         ':start_item' => $start_item,
                         ':language_id' => $languageId);

		// Execute the query and return the results
		return DatabaseHandler::GetAll($sql, $params);
    }

    public static function GetProducts ($categoryId, $uniqueCategoryId, $storeId, 
                                        $filterParams, $pageNo = 1, &$rHowManyPages = 1, 
                                        $productsPerPage = PRODUCTS_PER_PAGE, 
                                        $languageId = null)
    {
        $sql = '';
        $params = array();
        $short_product_description_length = SHORT_PRODUCT_DESCRIPTION_LENGTH;
        
        /* Filter params */
        $category_id = null;
        $manufacturer_id = null;
        $have_max_price = null;
        $have_attribute_id = null;
        $have_attribute_value = null;
        $attribute_value_words = array();

        /* Get filter Paramaters */
        if (is_array($filterParams) && count($filterParams)) {
            $category_id = (isset($filterParams['category']) && 
                    !empty($filterParams['category'])) ? 
                $filterParams['category'] : null;
            $manufacturer_id = (isset($filterParams['brand']) && 
                    !empty($filterParams['brand'])) ? 
                $filterParams['brand'] : null;
            $have_max_price = (isset($filterParams['maxprice']) && 
                    !empty($filterParams['maxprice'])) ? 
                $filterParams['maxprice'] : null;
            $have_attribute_id = (isset($filterParams['attributename']) && 
                    !empty($filterParams['attributename'])) ? 
                $filterParams['attributename'] : null;
            $have_attribute_value = (isset($filterParams['attributevalue']) && 
                    !empty($filterParams['attributevalue'])) ? 
                $filterParams['attributevalue'] : null;
        
            /* Parse the string of attribute value if exist, and find the search words */
            if (!is_null($have_attribute_value)) {
                // Search string delimeters
                $delimeters = ',.; ';
                $word = strtok ($have_attribute_value, $delimeters);
                // Parse the string word by word until there are no more words
                while ($word) {
                    if (strlen ($word) >= FT_MIN_WORD_LEN)
                        $attribute_value_words[] = $word;
                    // Get the next word of the search string
                    $word = strtok ($delimeters);
                }
                // XXX OR searching for attribute value
                $have_attribute_value = implode (" ", $attribute_value_words);
            }
        }

        /* Filtering by category here is not supported yet */
        if (!is_null($category_id)) {
            trigger_error('Filter by category in Catalog::GetProducts(). Not Supported.');
            exit(0);
        }

        if ((!is_null($categoryId) || !is_null($uniqueCategoryId)) && is_null($storeId)) {
            // Query that returns the number of products in the category
            $sql = 'CALL catalog_count_products_in_category(:category_id, :unique_category_id, 
                :manufacturer_id, :have_max_price, :have_attribute_id, :have_attribute_value)';

            // Build the parameters array
            $params = array(':category_id' => $categoryId,
                ':unique_category_id' => $uniqueCategoryId,
                ':manufacturer_id' => $manufacturer_id,
                ':have_max_price' => $have_max_price,
                ':have_attribute_id' => $have_attribute_id,
                ':have_attribute_value' => $have_attribute_value);
        } else if (is_null($categoryId) && !is_null($storeId)) {
            // Query that returns the number of products in the store
            $sql = 'CALL catalog_count_products_in_store(:store_id)';

            // Build the parameters array
            $params = array(':store_id' => $storeId);
        }

        if ($rHowManyPages == 1) {
            $productsPerPage = DatabaseHandler::GetOne($sql, $params);
            $short_product_description_length = FULL_PRODUCT_DESCRIPTION_LENGTH;
        } else {
            // Calculate the number of pages required to display the products
            $rHowManyPages = self::HowManyPages($sql, $params, $productsPerPage);
        }
        
        // Calculate the start item
        $start_item = ($pageNo - 1) * $productsPerPage;

        // Get current session's languageId if not specified
        if (is_null($languageId))
            $languageId = Language::Get();

        if ((!is_null($categoryId) || !is_null($uniqueCategoryId)) && is_null($storeId)) {
            // Retrieve the list of products
            $sql = 'CALL catalog_get_products_in_category(:category_id,
                :unique_category_id, :manufacturer_id, :have_max_price, 
                :have_attribute_id, :have_attribute_value, 
                :short_product_description_length, 
                :products_per_page, :start_item, 
                :language_id)';

            // Build the parameters array
            $params = array(':category_id' => $categoryId,
                ':unique_category_id' => $uniqueCategoryId,
                ':manufacturer_id' => $manufacturer_id,
                ':have_max_price' => $have_max_price,
                ':have_attribute_id' => $have_attribute_id,
                ':have_attribute_value' => $have_attribute_value,
                ':short_product_description_length' => $short_product_description_length,
                ':products_per_page' => $productsPerPage,
                ':start_item' => $start_item,
                ':language_id' => $languageId);
        } else if (is_null($categoryId) && !is_null($storeId)) {
            // Retrieve the list of products
            $sql = 'CALL catalog_get_products_in_store(:store_id, 
                :short_product_description_length, 
                :products_per_page, 
                :start_item, 
                :language_id)';

            // Build the parameters array
            $params = array(':store_id' => $storeId,
                ':short_product_description_length' => $short_product_description_length,
                ':products_per_page' => $productsPerPage,
                ':start_item' => $start_item,
                ':language_id' => $languageId);
        }

		// Execute the query and return the results
		return DatabaseHandler::GetAll($sql, $params);
    }

	public static function GetProductDetails ($productId, $optionsIds = null, $languageId = null)
	{
        // Get current session's languageId if not specified
        if (is_null($languageId))
            $languageId = Language::Get();
        
        // Build SQL query
		$sql = 'CALL catalog_get_product_details(:product_id, :product_options_ids, :language_id)';

		// Build the parameters array
        $params = array(':product_id' => $productId, 
            ':product_options_ids' => $optionsIds,
            ':language_id' => $languageId);

		// Execute the query and return the results
		return DatabaseHandler::GetRow($sql, $params);
	}

	public static function GetProductsPromoted($promotionType = null, $filterParams = null, $pageNo = 1, &$rHowManyPages = 1, $languageId = null)
    {
        $productsPerPage = PRODUCTS_PER_PAGE;
        $short_product_description_length = SHORT_PRODUCT_DESCRIPTION_LENGTH;
        
        /* Filter params */
        $category_id = null;
        $manufacturer_id = null;
        $have_max_price = null;
        $have_attribute_id = null;
        $have_attribute_value = null;
        $attribute_value_words = array();

        /* Get filter Paramaters */
        if (is_array($filterParams) && count($filterParams)) {
            $category_id = (isset($filterParams['category']) && 
                    !empty($filterParams['category'])) ? 
                $filterParams['category'] : null;
            $manufacturer_id = (isset($filterParams['brand']) && 
                    !empty($filterParams['brand'])) ? 
                $filterParams['brand'] : null;
            $have_max_price = (isset($filterParams['maxprice']) && 
                    !empty($filterParams['maxprice'])) ? 
                $filterParams['maxprice'] : null;
            $have_attribute_id = (isset($filterParams['attributename']) && 
                    !empty($filterParams['attributename'])) ? 
                $filterParams['attributename'] : null;
            $have_attribute_value = (isset($filterParams['attributevalue']) && 
                    !empty($filterParams['attributevalue'])) ? 
                $filterParams['attributevalue'] : null;
        
            /* Parse the string of attribute value if exist, and find the search words */
            if (!is_null($have_attribute_value)) {
                // Search string delimeters
                $delimeters = ',.; ';
                $word = strtok ($have_attribute_value, $delimeters);
                // Parse the string word by word until there are no more words
                while ($word) {
                    if (strlen ($word) >= FT_MIN_WORD_LEN)
                        $attribute_value_words[] = $word;
                    // Get the next word of the search string
                    $word = strtok ($delimeters);
                }
                // XXX OR searching for attribute value
                $have_attribute_value = implode (" ", $attribute_value_words);
            }
        }

        // Query that returns the number of products in the category
        $sql = 'CALL catalog_count_promoted_products(:category_id, :manufacturer_id, 
            :have_max_price, :have_attribute_id, :have_attribute_value, :promotion_type)';

        // Build the parameters array
        $params = array(':category_id' => $category_id,
            ':manufacturer_id' => $manufacturer_id,
            ':have_max_price' => $have_max_price,
            ':have_attribute_id' => $have_attribute_id,
            ':have_attribute_value' => $have_attribute_value,
            ':promotion_type' => $promotionType);

        if ($rHowManyPages == 1) {
            $productsPerPage = DatabaseHandler::GetOne($sql, $params);
            $short_product_description_length = FULL_PRODUCT_DESCRIPTION_LENGTH;
        } else {
            // Calculate the number of pages required to display the products
            $rHowManyPages = self::HowManyPages($sql, $params, $productsPerPage);
        }
        
        // Calculate the start item
        $start_item = ($pageNo - 1) * $productsPerPage;

        // Get current session's languageId if not specified
        if (is_null($languageId))
            $languageId = Language::Get();

        // Retrieve the list of products
        $sql = 'CALL catalog_get_promoted_products(:category_id,
            :manufacturer_id, :have_max_price, 
            :have_attribute_id, :have_attribute_value,
            :promotion_type, :short_product_description_length, 
            :products_per_page, 
            :start_item, 
            :language_id)';

        // Build the parameters array
        $params = array(':category_id' => $category_id,
            ':manufacturer_id' => $manufacturer_id,
            ':have_max_price' => $have_max_price,
            ':have_attribute_id' => $have_attribute_id,
            ':have_attribute_value' => $have_attribute_value,
            ':promotion_type' => $promotionType,
            ':short_product_description_length' => $short_product_description_length,
            ':products_per_page' => $productsPerPage,
            ':start_item' => $start_item,
            ':language_id' => $languageId);

		// Execute the query and return the results
		return DatabaseHandler::GetAll($sql, $params);
	}

	public static function GetProductAttributes($productId, $languageId = null)
	{
        // Get current session's languageId if not specified
        if (is_null($languageId))
            $languageId = Language::Get();
        
        // Build SQL query
		$sql = 'CALL catalog_get_product_attributes(:product_id, :language_id)';

		// Build the parameters array
        $params = array(':product_id' => $productId,
            ':language_id' => $languageId);

		// Execute the query and return the results
		return DatabaseHandler::GetAll($sql, $params);
	}
    
    public static function GetProductAttributesAllLanguages($productId, $languageId = null)
	{
        // Get current session's languageId if not specified
        if (is_null($languageId))
            $languageId = Language::Get();
        
        // Build SQL query
        $sql = 'CALL catalog_get_product_attributes_all_languages(
            :product_id, :language_id)';

		// Build the parameters array
        $params = array(':product_id' => $productId,
            ':language_id' => $languageId);

		// Execute the query and return the results
		return DatabaseHandler::GetAll($sql, $params);
	}

        public static function GetProductResources($productId, $resourceType = null)
        {
            // Build SQL query
            $sql = 'CALL catalog_get_product_resources(:product_id, :resource_type)';

            // Build the parameters array
            $params = array(':product_id' => $productId,
                ':resource_type' => $resourceType);

            // Execute the query and return the results
            return DatabaseHandler::GetAll($sql, $params);
        }

    public static function GetCategoryAttributes($categoryId, $languageId = null)
    {
        // Get current session's languageId if not specified
        if (is_null($languageId))
            $languageId = Language::Get();
        
        // Build SQL query
		$sql = 'CALL catalog_get_category_attributes(:category_id, :language_id)';
        
        // Build the parameters array
        $params = array(':category_id' => $categoryId,
            ':language_id' => $languageId);

		// Execute the query and return the results
		return DatabaseHandler::GetAll($sql, $params);
    }
    
    public static function GetCategoryOptions($categoryId, $languageId = null)
    {
        // Get current session's languageId if not specified
        if (is_null($languageId))
            $languageId = Language::Get();
        
        // Build SQL query
		$sql = 'CALL catalog_get_category_options(:category_id, :language_id)';
        
        // Build the parameters array
        $params = array(':category_id' => $categoryId,
            ':language_id' => $languageId);

		// Execute the query and return the results
		return DatabaseHandler::GetAll($sql, $params);
    }

    public static function GetAttributesNotInCategory($categoryId, $languageId = null)
    {
        // Get current session's languageId if not specified
        if (is_null($languageId))
            $languageId = Language::Get();
        
		// Build SQL query
        $sql = 'CALL catalog_get_attributes_not_in_category(
            :category_id, :language_id)';
        
        // Build the parameters array
        $params = array(':category_id' => $categoryId,
            ':language_id' => $languageId);

		// Execute the query and return the results
		return DatabaseHandler::GetAll($sql, $params);
    }
    
    public static function GetOptionsNotInCategory($categoryId, $languageId = null)
    {
        // Get current session's languageId if not specified
        if (is_null($languageId))
            $languageId = Language::Get();
        
		// Build SQL query
        $sql = 'CALL catalog_get_options_not_in_category(
            :category_id, :language_id)';
        
        // Build the parameters array
        $params = array(':category_id' => $categoryId,
            ':language_id' => $languageId);

		// Execute the query and return the results
		return DatabaseHandler::GetAll($sql, $params);
    }

	public static function GetProductName($productId, $languageId = null)
    {
        // Get current session's languageId if not specified
        if (is_null($languageId))
            $languageId = Language::Get();

		// Build SQL query
		$sql = 'CALL catalog_get_product_name(:product_id, :language_id)';

		// Build the parameters array
		$params = array(':product_id' => $productId, ':language_id' => $languageId);

		// Execute the query and return the results
		return DatabaseHandler::GetOne($sql, $params);
	}
    
    public static function GetProductIntroduction($productId, $languageId = null)
    {
        // Get current session's languageId if not specified
        if (is_null($languageId))
            $languageId = Language::Get();

		// Build SQL query
		$sql = 'CALL catalog_get_product_introduction(:product_id, :language_id)';

		// Build the parameters array
		$params = array(':product_id' => $productId, ':language_id' => $languageId);

		// Execute the query and return the results
		return DatabaseHandler::GetOne($sql, $params);
    }

    public static function GetProductDescription($productId, $languageId = null)
    {
        // Get current session's languageId if not specified
        if (is_null($languageId))
            $languageId = Language::Get();

		// Build SQL query
		$sql = 'CALL catalog_get_product_description(:product_id, :language_id)';

		// Build the parameters array
		$params = array(':product_id' => $productId, ':language_id' => $languageId);

		// Execute the query and return the results
		return DatabaseHandler::GetOne($sql, $params);
	}
    
    public static function GetProductComments($productId, $languageId = null)
    {
        // Get current session's languageId if not specified
        if (is_null($languageId))
            $languageId = Language::Get();

		// Build SQL query
		$sql = 'CALL catalog_get_product_comments(:product_id, :language_id)';

		// Build the parameters array
		$params = array(':product_id' => $productId, ':language_id' => $languageId);

		// Execute the query and return the results
		return DatabaseHandler::GetOne($sql, $params);
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
    
    public static function GetAttributeName($attributeId, $languageId = null)
	{
        // Get current session's languageId if not specified
        if (is_null($languageId))
            $languageId = Language::Get();
        
        // Build SQL query
		$sql = 'CALL catalog_get_attribute_name(:attribute_id, :language_id)';

		// Build the parameters array
        $params = array(':attribute_id' => $attributeId, 
            ':language_id' => $languageId);

		// Execute the query and return the results
		return DatabaseHandler::GetOne($sql, $params);
    }
    
    public static function GetOptionName($optionId, $languageId = null)
	{
        // Get current session's languageId if not specified
        if (is_null($languageId))
            $languageId = Language::Get();
        
        // Build SQL query
		$sql = 'CALL catalog_get_option_name(:option_id, :language_id)';

		// Build the parameters array
        $params = array(':option_id' => $optionId, 
            ':language_id' => $languageId);

		// Execute the query and return the results
		return DatabaseHandler::GetOne($sql, $params);
    }

    public static function Search($searchParams, $pageNo, &$rHowManyPages, $productsPerPage = PRODUCTS_PER_PAGE)
    {
        $search_string = null;
        $is_advanced_search = false;
        $attribute_value_words = array();

        /* Get advanced Paramaters */
        $in_category_id = (isset($searchParams['in_category_id']) && 
                !empty($searchParams['in_category_id'])) ? 
            $searchParams['in_category_id'] : null;
        $is_manufacturer_id = (isset($searchParams['is_manufacturer_id']) && 
                !empty($searchParams['is_manufacturer_id'])) ? 
            $searchParams['is_manufacturer_id'] : null;
        $has_max_price = (isset($searchParams['has_max_price']) && 
                !empty($searchParams['has_max_price'])) ? 
            $searchParams['has_max_price'] : null;
        $has_attribute_id = (isset($searchParams['has_attribute_id']) && 
                !empty($searchParams['has_attribute_id'])) ? 
            $searchParams['has_attribute_id'] : null;
        $has_attribute_value = (isset($searchParams['has_attribute_value']) && 
                !empty($searchParams['has_attribute_value'])) ? 
            $searchParams['has_attribute_value'] : null;

        if (!is_null($in_category_id) || !is_null($is_manufacturer_id) ||
                !is_null($has_max_price) || !is_null($has_attribute_id) || 
                !is_null($has_attribute_value))
            $is_advanced_search = true;
        
        // The search result will be an array of this form
        $search_result = array ('original_phrase' => $searchParams['search_string'],
                                'accepted_words' => array(),
                                'ignored_words' => array(),
                                'products' => array());

        
        // Return void if the search string is void and we are in basic search
        if (is_null($in_category_id) && is_null($is_manufacturer_id) &&
                is_null($has_max_price) && is_null($has_attribute_id) && 
                is_null($has_attribute_value) && empty($searchParams['search_string']))
            return $search_result;

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

        // Parse the string of attribute value if exist, and find the search words
        if (!is_null($has_attribute_value)) {
            $word = strtok ($has_attribute_value, $delimeters);
            // Parse the string word by word until there are no more words
            while ($word) {
                if (strlen ($word) >= FT_MIN_WORD_LEN)
                    $attribute_value_words[] = $word;
                // Get the next word of the search string
                $word = strtok ($delimeters);
            }
            // XXX OR searching for attribute value
            $has_attribute_value = implode (" ", $attribute_value_words);
        }

        // If there aren't any accepted words and we are in basic search return the empty $search_result
        if (count($search_result['accepted_words']) == 0 && !$is_advanced_search)
            return $search_result;

        // If word mode is 'all' then we append a ' +' to each word
        if (!empty($searchParams['search_string'])) {
            if (!strcmp ($searchParams['words'], "all")) {
                $search_string = implode (" +", $search_result['accepted_words']);
                $search_string = "+" . $search_string;
            } else if (!strcmp ($searchParams['words'], "exact")) 
                $search_string = '"' . $searchParams['search_string'] . '"';
            else 
                $search_string = implode (" ", $search_result['accepted_words']);
        }

        // Count the search results
        $sql = 'CALL catalog_count_search_results(:search_string, :words_mode, 
            :category_id, :unique_category_id, :manufacturer_id, :max_price, 
            :attribute_id, :attribute_value, :promoted_only, :promotion_type, 
            :added_after)';
        $params = array (':search_string' => $search_string,
                         ':words_mode' => $searchParams['words'],
                         ':category_id' => $in_category_id,
                         ':unique_category_id' => null,
                         ':manufacturer_id' => $is_manufacturer_id,
                         ':max_price' => $has_max_price,
                         ':attribute_id' => $has_attribute_id,
                         ':attribute_value' => $has_attribute_value,
                         ':promoted_only' => false,
                         ':promotion_type' => null,
                         ':added_after' => null);

        $rHowManyPages = Catalog::HowManyPages($sql, $params, $productsPerPage);

        $start_item = ($pageNo - 1) * $productsPerPage;

        // Get the results from db
        $sql = 'CALL catalog_search(:search_string, :words_mode,
                                    :category_id, :unique_category_id, 
                                    :manufacturer_id, :max_price, 
                                    :attribute_id, :attribute_value,
                                    :promoted_only, :promotion_type, 
                                    :added_after, :short_product_description_length, 
                                    :products_per_page, :start_item, :language_id)';

        $params = array (':search_string' => $search_string,
                         ':words_mode' => $searchParams['words'],
                         ':category_id' => $in_category_id,
                         ':unique_category_id' => null,
                         ':manufacturer_id' => $is_manufacturer_id,
                         ':max_price' => $has_max_price,
                         ':attribute_id' => $has_attribute_id,
                         ':attribute_value' => $has_attribute_value,
                         ':promoted_only' => false,
                         ':promotion_type' => null,
                         ':added_after' => null,
                         ':short_product_description_length' => SHORT_PRODUCT_DESCRIPTION_LENGTH,
                         ':products_per_page' => $productsPerPage,
                         ':start_item' => $start_item,
                         ':language_id' => null);

        $search_result['products'] = DatabaseHandler::GetAll($sql, $params);

        return $search_result;
    }

    public static function AddCategory($parentId = null, $isSpare = false, $isGroup = false)
    {
        // Build SQL query
        $sql = 'CALL catalog_add_category(:parent_id, :is_spare, :is_group)';

        // Build the parameters array
        $params = array(':parent_id' => $parentId,
                        ':is_spare'  => $isSpare,
                        ':is_group'  => $isGroup);
        
        // Execute the query
        return DatabaseHandler::GetOne($sql, $params);
    }
    
    public static function UpdateCategory($categoryId, $categoryName, $categoryDescription, $languageId)
    {
		// Build SQL query
        $sql = 'CALL surveys_update_category(:category_id, 
                                            :category_name,
                                            :category_description,
                                            :language_id)';

		// Build the parameters array
        $params = array(':category_id' => $categoryId, 
            ':category_name' => $categoryName,
            ':category_description' => $categoryDescription,
            ':language_id' => $languageId);

		// Execute the query
		DatabaseHandler::Execute($sql, $params);
    }
    

    public static function SetCategoryName($categoryId, $categoryName, $languageId)
    {
		// Build SQL query
        $sql = 'CALL catalog_set_category_name(:category_id, 
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
        $sql = 'CALL catalog_set_category_image(:category_id, :image_name)';
        
        // Build the parameters array
        $params = array(':category_id' => $categoryId,
                        ':image_name' => $imageName);

		// Execute the query
		DatabaseHandler::Execute($sql, $params);
    }
    
    public static function AddCategoryAttribute($categoryId)
    {
		// Build SQL query
        $sql = 'CALL catalog_add_category_attribute(:category_id)';

		// Build the parameters array
        $params = array(':category_id' => $categoryId);

		// Execute the query
		return DatabaseHandler::GetOne($sql, $params);
    }
    
    public static function AssignAttributeToCategory($categoryId, $attributeId)
    {
		// Build SQL query
        $sql = 'CALL catalog_assign_attribute_to_category(
            :category_id, :attribute_id)';

		// Build the parameters array
        $params = array(':category_id' => $categoryId,
                        ':attribute_id' => $attributeId);

		// Execute the query
		DatabaseHandler::Execute($sql, $params);
    }
    
    public static function UpdateCategoryAttribute($attributeId, $attributeName, $languageId)
    {
		// Build SQL query
        $sql = 'CALL catalog_update_category_attribute(:attribute_id, 
            :attribute_name, :language_id)';

		// Build the parameters array
        $params = array(':attribute_id' => $attributeId, 
                        ':attribute_name' => $attributeName,
                        ':language_id' => $languageId);

		// Execute the query
		DatabaseHandler::Execute($sql, $params);
    }
    
    public static function DeleteCategoryAttribute($categoryId, $attributeId)
    {
		// Build SQL query
        $sql = 'CALL catalog_delete_category_attribute(:category_id, :attribute_id)';

		// Build the parameters array
        $params = array(':category_id' => $categoryId,
                        ':attribute_id' => $attributeId);

		// Execute the query
		DatabaseHandler::Execute($sql, $params);
    }
    
    public static function AddCategoryOption($categoryId)
    {
		// Build SQL query
        $sql = 'CALL catalog_add_category_option(:category_id)';

		// Build the parameters array
        $params = array(':category_id' => $categoryId);

		// Execute the query
		return DatabaseHandler::GetOne($sql, $params);
    }
    
    public static function AssignOptionToCategory($categoryId, $optionId)
    {
		// Build SQL query
        $sql = 'CALL catalog_assign_option_to_category(
            :category_id, :option_id)';

		// Build the parameters array
        $params = array(':category_id' => $categoryId,
                        ':option_id' => $optionId);

		// Execute the query
		DatabaseHandler::Execute($sql, $params);
    }
    
    public static function UpdateCategoryOption($optionId, $optionName, $languageId)
    {
		// Build SQL query
        $sql = 'CALL catalog_update_category_option(:option_id, 
            :option_name, :language_id)';

		// Build the parameters array
        $params = array(':option_id' => $optionId, 
                        ':option_name' => $optionName,
                        ':language_id' => $languageId);

		// Execute the query
		DatabaseHandler::Execute($sql, $params);
    }
    
    public static function DeleteCategoryOption($categoryId, $optionId)
    {
		// Build SQL query
        $sql = 'CALL catalog_delete_category_option(:category_id, :option_id)';

		// Build the parameters array
        $params = array(':category_id' => $categoryId,
                        ':option_id' => $optionId);

		// Execute the query
		return DatabaseHandler::GetOne($sql, $params);
    }

    public static function AddProduct($storeId, $categoryId, $uniqueCategoryId, $erpCode, $manufacturerId, $productPrice, $isBulky, $createdOn)
    {
		// Build SQL query
        $sql = 'CALL catalog_add_product(:store_id, :category_id, :unique_category_id, :erp_code, :manufacturer_id, :product_price, :isbulky, :created_on)';

		// Build the parameters array
        $params = array(':store_id' => $storeId,
                        ':category_id' => $categoryId,
                        ':unique_category_id' => $uniqueCategoryId,
                        ':erp_code' => empty($erpCode) ? null : $erpCode,
                        ':manufacturer_id' => empty($manufacturerId) ? null : $manufacturerId,
                        ':product_price' => $productPrice,
                        ':isbulky' => $isBulky,
                        ':created_on' => $createdOn);

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

    public static function GetProductByERPCode($erpCode, $languageId = null)
    {
        // Get current session's languageId if not specified
        if (is_null($languageId))
            $languageId = Language::Get();
        
        // Build SQL query
        $sql = 'CALL catalog_get_product_by_erpcode(
                    :erp_code, :language_id)';

		// Build the parameters array
        $params = array(':erp_code' => $erpCode, 
                        ':language_id' => $languageId);

		// Execute the query and return the results
		return DatabaseHandler::GetRow($sql, $params);
    }

    public static function IsValidERPCodeForProduct($erpCode, $productId = null)
    {
        $product = self::GetProductByERPCode($erpCode);
        
        if (empty($product))
            return false;
        else if (!is_null($productId)) {
            if ($product['product_id'] == $productId)
                return false;
        }

        return true;
    }
    
    public static function UpdateProductInfo($productId, $erpCode, $uniqueCategoryId, $manufacturerId, $quantity, 
                                                $productPrice, $productDiscountPrice, $isBulky, $createdOn)
    {
		// Build SQL query
        $sql = 'CALL catalog_update_product_info(:product_id, :erp_code, :unique_category_id, :manufacturer_id, :product_quantity,  
                                                    :product_price, :product_discount_price, :isbulky, :created_on)';
		// Build the parameters array
        $params = array(':product_id' => $productId,
                        ':erp_code' => empty($erpCode) ? null : $erpCode,
                        ':unique_category_id' => $uniqueCategoryId,
                        ':manufacturer_id' => $manufacturerId,
                        ':product_quantity' => $quantity, 
                        ':product_price' => $productPrice, 
                        ':product_price' => $productPrice, 
                        ':product_discount_price' => $productDiscountPrice,
                        ':isbulky' => $isBulky,
                        ':created_on' => $createdOn);

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

    public static function SetProductName($productId, $productName, 
       $productIntroduction, $productDescription, $productComments, $languageId)
    {
		// Build SQL query
        $sql = 'CALL catalog_set_product_name(:product_id, :product_name, 
            :product_introduction, :product_description, :product_comments, :language_id)';
        
        // Build the parameters array
        $params = array(':product_id' => $productId,
            ':product_name' => $productName,
            ':product_introduction' => $productIntroduction,
            ':product_description' => $productDescription,
            ':product_comments' => $productComments,
            ':language_id' => $languageId);

		// Execute the query
		DatabaseHandler::Execute($sql, $params);
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
    
    public static function RemoveProductResource($resourceId)
    {
		// Build SQL query
        $sql = 'CALL catalog_remove_product_resource(:resource_id)';
        
        // Build the parameters array
        $params = array(':resource_id' => $resourceId);

		// Execute the query
		DatabaseHandler::Execute($sql, $params);
    }

    public static function GetProductOptions($productId, $languageId = null)
    {
        // Get current session's languageId if not specified
        if (is_null($languageId))
            $languageId = Language::Get();
        
        // Build SQL query
        $sql = 'CALL catalog_get_product_options(:product_id, :language_id)';
        
        // Build the parameters array
        $params = array(':product_id' => $productId,
            ':language_id' => $languageId);

		// Execute the query
        return DatabaseHandler::GetAll($sql, $params);
    }
    
    public static function GetProductOptionsAllLanguages($productId, $languageId = null)
    {
        // Get current session's languageId if not specified
        if (is_null($languageId))
            $languageId = Language::Get();
        
        // Build SQL query
        $sql = 'CALL catalog_get_product_options_all_languages(
            :product_id, :language_id)';
        
        // Build the parameters array
        $params = array(':product_id' => $productId,
            ':language_id' => $languageId);

		// Execute the query
        return DatabaseHandler::GetAll($sql, $params);
    }
    
    public static function GetProductCategoriesOptions($productId, $languageId = null)
    {
        // Get current session's languageId if not specified
        if (is_null($languageId))
            $languageId = Language::Get();
        
        // Build SQL query
        $sql = 'CALL catalog_get_product_categories_options(
            :product_id, :language_id)';
        
        // Build the parameters array
        $params = array(':product_id' => $productId,
            ':language_id' => $languageId);

		// Execute the query
        return DatabaseHandler::GetAll($sql, $params);
    }
    
    public static function UpdateProductOption($productOptionId, $optionValue, $languageId)
    {
		// Build SQL query
        $sql = 'CALL catalog_update_product_option(:product_option_id, 
            :language_id, :option_value)';

		// Build the parameters array
        $params = array(':product_option_id' => $productOptionId,
                        ':language_id' => $languageId,
                        ':option_value' => $optionValue);

		// Execute the query
		DatabaseHandler::Execute($sql, $params);
    }
    
    public static function AddProductOption($productId, $optionId, $optionValues)
    {
		// Build SQL queries
        $sql1 = 'CALL catalog_check_product_option_value(:product_id, :option_id, 
            :language_id, :option_value)';
        $sql2 = 'CALL catalog_add_product_option(:product_id, :option_id)';
        $sql3 = 'CALL catalog_set_product_option_value(:product_option_id, 
                                                :language_id, :option_value)';
        foreach ($optionValues as $languageId => $optionValue) 
        {
            // Check the existence of this option value
            $params1 = array(':product_id' => $productId,
                ':option_id' => $optionId, 
                ':language_id' => $languageId, 
                ':option_value' => $optionValue);
            if (DatabaseHandler::GetOne($sql1, $params1) != null)
                return -1;
        }
        // Add new option
        $params2 = array(':product_id' => $productId,
                        ':option_id' => $optionId);
        $productOptionId = DatabaseHandler::GetOne($sql2, $params2);

        foreach ($optionValues as $languageId => $optionValue) 
        {
            // Set new option's value
            $params3 = array(':product_option_id' => $productOptionId,
                ':language_id' => $languageId, 
                ':option_value' => $optionValue);
            DatabaseHandler::Execute($sql3, $params3);
        }
        return 0;
    }
    
    public static function DeleteProductOption($productOptionId)
    {
		// Build SQL query
        $sql = 'CALL catalog_delete_product_option(:product_option_id)';

		// Build the parameters array
        $params = array(':product_option_id' => $productOptionId);

		// Execute the query
		return DatabaseHandler::GetOne($sql, $params);
    }

    public static function GetProductSpareItems($productId)
    {
		// Build SQL query
        $sql = 'CALL catalog_get_product_spareitems(:product_id)';
        
        // Build the parameters array
        $params = array(':product_id' => $productId);
        
        // Execute the query
		return DatabaseHandler::GetAll($sql, $params);
    }
    
    public static function GetProductUnassignedSpareItems($productId)
    {
        // Build SQL query
        $sql = 'CALL catalog_get_product_unassigned_spareitems(:product_id)';
        
        // Build the parameters array
        $params = array(':product_id' => $productId);
        
        // Execute the query
        return DatabaseHandler::GetAll($sql, $params);
    }
    
    public static function AssignProductSpareItem($productId, $spareItemId)
    {
		// Build SQL query
        $sql = 'CALL catalog_assign_product_spareitem(:product_id, :spare_item_id)';

		// Build the parameters array
        $params = array(':product_id' => $productId,
                        ':spare_item_id' => $spareItemId);

		// Execute the query
		DatabaseHandler::Execute($sql, $params);
    }
    
    public static function DeleteProductSpareItem($spareItemId, $productId)
    {
        // Build SQL query
        $sql = 'CALL catalog_delete_product_spareitem(:spare_product_id, :product_id)';
		// Build the parameters array
        $params = array(':spare_product_id' => $spareItemId,
                        ':product_id'=> $productId );

		// Execute the query
		DatabaseHandler::Execute($sql, $params);
    }
    
    public static function GetAllSpareProducts($languageId = null)
    {
        // Get current session's languageId if not specified
        if (is_null($languageId))
            $languageId = Language::Get();
        
        // Build SQL query
        $sql = 'CALL catalog_get_spareitems(:language_id)';

        // Build the parameters array
        $params = array(':language_id' => $languageId);

        // Execute the query
        return DatabaseHandler::GetAll($sql, $params);
    }
    
    public static function AssignSpareItemToGroupsetProduct($productId, $spareItemId)
    {                                               
        // Build SQL query
        $sql = 'CALL catalog_assign_spareitem_to_groupset_product(:product_id, :spare_item_id)';
        
        // Build the parameters array
        $params = array(':product_id' => $productId,
                        ':spare_item_id' => $spareItemId);

		// Execute the query
		DatabaseHandler::Execute($sql, $params);
    }

    public static function GetGroupsetProductSpareItems($productId, $languageId = null)
    {                                               
        // Get current session's languageId if not specified
        if (is_null($languageId))
            $languageId = Language::Get();
        
        // Build SQL query
        $sql = 'CALL catalog_get_groupset_product_spareitems(:product_id, :language_id)';
        
        // Build the parameters array
        $params = array(':product_id' => $productId, 
                        ':language_id' => $languageId);

        // Execute the query
        return DatabaseHandler::GetAll($sql, $params);
    }
    
    public static function RemoveProductGroupItem($groupItemId, $productId)
    {
        // Build SQL query
        $sql = 'CALL catalog_remove_product_groupitem(:spare_product_id, :product_id)';
		// Build the parameters array
        $params = array(':spare_product_id' => $groupItemId, //XXX to rename :spare_product_id to groupped_product_id
                        ':product_id'=> $productId );
        
        DatabaseHandler::Execute($sql, $params);
    }
    
    public static function CheckCategoryName($parentId, $categoryId, $categoryName, $languageId)
    {
        // Build SQL query
        $sql = 'CALL surveys_check_category_name(:parent_id, :category_id, 
                    :category_name, :language_id)';
		// Build the parameters array
        $params = array(':parent_id' => $parentId, 
                        ':category_id' => $categoryId,
                        ':category_name' => $categoryName,
                        ':language_id' => $languageId);

		// Execute the query
        return DatabaseHandler::GetOne($sql, $params);
    }
    
    public static function CheckAttributeName($attributeId, $attributeName, $languageId)
    {
        // Build SQL query
        $sql = 'CALL catalog_check_attribute_name(:attribute_id, :attribute_name, :language_id)';
		// Build the parameters array
        $params = array(':attribute_id' => $attributeId,
                        ':attribute_name' => $attributeName,
                        ':language_id' => $languageId);

		// Execute the query
        return DatabaseHandler::GetOne($sql, $params);
    }
    
    public static function CheckOptionName($optionId, $optionName, $languageId)
    {
        // Build SQL query
        $sql = 'CALL catalog_check_option_name(:option_id, :option_name, :language_id)';
		// Build the parameters array
        $params = array(':option_id' => $optionId,
                        ':option_name' => $optionName,
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
    
    public static function GetSpareCategoriesTree($languageId = null)
    {
        // Get current session's languageId if not specified
        if (is_null($languageId))
            $languageId = Language::Get();
        
        // Build SQL query
        $sql = 'CALL catalog_get_spare_categories_tree(:language_id)';
        
        // Build the parameters array
        $params = array(':language_id' => $languageId);
        
        // Execute the query
        return DatabaseHandler::GetAll($sql, $params);
    }
    
    public static function GetAvailableAttributes($languageId = null)
    {
        // Get current session's languageId if not specified
        if (is_null($languageId))
            $languageId = Language::Get();
        
        // Build SQL query
        $sql = 'CALL catalog_get_available_attributes(:language_id)';
        
        // Build the parameters array
        $params = array(':language_id' => $languageId);
        
        // Execute the query
        return DatabaseHandler::GetAll($sql, $params);
    }
    
    public static function GetCategoryManufacturers($categoryId = null)
    {
        // Build SQL query
        $sql = 'CALL catalog_get_category_manufacturers(:category_id)';
        
        // Build the parameters array
        $params = array(':category_id' => $categoryId);
        
        // Execute the query
        return DatabaseHandler::GetAll($sql, $params);
    }
    
    /* Create the order for a single product */
    public static function ProductCreateOrder($productId, $productOptionsIds, $customerGender, 
        $customerName, $customerPhone, $customerMobile, $shippingStreetAddress, $shippingCompany, 
        $shippingSuburb, $shippingCity, $shippingState, $shippingPostcode, $shippingCountryId, 
        $paymentMethod, $plainCreditCard, $invoiceCompanyName, $invoiceCompanyAddress, 
        $invoiceProfession, $invoiceVatRegistration, $invoiceTaxOffice, 
        $isGift = false, $receiverCustomerId = null)
    {
        $customerId = null;
        $encrypted_card = null;

        if (Customer::IsAuthenticated())
            $customerId = Customer::GetCurrentCustomerId();
        
        if ($paymentMethod == PAYMENT_METHOD_CC)
        { 
            $secure_card = new SecureCard();
            $secure_card->LoadPlainDataAndEncrypt($plainCreditCard['card_holder'],
                $plainCreditCard['card_number'], $plainCreditCard['issue_date'],
                $plainCreditCard['expiry_date'], $plainCreditCard['issue_number'],
                $plainCreditCard['card_type']);
            $encrypted_card = $secure_card->EncryptedData;
        }
        
        $sql = 'CALL catalog_product_create_order(:product_id, :product_options_ids, 
            :customer_id, :customer_gender, :customer_name, :customer_phone, 
            :customer_mobile, :shipping_company, :shipping_street_addr, :shipping_suburb, 
            :shipping_city, :shipping_state, :shipping_postcode, :shipping_country_id, 
            :payment_method, :credit_card, :invoice_company_name, :invoice_company_address, 
            :invoice_profession, :invoice_vat_registration, :invoice_tax_office,
            :is_gift, :receiver_customer_id)';
        
        $params = array(':product_id' => $productId, 
            ':product_options_ids' => $productOptionsIds,
            ':customer_id' => $customerId,
            ':customer_gender' => $customerGender,
            ':customer_name' => $customerName,
            ':customer_phone' => $customerPhone,
            ':customer_mobile' => $customerMobile,
            ':shipping_company' => $shippingCompany,
            ':shipping_street_addr' => $shippingStreetAddress, 
            ':shipping_suburb' => $shippingSuburb, 
            ':shipping_city' => $shippingCity, 
            ':shipping_state' => $shippingState, 
            ':shipping_postcode' => $shippingPostcode, 
            ':shipping_country_id' => $shippingCountryId,
            ':payment_method' => $paymentMethod,
            ':credit_card' => $encrypted_card,
            ':invoice_company_name' => $invoiceCompanyName,
            ':invoice_company_address' => $invoiceCompanyAddress,
            ':invoice_profession' => $invoiceProfession,
            ':invoice_vat_registration' => $invoiceVatRegistration,
            ':invoice_tax_office' => $invoiceTaxOffice,
            ':is_gift' => $isGift,
            ':receiver_customer_id' => $receiverCustomerId);

        return DatabaseHandler::GetOne($sql, $params);
    }
    
    public static function GetProductRelatedProducts($productId, $languageId = null)
    {                                               
        // Get current session's languageId if not specified
        if (is_null($languageId))
            $languageId = Language::Get();
        
        // Build SQL query
        $sql = 'CALL catalog_get_product_related_products(:product_id, :language_id)';
        
        // Build the parameters array
        $params = array(':product_id' => $productId, 
                        ':language_id' => $languageId);

        // Execute the query
        return DatabaseHandler::GetAll($sql, $params);
    }
    
    public static function AssignProductRelatedProduct($productId, $relatedProductId)
    {
		// Build SQL query
        $sql = 'CALL catalog_assign_product_related_product(:product_id, :related_product_id)';

		// Build the parameters array
        $params = array(':product_id' => $productId,
                        ':related_product_id' => $relatedProductId);

		// Execute the query
		DatabaseHandler::Execute($sql, $params);
    }
    
    public static function DeleteProductRelatedProduct($productId, $relatedProductId)
    {
        // Build SQL query
        $sql = 'CALL catalog_delete_product_related_product(:product_id, :related_product_id)';

		// Build the parameters array
        $params = array(':product_id' => $productId,
                        ':related_product_id'=> $relatedProductId);

		// Execute the query
		DatabaseHandler::Execute($sql, $params);
    }
    
    public static function GetRandomCandidateRelatedProducts($productId, $categoryId, 
        $maxResults = MAX_RANDOM_CANDIDATE_RELATED_PRODUCTS, $languageId = null)
    {
        // Get current session's languageId if not specified
        if (is_null($languageId))
            $languageId = Language::Get();
        
        // Build SQL query
        $sql = 'CALL catalog_get_random_candidate_related_products(
            :product_id, :category_id, :language_id, :max_results)';

		// Build the parameters array
        $params = array(':product_id' => $productId,
                        ':category_id'=> $categoryId,
                        ':language_id'=> $languageId,
                        ':max_results'=> $maxResults);

		// Execute the query
		return DatabaseHandler::GetAll($sql, $params);
    }

    public static function GetProductOptionsCombinations($optionsOrProductId)
    {
        $j = 0; 
        $options = array();
        $options_names = array();
        $options_values = array();
        $options_ids = array();

        if (is_array($optionsOrProductId))
            $options = $optionsOrProductId;
        else
            $options = self::GetProductOptions($optionsOrProductId);

        for ($i = 0; $i < count($options); $i++) {
            if ($i == 0 || $options[$i]['option_name'] != $options[$i-1]['option_name']) { 
                if ($i != 0)
                    $j++;
                $options_names[$j] = $options[$i]['option_name'];
                $options_values[$j] = array();
                $options_ids[$j] = array();
            }
            array_push($options_values[$j], 
                $options[$i]['option_value']);
            array_push($options_ids[$j], 
                $options[$i]['product_option_id']);
        }

        return array($options_names, 
            Utils::ArrayCartesianProduct($options_ids), 
            Utils::ArrayCartesianProduct($options_values));
    }

    public static function GetProductAvailability($productId, $productOptionsIds = null, $branchId = null)
    {
        // Build SQL query
        $sql = 'CALL catalog_get_product_availability(:product_id, :product_options_ids, :branch_id)';

		// Build the parameters array
        $params = array(':product_id' => $productId,
                        ':product_options_ids'=> $productOptionsIds,
                        ':branch_id'=> $branchId);

		// Execute the query
		return DatabaseHandler::GetAll($sql, $params);
    }

    public static function SetProductAvailability($productId, $status, $schedule, $productOptionsIds = null, $branchId = null)
    {
        // Build SQL query
        $sql = 'CALL catalog_set_product_availability(:product_id, :product_options_ids, 
            :branch_id, :availability_status, :availability_schedule)';

		// Build the parameters array
        $params = array(':product_id' => $productId,
                        ':product_options_ids'=> $productOptionsIds,
                        ':branch_id'=> $branchId,
                        ':availability_status'=> $status,
                        ':availability_schedule'=> $schedule);

		// Execute the query
		DatabaseHandler::Execute($sql, $params);
    }

    public static function RemoveProductAvailability($productId, $productOptionsIds = null, $branchId = null)
    {
        // Build SQL query
        $sql = 'CALL catalog_remove_product_availability(:product_id, :product_options_ids, :branch_id)';

		// Build the parameters array
        $params = array(':product_id' => $productId,
                        ':product_options_ids'=> $productOptionsIds,
                        ':branch_id'=> $branchId);

		// Execute the query
		DatabaseHandler::Execute($sql, $params);
    }

    public static function UpdateProductAvailability($productId, $productOptionsIds, $availabilityStatusIds, $availabilitySchedules, $branchesIds = array())
    {
        $all_available = true;
        for ($i = 0; $i < count($availabilityStatusIds); $i++) {
            if ($availabilityStatusIds[$i] > 1) {
                $all_available = false;
                break;
            }
        }

        if ($all_available) {
            //echo 'All available. Must delete all entries of product from the product_availability table' . '<br>';
            self::RemoveProductAvailability($productId);
        } else {
            for ($i = 0; $i < count($availabilityStatusIds); $i++) {
                if ($availabilityStatusIds[$i] > 1) { // Not available
                    //echo 'Must insert or update the following entries : ';
                    //echo 'branch_id: ' . $branchesIds[$i];
                    //echo ' product_option_ids: ' . $productOptionsIds[$i];
                    //echo ' availability_status_id: ' . $availabilityStatusIds[$i];
                    //echo '<br>';
                    $schedule = null;
                    if (!empty($availabilitySchedules[$i])) {
                        if (version_compare(PHP_VERSION, '5.3.0') >= 0) {
                            $date = DateTime::createFromFormat('d#m#Y H:i:s', $availabilitySchedules[$i] . ' 00:00:00');
                            $schedule = $date->format('Y-m-d H:i:s');
                        } else {
                            list($day, $month, $year) = split('[/]', $availabilitySchedules[$i]);
                            $schedule = $year . '-' . $month . '-' . $day . ' 00:00:00';
                        }
                    }
                    self::SetProductAvailability($productId, $availabilityStatusIds[$i], 
                        $schedule, $productOptionsIds[$i], $branchesIds[$i]);
                } else { // Available
                    //echo 'Must delete the following entries : ';
                    //echo 'branch_id: ' . $branchesIds[$i];
                    //echo ' product_option_ids: ' . $productOptionsIds[$i];
                    //echo '<br>';
                    self::RemoveProductAvailability($productId, $productOptionsIds[$i], $branchesIds[$i]);
                }
            }
        }
    }
    
    public static function GetProductsLatest($howMany, $uniqueCategoryId = null, $languageId = null)
    {
        $short_product_description_length = SHORT_PRODUCT_DESCRIPTION_LENGTH;

        // Get current session's languageId if not specified
        if (is_null($languageId))
            $languageId = Language::Get();

        // Retrieve the list of products
        $sql = 'CALL catalog_get_latest_products(:unique_category_id, :how_many,
            :short_product_description_length, :language_id)';

        // Build the parameters array
        $params = array(':unique_category_id' => $uniqueCategoryId,
            ':how_many' => $howMany,
            ':short_product_description_length' => $short_product_description_length,
            ':language_id' => $languageId);

		// Execute the query and return the results
		return DatabaseHandler::GetAll($sql, $params);
    }
}
?>
