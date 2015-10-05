<?php

define('ADD_CATEGORY', 'add_cat');
define('EDIT_CATEGORY', 'edit_cat');
define('UPDATE_CATEGORY', 'update_cat');
define('DELETE_CATEGORY', 'delete_cat');
define('ADD_ATTRIBUTE', 'add_attr');
define('ASSIGN_ATTRIBUTE', 'assign_attr');
define('EDIT_ATTRIBUTE', 'edit_attr');
define('UPDATE_ATTRIBUTE', 'update_attr');
define('DELETE_ATTRIBUTE', 'delete_attr');
define('ADD_OPTION', 'add_opt');
define('ASSIGN_OPTION', 'assign_opt');
define('EDIT_OPTION', 'edit_opt');
define('UPDATE_OPTION', 'update_opt');
define('DELETE_OPTION', 'delete_opt');

class AdminSurveyQuestions
{
    public $mService;
    public $mProduct;
    public $mErrorMessage;
    public $mWarningMessage;
    
    public $mEditItem;
    

    private $__mProductId = null;
    private $__mStoreId = null;
    private $__mCategoryId = null;
    private $__mAction;
    
    public function ArrayImplode($array)
    {
        asort($array);
        return implode(',', $array);
    }
    
    public function GetQuestionName($questionId, $languageId)
    {
        return Surveys::GetQuestionName($questionId, $languageId);
    }

    public function __construct ()
    {
        if (!Administrator::HasPermission('ADMIN_CATALOG')) {
            $application = new Application();
            $application->display('not_authorized.tpl');
            exit(0);
        }
        
        if (isset($_GET['CategoryId']))
            $this->__mCategoryId = (int) $_GET['CategoryId'];
        
        if (isset ($_GET['ProductId']))
            $this->surveyId = (int) $_GET['ProductId'];
        
        foreach ($_POST as $key => $value) {
            if (substr ($key, 0, 6) == 'submit') {
                $last_underscore = strrpos ($key, '_');
                $this->__mAction = substr ($key, strlen('submit_'), 
                    $last_underscore - strlen('submit_'));
                if ($this->__mAction == ADD_ATTRIBUTE || 
                    $this->__mAction == ASSIGN_ATTRIBUTE || 
                    $this->__mAction == EDIT_ATTRIBUTE || 
                    $this->__mAction == UPDATE_ATTRIBUTE || 
                    $this->__mAction == DELETE_ATTRIBUTE) {
                    $this->__mActionedAttributeId = (int) substr ($key, $last_underscore + 1);
                } else if ($this->__mAction == ADD_OPTION || 
                    $this->__mAction == ASSIGN_OPTION || 
                    $this->__mAction == EDIT_OPTION || 
                    $this->__mAction == UPDATE_OPTION || 
                    $this->__mAction == DELETE_OPTION) {
                    $this->__mActionedOptionId = (int) substr ($key, $last_underscore + 1);
                } else
                    $this->__mActionedCategoryId = (int) substr ($key, $last_underscore + 1);
                
                break;
            } 
        }


        /* Get supported languages */
        $this->mLanguages = Language::GetAll();
        
        $this->mLinkToSurveyQuestionsAdmin = 
            Link::ToSurveyQuestionsAdmin($_GET['ProductId']);
        
    }

