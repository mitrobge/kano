<?php

// Business tier class that manages administrator accounts functionality
class Administrator
{
    public static $mStatusOptions = array('Μη Ενεργός',
                                          'Ενεργός');

    public static function IsAuthenticated()
    {
        if (!(isset ($_SESSION['administrator_id'])))
            return 0;
        else
            return 1;
    }
    
    public static function GetLoggedAdministratorId()
    {
        if (self::IsAuthenticated())
            return $_SESSION['administrator_id'];
        else
            return 0;
    }

    public static function GetSeminarsPerPage($administratorId = null)
    {
        if (is_null($administratorId))
            $administratorId = self::GetLoggedAdministratorId();
        
        if (!isset($_SESSION['administrator_seminar_per_page'])) {
            $admin = self::Get($administratorId);
            $_SESSION['administrator_seminar_per_page'] = 
                ($admin['seminars_per_page']) ? $admin['seminars_per_page'] : SEMINARS_PER_PAGE_ADMIN;
        }
        
        return $_SESSION['administrator_seminar_per_page'];

    }
    
    public static function SetSeminarsPerPage($seminarsPerPage, $administratorId = null)
    {
        if (is_null($administratorId))
            $administratorId = self::GetLoggedAdministratorId();

        // Build the SQL query
        $sql = 'CALL administrator_set_seminars_per_page(
            :administrator_id, :seminars_per_page)';

        // Build the parameters array
        $params = array (':administrator_id' => $administratorId,
            ':seminars_per_page' => $seminarsPerPage);

        // Execute the query and return the results
        DatabaseHandler::Execute($sql, $params);
        
