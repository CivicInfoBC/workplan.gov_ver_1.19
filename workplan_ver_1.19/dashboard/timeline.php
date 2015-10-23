<?php
error_reporting(E_ALL);
ini_set('display_errors','1');

$dsn = 'mysql:dbname=wp12.5;host=localhost';
$user = 'root';
$password = 'root';

$pdo = new PDO($dsn, $user, $password);



$result = $pdo->query('select project_name, DATE_FORMAT(project.date_start,"%Y, %c -1, %d") AS date_start, DATE_FORMAT(project.date_end,"%Y, %c-1, %d") AS date_end from project');
foreach ($result as $row) {


$rows[] = "['{$row['project_name']}', new Date({$row['date_start']}), new Date({$row['date_end']})]\r\n";

}
$rowsString = implode(',',$rows);
?>


<script type="text/javascript" src="https://www.google.com/jsapi?autoload={'modules':[{'name':'visualization',
       'version':'1','packages':['timeline']}]}"></script>
<script type="text/javascript">
google.setOnLoadCallback(drawChart);

function drawChart() {

  var container = document.getElementById('time_line');

  var chart = new google.visualization.Timeline(container);

  var dataTable = new google.visualization.DataTable();

  dataTable.addColumn({ type: 'string', id: 'Project' });
  dataTable.addColumn({ type: 'date', id: 'Start' });
  dataTable.addColumn({ type: 'date', id: 'End' });

  dataTable.addRows([<?php echo $rowsString; ?>]);
	
	

  chart.draw(dataTable);
}
</script>


<div id="time_line" style="width: 800px; height: 480px;"></div>

