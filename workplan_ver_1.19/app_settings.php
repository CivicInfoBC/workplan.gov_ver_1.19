<?php

//  define('SHOW_VARIABLES', 1);
//  define('DEBUG_LEVEL', 1);

//  error_reporting(E_ALL ^ E_NOTICE);
//  ini_set('display_errors', 'On');

set_include_path('.' . PATH_SEPARATOR . get_include_path());


include_once dirname(__FILE__) . '/' . 'components/utils/system_utils.php';

//  SystemUtils::DisableMagicQuotesRuntime();

SystemUtils::SetTimeZoneIfNeed('America/Los_Angeles');

function GetGlobalConnectionOptions()
{
    return array(
  'server' => 'localhost',
  'port' => '3306',
  'username' => 'root',
  'password' => 'yourpass',
  'database' => 'workplan'
);
}

function HasAdminPage()
{
    return true;
}

function GetPageGroups()
{
    $result = array('Default');
    return $result;
}

function GetPageInfos()
{
    $result = array();
    $result[] = array('caption' => 'Dashboard', 'short_caption' => 'Dashboard', 'filename' => 'Dashboard.php', 'name' => 'Dashboard', 'group_name' => 'Default', 'add_separator' => false);
    $result[] = array('caption' => 'Project Type', 'short_caption' => 'Project Type', 'filename' => 'program.php', 'name' => 'program', 'group_name' => 'Default', 'add_separator' => false);
    $result[] = array('caption' => 'View all Projects', 'short_caption' => 'Project', 'filename' => 'project.php', 'name' => 'project', 'group_name' => 'Default', 'add_separator' => false);
    $result[] = array('caption' => 'Tasks - Time Tracking', 'short_caption' => 'Tasks - Time Tracking', 'filename' => 'task.php', 'name' => 'task', 'group_name' => 'Default', 'add_separator' => false);
    $result[] = array('caption' => 'Hours per Project', 'short_caption' => 'Hours per project', 'filename' => 'Hours per project by user.php', 'name' => 'Hours per Project by user', 'group_name' => 'Default', 'add_separator' => false);
    $result[] = array('caption' => 'Staff', 'short_caption' => 'Staff', 'filename' => 'staff.php', 'name' => 'staff', 'group_name' => 'Default', 'add_separator' => false);
    $result[] = array('caption' => 'Department', 'short_caption' => 'Department', 'filename' => 'department.php', 'name' => 'department', 'group_name' => 'Default', 'add_separator' => false);
    $result[] = array('caption' => 'Priority', 'short_caption' => 'Priority', 'filename' => 'Priority.php', 'name' => 'Priority', 'group_name' => 'Default', 'add_separator' => false);
    $result[] = array('caption' => 'Task Names', 'short_caption' => 'Task Names', 'filename' => 'task_names.php', 'name' => 'task_names', 'group_name' => 'Default', 'add_separator' => false);
    $result[] = array('caption' => 'Pay Period', 'short_caption' => 'Pay Period', 'filename' => 'Pay_Period.php', 'name' => 'Pay Period', 'group_name' => 'Default', 'add_separator' => false);
    $result[] = array('caption' => 'Department Projects', 'short_caption' => 'Department Projects', 'filename' => 'department_projects.php', 'name' => 'department_projects', 'group_name' => 'Default', 'add_separator' => false);
    return $result;
}

function GetPagesHeader()
{
    return
    '<p>
<table>
  <tr>
    <td>
      <img src="logo.png" /></td>
    <td>
      <h2>WorkPlan.Gov - Work Plan & Capacity Analysis</h2>
    </td>
    
  </tr>
</table>';
}

function GetPagesFooter()
{
    return
        '<p style="font-size:14px">copyright &copy 2014 City of Courtenay'; 
    }

function ApplyCommonPageSettings(Page $page, Grid $grid)
{
    $page->SetShowUserAuthBar(true);
    $page->OnCustomHTMLHeader->AddListener('Global_CustomHTMLHeaderHandler');
    $page->OnGetCustomTemplate->AddListener('Global_GetCustomTemplateHandler');
    $grid->BeforeUpdateRecord->AddListener('Global_BeforeUpdateHandler');
    $grid->BeforeDeleteRecord->AddListener('Global_BeforeDeleteHandler');
    $grid->BeforeInsertRecord->AddListener('Global_BeforeInsertHandler');
}

/*
  Default code page: 1252
*/
function GetAnsiEncoding() { return 'windows-1252'; }

function Global_CustomHTMLHeaderHandler($page, &$customHtmlHeaderText)
{

}

function Global_GetCustomTemplateHandler($part, $mode, &$result, &$params, Page $page = null)
{

}

function Global_BeforeUpdateHandler($page, $rowData, &$cancel, &$message, $tableName)
{

}

function Global_BeforeDeleteHandler($page, $rowData, &$cancel, &$message, $tableName)
{

}

function Global_BeforeInsertHandler($page, $rowData, &$cancel, &$message, $tableName)
{

}

function GetDefaultDateFormat()
{
    return 'Y-m-d';
}

function GetFirstDayOfWeek()
{
    return 0;
}

function GetEnableLessFilesRunTimeCompilation()
{
    return false;
}



?>