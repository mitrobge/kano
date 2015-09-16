<?php

//require_once 'facebook.php';

// Business tier class that manages customer accounts functionality
class Customer
{
    public static $mProfessionalStatusOptions = array(1 => 'Ερασιτέχνης',
                                                      2 => 'Επαγγελματίας',
                                                      3 => 'Νέος Επαγγελματίας (κάτω απο 28)',
                                                      4 => 'Επιχείρηση/Οργανισμός',
                                                      5 => 'Φοιτητής/Σπουδαστής');
    
    public static $mExperienceYearsOptions = array(1 => '< 5',
                                                   2 => '5 - 10',
                                                   3 => '11 - 20',
                                                   4 => '> 20');
    // Generates random passwords
    public static function RandomPassword($length=8, $strength=15) 
    {
        $vowels = 'aeuy';
        $consonants = 'bdghjmnpqrstvz';
        if ($strength & 1) {
            $consonants .= 'BDGHJLMNPQRSTVWXZ';
        }
        if ($strength & 2) {
            $vowels .= "AEUY";
        }
        if ($strength & 4) {
            $consonants .= '23456789';
        }
        if ($strength & 8) {
            $consonants .= '@#$%';
        }

        $password = '';
        $alt = time() % 2;
        for ($i = 0; $i < $length; $i++) {
            if ($alt == 1) {
                $password .= $consonants[(rand() % strlen($consonants))];
                $alt = 0;
            } else {
                $password .= $vowels[(rand() % strlen($vowels))];
                $alt = 1;
            }
        }
        return $password;
    }
    
    // Checks if a customer_id exists in session
    public static function IsAuthenticated()
    {
        if (!(isset ($_SESSION['customer_id'])))
            return 0;
        else
            return 1;
    }

    // Returns customer_id for customer with email $email if exist in db
    public static function CheckLoginInfo($email, $password = null)
    {
        // Build the SQL query
        $sql = 'CALL customer_check_login_info(:email, :password)';

        // Build the parameters array
        $params = array (':email' => $email, 
            ':password' => $password);

        // Execute the query and return the results
        return DatabaseHandler::GetRow($sql, $params);
    }

    public static function GetFbUserCustomerId($fb_user_id)
    {
        // Build the SQL query
        $sql = 'CALL customer_check_login_info_fb(:fb_user_id)';

        // Build the parameters array
        $params = array (':fb_user_id' => (string)$fb_user_id);

        // Execute the query and return the results
        return DatabaseHandler::GetOne($sql, $params);
    }
    
    // Checks if login info is valid and sets the related session variables
    public static function Login($email, $password)
    {
        $login = self::CheckLoginInfo($email, 
            PasswordHasher::Hash($password));

        if ($login['check_status'] == 3)
            return 3;
        else if ($login['check_status'] == 2)
            return 2;
        else if ($login['check_status'] == 1)
            return 1;

        $_SESSION['customer_id'] = $login['customer_id'];
        $_SESSION['customer_first_name'] = $login['first_name'];
        $_SESSION['customer_last_name'] = $login['last_name'];
        return 0;
    }

    public static function LoginFbUser($fb_user_id)
    {
        $customer_id = self::GetFbUserCustomerId($fb_user_id);

        if (is_null($customer_id))
        {
            $info = FacebookApp::GetUserInfo($fb_user_id);
            $customer_id = self::Add(
                $info['gender'], $info['first_name'], 
                $info['last_name'], $info['email'], 
                '', '', '', '', '', '', '', '', '', '', '', 
                (string)$fb_user_id, false, false);
        }

        $_SESSION['customer_id'] = $customer_id;
        $_SESSION['cart_id'] = (string)$fb_user_id;

        return $customer_id;
    }

    public static function Logout()
    {
        unset($_SESSION['customer_id']);
        unset($_SESSION['customer_first_name']);
        unset($_SESSION['customer_last_name']);
    }

    public static function GetCurrentCustomerId()
    {
        if (self::IsAuthenticated())
            return $_SESSION['customer_id'];
        else
            return 0;
    }

    /* Adds a new customer account, log him in if $addAndLogin is true
        and returns customer_id */
    public static function Add($gender, $firstName, $lastName, $email, $password, 
				$streetAddr, $city, $stateId, $postcode, $countryId, 
                                $phone, $mobile,  $addAndLogin = true)
    {
        $hashed_password = PasswordHasher::Hash($password);
        
        //$shipping_region_id = Shipping::FindRegion($stateId);

        // Build the SQL query
        $sql = 'CALL customer_add(:gender, :first_name, :last_name, :email, :password,
            :street_address, :city, :state_id, :postcode, :country_id, 
            :phone, :mobile)';

