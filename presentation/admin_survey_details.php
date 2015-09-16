<?php

define('UPDATE_PRODUCT_INFO', 'update_product_info');
define('ASSIGN_PRODUCT_TO_CATEGORY', 'assign_to_category');
define('MOVE_PRODUCT_TO_CATEGORY', 'move_to_category');
define('REMOVE_PRODUCT_FROM_CATEGORY', 'remove_from_category');
define('REMOVE_PRODUCT_FROM_CATALOG', 'remove_from_catalog');
define('UPDATE_PRODUCT_ATTRIBUTES', 'update_product_attributes');
define('UPDATE_PRODUCT_OPTIONS', 'update_product_options');
define('ADD_PRODUCT_OPTIONS', 'add_product_options');
define('UPLOAD_PRODUCT_IMAGE', 'upload_image');
define('UPLOAD_PRODUCT_RESOURCE', 'upload_resource');
define('DELETE_PRODUCT_RESOURCE', 'delete_resource');
define('ADD_SPARE_ITEM', 'add_spare_item');
define('DELETE_SPARE_ITEM', 'delete_spare_item');
define('DELETE_GROUP_ITEM', 'delete_group_item');
define('ADD_GROUP_ITEM', 'add_group_item');
define('ADD_RELATED_PRODUCT', 'add_related_product');
define('DELETE_RELATED_PRODUCT', 'delete_related_product');
define('UPDATE_PRODUCT_AVAILABILITY', 'update_product_availability');
define('REMOVE_RELATED_NEW', 'remove_announcement');
define('ADD_RELATED_NEW', 'add_news_item');
define('ADD_NEW_SEMINAR', 'add_new_seminar');
define('REMOVE_SEMINAR', 'remove_seminar');
define('EDIT_SEMINAR', 'edit_seminar');
define('UPDATE_SEMINAR', 'update_seminar');

class AdminSurveyDetails
{
    public $mService;
    public $mProduct;
    public $mManufacturers;
    public $mOtherCategories;
    public $mErrorMessage;
    public $mLanguages;
    public $mNumOfLanguages;
    public $mLinkToProductDetailsAdmin;
    public $mLinkToProductsAdmin;
    public $mRemoveFromCategory = false;
    public $mSpareCategories;
    public $mCategoryIsEdu = false;
    public $mStoreBranches;
    public $mAvailabilityStatusOptions;
    public $mTabs;
    
    public $mAnnouncementCategoryName;
    public $mAnnouncementsPerCategory;
    public $mrTotalPages;
    public $mPageNo = 1;
    
    public $mAnnouncementCategory;
    public $mAnnouncement;
    public $mRelatedNews;

    public $mEditItem;
    public $mSeminars;
    public $mSeminarLocation = array(
        array(
            1 => 'Αθήνα',
            2 => 'Θεσσαλονίκη',
            3 => 'Ηράκλειο',
            4 => 'Κύπρος',
            5 => 'Ιορδανία',
            6 => 'Ρουμανία',
            7 => 'Αλβανία',
            8 => 'Σαουδική Αραβία'),
        array(
            1 => 'Athens',
            2 => 'Thessaloniki',
            3 => 'Iraklio',
            4 => 'Cyprus',
            5 => 'Jordan',
            6 => 'Roumania',
            7 => 'Albania',
            8 => 'Saudi Arabia')
            );
    
    public $mSeminarDuration = array(
            1 => '8',
            2 => '16',
            3 => '24',
            4 => '32',
            5 => '40'
            );
    public $mSeminarStatus = array(
            0 => 'Ακυρώθηκε',
            1 => 'Ενεργό',
            2 => 'Ολοκληρώθηκε'
            );
    
    public $mSeminarIndex = array(
            1 => '1',
            2 => '2',
            3 => '3',
            4 => '4',
            5 => '5',
            6 => '6',
            7 => '7',
            8 => '8',
            9 => '9',
            10 => '10'
            );
    
    public $mStatusOptions = array('Ακυρώθηκε', 'Ενεργό', 'Ολοκληρώθηκε');

