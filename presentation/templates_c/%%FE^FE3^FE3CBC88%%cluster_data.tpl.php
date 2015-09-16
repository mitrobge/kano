<?php /* Smarty version 2.6.22, created on 2015-09-12 21:40:43
         compiled from cluster_data.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'load_presentation_object', 'cluster_data.tpl', 2, false),)), $this); ?>
<?php echo smarty_function_load_presentation_object(array('filename' => 'cluster_data','assign' => 'obj'), $this);?>


<?php echo '    
        <style>
            #map {
                width: 500px;
                height: 400px;
            }
        </style>
<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script type="text/javascript"></script>
'; ?>



<?php echo '    

    <script src="https://maps.googleapis.com/maps/api/js"
        type="text/javascript"></script>
    <script type="text/javascript">
        //<![CDATA[

    var customIcons = {
restaurant: {
icon: \'http://labs.google.com/ridefinder/images/mm_20_blue.png\'
            },
bar: {
icon: \'http://labs.google.com/ridefinder/images/mm_20_red.png\'
     }
    };

function load() {
    var map = new google.maps.Map(document.getElementById("map"), {
center: new google.maps.LatLng(37.92,23.7),
zoom: 6,
mapTypeId: \'roadmap\'
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
    google.maps.event.addListener(marker, \'click\', function() {
            infoWindow.setContent(html);
            infoWindow.open(map, marker);
            });
}

function downloadUrl(url, callback) {
    var request = window.ActiveXObject ?
        new ActiveXObject(\'Microsoft.XMLHTTP\') :
        new XMLHttpRequest;

    request.onreadystatechange = function() {
        if (request.readyState == 4) {
            request.onreadystatechange = doNothing;
            callback(request, request.status);
        }
    };

    request.open(\'GET\', url, true);
    request.send(null);
}

function doNothing() {}

//]]>

</script>

'; ?>


<!-- Scripts -->
<script type="text/javascript" src="js/jquery-1.8.0.min.js"></script>
<script type="text/javascript" src="js/amazium.js"></script>



<?php if ($this->_tpl_vars['obj']->mUserIsLoggedIn): ?>

<section class="row">
    <article class="grid_6">
    <div id="map" style="width: 500px; height: 500px">
        <?php echo '
        <script type="text/javascript">
            load()
        </script>
        '; ?>

    </div>
    </article>


    <article class="grid_6">
        <p><a href="<?php echo $this->_tpl_vars['obj']->mCustomerClusters[0]['link_to_cluster_details']; ?>
" class="btn white small">Add New Cluster</a></p>
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
        <?php unset($this->_sections['j']);
$this->_sections['j']['name'] = 'j';
$this->_sections['j']['loop'] = is_array($_loop=$this->_tpl_vars['obj']->mCustomerClusters) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['j']['show'] = true;
$this->_sections['j']['max'] = $this->_sections['j']['loop'];
$this->_sections['j']['step'] = 1;
$this->_sections['j']['start'] = $this->_sections['j']['step'] > 0 ? 0 : $this->_sections['j']['loop']-1;
if ($this->_sections['j']['show']) {
    $this->_sections['j']['total'] = $this->_sections['j']['loop'];
    if ($this->_sections['j']['total'] == 0)
        $this->_sections['j']['show'] = false;
} else
    $this->_sections['j']['total'] = 0;
if ($this->_sections['j']['show']):

            for ($this->_sections['j']['index'] = $this->_sections['j']['start'], $this->_sections['j']['iteration'] = 1;
                 $this->_sections['j']['iteration'] <= $this->_sections['j']['total'];
                 $this->_sections['j']['index'] += $this->_sections['j']['step'], $this->_sections['j']['iteration']++):
$this->_sections['j']['rownum'] = $this->_sections['j']['iteration'];
$this->_sections['j']['index_prev'] = $this->_sections['j']['index'] - $this->_sections['j']['step'];
$this->_sections['j']['index_next'] = $this->_sections['j']['index'] + $this->_sections['j']['step'];
$this->_sections['j']['first']      = ($this->_sections['j']['iteration'] == 1);
$this->_sections['j']['last']       = ($this->_sections['j']['iteration'] == $this->_sections['j']['total']);
?>
        <tr>
        <td><a href="<?php echo $this->_tpl_vars['obj']->mCustomerClusters[$this->_sections['j']['index']]['link_to_cluster_details']; ?>
"><?php echo $this->_tpl_vars['obj']->mCustomerClusters[$this->_sections['j']['index']]['cluster_name']; ?>
</a></td>
        <td><?php echo $this->_tpl_vars['obj']->mCustomerClusters[$this->_sections['j']['index']]['cluster_city']; ?>
</td>
        <td><?php echo $this->_tpl_vars['obj']->mCustomerClusters[$this->_sections['j']['index']]['cluster_size']; ?>
</td>
        <td><?php echo $this->_tpl_vars['obj']->mCustomerClusters[$this->_sections['j']['index']]['lon']; ?>
</td>
        <td><?php echo $this->_tpl_vars['obj']->mCustomerClusters[$this->_sections['j']['index']]['lat']; ?>
</td>
        <td><img src="http://openweathermap.org/img/w/<?php echo $this->_tpl_vars['obj']->mCustomerClusters[$this->_sections['j']['index']]['icon']; ?>
.png"></td>
        <td><?php echo $this->_tpl_vars['obj']->mCustomerClusters[$this->_sections['j']['index']]['Weather']; ?>
</td>
        <td><?php echo $this->_tpl_vars['obj']->mCustomerClusters[$this->_sections['j']['index']]['Temperature']; ?>
</td>
        <td><?php echo $this->_tpl_vars['obj']->mCustomerClusters[$this->_sections['j']['index']]['Pressure']; ?>
</td>
        <td><?php echo $this->_tpl_vars['obj']->mCustomerClusters[$this->_sections['j']['index']]['Humidity']; ?>
</td>
        <td><p><a href="#" class="btn white small">Edit</a></p></td>
        </tr>
        <?php endfor; endif; ?>
        </table>
    </article>
</section>

<?php else: ?>
     You need to login to access this page
<?php endif; ?>
