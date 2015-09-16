<?php

class Utils
{
    public static function GetCountries()
    {
        // Build the SQL query
        $sql = 'CALL utils_get_countries()';

        // Execute the query and return the results
        return DatabaseHandler::GetAll($sql);
    }

    public static function GetCountry($countryId)
    {
        // Build the SQL query
        $sql = 'CALL utils_get_country(:country_id)';
        
        // Build the parameters array
		$params = array(':country_id' => $countryId);

        // Execute the query and return the results
        return DatabaseHandler::GetRow($sql, $params);
    }
    
    public static function GetStates()
    {
        // Build the SQL query
        $sql = 'CALL utils_get_states()';

        // Execute the query and return the results
        return DatabaseHandler::GetAll($sql);
    }
    
    public static function GetCountryStates($countryId)
    {
        // Build the SQL query
        $sql = 'CALL utils_get_country_states(:country_id)';
        
        // Build the parameters array
		$params = array(':country_id' => $countryId);

        // Execute the query and return the results
        return DatabaseHandler::GetAll($sql, $params);
    }
    
    public static function GetState($stateId)
    {
        // Build the SQL query
        $sql = 'CALL utils_get_state(:state_id)';
        
        // Build the parameters array
		$params = array(':state_id' => $stateId);

        // Execute the query and return the results
        return DatabaseHandler::GetRow($sql, $params);
    }

    public static function CheckVATRegistrationNumber($num)
    {
        $sum = 0;
        $ext = 256;
        $digits = array();

        if(!empty($num) && intval($num) && is_numeric($num))
        {
            for ($i = 0; $i < (strlen($num)); $i++)
            {   
                array_push($digits, $num{$i});
            }
            for ($i = 0; $i < (strlen($num)-1); $i++)
            {
                $sum += $digits[$i]*$ext;
                $ext = $ext/2;
            }
            if ((intval(fmod($sum, 11) == 10)) && ($digits[strlen($num)-1] == 0)) 
            {  
                return true; 
            }
            elseif ((intval(fmod($sum, 11) < 10)) && ($digits[strlen($num)-1] == intval(fmod($sum, 11))))
            {  
                return true;   
            }
            else  
            {   
                return false;
            }
        }
        else
        {
            return false;
        }
    }
    
    public static function SqlToDatePickerFormat($sqlDate)
    {
        if (is_null($sqlDate) || empty($sqlDate))
            return;
        if (version_compare(PHP_VERSION, '5.3.0') >= 0) {
            $date = DateTime::createFromFormat('Y-m-d H:i:s', $sqlDate);
            return $date->format('d/m/Y');
        } else {
            list($date, $time) = split('[ ]', $sqlDate);
            list($year, $month, $day) = split('[-]', $date);
            return $day . '/' . $month . '/' . $year;
        }
    }

    public static function ArrayCartesianProduct($arrays) 
    {
        //returned array...
        $cartesic = array();

        //calculate expected size of cartesian array...
        $size=(sizeof($arrays)>0)?1:0;
        foreach($arrays as $array)
        {
            $size= $size*sizeof($array);
        }
        for($i=0; $i<$size;$i++) {
            $cartesic[$i] = array();

            for($j=0;$j<sizeof($arrays);$j++)
            {
                $current = current($arrays[$j]);
                array_push($cartesic[$i], $current); 
            }
            //set cursor on next element in the arrays, beginning with the last array
            for($j=(sizeof($arrays)-1);$j>=0;$j--)
            {
                //if next returns true, then break
                if(next($arrays[$j])) {
                    break;
                } else { //if next returns false, then reset and go on with previuos array...
                    reset($arrays[$j]);
                }
            }
        }
        return $cartesic;
    }
}

?>
