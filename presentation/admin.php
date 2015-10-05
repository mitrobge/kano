<?php

class Admin {
    public $mSiteUrl;
    public $mSiteImages;
    public $mLanguages;
    public $mMenuCell = 'blank.tpl';
    public $mContentsCell = 'blank.tpl';

    public function __construct()
    {
        $this->mSiteUrl = Link::Build('','https');
        $this->mSiteImages = Link::Build('images/');
        $this->mLanguages = Language::GetAll(true);

        if (USE_SSL == 'yes' && getenv('HTTPS') != 'on') {
            header ('Location: https://' . getenv('SERVER_NAME') . 
                getenv('REQUEST_URI'));
            exit(1);
        }
    }

    public function init()
    {
        // Change the language
        if (isset($_POST['languageId']))
        {
            Language::Set($_POST['languageId']);
            header('Location: ' .
                htmlspecialchars_decode(
                    Link::Build(str_replace(
                        VIRTUAL_LOCATION, '', getenv('REQUEST_URI')))));
        }

        // If admin is not logged in, load the admin_login template
        if (!Administrator::IsAuthenticated()) {
            $this->mContentsCell = 'admin_login.tpl';
        } else {
            $this->mMenuCell = 'admin_menu.tpl';

            // if logging out ...
            if (isset($_GET['Page']) && $_GET['Page'] == 'Logout') {
                Administrator::Logout();
                header('Location: ' . Link::ToAdmin());
                exit(1);
            }
            
            // If Page is not explicitly set, assume the Categories page
            $admin_page = isset ($_GET['Page']) ? $_GET['Page'] : 'Categories';
            
            // Choose what admin page to load ...
            if ($admin_page == 'Categories' || $admin_page == 'Subcategories')
                $this->mContentsCell = 'admin_categories.tpl';
            else if ($admin_page == 'CategoryChildrenSorting')
                $this->mContentsCell = 'admin_category_sorting.tpl';
            else if ($admin_page == 'CategoryAttributes')
                $this->mContentsCell = 'admin_category_attributes.tpl';
            else if ($admin_page == 'CategoryOptions')
                $this->mContentsCell = 'admin_category_options.tpl';
            else if ($admin_page == 'Products')
                $this->mContentsCell = 'admin_surveys.tpl';
            else if ($admin_page == 'AddProduct')
                $this->mContentsCell = 'admin_product_add.tpl';
            else if ($admin_page == 'ProductDetails')
                $this->mContentsCell = 'admin_survey_details.tpl';
            else if ($admin_page == 'QuestionsDetails')
                $this->mContentsCell = 'admin_survey_questions.tpl';
            else if ($admin_page == 'ShoppingCarts')
                $this->mContentsCell = 'admin_carts.tpl';
            else if ($admin_page == 'Manufacturers')
                $this->mContentsCell = 'admin_manufacturers.tpl';
            else if ($admin_page == 'ManufacturerDetails')
                $this->mContentsCell = 'admin_manufacturer_details.tpl';
            else if ($admin_page == 'OrderDetails')
                $this->mContentsCell = 'admin_order_details.tpl';
            else if ($admin_page == 'Customers')
                $this->mContentsCell = 'admin_customers.tpl';
            else if ($admin_page == 'Stores')
                $this->mContentsCell = 'admin_stores.tpl';
            else if ($admin_page == 'StoreDetails')
                $this->mContentsCell = 'admin_store_details.tpl';
            else if ($admin_page == 'Administrators')
                $this->mContentsCell = 'admin_administrators.tpl';
            else if ($admin_page == 'AdministratorDetails')
                $this->mContentsCell = 'admin_administrator_details.tpl';
            else if ($admin_page == 'Reviews')
                $this->mContentsCell = 'admin_reviews.tpl';
            else if ($admin_page == 'Questions')
                $this->mContentsCell = 'admin_questions.tpl';
            else if ($admin_page == 'QuestionDetails')
                $this->mContentsCell = 'admin_question_details.tpl';
            else if ($admin_page == 'Reports')
                $this->mContentsCell = 'admin_reports.tpl';
            else if ($admin_page == 'Shipping')
                $this->mContentsCell = 'admin_shipping.tpl';
            else if ($admin_page == 'Promotion')
                $this->mContentsCell = 'admin_promotion.tpl';
            else if ($admin_page == 'BannerDetails')
                $this->mContentsCell = 'admin_banner_details.tpl';
            else if ($admin_page == 'ArticleDetails')
                $this->mContentsCell = 'admin_article_details.tpl';
            else if ($admin_page == 'Search' || $admin_page == 'SearchResults')
                $this->mContentsCell = 'admin_search.tpl';
            else if ($admin_page == 'Sponsors')
                $this->mContentsCell = 'admin_sponsors.tpl';
            else if ($admin_page == 'SponsorDetails')
                $this->mContentsCell = 'admin_sponsor_details.tpl';
            else if ($admin_page == 'Newsletter')
                $this->mContentsCell = 'admin_newsletter.tpl';
            else if ($admin_page == 'Files')
                $this->mContentsCell = 'admin_files.tpl';
            else if ($admin_page == 'Promotion')
                $this->mContentsCell = 'admin_promotion.tpl';
            else if ($admin_page == 'Accreditations')
                $this->mContentsCell = 'admin_accreditations.tpl';
            else if ($admin_page == 'Terms')
                $this->mContentsCell = 'admin_terms.tpl';
            else if ($admin_page == 'TuvTimes')
                $this->mContentsCell = 'admin_tuvtimes.tpl';
            else if ($admin_page == 'TuvTimesDetails')
                $this->mContentsCell = 'admin_tuvtimes_details.tpl';
            else if ($admin_page == 'Organization')
                $this->mContentsCell = 'admin_organization.tpl';
            else if ($admin_page == 'OrganizationDetails')
                $this->mContentsCell = 'admin_organization_details.tpl';
            else if ($admin_page == 'Briefing')
                $this->mContentsCell = 'admin_briefing.tpl';
            else if ($admin_page == 'BriefingDetails')
                $this->mContentsCell = 'admin_briefing_details.tpl';
            else if ($admin_page == 'EducationForms')
                $this->mContentsCell = 'admin_education_forms.tpl';
            else if ($admin_page == 'EducationFormsDetails')
                $this->mContentsCell = 'admin_education_forms_details.tpl';
            else if ($admin_page == 'EducationSeminars')
                $this->mContentsCell = 'admin_education_seminars.tpl';
        }
    }
}
?>
