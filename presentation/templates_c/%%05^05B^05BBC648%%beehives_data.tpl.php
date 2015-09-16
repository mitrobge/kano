<?php /* Smarty version 2.6.22, created on 2015-08-30 11:35:17
         compiled from beehives_data.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'load_presentation_object', 'beehives_data.tpl', 2, false),)), $this); ?>
<?php echo smarty_function_load_presentation_object(array('filename' => 'beehives_data','assign' => 'obj'), $this);?>


<?php echo '    
<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script type="text/javascript"></script>
'; ?>




<!-- Scripts -->
<script type="text/javascript" src="js/jquery-1.8.0.min.js"></script>
<script type="text/javascript" src="js/amazium.js"></script>


<?php echo '    
<script type="text/javascript">
    
    google.load(\'visualization\', \'1\', {\'packages\':[\'corechart\']});
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
    var chart = new google.visualization.PieChart(document.getElementById(\'chart_div\'));
    chart.draw(data, {width: 400, height: 240});
    }


</script>
'; ?>
    

   
<section class="row">
    <article class="grid_6">
        <table>
        <th>Cluster</th>
        <th>Id</th>
        <th>Name</th>
        <th>RSSI</th>
        <th>GSM battery</th>
        <th>uC battery</th>
        <?php unset($this->_sections['j']);
$this->_sections['j']['name'] = 'j';
$this->_sections['j']['loop'] = is_array($_loop=$this->_tpl_vars['obj']->mClusterBeehives) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
        <td><?php echo $this->_tpl_vars['obj']->mClusterName; ?>
</td>
        <td><?php echo $this->_tpl_vars['obj']->mClusterBeehives[$this->_sections['j']['index']]['beehive_id']; ?>
</td>
        <td><?php echo $this->_tpl_vars['obj']->mClusterBeehives[$this->_sections['j']['index']]['beehive_name']; ?>
</td>
        <td><?php echo $this->_tpl_vars['obj']->mBeehiveStatus[$this->_sections['j']['index']][0]['beehive_RSSI']; ?>
</td>
        <td><?php echo $this->_tpl_vars['obj']->mBeehiveStatus[$this->_sections['j']['index']][0]['beehive_gsm_battery']; ?>
</td>
        <td><?php echo $this->_tpl_vars['obj']->mBeehiveStatus[$this->_sections['j']['index']][0]['beehive_uc_battery']; ?>
</td>
    
        </tr>
        <?php endfor; endif; ?>
        </table>
    </article>
</section>


