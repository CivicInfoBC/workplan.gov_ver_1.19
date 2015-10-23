{* <CustomTemplates> *}
{literal}
<script src="gantt/dhtmlxgantt.js" type="text/javascript" charset="utf-8"></script>
	<link rel="stylesheet" href="gantt/dhtmlxgantt.css" type="text/css" media="screen" title="no title" charset="utf-8">
<script src="gantt/ext/dhtmlxgantt_tooltip.js" type="text/javascript" charset="utf-8"></script>

<style>
.gantt_task_progress{
text-align:left;
padding-left:10px;
box-sizing: border-box;
color:white;
font-weight:bold;
}
</style>

<div id="gantt_here" style='width:100%; height:450px;'></div>
	<script type="text/javascript">
	var tasks =  {
        data:[
      {/literal}
		{foreach item=Row from=$DataGrid.Rows name=RowsGrid}
               {literal} { {/literal}id:"{$Row.DataCells.project_id.Data}", text:"{$Row.DataCells.project_name.Data}", start_date:"{$Row.DataCells.project_date_start.Data}", end_date: "{$Row.DataCells.project_date_end.Data}", progress: "{$Row.DataCells.progress.Data}",type:gantt.config.types.project, open: true{literal}}{/literal},
                 {literal} { {/literal}id:"{$Row.DataCells.task_id.Data}", text:"{$Row.DataCells.task_name.Data}", start_date:"{$Row.DataCells.task_date_start.Data}",end_date:"{$Row.DataCells.task_date_end.Data}", parent:"{$Row.DataCells.task_project_id.Data}"{literal}},{/literal} 
{/foreach}
		 {literal}                
				]
        };
gantt.config.scale_unit = "year";
gantt.config.step = 1;
gantt.config.date_scale = "%Y";
gantt.config.min_column_width = 50;
gantt.config.scale_height = 90;
gantt.templates.date_scale = null;
	var monthScaleTemplate = function(date){
	var dateToStr = gantt.date.date_to_str("%M");
	var endDate = gantt.date.add(date, 2, "month");
	return dateToStr(date) + " - " + dateToStr(endDate);
	};
gantt.config.subscales = [
{unit:"month", step:3, template:monthScaleTemplate},
{unit:"month", step:1, date:"%M" }
];


		
gantt.templates.progress_text = function(start,end, task){
return "<span style='text-align:left;'>"+Math.round(task.progress*100)+ "% </span>";
};
gantt.init("gantt_here");
gantt.config.readonly = true;
gantt.config.xml_date = "%Y-%m-%d %H:%i:%s";
//gantt.config.scale_unit = "month";

gantt.config.columns = [
{name:"text", label:"Projects", width:200, tree:true}

];

gantt.parse(tasks);


	</script>	
<p>
{/literal}


{* </CustomTemplates> *}

