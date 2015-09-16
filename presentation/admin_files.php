<?php

define('UPLOAD_FILE', 'upload');
define('DELETE_FILE', 'delete_file');

class AdminFiles
{
    public $mLinkToFilesAdmin;
    public $mFiles;
    public $mFileSize;
    
    private $__mActionedCategoryId;
    private $__mDeletedFileId;
    private $__mAction;
    
    public function filesize_formatted($path)
        {
                $size = filesize($path);
                    $units = array( 'B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB');
                    $power = $size > 0 ? floor(log($size, 1024)) : 0;
                        return number_format($size / pow(1024, $power), 2, '.', ',') . ' ' . $units[$power];
        }


    public function __construct()
    {
        if (!Administrator::HasPermission('ADMIN_FILES')) {
            $application = new Application();
            $application->display('not_authorized.tpl');
            exit(0);
        }
      
        foreach ($_POST as $key => $value) {
            if (substr ($key, 0, 6) == 'submit') {
                $last_underscore = strrpos ($key, '_');
                $this->__mAction = substr ($key, strlen('submit_'), 
                    $last_underscore - strlen('submit_'));
                if ($this->__mAction == DELETE_FILE)
                    $this->__mDeletedFileId = (int) substr ($key, $last_underscore + 1);
                break;
            } 
        }
    }

    public function init()
    {

        /* Make Links */
        $this->mLinkToFilesAdmin =
            Link::ToFilesAdmin();

        $this->mFiles = Files::GetFiles();

            for ($i = 0; $i < count($this->mFiles); $i++) { // TODO: js validation of input (for all languages)
                $this->mFiles[$i]['filesize'] = AdminFiles::filesize_formatted('content/'.$this->mFiles[$i]['filename']);
                $this->mFiles[$i]['filetype'] = mime_content_type('content/'.$this->mFiles[$i]['filename']);
                $this->mFiles[$i]['imagesize'] = getimagesize('content/'.$this->mFiles[$i]['filename']);
            }


        switch ($this->__mAction) {
        case UPLOAD_FILE:
            /* Check whether we have write permission on the images folder */
            if (!is_writeable(SITE_ROOT . '/content/')) {
                echo "Can't write to the content folder";
                exit();
            }
            /* move file from its temporary location to the images folder, 
             * and update product information in the database */
            if ($_FILES['image_file']['error'] == UPLOAD_ERR_OK) {
                move_uploaded_file($_FILES['image_file']['tmp_name'],
                        SITE_ROOT . '/content/' . 
                        $_FILES['image_file']['name']);
                Files::AddFile($_FILES['image_file']['name']);
            } 
            if (!$has_error) {
                header('Location: ' .
                    htmlspecialchars_decode(
                        $this->mLinkToFilesAdmin));
                exit(0);
            }
            break;                
        case DELETE_FILE:
            Files::DeleteFile($this->__mDeletedFileId);
            Link::Redirect(Link::ToFilesAdmin());
            exit();
        default:
            break;
        }
        
    }
}
?>
