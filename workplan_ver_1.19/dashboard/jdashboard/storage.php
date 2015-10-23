<?php
	
	/*!
	 *	this is a template included with the jDashboard Plugin for jQuery
	 *	http://codecanyon.net/item/jdashboard/135111
	 *
	 *	Copyright (c) 2010-2012 Sarathi Hansen
	 *	http://www.codecanyon.net/user/sarthemaker
	 *
	 *	fill in the information about your mysql database below:
	 */
	$hostname  = 'localhost';		// your mysql database hostname
	$username  = 'root';			// your mysql database username
	$password  = 'root';				// your mysql database password
	
	$database  = 'jdash';			// the name of your database
	$tablename = 'dashboard';		// the name of the table in which to store the dashboard layouts
	$idfield   = 'userID';			// the field in which to store each users unique id
	$datafield = 'jdashStorage';	// the field in which to store the users dashboard layout
	
	
	/*!
	 *	YOU CAN STOP EDITING HERE
	 */
	$handle    = mysql_connect($hostname, $username, $password);
				 mysql_select_db($database);
	
	$storageID = $_POST['jdashStorageID'];
	$result    = mysql_result(mysql_query("SELECT `{$datafield}` FROM `{$tablename}` WHERE `{$idfield}`='{$storageID}'"), 0);
	
	if($_POST['type'] === 'load') {
		
		echo $result;
		
	} elseif($_POST['type'] === 'save') {
		
		if($result !== false)
			mysql_query("UPDATE `{$tablename}` SET `{$datafield}`='{$_POST['jdashStorage']}' WHERE `{$idfield}`='{$storageID}'");
		else
			mysql_query("INSERT INTO `{$tablename}` (`{$idfield}`,`{$datafield}`) VALUES('{$storageID}','{$_POST['jdashStorage']}')");
	}
	
?>