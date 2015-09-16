<?php

class Files       
{
    public static function CheckFileExists($fileName)
    {
        // Build the SQL query
        $sql = 'CALL check_if_file_exists(:filename)';

        // Build the parameters array
        $params = array (':filename' => $fileName);

        // Execute the query and return the results
        return DatabaseHandler::GetOne($sql, $params);
        
    }
    public static function AddFile($fileName)
    {
        // Build the SQL query
        $sql = 'CALL files_upload_file(:filename)';
        
        // Build the parameters array
        $params = array (':filename' => $fileName);

        // Execute the query and return the results
        return DatabaseHandler::Execute($sql, $params);
        
    }
    
    public static function GetFiles()
    {
        // Build the SQL query
        $sql = 'CALL files_get_files()';
        
        // Build the parameters array
        $params = array ();

        // Execute the query and return the results
        return DatabaseHandler::GetAll($sql, $params);
    }
    
    public static function DeleteFile($fileNameId)
    {
        // Build the SQL query
        $sql = 'CALL files_delete_file(:file_id)';

        // Build the parameters array
        $params = array (':file_id' => $fileNameId);

        // Execute the query and return the results
        DatabaseHandler::Execute($sql, $params);
    }
    


}

?>

