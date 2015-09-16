<?php

class CustomerAccount 
{
    public $mStates;
    public $mCountries;
    public $mCustomer = array(
        'gender' => '', 
        'first_name' => '', 
        'last_name' => '', 
        'nickname' => '', 
        'email' => '', 
        'professional_status' => '', 
	    'profession' => '',
	    'experience_years' => '',
        'street_address' => '', 
        'company' => '', 
        'city' => '', 
        'postcode' => '',
        'state_id' => '', 
        'phone' => '', 
        'mobile' => '', 
        'country_id' => '', 
        'company_name' => '',
        'company_profession' => '',
        'company_address' => '',
        'company_city' => '',
        'company_state_id' => '',
        'company_postcode' => '',
        'company_vat_registration' => '',
        'company_tax_office' => '',
    );
    
    /* Error variables */
    public $mGenderError = false;
    public $mFirstNameError = false;
    public $mLastNameError = false;
    public $mEmailAlreadyTaken = false;
    public $mEmailError = false;
    public $mEmailInvalid = false;
    public $mPasswordError = false;
    public $mOldPasswordError = false;
    public $mPasswordConfirmError = false;
    public $mPasswordMatchError = false;
    public $mPasswordTooShort = false;
    public $mProfessionalStatusError = false;
    public $mProfessionError = false;
    public $mExperienceYearsError = false;
    public $mStreetAddressError = false;
    public $mCityError = false;
    public $mStateError = false;
    public $mPostcodeError = false;
    public $mCountryError = false;
    public $mPhoneError = false;
    public $mMobileError = false;
    public $mCompanyNameError = false; 
    public $mCompanyAddressError = false; 
    public $mCompanyCityError = false; 
    public $mCompanyStateError = false; 
    public $mCompanyPostcodeError = false; 
    public $mCompanyProfessionError = false; 
    public $mCompanyVATRegistrationError = false; 
    public $mCompanyTaxOfficeError = false;
    public $mProfessionalStatusOptions;
    public $mExperienceYearsOptions;

    public $mLinkToAccountDetails;
    public $mLinkToChangePassword;
    public $mLinkToWishList;
    public $mLinkToAccountUpdate;
    public $mLinkToOrdersHistory;
    public $mLinkToRecentlyViewed;

    public $mPasswordChange = false;
    public $mPassword = '';
    public $mOldPassword = '';
    public $mConfirmedPassword = '';

    private function ValidatePassword()
    {
        $errors = 0;

        if (isset($_POST['pass_change'])) {
            $this->mPasswordChange = true;
        
            if (empty($_POST['customer_old_password'])) 
            {
                $errors++;
                $this->mOldPasswordError = true;
            } 
            else 
            {
                $this->mOldPassword = $_POST['customer_old_password'];
            }

            if (empty($_POST['customer_password'])) 
            {
                $errors++;
                $this->mPasswordError = true;
            } 
            else 
            {
                /* Check for minimum password requirements */
                if (strlen ($_POST['customer_password']) < 8) 
                {
                    $errors++;
                    $this->mPasswordTooShort = true;
                } 
                else 
                    $this->mPassword = $_POST['customer_password'];
            }
            
            if (empty($_POST['customer_confirmed_password'])) 
            {
                $errors++;
                $this->mPasswordConfirmError = true;
            } 
            else 
            {
                /* Check if re-typing password matches password field */
                if (strcmp($_POST['customer_password'], 
                    $_POST['customer_confirmed_password'])) 
                {
                    $errors++;
                    $this->mPasswordMatchError = true;
                } else {
                    $this->mConfirmedPassword = 
                        $_POST['customer_confirmed_password'];
                }
            }
        }

        return $errors;
    }
    
