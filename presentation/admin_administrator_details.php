<?php

class AdminAdministratorDetails
{
    public $mErrorMessage;
    public $mAdministrator;
    public $mMyAdministratorId;
    public $mLinkToAdministratorDetails;
    public $mLinkToAdministrators;
    public $mLinkToChangePassword;
    public $mAvailablePermissions;
    public $mHasPermission = true;
    
    private $__mChangePassword = false;
    private $__mAdministratorId;
    
    private function ProcessSubmittedChanges()
    {
        $this->mErrorMessage = '';
        
        if (!$this->__mChangePassword) {
            if (strlen($_POST['admin_first_name']) < CUSTOMER_FIRST_NAME_MINLEN)
                $this->mErrorMessage .= '<br>' . '* Το Όνομα πρέπει να περιέχει τουλάχιστον' . 
                    CUSTOMER_FIRST_NAME_MINLEN . 'χαρακτήρες.';

            if (strlen($_POST['admin_last_name']) < CUSTOMER_LAST_NAME_MINLEN)
                $this->mErrorMessage .= '<br>' . '* Το επίθετο πρέπει να περιέχει τουλάχιστον ' . 
                    CUSTOMER_LAST_NAME_MINLEN . 'χαρακτήρες.';

            if (empty($_POST['admin_email'])) {
                $this->mErrorMessage .= '<br>' . '* Παρακαλώ εισάγετε μια έγκυρη διεύθυνση email.';
            } else {
                if (!preg_match('/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/i', 
                        $_POST['admin_email'])) {
                    $this->mErrorMessage .= '<br>' . '* Η διεύθυνση email δεν είναι έγκυρη.';
                } else { 
                    /* Check if we have any administrator with submitted email... */
                    $admin_read = Administrator::CheckLoginInfo($_POST['admin_email']);
                    if (!is_null($admin_read['administrator_id']) && 
                            $admin_read['administrator_id'] != $this->__mAdministratorId) {
                        $this->mErrorMessage .= '<br>' . '* Η διεύθυνση email χρησιμοποιείται ήδη.';
                    }
                }
            }

            if (empty($this->mErrorMessage)) {
                $permissions_ids = '';
                if (isset($_POST['permission']))
                    $permissions_ids = implode(',', $_POST['permission']);
                Administrator::Update($this->__mAdministratorId,
                    $_POST['admin_first_name'], $_POST['admin_last_name'], 
                    $_POST['admin_email'], $_POST['admin_status'],
                    $permissions_ids);
                return SUBMIT_SUCCESS;
            }
        } else {
            if (isset($_POST['admin_existing_password']) && empty($_POST['admin_existing_password'])) {
                $this->mErrorMessage .= '<br>' . '* Παρακαλώ εισάγετε τον τρέχον κωδικό.';
            } 
            
            if (empty($_POST['admin_new_password'])) {
                $this->mErrorMessage .= '<br>' . '* Παρακαλώ εισάγετε ένα νέο κωδικό.';
            } else {
                /* Check for minimum password requirements */
                if (strlen ($_POST['admin_new_password']) < 8) 
                    $this->mErrorMessage .= '<br>' . '* Πρέπει να εισάγετε έναν κωδικό με τουλάχιστον 8 χαρακτήρες.';
            }
            
            if (empty($_POST['admin_confirm_new_password'])) {
                $this->mErrorMessage .= '<br>' . '* Παρακαλώ επανεισάγετε το νέο κωδικό σας.';
            } else {
                /* Check if re-typing password matches password field */
                if (strcmp($_POST['admin_new_password'], 
                        $_POST['admin_confirm_new_password'])) 
                    $this->mErrorMessage .= '<br>' . '* Η επιβεβαίωση του κωδικού απέτυχε.';
            }
            
            if (empty($this->mErrorMessage)) {
                $status = Administrator::ChangePassword($this->__mAdministratorId,
                    $_POST['admin_email'], $_POST['admin_existing_password'], 
                    $_POST['admin_new_password']);
                if ($status == UNRECOGNIZED_PASSW)
                    $this->mErrorMessage .= '<br>' . '* Λάθος τρέχον κωδικός.';
                else if ($status > 0)
                    $this->mErrorMessage .= '<br>' . '* Λάθος: ο κωδικός δε μπορεί να αλλαχθεί. ';
                else 
                    return SUBMIT_SUCCESS;
            }
        }

        if (!$this->__mChangePassword) {
            $this->mAdministrator['first_name'] = $_POST['admin_first_name'];
            $this->mAdministrator['last_name'] = $_POST['admin_last_name'];
            $this->mAdministrator['status'] = $_POST['admin_status'];
            $this->mAdministrator['created_on'] = $_POST['admin_created_on'];
            $this->mAdministrator['last_login'] = $_POST['admin_last_login'];
        }
        $this->mAdministrator['email'] = $_POST['admin_email'];
        return SUBMIT_ERRORS;
    }

    public function __construct()
    { 
        /* Get the store ID from the query string */
        if (isset ($_GET['AdministratorId']))
            $this->__mAdministratorId = (int) $_GET['AdministratorId'];
        else {
            trigger_error('AdministratorId paramater is required');
            exit(0);
        }
        
        /* If current logged in administrator has no permission to
         * admin administrators exit */
        if (!Administrator::HasPermission('ADMIN_ADMINS')) {
            $this->mHasPermission = false;
            if (Administrator::GetLoggedAdministratorId() != $this->__mAdministratorId) {
                $application = new Application();
                $application->display('not_authorized.tpl');
                exit(0);
            }
        }
        
        if (isset ($_GET['ChangePassword']))
            $this->__mChangePassword = true;

        /* Make links */
        $this->mLinkToAdministrators = Link::ToAdministratorsAdmin();
        $this->mLinkToAdministratorDetails = Link::ToAdministratorDetailsAdmin(
            $this->__mAdministratorId);
        $this->mLinkToChangePassword = Link::ToAdministratorDetailsAdmin(
            $this->__mAdministratorId, true);
    }

    public function init()
    {
        $this->mAdministrator = Administrator::Get($this->__mAdministratorId);
        
        if (isset($_POST['submit_save_changes'])) {
            if (SUBMIT_SUCCESS == $this->ProcessSubmittedChanges()) {
                /* Redirect to administrator's details page */
                Link::Redirect(Link::ToAdministratorDetailsAdmin(
                    $this->__mAdministratorId));
                exit();
            }
        } else if (isset($_POST['submit_delete_admin'])) {
            if (Administrator::GetLoggedAdministratorId() != $this->__mAdministratorId) {
                Administrator::Delete($this->__mAdministratorId);
                Link::Redirect(Link::ToAdministratorsAdmin());
                exit();
            }
        }
        
        /* Get administrator id of the currently logged in administrator */
        $this->mMyAdministratorId = Administrator::GetLoggedAdministratorId();
        
        $this->mAdministrator['permissions_ids_flipped'] = array_flip(explode(',', 
            $this->mAdministrator['permissions_ids']));
        $this->mAvailablePermissions = Administrator::GetAvailablePermissions();
        $this->mAdministratorStatusOptions = Administrator::$mStatusOptions;
    }
}
?>

