<?php

// Database Queries

class Language 
{
    private static $__mLangId;
    private static $__mLangName;
    private static $__mEnLangId;

    public static function Set($langName)
    {
        $language = self::GetByName($langName);
        $_SESSION['langId'] = $language['language_id'];
        $_SESSION['langName'] = $language['language_name'];
        self::$__mLangId = $_SESSION['langId'];
        self::$__mLangName = $_SESSION['langName'];
    }

    public static function Get()
    {
        if (!isset(self::$__mLangId))
        {
            if (!isset($_SESSION['langId']))
            {
                $language = self::GetByName('gr');
                $_SESSION['langId'] = $language['language_id'];
                $_SESSION['langName'] = $language['language_name'];
            }
            self::$__mLangId = $_SESSION['langId'];
            self::$__mLangName = $_SESSION['langName'];
        }
        return self::$__mLangId;
    }
    
    public static function GetName()
    {
        self::Get();
        return self::$__mLangName;
    }
    
    public static function GetEn()
    {
        if (!isset(self::$__mEnLangId))
        {
            if (!isset($_SESSION['en_language_id']))
            {
                $language = self::GetByName('en');
                $_SESSION['en_language_id'] = $language['language_id'];
            }
            self::$__mEnLangId = $_SESSION['en_language_id'];

        }
        return self::$__mEnLangId;
    }

    public static function GetById($langId)
    {
        // Build SQL query
        $sql = 'CALL language_get_language(:language_id)';
        
        // Build the parameters array
        $params = array(':language_id' => $langId);
               
        // Execute the query
        return DatabaseHandler::GetRow($sql, $params);
    }
    
    public static function GetAll($fromSession = false)
    {
        if ($fromSession)
        {
            if (!isset($_SESSION['languages']))
                $_SESSION['languages'] = self::GetAll(false);
            return $_SESSION['languages'];
        }
        else
        {
            // Build SQL query
            $sql = 'CALL language_get_languages()';

            // Execute the query
            return DatabaseHandler::GetAll($sql);
        }
    }
    
    public static function GetByName($languageName)
    {
        // Build SQL query
        $sql = 'CALL language_get_by_name(:language_name)';
        
        // Build the parameters array
        $params = array(':language_name' => $languageName);
               
        // Execute the query
        return DatabaseHandler::GetRow($sql, $params);
    }
}
?>
