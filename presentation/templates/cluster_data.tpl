{* smarty *}
{load_presentation_object filename="cluster_data" assign="obj"}

{literal}    
        <style>
            #map {
                width: 500px;
                height: 400px;
            }
        </style>
<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script type="text/javascript"></script>
{/literal}


{literal}    

    <script src="https://maps.googleapis.com/maps/api/js"
        type="text/javascript"></script>
    <script type="text/javascript">
        //<![CDATA[

    var customIcons = {
restaurant: {
icon: 'http://labs.google.com/ridefinder/images/mm_20_blue.png'
            },
bar: {
icon: 'http://labs.google.com/ridefinder/images/mm_20_red.png'
     }
    };

function load() {
    var map = new google.maps.Map(document.getElementById("map"), {
center: new google.maps.LatLng(37.92,23.7),
zoom: 6,
mapTypeId: 'roadmap'
});
var infoWindow = new google.maps.InfoWindow;

// Change this depending on the name of your PHP file
downloadUrl("http://localhost/beesness-better/tmp/clusters.xml", function(data) {
        var xml = data.responseXML;
        var markers = xml.documentElement.getElementsByTagName("marker");
        for (var i = 0; i < markers.length; i++) {
        var name = markers[i].getAttribute("name");
        var address = markers[i].getAttribute("address");
        var type = markers[i].getAttribute("type");
        var point = new google.maps.LatLng(
            parseFloat(markers[i].getAttribute("lat")),
            parseFloat(markers[i].getAttribute("lng")));
        var html = "<b>" + name + "</b> <br/>" + address;
        var icon = customIcons[type] || {};
        var marker = new google.maps.Marker({
map: map,
position: point,
icon: icon.icon
});
        bindInfoWindow(marker, map, infoWindow, html);
        }
        });
}

function bindInfoWindow(marker, map, infoWindow, html) {
    google.maps.event.addListener(marker, 'click', function() {
            infoWindow.setContent(html);
            infoWindow.open(map, marker);
            });
}

function downloadUrl(url, callback) {
    var request = window.ActiveXObject ?
        new ActiveXObject('Microsoft.XMLHTTP') :
        new XMLHttpRequest;

    request.onreadystatechange = function() {
        if (request.readyState == 4) {
            request.onreadystatechange = doNothing;
            callback(request, request.status);
        }
    };

    request.open('GET', url, true);
    request.send(null);
}

function doNothing() {}

//]]>

</script>

{/literal}

<!-- Scripts -->
<script type="text/javascript" src="js/jquery-1.8.0.min.js"></script>
<script type="text/javascript" src="js/amazium.js"></script>



{if $obj->mUserIsLoggedIn}

<section class="row">
    <article class="grid_6">
    <div id="map" style="width: 500px; height: 500px">
        {literal}
        <script type="text/javascript">
            load()
        </script>
        {/literal}
    </div>
    </article>


    <article class="grid_6">
        <p><a href="{$obj->mCustomerClusters[0].link_to_cluster_details}" class="btn white small">Add New Cluster</a></p>
    </article>
</section>
   
<section class="row">
    <article class="grid_6">
        <table>
        <th>Name</th>
        <th>Current Location</th>
        <th>Size</th>
        <th>Longtitude</th>
        <th>Latitude</th>
        <th>Weather</th>
        <th>Description</th>
        <th>Temperature (°C) </th>
        <th>Pressure (hPA)</th>
        <th>Humidity (%)</th>
        <th>Action</th>
        {section name=j loop=$obj->mCustomerClusters}
        <tr>
        <td><a href="{$obj->mCustomerClusters[j].link_to_cluster_details}">{$obj->mCustomerClusters[j].cluster_name}</a></td>
        <td>{$obj->mCustomerClusters[j].cluster_city}</td>
        <td>{$obj->mCustomerClusters[j].cluster_size}</td>
        <td>{$obj->mCustomerClusters[j].lon}</td>
        <td>{$obj->mCustomerClusters[j].lat}</td>
        <td><img src="http://openweathermap.org/img/w/{$obj->mCustomerClusters[j].icon}.png"></td>
        <td>{$obj->mCustomerClusters[j].Weather}</td>
        <td>{$obj->mCustomerClusters[j].Temperature}</td>
        <td>{$obj->mCustomerClusters[j].Pressure}</td>
        <td>{$obj->mCustomerClusters[j].Humidity}</td>
        <td><p><a href="#" class="btn white small">Edit</a></p></td>
        </tr>
        {/section}
        </table>
    </article>
</section>

{else}
     You need to login to access this page
{/if}

