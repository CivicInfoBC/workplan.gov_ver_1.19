<?php
error_reporting(E_ALL);
ini_set('display_errors','1');
$dsn = 'mysql:dbname=wp12.5;host=localhost';
$user = 'root';
$password = 'root';

$pdo = new PDO($dsn, $user, $password);


//Query for "total Actual hours per project"
$QueryResult1 = $pdo->query('SELECT SUM(ts.total_hours) AS `total_hours`,
       p.`project_name`,
       SUM(t.`hrs`) AS `assigned_hours`,`task_name`
FROM `task` t INNER JOIN
      `project` p
       ON t.`project_id` = p.`project_id` INNER JOIN
       (select ts.task_id, sum(ts.hours) as total_hours
        from `timesheet` ts
        group by ts.task_id
       ) ts
       ON t.`task_id` = ts.`task_id`
GROUP BY p.`project_name`');


foreach ($QueryResult1 as $row) {

$rows[] = "['{$row['project_name']}',{$row['total_hours']}]";

 
}
$rowsString = implode(',',$rows);
//end of query 1

//start Query 2 for "Hours per Priority"

$QueryResult2 = $pdo->query('SELECT DISTINCT 
              `project`.`priority`,
              SUM(`task`.`hrs`) AS `total_allocated_hrs`
            FROM
              `task`
              INNER JOIN `project` ON (`task`.`project_id` = `project`.`project_id`)
            GROUP BY
              `project`.`priority`');
foreach ($QueryResult2 as $q2row) {

$q2rows[] = "['{$q2row['priority']}',{$q2row['total_allocated_hrs']}]";

 
}
$q2rowsString = implode(',',$q2rows);

//start query for budget per project
$QueryResult3 = $pdo->query('select * from project');
foreach ($QueryResult3 as $q3row) {

$q3rows[] = "['{$q3row['project_name']}',{$q3row['approved_budget']}]";

}
$q3rowsString = implode(',',$q3rows);

//start "Actual hours versus assigned hours


$QueryResult4 = $pdo->query('SELECT `x`.*
                 , SUM(`task`.`hrs`)AS `assigned_hrs`
              FROM
                 ( SELECT `staff_id`
                        , `name`
                        , SUM(`hours`) AS `actual_hours`
                     FROM `timesheet` 
                    GROUP 
                       BY `timesheet`.`staff_id`
                 ) `x`
              JOIN `task`
                ON `assigned_to` = `x`.`staff_id`
             GROUP
                BY `staff_id`');
foreach ($QueryResult4 as $q4row) {

$q4rows[] = "['{$q4row['name']}',{$q4row['actual_hours']},{$q4row['assigned_hrs']}]";

 
}
$q4rowsString = implode(',',$q4rows);

//start total allocated hours
$QueryResult5 = $pdo->query('SELECT DISTINCT 
              `task`.`assigned_to`,
              SUM(`task`.`hrs`) AS `total_hrs`,
              `staff`.`username`
            FROM
              `staff`,
              `task`
              
            WHERE
              `staff`.`staff_id` = `task`.`assigned_to`
            GROUP BY
                `staff`.`username`');
foreach ($QueryResult5 as $q5row) {

$q5rows[] = "['{$q5row['username']}',{$q5row['total_hrs']}]";

 
}
$q5rowsString = implode(',',$q5rows);

?>
<!DOCTYPE html>
<html lang="en">
	<head>
		
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, target-densityDpi=device-dpi" />
		<meta name="apple-mobile-web-app-capable" content="yes" />
		<meta name="apple-mobile-web-app-status-bar-style" content="black" /> 
		
		<title>Live Demo &mdash; jDashboard</title>
		
		<link rel="stylesheet" href="jdashboard/jdashboard.min.css" />
		<link rel="stylesheet" href="style.css" />

<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script type="text/javascript">
    google.load("visualization", "1", {packages:["corechart"]});
    google.setOnLoadCallback(drawChart);
    function drawChart() {
        var data1 = google.visualization.arrayToDataTable([
	['Project Name', 'Total Actual Hours'],
	  <?php echo $rowsString; ?>]);
	  

var data2 = new google.visualization.DataTable();
	data2.addColumn('string', 'Priority');
	data2.addColumn('number', 'Allocated Hours');
        data2.addRows([<?php echo $q2rowsString; ?>]);


var data3 = new google.visualization.DataTable();
	data3.addColumn('string', 'Project');
	data3.addColumn('number', 'Approved Budget');
        data3.addRows([<?php echo $q3rowsString; ?>]);

var data4 = google.visualization.arrayToDataTable([
	['Staff Name', 'Actual Hours', 'Allocated Hours'],
	  <?php echo $q4rowsString; ?>]);

var data5 = google.visualization.arrayToDataTable([
	['Staff Name','Allocated Hours'],
	  <?php echo $q5rowsString; ?>]);



var options1 = {title: '',is3D:true};

var options2 = {title: '',is3D:true,hAxis: {title: 'Total Allocated Hours'},height: 300};

var options3 = {pieSliceText: 'value',legend: {position: 'labeled'},chartArea: {height: '100%', width: '90%'},pieStartAngle: 90};

var options4 = {title: ''};

var options5 = {title: '',isStacked: true};


var chart1 = new google.visualization.PieChart(document.getElementById('chart_div1'));
        
var chart2 = new google.visualization.PieChart(document.getElementById('chart_div2'));

var chart3 = new google.visualization.PieChart(document.getElementById('chart_div3'));

var chart4 = new google.visualization.ColumnChart(document.getElementById('chart_div4'));

var chart5 = new google.visualization.ColumnChart(document.getElementById('chart_div5'));
       

var formatter = new google.visualization.NumberFormat(
      {prefix: '$', negativeColor: 'red', negativeParens: true});
		formatter.format(data3, 1); 
		
var formatter4 = new google.visualization.NumberFormat(
	{negativeColor: 'red', negativeParens: true});
	formatter4.format(data4,1);
	formatter4.format(data4,2);

var formatter5 = new google.visualization.NumberFormat(
	{negativeColor: 'red', negativeParens: true});
	formatter5.format(data5,1);



chart1.draw(data1, options1);
chart2.draw(data2, options2);
chart3.draw(data3, options3);
chart4.draw(data4, options4);
chart5.draw(data5, options5);

    }
</script>




		
	</head>
	<body>
		





		<div id="controls"></div>
		
		<div id="dashboard">
			
			
<!-- Charts Widget -->
			<div id="wgt-charts1" class="jdash-widget">
				<div class="jdash-header">Gantt<span class="subtitle">Project Gantt Chart</span></div>
				<div class="jdash-body"><iframe src="timeline.php" width=100% height="300" frameborder="0"> </iframe></div>
			</div>
			








<!-- Information Box Widget -->
			<div id="wgt-infobox" class="jdash-widget">
				
				<div class="jdash-header">Total Actual Hours<span class="subtitle">Actual Hours per Project</span></div>
				<div class="jdash-body">
					
					<div id="chart_div1" style="height: 300px; "></div>
					
				</div>
				
			</div>
			
			
			
			<!-- HTML5 Widget -->
			<div id="wgt-html5" class="jdash-widget">
				<div class="jdash-header">Hours per Priority<span class="subtitle">Total Allocated Hours per Priority Item</span></div>
				<div class="jdash-body">
					<div id="chart_div2"></div>
					<div class="clear"></div>
				</div>
			</div>
			
			<!-- Ajax Widget -->
			<div id="wgt-ajax" class="jdash-widget">
				<div class="jdash-header">Projects by Budget<span class="subtitle">Total Budget allocated per Project</span></div>
				<div class="jdash-body">
					<div id="chart_div3"></div>
				</div>
			</div>
			
			<!-- Charts Widget -->
			<div id="wgt-charts" class="jdash-widget">
				<div class="jdash-header">Total Hours <span class="subtitle">Actual Hours versus Assigned Hours</span></div>
				<div class="jdash-body"><div id="chart_div4"></div></div>
			</div>
			
			
			
			<!-- Hidden Widget -->
			<div id="wgt-charts5" class="jdash-widget">
				<div class="jdash-header">Total Hours<span class="subtitle">Total Allocated Hours</span></div>
				<div class="jdash-body"><div id="chart_div5"></div>
			</div>
			
			
		</div>
		
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.0/jquery.min.js"></script>
		<script src="jdashboard/jdashboard.js"></script>
		<script>
			
			$('#dashboard').jDashboard();
			
		</script>
		
	</body>
</html>