    private $__mProductId = null;
    private $__mStoreId = null;
    private $__mCategoryId = null;
    private $__mSpareItemId = null;
    private $__mRelatedProductId = null;
    private $__mResourceId = null;
    private $__mRelatedNewId = null;
    private $__mRelatedSeminarId = null;
    private $__mAction;
    
    public function ArrayImplode($array)
    {
        asort($array);
        return implode(',', $array);
    }

    public function GetProductAvailabilityIndex($productAvailability, $productOptionsIds, $branchId)
    {
        for ($i = 0; $i < count($productAvailability); $i++) {
            if (!is_null($productOptionsIds)) { 
                if (!strcmp($productAvailability[$i]['product_options_ids'], $productOptionsIds) && 
                    $productAvailability[$i]['branch_id'] == $branchId) {
                        return $i; 
                    }
            } else {
                if ($productAvailability[$i]['branch_id'] == $branchId) {
                    return $i; 
                }
            }
        }
        return -1;
    }

    public function __construct ()
    {
        if (!Administrator::HasPermission('ADMIN_CATALOG')) {
            $application = new Application();
            $application->display('not_authorized.tpl');
            exit(0);
        }

        if (isset ($_GET['CategoryId']))
            $this->__mCategoryId = (int)$_GET['CategoryId'];

        if (isset ($_GET['StoreId']))
            $this->__mStoreId = (int)$_GET['StoreId'];

        if (isset ($_GET['ProductId']))
            $this->__mProductId = (int)$_GET['ProductId'];
        else
            trigger_error('ProductId not set');


        /* Parse POST array to get current action */
        foreach ($_POST as $key => $value) {
            if (substr ($key, 0, 6) == 'submit') {

                $this->__mAction = substr ($key, strlen('submit_'));
                if (!strncmp($this->__mAction, DELETE_SPARE_ITEM, strlen(DELETE_SPARE_ITEM))) {
                    $last_underscore = strrpos ($this->__mAction, '_');
                    $this->__mSpareItemId = substr($this->__mAction, $last_underscore+1, strlen($this->__mAction));
                    $this->__mAction = substr($this->__mAction, 0, $last_underscore);
                }
                else if (!strncmp($this->__mAction, DELETE_GROUP_ITEM, strlen(DELETE_GROUP_ITEM))) {
                    $last_underscore = strrpos ($this->__mAction, '_');
                    $this->__mGroupItemId = substr($this->__mAction, $last_underscore+1, strlen($this->__mAction));
                    $this->__mAction = substr($this->__mAction, 0, $last_underscore);
                }
                else if (!strncmp($this->__mAction, DELETE_RELATED_PRODUCT, strlen(DELETE_RELATED_PRODUCT))) {
                    $last_underscore = strrpos ($this->__mAction, '_');
                    $this->__mRelatedProductId = substr($this->__mAction, $last_underscore+1, strlen($this->__mAction));
                    $this->__mAction = substr($this->__mAction, 0, $last_underscore);
                }
                else if (!strncmp($this->__mAction, DELETE_PRODUCT_RESOURCE, strlen(DELETE_PRODUCT_RESOURCE))) {
                    $last_underscore = strrpos ($this->__mAction, '_');
                    $this->__mResourceId = substr($this->__mAction, $last_underscore+1, strlen($this->__mAction));
                    $this->__mAction = substr($this->__mAction, 0, $last_underscore);
                }
                else if (!strncmp($this->__mAction, REMOVE_RELATED_NEW, strlen(REMOVE_RELATED_NEW))) {
                    $last_underscore = strrpos ($this->__mAction, '_');
                    $this->__mRelatedNewId = substr($this->__mAction, $last_underscore+1, strlen($this->__mAction));
                    $this->__mAction = substr($this->__mAction, 0, $last_underscore);
                }
                else if (!strncmp($this->__mAction, REMOVE_SEMINAR, strlen(REMOVE_SEMINAR))) {
                    $last_underscore = strrpos ($this->__mAction, '_');
                    $this->__mRelatedSeminarId = substr($this->__mAction, $last_underscore+1, strlen($this->__mAction));
                    $this->__mAction = substr($this->__mAction, 0, $last_underscore);
                }
                else if (!strncmp($this->__mAction, EDIT_SEMINAR, strlen(EDIT_SEMINAR))) {
                    $last_underscore = strrpos ($this->__mAction, '_');
                    $this->__mRelatedSeminarId = substr($this->__mAction, $last_underscore+1, strlen($this->__mAction));
                    $this->__mAction = substr($this->__mAction, 0, $last_underscore);
                }
                else if (!strncmp($this->__mAction, UPDATE_SEMINAR, strlen(UPDATE_SEMINAR))) {
                    $last_underscore = strrpos ($this->__mAction, '_');
                    $this->__mRelatedSeminarId = substr($this->__mAction, $last_underscore+1, strlen($this->__mAction));
                    $this->__mAction = substr($this->__mAction, 0, $last_underscore);
                }
                break;
            }
        }



        /* Make Links */
        $this->mLinkToProductsAdmin =
            Link::ToProductsAdmin($this->__mStoreId, $this->__mCategoryId);

        $this->mLinkToProductDetailsAdmin =
            Link::ToProductDetailsAdmin($this->__mProductId, 
            $this->__mStoreId, $this->__mCategoryId);

        /* Get supported languages */
        $this->mLanguages = Language::GetAll();
    }