        $_SESSION['administrator_seminar_per_page'] = $seminarsPerPage;
    }

    public static function GetReviewsPerPage($administratorId = null)
    {
        if (is_null($administratorId))
            $administratorId = self::GetLoggedAdministratorId();

        if (!isset($_SESSION['administrator_review_per_page'])) {
            $admin = self::Get($administratorId);
            $_SESSION['administrator_review_per_page'] = 
                ($admin['reviews_per_page']) ? $admin['reviews_per_page'] : REVIEWS_PER_PAGE_ADMIN;
        }
        
        return $_SESSION['administrator_review_per_page'];
    }

    public static function SetReviewsPerPage($reviewsPerPage, $administratorId = null)
    {
        if (is_null($administratorId))
            $administratorId = self::GetLoggedAdministratorId();

        // Build the SQL query
        $sql = 'CALL administrator_set_reviews_per_page(
            :administrator_id, :reviews_per_page)';

        // Build the parameters array
        $params = array (':administrator_id' => $administratorId,
            ':reviews_per_page' => $reviewsPerPage);

        // Execute the query and return the results
        DatabaseHandler::Execute($sql, $params);
        
        $_SESSION['administrator_review_per_page'] = $reviewsPerPage;
    }

    public static function GetQuestionsPerPage($administratorId = null)
    {
        if (is_null($administratorId))
            $administratorId = self::GetLoggedAdministratorId();

        if (!isset($_SESSION['administrator_question_per_page'])) {
            $admin = self::Get($administratorId);
            $_SESSION['administrator_question_per_page'] = 
                ($admin['questions_per_page']) ? $admin['questions_per_page'] : QUESTIONS_PER_PAGE_ADMIN;
        }
        
        return $_SESSION['administrator_question_per_page'];
    }

    public static function SetQuestionsPerPage($questionsPerPage, $administratorId = null)
    {
        if (is_null($administratorId))
            $administratorId = self::GetLoggedAdministratorId();

        // Build the SQL query
        $sql = 'CALL administrator_set_questions_per_page(
            :administrator_id, :questions_per_page)';

        // Build the parameters array
        $params = array (':administrator_id' => $administratorId,
            ':questions_per_page' => $questionsPerPage);

        // Execute the query and return the results
        DatabaseHandler::Execute($sql, $params);
        
        $_SESSION['administrator_question_per_page'] = $questionsPerPage;
    }

    public static function GetReportsPerPage($administratorId = null)
    {
        if (is_null($administratorId))
            $administratorId = self::GetLoggedAdministratorId();

        if (!isset($_SESSION['administrator_report_per_page'])) {
            $admin = self::Get($administratorId);
            $_SESSION['administrator_report_per_page'] = 
                ($admin['reports_per_page']) ? $admin['reports_per_page'] : REPORTS_PER_PAGE_ADMIN;
        }
        
        return $_SESSION['administrator_report_per_page'];
    }

    public static function SetReportsPerPage($reportsPerPage, $administratorId = null)
    {
        if (is_null($administratorId))
            $administratorId = self::GetLoggedAdministratorId();

        // Build the SQL query
        $sql = 'CALL administrator_set_reports_per_page(
            :administrator_id, :reports_per_page)';

        // Build the parameters array
        $params = array (':administrator_id' => $administratorId,
            ':reports_per_page' => $reportsPerPage);

        // Execute the query and return the results
        DatabaseHandler::Execute($sql, $params);
        
        $_SESSION['administrator_report_per_page'] = $reportsPerPage;
    }
    
    public static function GetOffersPerPage($administratorId = null)
    {
        if (is_null($administratorId))
            $administratorId = self::GetLoggedAdministratorId();

        if (!isset($_SESSION['administrator_offers_per_page'])) {
            $admin = self::Get($administratorId);
            $_SESSION['administrator_offers_per_page'] = 
                ($admin['offers_per_page']) ? $admin['offers_per_page'] : OFFERS_PER_PAGE_ADMIN;
        }
        
        return $_SESSION['administrator_offers_per_page'];
    }

    public static function SetOffersPerPage($offersPerPage, $administratorId = null)
    {
        if (is_null($administratorId))
            $administratorId = self::GetLoggedAdministratorId();

        // Build the SQL query
        $sql = 'CALL administrator_set_offers_per_page(
            :administrator_id, :offers_per_page)';

        // Build the parameters array
        $params = array (':administrator_id' => $administratorId,
            ':offers_per_page' => $offersPerPage);

        // Execute the query and return the results
        DatabaseHandler::Execute($sql, $params);
        
        $_SESSION['administrator_offers_per_page'] = $offersPerPage;
    }
    
    public static function CheckLoginInfo($email, $password = null)
    {
        // Build the SQL query
        $sql = 'CALL administrator_check_login_info(:email, :password)';

        // Build the parameters array
        $params = array (':email' => $email, 
            ':password' => PasswordHasher::Hash($password));

        // Execute the query and return the results
        return DatabaseHandler::GetRow($sql, $params);
    }
    
    public static function Login($email, $password)
    {
        $login = self::CheckLoginInfo($email, $password);

        if ($login['check_status'] == 3)
            return 3;
        else if ($login['check_status'] == 2)
            return 2;
        else if ($login['check_status'] == 1)
            return 1;

        $_SESSION['administrator_id'] = $login['administrator_id'];
        $_SESSION['administrator_first_name'] = $login['first_name'];
        $_SESSION['administrator_last_name'] = $login['last_name'];
        
        return 0;
    }

    public static function Logout()
    {
        unset($_SESSION['administrator_id']);
        unset($_SESSION['administrator_first_name']);
        unset($_SESSION['administrator_last_name']);
    }
    
    public static function GetAvailablePermissions()
    {
        // Build the SQL query
        $sql = 'CALL administrator_get_available_permissions()';

        // Execute the query and return the results
        return DatabaseHandler::GetAll($sql);
    }
    
    public static function GetPermissionsCodes($administratorId = null)
    {
        if (is_null($administratorId))
            $administratorId = self::GetLoggedAdministratorId();

        // Build the SQL query
        $sql = 'CALL administrator_get_permissions_codes(:administrator_id)';

        // Build the parameters array
        $params = array (':administrator_id' => $administratorId);

        // Execute the query and return the results
        return DatabaseHandler::GetOne($sql, $params);
    }
    
    public static function GetPermissions($administratorId = null)
    {
        if (is_null($administratorId))
            $administratorId = self::GetLoggedAdministratorId();

        // Build the SQL query
        $sql = 'CALL administrator_get_permissions(:administrator_id)';

        // Build the parameters array
        $params = array (':administrator_id' => $administratorId);

        // Execute the query and return the results
        return DatabaseHandler::GetAll($sql, $params);
    }

    public static function Add($firstName, $lastName, $email, $password)
    {
        $hashed_password = PasswordHasher::Hash($password);
        
        // Build the SQL query
        $sql = 'CALL administrator_add_administrator(
            :first_name, :last_name, :email, :password)';

        // Build the parameters array
        $params = array (':first_name' => $firstName,
            ':last_name' => $lastName,
            ':email' => $email,
            ':password' => $hashed_password);

        // Execute the query and return the results
        return DatabaseHandler::GetOne($sql, $params);
    }

    public static function Get($administratorId = null)
    {
        if (is_null($administratorId))
            $administratorId = self::GetLoggedAdministratorId();
        
        // Build the SQL query
        $sql = 'CALL administrator_get_administrator(:administrator_id)';

        // Build the parameters array
        $params = array (':administrator_id' => $administratorId);

        // Execute the query and return the results
        return DatabaseHandler::GetRow($sql, $params);
    }
    
    public static function GetAll()
    {
        // Build the SQL query
        $sql = 'CALL administrator_get_administrators()';

        // Execute the query and return the results
        return DatabaseHandler::GetAll($sql);
    }
    
    public static function GetWithPermission($permissionCode)
    {
        // Build the SQL query
        $sql = 'CALL administrator_get_administrators_with_permission(:permission_code_name)';
        
        // Build the parameters array
        $params = array (':permission_code_name' => $permissionCode);

        // Execute the query and return the results
        return DatabaseHandler::GetAll($sql, $params);
    }
    
    public static function Update($administratorId, $firstName, $lastName, $email, $status, $permissions)
    {
        // Build the SQL query
        $sql = 'CALL administrator_update_details(
            :administrator_id, :first_name, :last_name, :email, :status, :permissions)';

        // Build the parameters array
        $params = array (':administrator_id' => $administratorId,
            ':first_name' => $firstName,
            ':last_name' => $lastName,
            ':email' => $email,
            ':status' => $status,
            ':permissions' => $permissions);

        // Execute the query and return the results
        DatabaseHandler::Execute($sql, $params);
        
        $_SESSION['administrator_first_name'] = $firstName;
        $_SESSION['administrator_last_name'] = $lastName;
    }
    
    public static function ChangePassword($administratorId, $email, $existingPassword, $newPassword)
    {
        // Check if email and existing password are valid and refer to the administratorId
        if (isset($existingPassword)) {
            $login = self::CheckLoginInfo($email, $existingPassword);

            if ($login['administrator_id'] != $administratorId)
                return LOGININFO_INVALID;
            else if ($login['check_status'] > 0 && $login['check_status'] != ACCOUNT_BLOCKED)
                return $login['check_status'];
        }
        
        $hashed_new_password = PasswordHasher::Hash($newPassword);
        
        // Build the SQL query
        $sql = 'CALL administrator_change_password(
            :administrator_id, :new_password)';

        // Build the parameters array
        $params = array (':administrator_id' => $administratorId,
            ':new_password' => $hashed_new_password);

        // Execute the query and return the results
        DatabaseHandler::Execute($sql, $params);

        return 0;
    }

    public static function HasPermission($permission, $administratorId = null)
    {
        if (is_null($administratorId))
            $administratorId = self::GetLoggedAdministratorId();
        
        // Build the SQL query
        $sql = 'CALL administrator_has_permission(:administrator_id, :permission)';

        // Build the parameters array
        $params = array (':administrator_id' => $administratorId,
            ':permission' => $permission);

        // Execute the query and return the results
        return DatabaseHandler::GetOne($sql, $params);
    }
    
    public static function Delete($administratorId)
    {
        if (self::GetLoggedAdministratorId() == $administratorId)
            return;

        // Build the SQL query
        $sql = 'CALL administrator_delete_administrator(:administrator_id)';

        // Build the parameters array
        $params = array (':administrator_id' => $administratorId);

        // Execute the query and return the results
        DatabaseHandler::Execute($sql, $params);
    }

    public static function GetProductAvailabilityOptions($languageId = null)
    {
        // Get current session's languageId if not specified
        if (is_null($languageId))
            $languageId = Language::Get();

        // Build the SQL query
        $sql = 'CALL configuration_get_product_availability_options(:language_id)';

        // Build the parameters array
        $params = array (':language_id' => $languageId);

        // Execute the query and return the results
        return DatabaseHandler::GetAll($sql, $params);
    }

}

?>
