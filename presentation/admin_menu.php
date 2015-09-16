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
        $this->mLinkToStoresAdmin = Link::ToStoresAdmin();
        $this->mLinkToFilesAdmin = Link::ToFilesAdmin();
        $this->mLinkToBriefingAdmin = Link::ToBriefingAdmin();
        $this->mLinkToAccreditationsAdmin = Link::ToAccreditationsAdmin();
        $this->mLinkToEducationFormsAdmin = Link::ToEducationFormsAdmin();
        $this->mLinkToEducationSeminarsAdmin = Link::ToEducationSeminarsAdmin();
        $this->mLinkToTermsAdmin = Link::ToTermsAdmin();
        $this->mLinkToTuvTimesAdmin = Link::ToTuvTimesAdmin();
        $this->mLinkToOrganizationAdmin = Link::ToOrganizationAdmin();
        $this->mLinkToManufacturersAdmin = Link::ToManufacturersAdmin();
        $this->mLinkToAdministratorsAdmin = Link::ToAdministratorsAdmin();
        $this->mLinkToReviewsAdmin = Link::ToReviewsAdmin();
        $this->mLinkToQuestionsAdmin = Link::ToQuestionsAdmin();
        $this->mLinkToPromotionAdmin = Link::ToPromotionAdmin();
        $this->mLinkToSponsorsAdmin = Link::ToSponsorsAdmin();
        $this->mLinkToNewsletterAdmin = Link::ToNewsletterAdmin();
        $this->mLinkToReportsAdmin = Link::ToReportsAdmin();
        $this->mLinkToShippingAdmin = Link::ToShippingAdmin();
        $this->mLinkToMyAccount = Link::ToAdministratorDetailsAdmin(
            Administrator::GetLoggedAdministratorId());
        $this->mLinkToSearch = Link::ToSearchAdmin();
        $this->mLinkToLogout = Link::ToLogout();
    }
}
?>