    private function ValidateAccountDetails()
    {
        $errors = 0;

        if (isset($_POST['customer_gender']))
            $this->mCustomer['gender'] = $_POST['customer_gender'];
        if (isset($_POST['customer_first_name']))
            $this->mCustomer['first_name'] = $_POST['customer_first_name'];
        if (isset($_POST['customer_last_name']))
            $this->mCustomer['last_name'] = $_POST['customer_last_name'];
        if (isset($_POST['customer_email']))
            $this->mCustomer['email'] = $_POST['customer_email'];
        if (isset($_POST['customer_professional_status']))
            $this->mCustomer['professional_status'] = $_POST['customer_professional_status'];
        if (isset($_POST['customer_profession']))
            $this->mCustomer['profession'] = $_POST['customer_profession'];
        if (isset($_POST['customer_experience_years']))
            $this->mCustomer['experience_years'] = $_POST['customer_experience_years'];
        
        /* Validation of customer details information */
        if (empty($this->mCustomer['gender'])) 
        {
            $errors++;
            $this->mGenderError = true;
        } 
        if (strlen($this->mCustomer['first_name']) < CUSTOMER_FIRST_NAME_MINLEN) 
        {
            $errors++;
            $this->mFirstNameError = true;
        } 
        
        if (strlen($this->mCustomer['last_name']) < CUSTOMER_LAST_NAME_MINLEN) 
        {
            $errors++;
            $this->mLastNameError = true;
        } 
        
        if (empty($this->mCustomer['email'])) {
            $errors++;
            $this->mEmailError = true;
        } else {
            if (!preg_match('/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/i', 
                $this->mCustomer['email'])) 
            {
                $this->mEmailInvalid = true;
                $errors++;
            } 
            else 
            { 
                /* Check if we have any customer with submitted email... */
                $customer_read = Customer::CheckLoginInfo($this->mCustomer['email']);
                if (!empty ($customer_read['customer_id']) && 
                    $customer_read['customer_id'] != Customer::GetCurrentCustomerId()) 
                {
                    $this->mEmailAlreadyTaken = true;
                    $errors++;
                }
            }
        }
        
        if (empty($this->mCustomer['professional_status'])) {
            $errors++;
            $this->mProfessionalStatusError = true;
        }
        
        if (empty($this->mCustomer['profession'])) {
            $errors++;
            $this->mProfessionError = true;
        }
        
        if (empty($this->mCustomer['experience_years'])) {
            $errors++;
            $this->mExperienceYearsError = true;
        }
        
        return $errors; 
    } 

    private function ValidateShippingDetails()
    {
        $errors = 0;

        if (isset($_POST['customer_street_address']))
            $this->mCustomer['street_address'] = $_POST['customer_street_address'];
        if (isset($_POST['customer_company']))
            $this->mCustomer['company'] = $_POST['customer_company'];
        if (isset($_POST['customer_city']))
            $this->mCustomer['city'] = $_POST['customer_city'];
        if (isset($_POST['customer_state_id']))
            $this->mCustomer['state_id'] = $_POST['customer_state_id'];
        if (isset($_POST['customer_postcode']))
            $this->mCustomer['postcode'] = $_POST['customer_postcode'];
        if (isset($_POST['customer_phone']))
            $this->mCustomer['phone'] = $_POST['customer_phone'];
        if (isset($_POST['customer_mobile']))
            $this->mCustomer['mobile'] = $_POST['customer_mobile'];
        if (isset($_POST['customer_country_id']))
            $this->mCustomer['country_id'] = $_POST['customer_country_id'];
        
        /* Validation of address information */
        if (!empty($this->mCustomer['street_address']) || 
            !empty($this->mCustomer['city']) ||
            !empty($this->mCustomer['state_id']) ||
            !empty($this->mCustomer['postcode']) ||
            !empty($this->mCustomer['phone']) ||
            !empty($this->mCustomer['mobile']))
        {

            if (strlen($this->mCustomer['street_address']) < CUSTOMER_STREET_ADDR_MINLEN) 
            {
                $errors++;
                $this->mStreetAddressError = true;
            } 
            
            if (strlen($this->mCustomer['city']) < CUSTOMER_CITY_MINLEN) 
            {
                $errors++;
                $this->mCityError = true;
            } 
            
            if (empty($this->mCustomer['state_id'])) 
            {
                $errors++;
                $this->mStateError = true;
            } 
            
            if (strlen($this->mCustomer['postcode']) < CUSTOMER_POSTCODE_MINLEN) 
            {
                $errors++;
                $this->mPostcodeError = true;
            } 
            
            if (strlen($this->mCustomer['phone']) < CUSTOMER_PHONE_MINLEN) 
            {
                $errors++;
                $this->mPhoneError = true;
            } 
            
            if (strlen($this->mCustomer['mobile']) < CUSTOMER_MOBILE_MINLEN) 
            {
                $errors++;
                $this->mMobileError = true;
            } 
            
            if (empty($this->mCustomer['country_id'])) 
            {
                $errors++;
                $this->mCountryError = true;
            }
        } 
        
        return $errors; 
    } 

