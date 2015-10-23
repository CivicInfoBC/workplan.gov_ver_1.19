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

    
    
    // OnBeforePageExecute event handler
    
    
    
    class timesheetDetailView0taskPage extends DetailPage
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
            $field->SetIsNotNull(true);
            $this->dataset->AddField($field, false);
            $this->dataset->AddLookupField('task_id', 'task', new IntegerField('task_id', null, null, true), new StringField('task_name', 'task_id_task_name', 'task_id_task_name_task'), 'task_id_task_name_task');
        }
    
        protected function AddFieldColumns(Grid $grid)
        {
            //
            // View column for name field
            //
            $column = new TextViewColumn('name', 'Name', $this->dataset);
            $column->SetOrderable(false);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('timesheetDetailViewGrid0task_name_handler_list');
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for task_name field
            //
            $column = new TextViewColumn('task_id_task_name', 'Task', $this->dataset);
            $column->SetOrderable(false);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for hours field
            //
            $column = new TextViewColumn('hours', 'Hours', $this->dataset);
            $grid->SetTotal($column, PredefinedAggregate::$Sum);
            $column->SetOrderable(false);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for notes field
            //
            $column = new TextViewColumn('notes', 'Notes', $this->dataset);
            $column->SetOrderable(false);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('timesheetDetailViewGrid0task_notes_handler_list');
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for date field
            //
            $column = new DateTimeViewColumn('date', 'Date', $this->dataset);
            $column->SetDateTimeFormat('Y-m-d');
            $column->SetOrderable(false);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
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
        function timesheetDetailViewGrid0task_OnCustomRenderTotal($totalValue, $aggregate, $columnName, &$customText, &$handled)
        {
            if ($columnName == 'hours')
            
            {
            
                $customText = '<strong>Total: ' . $totalValue . '</strong>';
            
                $handled = true;   
            
            }
        }
        function timesheetDetailViewGrid0task_BeforeInsertRecord($page, &$rowData, &$cancel, &$message, $tableName)
        {
            $userID = $this->GetEnvVar('CURRENT_USER_ID');
            $rowData['staff_id'] = $userID;
        }
    
        public function GetPageDirection()
        {
            return null;
        }
    
        protected function ApplyCommonColumnEditProperties(CustomEditColumn $column)
        {
            $column->SetDisplaySetToNullCheckBox(false);
            $column->SetDisplaySetToDefaultCheckBox(false);
        }
    
        protected function CreateGrid()
        {
            $result = new Grid($this, $this->dataset, 'timesheetDetailViewGrid0task');
            $result->SetAllowDeleteSelected(false);
            $result->SetInsertClientValidationScript($this->RenderText('if (fieldValues[\'date\'] > %CURRENT_DATE% INTERVAL 14 DAY )
            {
              errorInfo.SetMessage(\'Date Must be no older than 14 days\');
              return false;
            }'));
            $result->SetUseFixedHeader(false);
            $result->SetShowLineNumbers(false);
            
            $result->SetHighlightRowAtHover(false);
            $result->SetWidth('');
            $result->OnCustomRenderTotal->AddListener('timesheetDetailViewGrid0task' . '_' . 'OnCustomRenderTotal', $this);
            $result->BeforeInsertRecord->AddListener('timesheetDetailViewGrid0task' . '_' . 'BeforeInsertRecord', $this);
            $this->AddFieldColumns($result);
            //
            // View column for name field
            //
            $column = new TextViewColumn('name', 'Name', $this->dataset);
            $column->SetOrderable(false);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'timesheetDetailViewGrid0task_name_handler_list', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            //
            // View column for notes field
            //
            $column = new TextViewColumn('notes', 'Notes', $this->dataset);
            $column->SetOrderable(false);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'timesheetDetailViewGrid0task_notes_handler_list', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            return $result;
        }
    }
    
    
    
    // OnBeforePageExecute event handler
    
    
    
    class timesheetDetailEdit0taskPage extends DetailPageEdit
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
              $field->SetReadOnly(false, GetApplication()->GetCurrentUserId());
            $field->SetIsNotNull(true);
            $this->dataset->AddField($field, false);
            $this->dataset->AddLookupField('task_id', 'task', new IntegerField('task_id', null, null, true), new StringField('task_name', 'task_id_task_name', 'task_id_task_name_task'), 'task_id_task_name_task');
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
            return null;
        }
    
        protected function CreateRssGenerator()
        {
            return null;
        }
    
        protected function CreateGridSearchControl(Grid $grid)
        {
            $grid->UseFilter = true;
            $grid->SearchControl = new SimpleSearch('timesheetDetailEdit0taskssearch', $this->dataset,
                array('timesheet_id', 'name', 'task_id_task_name', 'hours', 'notes', 'date'),
                array($this->RenderText('Timesheet Id'), $this->RenderText('Name'), $this->RenderText('Task'), $this->RenderText('Hours'), $this->RenderText('Notes'), $this->RenderText('Date')),
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
            $this->AdvancedSearchControl = new AdvancedSearchControl('timesheetDetailEdit0taskasearch', $this->dataset, $this->GetLocalizerCaptions(), $this->GetColumnVariableContainer(), $this->CreateLinkBuilder());
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
            $lookupDataset->AddCustomCondition(EnvVariablesUtils::EvaluateVariableTemplate($this->GetColumnVariableContainer(), 'task.assigned_to=%CURRENT_USER_ID%'));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateLookupSearchInput('task_id', $this->RenderText('Task'), $lookupDataset, 'task_id', 'task_name', false, 8));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('hours', $this->RenderText('Hours')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('notes', $this->RenderText('Notes')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateDateTimeSearchInput('date', $this->RenderText('Date'), 'Y-m-d'));
        }
    
        public function GetPageDirection()
        {
            return null;
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
            $column->SetFullTextWindowHandlerName('timesheetDetailEditGrid0task_name_handler_list');
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
            $column->SetFullTextWindowHandlerName('timesheetDetailEditGrid0task_notes_handler_list');
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
            $column->SetFullTextWindowHandlerName('timesheetDetailEditGrid0task_name_handler_view');
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
            $column->SetFullTextWindowHandlerName('timesheetDetailEditGrid0task_notes_handler_view');
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
            $editor->SetMaxLength(50);
            $editColumn = new CustomEditColumn('Name', 'name', $editor, $this->dataset);
            $editColumn->SetReadOnly(true);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for task_id field
            //
            $editor = new ComboBox('task_id_edit', $this->GetLocalizerCaptions()->GetMessageString('PleaseSelect'));
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
            $lookupDataset->AddCustomCondition(EnvVariablesUtils::EvaluateVariableTemplate($this->GetColumnVariableContainer(), 'task.assigned_to=%CURRENT_USER_ID%'));
            $editColumn = new LookUpEditColumn(
                'Task', 
                'task_id', 
                $editor, 
                $this->dataset, 'task_id', 'task_name', $lookupDataset);
            $editColumn->SetReadOnly(true);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for hours field
            //
            $editor = new TextEdit('hours_edit');
            $editor->SetSize(20);
            $editor->SetMaxLength(20);
            $editColumn = new CustomEditColumn('Hours', 'hours', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
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
            $editor->SetMaxLength(50);
            $editColumn = new CustomEditColumn('Name', 'name', $editor, $this->dataset);
            $editColumn->SetReadOnly(true);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetInsertDefaultValue($this->RenderText('%CURRENT_USER_NAME%'));
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for task_id field
            //
            $editor = new ComboBox('task_id_edit', $this->GetLocalizerCaptions()->GetMessageString('PleaseSelect'));
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
            $lookupDataset->AddCustomCondition(EnvVariablesUtils::EvaluateVariableTemplate($this->GetColumnVariableContainer(), 'task.assigned_to=%CURRENT_USER_ID%'));
            $editColumn = new LookUpEditColumn(
                'Task', 
                'task_id', 
                $editor, 
                $this->dataset, 'task_id', 'task_name', $lookupDataset);
            $editColumn->SetReadOnly(true);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for hours field
            //
            $editor = new TextEdit('hours_edit');
            $editor->SetSize(20);
            $editor->SetMaxLength(20);
            $editColumn = new CustomEditColumn('Hours', 'hours', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetInsertDefaultValue($this->RenderText('7'));
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
        function timesheetDetailEditGrid0task_OnCustomRenderTotal($totalValue, $aggregate, $columnName, &$customText, &$handled)
        {
            if ($columnName == 'hours')
            
            {
            
                $customText = '<strong>Total: ' . $totalValue . '</strong>';
            
                $handled = true;   
            
            }
        }
        function timesheetDetailEditGrid0task_BeforeInsertRecord($page, &$rowData, &$cancel, &$message, $tableName)
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
        
        public function GetModalGridDeleteHandler() { return 'timesheetDetailEdit0task_modal_delete'; }
        protected function GetEnableModalGridDelete() { return true; }
    
        protected function CreateGrid()
        {
            $result = new Grid($this, $this->dataset, 'timesheetDetailEditGrid0task');
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
            $result->OnCustomRenderTotal->AddListener('timesheetDetailEditGrid0task' . '_' . 'OnCustomRenderTotal', $this);
            $result->BeforeInsertRecord->AddListener('timesheetDetailEditGrid0task' . '_' . 'BeforeInsertRecord', $this);
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
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'timesheetDetailEditGrid0task_name_handler_list', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            //
            // View column for notes field
            //
            $column = new TextViewColumn('notes', 'Notes', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'timesheetDetailEditGrid0task_notes_handler_list', $column);
            GetApplication()->RegisterHTTPHandler($handler);//
            // View column for name field
            //
            $column = new TextViewColumn('name', 'Name', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'timesheetDetailEditGrid0task_name_handler_view', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            //
            // View column for notes field
            //
            $column = new TextViewColumn('notes', 'Notes', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'timesheetDetailEditGrid0task_notes_handler_view', $column);
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
    // OnGlobalBeforePageExecute event handler
    
    
    // OnBeforePageExecute event handler
    function isProjectApproved($connection, $project_id) {
      $approved = 0;
      $sqlText = 'SELECT approved FROM project WHERE project_id = '. $project_id;
      $approved = $connection->ExecScalarSQL($sqlText);
      return ($approved == 1);
    }
    
    
    class taskPage extends Page
    {
        protected function DoBeforeCreate()
        {
            $this->dataset = new TableDataset(
                new MyConnectionFactory(),
                GetConnectionOptions(),
                '`task`');
            $field = new IntegerField('task_id', null, null, true);
            $field->SetIsNotNull(true);
            $this->dataset->AddField($field, true);
            $field = new IntegerField('project_id');
            $this->dataset->AddField($field, false);
            $field = new StringField('assigned_to');
            $this->dataset->AddField($field, false);
            $field = new DateField('date_start');
            $this->dataset->AddField($field, false);
            $field = new DateField('date_end');
            $this->dataset->AddField($field, false);
            $field = new StringField('task_name');
            $this->dataset->AddField($field, false);
            $field = new StringField('notes');
            $field->SetIsNotNull(true);
            $this->dataset->AddField($field, false);
            $field = new IntegerField('hrs');
            $this->dataset->AddField($field, false);
            $field = new StringField('wo');
            $this->dataset->AddField($field, false);
            $field = new IntegerField('staff_id');
            if (!$this->GetSecurityInfo()->AdminGrant())
              $field->SetReadOnly(false, GetApplication()->GetCurrentUserId());
            $this->dataset->AddField($field, false);
            $this->dataset->AddLookupField('project_id', 'project', new IntegerField('project_id', null, null, true), new StringField('project_name', 'project_id_project_name', 'project_id_project_name_project'), 'project_id_project_name_project');
            $this->dataset->AddLookupField('task_name', 'task_names', new StringField('Name'), new StringField('Name', 'task_name_Name', 'task_name_Name_task_names'), 'task_name_Name_task_names');
            $this->dataset->AddLookupField('assigned_to', 'staff', new IntegerField('staff_id', null, null, true), new StringField('username', 'assigned_to_username', 'assigned_to_username_staff'), 'assigned_to_username_staff');
        }
    
        protected function DoPrepare() {
            foreach ($this->GetGrid()->GetEditColumns() as $column) {
              if ($column->GetFieldName() == 'approved')
                $column->setEnabled(GetApplication()->HasAdminGrantForCurrentUser());
            }
            
            foreach ($this->GetGrid()->GetInsertColumns() as $column) {
              if ($column->GetFieldName() == 'approved')
                $column->setEnabled(GetApplication()->HasAdminGrantForCurrentUser());
            }
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
            $grid->SearchControl = new SimpleSearch('taskssearch', $this->dataset,
                array('project_id_project_name', 'task_name_Name', 'notes', 'hrs', 'assigned_to_username', 'date_start', 'date_end'),
                array($this->RenderText('Project'), $this->RenderText('Name'), $this->RenderText('Notes'), $this->RenderText('Allocated Hours'), $this->RenderText('Assigned To'), $this->RenderText('Date Start'), $this->RenderText('Date End')),
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
            $this->AdvancedSearchControl = new AdvancedSearchControl('taskasearch', $this->dataset, $this->GetLocalizerCaptions(), $this->GetColumnVariableContainer(), $this->CreateLinkBuilder());
            $this->AdvancedSearchControl->setTimerInterval(1000);
            $lookupDataset = new TableDataset(
                new MyConnectionFactory(),
                GetConnectionOptions(),
                '`project`');
            $field = new IntegerField('project_id', null, null, true);
            $field->SetIsNotNull(true);
            $lookupDataset->AddField($field, true);
            $field = new IntegerField('programm_id');
            $lookupDataset->AddField($field, false);
            $field = new StringField('project_name');
            $lookupDataset->AddField($field, false);
            $field = new DateField('date_start');
            $lookupDataset->AddField($field, false);
            $field = new DateField('date_end');
            $lookupDataset->AddField($field, false);
            $field = new IntegerField('approved_budget');
            $lookupDataset->AddField($field, false);
            $field = new StringField('notes');
            $field->SetIsNotNull(true);
            $lookupDataset->AddField($field, false);
            $field = new StringField('priority');
            $lookupDataset->AddField($field, false);
            $field = new StringField('lead');
            $lookupDataset->AddField($field, false);
            $field = new StringField('level_of_service');
            $field->SetIsNotNull(true);
            $lookupDataset->AddField($field, false);
            $field = new StringField('multi_year');
            $field->SetIsNotNull(true);
            $lookupDataset->AddField($field, false);
            $field = new StringField('public_engagement');
            $field->SetIsNotNull(true);
            $lookupDataset->AddField($field, false);
            $field = new StringField('year');
            $field->SetIsNotNull(true);
            $lookupDataset->AddField($field, false);
            $field = new StringField('approved');
            $field->SetIsNotNull(true);
            $lookupDataset->AddField($field, false);
            $field = new StringField('progress');
            $field->SetIsNotNull(true);
            $lookupDataset->AddField($field, false);
            $field = new IntegerField('staff_id');
            $field->SetIsNotNull(true);
            $lookupDataset->AddField($field, false);
            $field = new IntegerField('dept_id');
            $field->SetIsNotNull(true);
            $lookupDataset->AddField($field, false);
            $field = new IntegerField('budget_spent');
            $field->SetIsNotNull(true);
            $lookupDataset->AddField($field, false);
            $field = new IntegerField('admin_flag');
            $field->SetIsNotNull(true);
            $lookupDataset->AddField($field, false);
            $lookupDataset->SetOrderBy('project_name', GetOrderTypeAsSQL(otAscending));
            $lookupDataset->AddCustomCondition(EnvVariablesUtils::EvaluateVariableTemplate($this->GetColumnVariableContainer(), '%CURRENT_USER_ID%  = 1  OR project.lead=%CURRENT_USER_ID%'));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateLookupSearchInput('project_id', $this->RenderText('Project'), $lookupDataset, 'project_id', 'project_name', false, 8));
            
            $lookupDataset = new TableDataset(
                new MyConnectionFactory(),
                GetConnectionOptions(),
                '`task_names`');
            $field = new IntegerField('id', null, null, true);
            $field->SetIsNotNull(true);
            $lookupDataset->AddField($field, true);
            $field = new StringField('Name');
            $lookupDataset->AddField($field, false);
            $lookupDataset->SetOrderBy('Name', GetOrderTypeAsSQL(otAscending));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateLookupSearchInput('task_name', $this->RenderText('Name'), $lookupDataset, 'Name', 'Name', false, 8));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('notes', $this->RenderText('Notes')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('hrs', $this->RenderText('Allocated Hours')));
            
            $lookupDataset = new TableDataset(
                new MyConnectionFactory(),
                GetConnectionOptions(),
                '`staff`');
            $field = new IntegerField('staff_id', null, null, true);
            $field->SetIsNotNull(true);
            $lookupDataset->AddField($field, true);
            $field = new StringField('username');
            $field->SetIsNotNull(true);
            $lookupDataset->AddField($field, false);
            $field = new StringField('email');
            $field->SetIsNotNull(true);
            $lookupDataset->AddField($field, false);
            $field = new StringField('picture');
            $field->SetIsNotNull(true);
            $lookupDataset->AddField($field, false);
            $field = new StringField('password');
            $field->SetIsNotNull(true);
            $lookupDataset->AddField($field, false);
            $field = new IntegerField('dept_id');
            $field->SetIsNotNull(true);
            $lookupDataset->AddField($field, false);
            $field = new StringField('position');
            $field->SetIsNotNull(true);
            $lookupDataset->AddField($field, false);
            $field = new StringField('emp_number');
            $field->SetIsNotNull(true);
            $lookupDataset->AddField($field, false);
            $lookupDataset->SetOrderBy('username', GetOrderTypeAsSQL(otAscending));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateLookupSearchInput('assigned_to', $this->RenderText('Assigned To'), $lookupDataset, 'staff_id', 'username', false, 8));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateDateTimeSearchInput('date_start', $this->RenderText('Date Start'), 'Y-m-d'));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateDateTimeSearchInput('date_end', $this->RenderText('Date End'), 'Y-m-d'));
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
            if (GetCurrentUserGrantForDataSource('task.timesheet')->HasViewGrant())
            {
              //
            // View column for timesheetDetailView0task detail
            //
            $column = new DetailColumn(array('task_id'), 'detail0task', 'timesheetDetailEdit0task_handler', 'timesheetDetailView0task_handler', $this->dataset, 'Timesheet', $this->RenderText('Timesheet'));
              $grid->AddViewColumn($column);
            }
            
            //
            // View column for project_name field
            //
            $column = new TextViewColumn('project_id_project_name', 'Project', $this->dataset);
            $column->SetOrderable(true);
            $column = new ExtendedHyperLinkColumnDecorator($column, $this->dataset, 'project.php?operation=view&pk0=%project_id%' , '');
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for Name field
            //
            $column = new TextViewColumn('task_name_Name', 'Name', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('taskGrid_Name_handler_list');
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for notes field
            //
            $column = new TextViewColumn('notes', 'Notes', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('taskGrid_notes_handler_list');
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for hrs field
            //
            $column = new TextViewColumn('hrs', 'Allocated Hours', $this->dataset);
            $grid->SetTotal($column, PredefinedAggregate::$Sum);
            $column->SetOrderable(true);
            $column = new NumberFormatValueViewColumnDecorator($column, 2, ',', '.');
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for username field
            //
            $column = new TextViewColumn('assigned_to_username', 'Assigned To', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for date_start field
            //
            $column = new DateTimeViewColumn('date_start', 'Date Start', $this->dataset);
            $column->SetDateTimeFormat('Y-m-d');
            $column->SetOrderable(true);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for date_end field
            //
            $column = new DateTimeViewColumn('date_end', 'Date End', $this->dataset);
            $column->SetDateTimeFormat('Y-m-d');
            $column->SetOrderable(true);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
        }
    
        protected function AddSingleRecordViewColumns(Grid $grid)
        {
            //
            // View column for project_name field
            //
            $column = new TextViewColumn('project_id_project_name', 'Project', $this->dataset);
            $column->SetOrderable(true);
            $column = new ExtendedHyperLinkColumnDecorator($column, $this->dataset, 'project.php?operation=view&pk0=%project_id%' , '');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Name field
            //
            $column = new TextViewColumn('task_name_Name', 'Name', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('taskGrid_Name_handler_view');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for notes field
            //
            $column = new TextViewColumn('notes', 'Notes', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('taskGrid_notes_handler_view');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for hrs field
            //
            $column = new TextViewColumn('hrs', 'Allocated Hours', $this->dataset);
            $column->SetOrderable(true);
            $column = new NumberFormatValueViewColumnDecorator($column, 2, ',', '.');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for username field
            //
            $column = new TextViewColumn('assigned_to_username', 'Assigned To', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for date_start field
            //
            $column = new DateTimeViewColumn('date_start', 'Date Start', $this->dataset);
            $column->SetDateTimeFormat('Y-m-d');
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for date_end field
            //
            $column = new DateTimeViewColumn('date_end', 'Date End', $this->dataset);
            $column->SetDateTimeFormat('Y-m-d');
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
        }
    
        protected function AddEditColumns(Grid $grid)
        {
            //
            // Edit column for project_id field
            //
            $editor = new ComboBox('project_id_edit', $this->GetLocalizerCaptions()->GetMessageString('PleaseSelect'));
            $lookupDataset = new TableDataset(
                new MyConnectionFactory(),
                GetConnectionOptions(),
                '`project`');
            $field = new IntegerField('project_id', null, null, true);
            $field->SetIsNotNull(true);
            $lookupDataset->AddField($field, true);
            $field = new IntegerField('programm_id');
            $lookupDataset->AddField($field, false);
            $field = new StringField('project_name');
            $lookupDataset->AddField($field, false);
            $field = new DateField('date_start');
            $lookupDataset->AddField($field, false);
            $field = new DateField('date_end');
            $lookupDataset->AddField($field, false);
            $field = new IntegerField('approved_budget');
            $lookupDataset->AddField($field, false);
            $field = new StringField('notes');
            $field->SetIsNotNull(true);
            $lookupDataset->AddField($field, false);
            $field = new StringField('priority');
            $lookupDataset->AddField($field, false);
            $field = new StringField('lead');
            $lookupDataset->AddField($field, false);
            $field = new StringField('level_of_service');
            $field->SetIsNotNull(true);
            $lookupDataset->AddField($field, false);
            $field = new StringField('multi_year');
            $field->SetIsNotNull(true);
            $lookupDataset->AddField($field, false);
            $field = new StringField('public_engagement');
            $field->SetIsNotNull(true);
            $lookupDataset->AddField($field, false);
            $field = new StringField('year');
            $field->SetIsNotNull(true);
            $lookupDataset->AddField($field, false);
            $field = new StringField('approved');
            $field->SetIsNotNull(true);
            $lookupDataset->AddField($field, false);
            $field = new StringField('progress');
            $field->SetIsNotNull(true);
            $lookupDataset->AddField($field, false);
            $field = new IntegerField('staff_id');
            $field->SetIsNotNull(true);
            $lookupDataset->AddField($field, false);
            $field = new IntegerField('dept_id');
            $field->SetIsNotNull(true);
            $lookupDataset->AddField($field, false);
            $field = new IntegerField('budget_spent');
            $field->SetIsNotNull(true);
            $lookupDataset->AddField($field, false);
            $field = new IntegerField('admin_flag');
            $field->SetIsNotNull(true);
            $lookupDataset->AddField($field, false);
            $lookupDataset->SetOrderBy('project_name', GetOrderTypeAsSQL(otAscending));
            $lookupDataset->AddCustomCondition(EnvVariablesUtils::EvaluateVariableTemplate($this->GetColumnVariableContainer(), '%CURRENT_USER_ID%  = 1  OR project.lead=%CURRENT_USER_ID%'));
            $editColumn = new LookUpEditColumn(
                'Project', 
                'project_id', 
                $editor, 
                $this->dataset, 'project_id', 'project_name', $lookupDataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for task_name field
            //
            $editor = new AutocomleteComboBox('task_name_edit', $this->CreateLinkBuilder());
            $editor->SetSize('250px');
            $lookupDataset = new TableDataset(
                new MyConnectionFactory(),
                GetConnectionOptions(),
                '`task_names`');
            $field = new IntegerField('id', null, null, true);
            $field->SetIsNotNull(true);
            $lookupDataset->AddField($field, true);
            $field = new StringField('Name');
            $lookupDataset->AddField($field, false);
            $lookupDataset->SetOrderBy('Name', GetOrderTypeAsSQL(otAscending));
            $editColumn = new DynamicLookupEditColumn('Name', 'task_name', 'task_name_Name', 'edit_task_name_Name_search', $editor, $this->dataset, $lookupDataset, 'Name', 'Name', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
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
            // Edit column for hrs field
            //
            $editor = new SpinEdit('hrs_edit');
            $editColumn = new CustomEditColumn('Allocated Hours', 'hrs', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $validator = new NumberValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('NumberValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for assigned_to field
            //
            $editor = new ComboBox('assigned_to_edit', $this->GetLocalizerCaptions()->GetMessageString('PleaseSelect'));
            $lookupDataset = new TableDataset(
                new MyConnectionFactory(),
                GetConnectionOptions(),
                '`staff`');
            $field = new IntegerField('staff_id', null, null, true);
            $field->SetIsNotNull(true);
            $lookupDataset->AddField($field, true);
            $field = new StringField('username');
            $field->SetIsNotNull(true);
            $lookupDataset->AddField($field, false);
            $field = new StringField('email');
            $field->SetIsNotNull(true);
            $lookupDataset->AddField($field, false);
            $field = new StringField('picture');
            $field->SetIsNotNull(true);
            $lookupDataset->AddField($field, false);
            $field = new StringField('password');
            $field->SetIsNotNull(true);
            $lookupDataset->AddField($field, false);
            $field = new IntegerField('dept_id');
            $field->SetIsNotNull(true);
            $lookupDataset->AddField($field, false);
            $field = new StringField('position');
            $field->SetIsNotNull(true);
            $lookupDataset->AddField($field, false);
            $field = new StringField('emp_number');
            $field->SetIsNotNull(true);
            $lookupDataset->AddField($field, false);
            $lookupDataset->SetOrderBy('username', GetOrderTypeAsSQL(otAscending));
            $editColumn = new LookUpEditColumn(
                'Assigned To', 
                'assigned_to', 
                $editor, 
                $this->dataset, 'staff_id', 'username', $lookupDataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for date_start field
            //
            $editor = new DateTimeEdit('date_start_edit', false, 'Y-m-d', GetFirstDayOfWeek());
            $editColumn = new CustomEditColumn('Date Start', 'date_start', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for date_end field
            //
            $editor = new DateTimeEdit('date_end_edit', true, 'Y-m-d', GetFirstDayOfWeek());
            $editColumn = new CustomEditColumn('Date End', 'date_end', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
        }
    
        protected function AddInsertColumns(Grid $grid)
        {
            //
            // Edit column for project_id field
            //
            $editor = new ComboBox('project_id_edit', $this->GetLocalizerCaptions()->GetMessageString('PleaseSelect'));
            $lookupDataset = new TableDataset(
                new MyConnectionFactory(),
                GetConnectionOptions(),
                '`project`');
            $field = new IntegerField('project_id', null, null, true);
            $field->SetIsNotNull(true);
            $lookupDataset->AddField($field, true);
            $field = new IntegerField('programm_id');
            $lookupDataset->AddField($field, false);
            $field = new StringField('project_name');
            $lookupDataset->AddField($field, false);
            $field = new DateField('date_start');
            $lookupDataset->AddField($field, false);
            $field = new DateField('date_end');
            $lookupDataset->AddField($field, false);
            $field = new IntegerField('approved_budget');
            $lookupDataset->AddField($field, false);
            $field = new StringField('notes');
            $field->SetIsNotNull(true);
            $lookupDataset->AddField($field, false);
            $field = new StringField('priority');
            $lookupDataset->AddField($field, false);
            $field = new StringField('lead');
            $lookupDataset->AddField($field, false);
            $field = new StringField('level_of_service');
            $field->SetIsNotNull(true);
            $lookupDataset->AddField($field, false);
            $field = new StringField('multi_year');
            $field->SetIsNotNull(true);
            $lookupDataset->AddField($field, false);
            $field = new StringField('public_engagement');
            $field->SetIsNotNull(true);
            $lookupDataset->AddField($field, false);
            $field = new StringField('year');
            $field->SetIsNotNull(true);
            $lookupDataset->AddField($field, false);
            $field = new StringField('approved');
            $field->SetIsNotNull(true);
            $lookupDataset->AddField($field, false);
            $field = new StringField('progress');
            $field->SetIsNotNull(true);
            $lookupDataset->AddField($field, false);
            $field = new IntegerField('staff_id');
            $field->SetIsNotNull(true);
            $lookupDataset->AddField($field, false);
            $field = new IntegerField('dept_id');
            $field->SetIsNotNull(true);
            $lookupDataset->AddField($field, false);
            $field = new IntegerField('budget_spent');
            $field->SetIsNotNull(true);
            $lookupDataset->AddField($field, false);
            $field = new IntegerField('admin_flag');
            $field->SetIsNotNull(true);
            $lookupDataset->AddField($field, false);
            $lookupDataset->SetOrderBy('project_name', GetOrderTypeAsSQL(otAscending));
            $lookupDataset->AddCustomCondition(EnvVariablesUtils::EvaluateVariableTemplate($this->GetColumnVariableContainer(), '%CURRENT_USER_ID%  = 1  OR project.lead=%CURRENT_USER_ID%'));
            $editColumn = new LookUpEditColumn(
                'Project', 
                'project_id', 
                $editor, 
                $this->dataset, 'project_id', 'project_name', $lookupDataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for task_name field
            //
            $editor = new AutocomleteComboBox('task_name_edit', $this->CreateLinkBuilder());
            $editor->SetSize('250px');
            $lookupDataset = new TableDataset(
                new MyConnectionFactory(),
                GetConnectionOptions(),
                '`task_names`');
            $field = new IntegerField('id', null, null, true);
            $field->SetIsNotNull(true);
            $lookupDataset->AddField($field, true);
            $field = new StringField('Name');
            $lookupDataset->AddField($field, false);
            $lookupDataset->SetOrderBy('Name', GetOrderTypeAsSQL(otAscending));
            $editColumn = new DynamicLookupEditColumn('Name', 'task_name', 'task_name_Name', 'insert_task_name_Name_search', $editor, $this->dataset, $lookupDataset, 'Name', 'Name', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
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
            // Edit column for hrs field
            //
            $editor = new SpinEdit('hrs_edit');
            $editColumn = new CustomEditColumn('Allocated Hours', 'hrs', $editor, $this->dataset);
            $editColumn->SetInsertDefaultValue($this->RenderText('21'));
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $validator = new NumberValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('NumberValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for assigned_to field
            //
            $editor = new ComboBox('assigned_to_edit', $this->GetLocalizerCaptions()->GetMessageString('PleaseSelect'));
            $lookupDataset = new TableDataset(
                new MyConnectionFactory(),
                GetConnectionOptions(),
                '`staff`');
            $field = new IntegerField('staff_id', null, null, true);
            $field->SetIsNotNull(true);
            $lookupDataset->AddField($field, true);
            $field = new StringField('username');
            $field->SetIsNotNull(true);
            $lookupDataset->AddField($field, false);
            $field = new StringField('email');
            $field->SetIsNotNull(true);
            $lookupDataset->AddField($field, false);
            $field = new StringField('picture');
            $field->SetIsNotNull(true);
            $lookupDataset->AddField($field, false);
            $field = new StringField('password');
            $field->SetIsNotNull(true);
            $lookupDataset->AddField($field, false);
            $field = new IntegerField('dept_id');
            $field->SetIsNotNull(true);
            $lookupDataset->AddField($field, false);
            $field = new StringField('position');
            $field->SetIsNotNull(true);
            $lookupDataset->AddField($field, false);
            $field = new StringField('emp_number');
            $field->SetIsNotNull(true);
            $lookupDataset->AddField($field, false);
            $lookupDataset->SetOrderBy('username', GetOrderTypeAsSQL(otAscending));
            $editColumn = new LookUpEditColumn(
                'Assigned To', 
                'assigned_to', 
                $editor, 
                $this->dataset, 'staff_id', 'username', $lookupDataset);
            $editColumn->SetInsertDefaultValue($this->RenderText('%CURRENT_USER_ID%'));
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for date_start field
            //
            $editor = new DateTimeEdit('date_start_edit', false, 'Y-m-d', GetFirstDayOfWeek());
            $editColumn = new CustomEditColumn('Date Start', 'date_start', $editor, $this->dataset);
            $editColumn->SetInsertDefaultValue($this->RenderText('%CURRENT_DATE%'));
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for date_end field
            //
            $editor = new DateTimeEdit('date_end_edit', true, 'Y-m-d', GetFirstDayOfWeek());
            $editColumn = new CustomEditColumn('Date End', 'date_end', $editor, $this->dataset);
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
            // View column for project_name field
            //
            $column = new TextViewColumn('project_id_project_name', 'Project', $this->dataset);
            $column->SetOrderable(true);
            $column = new ExtendedHyperLinkColumnDecorator($column, $this->dataset, 'project.php?operation=view&pk0=%project_id%' , '');
            $grid->AddPrintColumn($column);
            
            //
            // View column for task_name field
            //
            $column = new TextViewColumn('task_name', 'Task Name', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for notes field
            //
            $column = new TextViewColumn('notes', 'Notes', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for hrs field
            //
            $column = new TextViewColumn('hrs', 'Allocated Hours', $this->dataset);
            $column->SetOrderable(true);
            $column = new NumberFormatValueViewColumnDecorator($column, 2, ',', '.');
            $grid->AddPrintColumn($column);
            
            //
            // View column for username field
            //
            $column = new TextViewColumn('assigned_to_username', 'Assigned To', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for date_start field
            //
            $column = new DateTimeViewColumn('date_start', 'Date Start', $this->dataset);
            $column->SetDateTimeFormat('Y-m-d');
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for date_end field
            //
            $column = new DateTimeViewColumn('date_end', 'Date End', $this->dataset);
            $column->SetDateTimeFormat('Y-m-d');
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
        }
    
        protected function AddExportColumns(Grid $grid)
        {
            //
            // View column for project_name field
            //
            $column = new TextViewColumn('project_id_project_name', 'Project', $this->dataset);
            $column->SetOrderable(true);
            $column = new ExtendedHyperLinkColumnDecorator($column, $this->dataset, 'project.php?operation=view&pk0=%project_id%' , '');
            $grid->AddExportColumn($column);
            
            //
            // View column for task_name field
            //
            $column = new TextViewColumn('task_name', 'Task Name', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for notes field
            //
            $column = new TextViewColumn('notes', 'Notes', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for hrs field
            //
            $column = new TextViewColumn('hrs', 'Allocated Hours', $this->dataset);
            $column->SetOrderable(true);
            $column = new NumberFormatValueViewColumnDecorator($column, 2, ',', '.');
            $grid->AddExportColumn($column);
            
            //
            // View column for username field
            //
            $column = new TextViewColumn('assigned_to_username', 'Assigned To', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for date_start field
            //
            $column = new DateTimeViewColumn('date_start', 'Date Start', $this->dataset);
            $column->SetDateTimeFormat('Y-m-d');
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for date_end field
            //
            $column = new DateTimeViewColumn('date_end', 'Date End', $this->dataset);
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
    
        function CreateMasterDetailRecordGridFortimesheetDetailEdit0taskGrid()
        {
            $result = new Grid($this, $this->dataset, 'MasterDetailRecordGridFortimesheetDetailEdit0task');
            $result->SetAllowDeleteSelected(false);
            $result->SetShowFilterBuilder(false);
            $result->SetAdvancedSearchAvailable(false);
            $result->SetFilterRowAvailable(false);
            $result->SetShowUpdateLink(false);
            $result->SetEnabledInlineEditing(false);
            $result->SetShowKeyColumnsImagesInHeader(false);
            $result->SetName('master_grid');
            //
            // View column for project_name field
            //
            $column = new TextViewColumn('project_id_project_name', 'Project', $this->dataset);
            $column->SetOrderable(true);
            $column = new ExtendedHyperLinkColumnDecorator($column, $this->dataset, 'project.php?operation=view&pk0=%project_id%' , '');
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $result->AddViewColumn($column);
            
            //
            // View column for Name field
            //
            $column = new TextViewColumn('task_name_Name', 'Name', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('taskGrid_Name_handler_list');
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $result->AddViewColumn($column);
            
            //
            // View column for notes field
            //
            $column = new TextViewColumn('notes', 'Notes', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('taskGrid_notes_handler_list');
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $result->AddViewColumn($column);
            
            //
            // View column for hrs field
            //
            $column = new TextViewColumn('hrs', 'Allocated Hours', $this->dataset);
            $column->SetOrderable(true);
            $column = new NumberFormatValueViewColumnDecorator($column, 2, ',', '.');
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $result->AddViewColumn($column);
            
            //
            // View column for username field
            //
            $column = new TextViewColumn('assigned_to_username', 'Assigned To', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $result->AddViewColumn($column);
            
            //
            // View column for date_start field
            //
            $column = new DateTimeViewColumn('date_start', 'Date Start', $this->dataset);
            $column->SetDateTimeFormat('Y-m-d');
            $column->SetOrderable(true);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $result->AddViewColumn($column);
            
            //
            // View column for date_end field
            //
            $column = new DateTimeViewColumn('date_end', 'Date End', $this->dataset);
            $column->SetDateTimeFormat('Y-m-d');
            $column->SetOrderable(true);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $result->AddViewColumn($column);
            
            //
            // View column for project_name field
            //
            $column = new TextViewColumn('project_id_project_name', 'Project', $this->dataset);
            $column->SetOrderable(true);
            $column = new ExtendedHyperLinkColumnDecorator($column, $this->dataset, 'project.php?operation=view&pk0=%project_id%' , '');
            $result->AddPrintColumn($column);
            
            //
            // View column for task_name field
            //
            $column = new TextViewColumn('task_name', 'Task Name', $this->dataset);
            $column->SetOrderable(true);
            $result->AddPrintColumn($column);
            
            //
            // View column for notes field
            //
            $column = new TextViewColumn('notes', 'Notes', $this->dataset);
            $column->SetOrderable(true);
            $result->AddPrintColumn($column);
            
            //
            // View column for hrs field
            //
            $column = new TextViewColumn('hrs', 'Allocated Hours', $this->dataset);
            $column->SetOrderable(true);
            $column = new NumberFormatValueViewColumnDecorator($column, 2, ',', '.');
            $result->AddPrintColumn($column);
            
            //
            // View column for username field
            //
            $column = new TextViewColumn('assigned_to_username', 'Assigned To', $this->dataset);
            $column->SetOrderable(true);
            $result->AddPrintColumn($column);
            
            //
            // View column for date_start field
            //
            $column = new DateTimeViewColumn('date_start', 'Date Start', $this->dataset);
            $column->SetDateTimeFormat('Y-m-d');
            $column->SetOrderable(true);
            $result->AddPrintColumn($column);
            
            //
            // View column for date_end field
            //
            $column = new DateTimeViewColumn('date_end', 'Date End', $this->dataset);
            $column->SetDateTimeFormat('Y-m-d');
            $column->SetOrderable(true);
            $result->AddPrintColumn($column);
            
            return $result;
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
        function taskGrid_OnCustomRenderTotal($totalValue, $aggregate, $columnName, &$customText, &$handled)
        {
            if ($columnName == 'hrs')
            
            {
            
                $customText = '<strong>Total: ' . $totalValue . '</strong>';
            
                $handled = true;   
            
            }
        }
        function taskGrid_BeforeUpdateRecord($page, &$rowData, &$cancel, &$message, $tableName)
        {
            if (isProjectApproved($page->GetConnection(), $rowData['project_id'])) {
              $cancel = true;
              $message = 'You cannot change a task that belongs to an approved project'; }
            
            else
            $rowData['staff_id'] = $rowData['assigned_to'];
        }
        function taskGrid_BeforeDeleteRecord($page, &$rowData, &$cancel, &$message, $tableName)
        {
            if (isProjectApproved($page->GetConnection(), $rowData['project_id'])) {
              $cancel = true;
              $message = 'You cannot delete a task from an approved project'; }
        }
        function taskGrid_BeforeInsertRecord($page, &$rowData, &$cancel, &$message, $tableName)
        {
            if (isProjectApproved($page->GetConnection(), $rowData['project_id'])) {
              $cancel = true;
              $message = 'You cannot add a task to an approved project.'; }
            
            else
            $rowData['staff_id'] = $rowData['assigned_to'];
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
        
        public function GetModalGridDeleteHandler() { return 'task_modal_delete'; }
        protected function GetEnableModalGridDelete() { return true; }
    
        protected function CreateGrid()
        {
            $result = new Grid($this, $this->dataset, 'taskGrid');
            if ($this->GetSecurityInfo()->HasDeleteGrant())
               $result->SetAllowDeleteSelected(true);
            else
               $result->SetAllowDeleteSelected(false);   
            
            ApplyCommonPageSettings($this, $result);
            
            $result->SetUseImagesForActions(true);
            $result->SetUseFixedHeader(false);
            $result->SetShowLineNumbers(false);
            
            $result->SetHighlightRowAtHover(false);
            $result->SetWidth('');
            $result->OnCustomRenderTotal->AddListener('taskGrid' . '_' . 'OnCustomRenderTotal', $this);
            $result->BeforeUpdateRecord->AddListener('taskGrid' . '_' . 'BeforeUpdateRecord', $this);
            $result->BeforeDeleteRecord->AddListener('taskGrid' . '_' . 'BeforeDeleteRecord', $this);
            $result->BeforeInsertRecord->AddListener('taskGrid' . '_' . 'BeforeInsertRecord', $this);
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
            $pageView = new timesheetDetailView0taskPage($this, 'Timesheet', 'Timesheet', array('task_id'), GetCurrentUserGrantForDataSource('task.timesheet'), 'UTF-8', 20, 'timesheetDetailEdit0task_handler');
            
            $pageView->SetRecordPermission(GetCurrentUserRecordPermissionsForDataSource('task.timesheet'));
            $handler = new PageHTTPHandler('timesheetDetailView0task_handler', $pageView);
            GetApplication()->RegisterHTTPHandler($handler);
            $pageEdit = new timesheetDetailEdit0taskPage($this, array('task_id'), array('task_id'), $this->GetForeingKeyFields(), $this->CreateMasterDetailRecordGridFortimesheetDetailEdit0taskGrid(), $this->dataset, GetCurrentUserGrantForDataSource('task.timesheet'), 'UTF-8');
            
            $pageEdit->SetRecordPermission(GetCurrentUserRecordPermissionsForDataSource('task.timesheet'));
            $pageEdit->SetShortCaption('Timesheet');
            $pageEdit->SetHeader(GetPagesHeader());
            $pageEdit->SetFooter(GetPagesFooter());
            $pageEdit->SetCaption('Timesheet');
            $pageEdit->SetHttpHandlerName('timesheetDetailEdit0task_handler');
            $handler = new PageHTTPHandler('timesheetDetailEdit0task_handler', $pageEdit);
            GetApplication()->RegisterHTTPHandler($handler);
            //
            // View column for Name field
            //
            $column = new TextViewColumn('task_name_Name', 'Name', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'taskGrid_Name_handler_list', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            //
            // View column for notes field
            //
            $column = new TextViewColumn('notes', 'Notes', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'taskGrid_notes_handler_list', $column);
            GetApplication()->RegisterHTTPHandler($handler);//
            // View column for Name field
            //
            $column = new TextViewColumn('task_name_Name', 'Name', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'taskGrid_Name_handler_view', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            //
            // View column for notes field
            //
            $column = new TextViewColumn('notes', 'Notes', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'taskGrid_notes_handler_view', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            $lookupDataset = new TableDataset(
                new MyConnectionFactory(),
                GetConnectionOptions(),
                '`task_names`');
            $field = new IntegerField('id', null, null, true);
            $field->SetIsNotNull(true);
            $lookupDataset->AddField($field, true);
            $field = new StringField('Name');
            $lookupDataset->AddField($field, false);
            $lookupDataset->SetOrderBy('Name', GetOrderTypeAsSQL(otAscending));
            $lookupDataset->AddCustomCondition(EnvVariablesUtils::EvaluateVariableTemplate($this->GetColumnVariableContainer(), ''));
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'edit_task_name_Name_search', 'Name', 'Name', null);
            GetApplication()->RegisterHTTPHandler($handler);
            $lookupDataset = new TableDataset(
                new MyConnectionFactory(),
                GetConnectionOptions(),
                '`task_names`');
            $field = new IntegerField('id', null, null, true);
            $field->SetIsNotNull(true);
            $lookupDataset->AddField($field, true);
            $field = new StringField('Name');
            $lookupDataset->AddField($field, false);
            $lookupDataset->SetOrderBy('Name', GetOrderTypeAsSQL(otAscending));
            $lookupDataset->AddCustomCondition(EnvVariablesUtils::EvaluateVariableTemplate($this->GetColumnVariableContainer(), ''));
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'insert_task_name_Name_search', 'Name', 'Name', null);
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
        $Page = new taskPage("task.php", "task", GetCurrentUserGrantForDataSource("task"), 'UTF-8');
        $Page->SetShortCaption('Tasks - Time Tracking');
        $Page->SetHeader(GetPagesHeader());
        $Page->SetFooter(GetPagesFooter());
        $Page->SetCaption('Tasks - Time Tracking');
        $Page->SetRecordPermission(GetCurrentUserRecordPermissionsForDataSource("task"));
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
	
