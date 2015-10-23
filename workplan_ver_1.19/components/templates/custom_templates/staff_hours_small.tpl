{* <CustomTemplates> *}
{literal}
<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script type="text/javascript">
    google.load("visualization", "1", {packages:["corechart"]});
    google.setOnLoadCallback(drawChart);
    function drawChart() {
        var data = google.visualization.arrayToDataTable([
            ['Staff Name', 'Total Hours Worked']
        {/literal}
        {foreach item=Row from=$DataGrid.Rows name=RowsGrid}
            ,['{$Row.DataCells.name.Data}', {$Row.DataCells.total_hours.Data}]
        {/foreach}
        {literal}
        ]);

        var options = {
            title: ''
        };

        var chart = new google.visualization.ColumnChart(document.getElementById('chart_div'));
        chart.draw(data, options);
    }
</script>
{/literal}


<div id="chart_div"></div>
</div>

{php} 
$page->SetShowUserAuthBar(false);
{/php}
{* </CustomTemplates> *}

