<?php

class Beehive       
{
    

    public static function AddDataEntry($beehiveId, $beehiveWeight, $beehiveInTemp, $beehiveExtTemp, $beehiveExtHum, $beehiveLum, $beehiveLatitude, $beehiveLongtitude )
    {
        // Build the SQL query
        $sql = 'CALL beehive_add_data_entry(:beehive_id, :weight, :int_temp, :ext_temp, :ext_hum, :lum, :Latitude, :Longtitude)';

        // Build the parameters array
        $params = array (':beehive_id'   => $beehiveId, 
                         ':weight'       => $beehiveWeight,
                         ':int_temp'     => $beehiveInTemp,
                         ':ext_temp'     => $beehiveExtTemp,
                         ':ext_hum'      => $beehiveExtHum,
                         ':lum'          => $beehiveLum,
                         ':Latitude'     => $beehiveLatitude,
                         ':Longtitude'   => $beehiveLongtitude
        );     

        // Execute the query and return the results
        return DatabaseHandler::Execute($sql, $params);
    }
    
    public static function AddHealthStatusEntry($beehiveId, $uCBattery, $gsmBattery, $rssi )
    {
        // Build the SQL query
        $sql = 'CALL beehive_add_health_status_entry(:beehive_id, :beehive_uc_battery, :beehive_gsm_battery, :beehive_RSSI)';

        // Build the parameters array
        $params = array (':beehive_id'          => $beehiveId, 
                         ':beehive_uc_battery'  => $uCBattery,
                         ':beehive_gsm_battery' => $gsmBattery,
                         ':beehive_RSSI'        => $rssi
        );     

        // Execute the query and return the results
        return DatabaseHandler::Execute($sql, $params);
    }

    
    public static function GetCustomerClusters($customerId)
    {
        // Build the SQL query
        $sql = 'CALL beehive_get_clusters(:customer_id)';

        // Build the parameters array
        $params = array (':customer_id' => $customerId);

        // Execute the query and return the results
        return DatabaseHandler::GetAll($sql, $params);
    }
    
    public static function GetClusterBeehives($clusterId)
    {
        // Build the SQL query
        $sql = 'CALL beehive_get_cluster_beehives(:cluster_id)';

        // Build the parameters array
        $params = array (':cluster_id' => $clusterId);

        // Execute the query and return the results
        return DatabaseHandler::GetAll($sql, $params);
    }
    
    public static function GetClusterName($clusterId)
    {
        // Build the SQL query
        $sql = 'CALL beehive_get_cluster_name(:cluster_id)';

        // Build the parameters array
        $params = array (':cluster_id' => $clusterId);

        // Execute the query and return the results
        return DatabaseHandler::GetOne($sql, $params);
    }
    
    public static function GetBeehiveLatestStatus($beehiveId)
    {
        // Build the SQL query
        $sql = 'CALL beehive_get_beehive_latest_status(:beehive_id)';

        // Build the parameters array
        $params = array (':beehive_id' => $beehiveId);

        // Execute the query and return the results
        return DatabaseHandler::GetAll($sql, $params);
        
    }


}

?>