    private function ValidateInvoiceDetails()
    {
        $errors = 0;

        if (isset($_POST['customer_company_name']))
            $this->mCustomer['company_name'] = $_POST['customer_company_name'];
        if (isset($_POST['company_profession']))
            $this->mCustomer['company_profession'] = $_POST['company_profession'];
        if (isset($_POST['customer_company_address']))
            $this->mCustomer['company_address'] = $_POST['customer_company_address'];
        if (isset($_POST['customer_company_city']))
            $this->mCustomer['company_city'] = $_POST['customer_company_city'];
        if (isset($_POST['customer_company_state_id']))
            $this->mCustomer['company_state_id'] = $_POST['customer_company_state_id'];
        if (isset($_POST['customer_company_postcode']))
            $this->mCustomer['company_postcode'] = $_POST['customer_company_postcode'];
        if (isset($_POST['company_vat_registration']))
            $this->mCustomer['company_vat_registration'] = $_POST['company_vat_registration'];
        if (isset($_POST['company_tax_office']))
            $this->mCustomer['company_tax_office'] = $_POST['company_tax_office'];
        
        /* Validate Invoice details */
        if (!empty($this->mCustomer['company_name']) || 
            !empty($this->mCustomer['company_profession']) ||
            !empty($this->mCustomer['company_address']) ||
            !empty($this->mCustomer['company_city']) ||
            !empty($this->mCustomer['company_state_id']) ||
            !empty($this->mCustomer['company_postcode']) ||
            !empty($this->mCustomer['company_vat_registration']) ||
            !empty($this->mCustomer['company_tax_office']))
        {
            if (empty($this->mCustomer['company_name'])) 
            {
                $errors++;
                $this->mCompanyNameError = true; 
            } 
            
            if (empty($this->mCustomer['company_profession'])) 
            {
                $errors++;
                $this->mCompanyProfessionError = true; 
            }
            
            if (strlen($this->mCustomer['company_address']) < CUSTOMER_STREET_ADDR_MINLEN) 
            {
                $errors++;
                $this->mCompanyAddressError = true; 
            } 
            
            if (strlen($this->mCustomer['company_city']) < CUSTOMER_CITY_MINLEN) 
            {
                $errors++;
                $this->mCompanyCityError = true;
            } 
            
            if (empty($this->mCustomer['company_state_id'])) 
            {
                $errors++;
                $this->mCompanyStateError = true;
            } 
            
            if (strlen($this->mCustomer['company_postcode']) < CUSTOMER_POSTCODE_MINLEN) 
            {
                $errors++;
                $this->mCompanyPostcodeError = true;
            } 

            if (!Utils::CheckVATRegistrationNumber($this->mCustomer['company_vat_registration']))
            {
                $errors++;
                $this->mCompanyVATRegistrationError = true; 
            } 
            
            if (empty($this->mCustomer['company_tax_office'])) 
            {
                $errors++;
                $this->mCompanyTaxOfficeError = true; 
            } 

            $this->__mInvoiceProvided = true;
        }

        return $errors; 
    } 

