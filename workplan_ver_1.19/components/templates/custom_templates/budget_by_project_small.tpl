{* <CustomTemplates> *}
{literal}
<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script type="text/javascript">
    google.load("visualization", "1", {packages:["corechart"]});
    google.setOnLoadCallback(drawChart);
    
	
	
	function drawChart() {
        var data = new google.visualization.arrayToDataTable([
            ['Project', 'Approved Budget']
        {/literal}
        {foreach item=Row from=$DataGrid.Rows name=RowsGrid}
            ,['{$Row.DataCells.project_name.Data}', {$Row.DataCells.approved_budget.Data}]
        {/foreach}
        {literal}
        ]);
		var formatter = new google.visualization.NumberFormat(
      {prefix: '$', negativeColor: 'red', negativeParens: true});
		formatter.format(data, 1);  

        var options = {
            pieSliceText: 'value',
        legend: {
            position: 'labeled'
        },
        chartArea: {
            height: '100%',
            width: '90%'
        },
        pieStartAngle: 90
        };
	
      var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
    chart.draw(data, options);
	 
    }
</script>
{/literal}


<div id="chart_div"></div>
{php} 
$page->SetShowUserAuthBar(false);
{/php}
{* </CustomTemplates> *}
