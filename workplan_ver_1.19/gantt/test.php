<?php
 

include ('../../../connector-php/codebase/gantt_connector.php');
 

// Mysql
 $dbtype = "MySQL";
 $res=mysql_connect("192.168.1.6", "root", "root");
 mysql_select_db("gantt");
 
$gantt = new JSONGanttConnector($res, $dbtype);
 
$gantt->mix("open", 1);
//$gantt->enable_order("sortorder");
 
$gantt->render_links("gantt_links", "id", "source,target,type");
$gantt->render_table("gantt_tasks","id",
    "start_date,duration,text,progress,sortorder,parent","");
 
?>