    public function GetCountryName($countryId)
    {
        $country = Utils::GetCountry($countryId);

        if (is_null($country))
            return null;

        return $country['name'];
    }
    
    public function __construct()
    {
        /* If user is not logged on, redirect to register page */
        if (!Customer::IsAuthenticated()) {
            header('Location: ' .
                htmlspecialchars_decode(
                    Link::ToRegisterCustomer()));
            exit(0);
        }

        /* Make links */
        $this->mLinkToChangePassword = Link::ToCustomerAccount(true);
        $this->mLinkToAccountDetails = Link::ToCustomerAccount(); 
        //$this->mLinkToWishList = Link::ToWishList();
        $this->mLinkToOrdersHistory = Link::ToCustomerOrders();
        $this->mLinkToRecentlyViewed = Link::ToRecentlyViewed();
        if (isset($_GET['ChangePassword']))
            $this->mLinkToAccountUpdate = $this->mLinkToChangePassword;
        else 
            $this->mLinkToAccountUpdate = $this->mLinkToAccountDetails;
    }

    public function init()
    {  
        /* Get customer id */
        $customerId = Customer::GetCurrentCustomerId();

        /* Get customer account details */
        $this->mCustomer = Customer::Get($customerId);
        
        if (isset ($_POST['submit_customer_update'])) {
            /* Validate user input */
            $errors1 = $this->ValidateAccountDetails();
            $errors2 = $this->ValidateShippingDetails();
            $errors3 = $this->ValidateInvoiceDetails();
            $errors4 = $this->ValidatePassword();
            
            if ($errors1 == 0 && $errors2 == 0 && $errors3 == 0 && $errors4 == 0)
            {
                /* Update basic information */
                Customer::UpdateAccountDetails($this->mCustomer['gender'], 
                    $this->mCustomer['first_name'], $this->mCustomer['last_name'], 
                    $this->mCustomer['nickname'], $this->mCustomer['email'], 
                    $this->mCustomer['professional_status'], $this->mCustomer['profession'], 
                    $this->mCustomer['experience_years'], $customerId);
                /* Update address information */
                Customer::UpdateShippingDetails($this->mCustomer['street_address'],
                    $this->mCustomer['city'], $this->mCustomer['state_id'], 
                    $this->mCustomer['postcode'], $this->mCustomer['country_id'], 
                    $this->mCustomer['company'], $this->mCustomer['phone'], 
                    $this->mCustomer['mobile'], $customerId);
                /* Update invoice information */
                Customer::UpdateInvoiceDetails($this->mCustomer['company_name'], 
                    $this->mCustomer['company_profession'], $this->mCustomer['company_address'], 
                    $this->mCustomer['company_city'], $this->mCustomer['company_state_id'], 
                    $this->mCustomer['company_postcode'],  $this->mCustomer['company_vat_registration'], 
                    $this->mCustomer['company_tax_office'], $customerId);
                if ($this->mPasswordChange) {
                    if (!Customer::ChangePassword($this->mOldPassword, $this->mPassword))
                        $this->mOldPasswordError = true;
                }
                if (!isset($_GET['AjaxReq']) && !$this->mOldPasswordError) {
                    Link::Redirect(Link::ToCustomerAccount());
                    exit();
                }
            }
        } 
        
        /* Get countries */
        $this->mCountries = Utils::GetCountries();    
        
        /* Get states */
        $this->mStates = Utils::GetStates();
        
        /* Get available professional status options */
        $this->mProfessionalStatusOptions = Customer::$mProfessionalStatusOptions;
        
        /* Get available experience years options */
        $this->mExperienceYearsOptions = Customer::$mExperienceYearsOptions;
    }
}

?>
