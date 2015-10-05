<?php
class AdminMenu
{
    public $mLinkToCategoriesAdmin = null;
    public $mLinkToStoresAdmin = null;
    public $mLinkToFilesAdmin = null;
    public $mLinkToBriefing = null;
    public $mLinkToAccreditationsAdmin = null;
    public $mLinkToEducationFormsAdmin = null;
    public $mLinkToEducationSeminars = null;
    public $mLinkToTermsAdmin = null;
    public $mLinkToOrganizationAdmin = null;
    public $mLinkToCustomersAdmin = null;
    public $mLinkToManufacturersAdmin = null;
    public $mLinkToAdministratorsAdmin = null;
    public $mLinkToReviewsAdmin = null;
    public $mLinkToQuestionsAdmin = null;
    public $mLinkToPromotionAdmin = null;
    public $mLinkToSponsorsAdmin = null;
    public $mLinkToNewsletterAdmin = null;
    public $mLinkToReportsAdmin = null;
    public $mLinkToShippingAdmin = null;
    public $mLinkToMyAccount = null;
    public $mLinkToSearch = null;
    public $mLinkToLogout = null;
    
    public function __construct()
    {
    }

    public function init()
    {
        $this->mLinkToCategoriesAdmin = Link::ToAdmin();
        $this->mLinkToFilesAdmin = Link::ToFilesAdmin();
        $this->mLinkToAdministratorsAdmin = Link::ToAdministratorsAdmin();
        $this->mLinkToMyAccount = Link::ToAdministratorDetailsAdmin(
            Administrator::GetLoggedAdministratorId());
        $this->mLinkToLogout = Link::ToLogout();
    }
}
?>
