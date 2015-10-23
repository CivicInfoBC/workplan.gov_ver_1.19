{* <CustomTemplates> *}
{literal}
<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script type="text/javascript">
    google.load("visualization", "1", {packages:["corechart"]});
    google.setOnLoadCallback(drawChart);
    
	function drawChart() {
        		
		 var data2 = google.visualization.arrayToDataTable([
            ['Project', 'Hours']
        {/literal}
        {foreach item=Row from=$DataGrid.Rows name=RowsGrid}
            ,['{$Row.DataCells.project_name.Data}', {$Row.DataCells.assigned_hours.Data}]
        {/foreach}
        {literal}
        ]);

        
		 var options2 = {
            is3D:true
        };
		
		var formatter = new google.visualization.NumberFormat(
	{negativeColor: 'red', negativeParens: true});
	
    formatter.format(data2,1);
		
        
		var chart2 = new google.visualization.PieChart(document.getElementById('chart_div2'));
        chart2.draw(data2, options2);
    }
</script>
{/literal}
<p>

<div style="height: 350px; overflow: visible;">
<div id="chart_div2" style="height: 300px; "></div>
</div>

{php} 
$page->SetShowUserAuthBar(false);
{/php}

{* </CustomTemplates> *}