    public function init()
    {
        switch ($this->__mAction) {
        case ADD_CATEGORY:
            $has_error = false;
            $parent;
            /* Cannot add a subcategory in a category that contains products */
            if (!is_null($this->__mCategoryId)) {
                $parent = Catalog::GetCategory($this->__mCategoryId);
                if ($parent['products_count'] > 0) {
                    trigger_error('Cannot add a subcategory to a category that contains products');
                    exit(0);
                }
            }
            /* Check if category name(s) are empty or already exist */
            for ($i = 0; $i < count($this->mLanguages); $i++) { // TODO: js validation of input (for all languages)
                $category_name = $_POST['added_category_name_' . 
                    $this->mLanguages[$i]['language_id']];
                if (empty($category_name)) {
                    $this->mErrorMessage = 'Παρακαλώ εισάγεται το όνομα της νέας κατηγορίας/υποκατηγορίας';
                    if (count($this->mLanguages) > 1)
                        $this->mErrorMessage .= 'σε όλες τις διαθέσιμες γλώσσες';
                    $has_error = true;
                    break;
                } else if (!is_null(Catalog::CheckCategoryName($this->__mCategoryId, null, 
                        $category_name, $this->mLanguages[$i]['language_id']))) { 
                    $this->mErrorMessage = 'Το όνομα της κατηγορίας υπάρχει ήδη σε αυτό το επίπεδο';
                    $has_error = true;
                    break;
                }
            }
            /* Add the category or subcategory */ 
            if (!$has_error) {
                $cat_is_spare = false;
                $cat_is_group = false;
                if($_POST['category_type'] == "is_spare")
                    $cat_is_spare = true;
                else if($_POST['category_type'] == "is_group")
                    $cat_is_group = true;

                $category_id = Catalog::AddCategory($this->__mCategoryId, 
                    ($cat_is_spare || $parent['is_spare']) ? true : false, 
                    ($cat_is_group || $parent['is_group']) ? true : false);
                for ($i = 0; $i < count($this->mLanguages); $i++) {
                    $category_name = $_POST['added_category_name_' . 
                        $this->mLanguages[$i]['language_id']];
                    Catalog::SetCategoryName($category_id, $category_name, 
                        $this->mLanguages[$i]['language_id']);
                }
                header('Location: ' .
                    htmlspecialchars_decode(
                        $this->mLinkToCategoriesAdmin));
                exit(0);
            }
            break;
        case EDIT_CATEGORY:
            $this->mEditItem = $this->__mActionedCategoryId;
            break;
        case UPDATE_CATEGORY:
            $has_error = false;

            /* Update the name */
            for ($i = 0; $i < count($this->mLanguages); $i++) { // TODO: js validation of input (for all languages)
                $category_name = $_POST['category_name_' . 
                    $this->mLanguages[$i]['language_id']];
                if (empty($category_name)) {
                    $this->mErrorMessage = 'Παρακαλώ εισάγεται όνομα κατηγορίας';
                    if (count($this->mLanguages) > 1)
                        $this->mErrorMessage .= 'για όλες τις διαθέσιμες γλώσσες';
                    $this->mEditItem = $this->__mActionedCategoryId;
                    $has_error = true;
                    break;
                } else if (!is_null(Catalog::CheckCategoryName($this->__mCategoryId, 
                        $this->__mActionedCategoryId, $category_name, $this->mLanguages[$i]['language_id']))) { 
                    $this->mErrorMessage = 'Το όνομα της κατηγορίας υπάρχει ήδη σε αυτό το επίπεδο';
                    $this->mEditItem = $this->__mActionedCategoryId;
                    $has_error = true;
                    break;
                } else { 
                    Catalog::UpdateCategory($this->__mActionedCategoryId, 
                        $category_name, $this->mLanguages[$i]['language_id']);
                }
            }

            /* Update the image */
            if ($_FILES['image_file_' . $this->__mActionedCategoryId]['error'] == UPLOAD_ERR_OK) {
                /* Check whether we have write permission on the category_images folder */
                if (!is_writeable(SITE_ROOT . '/category_images/')) {
                    echo "Can't write to the category_images folder";
                    exit();
                }
                /* move file from its temporary location to the category_images folder, 
                 * and update category information in the database */
                move_uploaded_file($_FILES['image_file_' . $this->__mActionedCategoryId]['tmp_name'],
                        SITE_ROOT . '/category_images/' . $_FILES['image_file_' . $this->__mActionedCategoryId]['name']);
                Catalog::SetCategoryImage($this->__mActionedCategoryId, 
                    $_FILES['image_file_' . $this->__mActionedCategoryId]['name']);
            } 

            if (!$has_error) {
                header('Location: ' .
                    htmlspecialchars_decode(
                        $this->mLinkToCategoriesAdmin));
                exit(0);
            }
            break;
        case DELETE_CATEGORY:
            $status = Catalog::DeleteCategory($this->__mActionedCategoryId, true);
            if ($status < 0)
                $this->mErrorMessage = 'Δε μπορεί να διαγραφεί η κατηγορία "' . 
                    $this->GetCategoryName($this->__mActionedCategoryId, Language::Get()) . 
                        '" διότι δεν είναι άδεια';
            else {
                header('Location: ' .
                    htmlspecialchars_decode(
                        $this->mLinkToCategoriesAdmin));
                exit(0);
            }
            break;
        case ADD_ATTRIBUTE:
            /* Check if attribute name(s) are empty or already exist */
            $has_error = false;
            for( $j = 0; $j<2; $j++){
                for ($i = 0; $i < count($this->mLanguages); $i++) { // TODO: js validation of input (for all languages)
                    $attribute_name = $_POST['added_attribute_name_' . $j. '_'. 
                        $this->mLanguages[$i]['language_id']];
                    if (empty($attribute_name)) {
                        $this->mErrorMessage = 'Το όνομα του χαρακτηριστικού δε μπορεί να είναι άδειο';
                        $has_error = true;
                        break;
                    } 
                }
            }
            /* Add the attribute */
            if (!$has_error) {
                $attribute_id = Surveys::AddSurveyQuestion($this->surveyId);
                for ($i = 0; $i < count($this->mLanguages); $i++) {
                    $attribute_name_pos = $_POST['added_attribute_name_' . '0'. '_'. $this->mLanguages[$i]['language_id']];
                    
                    $attribute_name_neg = $_POST['added_attribute_name_' . '1'. '_'. $this->mLanguages[$i]['language_id']];
                    Surveys::UpdateSurveyQuestion($attribute_id, 
                        $attribute_name_pos, $attribute_name_neg, $this->mLanguages[$i]['language_id']);
                }
                header('Location: ' .
                    htmlspecialchars_decode(
                        $this->mLinkToSurveyQuestionsAdmin));
                exit(0);
                }
            break;
        case ASSIGN_ATTRIBUTE:
            $attribute_id = $_POST['assigned_attribute_id'];
            Catalog::AssignAttributeToCategory($this->__mCategoryId, $attribute_id);
            header('Location: ' .
                htmlspecialchars_decode(
                    $this->mLinkToCategoryAttributesAdmin));
            exit(0);
        case EDIT_ATTRIBUTE:
            $this->mEditItem = $this->__mActionedAttributeId;
            $this->mWarningMessage = 'Η τροποποίηση ενός χαρακτηρηστικού επηρεάζει όλες τις κατηγορίες';
            break;
        case UPDATE_ATTRIBUTE:
            $has_error = false;
            for ($i = 0; $i < count($this->mLanguages); $i++) { // TODO: js validation of input (for all languages)
                $attribute_name = $_POST['attribute_name_' . 
                    $this->mLanguages[$i]['language_id']];
                if (empty($attribute_name)) {
                    $this->mErrorMessage = 'Το όνομα του χαρακτηριστικού δε μπορεί να είναι άδειο';
                    $this->mEditItem = $this->__mActionedAttributeId;
                    $has_error = true;
                    break;
                } else if (!is_null(Catalog::CheckAttributeName($this->__mActionedAttributeId, 
                        $attribute_name, $this->mLanguages[$i]['language_id']))) { 
                    $this->mErrorMessage = 'Το όνομα του χαρακτηριστικού υπάρχει ήδη';
                    $this->mEditItem = $this->__mActionedAttributeId;
                    $has_error = true;
                    break;
                } else 
                    Catalog::UpdateCategoryAttribute($this->__mActionedAttributeId, 
                        $attribute_name, $this->mLanguages[$i]['language_id']);
            }
            if (!$has_error) {
                header('Location: ' .
                    htmlspecialchars_decode(
                        $this->mLinkToCategoryAttributesAdmin));
                exit(0);
            }
            break;
        case DELETE_ATTRIBUTE:
            $status = Catalog::DeleteCategoryAttribute($this->__mCategoryId, 
                                                        $this->__mActionedAttributeId);
            header('Location: ' .
                htmlspecialchars_decode(
                    $this->mLinkToCategoryAttributesAdmin));
            exit(0);
        case ADD_OPTION:
            /* Check if attribute name(s) are empty or already exist */
            $has_error = false;
            for ($i = 0; $i < count($this->mLanguages); $i++) { // TODO: js validation of input (for all languages)
                $option_name = $_POST['added_option_name_' . 
                    $this->mLanguages[$i]['language_id']];
                if (empty($option_name)) {
                    $this->mErrorMessage = 'Το όνομα της επιλογής δε μπορεί να είναι άδειο';
                    $has_error = true;
                    break;
                } else if (!is_null(Catalog::CheckOptionName(null, $option_name, 
                        $this->mLanguages[$i]['language_id']))) { 
                    $this->mErrorMessage = 'Το όνομα της επιλογής υπάρχει ήδη';
                    $has_error = true;
                    break;
                }
            }
            /* Add the attribute */
            if (!$has_error) {
                $option_id = Catalog::AddCategoryOption($this->__mCategoryId);
                for ($i = 0; $i < count($this->mLanguages); $i++) {
                    $option_name = $_POST['added_option_name_' . 
                        $this->mLanguages[$i]['language_id']];
                    Catalog::UpdateCategoryOption($option_id, 
                        $option_name, $this->mLanguages[$i]['language_id']);
                }
                header('Location: ' .
                    htmlspecialchars_decode(
                        $this->mLinkToCategoryOptionsAdmin));
                exit(0);
            }
            break;
        case ASSIGN_OPTION:
            $option_id = $_POST['assigned_option_id'];
            Catalog::AssignOptionToCategory($this->__mCategoryId, $option_id);
            header('Location: ' .
                htmlspecialchars_decode(
                    $this->mLinkToCategoryOptionsAdmin));
            exit(0);
        case EDIT_OPTION:
            $this->mEditItem = $this->__mActionedOptionId;
            $this->mWarningMessage = 'Η τροποποίηση μιας επιλογής επηρεάζει όλες τις κατηγορίες';
            break;
        case UPDATE_OPTION:
            $has_error = false;
            for ($i = 0; $i < count($this->mLanguages); $i++) { // TODO: js validation of input (for all languages)
                $option_name = $_POST['option_name_' . 
                    $this->mLanguages[$i]['language_id']];
                if (empty($option_name)) {
                    $this->mErrorMessage = 'Το όνομα της επιλογής δε μπορεί να είναι άδειο';
                    $this->mEditItem = $this->__mActionedOptionId;
                    $has_error = true;
                    break;
                } else if (!is_null(Catalog::CheckOptionName($this->__mActionedOptionId, 
                        $option_name, $this->mLanguages[$i]['language_id']))) { 
                    $this->mErrorMessage = 'Το όνομα της επιλογής υπάρχει ήδη';
                    $this->mEditItem = $this->__mActionedOptionId;
                    $has_error = true;
                    break;
                } else
                    Catalog::UpdateCategoryOption($this->__mActionedOptionId, 
                        $option_name, $this->mLanguages[$i]['language_id']);
            }
            if (!$has_error) {
                header('Location: ' .
                    htmlspecialchars_decode(
                        $this->mLinkToCategoryOptionsAdmin));
                exit(0);
            }
            break;
        case DELETE_OPTION:
            $status = Catalog::DeleteCategoryOption($this->__mCategoryId, 
                $this->__mActionedOptionId);
            if ($status == 0) {
                $this->mErrorMessage = 
                    'Δε μπορεί να διαγραφεί αυτή η επιλογή. Υπάρχουν προϊόντα που περιέχουν αυτή την επιλογή';
                break;
            }
            header('Location: ' .
                htmlspecialchars_decode(
                    $this->mLinkToCategoryOptionsAdmin));
            exit(0);
        default:
            break;
        }
            $this->mCategory = Catalog::GetCategory($this->__mCategoryId);

        $this->mSurvey['questions'] = 
                    Surveys::GetSurveyQuestions($this->surveyId, null);
        

    }
}

?>
