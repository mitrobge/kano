<?php /* Smarty version 2.6.22, created on 2015-09-05 16:32:17
         compiled from calendar.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'load_presentation_object', 'calendar.tpl', 2, false),)), $this); ?>
<?php echo smarty_function_load_presentation_object(array('filename' => 'calendar','assign' => 'obj'), $this);?>

<?php echo '
<script type="text/javascript" src="https://www.google.com/jsapi?autoload={\'modules\':[{\'name\':\'visualization\',
\'version\':\'1\',\'packages\':[\'timeline\']}]}"></script>
<script type="text/javascript">
google.setOnLoadCallback(drawChart);

function drawChart() {
    var container = document.getElementById(\'example5.4\');
    var chart = new google.visualization.Timeline(container);
    var dataTable = new google.visualization.DataTable();
    dataTable.addColumn({ type: \'string\', id: \'Role\' });
    dataTable.addColumn({ type: \'string\', id: \'Name\' });
    dataTable.addColumn({ type: \'date\', id: \'Start\' });
    dataTable.addColumn({ type: \'date\', id: \'End\' });
    dataTable.addRows([
            [ \'President\', \'George Washington\', new Date(1789, 3, 30), new Date(1797, 2, 4) ],
            [ \'President\', \'John Adams\', new Date(1797, 2, 4), new Date(1801, 2, 4) ],
            [ \'President\', \'Thomas Jefferson\', new Date(1801, 2, 4), new Date(1809, 2, 4) ]]);

    var options = {
colors: [\'#cbb69d\', \'#603913\', \'#c69c6e\'],
    };

    chart.draw(dataTable, options);
}

</script>


'; ?>



<section class="row">
    <article class="grid_9">

    <div id="example5.4" style="height: 150px;"></div>
    </article>
</section>




<!-- Scripts -->
<script type="text/javascript" src="js/jquery-1.8.0.min.js"></script>
<script type="text/javascript" src="js/amazium.js"></script>
