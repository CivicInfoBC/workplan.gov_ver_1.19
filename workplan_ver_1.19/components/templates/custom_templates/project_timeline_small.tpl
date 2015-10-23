{* <CustomTemplates> *}
{literal}
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

  dataTable.addRows([
        {/literal}
        {foreach item=Row from=$DataGrid.Rows name=RowsGrid}
            ['{$Row.DataCells.project_name.Data}',  new Date({$Row.DataCells.date_start.Data}),  new Date({$Row.DataCells.date_end.Data})],
        {/foreach}
        {literal}
        ]);
	
	
	
	

  chart.draw(dataTable);
}
</script>
{/literal}
<div id="time_line" style="width: 800px; height: 480px;"></div>
{php} 
$page->SetShowUserAuthBar(false);
{/php}
{* </CustomTemplates> *}

