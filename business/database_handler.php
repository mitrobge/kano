<?php
// Class providing generic data access functionality
class DatabaseHandler
{
    // Hold an instance of the PDO class
    private static $_mHandler;

    // Private constructor to prevent direct creation of object
    private function __construct()
    {
    }

    // Return an initialized database handler 
    private static function GetHandler()
    {
        // Create a database connection only if one doesn�t already exist
        if (!isset(self::$_mHandler))
        {
            // Execute code catching potential exceptions
            try
            {
                // Create a new PDO class instance
                self::$_mHandler =
                    new PDO(PDO_DSN, DB_USERNAME, DB_PASSWORD,
                        array(PDO::ATTR_PERSISTENT => DB_PERSISTENCY));

                // Configure PDO to throw exceptions
                self::$_mHandler->setAttribute(PDO::ATTR_ERRMODE,
                    PDO::ERRMODE_EXCEPTION);
                self::$_mHandler->query('SET NAMES utf8');
            }
            catch (PDOException $e)
            {
                // Close the database handler and trigger an error
                self::Close();
                trigger_error($e->getMessage(), E_USER_ERROR);
            }
        }

        // Return the database handler
        return self::$_mHandler;
    }

    // Clear the PDO class instance
    public static function Close()
    {
        self::$_mHandler = null;
    }

    // Wrapper method for PDOStatement::execute()
    public static function Execute($sqlQuery, $params = null)
    {
        // Try to execute an SQL query or a stored procedure
        try
        {
            // Get the database handler
            $database_handler = self::GetHandler();

            // Prepare the query for execution
            $statement_handler = $database_handler->prepare($sqlQuery);

            // Execute query
            $statement_handler->execute($params);
        }
        // Trigger an error if an exception was thrown when executing the SQL query
        catch(PDOException $e)
        {
            // Close the database handler and trigger an error
            self::Close();
            trigger_error($e->getMessage(), E_USER_ERROR);
        }
    }

    // Wrapper method for PDOStatement::fetchAll()
    public static function GetAll($sqlQuery, $params = null,
                                    $fetchStyle = PDO::FETCH_ASSOC)
    {
        // Initialize the return value to null
        $result = null;

        // Try to execute an SQL query or a stored procedure
        try
        {
            // Get the database handler
            $database_handler = self::GetHandler();

            // Prepare the query for execution
            $statement_handler = $database_handler->prepare($sqlQuery);

            // Execute the query
            $statement_handler->execute($params);

            // Fetch result
            $result = $statement_handler->fetchAll($fetchStyle);
        }
        // Trigger an error if an exception was thrown when executing the SQL query
        catch(PDOException $e)
        {
            // Close the database handler and trigger an error
            self::Close();
            trigger_error($e->getMessage(), E_USER_ERROR);
        }

        // Return the query results
        return $result;
    }

    // Wrapper method for PDOStatement::fetch()
    public static function GetRow($sqlQuery, $params = null,
        $fetchStyle = PDO::FETCH_ASSOC)
    {
        // Initialize the return value to null
        $result = null;

        // Try to execute an SQL query or a stored procedure
        try
        {
            // Get the database handler
            $database_handler = self::GetHandler();

            // Prepare the query for execution
            $statement_handler = $database_handler->prepare($sqlQuery);

            // Execute the query
            $statement_handler->execute($params);

            // Fetch result
            $result = $statement_handler->fetch($fetchStyle);
        }
        // Trigger an error if an exception was thrown when executing the SQL query
        catch(PDOException $e)
        {
            // Close the database handler and trigger an error
            self::Close();
            trigger_error($e->getMessage(), E_USER_ERROR);
        }

        // Return the query results
        return $result;
    }

    // Wrapper method for PDOStatement::execute()
    public static function ExecuteOutput($sqlQuery, $params = null)
    {
        $result = null;
        // Try to execute an SQL query or a stored procedure
        try
        {
            // Get the database handler
            $database_handler = self::GetHandler();

            // Prepare the query for execution
            $statement_handler = $database_handler->prepare($sqlQuery);

            $statement_handler->bindParam(1, $params[':email'], PDO::PARAM_STR, 256);
            $statement_handler->bindParam(2, $params[':survey_id'], PDO::PARAM_INT, 10);
            $statement_handler->bindParam(3, $params[':qid'], PDO::PARAM_INT, 10);
            $statement_handler->bindParam(4, $params[':pos'], PDO::PARAM_INT, 10);
            $statement_handler->bindParam(5, $params[':neg'], PDO::PARAM_INT, 10);
            $statement_handler->bindParam(6, $result, PDO::PARAM_INT, 10);

            // Execute query
            $statement_handler->execute();

            //var_dump($result);
            echo "The return values is:". $result;
        }
            // Trigger an error if an exception was thrown when executing the SQL query
        catch(PDOException $e)
        {
            // Close the database handler and trigger an error
            self::Close();
            trigger_error($e->getMessage(), E_USER_ERROR);
        }

        return $result;
    }
    // Return the first column value from a row
    public static function GetOne($sqlQuery, $params = null)
    {
        // Initialize the return value to null    
        $result = null;

        // Try to execute an SQL query or a stored procedure
        try
        {
            // Get the database handler
            $database_handler = self::GetHandler();

            // Prepare the query for execution
            $statement_handler = $database_handler->prepare($sqlQuery);

            // Execute the query
            $statement_handler->execute($params);

            // Fetch result
            $result = $statement_handler->fetch(PDO::FETCH_NUM);

            /* Save the first value of the result set (first column of the first row)
               to $result */
            $result = $result[0];
        }
        // Trigger an error if an exception was thrown when executing the SQL query
        catch(PDOException $e)
        {
            // Close the database handler and trigger an error
            self::Close();
            trigger_error($e->getMessage(), E_USER_ERROR);
        }

        // Return the query results
        return $result;
    }
}
?>
