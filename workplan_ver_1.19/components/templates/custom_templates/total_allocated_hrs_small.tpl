{* <CustomTemplates> *}
{literal}
<script type="text/javascript" src="https://www.google.com/jsapi?.js"></script>
  <script type="text/javascript">
  function drawChart() {
    // Create the data table.
    var data = new google.visualization.DataTable();
   
	data.addColumn('string', 'Staff Name');
data.addColumn('number', 'Esitmated Hours Hours');
data.addRows([
        {/literal}
        {foreach item=Row from=$DataGrid.Rows name=RowsGrid}
            ['{$Row.DataCells.username.Data}', {$Row.DataCells.total_hrs.Data}],
        {/foreach}
        {literal}
        ]);

        var options = {
            legend:'none'
        };
    // Instantiate and draw our chart, passing in some options.
    var chart1 = new google.visualization.ColumnChart(document.getElementById('chart_div_1'));
   
    
   
    
    chart1.draw(data, options);
   
}
google.load('visualization', '1', {packages:['corechart'], callback: drawChart});
  
  </script>
{/literal}



<div id="chart_div_1"></div>


</div>
{php} 
$page->SetShowUserAuthBar(false);
{/php}
{* </CustomTemplates> *}