    public function init()
    {

        /* Process POST Action */
        switch ($this->__mAction) {
        case UPLOAD_PRODUCT_IMAGE:
            /* Check whether we have write permission on the images folder */
            if (!is_writeable(SITE_ROOT . '/images/')) {
                echo "Can't write to the images folder";
                exit();
            }
            /* move file from its temporary location to the images folder, 
             * and update product information in the database */
            if ($_FILES['image_file']['error'] == UPLOAD_ERR_OK) {
                move_uploaded_file($_FILES['image_file']['tmp_name'],
                    SITE_ROOT . '/images/' . 
                    $_FILES['image_file']['name']);
                Services::SetServiceImage($this->__mProductId, 
                    $_FILES['image_file']['name']);
            } 
            break;
        case UPDATE_PRODUCT_INFO:
            /* Update name and description for all languages */
            for ($i = 0; $i < count($this->mLanguages); $i++) { // TODO: js validation of input (for all languages)
                $product_name = $_POST['product_name_' . 
                    $this->mLanguages[$i]['language_id']];
                $product_description = $_POST['product_description_' . 
                    $this->mLanguages[$i]['language_id']];
                Services::SetServiceName($this->__mProductId, $product_name,  
                    $product_description, $this->mLanguages[$i]['language_id']);
            }

            /* Update default resources based on resource_type */

            if(isset($_POST['resource_default']))
            {

                foreach ($_POST['resource_default'] as $key => $value) {
                    for ($i = 0; $i < count($this->mLanguages); $i++) {

                        Services::AddResourceToService($this->__mProductId, $this->mLanguages[$i]['language_id'], $value);

                    }
                }
            }

            /* Update resources based on resource_id */

            if (isset($_POST['product_resources']))
            {
                foreach ($_POST['product_resources'] as $key => $value) {

                    if (isset($_POST['resource_visibility_'. $key]))
                    { 
                        Services::SetServiceResources($key, $value, 1, $_POST['resource_type_desc_'. $key] );
                    }
                    else
                        Services::SetServiceResources($key, $value, 0, $_POST['resource_type_desc_'. $key] );
                }
            }



            break;
        case REMOVE_PRODUCT_FROM_CATEGORY:
            Catalog::RemoveProductFromCategory($this->__mProductId, 
                $_POST['category_id_remove']);
            header('Location: ' .
                htmlspecialchars_decode(
                    $this->mLinkToProductDetailsAdmin));
            exit();
        case REMOVE_PRODUCT_FROM_CATALOG:
            Services::DeleteService($this->__mProductId);
            header('Location: ' .
                htmlspecialchars_decode(
                    $this->mLinkToProductsAdmin));
            exit();
        case REMOVE_RELATED_NEW:
            Services::RemoveNewFromService($this->__mProductId, 
                $this->__mRelatedNewId);
            header('Location: ' .
                htmlspecialchars_decode(
                    $this->mLinkToProductDetailsAdmin));
            exit();
        case ADD_RELATED_NEW:
            if (($_POST['tmp_groupset_list'])==0) {
                $this->mErrorMessage .= '<br>* Δεν έχει επιλεγεί κάποιο νέο!';
            } else {
                    Services::AddNewToService($this-> __mProductId, $_POST['tmp_groupset_list']);
                header('Location: ' .
                    htmlspecialchars_decode(
                        $this->mLinkToProductDetailsAdmin));
                exit();
            }
            break;
        case ADD_NEW_SEMINAR:
            Services::AddSeminarToService($this-> __mProductId, $_POST['seminar_code'], date('Y-m-d', strtotime($_POST['seminar_sdate'])), date('Y-m-d', strtotime($_POST['seminar_edate'])), $_POST['seminar_duration'], $_POST['seminar_city'], $_POST['seminar_index'], $_POST['seminar_cost'], $_POST['seminar_discount'], $_POST['seminar_remarks']);
                header('Location: ' .
                    htmlspecialchars_decode(
                        $this->mLinkToProductDetailsAdmin));
                exit();
            break;
        case REMOVE_SEMINAR:
            Services::RemoveSeminarFromService($this->__mRelatedSeminarId);
            header('Location: ' .
                htmlspecialchars_decode(
                    $this->mLinkToProductDetailsAdmin));
            exit();
        case EDIT_SEMINAR:
            $this->mEditItem = $this->__mRelatedSeminarId;
            break;
        case UPDATE_SEMINAR:
            $has_error = false;
            /* Update the name */

            if(isset($_POST['seminar_discount_edit']))
                $seminar_discount_edit = $_POST['seminar_discount_edit'];
            else
                $seminar_discount_edit = null;
            if(isset($_POST['seminar_remarks_edit']))
                $seminar_remarks_edit = $_POST['seminar_remarks_edit'];
            else
                $seminar_remarks_edit = null;

            Services::UpdateSeminar($this->__mRelatedSeminarId, $_POST['seminar_code_edit'], date('Y-m-d', strtotime($_POST['seminar_sdate_edit'])), date('Y-m-d', strtotime($_POST['seminar_edate_edit'])), $_POST['seminar_duration_edit'], $_POST['seminar_city_edit'], $_POST['seminar_index_edit'], $_POST['seminar_cost_edit'], $seminar_discount_edit, $_POST['seminar_status_edit'], $seminar_remarks_edit);


            //header('Location: ' .
              //  htmlspecialchars_decode(
                //    $this->mLinkToProductDetailsAdmin));
           // exit();
        }

        $category = Surveys::GetCategory($this->__mCategoryId);


        /* Get the details of product */
        $this->mProduct = Surveys::GetSurveyDetails($this->__mProductId);


        /* Get supported languages */
        $this->mLanguages = Language::GetAll();
        $this->mNumOfLanguages = count($this->mLanguages);


        /* Get name and description for all languages */
        $this->mProduct['name'] = array();
        $this->mProduct['introduction'] = array();
        $this->mProduct['description'] = array();
        $this->mProduct['comments'] = array();
        $this->mProduct['language'] = array();
        $this->mService['resources'] = array();
        $this->mService['default_resources'] = array();
        $this->NumOfResources = array();
        $this->NumOfDefaultResources = array();


        for ($i = 0; $i < count($this->mLanguages); $i++) 
        {
            $this->mProduct['language'][] = $this->mLanguages[$i];
            $this->mProduct['name'][] = Surveys::GetSurveyName(
                $this->__mProductId, $this->mLanguages[$i]['language_id']);
            $this->mProduct['description'][] = Surveys::GetSurveyDescription(
                $this->__mProductId, $this->mLanguages[$i]['language_id']);
        }


        





    }
}

?>
