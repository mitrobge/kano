{* smarty *}
{load_presentation_object filename="calendar" assign="obj"}
{literal}
<script type="text/javascript" src="https://www.google.com/jsapi?autoload={'modules':[{'name':'visualization',
'version':'1','packages':['timeline']}]}"></script>
<script type="text/javascript">
google.setOnLoadCallback(drawChart);

function drawChart() {
    var container = document.getElementById('example5.4');
    var chart = new google.visualization.Timeline(container);
    var dataTable = new google.visualization.DataTable();
    dataTable.addColumn({ type: 'string', id: 'Role' });
    dataTable.addColumn({ type: 'string', id: 'Name' });
    dataTable.addColumn({ type: 'date', id: 'Start' });
    dataTable.addColumn({ type: 'date', id: 'End' });
    dataTable.addRows([
            [ 'President', 'George Washington', new Date(1789, 3, 30), new Date(1797, 2, 4) ],
            [ 'President', 'John Adams', new Date(1797, 2, 4), new Date(1801, 2, 4) ],
            [ 'President', 'Thomas Jefferson', new Date(1801, 2, 4), new Date(1809, 2, 4) ]]);

    var options = {
colors: ['#cbb69d', '#603913', '#c69c6e'],
    };

    chart.draw(dataTable, options);
}

</script>


{/literal}


<section class="row">
    <article class="grid_9">

    <div id="example5.4" style="height: 150px;"></div>
    </article>
</section>




<!-- Scripts -->
<script type="text/javascript" src="js/jquery-1.8.0.min.js"></script>
<script type="text/javascript" src="js/amazium.js"></script>

