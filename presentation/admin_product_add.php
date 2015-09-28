<?php

class AdminProductAdd
{
    public $mPromotionOfferStartDate = '';
    public $mPromotionOfferEndDate = '';
    public $mPromotionFrontpageStartDate = '';
    public $mPromotionFrontpageEndDate = '';
    public $mLinkToProductsAdmin;
    public $mErrorMessage;
    public $mLanguages;
    public $mCategoryIsGroup = false;  
    public $mProduct = array('category_id' => 0, 
        'name' => array(), 'introduction' => array(), 
        'description' => array(), 'language' => array(), 
        'price' => '', 'isbulky' => '', 'erp_code' => '',
        'manufacturer_id' => '');

    private $__mStoreId = null;
    private $__mCategoryId = null;

    private function ValidateSubmittedData()
    {
        $this->mErrorMessage = null;
        
        if (!is_null($this->__mStoreId) && is_null($this->__mCategoryId)) {
            if (!isset($_POST['product_category_id']) || empty($_POST['product_category_id']))
                $this->mErrorMessage .= '<br>* Παρακαλώ επιλέξτε κατηγορία';
            else
                $this->__mCategoryId = $_POST['product_category_id'];
        }

        if (!empty($_POST['product_erp_code']))
            if (Catalog::IsValidERPCodeForProduct($_POST['product_erp_code']))
                $this->mErrorMessage .= '* O κωδικός ERP "' . $_POST['product_erp_code'] . '" χρησιμοποιείται από άλλο προϊόν!';
        if ($_POST['product_price'] == null || !is_numeric($_POST['product_price']))
            $this->mErrorMessage .= '<br>* Η τιμή πρέπει να είναι ένας αριθμός';
        if ($this->mCategoryIsGroup && (!isset($_POST['groupset_list']) || !count($_POST['groupset_list'])))
            $this->mErrorMessage .= '<br>* Δεν έχει επιλεγεί κάποιο προϊόν';
        for ($i = 0; $i < count($this->mLanguages); $i++) {
            if ($_POST['product_name_' . $this->mLanguages[$i]['language_id']] == null || 
                    empty($_POST['product_name_' . $this->mLanguages[$i]['language_id']]))
                $this->mErrorMessage .= '<br>* Το όνομα δε μπορεί να είναι άδειο';
            if ($_POST['product_description_' . $this->mLanguages[$i]['language_id']] == null || 
                    empty($_POST['product_description_' . $this->mLanguages[$i]['language_id']]))
                $this->mErrorMessage .= '<br>* Η περιγραφή δε μπορεί να είναι κενή';
        }

        if (!is_null($this->mErrorMessage))
            return SUBMIT_ERRORS;

        return SUBMIT_SUCCESS;
    }

    public function __construct()
    {
        if (!Administrator::HasPermission('ADMIN_CATALOG')) {
            $application = new Application();
            $application->display('not_authorized.tpl');
            exit(0);
        }
         
        if (isset($_GET['StoreId'])) {
            $this->__mStoreId = $_GET['StoreId'];
        } else {
            $stores = Stores::Get();
            if (count($stores) > 1) {
                trigger_error('Adding a product in a multistore catalog needs StoreId to be set');
                exit(0);
            }
            $this->__mStoreId = $stores[0]['store_id'];
        } 
        
        if (isset($_GET['CategoryId'])) {
            $this->__mCategoryId = $_GET['CategoryId'];
            $category = Catalog::GetCategory($this->__mCategoryId);
            if ($category['subcategories_count'] > 0) {
                trigger_error('Cannot add a product to a non-leaf category');
                exit(0);
            }
            $this->mCategoryIsGroup = $category['is_group'];
        } 
        
        /* Promotion Start date is now */
        $this->mPromotionOfferStartDate = date('d/m/Y');
        $this->mPromotionFrontpageStartDate = date('d/m/Y');
        
        /* Make links */
        $this->mLinkToProductsAdmin = 
            Link::ToProductsAdmin($this->__mStoreId, $this->__mCategoryId);
    }

