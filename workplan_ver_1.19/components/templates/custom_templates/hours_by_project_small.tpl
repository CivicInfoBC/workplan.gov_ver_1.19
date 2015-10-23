{* <CustomTemplates> *}
{literal}
<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script type="text/javascript">
    google.load("visualization", "1", {packages:["corechart"]});
    google.setOnLoadCallback(drawChart);
    
	function drawChart() {
        var data = google.visualization.arrayToDataTable([
            ['Project', 'Hours']
        {/literal}
        {foreach item=Row from=$DataGrid.Rows name=RowsGrid}
            ,['{$Row.DataCells.project_name.Data}', {$Row.DataCells.total_hours.Data}]
        {/foreach}
        {literal}
        ]);
		
		

        var options = {
            title: '',is3D:true
        };

		
		
		var formatter = new google.visualization.NumberFormat(
	{negativeColor: 'red', negativeParens: true});
	formatter.format(data,1);
   
		
        var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
        chart.draw(data, options);
		
    }
</script>
{/literal}
<p>

<div id="chart_div"></div>


{php} 
$page->SetShowUserAuthBar(false);
{/php}

{* </CustomTemplates> *}