        // Build the parameters array
        $params = array (':gender' => $gender, ':first_name' => $firstName, 
            ':last_name' => $lastName, ':email' => $email, ':password' => $hashed_password, 
	    ':street_address' => $streetAddr, ':city' => $city, ':state_id' => $stateId,  
	    ':postcode' => $postcode, ':country_id' => $countryId, 
	    ':phone' => $phone, ':mobile' => $mobile);

        // Execute the query and get the customer_id
        $customer_id = DatabaseHandler::GetOne($sql, $params);

        if ($addAndLogin) {
            $_SESSION['customer_id'] = $customer_id;
            $_SESSION['customer_first_name'] = $firstName;
            $_SESSION['customer_last_name'] = $lastName;
        }

        return $customer_id;
    }

    public static function Get($customerId = null)
    {
        if (is_null($customerId))
            $customerId = self::GetCurrentCustomerId();

        // Build the SQL query
        $sql = 'CALL customer_get_customer(:customer_id)';

        // Build the parameters array
        $params = array (':customer_id' => $customerId);

        // Execute the query and return the results
        return DatabaseHandler::GetRow($sql, $params);
    }
 
    public static function GetAll()
    {
        // Build the SQL query
        $sql = 'CALL customer_get_customers()';

        // Execute the query and return the results
        return DatabaseHandler::GetAll($sql);
    }

    public static function UpdateAccountDetails($gender, $firstName, $lastName, $nickName, $email, 
        $professionalStatus, $profession, $experienceYears, $customerId = null)
    {
        if (is_null($customerId))
            $customerId = self::GetCurrentCustomerId();

        // Build the SQL query
        $sql = 'CALL customer_update_account(:customer_id, :gender, :first_name, :last_name, 
            :nickname, :email, :professional_status, :profession, :experience_years)';

        // Build the parameters array
        $params = array (':customer_id' => $customerId, ':gender' => $gender, 
            ':first_name' => $firstName, ':last_name' => $lastName, ':nickname' => $nickName, 
            ':email' => $email, ':professional_status' => $professionalStatus, 
            ':profession' => $profession, ':experience_years' => $experienceYears);

        // Execute the query
        DatabaseHandler::Execute($sql, $params);
        
        $_SESSION['customer_first_name'] = $firstName;
        $_SESSION['customer_last_name'] = $lastName;
    }
    
    public static function ChangePassword($oldPassword, $newPassword, $customerId = null)
    {
        if (is_null($customerId))
            $customerId = self::GetCurrentCustomerId();

        $hashed_old_password = PasswordHasher::Hash($oldPassword);
        $hashed_new_password = PasswordHasher::Hash($newPassword);

        // Build the SQL query
        $sql = 'CALL customer_change_password(:customer_id, :old_password, 
            :new_password)';

        // Build the parameters array
        $params = array (':customer_id' => $customerId, 
            ':old_password' => $hashed_old_password, 
            ':new_password' => $hashed_new_password);

        // Execute the query
        return DatabaseHandler::GetOne($sql, $params);
    }
    
    public static function UpdateInvoiceDetails($companyName, $companyProfession,
        $companyAddress, $companyCity, $companyStateId, $companyPostcode, 
        $companyVatRegistration, $companyTaxOffice, $customerId = null)
    {
        if (is_null($customerId))
            $customerId = self::GetCurrentCustomerId();

        // Build the SQL query
        $sql = 'CALL customer_update_invoice_details(:customer_id, :company_name, 
            :company_profession, :company_address, :company_city, :company_state_id, 
            :company_postcode, :company_vat_registration, :company_tax_office)';

        // Build the parameters array
        $params = array (':customer_id' => $customerId, 
            ':company_name' => $companyName, 
            ':company_profession' => $companyProfession, 
            ':company_address' => $companyAddress, 
            ':company_city' => $companyCity, 
            ':company_state_id' => $companyStateId, 
            ':company_postcode' => $companyPostcode, 
            ':company_vat_registration' => $companyVatRegistration,
            ':company_tax_office' => $companyTaxOffice);

        // Execute the query
        DatabaseHandler::Execute($sql, $params);
    }

    public static function UpdateShippingDetails($streetAddr, $city,
        $stateId, $postcode, $countryId, $company, $phone, 
        $mobile, $customerId = null)
    {
        if (is_null($customerId))
            $customerId = self::GetCurrentCustomerId();

        $shipping_region_id = Shipping::FindRegion($stateId);

        // Build the SQL query
        $sql = 'CALL customer_update_address(:customer_id, :street_address,
            :city, :state_id, :postcode, :country_id, :shipping_region_id, 
            :company, :phone, :mobile)';

        // Build the parameters array
        $params = array (':customer_id' => $customerId,
            ':street_address' => $streetAddr, ':city' => $city,
            ':state_id' => $stateId, ':postcode' => $postcode,
            ':country_id' => $countryId, ':shipping_region_id' => $shipping_region_id, 
            ':company' => $company, ':phone' => $phone, ':mobile' => $mobile);

        // Execute the query
        DatabaseHandler::Execute($sql, $params);
    }

    public static function GetInvoiceDetails($customerId = null)
    {
        if (is_null($customerId))
            $customerId = self::GetCurrentCustomerId();

        // Build the SQL query
        $sql = 'CALL customer_get_invoice_details(:customer_id)';

        // Build the parameters array
        $params = array (':customer_id' => $customerId);

        // Execute the query
        return DatabaseHandler::GetRow($sql, $params);
    }

    public static function Remove($customerId)
    {
        // Build the SQL query
        $sql = 'CALL customer_delete_customer(:customer_id)';

        // Build the parameters array
        $params = array (':customer_id' => $customerId);

        // Execute the query
        return DatabaseHandler::GetOne($sql, $params);
    }

    public static function ResetPassword($customerId, $emailPassword = true)
    {
        // Generate a random password and hast it
        $password = self::RandomPassword();
        $hashed_password = PasswordHasher::Hash($password);

        // Build the SQL query
        $sql = 'CALL customer_reset_password(:customer_id, :password)';

        // Build the parameters array
        $params = array (':customer_id' => $customerId, 
            ':password' => $hashed_password);

        // Execute the query
        $email = DatabaseHandler::GetOne($sql, $params);

        // Email the new password 
        if ($emailPassword) {
            self::Email($email, "Password Reset", 
                "Your new password id " . $password);
        }
    }
    
    public static function GetAddressBook($customerId = null)
    {
        if (is_null($customerId))
            $customerId = self::GetCurrentCustomerId();
        
        // Build the SQL query
        $sql = 'CALL customer_get_address_book(:customer_id)';

        // Build the parameters array
        $params = array (':customer_id' => $customerId);

        // Execute the query and return the results
        return DatabaseHandler::GetAll($sql, $params);
    }

    public static function GetAddressBookEntry($addressBookId)
    {
        // Build the SQL query
        $sql = 'CALL customer_get_address_book_entry(:address_book_id)';

        // Build the parameters array
        $params = array (':address_book_id' => $addressBookId);

        // Execute the query and return the results
        return DatabaseHandler::GetRow($sql, $params);
    }

    public static function AddAddressBookEntry($gender, $firstName, $lastName, 
                                                $streetAddress, $company, $city, 
                                                $stateId, $postcode, $phone, $mobile, 
                                                $countryId, $customerId = null)
    {
        if (is_null($customerId))
            $customerId = self::GetCurrentCustomerId();

        $shipping_region_id = Shipping::FindRegion($stateId);
        
        // Build the SQL query
        $sql = 'CALL customer_add_address_book_entry(:customer_id, :gender, :first_name, 
                                                :last_name, :street_address, :company, 
                                                :city, :postcode, :state_id, :phone, :mobile, 
                                                :country_id, :shipping_region_id)';

        // Build the parameters array
        $params = array (':customer_id' => $customerId,
            ':gender' => $gender, ':first_name' => $firstName,
            ':last_name' => $lastName, ':street_address' => $streetAddress,
            ':company' => $company, 
            ':city' => $city, ':postcode' => $postcode, 
            ':state_id' => $stateId, ':phone' => $phone, 
            ':mobile' => $mobile, ':country_id' => $countryId,
            ':shipping_region_id' => $shipping_region_id);

        // Execute the query
        DatabaseHandler::GetOne($sql, $params);

        return $shipping_region_id;
    }
    
    public static function GetProductsPerPage($customerId = null)
    {
        if (!isset($_SESSION['products_per_page'])) {
            if (self::IsAuthenticated()) {
                $customer = self::Get();
                $_SESSION['products_per_page'] = 
                    ($customer['products_per_page']) ? $customer['products_per_page'] : PRODUCTS_PER_PAGE;
            } else 
                $_SESSION['products_per_page'] =  PRODUCTS_PER_PAGE;
        }
        
        return $_SESSION['products_per_page'];
    }
    
    public static function SetProductsPerPage($productsPerPage, $customerId = null)
    {
        if (is_null($customerId))
            $customerId = self::GetCurrentCustomerId();

        // Build the SQL query
        $sql = 'CALL customer_set_products_per_page(
            :customer_id, :products_per_page)';

        // Build the parameters array
        $params = array (':customer_id' => $customerId,
            ':products_per_page' => $productsPerPage);

        // Execute the query and return the results
        DatabaseHandler::Execute($sql, $params);
        
        $_SESSION['products_per_page'] = $productsPerPage;
    }

    public static function UpdateRecentlyViewedProducts($productId)
    {
        if (!isset($_SESSION['recently_viewed_products']))
            $_SESSION['recently_viewed_products'] = array();

        $recently_viewed_products = $_SESSION['recently_viewed_products'];

        if (in_array($productId, $recently_viewed_products)) {
            foreach ($recently_viewed_products as $key => $value) {
                if ($value == $productId) {
                    unset($recently_viewed_products[$key]);
                    $recently_viewed_products = array_values($recently_viewed_products);
                    array_push($recently_viewed_products, $productId);
                    break;
                }
            }
        } else if (count($recently_viewed_products) < MAX_RECENTLY_VIEWED_PRODUCTS) {
            array_push($recently_viewed_products, $productId);
        } else {
            array_shift($recently_viewed_products);
            array_push($recently_viewed_products, $productId);
        }

        $_SESSION['recently_viewed_products'] = $recently_viewed_products;
    }

    public static function IsPasswordRecoveryInfoValid($customerEmail, $recoverId)
    {
        $info = self::CheckLoginInfo($customerEmail);
        if (is_null($info['customer_id']))
            return false;
        
        // Build the SQL query
        $sql = 'CALL customer_password_recovery_isvalid(:customer_id, :password_recover_id)';

        // Build the parameters array
        $params = array (':customer_id' => $info['customer_id'],
            ':password_recover_id' => $recoverId);

        // Execute the query and return the results
        return DatabaseHandler::GetOne($sql, $params);
    }

    public static function GetByFacebookUid($uid)
    {
        // Build the SQL query
        $sql = 'CALL customer_get_by_facebook_uid(:fb_user_id)';

        // Build the parameters array
        $params = array (':fb_user_id' => $uid);

        // Execute the query and return the results
        return DatabaseHandler::GetRow($sql, $params);
    }
    
    public static function StartPasswordRecovery($customerId, $customerEmail)
    {
        // Get a unique recover ID
        $rid = md5(uniqid(rand(), true));

        // Build the SQL query
        $sql = 'CALL customer_recover_password_start(:customer_id, :password_recover_id)';

        // Build the parameters array
        $params = array (':customer_id' => $customerId,
            ':password_recover_id' => $rid);

        // Execute the query and return the results
        DatabaseHandler::Execute($sql, $params);

        //Create the Transport (this is the account of the mailer deamon)
        $transport = Swift_SmtpTransport::newInstance(SMTP_HOST, SMTP_PORT, SMTP_CRYPTO)
            ->setUsername(MAIL_SENDER)
            ->setPassword(MAIL_SENDER_PASS);

        $mailer = Swift_Mailer::newInstance($transport);                           
            
        $message = Swift_Message::newInstance()

            //Give the message a subject
            ->setSubject('Αίτηση ανάκτησης password στο marsellosconcrete.gr')

            ->setFrom(array(MAIL_SENDER => 'MarsellosConcrete Mailer Deamon'))

            //Set the To addresses with an associative array
            ->setTo(array($customerEmail => ''))

            //Give it a body
            ->setBody('<BR>Αν θέλετε να ανακτήσετε την πρόσβαση σας στο χώρο μελών του marsellosconcrete.gr,'.
                      '<BR>τότε πατήστε <a href="'. Link::ToRecoverPassword($rid, $customerEmail) .
                      '" target="_blank"><b><u>εδώ</u></b></a>, και ακολουθήστε τη διαδικασία για να ορίσετε ένα καινούριο κωδικό πρόσβασης.'.
                      '<BR><BR>Προσοχή : Το παρόν email ισχύει για 12 ώρες από τη στιγμή που ζητήσατε την υπενθύμιση του κωδικού πρόσβασης.'.
                      '<BR>Μετά τις 12 ώρες παύει να ισχύει το παρόν και θα πρέπει να επαναλάβετε τη διαδικασία από την αρχή.',
                      'text/html');

        try {
            $result = $mailer->send($message);
            return 0;
        } catch (Exception $e) {
            return -1;
        }
    }
    
    public static function PasswordRecoveryCompleted($customerId, $newPassword)
    {
        // Build the SQL query
        $sql = 'CALL customer_recover_password_end(:customer_id, :new_hashed_password)';

        // Build the parameters array
        $params = array (':customer_id' => $customerId,
            ':new_hashed_password' => PasswordHasher::Hash($newPassword));

        // Execute the query and return the results
        DatabaseHandler::Execute($sql, $params);
    }
}
?>
