<?php

// Business tier class that manages shipping (regions, cost) functionality
class Shipping
{
    /* Private constructor to prevent direct creation of object */
    private function __construct()
    {
    }

    /* Find shipping region according to the state */
    public static function FindRegion($stateId)
    {
        $region_name = '';
        
        // Find shipping region name from the state
        $state = Utils::GetState($stateId);
        if ($state['state_name'] == 'Αττικής')
            $region_name = 'Αθήνα';
        else
            $region_name = 'Επαρχία';

        // Build SQL query
        $sql = 'CALL shipping_get_region_by_name(:shipping_region_name)';
                
        // Build the parameters array
        $params = array(':shipping_region_name' => $region_name);

        // Execute the query and return the results
        $region = DatabaseHandler::GetRow($sql, $params);

        return $region['shipping_region_id'];
    }
    
    public static function GetByRegionId($shippingRegionId)
    {
        // Build SQL query
        $sql = 'CALL shipping_get_shipping_by_region(:shipping_region_id)';
                
        // Build the parameters array
        $params = array(':shipping_region_id' => $shippingRegionId);

        // Execute the query and return the results
        return DatabaseHandler::GetRow($sql, $params);
    }

    public static function CalculateCost($shipping, $products)
    {
        $extra_cost = 0;

        if (!is_array($products)) {
            trigger_error('Shopping cart products array is required');
            exit(0);
        }
        
        // Calculate extra for each bulky item
        for ($i = 0; $i < count($products); $i++)
            $extra_cost += ($products[$i]['quantity'] * 
                $products[$i]['isbulky'] * $shipping['shipping_cost_bulky_product']);

        return $shipping['shipping_cost'] + $extra_cost;
    }

    public static function GetAll()
    {
        // Build SQL query
        $sql = 'CALL shipping_get_shippings()';
                
        // Execute the query and return the results
        return DatabaseHandler::GetAll($sql);
    }
    
    public static function Update($shippingId, $shippingCost, $shippingCostExtra)
    {
        // Build SQL query
        $sql = 'CALL shipping_update_shipping(:shipping_id, 
            :shipping_cost, :shipping_cost_bulky_product)';
                
        // Build the parameters array
        $params = array(':shipping_id' => $shippingId,
                        ':shipping_cost' => $shippingCost,
                        ':shipping_cost_bulky_product' => $shippingCostExtra);

        // Execute the query and return the results
        DatabaseHandler::Execute($sql, $params);
    }
}
?>

