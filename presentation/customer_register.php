<?php

class CustomerRegister
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
        'company_address' => '',
        'company_profession' => '',
        'vat_registration' => '',
        'tax_office' => '',
    );

    /* Error variables */
    public $mGenderError = false;
    public $mFirstNameError = false;
    public $mLastNameError = false;
    public $mEmailAlreadyTaken = false;
    public $mEmailError = false;
    public $mEmailInvalid = false;
    public $mPasswordError = false;
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
    public $mCompanyProfessionError = false; 
    public $mVATRegistrationError = false; 
    public $mTaxOfficeError = false;
    public $mProfessionalStatusOptions;
    public $mExperienceYearsOptions;

    /* Constants */
    public $mFirstNameMinLen = CUSTOMER_FIRST_NAME_MINLEN; 
    public $mLastNameMinLen = CUSTOMER_LAST_NAME_MINLEN; 
    public $mStreetAddressMinLen = CUSTOMER_STREET_ADDR_MINLEN;
    public $mCityMinLen = CUSTOMER_CITY_MINLEN;
    public $mStateMinLen = CUSTOMER_STATE_MINLEN;
    public $mPostCodeMinLen = CUSTOMER_POSTCODE_MINLEN;
    public $mPhoneMinLen = CUSTOMER_PHONE_MINLEN;
    public $mMobileMinLen = CUSTOMER_MOBILE_MINLEN;

    public $mLinkToCustomerRegister;

    private $__mPassword = '';
    private $__mConfirmedPassword = '';

    private $__mInvoiceProvided = false;

    public function ValidateUserInput()
    {
        $errors = 0;

        if (isset($_POST['customer_gender']))
            $this->mCustomer['gender'] = $_POST['customer_gender'];
        if (isset($_POST['customer_first_name']))
            $this->mCustomer['first_name'] = $_POST['customer_first_name'];
        if (isset($_POST['customer_last_name']))
            $this->mCustomer['last_name'] = $_POST['customer_last_name'];
        if (isset($_POST['customer_nickname']))
            $this->mCustomer['nickname'] = $_POST['customer_nickname'];
        if (isset($_POST['customer_email']))
            $this->mCustomer['email'] = $_POST['customer_email'];
        if (isset($_POST['customer_professional_status']))
            $this->mCustomer['professional_status'] = $_POST['customer_professional_status'];
        if (isset($_POST['customer_profession']))
            $this->mCustomer['profession'] = $_POST['customer_profession'];
        if (isset($_POST['customer_experience_years']))
            $this->mCustomer['experience_years'] = $_POST['customer_experience_years'];
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
        if (isset($_POST['customer_company_name']))
            $this->mCustomer['company_name'] = $_POST['customer_company_name'];
        if (isset($_POST['customer_company_address']))
            $this->mCustomer['company_address'] = $_POST['customer_company_address'];
        if (isset($_POST['company_profession']))
            $this->mCustomer['company_profession'] = $_POST['company_profession'];
        if (isset($_POST['customer_vat_registration']))
            $this->mCustomer['vat_registration'] = $_POST['customer_vat_registration'];
        if (isset($_POST['customer_tax_office']))
            $this->mCustomer['tax_office'] = $_POST['customer_tax_office'];
        
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
                $this->__mPassword = $_POST['customer_password'];
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
                $this->__mConfirmedPassword = 
                    $_POST['customer_confirmed_password'];
            }
        }
        
        /* Validation of address information */
        /*
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
         */
        
        
        /* Validate Invoice details */
        /*
        if (!empty($this->mCustomer['company_name']) || 
            !empty($this->mCustomer['company_address']) ||
            !empty($this->mCustomer['company_profession']) ||
            !empty($this->mCustomer['vat_registration']) ||
            !empty($this->mCustomer['tax_office']))
        {
            if (empty($this->mCustomer['company_name'])) 
            {
                $errors++;
                $this->mCompanyNameError = true; 
            } 
            
            if (strlen($this->mCustomer['company_address']) < CUSTOMER_STREET_ADDR_MINLEN) 
            {
                $errors++;
                $this->mCompanyAddressError = true; 
            } 
            
            if (empty($this->mCustomer['company_profession'])) 
            {
                $errors++;
                $this->mCompanyProfessionError = true; 
            }

            if (!Utils::CheckVATRegistrationNumber($this->mCustomer['vat_registration']))
            {
                $errors++;
                $this->mVATRegistrationError = true; 
            } 
            
            if (empty($this->mCustomer['tax_office'])) 
            {
                $errors++;
                $this->mTaxOfficeError = true; 
            } 

            $this->__mInvoiceProvided = true;
        }
         */

        return $errors; 
    } 

    public function __construct()
    {
        /* If user is logged on, redirect to account page */
        if (Customer::IsAuthenticated()) {
            header('Location: ' .
                htmlspecialchars_decode(
                    Link::ToCustomerAccount()));
            exit(0);
        }

        $this->mLinkToCustomerRegister = Link::ToRegisterCustomer();
    }

    public function init()
    { 
        if (isset ($_POST['submit_customer_register']))
        {
            /* Validate POST data */
            $errors = $this->ValidateUserInput();


            if ($errors == 0)
            {
                /* Add Customer */
                $customer_id = Customer::Add($this->mCustomer['gender'], 
                    $this->mCustomer['first_name'], $this->mCustomer['last_name'], 
                    $this->mCustomer['email'], 
                    $this->__mPassword,  
		            $this->mCustomer['street_address'], $this->mCustomer['city'], 
		            $this->mCustomer['state_id'], $this->mCustomer['postcode'], 
		            $this->mCustomer['country_id'], $this->mCustomer['company'], 
		            $this->mCustomer['phone'], $this->mCustomer['mobile']);

                if ($this->__mInvoiceProvided)
                {
                    Customer::UpdateInvoiceDetails($this->mCustomer['company_name'], 
                        $this->mCustomer['company_address'], $this->mCustomer['company_profession'], 
                        $this->mCustomer['vat_registration'], $this->mCustomer['tax_office'],  
                        $customer_id);
                }

                /* Redirect to home page */
                Link::Redirect(Link::ToIndex());
                exit;
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
