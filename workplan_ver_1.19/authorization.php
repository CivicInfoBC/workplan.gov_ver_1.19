<?php

require_once 'app_settings.php';
require_once 'components/security/security_info.php';
require_once 'components/security/datasource_security_info.php';
require_once 'components/security/tablebased_auth.php';
require_once 'components/security/user_grants_manager.php';
require_once 'components/security/table_based_user_grants_manager.php';

require_once 'database_engine/mysql_engine.php';

$grants = array();

$appGrants = array();

$dataSourceRecordPermissions = array('project' => new DataSourceRecordPermission('staff_id', true, false, false, true, true, true),
  'project.task' => new DataSourceRecordPermission('staff_id', true, false, false, true, true, true),
  'task' => new DataSourceRecordPermission('staff_id', false, false, false, true, true, true),
  'task.timesheet' => new DataSourceRecordPermission('staff_id', false, false, false, true, true, true),
  'Hours per Project by user' => new DataSourceRecordPermission('staff_id', false, false, false, true, true, true),
  'staff' => new DataSourceRecordPermission('staff_id', false, false, false, true, true, true),
  'Total hrs Estimated Hrs' => new DataSourceRecordPermission('staff_id', false, false, false, true, false, false),
  'Total Allocated Hrs' => new DataSourceRecordPermission('staff_id', false, false, false, true, false, false),
  'Pay Period' => new DataSourceRecordPermission('staff_id', false, false, false, true, false, false),
  'total allocated hours small' => new DataSourceRecordPermission('staff_id', false, false, false, true, false, false),
  'actuall hours versus allocated hours small' => new DataSourceRecordPermission('staff_id', false, false, false, true, false, false),
  'department_projects' => new DataSourceRecordPermission('staff_id', true, false, false, true, true, true),
  'department_projects.task' => new DataSourceRecordPermission('staff_id', false, false, false, true, true, true),
  'department_projects.task' => new DataSourceRecordPermission('staff_id', false, false, false, true, true, true));

$tableCaptions = array('Dashboard' => 'Dashboard',
'program' => 'Project Type',
'program.project' => 'Project Type.Projects',
'project' => 'View all Projects',
'project.task' => 'View all Projects.Tasks within this project',
'project.project' => 'View all Projects.Project Budget Chart',
'project.project_timeline_detail' => 'View all Projects.Tasks Gantt view',
'task' => 'Tasks - Time Tracking',
'task.timesheet' => 'Tasks - Time Tracking.Timesheet',
'Hours per Project by user' => 'Hours per Project',
'staff' => 'Staff',
'department' => 'Department',
'Priority' => 'Priority',
'task_names' => 'Task Names',
'Allocated Hrs by Priority' => 'Chart: Allocated Hrs by Priority',
'Project by Approved Budget' => 'Chart: Project By Budget',
'Project Time Line' => 'Chart: Project Time Line',
'project_timeline_detail' => 'Chart: Project Timeline Detail',
'Total hrs Estimated Hrs' => 'Chart: Actual Hrs / Assigned Hrs',
'Total Allocated Hrs' => 'Chart: Total Allocated Hrs',
'Actual Hours' => 'Chart: Actual Hours',
'Hours per project' => 'Chart: Hours Per Project',
'Pay Period' => 'Pay Period',
'total allocated hours small' => 'Total Allocated Hours dashboard',
'actuall hours versus allocated hours small' => 'Actual Hours vs Allocated Hours dashboard',
'project by approved budget small' => 'Project By Approved Budget dashboard',
'allocated hours by priority small' => 'Est Hours By Priority dashboard',
'actual hours small' => 'Actual Hours dashboard',
'hours per project small' => 'Hours Per Project dashboard',
'project timeline small' => 'Project Timeline dashboard',
'department_projects' => 'Department Projects',
'department_projects.task' => 'Department Projects.Gantt view',
'department_projects.project' => 'Department Projects.Project Budget Chart');

function CreateTableBasedGrantsManager()
{
    global $tableCaptions;
    $usersTable = array('TableName' => 'staff', 'UserName' => 'username', 'UserId' => 'staff_id', 'Password' => 'password');
    $userPermsTable = array('TableName' => 'user_permissions', 'UserId' => 'user_id', 'PageName' => 'page_name', 'Grant' => 'perm_name');

    $passwordHasher = HashUtils::CreateHasher('');
    $connectionOptions = GetGlobalConnectionOptions();
    $tableBasedGrantsManager = new TableBasedUserGrantsManager(new MyConnectionFactory(), $connectionOptions,
        $usersTable, $userPermsTable, $tableCaptions, $passwordHasher, false);
    return $tableBasedGrantsManager;
}

function SetUpUserAuthorization()
{
    global $grants;
    global $appGrants;
    global $dataSourceRecordPermissions;
    $hardCodedGrantsManager = new HardCodedUserGrantsManager($grants, $appGrants);
    $tableBasedGrantsManager = CreateTableBasedGrantsManager();
    $grantsManager = new CompositeGrantsManager();
    $grantsManager->AddGrantsManager($hardCodedGrantsManager);
    if (!is_null($tableBasedGrantsManager)) {
        $grantsManager->AddGrantsManager($tableBasedGrantsManager);
        GetApplication()->SetUserManager($tableBasedGrantsManager);
    }
    $userAuthorizationStrategy = new TableBasedUserAuthorization(new MyConnectionFactory(), GetGlobalConnectionOptions(), 'staff', 'username', 'staff_id', $grantsManager);
    GetApplication()->SetUserAuthorizationStrategy($userAuthorizationStrategy);

    GetApplication()->SetDataSourceRecordPermissionRetrieveStrategy(
        new HardCodedDataSourceRecordPermissionRetrieveStrategy($dataSourceRecordPermissions));
}

function GetIdentityCheckStrategy()
{
    return new TableBasedIdentityCheckStrategy(new MyConnectionFactory(), GetGlobalConnectionOptions(), 'staff', 'username', 'password', '');
}

function CanUserChangeOwnPassword()
{
    return true;
}

?>