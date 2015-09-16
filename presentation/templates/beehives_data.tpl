{* smarty *}
{load_presentation_object filename="beehives_data" assign="obj"}

{literal}    
<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script type="text/javascript"></script>
{/literal}



<!-- Scripts -->
<script type="text/javascript" src="js/jquery-1.8.0.min.js"></script>
<script type="text/javascript" src="js/amazium.js"></script>


{literal}    
<script type="text/javascript">
    
    google.load('visualization', '1', {'packages':['corechart']});
    google.setOnLoadCallback(drawChart);

    function drawChart() {
    var jsonData = $.ajax({
    url: "json/getData.php",
    dataType:"json",
    async: false
    }).responseText;

    // Create our data table out of JSON data loaded from server.
    var data = new google.visualization.DataTable(jsonData);

    // Instantiate and draw our chart, passing in some options.
    var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
    chart.draw(data, {width: 400, height: 240});
    }


</script>
{/literal}    

   
<section class="row">
    <article class="grid_6">
        <table>
        <th>Cluster</th>
        <th>Id</th>
        <th>Name</th>
        <th>RSSI</th>
        <th>GSM battery</th>
        <th>uC battery</th>
        {section name=j loop=$obj->mClusterBeehives}
        <tr>
        <td>{$obj->mClusterName}</td>
        <td>{$obj->mClusterBeehives[j].beehive_id}</td>
        <td>{$obj->mClusterBeehives[j].beehive_name}</td>
        <td>{$obj->mBeehiveStatus[j][0].beehive_RSSI}</td>
        <td>{$obj->mBeehiveStatus[j][0].beehive_gsm_battery}</td>
        <td>{$obj->mBeehiveStatus[j][0].beehive_uc_battery}</td>
    
        </tr>
        {/section}
        </table>
    </article>
</section>



