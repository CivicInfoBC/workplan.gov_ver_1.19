<?php
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 WorkPlan.Gov License Agreement
Copyright (c) 2013 - 2015, City of Courtenay.
All rights reserved.

This license is a legal agreement between you and City of Courtenay, for the use of WorkPlan.Gov Software (the "Software"). By obtaining the Software you agree to comply with the terms and conditions of this license.
Permitted Use
You are permitted to use, copy, modify, the Software and its documentation, with or without modification, for any purpose, provided that the following conditions are met:
1.	A copy of this license agreement must be included with the distribution.
2.	Source code must retain the above copyright notice in all source code files.
3.	Any files that have been modified must carry notices stating the nature of the change and the names of those who changed them.
4.	The Software shall not be published, propagated, distributed, sublicensed, and/or sold without expressed permission from the City of Courtenay.

Indemnity
You agree to indemnify and hold harmless the authors of the Software and any contributors for any direct, indirect, incidental, or consequential third-party claims, 
actions or suits, as well as any related expenses, liabilities, damages, settlements or fees arising from your use or misuse of the Software, or a violation of any terms of this license.
Disclaimer of Warranty
THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESSED OR IMPLIED, INCLUDING, BUT NOT LIMITED TO, WARRANTIES OF QUALITY, PERFORMANCE, NON-INFRINGEMENT, MERCHANTABILITY, OR FITNESS FOR A PARTICULAR PURPOSE.
Limitations of Liability
YOU ASSUME ALL RISK ASSOCIATED WITH THE INSTALLATION AND USE OF THE SOFTWARE. 
IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS OF THE SOFTWARE BE LIABLE FOR CLAIMS, DAMAGES OR OTHER LIABILITY ARISING FROM, OUT OF, OR IN CONNECTION WITH THE SOFTWARE. 
LICENSE HOLDERS ARE SOLELY RESPONSIBLE FOR DETERMINING THE APPROPRIATENESS OF USE AND ASSUME ALL RISKS ASSOCIATED WITH ITS USE, 
INCLUDING BUT NOT LIMITED TO THE RISKS OF PROGRAM ERRORS, DAMAGE TO EQUIPMENT, LOSS OF DATA OR SOFTWARE PROGRAMS, OR UNAVAILABILITY OR INTERRUPTION OF OPERATIONS.
 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 */


    include_once dirname(__FILE__) . '/' . 'components/utils/check_utils.php';
    CheckPHPVersion();
    CheckTemplatesCacheFolderIsExistsAndWritable();


    include_once dirname(__FILE__) . '/' . 'app_settings.php';
    include_once dirname(__FILE__) . '/' . 'database_engine/mysql_engine.php';
    include_once dirname(__FILE__) . '/' . 'components/page.php';
    include_once dirname(__FILE__) . '/' . 'authorization.php';

    function GetConnectionOptions()
    {
        $result = GetGlobalConnectionOptions();
        $result['client_encoding'] = 'utf8';
        GetApplication()->GetUserAuthorizationStrategy()->ApplyIdentityToConnectionOptions($result);
        return $result;
    }

    
    // OnGlobalBeforePageExecute event handler
    
    
    // OnBeforePageExecute event handler
    
    
    
    class timesheetPage extends Page
    {
        protected function DoBeforeCreate()
        {
            $this->dataset = new TableDataset(
                new MyConnectionFactory(),
                GetConnectionOptions(),
                '`timesheet`');
            $field = new IntegerField('timesheet_id', null, null, true);
            $field->SetIsNotNull(true);
            $this->dataset->AddField($field, true);
            $field = new StringField('name');
            $this->dataset->AddField($field, false);
            $field = new IntegerField('task_id');
            $this->dataset->AddField($field, false);
            $field = new StringField('hours');
            $this->dataset->AddField($field, false);
            $field = new StringField('notes');
            $field->SetIsNotNull(true);
            $this->dataset->AddField($field, false);
            $field = new StringField('time_type');
            $this->dataset->AddField($field, false);
            $field = new DateField('date');
            $field->SetIsNotNull(true);
            $this->dataset->AddField($field, false);
            $field = new IntegerField('staff_id');
            if (!$this->GetSecurityInfo()->AdminGrant())
              $field->SetReadOnly(true, GetApplication()->GetCurrentUserId());
            $field->SetIsNotNull(true);
            $this->dataset->AddField($field, false);
            $this->dataset->AddLookupField('task_id', 'task', new IntegerField('task_id', null, null, true), new StringField('task_name', 'task_id_task_name', 'task_id_task_name_task'), 'task_id_task_name_task');
        }
    
        protected function DoPrepare() {
    
        }
    
        protected function CreatePageNavigator()
        {
            $result = new CompositePageNavigator($this);
            
            $partitionNavigator = new PageNavigator('pnav', $this, $this->dataset);
            $partitionNavigator->SetRowsPerPage(20);
            $result->AddPageNavigator($partitionNavigator);
            
            return $result;
        }
    
        public function GetPageList()
        {
            $currentPageCaption = $this->GetShortCaption();
            $result = new PageList($this);
            $result->AddGroup($this->RenderText('Default'));
            if (GetCurrentUserGrantForDataSource('Dashboard')->HasViewGrant())
                $result->AddPage(new PageLink($this->RenderText('Dashboard'), 'Dashboard.php', $this->RenderText('Dashboard'), $currentPageCaption == $this->RenderText('Dashboard'), false, $this->RenderText('Default')));
            if (GetCurrentUserGrantForDataSource('program')->HasViewGrant())
                $result->AddPage(new PageLink($this->RenderText('Project Type'), 'program.php', $this->RenderText('Project Type'), $currentPageCaption == $this->RenderText('Project Type'), false, $this->RenderText('Default')));
            if (GetCurrentUserGrantForDataSource('project')->HasViewGrant())
                $result->AddPage(new PageLink($this->RenderText('View all Projects'), 'project.php', $this->RenderText('Project'), $currentPageCaption == $this->RenderText('View all Projects'), false, $this->RenderText('Default')));
            if (GetCurrentUserGrantForDataSource('task')->HasViewGrant())
                $result->AddPage(new PageLink($this->RenderText('Tasks - Time Tracking'), 'task.php', $this->RenderText('Tasks - Time Tracking'), $currentPageCaption == $this->RenderText('Tasks - Time Tracking'), false, $this->RenderText('Default')));
            if (GetCurrentUserGrantForDataSource('Hours per Project by user')->HasViewGrant())
                $result->AddPage(new PageLink($this->RenderText('Hours per Project'), 'Hours per project by user.php', $this->RenderText('Hours per project'), $currentPageCaption == $this->RenderText('Hours per Project'), false, $this->RenderText('Default')));
            if (GetCurrentUserGrantForDataSource('staff')->HasViewGrant())
                $result->AddPage(new PageLink($this->RenderText('Staff'), 'staff.php', $this->RenderText('Staff'), $currentPageCaption == $this->RenderText('Staff'), false, $this->RenderText('Default')));
            if (GetCurrentUserGrantForDataSource('department')->HasViewGrant())
                $result->AddPage(new PageLink($this->RenderText('Department'), 'department.php', $this->RenderText('Department'), $currentPageCaption == $this->RenderText('Department'), false, $this->RenderText('Default')));
            if (GetCurrentUserGrantForDataSource('timesheet')->HasViewGrant())
                $result->AddPage(new PageLink($this->RenderText('Time Tracking'), 'timesheet.php', $this->RenderText('Time Tracking'), $currentPageCaption == $this->RenderText('Time Tracking'), false, $this->RenderText('Default')));
            if (GetCurrentUserGrantForDataSource('Priority')->HasViewGrant())
                $result->AddPage(new PageLink($this->RenderText('Priority'), 'Priority.php', $this->RenderText('Priority'), $currentPageCaption == $this->RenderText('Priority'), false, $this->RenderText('Default')));
            if (GetCurrentUserGrantForDataSource('task_names')->HasViewGrant())
                $result->AddPage(new PageLink($this->RenderText('Task Names'), 'task_names.php', $this->RenderText('Task Names'), $currentPageCaption == $this->RenderText('Task Names'), false, $this->RenderText('Default')));
            if (GetCurrentUserGrantForDataSource('Pay Period')->HasViewGrant())
                $result->AddPage(new PageLink($this->RenderText('Pay Period'), 'Pay_Period.php', $this->RenderText('Pay Period'), $currentPageCaption == $this->RenderText('Pay Period'), false, $this->RenderText('Default')));
            if (GetCurrentUserGrantForDataSource('department_projects')->HasViewGrant())
                $result->AddPage(new PageLink($this->RenderText('Department Projects'), 'department_projects.php', $this->RenderText('Department Projects'), $currentPageCaption == $this->RenderText('Department Projects'), false, $this->RenderText('Default')));
            
            if ( HasAdminPage() && GetApplication()->HasAdminGrantForCurrentUser() ) {
              $result->AddGroup('Admin area');
              $result->AddPage(new PageLink($this->GetLocalizerCaptions()->GetMessageString('AdminPage'), 'app_admin.php', $this->GetLocalizerCaptions()->GetMessageString('AdminPage'), false, false, 'Admin area'));
            }
            return $result;
        }
    
        protected function CreateRssGenerator()
        {
            return null;
        }
    
        protected function CreateGridSearchControl(Grid $grid)
        {
            $grid->UseFilter = true;
            $grid->SearchControl = new SimpleSearch('timesheetssearch', $this->dataset,
                array('name', 'task_id_task_name', 'hours', 'notes', 'date'),
                array($this->RenderText('Name'), $this->RenderText('Task'), $this->RenderText('Hours'), $this->RenderText('Notes'), $this->RenderText('Date')),
                array(
                    '=' => $this->GetLocalizerCaptions()->GetMessageString('equals'),
                    '<>' => $this->GetLocalizerCaptions()->GetMessageString('doesNotEquals'),
                    '<' => $this->GetLocalizerCaptions()->GetMessageString('isLessThan'),
                    '<=' => $this->GetLocalizerCaptions()->GetMessageString('isLessThanOrEqualsTo'),
                    '>' => $this->GetLocalizerCaptions()->GetMessageString('isGreaterThan'),
                    '>=' => $this->GetLocalizerCaptions()->GetMessageString('isGreaterThanOrEqualsTo'),
                    'ILIKE' => $this->GetLocalizerCaptions()->GetMessageString('Like'),
                    'STARTS' => $this->GetLocalizerCaptions()->GetMessageString('StartsWith'),
                    'ENDS' => $this->GetLocalizerCaptions()->GetMessageString('EndsWith'),
                    'CONTAINS' => $this->GetLocalizerCaptions()->GetMessageString('Contains')
                    ), $this->GetLocalizerCaptions(), $this, 'CONTAINS'
                );
        }
    
        protected function CreateGridAdvancedSearchControl(Grid $grid)
        {
            $this->AdvancedSearchControl = new AdvancedSearchControl('timesheetasearch', $this->dataset, $this->GetLocalizerCaptions(), $this->GetColumnVariableContainer(), $this->CreateLinkBuilder());
            $this->AdvancedSearchControl->setTimerInterval(1000);
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('name', $this->RenderText('Name')));
            
            $lookupDataset = new TableDataset(
                new MyConnectionFactory(),
                GetConnectionOptions(),
                '`task`');
            $field = new IntegerField('task_id', null, null, true);
            $field->SetIsNotNull(true);
            $lookupDataset->AddField($field, true);
            $field = new IntegerField('project_id');
            $lookupDataset->AddField($field, false);
            $field = new StringField('assigned_to');
            $lookupDataset->AddField($field, false);
            $field = new DateField('date_start');
            $lookupDataset->AddField($field, false);
            $field = new DateField('date_end');
            $lookupDataset->AddField($field, false);
            $field = new StringField('task_name');
            $lookupDataset->AddField($field, false);
            $field = new StringField('notes');
            $field->SetIsNotNull(true);
            $lookupDataset->AddField($field, false);
            $field = new IntegerField('hrs');
            $lookupDataset->AddField($field, false);
            $field = new StringField('wo');
            $lookupDataset->AddField($field, false);
            $field = new IntegerField('staff_id');
            $lookupDataset->AddField($field, false);
            $lookupDataset->SetOrderBy('task_name', GetOrderTypeAsSQL(otAscending));
            $lookupDataset->AddCustomCondition(EnvVariablesUtils::EvaluateVariableTemplate($this->GetColumnVariableContainer(), '  task.assigned_to=%CURRENT_USER_ID%'));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateLookupSearchInput('task_id', $this->RenderText('Task'), $lookupDataset, 'task_id', 'task_name', false, 8));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('hours', $this->RenderText('Hours')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('notes', $this->RenderText('Notes')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateDateTimeSearchInput('date', $this->RenderText('Date'), 'Y-m-d'));
        }
    
        protected function AddOperationsColumns(Grid $grid)
        {
            $actionsBandName = 'actions';
            $grid->AddBandToBegin($actionsBandName, $this->GetLocalizerCaptions()->GetMessageString('Actions'), true);
            if ($this->GetSecurityInfo()->HasViewGrant())
            {
                $column = new RowOperationByLinkColumn($this->GetLocalizerCaptions()->GetMessageString('View'), OPERATION_VIEW, $this->dataset);
                $grid->AddViewColumn($column, $actionsBandName);
                $column->SetImagePath('images/view_action.png');
            }
            if ($this->GetSecurityInfo()->HasEditGrant())
            {
                $column = new RowOperationByLinkColumn($this->GetLocalizerCaptions()->GetMessageString('Edit'), OPERATION_EDIT, $this->dataset);
                $grid->AddViewColumn($column, $actionsBandName);
                $column->SetImagePath('images/edit_action.png');
                $column->OnShow->AddListener('ShowEditButtonHandler', $this);
            }
            if ($this->GetSecurityInfo()->HasDeleteGrant())
            {
                $column = new RowOperationByLinkColumn($this->GetLocalizerCaptions()->GetMessageString('Delete'), OPERATION_DELETE, $this->dataset);
                $grid->AddViewColumn($column, $actionsBandName);
                $column->SetImagePath('images/delete_action.png');
                $column->OnShow->AddListener('ShowDeleteButtonHandler', $this);
            $column->SetAdditionalAttribute("data-modal-delete", "true");
            $column->SetAdditionalAttribute("data-delete-handler-name", $this->GetModalGridDeleteHandler());
            }
            if ($this->GetSecurityInfo()->HasAddGrant())
            {
                $column = new RowOperationByLinkColumn($this->GetLocalizerCaptions()->GetMessageString('Copy'), OPERATION_COPY, $this->dataset);
                $grid->AddViewColumn($column, $actionsBandName);
                $column->SetImagePath('images/copy_action.png');
            }
        }
    
        protected function AddFieldColumns(Grid $grid)
        {
            //
            // View column for name field
            //
            $column = new TextViewColumn('name', 'Name', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('timesheetGrid_name_handler_list');
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for task_name field
            //
            $column = new TextViewColumn('task_id_task_name', 'Task', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for hours field
            //
            $column = new TextViewColumn('hours', 'Hours', $this->dataset);
            $grid->SetTotal($column, PredefinedAggregate::$Sum);
            $column->SetOrderable(true);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for notes field
            //
            $column = new TextViewColumn('notes', 'Notes', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('timesheetGrid_notes_handler_list');
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for date field
            //
            $column = new DateTimeViewColumn('date', 'Date', $this->dataset);
            $column->SetDateTimeFormat('Y-m-d');
            $column->SetOrderable(true);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
        }
    
        protected function AddSingleRecordViewColumns(Grid $grid)
        {
            //
            // View column for name field
            //
            $column = new TextViewColumn('name', 'Name', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('timesheetGrid_name_handler_view');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for task_name field
            //
            $column = new TextViewColumn('task_id_task_name', 'Task', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for hours field
            //
            $column = new TextViewColumn('hours', 'Hours', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for notes field
            //
            $column = new TextViewColumn('notes', 'Notes', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('timesheetGrid_notes_handler_view');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for date field
            //
            $column = new DateTimeViewColumn('date', 'Date', $this->dataset);
            $column->SetDateTimeFormat('Y-m-d');
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
        }
    
        protected function AddEditColumns(Grid $grid)
        {
            //
            // Edit column for name field
            //
            $editor = new TextEdit('name_edit');
            $editor->SetSize(50);
            $editor->SetMaxLength(100);
            $editColumn = new CustomEditColumn('Name', 'name', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for task_id field
            //
            $editor = new MultiLevelComboBoxEditor('task_id_edit', $this->CreateLinkBuilder());
            
            $dataset0 = new TableDataset(
                new MyConnectionFactory(),
                GetConnectionOptions(),
                '`project`');
            $field = new IntegerField('project_id', null, null, true);
            $field->SetIsNotNull(true);
            $dataset0->AddField($field, true);
            $field = new IntegerField('programm_id');
            $dataset0->AddField($field, false);
            $field = new StringField('project_name');
            $dataset0->AddField($field, false);
            $field = new DateField('date_start');
            $dataset0->AddField($field, false);
            $field = new DateField('date_end');
            $dataset0->AddField($field, false);
            $field = new IntegerField('approved_budget');
            $dataset0->AddField($field, false);
            $field = new StringField('notes');
            $field->SetIsNotNull(true);
            $dataset0->AddField($field, false);
            $field = new StringField('priority');
            $dataset0->AddField($field, false);
            $field = new StringField('lead');
            $dataset0->AddField($field, false);
            $field = new StringField('level_of_service');
            $field->SetIsNotNull(true);
            $dataset0->AddField($field, false);
            $field = new StringField('multi_year');
            $field->SetIsNotNull(true);
            $dataset0->AddField($field, false);
            $field = new StringField('public_engagement');
            $field->SetIsNotNull(true);
            $dataset0->AddField($field, false);
            $field = new StringField('year');
            $field->SetIsNotNull(true);
            $dataset0->AddField($field, false);
            $field = new StringField('approved');
            $field->SetIsNotNull(true);
            $dataset0->AddField($field, false);
            $field = new StringField('progress');
            $field->SetIsNotNull(true);
            $dataset0->AddField($field, false);
            $field = new IntegerField('staff_id');
            $field->SetIsNotNull(true);
            $dataset0->AddField($field, false);
            $field = new IntegerField('dept_id');
            $field->SetIsNotNull(true);
            $dataset0->AddField($field, false);
            $field = new IntegerField('budget_spent');
            $field->SetIsNotNull(true);
            $dataset0->AddField($field, false);
            $field = new IntegerField('admin_flag');
            $field->SetIsNotNull(true);
            $dataset0->AddField($field, false);
            
            $editor->AddLevel($dataset0, 'project_id', 'project_name', $this->RenderText('Project'), null);
            
            $dataset1 = new TableDataset(
                new MyConnectionFactory(),
                GetConnectionOptions(),
                '`task`');
            $field = new IntegerField('task_id', null, null, true);
            $field->SetIsNotNull(true);
            $dataset1->AddField($field, true);
            $field = new IntegerField('project_id');
            $dataset1->AddField($field, false);
            $field = new StringField('assigned_to');
            $dataset1->AddField($field, false);
            $field = new DateField('date_start');
            $dataset1->AddField($field, false);
            $field = new DateField('date_end');
            $dataset1->AddField($field, false);
            $field = new StringField('task_name');
            $dataset1->AddField($field, false);
            $field = new StringField('notes');
            $field->SetIsNotNull(true);
            $dataset1->AddField($field, false);
            $field = new IntegerField('hrs');
            $dataset1->AddField($field, false);
            $field = new StringField('wo');
            $dataset1->AddField($field, false);
            $field = new IntegerField('staff_id');
            $dataset1->AddField($field, false);
            $dataset1->SetOrderBy('task_name', GetOrderTypeAsSQL(otAscending));
            
            $editor->AddLevel($dataset1, 'task_id', 'task_name', $this->RenderText('Task'), new ForeignKeyInfo('project_id', 'project_id'));
            $editColumn = new MultiLevelLookupEditColumn('Task', 'task_id', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for hours field
            //
            $editor = new SpinEdit('hours_edit');
            $editColumn = new CustomEditColumn('Hours', 'hours', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $validator = new NumberValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('NumberValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for notes field
            //
            $editor = new TextAreaEdit('notes_edit', 50, 8);
            $editColumn = new CustomEditColumn('Notes', 'notes', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for date field
            //
            $editor = new DateTimeEdit('date_edit', false, 'Y-m-d', GetFirstDayOfWeek());
            $editColumn = new CustomEditColumn('Date', 'date', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
        }
    
        protected function AddInsertColumns(Grid $grid)
        {
            //
            // Edit column for name field
            //
            $editor = new TextEdit('name_edit');
            $editor->SetSize(50);
            $editor->SetMaxLength(100);
            $editColumn = new CustomEditColumn('Name', 'name', $editor, $this->dataset);
            $editColumn->SetInsertDefaultValue($this->RenderText('%CURRENT_USER_NAME%'));
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for task_id field
            //
            $editor = new MultiLevelComboBoxEditor('task_id_edit', $this->CreateLinkBuilder());
            
            $dataset0 = new TableDataset(
                new MyConnectionFactory(),
                GetConnectionOptions(),
                '`project`');
            $field = new IntegerField('project_id', null, null, true);
            $field->SetIsNotNull(true);
            $dataset0->AddField($field, true);
            $field = new IntegerField('programm_id');
            $dataset0->AddField($field, false);
            $field = new StringField('project_name');
            $dataset0->AddField($field, false);
            $field = new DateField('date_start');
            $dataset0->AddField($field, false);
            $field = new DateField('date_end');
            $dataset0->AddField($field, false);
            $field = new IntegerField('approved_budget');
            $dataset0->AddField($field, false);
            $field = new StringField('notes');
            $field->SetIsNotNull(true);
            $dataset0->AddField($field, false);
            $field = new StringField('priority');
            $dataset0->AddField($field, false);
            $field = new StringField('lead');
            $dataset0->AddField($field, false);
            $field = new StringField('level_of_service');
            $field->SetIsNotNull(true);
            $dataset0->AddField($field, false);
            $field = new StringField('multi_year');
            $field->SetIsNotNull(true);
            $dataset0->AddField($field, false);
            $field = new StringField('public_engagement');
            $field->SetIsNotNull(true);
            $dataset0->AddField($field, false);
            $field = new StringField('year');
            $field->SetIsNotNull(true);
            $dataset0->AddField($field, false);
            $field = new StringField('approved');
            $field->SetIsNotNull(true);
            $dataset0->AddField($field, false);
            $field = new StringField('progress');
            $field->SetIsNotNull(true);
            $dataset0->AddField($field, false);
            $field = new IntegerField('staff_id');
            $field->SetIsNotNull(true);
            $dataset0->AddField($field, false);
            $field = new IntegerField('dept_id');
            $field->SetIsNotNull(true);
            $dataset0->AddField($field, false);
            $field = new IntegerField('budget_spent');
            $field->SetIsNotNull(true);
            $dataset0->AddField($field, false);
            $field = new IntegerField('admin_flag');
            $field->SetIsNotNull(true);
            $dataset0->AddField($field, false);
            
            $editor->AddLevel($dataset0, 'project_id', 'project_name', $this->RenderText('Project'), null);
            
            $dataset1 = new TableDataset(
                new MyConnectionFactory(),
                GetConnectionOptions(),
                '`task`');
            $field = new IntegerField('task_id', null, null, true);
            $field->SetIsNotNull(true);
            $dataset1->AddField($field, true);
            $field = new IntegerField('project_id');
            $dataset1->AddField($field, false);
            $field = new StringField('assigned_to');
            $dataset1->AddField($field, false);
            $field = new DateField('date_start');
            $dataset1->AddField($field, false);
            $field = new DateField('date_end');
            $dataset1->AddField($field, false);
            $field = new StringField('task_name');
            $dataset1->AddField($field, false);
            $field = new StringField('notes');
            $field->SetIsNotNull(true);
            $dataset1->AddField($field, false);
            $field = new IntegerField('hrs');
            $dataset1->AddField($field, false);
            $field = new StringField('wo');
            $dataset1->AddField($field, false);
            $field = new IntegerField('staff_id');
            $dataset1->AddField($field, false);
            $dataset1->SetOrderBy('task_name', GetOrderTypeAsSQL(otAscending));
            
            $editor->AddLevel($dataset1, 'task_id', 'task_name', $this->RenderText('Task'), new ForeignKeyInfo('project_id', 'project_id'));
            $editColumn = new MultiLevelLookupEditColumn('Task', 'task_id', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for hours field
            //
            $editor = new SpinEdit('hours_edit');
            $editColumn = new CustomEditColumn('Hours', 'hours', $editor, $this->dataset);
            $editColumn->SetInsertDefaultValue($this->RenderText('7'));
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $validator = new NumberValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('NumberValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for notes field
            //
            $editor = new TextAreaEdit('notes_edit', 50, 8);
            $editColumn = new CustomEditColumn('Notes', 'notes', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for date field
            //
            $editor = new DateTimeEdit('date_edit', false, 'Y-m-d', GetFirstDayOfWeek());
            $editColumn = new CustomEditColumn('Date', 'date', $editor, $this->dataset);
            $editColumn->SetInsertDefaultValue($this->RenderText('%CURRENT_DATE%'));
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            if ($this->GetSecurityInfo()->HasAddGrant())
            {
                $grid->SetShowAddButton(true);
                $grid->SetShowInlineAddButton(false);
            }
            else
            {
                $grid->SetShowInlineAddButton(false);
                $grid->SetShowAddButton(false);
            }
        }
    
        protected function AddPrintColumns(Grid $grid)
        {
            //
            // View column for name field
            //
            $column = new TextViewColumn('name', 'Name', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for task_name field
            //
            $column = new TextViewColumn('task_id_task_name', 'Task', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for hours field
            //
            $column = new TextViewColumn('hours', 'Hours', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for notes field
            //
            $column = new TextViewColumn('notes', 'Notes', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for date field
            //
            $column = new DateTimeViewColumn('date', 'Date', $this->dataset);
            $column->SetDateTimeFormat('Y-m-d');
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
        }
    
        protected function AddExportColumns(Grid $grid)
        {
            //
            // View column for name field
            //
            $column = new TextViewColumn('name', 'Name', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for task_name field
            //
            $column = new TextViewColumn('task_id_task_name', 'Task', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for hours field
            //
            $column = new TextViewColumn('hours', 'Hours', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for notes field
            //
            $column = new TextViewColumn('notes', 'Notes', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for date field
            //
            $column = new DateTimeViewColumn('date', 'Date', $this->dataset);
            $column->SetDateTimeFormat('Y-m-d');
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
        }
    
        public function GetPageDirection()
        {
            return null;
        }
    
        protected function ApplyCommonColumnEditProperties(CustomEditColumn $column)
        {
            $column->SetDisplaySetToNullCheckBox(false);
            $column->SetDisplaySetToDefaultCheckBox(false);
    		$column->SetVariableContainer($this->GetColumnVariableContainer());
        }
    
        function BeforeBeginRenderPage()
        {
            if ($this->GetRecordPermission() != null)
        	       if (!$this->GetRecordPermission()->CanAllUsersViewRecords())
                     if (GetApplication()->GetCurrentUserId() == null)
                         $this->dataset->AddFieldFilter('staff_id', new IsNullFieldFilter());
                     else
        		             $this->dataset->AddFieldFilter('staff_id', new FieldFilter(GetApplication()->GetCurrentUserId(), '='));
        }
        
        function GetCustomClientScript()
        {
            return ;
        }
        
        function GetOnPageLoadedClientScript()
        {
            return ;
        }
        function timesheetGrid_OnCustomRenderTotal($totalValue, $aggregate, $columnName, &$customText, &$handled)
        {
            if ($columnName == 'hours')
            
            {
            
                $customText = '<strong>Total: ' . $totalValue . '</strong>';
            
                $handled = true;   
            
            }
        }
        function timesheetGrid_BeforeInsertRecord($page, &$rowData, &$cancel, &$message, $tableName)
        {
            $userID = $this->GetEnvVar('CURRENT_USER_ID');
            $rowData['staff_id'] = $userID;
        }
        public function ShowEditButtonHandler(&$show)
        {
            if ($this->GetRecordPermission() != null)
                $show = $this->GetRecordPermission()->HasEditGrant($this->GetDataset());
        }
        public function ShowDeleteButtonHandler(&$show)
        {
            if ($this->GetRecordPermission() != null)
                $show = $this->GetRecordPermission()->HasDeleteGrant($this->GetDataset());
        }
        
        public function GetModalGridDeleteHandler() { return 'timesheet_modal_delete'; }
        protected function GetEnableModalGridDelete() { return true; }
    
        protected function CreateGrid()
        {
            $result = new Grid($this, $this->dataset, 'timesheetGrid');
            if ($this->GetSecurityInfo()->HasDeleteGrant())
               $result->SetAllowDeleteSelected(true);
            else
               $result->SetAllowDeleteSelected(false);   
            
            ApplyCommonPageSettings($this, $result);
            
            $result->SetUseImagesForActions(true);
            $result->SetInsertClientValidationScript($this->RenderText('if (fieldValues[\'date\'] > %CURRENT_DATE% INTERVAL 14 DAY )
            {
              errorInfo.SetMessage(\'Date Must be no older than 14 days\');
              return false;
            }'));
            $result->SetUseFixedHeader(false);
            $result->SetShowLineNumbers(false);
            
            $result->SetHighlightRowAtHover(false);
            $result->SetWidth('');
            $result->OnCustomRenderTotal->AddListener('timesheetGrid' . '_' . 'OnCustomRenderTotal', $this);
            $result->BeforeInsertRecord->AddListener('timesheetGrid' . '_' . 'BeforeInsertRecord', $this);
            $this->CreateGridSearchControl($result);
            $this->CreateGridAdvancedSearchControl($result);
            $this->AddOperationsColumns($result);
            $this->AddFieldColumns($result);
            $this->AddSingleRecordViewColumns($result);
            $this->AddEditColumns($result);
            $this->AddInsertColumns($result);
            $this->AddPrintColumns($result);
            $this->AddExportColumns($result);
    
            $this->SetShowPageList(true);
            $this->SetHidePageListByDefault(false);
            $this->SetExportToExcelAvailable(true);
            $this->SetExportToWordAvailable(true);
            $this->SetExportToXmlAvailable(false);
            $this->SetExportToCsvAvailable(true);
            $this->SetExportToPdfAvailable(true);
            $this->SetPrinterFriendlyAvailable(true);
            $this->SetSimpleSearchAvailable(true);
            $this->SetAdvancedSearchAvailable(true);
            $this->SetFilterRowAvailable(true);
            $this->SetVisualEffectsEnabled(true);
            $this->SetShowTopPageNavigator(true);
            $this->SetShowBottomPageNavigator(true);
    
            //
            // Http Handlers
            //
            //
            // View column for name field
            //
            $column = new TextViewColumn('name', 'Name', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'timesheetGrid_name_handler_list', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            //
            // View column for notes field
            //
            $column = new TextViewColumn('notes', 'Notes', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'timesheetGrid_notes_handler_list', $column);
            GetApplication()->RegisterHTTPHandler($handler);//
            // View column for name field
            //
            $column = new TextViewColumn('name', 'Name', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'timesheetGrid_name_handler_view', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            //
            // View column for notes field
            //
            $column = new TextViewColumn('notes', 'Notes', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'timesheetGrid_notes_handler_view', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            return $result;
        }
        
        public function OpenAdvancedSearchByDefault()
        {
            return false;
        }
    
        protected function DoGetGridHeader()
        {
            return '';
        }
    }

    SetUpUserAuthorization(GetApplication());

    try
    {
        $Page = new timesheetPage("timesheet.php", "timesheet", GetCurrentUserGrantForDataSource("timesheet"), 'UTF-8');
        $Page->SetShortCaption('Time Tracking');
        $Page->SetHeader(GetPagesHeader());
        $Page->SetFooter(GetPagesFooter());
        $Page->SetCaption('Time Tracking');
        $Page->SetRecordPermission(GetCurrentUserRecordPermissionsForDataSource("timesheet"));
        GetApplication()->SetEnableLessRunTimeCompile(GetEnableLessFilesRunTimeCompilation());
        GetApplication()->SetCanUserChangeOwnPassword(
            !function_exists('CanUserChangeOwnPassword') || CanUserChangeOwnPassword());
        GetApplication()->SetMainPage($Page);
        GetApplication()->Run();
    }
    catch(Exception $e)
    {
        ShowErrorPage($e->getMessage());
    }
	
