<?php

class AdminSurveys
{
    public $mPageNo = 1;
    public $mrTotalPages;
    public $mLinkToBack;
    public $mCategoryName;
    public $mStoreName;
    public $mProducts;
    public $mLinkToNextPage;
    public $mLinkToPreviousPage;
    public $mLinkToAddProduct;
    public $mLinkToCategories;
    public $mProductsPages = array();

    // Private attributes
    private $__mCategoryId = null;
    private $__mUniqueCategoryId = null;
    private $__mStoreId = null;

    public function ProductDetailsLink($productId)
    {
        return Link::ToProductDetailsAdmin($productId, 
                    $this->__mStoreId, $this->__mCategoryId);
    }
    
    public function ProductQuestionsLink($productId)
    {
        return Link::ToSurveyQuestionsAdmin($productId, 
                    $this->__mStoreId, $this->__mCategoryId);
    }

    public function __construct()
    {
        if (!Administrator::HasPermission('ADMIN_CATALOG')) {
            $application = new Application();
            $application->display('not_authorized.tpl');
            exit(0);
        }
        
        if (isset ($_GET['CategoryId']))
            $this->__mCategoryId = (int)$_GET['CategoryId'];
        
        if (isset ($_GET['UniqueCategoryId']))
            $this->__mUniqueCategoryId = (int)$_GET['UniqueCategoryId'];
        
        if (isset ($_GET['StoreId']))
            $this->__mStoreId = (int)$_GET['StoreId'];

        if (!isset ($_GET['CategoryId']) && !isset ($_GET['StoreId']))
            trigger_error('Neither CategoryId nor StoreId is set');
        
        // Get Page number from query string casting it to int
		if (isset ($_GET['PageNo']))
            $this->mPageNo = (int)$_GET['PageNo'];

        $this->mLinkToAddProduct = 
            Link::ToProductAddAdmin($this->__mCategoryId);

        $this->mLinkToCategories =
            Link::ToCategoriesAdmin();
        
        if (!is_null($this->__mCategoryId) && is_null($this->__mStoreId))
            $this->mLinkToBack = Link::ToCategoriesAdmin();
        else if (is_null($this->__mCategoryId) && !is_null($this->__mStoreId))
            $this->mLinkToBack = Link::ToStoresAdmin();
        else
            echo 'Not implemented yet';
    }

    public function init()
    {
        if (!is_null($this->__mCategoryId))
            $this->mCategoryName = Surveys::GetCategoryName($this->__mCategoryId);
        
        if (!is_null($this->__mStoreId))
            $this->mStoreName = Stores::GetName($this->__mStoreId);
 
        $this->mProducts = Surveys::GetSurveys(
            $this->__mCategoryId, null);

    	/* If there are subpages of products, display navigation controls */
		if ($this->mrTotalPages > 1) {
            /* Build the Next link */
			if ($this->mPageNo < $this->mrTotalPages) {
                $this->mLinkToNextPage = Link::ToProductsAdmin(
                    $this->__mStoreId, $this->__mCategoryId, $this->mPageNo + 1);
			}

            /* Build the Previous link */
			if ($this->mPageNo > 1) {
                $this->mLinkToPreviousPage = Link::ToProductsAdmin(
                    $this->__mStoreId, $this->__mCategoryId, $this->mPageNo - 1);
			}

            /* Build the pages links */
			for ($i = 1; $i <= $this->mrTotalPages; $i++) {
                $this->mProductsPages[] = Link::ToProductsAdmin(
                    $this->__mStoreId, $this->__mCategoryId, $i);
			}
		}
    }
}

?>
