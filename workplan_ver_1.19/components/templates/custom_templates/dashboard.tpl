{* <CustomTemplates> *}

{literal}
<link rel="stylesheet" href="dashboard/jdashboard/dashboard_controls.css" />


<link rel="stylesheet" href="dashboard/jdashboard/jdashboard.min.css" />

		<!--here-->
		<div id="controls"></div>

		
		<div id="dashboard">


	
<!-- actual hours -->
			<div id="wgt-infobox" class="jdash-widget">
				
				<div class="jdash-header">Total Actual Hours<span class="subtitle"><a href="Hours_per_project.php">Actual Hours per Project</a></span></div>
				<div class="jdash-body">
					
					<iframe src="hours_per_project_small.php" width=100% height="300" frameborder="0"> </iframe>
					
				</div>
				</div>
				
			
			
			<!-- hours per priority -->
			<div id="wgt-html5" class="jdash-widget">
				<div class="jdash-header">Hours per Priority<span class="subtitle"><a href="Allocated_Hrs_by_Priority.php">Total Estimated Hours per Priority Item</a></span></div>
				<div class="jdash-body">
					<iframe src="allocated_hours_by_priority_small.php" width=100% height="300" frameborder="0"> </iframe>
					<div class="clear"></div>
				</div>
			</div>
			
			<!-- Project by budget -->
			<div id="wgt-ajax" class="jdash-widget">
				<div class="jdash-header">Projects by Budget<span class="subtitle"><a href="Project_by_approved_budget.php"> Total Budget allocated per Project</a></span></div>
				<div class="jdash-body">
					<iframe src="project_by_approved_budget_small.php" width=100% height="300" frameborder="0"> </iframe>
				</div>
			</div>
			
			<!-- Total actual Hours versus assigned hours -->
			<div id="wgt-charts" class="jdash-widget">
				<div class="jdash-header">Total Hours <span class="subtitle"><a href="Total_hrs_Estimated_Hrs.php"> Actual Hours versus Estimated Hours</a></span></div>
				<div class="jdash-body"><iframe src="actual_hours_versus_allocated_hours_small.php" width=100% height="300" frameborder="0"> </iframe></div>
			</div>
<!-- gantt chart-->
<div id="wgt-charts11" class="jdash-widget">
				<div class="jdash-header">Gantt<span class="subtitle"><a href="Project_Time_Line.php">Gantt Chart</a></span></div>
				<div class="jdash-body"><iframe src="project_timeline_small.php" width=100% height="300" frameborder="0"> </iframe></div>
			</div>
			
			
			<!-- allocated -->
			<div id="wgt-charts5" class="jdash-widget">
				<div class="jdash-header">Total Estimated Hours<span class="subtitle"><a href="Total_Allocated_Hrs.php"> Total Estimated Hours</a></span></div>
				<div class="jdash-body"><iframe src="total_allocated_hours_small.php" width=100% height="300" frameborder="0"> </iframe></div>
			</div>


			
			
			
		</div>
		
		
<!--heremw-->		
<script type="text/javascript" src="dashboard/jdashboard/jdashboard.min.js"></script>

		<script>
			
			$('#dashboard').jDashboard({controls: '#controls'});
			
		</script>	
  {/literal}  	
{* </CustomTemplates> *}

<b>Generated on: {$smarty.now|date_format:"%c"}</b>