    public function init()
    {
        /* Get supported languages */
        $this->mLanguages = Language::GetAll();
 
        if (isset($_POST['submit_add_product'])) {
            if ($this->ValidateSubmittedData() == SUBMIT_SUCCESS) {
                $product_id = Catalog::AddProduct($this->__mStoreId, $this->__mCategoryId, 
                    $_POST['product_erp_code'], $_POST['product_manufacturer_id'], 
                    $_POST['product_price'], isset($_POST['is_bulky']) ? true : false);
                for ($i = 0; $i < count($this->mLanguages); $i++) {
                    Catalog::SetProductName($product_id, 
                        $_POST['product_name_' . $this->mLanguages[$i]['language_id']], 
                        $_POST['product_introduction_' . $this->mLanguages[$i]['language_id']], 
                        $_POST['product_description_' . $this->mLanguages[$i]['language_id']],
                        $_POST['product_comments_' . $this->mLanguages[$i]['language_id']],
                        $this->mLanguages[$i]['language_id']);
                }
                /* Assign spare items consisting the product */
                if ($this->mCategoryIsGroup) {
                    foreach ($_POST['groupset_list'] as $key => $value)
                        Catalog::AssignSpareItemToGroupsetProduct($product_id, $value);
                }
                /* Set promotion of the new product if defined */
                if (isset($_POST['promotion_offer'])) {
                    /* Convert to PHP/MySQL date format */
                    $sdate = null; $edate = null;
                    if (!empty($_POST['promotion_offer_start_date'])) {
                        $this->mPromotionOfferStartDate = $_POST['promotion_offer_start_date'];
                        if (version_compare(PHP_VERSION, '5.3.0') >= 0) {
                            $date = DateTime::createFromFormat('d#m#Y H:i:s', $_POST['promotion_offer_start_date'] . ' 00:00:00');
                            $sdate = $date->format('Y-m-d H:i:s');
                        } else {
                            list($day, $month, $year) = split('[/]', $_POST['promotion_offer_start_date']);
                            $sdate = $year . '-' . $month . '-' . $day . ' 00:00:00';
                        }
                    }
                    if (!empty($_POST['promotion_offer_end_date'])) {
                        $this->mPromotionOfferEndDate = $_POST['promotion_offer_end_date'];
                        if (version_compare(PHP_VERSION, '5.3.0') >= 0) {
                            $date = DateTime::createFromFormat('d#m#Y H:i:s', $_POST['promotion_offer_end_date'] . ' 23:59:59');
                            $edate = $date->format('Y-m-d H:i:s');
                        } else {
                            list($day, $month, $year) = split('[/]', $_POST['promotion_offer_end_date']);
                            $edate = $year . '-' . $month . '-' . $day . ' 23:59:59';
                        }
                    }
                    /* Add promotion */
                    Promotion::AddProductOffer($product_id, $sdate, $edate);
                }
                if (isset($_POST['promotion_frontpage'])) {
                    /* Convert to PHP/MySQL date format */
                    $sdate = null; $edate = null;
                    if (!empty($_POST['promotion_frontpage_start_date'])) {
                        $this->mPromotionFrontpageStartDate = $_POST['promotion_frontpage_start_date'];
                        if (version_compare(PHP_VERSION, '5.3.0') >= 0) {
                            $date = DateTime::createFromFormat('d#m#Y H:i:s', $_POST['promotion_frontpage_start_date'] . ' 00:00:00');
                            $sdate = $date->format('Y-m-d H:i:s');
                        } else {
                            list($day, $month, $year) = split('[/]', $_POST['promotion_frontpage_start_date']);
                            $sdate = $year . '-' . $month . '-' . $day . ' 00:00:00';
                        }
                    }
                    if (!empty($_POST['promotion_frontpage_end_date'])) {
                        $this->mPromotionFrontpageEndDate = $_POST['promotion_frontpage_end_date'];
                        if (version_compare(PHP_VERSION, '5.3.0') >= 0) {
                            $date = DateTime::createFromFormat('d#m#Y H:i:s', $_POST['promotion_frontpage_end_date'] . ' 23:59:59');
                            $edate = $date->format('Y-m-d H:i:s');
                        } else {
                            list($day, $month, $year) = split('[/]', $_POST['promotion_frontpage_end_date']);
                            $edate = $year . '-' . $month . '-' . $day . ' 23:59:59';
                        }
                    }
                    /* Add promotion */
                    Promotion::AddProductOnFrontpage($product_id, $sdate, $edate);
                }
                header('Location: ' .
                    htmlspecialchars_decode(
                        Link::ToProductDetailsAdmin($product_id, null, $this->__mCategoryId)));
                exit();
            } else {
                if (isset($_POST['product_category_id']))
                    $this->mProduct['category_id'] = $_POST['product_category_id'];
                $this->mProduct['erp_code'] = $_POST['product_erp_code'];
                $this->mProduct['manufacturer_id'] = $_POST['product_manufacturer_id'];
                $this->mProduct['price'] = $_POST['product_price'];
                if (isset($_POST['is_bulky']))
                    $this->mProduct['isbulky'] = $_POST['is_bulky'];
                for ($i = 0; $i < count($this->mLanguages); $i++) {
                    $this->mProduct['language'][] = $this->mLanguages[$i];
                    $this->mProduct['name'][] = $_POST['product_name_' . 
                        $this->mLanguages[$i]['language_id']];
                    $this->mProduct['introduction'][] = $_POST['product_introduction_' . 
                        $this->mLanguages[$i]['language_id']];
                    $this->mProduct['description'][] = $_POST['product_description_' . 
                        $this->mLanguages[$i]['language_id']];
                    $this->mProduct['comments'][] = $_POST['product_comments_' . 
                        $this->mLanguages[$i]['language_id']];
                }
            } 
        }
        
        /* Get all categories starting from parent category if the current category 
         * (where the product is going to be added) is a groupset category */
        if ($this->mCategoryIsGroup || isset($_GET['StoreId']))
            $this->mCategories = Catalog::GetCategoriesTree(); 
        
        /* Get Manufacturers */
        $this->mManufacturers = Manufacturer::GetAll();
        
        /* Initialize name/description arrays only if nothing has been posted */
        if (!isset($_POST['submit_add_product'])) {
            for ($i = 0; $i < count($this->mLanguages); $i++) {
                $this->mProduct['language'][] = $this->mLanguages[$i];
                $this->mProduct['name'][] = '';
                $this->mProduct['introduction'][] = '';
                $this->mProduct['description'][] = '';
                $this->mProduct['comments'][] = '';
            }
        }
    }
}

?>

