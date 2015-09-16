<?php

define('ADD_ADMIN', 'add_admin');
define('DELETE_ADMIN', 'delete_admin');

class AdminAdministrators
{
    public $mMyAdministratorId;
    public $mAdministrators;
    public $mErrorMessage;
    public $mNewAdmin;

    private $__mAction;
    private $__mNewAdminId;
    private $__mDeletedAdminId;
    
    private function ProcessSubmittedNewAdmin()
    {
        $this->mErrorMessage = '';

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
                        !empty($admin_read['administrator_id'])) {
                    $this->mErrorMessage .= '<br>' . '* Η διεύθυνση email χρησιμοποιείται ήδη.';
                }
            }
        }
        
        if (empty($_POST['admin_password'])) {
            $this->mErrorMessage .= '<br>' . '* Παρακαλώ εισάγετε έναν κωδικό.';
        } else {
            /* Check for minimum password requirements */
            if (strlen ($_POST['admin_password']) < 8) 
                    $this->mErrorMessage .= '<br>' . '* Πρέπει να εισάγετε έναν κωδικό με τουλάχιστον 8 χαρακτήρες.';
        }
        
        if (empty($_POST['admin_password_confirm'])) {
                $this->mErrorMessage .= '<br>' . '* Παρακαλώ επανεισάγετε το νέο κωδικό σας.';
        } else {
            /* Check if re-typing password matches password field */
            if (strcmp($_POST['admin_password'], 
                    $_POST['admin_password_confirm'])) 
                    $this->mErrorMessage .= '<br>' . '* Η επιβεβαίωση του κωδικού απέτυχε.';
        }
        
        if (empty($this->mErrorMessage)) {
            $this->__mNewAdminId = Administrator::Add(
                $_POST['admin_first_name'], $_POST['admin_last_name'], 
                $_POST['admin_email'], $_POST['admin_password']);
            return SUBMIT_SUCCESS;
        }
        
        $this->mNewAdmin['first_name'] = $_POST['admin_first_name'];
        $this->mNewAdmin['last_name'] = $_POST['admin_last_name'];
        $this->mNewAdmin['email'] = $_POST['admin_email'];
        $this->mNewAdmin['password'] = $_POST['admin_password'];
        $this->mNewAdmin['password_confirm'] = $_POST['admin_password_confirm'];
        return SUBMIT_ERRORS;
    }

    public function __construct()
    {
        /* If current logged in administrator has no permission to
         * admin administrators exit */
        if (!Administrator::HasPermission('ADMIN_ADMINS')) {
            $application = new Application();
            $application->display('not_authorized.tpl');
            exit(0);
        }

        /* Parse POST array and find action */ 
        foreach ($_POST as $key => $value) {
            if (substr ($key, 0, 6) == 'submit') {
                $last_underscore = strrpos ($key, '_');
                $this->__mAction = substr ($key, strlen('submit_'), 
                    $last_underscore - strlen('submit_'));
                if ($this->__mAction == DELETE_ADMIN)
                    $this->__mDeletedAdminId = (int) substr ($key, $last_underscore + 1);
                break;
            } 
        }
    }

    public function init()
    {
        switch ($this->__mAction) {
        case ADD_ADMIN:
            if (SUBMIT_SUCCESS == $this->ProcessSubmittedNewAdmin()) {
                /* Redirect to store's details page */
                Link::Redirect(Link::ToAdministratorDetailsAdmin($this->__mNewAdminId));
                exit();
            }
            break;
        case DELETE_ADMIN:
            Administrator::Delete($this->__mDeletedAdminId);
            Link::Redirect(Link::ToAdministratorsAdmin());
            exit();
        default:
            break;
        }

        /* Get administrator id of the currently logged in administrator */
        $this->mMyAdministratorId = Administrator::GetLoggedAdministratorId();

        /* Get all administrators */ 
        $this->mAdministrators = Administrator::GetAll();

        /* Make links to details page */ 
        for ($i = 0; $i < count($this->mAdministrators); $i++) {
            $statusOptions = Administrator::$mStatusOptions;
            $this->mAdministrators[$i]['status'] = 
                $statusOptions[$this->mAdministrators[$i]['status']];
            $this->mAdministrators[$i]['link_to_administrator_details'] =
                Link::ToAdministratorDetailsAdmin($this->mAdministrators[$i]['administrator_id']);
        }
    }
}
?>

