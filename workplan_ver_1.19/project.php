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
    
    
    
    class timesheetDetailView0taskDetailView0projectPage extends DetailPage
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
            $column->SetFullTextWindowHandlerName('timesheetDetailViewGrid0taskDetailView0project_name_handler_list');
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
            $column->SetFullTextWindowHandlerName('timesheetDetailViewGrid0taskDetailView0project_notes_handler_list');
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
        
        function GetCustomClientScript()
        {
            return ;
        }
        
        function GetOnPageLoadedClientScript()
        {
            return ;
        }
        public function timesheetDetailViewGrid0taskDetailView0project_OnCustomDrawRow($rowData, &$rowCellStyles, &$rowStyles)
        {
        $rowStyles = 'background-color: #F3E2A9';
        }
        function timesheetDetailViewGrid0taskDetailView0project_OnCustomRenderTotal($totalValue, $aggregate, $columnName, &$customText, &$handled)
        {
            if ($columnName == 'hours')
            
            {
            
                $customText = '<strong>Total: ' . $totalValue . '</strong>';
            
                $handled = true;   
            
            }
        }
        function timesheetDetailViewGrid0taskDetailView0project_BeforeInsertRecord($page, &$rowData, &$cancel, &$message, $tableName)
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
            $result = new Grid($this, $this->dataset, 'timesheetDetailViewGrid0taskDetailView0project');
            $result->SetAllowDeleteSelected(false);
            $result->SetUseFixedHeader(false);
            $result->SetShowLineNumbers(false);
            
            $result->SetHighlightRowAtHover(false);
            $result->SetWidth('');
            $result->OnCustomDrawCell->AddListener('timesheetDetailViewGrid0taskDetailView0project' . '_OnCustomDrawRow', $this);
            $result->OnCustomRenderTotal->AddListener('timesheetDetailViewGrid0taskDetailView0project' . '_' . 'OnCustomRenderTotal', $this);
            $result->BeforeInsertRecord->AddListener('timesheetDetailViewGrid0taskDetailView0project' . '_' . 'BeforeInsertRecord', $this);
            $this->AddFieldColumns($result);
            //
            // View column for name field
            //
            $column = new TextViewColumn('name', 'Name', $this->dataset);
            $column->SetOrderable(false);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'timesheetDetailViewGrid0taskDetailView0project_name_handler_list', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            //
            // View column for notes field
            //
            $column = new TextViewColumn('notes', 'Notes', $this->dataset);
            $column->SetOrderable(false);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'timesheetDetailViewGrid0taskDetailView0project_notes_handler_list', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            return $result;
        }
    }
    
    
    
    // OnBeforePageExecute event handler
    
    
    
    class timesheetDetailEdit0taskDetailView0projectPage extends DetailPageEdit
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
            $grid->SearchControl = new SimpleSearch('timesheetDetailEdit0taskDetailView0projectssearch', $this->dataset,
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
            $this->AdvancedSearchControl = new AdvancedSearchControl('timesheetDetailEdit0taskDetailView0projectasearch', $this->dataset, $this->GetLocalizerCaptions(), $this->GetColumnVariableContainer(), $this->CreateLinkBuilder());
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
            $column->SetFullTextWindowHandlerName('timesheetDetailEditGrid0taskDetailView0project_name_handler_list');
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
            $column->SetFullTextWindowHandlerName('timesheetDetailEditGrid0taskDetailView0project_notes_handler_list');
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
            $column->SetFullTextWindowHandlerName('timesheetDetailEditGrid0taskDetailView0project_name_handler_view');
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
            $column->SetFullTextWindowHandlerName('timesheetDetailEditGrid0taskDetailView0project_notes_handler_view');
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
            $editColumn->SetReadOnly(true);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
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
            $editColumn->setEnabled(false);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for hours field
            //
            $editor = new SpinEdit('hours_edit');
            $editor->SetUseConstraints(true);
            $editor->SetMaxValue(12);
            $editor->SetMinValue(0);
            $editor->SetStep(1);
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
            $editColumn->SetReadOnly(true);
            $editColumn->SetInsertDefaultValue($this->RenderText('%CURRENT_USER_NAME%'));
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
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
            $editColumn->setEnabled(false);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for hours field
            //
            $editor = new SpinEdit('hours_edit');
            $editor->SetUseConstraints(true);
            $editor->SetMaxValue(12);
            $editor->SetMinValue(0);
            $editor->SetStep(1);
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
    
        protected function ApplyCommonColumnEditProperties(CustomEditColumn $column)
        {
            $column->SetDisplaySetToNullCheckBox(false);
            $column->SetDisplaySetToDefaultCheckBox(false);
        	$column->SetVariableContainer($this->GetColumnVariableContainer());
        }
    
        function GetCustomClientScript()
        {
            return ;
        }
        
        function GetOnPageLoadedClientScript()
        {
            return ;
        }
        public function timesheetDetailEditGrid0taskDetailView0project_OnCustomDrawRow($rowData, &$rowCellStyles, &$rowStyles)
        {
        $rowStyles = 'background-color: #F3E2A9';
        }
        function timesheetDetailEditGrid0taskDetailView0project_OnCustomRenderTotal($totalValue, $aggregate, $columnName, &$customText, &$handled)
        {
            if ($columnName == 'hours')
            
            {
            
                $customText = '<strong>Total: ' . $totalValue . '</strong>';
            
                $handled = true;   
            
            }
        }
        function timesheetDetailEditGrid0taskDetailView0project_BeforeInsertRecord($page, &$rowData, &$cancel, &$message, $tableName)
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
        
        public function GetModalGridDeleteHandler() { return 'timesheetDetailEdit0taskDetailView0project_modal_delete'; }
        protected function GetEnableModalGridDelete() { return true; }
    
        protected function CreateGrid()
        {
            $result = new Grid($this, $this->dataset, 'timesheetDetailEditGrid0taskDetailView0project');
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
            $result->OnCustomDrawCell->AddListener('timesheetDetailEditGrid0taskDetailView0project' . '_OnCustomDrawRow', $this);
            $result->OnCustomRenderTotal->AddListener('timesheetDetailEditGrid0taskDetailView0project' . '_' . 'OnCustomRenderTotal', $this);
            $result->BeforeInsertRecord->AddListener('timesheetDetailEditGrid0taskDetailView0project' . '_' . 'BeforeInsertRecord', $this);
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
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'timesheetDetailEditGrid0taskDetailView0project_name_handler_list', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            //
            // View column for notes field
            //
            $column = new TextViewColumn('notes', 'Notes', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'timesheetDetailEditGrid0taskDetailView0project_notes_handler_list', $column);
            GetApplication()->RegisterHTTPHandler($handler);//
            // View column for name field
            //
            $column = new TextViewColumn('name', 'Name', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'timesheetDetailEditGrid0taskDetailView0project_name_handler_view', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            //
            // View column for notes field
            //
            $column = new TextViewColumn('notes', 'Notes', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'timesheetDetailEditGrid0taskDetailView0project_notes_handler_view', $column);
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
    
    // OnBeforePageExecute event handler
    
    
    
    class taskDetailView0projectPage extends DetailPage
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
            $this->dataset->AddField($field, false);
            $this->dataset->AddLookupField('project_id', 'project', new IntegerField('project_id', null, null, true), new StringField('project_name', 'project_id_project_name', 'project_id_project_name_project'), 'project_id_project_name_project');
            $this->dataset->AddLookupField('task_name', 'task_names', new StringField('Name'), new StringField('Name', 'task_name_Name', 'task_name_Name_task_names'), 'task_name_Name_task_names');
            $this->dataset->AddLookupField('assigned_to', 'staff', new IntegerField('staff_id', null, null, true), new StringField('username', 'assigned_to_username', 'assigned_to_username_staff'), 'assigned_to_username_staff');
        }
    
        protected function AddFieldColumns(Grid $grid)
        {
            if (GetCurrentUserGrantForDataSource('task.timesheet')->HasViewGrant())
            {
              //
            // View column for timesheetDetailView0taskDetailView0project detail
            //
            $column = new DetailColumn(array('task_id'), 'detail0taskDetailView0project', 'timesheetDetailEdit0taskDetailView0project_handler', 'timesheetDetailView0taskDetailView0project_handler', $this->dataset, 'Time Tracking for this Task', $this->RenderText('TimeTracking'));
              $grid->AddViewColumn($column);
            }
            
            //
            // View column for project_name field
            //
            $column = new TextViewColumn('project_id_project_name', 'Parent Project', $this->dataset);
            $column->SetOrderable(false);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for date_start field
            //
            $column = new DateTimeViewColumn('date_start', 'Date Start', $this->dataset);
            $column->SetDateTimeFormat('Y-m-d');
            $column->SetOrderable(false);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for date_end field
            //
            $column = new DateTimeViewColumn('date_end', 'Date End', $this->dataset);
            $column->SetDateTimeFormat('Y-m-d');
            $column->SetOrderable(false);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for Name field
            //
            $column = new TextViewColumn('task_name_Name', 'Task Name', $this->dataset);
            $column->SetOrderable(false);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('taskDetailViewGrid0project_Name_handler_list');
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for notes field
            //
            $column = new TextViewColumn('notes', 'Notes', $this->dataset);
            $column->SetOrderable(false);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('taskDetailViewGrid0project_notes_handler_list');
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for hrs field
            //
            $column = new TextViewColumn('hrs', 'Hrs', $this->dataset);
            $grid->SetTotal($column, PredefinedAggregate::$Sum);
            $column->SetOrderable(false);
            $column = new NumberFormatValueViewColumnDecorator($column, 2, ',', '.');
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for username field
            //
            $column = new TextViewColumn('assigned_to_username', 'Assigned To', $this->dataset);
            $column->SetOrderable(false);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
        }
        
        function CreateMasterDetailRecordGridFortimesheetDetailEdit0taskDetailView0projectGrid()
        {
            $result = new Grid($this, $this->dataset, 'MasterDetailRecordGridFortimesheetDetailEdit0taskDetailView0project');
            $result->SetAllowDeleteSelected(false);
            $result->OnCustomDrawCell->AddListener('MasterDetailRecordGridFortimesheetDetailEdit0taskDetailView0project' . '_OnCustomDrawRow', $this);
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
            $column = new TextViewColumn('project_id_project_name', 'Parent Project', $this->dataset);
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
            // View column for Name field
            //
            $column = new TextViewColumn('task_name_Name', 'Task Name', $this->dataset);
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
            $column = new TextViewColumn('hrs', 'Hrs', $this->dataset);
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
            // View column for project_name field
            //
            $column = new TextViewColumn('project_id_project_name', 'Parent Project', $this->dataset);
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
            $column = new TextViewColumn('hrs', 'Hrs', $this->dataset);
            $column->SetOrderable(true);
            $column = new NumberFormatValueViewColumnDecorator($column, 2, ',', '.');
            $result->AddPrintColumn($column);
            
            //
            // View column for username field
            //
            $column = new TextViewColumn('assigned_to_username', 'Assigned To', $this->dataset);
            $column->SetOrderable(true);
            $result->AddPrintColumn($column);
            
            return $result;
        }
        
        public function MasterDetailRecordGridFortimesheetDetailEdit0taskDetailView0project_OnCustomDrawRow($rowData, &$rowCellStyles, &$rowStyles)
        {
        $rowStyles = 'background-color: #F6D8CE';
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
        public function taskDetailViewGrid0project_OnCustomDrawRow($rowData, &$rowCellStyles, &$rowStyles)
        {
        $rowStyles = 'background-color: #F6D8CE';
        }
        function taskDetailViewGrid0project_BeforeUpdateRecord($page, &$rowData, &$cancel, &$message, $tableName)
        {
            if (isProjectApproved($page->GetConnection())) {
              $cancel = true;
              $message = 'You cannot change a task that belongs to an approved project'; }
            
            else
            $rowData['staff_id'] = $rowData['assigned_to'];
        }
        function taskDetailViewGrid0project_BeforeDeleteRecord($page, &$rowData, &$cancel, &$message, $tableName)
        {
            if (isProjectApproved($page->GetConnection())) {
              $cancel = true;
              $message = 'You cannot delete a task from an approved project'; }
        }
        function taskDetailViewGrid0project_BeforeInsertRecord($page, &$rowData, &$cancel, &$message, $tableName)
        {
            if (isProjectApproved($page->GetConnection())) {
              $cancel = true;
              $message = 'You cannot add a task to an approved project.'; }
            else
            $rowData['staff_id'] = $rowData['assigned_to'];
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
            $result = new Grid($this, $this->dataset, 'taskDetailViewGrid0project');
            $result->SetAllowDeleteSelected(false);
            $result->SetInsertClientValidationScript($this->RenderText('if (fieldValues[\'project_id\'] ==\'\')
            
            {
            
                errorInfo.SetMessage(\'Only project lead may add tasks to this project.\'); 
            
                return false;
            
            }'));
            
            $result->SetInsertClientEditorValueChangedScript($this->RenderText('if (fieldValues[\'project_id\'] ==\'\')
            
            {
            
                errorInfo.SetMessage(\'Only project lead may add tasks to this project.\'); 
            
                return false;
            
            }'));
            $result->SetUseFixedHeader(false);
            $result->SetShowLineNumbers(false);
            
            $result->SetHighlightRowAtHover(true);
            $result->SetWidth('');
            $result->OnCustomDrawCell->AddListener('taskDetailViewGrid0project' . '_OnCustomDrawRow', $this);
            $result->BeforeUpdateRecord->AddListener('taskDetailViewGrid0project' . '_' . 'BeforeUpdateRecord', $this);
            $result->BeforeDeleteRecord->AddListener('taskDetailViewGrid0project' . '_' . 'BeforeDeleteRecord', $this);
            $result->BeforeInsertRecord->AddListener('taskDetailViewGrid0project' . '_' . 'BeforeInsertRecord', $this);
            $this->AddFieldColumns($result);
            $pageView = new timesheetDetailView0taskDetailView0projectPage($this, 'TimeTracking', 'TimeTracking', array('task_id'), GetCurrentUserGrantForDataSource('task.timesheet'), 'UTF-8', 20, 'timesheetDetailEdit0taskDetailView0project_handler');
            
            $pageView->SetRecordPermission(GetCurrentUserRecordPermissionsForDataSource('task.timesheet'));
            $handler = new PageHTTPHandler('timesheetDetailView0taskDetailView0project_handler', $pageView);
            GetApplication()->RegisterHTTPHandler($handler);
            $pageEdit = new timesheetDetailEdit0taskDetailView0projectPage($this, array('task_id'), array('task_id'), $this->GetForeingKeyFields(), $this->CreateMasterDetailRecordGridFortimesheetDetailEdit0taskDetailView0projectGrid(), $this->dataset, GetCurrentUserGrantForDataSource('task.timesheet'), 'UTF-8');
            
            $pageEdit->SetRecordPermission(GetCurrentUserRecordPermissionsForDataSource('task.timesheet'));
            $pageEdit->SetShortCaption('Time Tracking for this Task');
            $pageEdit->SetHeader(GetPagesHeader());
            $pageEdit->SetFooter(GetPagesFooter());
            $pageEdit->SetCaption('TimeTracking');
            $pageEdit->SetHttpHandlerName('timesheetDetailEdit0taskDetailView0project_handler');
            $handler = new PageHTTPHandler('timesheetDetailEdit0taskDetailView0project_handler', $pageEdit);
            GetApplication()->RegisterHTTPHandler($handler);
            //
            // View column for Name field
            //
            $column = new TextViewColumn('task_name_Name', 'Task Name', $this->dataset);
            $column->SetOrderable(false);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'taskDetailViewGrid0project_Name_handler_list', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            //
            // View column for notes field
            //
            $column = new TextViewColumn('notes', 'Notes', $this->dataset);
            $column->SetOrderable(false);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'taskDetailViewGrid0project_notes_handler_list', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            return $result;
        }
    }
    
    
    
    // OnBeforePageExecute event handler
    
    
    
    class timesheetDetailView0taskDetailEdit0projectPage extends DetailPage
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
            $column->SetFullTextWindowHandlerName('timesheetDetailViewGrid0taskDetailEdit0project_name_handler_list');
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
            $column->SetFullTextWindowHandlerName('timesheetDetailViewGrid0taskDetailEdit0project_notes_handler_list');
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
        
        function GetCustomClientScript()
        {
            return ;
        }
        
        function GetOnPageLoadedClientScript()
        {
            return ;
        }
        public function timesheetDetailViewGrid0taskDetailEdit0project_OnCustomDrawRow($rowData, &$rowCellStyles, &$rowStyles)
        {
        $rowStyles = 'background-color: #F3E2A9';
        }
        function timesheetDetailViewGrid0taskDetailEdit0project_OnCustomRenderTotal($totalValue, $aggregate, $columnName, &$customText, &$handled)
        {
            if ($columnName == 'hours')
            
            {
            
                $customText = '<strong>Total: ' . $totalValue . '</strong>';
            
                $handled = true;   
            
            }
        }
        function timesheetDetailViewGrid0taskDetailEdit0project_BeforeInsertRecord($page, &$rowData, &$cancel, &$message, $tableName)
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
            $result = new Grid($this, $this->dataset, 'timesheetDetailViewGrid0taskDetailEdit0project');
            $result->SetAllowDeleteSelected(false);
            $result->SetUseFixedHeader(false);
            $result->SetShowLineNumbers(false);
            
            $result->SetHighlightRowAtHover(false);
            $result->SetWidth('');
            $result->OnCustomDrawCell->AddListener('timesheetDetailViewGrid0taskDetailEdit0project' . '_OnCustomDrawRow', $this);
            $result->OnCustomRenderTotal->AddListener('timesheetDetailViewGrid0taskDetailEdit0project' . '_' . 'OnCustomRenderTotal', $this);
            $result->BeforeInsertRecord->AddListener('timesheetDetailViewGrid0taskDetailEdit0project' . '_' . 'BeforeInsertRecord', $this);
            $this->AddFieldColumns($result);
            //
            // View column for name field
            //
            $column = new TextViewColumn('name', 'Name', $this->dataset);
            $column->SetOrderable(false);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'timesheetDetailViewGrid0taskDetailEdit0project_name_handler_list', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            //
            // View column for notes field
            //
            $column = new TextViewColumn('notes', 'Notes', $this->dataset);
            $column->SetOrderable(false);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'timesheetDetailViewGrid0taskDetailEdit0project_notes_handler_list', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            return $result;
        }
    }
    
    
    
    // OnBeforePageExecute event handler
    
    
    
    class timesheetDetailEdit0taskDetailEdit0projectPage extends DetailPageEdit
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
            $grid->SearchControl = new SimpleSearch('timesheetDetailEdit0taskDetailEdit0projectssearch', $this->dataset,
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
            $this->AdvancedSearchControl = new AdvancedSearchControl('timesheetDetailEdit0taskDetailEdit0projectasearch', $this->dataset, $this->GetLocalizerCaptions(), $this->GetColumnVariableContainer(), $this->CreateLinkBuilder());
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
            $column->SetFullTextWindowHandlerName('timesheetDetailEditGrid0taskDetailEdit0project_name_handler_list');
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
            $column->SetFullTextWindowHandlerName('timesheetDetailEditGrid0taskDetailEdit0project_notes_handler_list');
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
            $column->SetFullTextWindowHandlerName('timesheetDetailEditGrid0taskDetailEdit0project_name_handler_view');
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
            $column->SetFullTextWindowHandlerName('timesheetDetailEditGrid0taskDetailEdit0project_notes_handler_view');
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
            $editColumn->SetReadOnly(true);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
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
            $editColumn->setEnabled(false);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for hours field
            //
            $editor = new SpinEdit('hours_edit');
            $editor->SetUseConstraints(true);
            $editor->SetMaxValue(12);
            $editor->SetMinValue(0);
            $editor->SetStep(1);
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
            $editColumn->SetReadOnly(true);
            $editColumn->SetInsertDefaultValue($this->RenderText('%CURRENT_USER_NAME%'));
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
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
            $editColumn->setEnabled(false);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for hours field
            //
            $editor = new SpinEdit('hours_edit');
            $editor->SetUseConstraints(true);
            $editor->SetMaxValue(12);
            $editor->SetMinValue(0);
            $editor->SetStep(1);
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
    
        protected function ApplyCommonColumnEditProperties(CustomEditColumn $column)
        {
            $column->SetDisplaySetToNullCheckBox(false);
            $column->SetDisplaySetToDefaultCheckBox(false);
        	$column->SetVariableContainer($this->GetColumnVariableContainer());
        }
    
        function GetCustomClientScript()
        {
            return ;
        }
        
        function GetOnPageLoadedClientScript()
        {
            return ;
        }
        public function timesheetDetailEditGrid0taskDetailEdit0project_OnCustomDrawRow($rowData, &$rowCellStyles, &$rowStyles)
        {
        $rowStyles = 'background-color: #F3E2A9';
        }
        function timesheetDetailEditGrid0taskDetailEdit0project_OnCustomRenderTotal($totalValue, $aggregate, $columnName, &$customText, &$handled)
        {
            if ($columnName == 'hours')
            
            {
            
                $customText = '<strong>Total: ' . $totalValue . '</strong>';
            
                $handled = true;   
            
            }
        }
        function timesheetDetailEditGrid0taskDetailEdit0project_BeforeInsertRecord($page, &$rowData, &$cancel, &$message, $tableName)
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
        
        public function GetModalGridDeleteHandler() { return 'timesheetDetailEdit0taskDetailEdit0project_modal_delete'; }
        protected function GetEnableModalGridDelete() { return true; }
    
        protected function CreateGrid()
        {
            $result = new Grid($this, $this->dataset, 'timesheetDetailEditGrid0taskDetailEdit0project');
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
            $result->OnCustomDrawCell->AddListener('timesheetDetailEditGrid0taskDetailEdit0project' . '_OnCustomDrawRow', $this);
            $result->OnCustomRenderTotal->AddListener('timesheetDetailEditGrid0taskDetailEdit0project' . '_' . 'OnCustomRenderTotal', $this);
            $result->BeforeInsertRecord->AddListener('timesheetDetailEditGrid0taskDetailEdit0project' . '_' . 'BeforeInsertRecord', $this);
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
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'timesheetDetailEditGrid0taskDetailEdit0project_name_handler_list', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            //
            // View column for notes field
            //
            $column = new TextViewColumn('notes', 'Notes', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'timesheetDetailEditGrid0taskDetailEdit0project_notes_handler_list', $column);
            GetApplication()->RegisterHTTPHandler($handler);//
            // View column for name field
            //
            $column = new TextViewColumn('name', 'Name', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'timesheetDetailEditGrid0taskDetailEdit0project_name_handler_view', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            //
            // View column for notes field
            //
            $column = new TextViewColumn('notes', 'Notes', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'timesheetDetailEditGrid0taskDetailEdit0project_notes_handler_view', $column);
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
    
    // OnBeforePageExecute event handler
    function isProjectApproved($connection) {
      $approved = 0;
      if (GetApplication()->IsGETValueSet('fk0')) {
        $sqlText = 'SELECT approved FROM project WHERE project_id = '. 
    GetApplication()->GetGETValue('fk0');
        $approved = $connection->ExecScalarSQL($sqlText);
      }
      return ($approved == 1);
    }
    
    
    class taskDetailEdit0projectPage extends DetailPageEdit
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
            $grid->SearchControl = new SimpleSearch('taskDetailEdit0projectssearch', $this->dataset,
                array('project_id_project_name', 'date_start', 'date_end', 'task_name_Name', 'notes', 'hrs', 'assigned_to_username'),
                array($this->RenderText('Parent Project'), $this->RenderText('Date Start'), $this->RenderText('Date End'), $this->RenderText('Task Name'), $this->RenderText('Notes'), $this->RenderText('Hrs'), $this->RenderText('Assigned To')),
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
            $this->AdvancedSearchControl = new AdvancedSearchControl('taskDetailEdit0projectasearch', $this->dataset, $this->GetLocalizerCaptions(), $this->GetColumnVariableContainer(), $this->CreateLinkBuilder());
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
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateLookupSearchInput('project_id', $this->RenderText('Parent Project'), $lookupDataset, 'project_id', 'project_name', false, 8));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateDateTimeSearchInput('date_start', $this->RenderText('Date Start'), 'Y-m-d'));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateDateTimeSearchInput('date_end', $this->RenderText('Date End'), 'Y-m-d'));
            
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
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateLookupSearchInput('task_name', $this->RenderText('Task Name'), $lookupDataset, 'Name', 'Name', false, 8));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('notes', $this->RenderText('Notes')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('hrs', $this->RenderText('Hrs')));
            
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
        }
    
        protected function AddFieldColumns(Grid $grid)
        {
            if (GetCurrentUserGrantForDataSource('task.timesheet')->HasViewGrant())
            {
              //
            // View column for timesheetDetailView0taskDetailEdit0project detail
            //
            $column = new DetailColumn(array('task_id'), 'detail0taskDetailEdit0project', 'timesheetDetailEdit0taskDetailEdit0project_handler', 'timesheetDetailView0taskDetailEdit0project_handler', $this->dataset, 'Time Tracking for this Task', $this->RenderText('TimeTracking'));
              $grid->AddViewColumn($column);
            }
            
            //
            // View column for project_name field
            //
            $column = new TextViewColumn('project_id_project_name', 'Parent Project', $this->dataset);
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
            
            //
            // View column for Name field
            //
            $column = new TextViewColumn('task_name_Name', 'Task Name', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('taskDetailEditGrid0project_Name_handler_list');
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for notes field
            //
            $column = new TextViewColumn('notes', 'Notes', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('taskDetailEditGrid0project_notes_handler_list');
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for hrs field
            //
            $column = new TextViewColumn('hrs', 'Hrs', $this->dataset);
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
        }
    
        protected function AddSingleRecordViewColumns(Grid $grid)
        {
            //
            // View column for project_name field
            //
            $column = new TextViewColumn('project_id_project_name', 'Parent Project', $this->dataset);
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
            
            //
            // View column for Name field
            //
            $column = new TextViewColumn('task_name_Name', 'Task Name', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('taskDetailEditGrid0project_Name_handler_view');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for notes field
            //
            $column = new TextViewColumn('notes', 'Notes', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('taskDetailEditGrid0project_notes_handler_view');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for hrs field
            //
            $column = new TextViewColumn('hrs', 'Hrs', $this->dataset);
            $column->SetOrderable(true);
            $column = new NumberFormatValueViewColumnDecorator($column, 2, ',', '.');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for username field
            //
            $column = new TextViewColumn('assigned_to_username', 'Assigned To', $this->dataset);
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
                'Parent Project', 
                'project_id', 
                $editor, 
                $this->dataset, 'project_id', 'project_name', $lookupDataset);
            $editColumn->SetReadOnly(true);
            $editColumn->setEnabled(false);
            $editColumn->SetAllowSetToNull(true);
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
            $editor = new DateTimeEdit('date_end_edit', false, 'Y-m-d', GetFirstDayOfWeek());
            $editColumn = new CustomEditColumn('Date End', 'date_end', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for task_name field
            //
            $editor = new ComboBox('task_name_edit', $this->GetLocalizerCaptions()->GetMessageString('PleaseSelect'));
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
            $editColumn = new LookUpEditColumn(
                'Task Name', 
                'task_name', 
                $editor, 
                $this->dataset, 'Name', 'Name', $lookupDataset);
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
            $editColumn = new CustomEditColumn('Hrs', 'hrs', $editor, $this->dataset);
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
                'Parent Project', 
                'project_id', 
                $editor, 
                $this->dataset, 'project_id', 'project_name', $lookupDataset);
            $editColumn->SetReadOnly(true);
            $editColumn->setEnabled(false);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetInsertDefaultValue($this->RenderText('%project_name%'));
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for date_start field
            //
            $editor = new DateTimeEdit('date_start_edit', false, 'Y-m-d', GetFirstDayOfWeek());
            $editColumn = new CustomEditColumn('Date Start', 'date_start', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for date_end field
            //
            $editor = new DateTimeEdit('date_end_edit', false, 'Y-m-d', GetFirstDayOfWeek());
            $editColumn = new CustomEditColumn('Date End', 'date_end', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for task_name field
            //
            $editor = new ComboBox('task_name_edit', $this->GetLocalizerCaptions()->GetMessageString('PleaseSelect'));
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
            $editColumn = new LookUpEditColumn(
                'Task Name', 
                'task_name', 
                $editor, 
                $this->dataset, 'Name', 'Name', $lookupDataset);
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
            $editColumn = new CustomEditColumn('Hrs', 'hrs', $editor, $this->dataset);
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
            $column = new TextViewColumn('project_id_project_name', 'Parent Project', $this->dataset);
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
            $column = new TextViewColumn('hrs', 'Hrs', $this->dataset);
            $column->SetOrderable(true);
            $column = new NumberFormatValueViewColumnDecorator($column, 2, ',', '.');
            $grid->AddPrintColumn($column);
            
            //
            // View column for username field
            //
            $column = new TextViewColumn('assigned_to_username', 'Assigned To', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
        }
    
        protected function AddExportColumns(Grid $grid)
        {
            //
            // View column for project_name field
            //
            $column = new TextViewColumn('project_id_project_name', 'Parent Project', $this->dataset);
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
            $column = new TextViewColumn('hrs', 'Hrs', $this->dataset);
            $column->SetOrderable(true);
            $column = new NumberFormatValueViewColumnDecorator($column, 2, ',', '.');
            $grid->AddExportColumn($column);
            
            //
            // View column for username field
            //
            $column = new TextViewColumn('assigned_to_username', 'Assigned To', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
        }
    
        protected function ApplyCommonColumnEditProperties(CustomEditColumn $column)
        {
            $column->SetDisplaySetToNullCheckBox(false);
            $column->SetDisplaySetToDefaultCheckBox(false);
        	$column->SetVariableContainer($this->GetColumnVariableContainer());
        }
    
        function CreateMasterDetailRecordGridFortimesheetDetailEdit0taskDetailEdit0projectGrid()
        {
            $result = new Grid($this, $this->dataset, 'MasterDetailRecordGridFortimesheetDetailEdit0taskDetailEdit0project');
            $result->SetAllowDeleteSelected(false);
            $result->OnCustomDrawCell->AddListener('MasterDetailRecordGridFortimesheetDetailEdit0taskDetailEdit0project' . '_OnCustomDrawRow', $this);
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
            $column = new TextViewColumn('project_id_project_name', 'Parent Project', $this->dataset);
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
            // View column for Name field
            //
            $column = new TextViewColumn('task_name_Name', 'Task Name', $this->dataset);
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
            $column = new TextViewColumn('hrs', 'Hrs', $this->dataset);
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
            // View column for project_name field
            //
            $column = new TextViewColumn('project_id_project_name', 'Parent Project', $this->dataset);
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
            $column = new TextViewColumn('hrs', 'Hrs', $this->dataset);
            $column->SetOrderable(true);
            $column = new NumberFormatValueViewColumnDecorator($column, 2, ',', '.');
            $result->AddPrintColumn($column);
            
            //
            // View column for username field
            //
            $column = new TextViewColumn('assigned_to_username', 'Assigned To', $this->dataset);
            $column->SetOrderable(true);
            $result->AddPrintColumn($column);
            
            return $result;
        }
        
        public function MasterDetailRecordGridFortimesheetDetailEdit0taskDetailEdit0project_OnCustomDrawRow($rowData, &$rowCellStyles, &$rowStyles)
        {
        $rowStyles = 'background-color: #F6D8CE';
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
        public function taskDetailEditGrid0project_OnCustomDrawRow($rowData, &$rowCellStyles, &$rowStyles)
        {
        $rowStyles = 'background-color: #F6D8CE';
        }
        function taskDetailEditGrid0project_BeforeUpdateRecord($page, &$rowData, &$cancel, &$message, $tableName)
        {
            if (isProjectApproved($page->GetConnection())) {
              $cancel = true;
              $message = 'You cannot change a task that belongs to an approved project'; }
            
            else
            $rowData['staff_id'] = $rowData['assigned_to'];
        }
        function taskDetailEditGrid0project_BeforeDeleteRecord($page, &$rowData, &$cancel, &$message, $tableName)
        {
            if (isProjectApproved($page->GetConnection())) {
              $cancel = true;
              $message = 'You cannot delete a task from an approved project'; }
        }
        function taskDetailEditGrid0project_BeforeInsertRecord($page, &$rowData, &$cancel, &$message, $tableName)
        {
            if (isProjectApproved($page->GetConnection())) {
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
        
        public function GetModalGridDeleteHandler() { return 'taskDetailEdit0project_modal_delete'; }
        protected function GetEnableModalGridDelete() { return true; }
    
        protected function CreateGrid()
        {
            $result = new Grid($this, $this->dataset, 'taskDetailEditGrid0project');
            if ($this->GetSecurityInfo()->HasDeleteGrant())
                $result->SetAllowDeleteSelected(false);
            else
                $result->SetAllowDeleteSelected(false);
            ApplyCommonPageSettings($this, $result);
            $result->SetUseImagesForActions(true);
            $result->SetInsertClientValidationScript($this->RenderText('if (fieldValues[\'project_id\'] ==\'\')
            
            {
            
                errorInfo.SetMessage(\'Only project lead may add tasks to this project.\'); 
            
                return false;
            
            }'));
            
            $result->SetInsertClientEditorValueChangedScript($this->RenderText('if (fieldValues[\'project_id\'] ==\'\')
            
            {
            
                errorInfo.SetMessage(\'Only project lead may add tasks to this project.\'); 
            
                return false;
            
            }'));
            $result->SetUseFixedHeader(false);
            $result->SetShowLineNumbers(false);
            
            $result->SetHighlightRowAtHover(true);
            $result->SetWidth('');
            $result->OnCustomDrawCell->AddListener('taskDetailEditGrid0project' . '_OnCustomDrawRow', $this);
            $result->BeforeUpdateRecord->AddListener('taskDetailEditGrid0project' . '_' . 'BeforeUpdateRecord', $this);
            $result->BeforeDeleteRecord->AddListener('taskDetailEditGrid0project' . '_' . 'BeforeDeleteRecord', $this);
            $result->BeforeInsertRecord->AddListener('taskDetailEditGrid0project' . '_' . 'BeforeInsertRecord', $this);
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
            $this->SetSimpleSearchAvailable(false);
            $this->SetAdvancedSearchAvailable(false);
            $this->SetFilterRowAvailable(true);
            $this->SetVisualEffectsEnabled(true);
            $this->SetShowTopPageNavigator(true);
            $this->SetShowBottomPageNavigator(true);
    
            //
            // Http Handlers
            //
            $pageView = new timesheetDetailView0taskDetailEdit0projectPage($this, 'TimeTracking', 'TimeTracking', array('task_id'), GetCurrentUserGrantForDataSource('task.timesheet'), 'UTF-8', 20, 'timesheetDetailEdit0taskDetailEdit0project_handler');
            
            $pageView->SetRecordPermission(GetCurrentUserRecordPermissionsForDataSource('task.timesheet'));
            $handler = new PageHTTPHandler('timesheetDetailView0taskDetailEdit0project_handler', $pageView);
            GetApplication()->RegisterHTTPHandler($handler);
            $pageEdit = new timesheetDetailEdit0taskDetailEdit0projectPage($this, array('task_id'), array('task_id'), $this->GetForeingKeyFields(), $this->CreateMasterDetailRecordGridFortimesheetDetailEdit0taskDetailEdit0projectGrid(), $this->dataset, GetCurrentUserGrantForDataSource('task.timesheet'), 'UTF-8');
            
            $pageEdit->SetRecordPermission(GetCurrentUserRecordPermissionsForDataSource('task.timesheet'));
            $pageEdit->SetShortCaption('Time Tracking for this Task');
            $pageEdit->SetHeader(GetPagesHeader());
            $pageEdit->SetFooter(GetPagesFooter());
            $pageEdit->SetCaption('TimeTracking');
            $pageEdit->SetHttpHandlerName('timesheetDetailEdit0taskDetailEdit0project_handler');
            $handler = new PageHTTPHandler('timesheetDetailEdit0taskDetailEdit0project_handler', $pageEdit);
            GetApplication()->RegisterHTTPHandler($handler);
            //
            // View column for Name field
            //
            $column = new TextViewColumn('task_name_Name', 'Task Name', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'taskDetailEditGrid0project_Name_handler_list', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            //
            // View column for notes field
            //
            $column = new TextViewColumn('notes', 'Notes', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'taskDetailEditGrid0project_notes_handler_list', $column);
            GetApplication()->RegisterHTTPHandler($handler);//
            // View column for Name field
            //
            $column = new TextViewColumn('task_name_Name', 'Task Name', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'taskDetailEditGrid0project_Name_handler_view', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            //
            // View column for notes field
            //
            $column = new TextViewColumn('notes', 'Notes', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'taskDetailEditGrid0project_notes_handler_view', $column);
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
    
    
    
    // OnBeforePageExecute event handler
    
    
    
    class projectDetailView1projectPage extends DetailPage
    {
        protected function DoBeforeCreate()
        {
            $this->dataset = new TableDataset(
                new MyConnectionFactory(),
                GetConnectionOptions(),
                '`project`');
            $field = new IntegerField('project_id', null, null, true);
            $field->SetIsNotNull(true);
            $this->dataset->AddField($field, true);
            $field = new IntegerField('programm_id');
            $this->dataset->AddField($field, false);
            $field = new StringField('project_name');
            $this->dataset->AddField($field, false);
            $field = new DateField('date_start');
            $this->dataset->AddField($field, false);
            $field = new DateField('date_end');
            $this->dataset->AddField($field, false);
            $field = new IntegerField('approved_budget');
            $this->dataset->AddField($field, false);
            $field = new StringField('notes');
            $field->SetIsNotNull(true);
            $this->dataset->AddField($field, false);
            $field = new StringField('priority');
            $this->dataset->AddField($field, false);
            $field = new StringField('lead');
            $this->dataset->AddField($field, false);
            $field = new StringField('level_of_service');
            $field->SetIsNotNull(true);
            $this->dataset->AddField($field, false);
            $field = new StringField('multi_year');
            $field->SetIsNotNull(true);
            $this->dataset->AddField($field, false);
            $field = new StringField('public_engagement');
            $field->SetIsNotNull(true);
            $this->dataset->AddField($field, false);
            $field = new StringField('year');
            $field->SetIsNotNull(true);
            $this->dataset->AddField($field, false);
            $field = new StringField('approved');
            $field->SetIsNotNull(true);
            $this->dataset->AddField($field, false);
            $field = new StringField('progress');
            $field->SetIsNotNull(true);
            $this->dataset->AddField($field, false);
            $field = new IntegerField('staff_id');
            $field->SetIsNotNull(true);
            $this->dataset->AddField($field, false);
            $field = new IntegerField('dept_id');
            $field->SetIsNotNull(true);
            $this->dataset->AddField($field, false);
            $field = new IntegerField('budget_spent');
            $field->SetIsNotNull(true);
            $this->dataset->AddField($field, false);
            $field = new IntegerField('admin_flag');
            $field->SetIsNotNull(true);
            $this->dataset->AddField($field, false);
            $this->dataset->AddLookupField('programm_id', 'program', new IntegerField('program_id', null, null, true), new StringField('program_name', 'programm_id_program_name', 'programm_id_program_name_program'), 'programm_id_program_name_program');
        }
    
        protected function AddFieldColumns(Grid $grid)
        {
            //
            // View column for program_name field
            //
            $column = new TextViewColumn('programm_id_program_name', 'Programm Id', $this->dataset);
            $column->SetOrderable(false);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for project_name field
            //
            $column = new TextViewColumn('project_name', 'Project Name', $this->dataset);
            $column->SetOrderable(false);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('projectDetailViewGrid1project_project_name_handler_list');
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for date_start field
            //
            $column = new DateTimeViewColumn('date_start', 'Date Start', $this->dataset);
            $column->SetDateTimeFormat('Y-m-d');
            $column->SetOrderable(false);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for date_end field
            //
            $column = new DateTimeViewColumn('date_end', 'Date End', $this->dataset);
            $column->SetDateTimeFormat('Y-m-d H:i:s');
            $column->SetOrderable(false);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for approved_budget field
            //
            $column = new TextViewColumn('approved_budget', 'Approved Budget', $this->dataset);
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
            $column->SetFullTextWindowHandlerName('projectDetailViewGrid1project_notes_handler_list');
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for priority field
            //
            $column = new TextViewColumn('priority', 'Priority', $this->dataset);
            $column->SetOrderable(false);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('projectDetailViewGrid1project_priority_handler_list');
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for lead field
            //
            $column = new TextViewColumn('lead', 'Lead', $this->dataset);
            $column->SetOrderable(false);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for level_of_service field
            //
            $column = new TextViewColumn('level_of_service', 'Level Of Service', $this->dataset);
            $column->SetOrderable(false);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for multi_year field
            //
            $column = new TextViewColumn('multi_year', 'Multi Year', $this->dataset);
            $column->SetOrderable(false);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for public_engagement field
            //
            $column = new TextViewColumn('public_engagement', 'Public Engagement', $this->dataset);
            $column->SetOrderable(false);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('projectDetailViewGrid1project_public_engagement_handler_list');
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for year field
            //
            $column = new TextViewColumn('year', 'Year', $this->dataset);
            $column->SetOrderable(false);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for approved field
            //
            $column = new TextViewColumn('approved', 'Approved', $this->dataset);
            $column->SetOrderable(false);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for progress field
            //
            $column = new TextViewColumn('progress', 'Progress', $this->dataset);
            $column->SetOrderable(false);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for dept_id field
            //
            $column = new TextViewColumn('dept_id', 'Dept Id', $this->dataset);
            $column->SetOrderable(false);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for budget_spent field
            //
            $column = new TextViewColumn('budget_spent', 'Budget Spent', $this->dataset);
            $column->SetOrderable(false);
            $column = new NumberFormatValueViewColumnDecorator($column, 0, '', '');
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
        }
        
        function GetCustomClientScript()
        {
            return ;
        }
        
        function GetOnPageLoadedClientScript()
        {
            return ;
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
            $result = new Grid($this, $this->dataset, 'projectDetailViewGrid1project');
            $result->SetAllowDeleteSelected(false);
            $result->SetUseFixedHeader(false);
            $result->SetShowLineNumbers(false);
            
            $result->SetHighlightRowAtHover(false);
            $result->SetWidth('');
            $this->AddFieldColumns($result);
            //
            // View column for project_name field
            //
            $column = new TextViewColumn('project_name', 'Project Name', $this->dataset);
            $column->SetOrderable(false);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'projectDetailViewGrid1project_project_name_handler_list', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            //
            // View column for notes field
            //
            $column = new TextViewColumn('notes', 'Notes', $this->dataset);
            $column->SetOrderable(false);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'projectDetailViewGrid1project_notes_handler_list', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            //
            // View column for priority field
            //
            $column = new TextViewColumn('priority', 'Priority', $this->dataset);
            $column->SetOrderable(false);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'projectDetailViewGrid1project_priority_handler_list', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            //
            // View column for public_engagement field
            //
            $column = new TextViewColumn('public_engagement', 'Public Engagement', $this->dataset);
            $column->SetOrderable(false);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'projectDetailViewGrid1project_public_engagement_handler_list', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            return $result;
        }
    }
    
    
    
    // OnBeforePageExecute event handler
    
    
    
    class projectDetailEdit1projectPage extends DetailPageEdit
    {
        protected function DoBeforeCreate()
        {
            $this->dataset = new TableDataset(
                new MyConnectionFactory(),
                GetConnectionOptions(),
                '`project`');
            $field = new IntegerField('project_id', null, null, true);
            $field->SetIsNotNull(true);
            $this->dataset->AddField($field, true);
            $field = new IntegerField('programm_id');
            $this->dataset->AddField($field, false);
            $field = new StringField('project_name');
            $this->dataset->AddField($field, false);
            $field = new DateField('date_start');
            $this->dataset->AddField($field, false);
            $field = new DateField('date_end');
            $this->dataset->AddField($field, false);
            $field = new IntegerField('approved_budget');
            $this->dataset->AddField($field, false);
            $field = new StringField('notes');
            $field->SetIsNotNull(true);
            $this->dataset->AddField($field, false);
            $field = new StringField('priority');
            $this->dataset->AddField($field, false);
            $field = new StringField('lead');
            $this->dataset->AddField($field, false);
            $field = new StringField('level_of_service');
            $field->SetIsNotNull(true);
            $this->dataset->AddField($field, false);
            $field = new StringField('multi_year');
            $field->SetIsNotNull(true);
            $this->dataset->AddField($field, false);
            $field = new StringField('public_engagement');
            $field->SetIsNotNull(true);
            $this->dataset->AddField($field, false);
            $field = new StringField('year');
            $field->SetIsNotNull(true);
            $this->dataset->AddField($field, false);
            $field = new StringField('approved');
            $field->SetIsNotNull(true);
            $this->dataset->AddField($field, false);
            $field = new StringField('progress');
            $field->SetIsNotNull(true);
            $this->dataset->AddField($field, false);
            $field = new IntegerField('staff_id');
            $field->SetIsNotNull(true);
            $this->dataset->AddField($field, false);
            $field = new IntegerField('dept_id');
            $field->SetIsNotNull(true);
            $this->dataset->AddField($field, false);
            $field = new IntegerField('budget_spent');
            $field->SetIsNotNull(true);
            $this->dataset->AddField($field, false);
            $field = new IntegerField('admin_flag');
            $field->SetIsNotNull(true);
            $this->dataset->AddField($field, false);
            $this->dataset->AddLookupField('programm_id', 'program', new IntegerField('program_id', null, null, true), new StringField('program_name', 'programm_id_program_name', 'programm_id_program_name_program'), 'programm_id_program_name_program');
        }
    
        protected function CreatePageNavigator()
        {
            return null;
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
            $grid->SearchControl = new SimpleSearch('projectDetailEdit1projectssearch', $this->dataset,
                array('programm_id_program_name', 'project_name', 'date_start', 'date_end', 'approved_budget', 'notes', 'priority', 'lead', 'level_of_service', 'multi_year', 'public_engagement', 'year', 'approved', 'progress', 'dept_id', 'budget_spent'),
                array($this->RenderText('Programm Id'), $this->RenderText('Project Name'), $this->RenderText('Date Start'), $this->RenderText('Date End'), $this->RenderText('Approved Budget'), $this->RenderText('Notes'), $this->RenderText('Priority'), $this->RenderText('Lead'), $this->RenderText('Level Of Service'), $this->RenderText('Multi Year'), $this->RenderText('Public Engagement'), $this->RenderText('Year'), $this->RenderText('Approved'), $this->RenderText('Progress'), $this->RenderText('Dept Id'), $this->RenderText('Budget Spent')),
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
            $this->AdvancedSearchControl = new AdvancedSearchControl('projectDetailEdit1projectasearch', $this->dataset, $this->GetLocalizerCaptions(), $this->GetColumnVariableContainer(), $this->CreateLinkBuilder());
            $this->AdvancedSearchControl->setTimerInterval(1000);
            $lookupDataset = new TableDataset(
                new MyConnectionFactory(),
                GetConnectionOptions(),
                '`program`');
            $field = new IntegerField('program_id', null, null, true);
            $field->SetIsNotNull(true);
            $lookupDataset->AddField($field, true);
            $field = new StringField('program_name');
            $lookupDataset->AddField($field, false);
            $field = new StringField('year');
            $lookupDataset->AddField($field, false);
            $field = new StringField('multi');
            $field->SetIsNotNull(true);
            $lookupDataset->AddField($field, false);
            $field = new StringField('description');
            $field->SetIsNotNull(true);
            $lookupDataset->AddField($field, false);
            $field = new StringField('lead');
            $lookupDataset->AddField($field, false);
            $field = new DateField('date_start');
            $lookupDataset->AddField($field, false);
            $field = new DateField('date_end');
            $lookupDataset->AddField($field, false);
            $field = new IntegerField('progress');
            $field->SetIsNotNull(true);
            $lookupDataset->AddField($field, false);
            $field = new StringField('notes');
            $lookupDataset->AddField($field, false);
            $lookupDataset->SetOrderBy('program_name', GetOrderTypeAsSQL(otAscending));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateLookupSearchInput('programm_id', $this->RenderText('Programm Id'), $lookupDataset, 'program_id', 'program_name', false, 8));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('project_name', $this->RenderText('Project Name')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateDateTimeSearchInput('date_start', $this->RenderText('Date Start'), 'Y-m-d'));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateDateTimeSearchInput('date_end', $this->RenderText('Date End'), 'Y-m-d H:i:s'));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('approved_budget', $this->RenderText('Approved Budget')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('notes', $this->RenderText('Notes')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('priority', $this->RenderText('Priority')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('lead', $this->RenderText('Lead')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('level_of_service', $this->RenderText('Level Of Service')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('multi_year', $this->RenderText('Multi Year')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('public_engagement', $this->RenderText('Public Engagement')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('year', $this->RenderText('Year')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('approved', $this->RenderText('Approved')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('progress', $this->RenderText('Progress')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('dept_id', $this->RenderText('Dept Id')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('budget_spent', $this->RenderText('Budget Spent')));
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
            // View column for program_name field
            //
            $column = new TextViewColumn('programm_id_program_name', 'Programm Id', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for project_name field
            //
            $column = new TextViewColumn('project_name', 'Project Name', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('projectDetailEditGrid1project_project_name_handler_list');
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
            $column->SetDateTimeFormat('Y-m-d H:i:s');
            $column->SetOrderable(true);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for approved_budget field
            //
            $column = new TextViewColumn('approved_budget', 'Approved Budget', $this->dataset);
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
            $column->SetFullTextWindowHandlerName('projectDetailEditGrid1project_notes_handler_list');
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for priority field
            //
            $column = new TextViewColumn('priority', 'Priority', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('projectDetailEditGrid1project_priority_handler_list');
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for lead field
            //
            $column = new TextViewColumn('lead', 'Lead', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for level_of_service field
            //
            $column = new TextViewColumn('level_of_service', 'Level Of Service', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for multi_year field
            //
            $column = new TextViewColumn('multi_year', 'Multi Year', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for public_engagement field
            //
            $column = new TextViewColumn('public_engagement', 'Public Engagement', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('projectDetailEditGrid1project_public_engagement_handler_list');
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for year field
            //
            $column = new TextViewColumn('year', 'Year', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for approved field
            //
            $column = new TextViewColumn('approved', 'Approved', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for progress field
            //
            $column = new TextViewColumn('progress', 'Progress', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for dept_id field
            //
            $column = new TextViewColumn('dept_id', 'Dept Id', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for budget_spent field
            //
            $column = new TextViewColumn('budget_spent', 'Budget Spent', $this->dataset);
            $column->SetOrderable(true);
            $column = new NumberFormatValueViewColumnDecorator($column, 0, '', '');
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
        }
    
        protected function AddSingleRecordViewColumns(Grid $grid)
        {
            //
            // View column for program_name field
            //
            $column = new TextViewColumn('programm_id_program_name', 'Programm Id', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for project_name field
            //
            $column = new TextViewColumn('project_name', 'Project Name', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('projectDetailEditGrid1project_project_name_handler_view');
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
            $column->SetDateTimeFormat('Y-m-d H:i:s');
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for approved_budget field
            //
            $column = new TextViewColumn('approved_budget', 'Approved Budget', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for notes field
            //
            $column = new TextViewColumn('notes', 'Notes', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('projectDetailEditGrid1project_notes_handler_view');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for priority field
            //
            $column = new TextViewColumn('priority', 'Priority', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('projectDetailEditGrid1project_priority_handler_view');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for lead field
            //
            $column = new TextViewColumn('lead', 'Lead', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for level_of_service field
            //
            $column = new TextViewColumn('level_of_service', 'Level Of Service', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for multi_year field
            //
            $column = new TextViewColumn('multi_year', 'Multi Year', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for public_engagement field
            //
            $column = new TextViewColumn('public_engagement', 'Public Engagement', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('projectDetailEditGrid1project_public_engagement_handler_view');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for year field
            //
            $column = new TextViewColumn('year', 'Year', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for approved field
            //
            $column = new TextViewColumn('approved', 'Approved', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for progress field
            //
            $column = new TextViewColumn('progress', 'Progress', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for dept_id field
            //
            $column = new TextViewColumn('dept_id', 'Dept Id', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for budget_spent field
            //
            $column = new TextViewColumn('budget_spent', 'Budget Spent', $this->dataset);
            $column->SetOrderable(true);
            $column = new NumberFormatValueViewColumnDecorator($column, 0, '', '');
            $grid->AddSingleRecordViewColumn($column);
        }
    
        protected function AddEditColumns(Grid $grid)
        {
            //
            // Edit column for programm_id field
            //
            $editor = new ComboBox('programm_id_edit', $this->GetLocalizerCaptions()->GetMessageString('PleaseSelect'));
            $lookupDataset = new TableDataset(
                new MyConnectionFactory(),
                GetConnectionOptions(),
                '`program`');
            $field = new IntegerField('program_id', null, null, true);
            $field->SetIsNotNull(true);
            $lookupDataset->AddField($field, true);
            $field = new StringField('program_name');
            $lookupDataset->AddField($field, false);
            $field = new StringField('year');
            $lookupDataset->AddField($field, false);
            $field = new StringField('multi');
            $field->SetIsNotNull(true);
            $lookupDataset->AddField($field, false);
            $field = new StringField('description');
            $field->SetIsNotNull(true);
            $lookupDataset->AddField($field, false);
            $field = new StringField('lead');
            $lookupDataset->AddField($field, false);
            $field = new DateField('date_start');
            $lookupDataset->AddField($field, false);
            $field = new DateField('date_end');
            $lookupDataset->AddField($field, false);
            $field = new IntegerField('progress');
            $field->SetIsNotNull(true);
            $lookupDataset->AddField($field, false);
            $field = new StringField('notes');
            $lookupDataset->AddField($field, false);
            $lookupDataset->SetOrderBy('program_name', GetOrderTypeAsSQL(otAscending));
            $editColumn = new LookUpEditColumn(
                'Programm Id', 
                'programm_id', 
                $editor, 
                $this->dataset, 'program_id', 'program_name', $lookupDataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for project_name field
            //
            $editor = new TextAreaEdit('project_name_edit', 50, 8);
            $editColumn = new CustomEditColumn('Project Name', 'project_name', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for date_start field
            //
            $editor = new DateTimeEdit('date_start_edit', false, 'Y-m-d', GetFirstDayOfWeek());
            $editColumn = new CustomEditColumn('Date Start', 'date_start', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for date_end field
            //
            $editor = new DateTimeEdit('date_end_edit', true, 'Y-m-d H:i:s', GetFirstDayOfWeek());
            $editColumn = new CustomEditColumn('Date End', 'date_end', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for approved_budget field
            //
            $editor = new TextEdit('approved_budget_edit');
            $editColumn = new CustomEditColumn('Approved Budget', 'approved_budget', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for notes field
            //
            $editor = new TextAreaEdit('notes_edit', 50, 8);
            $editColumn = new CustomEditColumn('Notes', 'notes', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for priority field
            //
            $editor = new TextEdit('priority_edit');
            $editor->SetSize(100);
            $editor->SetMaxLength(100);
            $editColumn = new CustomEditColumn('Priority', 'priority', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for lead field
            //
            $editor = new TextEdit('lead_edit');
            $editor->SetSize(50);
            $editor->SetMaxLength(50);
            $editColumn = new CustomEditColumn('Lead', 'lead', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for level_of_service field
            //
            $editor = new TextEdit('level_of_service_edit');
            $editor->SetSize(55);
            $editor->SetMaxLength(55);
            $editColumn = new CustomEditColumn('Level Of Service', 'level_of_service', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for multi_year field
            //
            $editor = new TextEdit('multi_year_edit');
            $editor->SetSize(10);
            $editor->SetMaxLength(10);
            $editColumn = new CustomEditColumn('Multi Year', 'multi_year', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for public_engagement field
            //
            $editor = new TextEdit('public_engagement_edit');
            $editor->SetSize(100);
            $editor->SetMaxLength(100);
            $editColumn = new CustomEditColumn('Public Engagement', 'public_engagement', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for year field
            //
            $editor = new TextEdit('year_edit');
            $editor->SetSize(4);
            $editor->SetMaxLength(4);
            $editColumn = new CustomEditColumn('Year', 'year', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for approved field
            //
            $editor = new TextEdit('approved_edit');
            $editor->SetSize(10);
            $editor->SetMaxLength(10);
            $editColumn = new CustomEditColumn('Approved', 'approved', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for progress field
            //
            $editor = new TextEdit('progress_edit');
            $editor->SetSize(11);
            $editor->SetMaxLength(11);
            $editColumn = new CustomEditColumn('Progress', 'progress', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for dept_id field
            //
            $editor = new TextEdit('dept_id_edit');
            $editColumn = new CustomEditColumn('Dept Id', 'dept_id', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for budget_spent field
            //
            $editor = new TextEdit('budget_spent_edit');
            $editColumn = new CustomEditColumn('Budget Spent', 'budget_spent', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
        }
    
        protected function AddInsertColumns(Grid $grid)
        {
            //
            // Edit column for programm_id field
            //
            $editor = new ComboBox('programm_id_edit', $this->GetLocalizerCaptions()->GetMessageString('PleaseSelect'));
            $lookupDataset = new TableDataset(
                new MyConnectionFactory(),
                GetConnectionOptions(),
                '`program`');
            $field = new IntegerField('program_id', null, null, true);
            $field->SetIsNotNull(true);
            $lookupDataset->AddField($field, true);
            $field = new StringField('program_name');
            $lookupDataset->AddField($field, false);
            $field = new StringField('year');
            $lookupDataset->AddField($field, false);
            $field = new StringField('multi');
            $field->SetIsNotNull(true);
            $lookupDataset->AddField($field, false);
            $field = new StringField('description');
            $field->SetIsNotNull(true);
            $lookupDataset->AddField($field, false);
            $field = new StringField('lead');
            $lookupDataset->AddField($field, false);
            $field = new DateField('date_start');
            $lookupDataset->AddField($field, false);
            $field = new DateField('date_end');
            $lookupDataset->AddField($field, false);
            $field = new IntegerField('progress');
            $field->SetIsNotNull(true);
            $lookupDataset->AddField($field, false);
            $field = new StringField('notes');
            $lookupDataset->AddField($field, false);
            $lookupDataset->SetOrderBy('program_name', GetOrderTypeAsSQL(otAscending));
            $editColumn = new LookUpEditColumn(
                'Programm Id', 
                'programm_id', 
                $editor, 
                $this->dataset, 'program_id', 'program_name', $lookupDataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for project_name field
            //
            $editor = new TextAreaEdit('project_name_edit', 50, 8);
            $editColumn = new CustomEditColumn('Project Name', 'project_name', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for date_start field
            //
            $editor = new DateTimeEdit('date_start_edit', false, 'Y-m-d', GetFirstDayOfWeek());
            $editColumn = new CustomEditColumn('Date Start', 'date_start', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for date_end field
            //
            $editor = new DateTimeEdit('date_end_edit', true, 'Y-m-d H:i:s', GetFirstDayOfWeek());
            $editColumn = new CustomEditColumn('Date End', 'date_end', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for approved_budget field
            //
            $editor = new TextEdit('approved_budget_edit');
            $editColumn = new CustomEditColumn('Approved Budget', 'approved_budget', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for notes field
            //
            $editor = new TextAreaEdit('notes_edit', 50, 8);
            $editColumn = new CustomEditColumn('Notes', 'notes', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for priority field
            //
            $editor = new TextEdit('priority_edit');
            $editor->SetSize(100);
            $editor->SetMaxLength(100);
            $editColumn = new CustomEditColumn('Priority', 'priority', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for lead field
            //
            $editor = new TextEdit('lead_edit');
            $editor->SetSize(50);
            $editor->SetMaxLength(50);
            $editColumn = new CustomEditColumn('Lead', 'lead', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for level_of_service field
            //
            $editor = new TextEdit('level_of_service_edit');
            $editor->SetSize(55);
            $editor->SetMaxLength(55);
            $editColumn = new CustomEditColumn('Level Of Service', 'level_of_service', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for multi_year field
            //
            $editor = new TextEdit('multi_year_edit');
            $editor->SetSize(10);
            $editor->SetMaxLength(10);
            $editColumn = new CustomEditColumn('Multi Year', 'multi_year', $editor, $this->dataset);
            $editColumn->SetAllowSetToDefault(true);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for public_engagement field
            //
            $editor = new TextEdit('public_engagement_edit');
            $editor->SetSize(100);
            $editor->SetMaxLength(100);
            $editColumn = new CustomEditColumn('Public Engagement', 'public_engagement', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for year field
            //
            $editor = new TextEdit('year_edit');
            $editor->SetSize(4);
            $editor->SetMaxLength(4);
            $editColumn = new CustomEditColumn('Year', 'year', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for approved field
            //
            $editor = new TextEdit('approved_edit');
            $editor->SetSize(10);
            $editor->SetMaxLength(10);
            $editColumn = new CustomEditColumn('Approved', 'approved', $editor, $this->dataset);
            $editColumn->SetAllowSetToDefault(true);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for progress field
            //
            $editor = new TextEdit('progress_edit');
            $editor->SetSize(11);
            $editor->SetMaxLength(11);
            $editColumn = new CustomEditColumn('Progress', 'progress', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for dept_id field
            //
            $editor = new TextEdit('dept_id_edit');
            $editColumn = new CustomEditColumn('Dept Id', 'dept_id', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for budget_spent field
            //
            $editor = new TextEdit('budget_spent_edit');
            $editColumn = new CustomEditColumn('Budget Spent', 'budget_spent', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
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
            // View column for program_name field
            //
            $column = new TextViewColumn('programm_id_program_name', 'Programm Id', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for project_name field
            //
            $column = new TextViewColumn('project_name', 'Project Name', $this->dataset);
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
            $column->SetDateTimeFormat('Y-m-d H:i:s');
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for approved_budget field
            //
            $column = new TextViewColumn('approved_budget', 'Approved Budget', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for notes field
            //
            $column = new TextViewColumn('notes', 'Notes', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for priority field
            //
            $column = new TextViewColumn('priority', 'Priority', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for lead field
            //
            $column = new TextViewColumn('lead', 'Lead', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for level_of_service field
            //
            $column = new TextViewColumn('level_of_service', 'Level Of Service', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for multi_year field
            //
            $column = new TextViewColumn('multi_year', 'Multi Year', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for public_engagement field
            //
            $column = new TextViewColumn('public_engagement', 'Public Engagement', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for year field
            //
            $column = new TextViewColumn('year', 'Year', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for approved field
            //
            $column = new TextViewColumn('approved', 'Approved', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for progress field
            //
            $column = new TextViewColumn('progress', 'Progress', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for dept_id field
            //
            $column = new TextViewColumn('dept_id', 'Dept Id', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for budget_spent field
            //
            $column = new TextViewColumn('budget_spent', 'Budget Spent', $this->dataset);
            $column->SetOrderable(true);
            $column = new NumberFormatValueViewColumnDecorator($column, 0, '', '');
            $grid->AddPrintColumn($column);
        }
    
        protected function AddExportColumns(Grid $grid)
        {
            //
            // View column for program_name field
            //
            $column = new TextViewColumn('programm_id_program_name', 'Programm Id', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for project_name field
            //
            $column = new TextViewColumn('project_name', 'Project Name', $this->dataset);
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
            $column->SetDateTimeFormat('Y-m-d H:i:s');
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for approved_budget field
            //
            $column = new TextViewColumn('approved_budget', 'Approved Budget', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for notes field
            //
            $column = new TextViewColumn('notes', 'Notes', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for priority field
            //
            $column = new TextViewColumn('priority', 'Priority', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for lead field
            //
            $column = new TextViewColumn('lead', 'Lead', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for level_of_service field
            //
            $column = new TextViewColumn('level_of_service', 'Level Of Service', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for multi_year field
            //
            $column = new TextViewColumn('multi_year', 'Multi Year', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for public_engagement field
            //
            $column = new TextViewColumn('public_engagement', 'Public Engagement', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for year field
            //
            $column = new TextViewColumn('year', 'Year', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for approved field
            //
            $column = new TextViewColumn('approved', 'Approved', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for progress field
            //
            $column = new TextViewColumn('progress', 'Progress', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for dept_id field
            //
            $column = new TextViewColumn('dept_id', 'Dept Id', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for budget_spent field
            //
            $column = new TextViewColumn('budget_spent', 'Budget Spent', $this->dataset);
            $column->SetOrderable(true);
            $column = new NumberFormatValueViewColumnDecorator($column, 0, '', '');
            $grid->AddExportColumn($column);
        }
    
        protected function ApplyCommonColumnEditProperties(CustomEditColumn $column)
        {
            $column->SetDisplaySetToNullCheckBox(false);
            $column->SetDisplaySetToDefaultCheckBox(false);
        	$column->SetVariableContainer($this->GetColumnVariableContainer());
        }
    
        function GetCustomClientScript()
        {
            return ;
        }
        
        function GetOnPageLoadedClientScript()
        {
            return ;
        }
        public function projectDetailEditGrid1project_OnGetCustomTemplate($part, $mode, &$result, &$params)
        {
        if ($part == PagePart::Grid && $mode == PageMode::ViewAll)
          $result = 'project_detail.tpl';
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
        
        public function GetModalGridDeleteHandler() { return 'projectDetailEdit1project_modal_delete'; }
        protected function GetEnableModalGridDelete() { return true; }
    
        protected function CreateGrid()
        {
            $result = new Grid($this, $this->dataset, 'projectDetailEditGrid1project');
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
            $this->OnGetCustomTemplate->AddListener('projectDetailEditGrid1project' . '_OnGetCustomTemplate', $this);
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
            $this->SetShowTopPageNavigator(false);
            $this->SetShowBottomPageNavigator(false);
    
            //
            // Http Handlers
            //
            //
            // View column for project_name field
            //
            $column = new TextViewColumn('project_name', 'Project Name', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'projectDetailEditGrid1project_project_name_handler_list', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            //
            // View column for notes field
            //
            $column = new TextViewColumn('notes', 'Notes', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'projectDetailEditGrid1project_notes_handler_list', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            //
            // View column for priority field
            //
            $column = new TextViewColumn('priority', 'Priority', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'projectDetailEditGrid1project_priority_handler_list', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            //
            // View column for public_engagement field
            //
            $column = new TextViewColumn('public_engagement', 'Public Engagement', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'projectDetailEditGrid1project_public_engagement_handler_list', $column);
            GetApplication()->RegisterHTTPHandler($handler);//
            // View column for project_name field
            //
            $column = new TextViewColumn('project_name', 'Project Name', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'projectDetailEditGrid1project_project_name_handler_view', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            //
            // View column for notes field
            //
            $column = new TextViewColumn('notes', 'Notes', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'projectDetailEditGrid1project_notes_handler_view', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            //
            // View column for priority field
            //
            $column = new TextViewColumn('priority', 'Priority', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'projectDetailEditGrid1project_priority_handler_view', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            //
            // View column for public_engagement field
            //
            $column = new TextViewColumn('public_engagement', 'Public Engagement', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'projectDetailEditGrid1project_public_engagement_handler_view', $column);
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
    
    
    
    // OnBeforePageExecute event handler
    
    
    
    class project_timeline_detailDetailView2projectPage extends DetailPage
    {
        protected function DoBeforeCreate()
        {
            $selectQuery = 'SELECT 
              `project`.`project_name`,
              `project`.`date_start` AS project_date_start,
              `project`.`date_end` AS project_date_end,
              `project`.`lead`,
              `project`.`year`,
              `project`.`progress`,
              `project`.`project_id`,
              `task`.`task_id`,
              `task`.`project_id` AS task_project_id,
              `task`.`assigned_to`,
              `task`.`date_start` AS task_date_start,
              `task`.`date_end` AS task_date_end,
              `task`.`task_name`,
              `task`.`staff_id`
            FROM
              `project`
              INNER JOIN `task` ON (`project`.`project_id` = `task`.`project_id`)';
            $insertQuery = array();
            $updateQuery = array();
            $deleteQuery = array();
            $this->dataset = new QueryDataset(
              new MyConnectionFactory(), 
              GetConnectionOptions(),
              $selectQuery, $insertQuery, $updateQuery, $deleteQuery, 'project_timeline_detail');
            $field = new StringField('project_name');
            $this->dataset->AddField($field, false);
            $field = new DateField('project_date_start');
            $this->dataset->AddField($field, false);
            $field = new DateField('project_date_end');
            $this->dataset->AddField($field, false);
            $field = new StringField('lead');
            $this->dataset->AddField($field, false);
            $field = new StringField('year');
            $field->SetIsNotNull(true);
            $this->dataset->AddField($field, false);
            $field = new StringField('progress');
            $field->SetIsNotNull(true);
            $this->dataset->AddField($field, false);
            $field = new IntegerField('project_id');
            $field->SetIsNotNull(true);
            $this->dataset->AddField($field, true);
            $field = new IntegerField('task_id');
            $field->SetIsNotNull(true);
            $this->dataset->AddField($field, true);
            $field = new IntegerField('task_project_id');
            $this->dataset->AddField($field, false);
            $field = new StringField('assigned_to');
            $this->dataset->AddField($field, false);
            $field = new DateField('task_date_start');
            $this->dataset->AddField($field, false);
            $field = new DateField('task_date_end');
            $this->dataset->AddField($field, false);
            $field = new StringField('task_name');
            $this->dataset->AddField($field, false);
            $field = new IntegerField('staff_id');
            $this->dataset->AddField($field, false);
        }
    
        protected function AddFieldColumns(Grid $grid)
        {
            //
            // View column for project_name field
            //
            $column = new TextViewColumn('project_name', 'Project Name', $this->dataset);
            $column->SetOrderable(false);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for project_date_start field
            //
            $column = new DateTimeViewColumn('project_date_start', 'Project Date Start', $this->dataset);
            $column->SetDateTimeFormat('d-m-Y');
            $column->SetOrderable(false);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for project_date_end field
            //
            $column = new DateTimeViewColumn('project_date_end', 'Project Date End', $this->dataset);
            $column->SetDateTimeFormat('d-m-Y');
            $column->SetOrderable(false);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for lead field
            //
            $column = new TextViewColumn('lead', 'Lead', $this->dataset);
            $column->SetOrderable(false);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for year field
            //
            $column = new TextViewColumn('year', 'Year', $this->dataset);
            $column->SetOrderable(false);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for progress field
            //
            $column = new TextViewColumn('progress', 'Progress', $this->dataset);
            $column->SetOrderable(false);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for project_id field
            //
            $column = new TextViewColumn('project_id', 'Project Id', $this->dataset);
            $column->SetOrderable(false);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for task_id field
            //
            $column = new TextViewColumn('task_id', 'Task Id', $this->dataset);
            $column->SetOrderable(false);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for task_project_id field
            //
            $column = new TextViewColumn('task_project_id', 'Task Project Id', $this->dataset);
            $column->SetOrderable(false);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for assigned_to field
            //
            $column = new TextViewColumn('assigned_to', 'Assigned To', $this->dataset);
            $column->SetOrderable(false);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for task_date_start field
            //
            $column = new DateTimeViewColumn('task_date_start', 'Task Date Start', $this->dataset);
            $column->SetDateTimeFormat('Y-m-d');
            $column->SetOrderable(false);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for task_date_end field
            //
            $column = new DateTimeViewColumn('task_date_end', 'Task Date End', $this->dataset);
            $column->SetDateTimeFormat('Y-m-d');
            $column->SetOrderable(false);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for task_name field
            //
            $column = new TextViewColumn('task_name', 'Task Name', $this->dataset);
            $column->SetOrderable(false);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
        }
        
        function GetCustomClientScript()
        {
            return ;
        }
        
        function GetOnPageLoadedClientScript()
        {
            return ;
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
            $result = new Grid($this, $this->dataset, 'project_timeline_detailDetailViewGrid2project');
            $result->SetAllowDeleteSelected(false);
            $result->SetUseFixedHeader(false);
            $result->SetShowLineNumbers(false);
            
            $result->SetHighlightRowAtHover(false);
            $result->SetWidth('');
            $this->AddFieldColumns($result);
    
            return $result;
        }
    }
    
    
    
    // OnBeforePageExecute event handler
    
    
    
    class project_timeline_detailDetailEdit2projectPage extends DetailPageEdit
    {
        protected function DoBeforeCreate()
        {
            $selectQuery = 'SELECT 
              `project`.`project_name`,
              `project`.`date_start` AS project_date_start,
              `project`.`date_end` AS project_date_end,
              `project`.`lead`,
              `project`.`year`,
              `project`.`progress`,
              `project`.`project_id`,
              `task`.`task_id`,
              `task`.`project_id` AS task_project_id,
              `task`.`assigned_to`,
              `task`.`date_start` AS task_date_start,
              `task`.`date_end` AS task_date_end,
              `task`.`task_name`,
              `task`.`staff_id`
            FROM
              `project`
              INNER JOIN `task` ON (`project`.`project_id` = `task`.`project_id`)';
            $insertQuery = array();
            $updateQuery = array();
            $deleteQuery = array();
            $this->dataset = new QueryDataset(
              new MyConnectionFactory(), 
              GetConnectionOptions(),
              $selectQuery, $insertQuery, $updateQuery, $deleteQuery, 'project_timeline_detail');
            $field = new StringField('project_name');
            $this->dataset->AddField($field, false);
            $field = new DateField('project_date_start');
            $this->dataset->AddField($field, false);
            $field = new DateField('project_date_end');
            $this->dataset->AddField($field, false);
            $field = new StringField('lead');
            $this->dataset->AddField($field, false);
            $field = new StringField('year');
            $field->SetIsNotNull(true);
            $this->dataset->AddField($field, false);
            $field = new StringField('progress');
            $field->SetIsNotNull(true);
            $this->dataset->AddField($field, false);
            $field = new IntegerField('project_id');
            $field->SetIsNotNull(true);
            $this->dataset->AddField($field, true);
            $field = new IntegerField('task_id');
            $field->SetIsNotNull(true);
            $this->dataset->AddField($field, true);
            $field = new IntegerField('task_project_id');
            $this->dataset->AddField($field, false);
            $field = new StringField('assigned_to');
            $this->dataset->AddField($field, false);
            $field = new DateField('task_date_start');
            $this->dataset->AddField($field, false);
            $field = new DateField('task_date_end');
            $this->dataset->AddField($field, false);
            $field = new StringField('task_name');
            $this->dataset->AddField($field, false);
            $field = new IntegerField('staff_id');
            $this->dataset->AddField($field, false);
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
            $grid->SearchControl = new SimpleSearch('project_timeline_detailDetailEdit2projectssearch', $this->dataset,
                array('project_name', 'project_date_start', 'project_date_end', 'lead', 'year', 'progress', 'project_id', 'task_id', 'task_project_id', 'assigned_to', 'task_date_start', 'task_date_end', 'task_name'),
                array($this->RenderText('Project Name'), $this->RenderText('Project Date Start'), $this->RenderText('Project Date End'), $this->RenderText('Lead'), $this->RenderText('Year'), $this->RenderText('Progress'), $this->RenderText('Project Id'), $this->RenderText('Task Id'), $this->RenderText('Task Project Id'), $this->RenderText('Assigned To'), $this->RenderText('Task Date Start'), $this->RenderText('Task Date End'), $this->RenderText('Task Name')),
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
            $this->AdvancedSearchControl = new AdvancedSearchControl('project_timeline_detailDetailEdit2projectasearch', $this->dataset, $this->GetLocalizerCaptions(), $this->GetColumnVariableContainer(), $this->CreateLinkBuilder());
            $this->AdvancedSearchControl->setTimerInterval(1000);
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('project_name', $this->RenderText('Project Name')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateDateTimeSearchInput('project_date_start', $this->RenderText('Project Date Start'), 'd-m-Y'));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateDateTimeSearchInput('project_date_end', $this->RenderText('Project Date End'), 'd-m-Y'));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('lead', $this->RenderText('Lead')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('year', $this->RenderText('Year')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('progress', $this->RenderText('Progress')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('project_id', $this->RenderText('Project Id')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('task_id', $this->RenderText('Task Id')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('task_project_id', $this->RenderText('Task Project Id')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('assigned_to', $this->RenderText('Assigned To')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateDateTimeSearchInput('task_date_start', $this->RenderText('Task Date Start'), 'Y-m-d'));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateDateTimeSearchInput('task_date_end', $this->RenderText('Task Date End'), 'Y-m-d'));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('task_name', $this->RenderText('Task Name')));
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
        }
    
        protected function AddFieldColumns(Grid $grid)
        {
            //
            // View column for project_name field
            //
            $column = new TextViewColumn('project_name', 'Project Name', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for project_date_start field
            //
            $column = new DateTimeViewColumn('project_date_start', 'Project Date Start', $this->dataset);
            $column->SetDateTimeFormat('d-m-Y');
            $column->SetOrderable(true);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for project_date_end field
            //
            $column = new DateTimeViewColumn('project_date_end', 'Project Date End', $this->dataset);
            $column->SetDateTimeFormat('d-m-Y');
            $column->SetOrderable(true);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for lead field
            //
            $column = new TextViewColumn('lead', 'Lead', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for year field
            //
            $column = new TextViewColumn('year', 'Year', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for progress field
            //
            $column = new TextViewColumn('progress', 'Progress', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for project_id field
            //
            $column = new TextViewColumn('project_id', 'Project Id', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for task_id field
            //
            $column = new TextViewColumn('task_id', 'Task Id', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for task_project_id field
            //
            $column = new TextViewColumn('task_project_id', 'Task Project Id', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for assigned_to field
            //
            $column = new TextViewColumn('assigned_to', 'Assigned To', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for task_date_start field
            //
            $column = new DateTimeViewColumn('task_date_start', 'Task Date Start', $this->dataset);
            $column->SetDateTimeFormat('Y-m-d');
            $column->SetOrderable(true);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for task_date_end field
            //
            $column = new DateTimeViewColumn('task_date_end', 'Task Date End', $this->dataset);
            $column->SetDateTimeFormat('Y-m-d');
            $column->SetOrderable(true);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for task_name field
            //
            $column = new TextViewColumn('task_name', 'Task Name', $this->dataset);
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
            $column = new TextViewColumn('project_name', 'Project Name', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for project_date_start field
            //
            $column = new DateTimeViewColumn('project_date_start', 'Project Date Start', $this->dataset);
            $column->SetDateTimeFormat('d-m-Y');
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for project_date_end field
            //
            $column = new DateTimeViewColumn('project_date_end', 'Project Date End', $this->dataset);
            $column->SetDateTimeFormat('d-m-Y');
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for lead field
            //
            $column = new TextViewColumn('lead', 'Lead', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for year field
            //
            $column = new TextViewColumn('year', 'Year', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for progress field
            //
            $column = new TextViewColumn('progress', 'Progress', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for project_id field
            //
            $column = new TextViewColumn('project_id', 'Project Id', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for task_id field
            //
            $column = new TextViewColumn('task_id', 'Task Id', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for task_project_id field
            //
            $column = new TextViewColumn('task_project_id', 'Task Project Id', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for assigned_to field
            //
            $column = new TextViewColumn('assigned_to', 'Assigned To', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for task_date_start field
            //
            $column = new DateTimeViewColumn('task_date_start', 'Task Date Start', $this->dataset);
            $column->SetDateTimeFormat('Y-m-d');
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for task_date_end field
            //
            $column = new DateTimeViewColumn('task_date_end', 'Task Date End', $this->dataset);
            $column->SetDateTimeFormat('Y-m-d');
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for task_name field
            //
            $column = new TextViewColumn('task_name', 'Task Name', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
        }
    
        protected function AddEditColumns(Grid $grid)
        {
            //
            // Edit column for project_name field
            //
            $editor = new TextEdit('project_name_edit');
            $editColumn = new CustomEditColumn('Project Name', 'project_name', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for project_date_start field
            //
            $editor = new DateTimeEdit('project_date_start_edit', false, 'Y-m-d H:i:s', GetFirstDayOfWeek());
            $editColumn = new CustomEditColumn('Project Date Start', 'project_date_start', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for project_date_end field
            //
            $editor = new DateTimeEdit('project_date_end_edit', false, 'Y-m-d H:i:s', GetFirstDayOfWeek());
            $editColumn = new CustomEditColumn('Project Date End', 'project_date_end', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for lead field
            //
            $editor = new TextEdit('lead_edit');
            $editColumn = new CustomEditColumn('Lead', 'lead', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for year field
            //
            $editor = new TextEdit('year_edit');
            $editColumn = new CustomEditColumn('Year', 'year', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for progress field
            //
            $editor = new TextEdit('progress_edit');
            $editColumn = new CustomEditColumn('Progress', 'progress', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for project_id field
            //
            $editor = new SpinEdit('project_id_edit');
            $editColumn = new CustomEditColumn('Project Id', 'project_id', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for task_id field
            //
            $editor = new SpinEdit('task_id_edit');
            $editColumn = new CustomEditColumn('Task Id', 'task_id', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for task_project_id field
            //
            $editor = new SpinEdit('task_project_id_edit');
            $editColumn = new CustomEditColumn('Task Project Id', 'task_project_id', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for assigned_to field
            //
            $editor = new TextEdit('assigned_to_edit');
            $editColumn = new CustomEditColumn('Assigned To', 'assigned_to', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for task_date_start field
            //
            $editor = new DateTimeEdit('task_date_start_edit', false, 'Y-m-d ', GetFirstDayOfWeek());
            $editColumn = new CustomEditColumn('Task Date Start', 'task_date_start', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for task_date_end field
            //
            $editor = new DateTimeEdit('task_date_end_edit', false, 'Y-m-d', GetFirstDayOfWeek());
            $editColumn = new CustomEditColumn('Task Date End', 'task_date_end', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for task_name field
            //
            $editor = new TextEdit('task_name_edit');
            $editColumn = new CustomEditColumn('Task Name', 'task_name', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
        }
    
        protected function AddInsertColumns(Grid $grid)
        {
            //
            // Edit column for project_name field
            //
            $editor = new TextEdit('project_name_edit');
            $editColumn = new CustomEditColumn('Project Name', 'project_name', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for project_date_start field
            //
            $editor = new DateTimeEdit('project_date_start_edit', false, 'Y-m-d H:i:s', GetFirstDayOfWeek());
            $editColumn = new CustomEditColumn('Project Date Start', 'project_date_start', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for project_date_end field
            //
            $editor = new DateTimeEdit('project_date_end_edit', false, 'Y-m-d H:i:s', GetFirstDayOfWeek());
            $editColumn = new CustomEditColumn('Project Date End', 'project_date_end', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for lead field
            //
            $editor = new TextEdit('lead_edit');
            $editColumn = new CustomEditColumn('Lead', 'lead', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for year field
            //
            $editor = new TextEdit('year_edit');
            $editColumn = new CustomEditColumn('Year', 'year', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for progress field
            //
            $editor = new TextEdit('progress_edit');
            $editColumn = new CustomEditColumn('Progress', 'progress', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for project_id field
            //
            $editor = new SpinEdit('project_id_edit');
            $editColumn = new CustomEditColumn('Project Id', 'project_id', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for task_id field
            //
            $editor = new SpinEdit('task_id_edit');
            $editColumn = new CustomEditColumn('Task Id', 'task_id', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for task_project_id field
            //
            $editor = new SpinEdit('task_project_id_edit');
            $editColumn = new CustomEditColumn('Task Project Id', 'task_project_id', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for assigned_to field
            //
            $editor = new TextEdit('assigned_to_edit');
            $editColumn = new CustomEditColumn('Assigned To', 'assigned_to', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for task_date_start field
            //
            $editor = new DateTimeEdit('task_date_start_edit', false, 'Y-m-d ', GetFirstDayOfWeek());
            $editColumn = new CustomEditColumn('Task Date Start', 'task_date_start', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for task_date_end field
            //
            $editor = new DateTimeEdit('task_date_end_edit', false, 'Y-m-d', GetFirstDayOfWeek());
            $editColumn = new CustomEditColumn('Task Date End', 'task_date_end', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for task_name field
            //
            $editor = new TextEdit('task_name_edit');
            $editColumn = new CustomEditColumn('Task Name', 'task_name', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            if ($this->GetSecurityInfo()->HasAddGrant())
            {
                $grid->SetShowAddButton(false);
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
            $column = new TextViewColumn('project_name', 'Project Name', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for project_date_start field
            //
            $column = new DateTimeViewColumn('project_date_start', 'Project Date Start', $this->dataset);
            $column->SetDateTimeFormat('d-m-Y');
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for project_date_end field
            //
            $column = new DateTimeViewColumn('project_date_end', 'Project Date End', $this->dataset);
            $column->SetDateTimeFormat('d-m-Y');
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for lead field
            //
            $column = new TextViewColumn('lead', 'Lead', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for year field
            //
            $column = new TextViewColumn('year', 'Year', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for progress field
            //
            $column = new TextViewColumn('progress', 'Progress', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for project_id field
            //
            $column = new TextViewColumn('project_id', 'Project Id', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for task_id field
            //
            $column = new TextViewColumn('task_id', 'Task Id', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for task_project_id field
            //
            $column = new TextViewColumn('task_project_id', 'Task Project Id', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for assigned_to field
            //
            $column = new TextViewColumn('assigned_to', 'Assigned To', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for task_date_start field
            //
            $column = new DateTimeViewColumn('task_date_start', 'Task Date Start', $this->dataset);
            $column->SetDateTimeFormat('Y-m-d');
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for task_date_end field
            //
            $column = new DateTimeViewColumn('task_date_end', 'Task Date End', $this->dataset);
            $column->SetDateTimeFormat('Y-m-d');
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for task_name field
            //
            $column = new TextViewColumn('task_name', 'Task Name', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
        }
    
        protected function AddExportColumns(Grid $grid)
        {
            //
            // View column for project_name field
            //
            $column = new TextViewColumn('project_name', 'Project Name', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for project_date_start field
            //
            $column = new DateTimeViewColumn('project_date_start', 'Project Date Start', $this->dataset);
            $column->SetDateTimeFormat('d-m-Y');
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for project_date_end field
            //
            $column = new DateTimeViewColumn('project_date_end', 'Project Date End', $this->dataset);
            $column->SetDateTimeFormat('d-m-Y');
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for lead field
            //
            $column = new TextViewColumn('lead', 'Lead', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for year field
            //
            $column = new TextViewColumn('year', 'Year', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for progress field
            //
            $column = new TextViewColumn('progress', 'Progress', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for project_id field
            //
            $column = new TextViewColumn('project_id', 'Project Id', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for task_id field
            //
            $column = new TextViewColumn('task_id', 'Task Id', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for task_project_id field
            //
            $column = new TextViewColumn('task_project_id', 'Task Project Id', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for assigned_to field
            //
            $column = new TextViewColumn('assigned_to', 'Assigned To', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for task_date_start field
            //
            $column = new DateTimeViewColumn('task_date_start', 'Task Date Start', $this->dataset);
            $column->SetDateTimeFormat('Y-m-d');
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for task_date_end field
            //
            $column = new DateTimeViewColumn('task_date_end', 'Task Date End', $this->dataset);
            $column->SetDateTimeFormat('Y-m-d');
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for task_name field
            //
            $column = new TextViewColumn('task_name', 'Task Name', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
        }
    
        protected function ApplyCommonColumnEditProperties(CustomEditColumn $column)
        {
            $column->SetDisplaySetToNullCheckBox(false);
            $column->SetDisplaySetToDefaultCheckBox(false);
        	$column->SetVariableContainer($this->GetColumnVariableContainer());
        }
    
        function GetCustomClientScript()
        {
            return ;
        }
        
        function GetOnPageLoadedClientScript()
        {
            return ;
        }
        public function project_timeline_detailDetailEditGrid2project_OnGetCustomTemplate($part, $mode, &$result, &$params)
        {
        if ($part == PagePart::Grid && $mode == PageMode::ViewAll)
          $result = 'task_view_timeline1.tpl';
        }
    
        protected function CreateGrid()
        {
            $result = new Grid($this, $this->dataset, 'project_timeline_detailDetailEditGrid2project');
            if ($this->GetSecurityInfo()->HasDeleteGrant())
                $result->SetAllowDeleteSelected(false);
            else
                $result->SetAllowDeleteSelected(false);
            ApplyCommonPageSettings($this, $result);
            $result->SetUseImagesForActions(true);
            $result->SetUseFixedHeader(false);
            $result->SetShowLineNumbers(false);
            
            $result->SetHighlightRowAtHover(false);
            $result->SetWidth('');
            $this->OnGetCustomTemplate->AddListener('project_timeline_detailDetailEditGrid2project' . '_OnGetCustomTemplate', $this);
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
    
    
    
    class projectPage extends Page
    {
        protected function DoBeforeCreate()
        {
            $this->dataset = new TableDataset(
                new MyConnectionFactory(),
                GetConnectionOptions(),
                '`project`');
            $field = new IntegerField('project_id', null, null, true);
            $field->SetIsNotNull(true);
            $this->dataset->AddField($field, true);
            $field = new IntegerField('programm_id');
            $this->dataset->AddField($field, false);
            $field = new StringField('project_name');
            $this->dataset->AddField($field, false);
            $field = new DateField('date_start');
            $this->dataset->AddField($field, false);
            $field = new DateField('date_end');
            $this->dataset->AddField($field, false);
            $field = new IntegerField('approved_budget');
            $this->dataset->AddField($field, false);
            $field = new StringField('notes');
            $field->SetIsNotNull(true);
            $this->dataset->AddField($field, false);
            $field = new StringField('priority');
            $this->dataset->AddField($field, false);
            $field = new StringField('lead');
            $this->dataset->AddField($field, false);
            $field = new StringField('level_of_service');
            $field->SetIsNotNull(true);
            $this->dataset->AddField($field, false);
            $field = new StringField('multi_year');
            $field->SetIsNotNull(true);
            $this->dataset->AddField($field, false);
            $field = new StringField('public_engagement');
            $field->SetIsNotNull(true);
            $this->dataset->AddField($field, false);
            $field = new StringField('year');
            $field->SetIsNotNull(true);
            $this->dataset->AddField($field, false);
            $field = new StringField('approved');
            $field->SetIsNotNull(true);
            $this->dataset->AddField($field, false);
            $field = new StringField('progress');
            $field->SetIsNotNull(true);
            $this->dataset->AddField($field, false);
            $field = new IntegerField('staff_id');
            if (!$this->GetSecurityInfo()->AdminGrant())
              $field->SetReadOnly(false, GetApplication()->GetCurrentUserId());
            $field->SetIsNotNull(true);
            $this->dataset->AddField($field, false);
            $field = new IntegerField('dept_id');
            $field->SetIsNotNull(true);
            $this->dataset->AddField($field, false);
            $field = new IntegerField('budget_spent');
            $field->SetIsNotNull(true);
            $this->dataset->AddField($field, false);
            $field = new IntegerField('admin_flag');
            $field->SetIsNotNull(true);
            $this->dataset->AddField($field, false);
            $this->dataset->AddLookupField('programm_id', 'program', new IntegerField('program_id', null, null, true), new StringField('program_name', 'programm_id_program_name', 'programm_id_program_name_program'), 'programm_id_program_name_program');
            $this->dataset->AddLookupField('priority', 'Priority', new StringField('Name'), new StringField('Name', 'priority_Name', 'priority_Name_Priority'), 'priority_Name_Priority');
            $this->dataset->AddLookupField('lead', 'staff', new IntegerField('staff_id', null, null, true), new StringField('username', 'lead_username', 'lead_username_staff'), 'lead_username_staff');
            $this->dataset->AddLookupField('dept_id', 'department', new IntegerField('DEPT_ID', null, null, true), new StringField('DEPARTMENT', 'dept_id_DEPARTMENT', 'dept_id_DEPARTMENT_department'), 'dept_id_DEPARTMENT_department');
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
            
            $partitionNavigator = new CustomPageNavigator('partition', $this, $this->dataset, $this->RenderText('Department'), $result);
            $partitionNavigator->OnGetPartitionCondition->AddListener('partition' . '_GetPartitionConditionHandler', $this);
            $partitionNavigator->OnGetPartitions->AddListener('partition' . '_GetPartitionsHandler', $this);
            $partitionNavigator->SetAllowViewAllRecords(true);
            $partitionNavigator->SetNavigationStyle(NS_LIST);
            $result->AddPageNavigator($partitionNavigator);
            
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
            $grid->SearchControl = new SimpleSearch('projectssearch', $this->dataset,
                array('programm_id_program_name', 'project_name', 'date_start', 'date_end', 'year', 'notes', 'priority_Name', 'lead_username', 'approved_budget', 'budget_spent', 'multi_year', 'public_engagement', 'level_of_service', 'approved', 'progress', 'dept_id_DEPARTMENT'),
                array($this->RenderText('Project Type'), $this->RenderText('Project Name'), $this->RenderText('Date Start'), $this->RenderText('Date End'), $this->RenderText('Year'), $this->RenderText('Objectives'), $this->RenderText('Priority'), $this->RenderText('Project Lead'), $this->RenderText('Approved Budget'), $this->RenderText('Budget Spent'), $this->RenderText('Multi Year'), $this->RenderText('Public Engagement'), $this->RenderText('Level Of Service'), $this->RenderText('Approved by CAO'), $this->RenderText('Progress'), $this->RenderText('Department')),
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
            $this->AdvancedSearchControl = new AdvancedSearchControl('projectasearch', $this->dataset, $this->GetLocalizerCaptions(), $this->GetColumnVariableContainer(), $this->CreateLinkBuilder());
            $this->AdvancedSearchControl->setTimerInterval(1000);
            $lookupDataset = new TableDataset(
                new MyConnectionFactory(),
                GetConnectionOptions(),
                '`program`');
            $field = new IntegerField('program_id', null, null, true);
            $field->SetIsNotNull(true);
            $lookupDataset->AddField($field, true);
            $field = new StringField('program_name');
            $lookupDataset->AddField($field, false);
            $field = new StringField('year');
            $lookupDataset->AddField($field, false);
            $field = new StringField('multi');
            $field->SetIsNotNull(true);
            $lookupDataset->AddField($field, false);
            $field = new StringField('description');
            $field->SetIsNotNull(true);
            $lookupDataset->AddField($field, false);
            $field = new StringField('lead');
            $lookupDataset->AddField($field, false);
            $field = new DateField('date_start');
            $lookupDataset->AddField($field, false);
            $field = new DateField('date_end');
            $lookupDataset->AddField($field, false);
            $field = new IntegerField('progress');
            $field->SetIsNotNull(true);
            $lookupDataset->AddField($field, false);
            $field = new StringField('notes');
            $lookupDataset->AddField($field, false);
            $lookupDataset->SetOrderBy('program_name', GetOrderTypeAsSQL(otAscending));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateLookupSearchInput('programm_id', $this->RenderText('Project Type'), $lookupDataset, 'program_id', 'program_name', false, 8));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('project_name', $this->RenderText('Project Name')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateDateTimeSearchInput('date_start', $this->RenderText('Date Start'), 'Y-m-d'));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateDateTimeSearchInput('date_end', $this->RenderText('Date End'), 'Y-m-d'));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('year', $this->RenderText('Year')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('notes', $this->RenderText('Objectives')));
            
            $lookupDataset = new TableDataset(
                new MyConnectionFactory(),
                GetConnectionOptions(),
                '`Priority`');
            $field = new IntegerField('id', null, null, true);
            $field->SetIsNotNull(true);
            $lookupDataset->AddField($field, true);
            $field = new StringField('Name');
            $lookupDataset->AddField($field, false);
            $lookupDataset->SetOrderBy('Name', GetOrderTypeAsSQL(otAscending));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateLookupSearchInput('priority', $this->RenderText('Priority'), $lookupDataset, 'Name', 'Name', false, 8));
            
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
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateLookupSearchInput('lead', $this->RenderText('Project Lead'), $lookupDataset, 'staff_id', 'username', false, 8));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('approved_budget', $this->RenderText('Approved Budget')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('budget_spent', $this->RenderText('Budget Spent')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('multi_year', $this->RenderText('Multi Year')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('public_engagement', $this->RenderText('Public Engagement')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('level_of_service', $this->RenderText('Level Of Service')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('approved', $this->RenderText('Approved by CAO')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('progress', $this->RenderText('Progress')));
            
            $lookupDataset = new TableDataset(
                new MyConnectionFactory(),
                GetConnectionOptions(),
                '`department`');
            $field = new IntegerField('DEPT_ID', null, null, true);
            $field->SetIsNotNull(true);
            $lookupDataset->AddField($field, true);
            $field = new StringField('DEPARTMENT');
            $field->SetIsNotNull(true);
            $lookupDataset->AddField($field, false);
            $field = new IntegerField('MANAGER');
            $field->SetIsNotNull(true);
            $lookupDataset->AddField($field, false);
            $field = new IntegerField('DIRECTOR');
            $field->SetIsNotNull(true);
            $lookupDataset->AddField($field, false);
            $field = new StringField('LOCATION');
            $field->SetIsNotNull(true);
            $lookupDataset->AddField($field, false);
            $field = new StringField('PHONE_NO');
            $field->SetIsNotNull(true);
            $lookupDataset->AddField($field, false);
            $lookupDataset->SetOrderBy('DEPARTMENT', GetOrderTypeAsSQL(otAscending));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateLookupSearchInput('dept_id', $this->RenderText('Department'), $lookupDataset, 'DEPT_ID', 'DEPARTMENT', false, 8));
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
        }
    
        protected function AddFieldColumns(Grid $grid)
        {
            if (GetCurrentUserGrantForDataSource('project.task')->HasViewGrant())
            {
              //
            // View column for taskDetailView0project detail
            //
            $column = new DetailColumn(array('project_id'), 'detail0project', 'taskDetailEdit0project_handler', 'taskDetailView0project_handler', $this->dataset, 'Tasks within this project', $this->RenderText('Tasks'));
              $grid->AddViewColumn($column);
            }
            
            if (GetCurrentUserGrantForDataSource('project.project')->HasViewGrant())
            {
              //
            // View column for projectDetailView1project detail
            //
            $column = new DetailColumn(array('project_id'), 'detail1project', 'projectDetailEdit1project_handler', 'projectDetailView1project_handler', $this->dataset, 'Project Budget Chart', $this->RenderText('Project Budget'));
              $grid->AddViewColumn($column);
            }
            
            if (GetCurrentUserGrantForDataSource('project.project_timeline_detail')->HasViewGrant())
            {
              //
            // View column for project_timeline_detailDetailView2project detail
            //
            $column = new DetailColumn(array('project_id'), 'detail2project', 'project_timeline_detailDetailEdit2project_handler', 'project_timeline_detailDetailView2project_handler', $this->dataset, 'Tasks Gantt view', $this->RenderText('Tasks Gantt view'));
              $grid->AddViewColumn($column);
            }
            
            //
            // View column for program_name field
            //
            $column = new TextViewColumn('programm_id_program_name', 'Project Type', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for project_name field
            //
            $column = new TextViewColumn('project_name', 'Project Name', $this->dataset);
            $column->SetOrderable(true);
            $column->SetEscapeHTMLSpecialChars(true);
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
            
            //
            // View column for year field
            //
            $column = new TextViewColumn('year', 'Year', $this->dataset);
            $column->SetOrderable(true);
            $column->SetEscapeHTMLSpecialChars(true);
            $column->SetWordWrap(false);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for notes field
            //
            $column = new TextViewColumn('notes', 'Objectives', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('projectGrid_notes_handler_list');
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for Name field
            //
            $column = new TextViewColumn('priority_Name', 'Priority', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for username field
            //
            $column = new TextViewColumn('lead_username', 'Project Lead', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for approved_budget field
            //
            $column = new TextViewColumn('approved_budget', 'Approved Budget', $this->dataset);
            $grid->SetTotal($column, PredefinedAggregate::$Sum);
            $column->SetOrderable(true);
            $column = new CurrencyFormatValueViewColumnDecorator($column, 2, ',', '.', $this->RenderText('$'));
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for budget_spent field
            //
            $column = new TextViewColumn('budget_spent', 'Budget Spent', $this->dataset);
            $grid->SetTotal($column, PredefinedAggregate::$Sum);
            $column->SetOrderable(true);
            $column = new CurrencyFormatValueViewColumnDecorator($column, 2, ',', '.', $this->RenderText('$'));
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for multi_year field
            //
            $column = new TextViewColumn('multi_year', 'Multi Year', $this->dataset);
            $column->SetOrderable(true);
            $column = new CheckBoxFormatValueViewColumnDecorator($column);
            $column->SetDisplayValues($this->RenderText('<img src="images/checked.png" alt="true">'), $this->RenderText(''));
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for public_engagement field
            //
            $column = new TextViewColumn('public_engagement', 'Public Engagement', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('projectGrid_public_engagement_handler_list');
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for level_of_service field
            //
            $column = new TextViewColumn('level_of_service', 'Level Of Service', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for approved field
            //
            $column = new TextViewColumn('approved', 'Approved by CAO', $this->dataset);
            $column->SetOrderable(true);
            $column = new CheckBoxFormatValueViewColumnDecorator($column);
            $column->SetDisplayValues($this->RenderText('<img src="images/checked.png" alt="true">'), $this->RenderText(''));
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for progress field
            //
            $column = new TextViewColumn('progress', 'Progress', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for DEPARTMENT field
            //
            $column = new TextViewColumn('dept_id_DEPARTMENT', 'Department', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
        }
    
        protected function AddSingleRecordViewColumns(Grid $grid)
        {
            //
            // View column for program_name field
            //
            $column = new TextViewColumn('programm_id_program_name', 'Project Type', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for project_name field
            //
            $column = new TextViewColumn('project_name', 'Project Name', $this->dataset);
            $column->SetOrderable(true);
            $column->SetEscapeHTMLSpecialChars(true);
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
            
            //
            // View column for year field
            //
            $column = new TextViewColumn('year', 'Year', $this->dataset);
            $column->SetOrderable(true);
            $column->SetEscapeHTMLSpecialChars(true);
            $column->SetWordWrap(false);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for notes field
            //
            $column = new TextViewColumn('notes', 'Objectives', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('projectGrid_notes_handler_view');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Name field
            //
            $column = new TextViewColumn('priority_Name', 'Priority', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for username field
            //
            $column = new TextViewColumn('lead_username', 'Project Lead', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for approved_budget field
            //
            $column = new TextViewColumn('approved_budget', 'Approved Budget', $this->dataset);
            $column->SetOrderable(true);
            $column = new CurrencyFormatValueViewColumnDecorator($column, 2, ',', '.', $this->RenderText('$'));
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for budget_spent field
            //
            $column = new TextViewColumn('budget_spent', 'Budget Spent', $this->dataset);
            $column->SetOrderable(true);
            $column = new CurrencyFormatValueViewColumnDecorator($column, 2, ',', '.', $this->RenderText('$'));
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for multi_year field
            //
            $column = new TextViewColumn('multi_year', 'Multi Year', $this->dataset);
            $column->SetOrderable(true);
            $column = new CheckBoxFormatValueViewColumnDecorator($column);
            $column->SetDisplayValues($this->RenderText('<img src="images/checked.png" alt="true">'), $this->RenderText(''));
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for public_engagement field
            //
            $column = new TextViewColumn('public_engagement', 'Public Engagement', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('projectGrid_public_engagement_handler_view');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for level_of_service field
            //
            $column = new TextViewColumn('level_of_service', 'Level Of Service', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for approved field
            //
            $column = new TextViewColumn('approved', 'Approved by CAO', $this->dataset);
            $column->SetOrderable(true);
            $column = new CheckBoxFormatValueViewColumnDecorator($column);
            $column->SetDisplayValues($this->RenderText('<img src="images/checked.png" alt="true">'), $this->RenderText(''));
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for progress field
            //
            $column = new TextViewColumn('progress', 'Progress', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for DEPARTMENT field
            //
            $column = new TextViewColumn('dept_id_DEPARTMENT', 'Department', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
        }
    
        protected function AddEditColumns(Grid $grid)
        {
            //
            // Edit column for programm_id field
            //
            $editor = new ComboBox('programm_id_edit', $this->GetLocalizerCaptions()->GetMessageString('PleaseSelect'));
            $lookupDataset = new TableDataset(
                new MyConnectionFactory(),
                GetConnectionOptions(),
                '`program`');
            $field = new IntegerField('program_id', null, null, true);
            $field->SetIsNotNull(true);
            $lookupDataset->AddField($field, true);
            $field = new StringField('program_name');
            $lookupDataset->AddField($field, false);
            $field = new StringField('year');
            $lookupDataset->AddField($field, false);
            $field = new StringField('multi');
            $field->SetIsNotNull(true);
            $lookupDataset->AddField($field, false);
            $field = new StringField('description');
            $field->SetIsNotNull(true);
            $lookupDataset->AddField($field, false);
            $field = new StringField('lead');
            $lookupDataset->AddField($field, false);
            $field = new DateField('date_start');
            $lookupDataset->AddField($field, false);
            $field = new DateField('date_end');
            $lookupDataset->AddField($field, false);
            $field = new IntegerField('progress');
            $field->SetIsNotNull(true);
            $lookupDataset->AddField($field, false);
            $field = new StringField('notes');
            $lookupDataset->AddField($field, false);
            $lookupDataset->SetOrderBy('program_name', GetOrderTypeAsSQL(otAscending));
            $editColumn = new LookUpEditColumn(
                'Project Type', 
                'programm_id', 
                $editor, 
                $this->dataset, 'program_id', 'program_name', $lookupDataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for project_name field
            //
            $editor = new TextEdit('project_name_edit');
            $editColumn = new CustomEditColumn('Project Name', 'project_name', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $validator = new CustomRegExpValidator('^[A-Za-z0-9 ]+[-]*[A-Za-z0-9 ]*$', StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RegExpValidationMessage'), $this->RenderText($editColumn->GetCaption())));
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
            
            //
            // Edit column for year field
            //
            $editor = new TextEdit('year_edit');
            $editColumn = new CustomEditColumn('Year', 'year', $editor, $this->dataset);
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
            $editColumn = new CustomEditColumn('Objectives', 'notes', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for priority field
            //
            $editor = new ComboBox('priority_edit', $this->GetLocalizerCaptions()->GetMessageString('PleaseSelect'));
            $lookupDataset = new TableDataset(
                new MyConnectionFactory(),
                GetConnectionOptions(),
                '`Priority`');
            $field = new IntegerField('id', null, null, true);
            $field->SetIsNotNull(true);
            $lookupDataset->AddField($field, true);
            $field = new StringField('Name');
            $lookupDataset->AddField($field, false);
            $lookupDataset->SetOrderBy('Name', GetOrderTypeAsSQL(otAscending));
            $editColumn = new LookUpEditColumn(
                'Priority', 
                'priority', 
                $editor, 
                $this->dataset, 'Name', 'Name', $lookupDataset);
            $editColumn->SetCaptionTemplate($this->RenderText('%Name%'));
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for lead field
            //
            $editor = new ComboBox('lead_edit', $this->GetLocalizerCaptions()->GetMessageString('PleaseSelect'));
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
                'Project Lead', 
                'lead', 
                $editor, 
                $this->dataset, 'staff_id', 'username', $lookupDataset);
            $editColumn->SetCaptionTemplate($this->RenderText('%username%'));
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for approved_budget field
            //
            $editor = new TextEdit('approved_budget_edit');
            $editor->SetPlaceholder($this->RenderText('currency value without comma'));
            $editor->SetPrefix($this->RenderText('$'));
            $editor->SetSuffix($this->RenderText('.00'));
            $editColumn = new CustomEditColumn('Approved Budget', 'approved_budget', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $validator = new CustomRegExpValidator('^[0-9]*$', StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RegExpValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for budget_spent field
            //
            $editor = new TextEdit('budget_spent_edit');
            $editor->SetPlaceholder($this->RenderText('currency value without comma'));
            $editor->SetPrefix($this->RenderText('$'));
            $editor->SetSuffix($this->RenderText('.00'));
            $editColumn = new CustomEditColumn('Budget Spent', 'budget_spent', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $validator = new CustomRegExpValidator('^[0-9]*$', StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RegExpValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for multi_year field
            //
            $editor = new CheckBox('multi_year_edit');
            $editColumn = new CustomEditColumn('Multi Year', 'multi_year', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for public_engagement field
            //
            $editor = new ComboBox('public_engagement_edit', $this->GetLocalizerCaptions()->GetMessageString('PleaseSelect'));
            $editor->AddValue('0 - No Public Engagement (CAO Authorization Only)', $this->RenderText('0 - No Public Engagement  (CAO Authorization Only)'));
            $editor->AddValue('1 - Inform', $this->RenderText('1 - Inform'));
            $editor->AddValue('2 - Consult', $this->RenderText('2 - Consult'));
            $editor->AddValue('3 - Involve ', $this->RenderText('3 - Involve'));
            $editor->AddValue('4 - Collaborate', $this->RenderText('4 - Collaborate'));
            $editor->AddValue('5- Empower', $this->RenderText('5 - Empower'));
            $editColumn = new CustomEditColumn('Public Engagement', 'public_engagement', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for level_of_service field
            //
            $editor = new ComboBox('level_of_service_edit', $this->GetLocalizerCaptions()->GetMessageString('PleaseSelect'));
            $editor->AddValue('Maintain existing Level Of Service', $this->RenderText('Maintain existing Level Of Service'));
            $editor->AddValue('Upgrade Level Of Service', $this->RenderText('Upgrade Level Of Service'));
            $editor->AddValue('Downgrade Level Of Service', $this->RenderText('Downgrade Level Of Service'));
            $editor->AddValue('New Level Of Service/Asset(s)', $this->RenderText('New Level Of Service/Asset(s)'));
            $editor->AddValue('Eliminate Level Of Service/Asset(s)', $this->RenderText('Eliminate Level Of Service/Asset(s)'));
            $editor->AddValue('One-Time only Project', $this->RenderText('One-Time only Project'));
            $editColumn = new CustomEditColumn('Level Of Service', 'level_of_service', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for approved field
            //
            $editor = new CheckBox('approved_edit');
            $editColumn = new CustomEditColumn('Approved by CAO', 'approved', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for progress field
            //
            $editor = new ComboBox('progress_edit', $this->GetLocalizerCaptions()->GetMessageString('PleaseSelect'));
            $editor->AddValue('0', $this->RenderText('Zero Percent'));
            $editor->AddValue('0.10', $this->RenderText('10 Percent'));
            $editor->AddValue('0.20', $this->RenderText('20 Percent'));
            $editor->AddValue('0.30', $this->RenderText('30 Percent'));
            $editor->AddValue('0.40', $this->RenderText('40 Percent'));
            $editor->AddValue('0.5', $this->RenderText('50 Percent'));
            $editor->AddValue('0.6', $this->RenderText('60 Percent'));
            $editor->AddValue('0.7', $this->RenderText('70 Percent'));
            $editor->AddValue('0.8', $this->RenderText('80 Percent'));
            $editor->AddValue('0.9', $this->RenderText('90 Percent'));
            $editor->AddValue('1', $this->RenderText('100 Percent'));
            $editColumn = new CustomEditColumn('Progress', 'progress', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for dept_id field
            //
            $editor = new ComboBox('dept_id_edit', $this->GetLocalizerCaptions()->GetMessageString('PleaseSelect'));
            $lookupDataset = new TableDataset(
                new MyConnectionFactory(),
                GetConnectionOptions(),
                '`department`');
            $field = new IntegerField('DEPT_ID', null, null, true);
            $field->SetIsNotNull(true);
            $lookupDataset->AddField($field, true);
            $field = new StringField('DEPARTMENT');
            $field->SetIsNotNull(true);
            $lookupDataset->AddField($field, false);
            $field = new IntegerField('MANAGER');
            $field->SetIsNotNull(true);
            $lookupDataset->AddField($field, false);
            $field = new IntegerField('DIRECTOR');
            $field->SetIsNotNull(true);
            $lookupDataset->AddField($field, false);
            $field = new StringField('LOCATION');
            $field->SetIsNotNull(true);
            $lookupDataset->AddField($field, false);
            $field = new StringField('PHONE_NO');
            $field->SetIsNotNull(true);
            $lookupDataset->AddField($field, false);
            $lookupDataset->SetOrderBy('DEPARTMENT', GetOrderTypeAsSQL(otAscending));
            $editColumn = new LookUpEditColumn(
                'Department', 
                'dept_id', 
                $editor, 
                $this->dataset, 'DEPT_ID', 'DEPARTMENT', $lookupDataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
        }
    
        protected function AddInsertColumns(Grid $grid)
        {
            //
            // Edit column for programm_id field
            //
            $editor = new ComboBox('programm_id_edit', $this->GetLocalizerCaptions()->GetMessageString('PleaseSelect'));
            $lookupDataset = new TableDataset(
                new MyConnectionFactory(),
                GetConnectionOptions(),
                '`program`');
            $field = new IntegerField('program_id', null, null, true);
            $field->SetIsNotNull(true);
            $lookupDataset->AddField($field, true);
            $field = new StringField('program_name');
            $lookupDataset->AddField($field, false);
            $field = new StringField('year');
            $lookupDataset->AddField($field, false);
            $field = new StringField('multi');
            $field->SetIsNotNull(true);
            $lookupDataset->AddField($field, false);
            $field = new StringField('description');
            $field->SetIsNotNull(true);
            $lookupDataset->AddField($field, false);
            $field = new StringField('lead');
            $lookupDataset->AddField($field, false);
            $field = new DateField('date_start');
            $lookupDataset->AddField($field, false);
            $field = new DateField('date_end');
            $lookupDataset->AddField($field, false);
            $field = new IntegerField('progress');
            $field->SetIsNotNull(true);
            $lookupDataset->AddField($field, false);
            $field = new StringField('notes');
            $lookupDataset->AddField($field, false);
            $lookupDataset->SetOrderBy('program_name', GetOrderTypeAsSQL(otAscending));
            $editColumn = new LookUpEditColumn(
                'Project Type', 
                'programm_id', 
                $editor, 
                $this->dataset, 'program_id', 'program_name', $lookupDataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for project_name field
            //
            $editor = new TextEdit('project_name_edit');
            $editColumn = new CustomEditColumn('Project Name', 'project_name', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $validator = new CustomRegExpValidator('^[A-Za-z0-9 ]+[-]*[A-Za-z0-9 ]*$', StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RegExpValidationMessage'), $this->RenderText($editColumn->GetCaption())));
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
            
            //
            // Edit column for year field
            //
            $editor = new TextEdit('year_edit');
            $editColumn = new CustomEditColumn('Year', 'year', $editor, $this->dataset);
            $editColumn->SetInsertDefaultValue($this->RenderText('2015'));
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
            $editColumn = new CustomEditColumn('Objectives', 'notes', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for priority field
            //
            $editor = new ComboBox('priority_edit', $this->GetLocalizerCaptions()->GetMessageString('PleaseSelect'));
            $lookupDataset = new TableDataset(
                new MyConnectionFactory(),
                GetConnectionOptions(),
                '`Priority`');
            $field = new IntegerField('id', null, null, true);
            $field->SetIsNotNull(true);
            $lookupDataset->AddField($field, true);
            $field = new StringField('Name');
            $lookupDataset->AddField($field, false);
            $lookupDataset->SetOrderBy('Name', GetOrderTypeAsSQL(otAscending));
            $editColumn = new LookUpEditColumn(
                'Priority', 
                'priority', 
                $editor, 
                $this->dataset, 'Name', 'Name', $lookupDataset);
            $editColumn->SetCaptionTemplate($this->RenderText('%Name%'));
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for lead field
            //
            $editor = new ComboBox('lead_edit', $this->GetLocalizerCaptions()->GetMessageString('PleaseSelect'));
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
                'Project Lead', 
                'lead', 
                $editor, 
                $this->dataset, 'staff_id', 'username', $lookupDataset);
            $editColumn->SetCaptionTemplate($this->RenderText('%username%'));
            $editColumn->SetInsertDefaultValue($this->RenderText('%CURRENT_USER_ID%'));
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for approved_budget field
            //
            $editor = new TextEdit('approved_budget_edit');
            $editor->SetPlaceholder($this->RenderText('currency value without comma'));
            $editor->SetPrefix($this->RenderText('$'));
            $editor->SetSuffix($this->RenderText('.00'));
            $editColumn = new CustomEditColumn('Approved Budget', 'approved_budget', $editor, $this->dataset);
            $editColumn->SetInsertDefaultValue($this->RenderText('0'));
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $validator = new CustomRegExpValidator('^[0-9]*$', StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RegExpValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for budget_spent field
            //
            $editor = new TextEdit('budget_spent_edit');
            $editor->SetPlaceholder($this->RenderText('currency value without comma'));
            $editor->SetPrefix($this->RenderText('$'));
            $editor->SetSuffix($this->RenderText('.00'));
            $editColumn = new CustomEditColumn('Budget Spent', 'budget_spent', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetInsertDefaultValue($this->RenderText('0'));
            $validator = new CustomRegExpValidator('^[0-9]*$', StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RegExpValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for multi_year field
            //
            $editor = new CheckBox('multi_year_edit');
            $editColumn = new CustomEditColumn('Multi Year', 'multi_year', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for public_engagement field
            //
            $editor = new ComboBox('public_engagement_edit', $this->GetLocalizerCaptions()->GetMessageString('PleaseSelect'));
            $editor->AddValue('0 - No Public Engagement (CAO Authorization Only)', $this->RenderText('0 - No Public Engagement  (CAO Authorization Only)'));
            $editor->AddValue('1 - Inform', $this->RenderText('1 - Inform'));
            $editor->AddValue('2 - Consult', $this->RenderText('2 - Consult'));
            $editor->AddValue('3 - Involve ', $this->RenderText('3 - Involve'));
            $editor->AddValue('4 - Collaborate', $this->RenderText('4 - Collaborate'));
            $editor->AddValue('5- Empower', $this->RenderText('5 - Empower'));
            $editColumn = new CustomEditColumn('Public Engagement', 'public_engagement', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for level_of_service field
            //
            $editor = new ComboBox('level_of_service_edit', $this->GetLocalizerCaptions()->GetMessageString('PleaseSelect'));
            $editor->AddValue('Maintain existing Level Of Service', $this->RenderText('Maintain existing Level Of Service'));
            $editor->AddValue('Upgrade Level Of Service', $this->RenderText('Upgrade Level Of Service'));
            $editor->AddValue('Downgrade Level Of Service', $this->RenderText('Downgrade Level Of Service'));
            $editor->AddValue('New Level Of Service/Asset(s)', $this->RenderText('New Level Of Service/Asset(s)'));
            $editor->AddValue('Eliminate Level Of Service/Asset(s)', $this->RenderText('Eliminate Level Of Service/Asset(s)'));
            $editor->AddValue('One-Time only Project', $this->RenderText('One-Time only Project'));
            $editColumn = new CustomEditColumn('Level Of Service', 'level_of_service', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for approved field
            //
            $editor = new CheckBox('approved_edit');
            $editColumn = new CustomEditColumn('Approved by CAO', 'approved', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for progress field
            //
            $editor = new ComboBox('progress_edit', $this->GetLocalizerCaptions()->GetMessageString('PleaseSelect'));
            $editor->AddValue('0', $this->RenderText('Zero Percent'));
            $editor->AddValue('0.10', $this->RenderText('10 Percent'));
            $editor->AddValue('0.20', $this->RenderText('20 Percent'));
            $editor->AddValue('0.30', $this->RenderText('30 Percent'));
            $editor->AddValue('0.40', $this->RenderText('40 Percent'));
            $editor->AddValue('0.5', $this->RenderText('50 Percent'));
            $editor->AddValue('0.6', $this->RenderText('60 Percent'));
            $editor->AddValue('0.7', $this->RenderText('70 Percent'));
            $editor->AddValue('0.8', $this->RenderText('80 Percent'));
            $editor->AddValue('0.9', $this->RenderText('90 Percent'));
            $editor->AddValue('1', $this->RenderText('100 Percent'));
            $editColumn = new CustomEditColumn('Progress', 'progress', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetInsertDefaultValue($this->RenderText('0'));
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for dept_id field
            //
            $editor = new ComboBox('dept_id_edit', $this->GetLocalizerCaptions()->GetMessageString('PleaseSelect'));
            $lookupDataset = new TableDataset(
                new MyConnectionFactory(),
                GetConnectionOptions(),
                '`department`');
            $field = new IntegerField('DEPT_ID', null, null, true);
            $field->SetIsNotNull(true);
            $lookupDataset->AddField($field, true);
            $field = new StringField('DEPARTMENT');
            $field->SetIsNotNull(true);
            $lookupDataset->AddField($field, false);
            $field = new IntegerField('MANAGER');
            $field->SetIsNotNull(true);
            $lookupDataset->AddField($field, false);
            $field = new IntegerField('DIRECTOR');
            $field->SetIsNotNull(true);
            $lookupDataset->AddField($field, false);
            $field = new StringField('LOCATION');
            $field->SetIsNotNull(true);
            $lookupDataset->AddField($field, false);
            $field = new StringField('PHONE_NO');
            $field->SetIsNotNull(true);
            $lookupDataset->AddField($field, false);
            $lookupDataset->SetOrderBy('DEPARTMENT', GetOrderTypeAsSQL(otAscending));
            $editColumn = new LookUpEditColumn(
                'Department', 
                'dept_id', 
                $editor, 
                $this->dataset, 'DEPT_ID', 'DEPARTMENT', $lookupDataset);
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
            // View column for program_name field
            //
            $column = new TextViewColumn('programm_id_program_name', 'Project Type', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for project_name field
            //
            $column = new TextViewColumn('project_name', 'Project Name', $this->dataset);
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
            
            //
            // View column for year field
            //
            $column = new TextViewColumn('year', 'Year', $this->dataset);
            $column->SetOrderable(true);
            $column->SetEscapeHTMLSpecialChars(true);
            $column->SetWordWrap(false);
            $grid->AddPrintColumn($column);
            
            //
            // View column for notes field
            //
            $column = new TextViewColumn('notes', 'Notes', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for Name field
            //
            $column = new TextViewColumn('priority_Name', 'Priority', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for username field
            //
            $column = new TextViewColumn('lead_username', 'Project Lead', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for approved_budget field
            //
            $column = new TextViewColumn('approved_budget', 'Approved Budget', $this->dataset);
            $column->SetOrderable(true);
            $column = new CurrencyFormatValueViewColumnDecorator($column, 2, ',', '.', $this->RenderText('$'));
            $grid->AddPrintColumn($column);
            
            //
            // View column for budget_spent field
            //
            $column = new TextViewColumn('budget_spent', 'Budget Spent', $this->dataset);
            $column->SetOrderable(true);
            $column = new CurrencyFormatValueViewColumnDecorator($column, 2, ',', '.', $this->RenderText('$'));
            $grid->AddPrintColumn($column);
            
            //
            // View column for multi_year field
            //
            $column = new TextViewColumn('multi_year', 'Multi Year', $this->dataset);
            $column->SetOrderable(true);
            $column = new CheckBoxFormatValueViewColumnDecorator($column);
            $column->SetDisplayValues($this->RenderText('<img src="images/checked.png" alt="true">'), $this->RenderText(''));
            $grid->AddPrintColumn($column);
            
            //
            // View column for public_engagement field
            //
            $column = new TextViewColumn('public_engagement', 'Public Engagement', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for level_of_service field
            //
            $column = new TextViewColumn('level_of_service', 'Level Of Service', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for approved field
            //
            $column = new TextViewColumn('approved', 'Approved by CAO', $this->dataset);
            $column->SetOrderable(true);
            $column = new CheckBoxFormatValueViewColumnDecorator($column);
            $column->SetDisplayValues($this->RenderText('<img src="images/checked.png" alt="true">'), $this->RenderText(''));
            $grid->AddPrintColumn($column);
            
            //
            // View column for progress field
            //
            $column = new TextViewColumn('progress', 'Progress', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for DEPARTMENT field
            //
            $column = new TextViewColumn('dept_id_DEPARTMENT', 'Department', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
        }
    
        protected function AddExportColumns(Grid $grid)
        {
            //
            // View column for program_name field
            //
            $column = new TextViewColumn('programm_id_program_name', 'Project Type', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for project_name field
            //
            $column = new TextViewColumn('project_name', 'Project Name', $this->dataset);
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
            
            //
            // View column for year field
            //
            $column = new TextViewColumn('year', 'Year', $this->dataset);
            $column->SetOrderable(true);
            $column->SetEscapeHTMLSpecialChars(true);
            $column->SetWordWrap(false);
            $grid->AddExportColumn($column);
            
            //
            // View column for notes field
            //
            $column = new TextViewColumn('notes', 'Notes', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for Name field
            //
            $column = new TextViewColumn('priority_Name', 'Priority', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for username field
            //
            $column = new TextViewColumn('lead_username', 'Project Lead', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for approved_budget field
            //
            $column = new TextViewColumn('approved_budget', 'Approved Budget', $this->dataset);
            $column->SetOrderable(true);
            $column = new CurrencyFormatValueViewColumnDecorator($column, 2, ',', '.', $this->RenderText('$'));
            $grid->AddExportColumn($column);
            
            //
            // View column for budget_spent field
            //
            $column = new TextViewColumn('budget_spent', 'Budget Spent', $this->dataset);
            $column->SetOrderable(true);
            $column = new CurrencyFormatValueViewColumnDecorator($column, 2, ',', '.', $this->RenderText('$'));
            $grid->AddExportColumn($column);
            
            //
            // View column for multi_year field
            //
            $column = new TextViewColumn('multi_year', 'Multi Year', $this->dataset);
            $column->SetOrderable(true);
            $column = new CheckBoxFormatValueViewColumnDecorator($column);
            $column->SetDisplayValues($this->RenderText('<img src="images/checked.png" alt="true">'), $this->RenderText(''));
            $grid->AddExportColumn($column);
            
            //
            // View column for public_engagement field
            //
            $column = new TextViewColumn('public_engagement', 'Public Engagement', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for level_of_service field
            //
            $column = new TextViewColumn('level_of_service', 'Level Of Service', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for approved field
            //
            $column = new TextViewColumn('approved', 'Approved by CAO', $this->dataset);
            $column->SetOrderable(true);
            $column = new CheckBoxFormatValueViewColumnDecorator($column);
            $column->SetDisplayValues($this->RenderText('<img src="images/checked.png" alt="true">'), $this->RenderText(''));
            $grid->AddExportColumn($column);
            
            //
            // View column for progress field
            //
            $column = new TextViewColumn('progress', 'Progress', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for DEPARTMENT field
            //
            $column = new TextViewColumn('dept_id_DEPARTMENT', 'Department', $this->dataset);
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
    
        function CreateMasterDetailRecordGridFortaskDetailEdit0projectGrid()
        {
            $result = new Grid($this, $this->dataset, 'MasterDetailRecordGridFortaskDetailEdit0project');
            $result->SetAllowDeleteSelected(false);
            $result->OnCustomDrawCell->AddListener('MasterDetailRecordGridFortaskDetailEdit0project' . '_OnCustomDrawRow', $this);
            $result->OnCustomRenderColumn->AddListener('MasterDetailRecordGridFortaskDetailEdit0project' . '_' . 'OnCustomRenderColumn', $this);
            $result->SetShowFilterBuilder(false);
            $result->SetAdvancedSearchAvailable(false);
            $result->SetFilterRowAvailable(false);
            $result->SetShowUpdateLink(false);
            $result->SetEnabledInlineEditing(false);
            $result->SetShowKeyColumnsImagesInHeader(false);
            $result->SetName('master_grid');
            //
            // View column for program_name field
            //
            $column = new TextViewColumn('programm_id_program_name', 'Project Type', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $result->AddViewColumn($column);
            
            //
            // View column for project_name field
            //
            $column = new TextViewColumn('project_name', 'Project Name', $this->dataset);
            $column->SetOrderable(true);
            $column->SetEscapeHTMLSpecialChars(true);
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
            // View column for year field
            //
            $column = new TextViewColumn('year', 'Year', $this->dataset);
            $column->SetOrderable(true);
            $column->SetEscapeHTMLSpecialChars(true);
            $column->SetWordWrap(false);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $result->AddViewColumn($column);
            
            //
            // View column for notes field
            //
            $column = new TextViewColumn('notes', 'Objectives', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('projectGrid_notes_handler_list');
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $result->AddViewColumn($column);
            
            //
            // View column for Name field
            //
            $column = new TextViewColumn('priority_Name', 'Priority', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $result->AddViewColumn($column);
            
            //
            // View column for username field
            //
            $column = new TextViewColumn('lead_username', 'Project Lead', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $result->AddViewColumn($column);
            
            //
            // View column for approved_budget field
            //
            $column = new TextViewColumn('approved_budget', 'Approved Budget', $this->dataset);
            $column->SetOrderable(true);
            $column = new CurrencyFormatValueViewColumnDecorator($column, 2, ',', '.', $this->RenderText('$'));
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $result->AddViewColumn($column);
            
            //
            // View column for budget_spent field
            //
            $column = new TextViewColumn('budget_spent', 'Budget Spent', $this->dataset);
            $column->SetOrderable(true);
            $column = new CurrencyFormatValueViewColumnDecorator($column, 2, ',', '.', $this->RenderText('$'));
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $result->AddViewColumn($column);
            
            //
            // View column for multi_year field
            //
            $column = new TextViewColumn('multi_year', 'Multi Year', $this->dataset);
            $column->SetOrderable(true);
            $column = new CheckBoxFormatValueViewColumnDecorator($column);
            $column->SetDisplayValues($this->RenderText('<img src="images/checked.png" alt="true">'), $this->RenderText(''));
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $result->AddViewColumn($column);
            
            //
            // View column for public_engagement field
            //
            $column = new TextViewColumn('public_engagement', 'Public Engagement', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('projectGrid_public_engagement_handler_list');
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $result->AddViewColumn($column);
            
            //
            // View column for level_of_service field
            //
            $column = new TextViewColumn('level_of_service', 'Level Of Service', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $result->AddViewColumn($column);
            
            //
            // View column for approved field
            //
            $column = new TextViewColumn('approved', 'Approved by CAO', $this->dataset);
            $column->SetOrderable(true);
            $column = new CheckBoxFormatValueViewColumnDecorator($column);
            $column->SetDisplayValues($this->RenderText('<img src="images/checked.png" alt="true">'), $this->RenderText(''));
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $result->AddViewColumn($column);
            
            //
            // View column for progress field
            //
            $column = new TextViewColumn('progress', 'Progress', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $result->AddViewColumn($column);
            
            //
            // View column for DEPARTMENT field
            //
            $column = new TextViewColumn('dept_id_DEPARTMENT', 'Department', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $result->AddViewColumn($column);
            
            //
            // View column for program_name field
            //
            $column = new TextViewColumn('programm_id_program_name', 'Project Type', $this->dataset);
            $column->SetOrderable(true);
            $result->AddPrintColumn($column);
            
            //
            // View column for project_name field
            //
            $column = new TextViewColumn('project_name', 'Project Name', $this->dataset);
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
            
            //
            // View column for year field
            //
            $column = new TextViewColumn('year', 'Year', $this->dataset);
            $column->SetOrderable(true);
            $column->SetEscapeHTMLSpecialChars(true);
            $column->SetWordWrap(false);
            $result->AddPrintColumn($column);
            
            //
            // View column for notes field
            //
            $column = new TextViewColumn('notes', 'Notes', $this->dataset);
            $column->SetOrderable(true);
            $result->AddPrintColumn($column);
            
            //
            // View column for Name field
            //
            $column = new TextViewColumn('priority_Name', 'Priority', $this->dataset);
            $column->SetOrderable(true);
            $result->AddPrintColumn($column);
            
            //
            // View column for username field
            //
            $column = new TextViewColumn('lead_username', 'Project Lead', $this->dataset);
            $column->SetOrderable(true);
            $result->AddPrintColumn($column);
            
            //
            // View column for approved_budget field
            //
            $column = new TextViewColumn('approved_budget', 'Approved Budget', $this->dataset);
            $column->SetOrderable(true);
            $column = new CurrencyFormatValueViewColumnDecorator($column, 2, ',', '.', $this->RenderText('$'));
            $result->AddPrintColumn($column);
            
            //
            // View column for budget_spent field
            //
            $column = new TextViewColumn('budget_spent', 'Budget Spent', $this->dataset);
            $column->SetOrderable(true);
            $column = new CurrencyFormatValueViewColumnDecorator($column, 2, ',', '.', $this->RenderText('$'));
            $result->AddPrintColumn($column);
            
            //
            // View column for multi_year field
            //
            $column = new TextViewColumn('multi_year', 'Multi Year', $this->dataset);
            $column->SetOrderable(true);
            $column = new CheckBoxFormatValueViewColumnDecorator($column);
            $column->SetDisplayValues($this->RenderText('<img src="images/checked.png" alt="true">'), $this->RenderText(''));
            $result->AddPrintColumn($column);
            
            //
            // View column for public_engagement field
            //
            $column = new TextViewColumn('public_engagement', 'Public Engagement', $this->dataset);
            $column->SetOrderable(true);
            $result->AddPrintColumn($column);
            
            //
            // View column for level_of_service field
            //
            $column = new TextViewColumn('level_of_service', 'Level Of Service', $this->dataset);
            $column->SetOrderable(true);
            $result->AddPrintColumn($column);
            
            //
            // View column for approved field
            //
            $column = new TextViewColumn('approved', 'Approved by CAO', $this->dataset);
            $column->SetOrderable(true);
            $column = new CheckBoxFormatValueViewColumnDecorator($column);
            $column->SetDisplayValues($this->RenderText('<img src="images/checked.png" alt="true">'), $this->RenderText(''));
            $result->AddPrintColumn($column);
            
            //
            // View column for progress field
            //
            $column = new TextViewColumn('progress', 'Progress', $this->dataset);
            $column->SetOrderable(true);
            $result->AddPrintColumn($column);
            
            //
            // View column for DEPARTMENT field
            //
            $column = new TextViewColumn('dept_id_DEPARTMENT', 'Department', $this->dataset);
            $column->SetOrderable(true);
            $result->AddPrintColumn($column);
            
            return $result;
        }
        
        public function MasterDetailRecordGridFortaskDetailEdit0project_OnCustomDrawRow($rowData, &$rowCellStyles, &$rowStyles)
        {
        $today = date("Y-m-d");
        if ($today > $rowData['date_end'] AND $rowData['progress'] < 1)
        $rowCellStyles['date_end'] .= 'font-size: 10pt;font-weight: bold; color: #FF0000;background-color:#F3F781;';
        elseif ($rowData['progress'] >= 1)
        $rowCellStyles['progress'] .= 'font-size: 10pt;font-weight: bold; background-color: #58FA58;';
        
        if ($rowData['budget_spent'] > $rowData['approved_budget'])
        $rowCellStyles['budget_spent'] .= 'font-size: 10pt;font-weight: bold; color:#FFFFFF; background-color: #FF0000;';
        }
        function MasterDetailRecordGridFortaskDetailEdit0project_OnCustomRenderColumn($fieldName, $fieldData, $rowData, &$customText, &$handled)
        {
            if ($fieldName == 'progress') 
            
              {
            
                if ($fieldData >= 1)
            
                  $customText = 'Project <br /> Complete';
            else $customText = ($fieldData * 100 . '%');
                
                $handled = true;   
            
              }
        }
        function CreateMasterDetailRecordGridForprojectDetailEdit1projectGrid()
        {
            $result = new Grid($this, $this->dataset, 'MasterDetailRecordGridForprojectDetailEdit1project');
            $result->SetAllowDeleteSelected(false);
            $result->OnCustomDrawCell->AddListener('MasterDetailRecordGridForprojectDetailEdit1project' . '_OnCustomDrawRow', $this);
            $result->OnCustomRenderColumn->AddListener('MasterDetailRecordGridForprojectDetailEdit1project' . '_' . 'OnCustomRenderColumn', $this);
            $result->SetShowFilterBuilder(false);
            $result->SetAdvancedSearchAvailable(false);
            $result->SetFilterRowAvailable(false);
            $result->SetShowUpdateLink(false);
            $result->SetEnabledInlineEditing(false);
            $result->SetShowKeyColumnsImagesInHeader(false);
            $result->SetName('master_grid');
            //
            // View column for program_name field
            //
            $column = new TextViewColumn('programm_id_program_name', 'Project Type', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $result->AddViewColumn($column);
            
            //
            // View column for project_name field
            //
            $column = new TextViewColumn('project_name', 'Project Name', $this->dataset);
            $column->SetOrderable(true);
            $column->SetEscapeHTMLSpecialChars(true);
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
            // View column for year field
            //
            $column = new TextViewColumn('year', 'Year', $this->dataset);
            $column->SetOrderable(true);
            $column->SetEscapeHTMLSpecialChars(true);
            $column->SetWordWrap(false);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $result->AddViewColumn($column);
            
            //
            // View column for notes field
            //
            $column = new TextViewColumn('notes', 'Objectives', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('projectGrid_notes_handler_list');
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $result->AddViewColumn($column);
            
            //
            // View column for Name field
            //
            $column = new TextViewColumn('priority_Name', 'Priority', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $result->AddViewColumn($column);
            
            //
            // View column for username field
            //
            $column = new TextViewColumn('lead_username', 'Project Lead', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $result->AddViewColumn($column);
            
            //
            // View column for approved_budget field
            //
            $column = new TextViewColumn('approved_budget', 'Approved Budget', $this->dataset);
            $column->SetOrderable(true);
            $column = new CurrencyFormatValueViewColumnDecorator($column, 2, ',', '.', $this->RenderText('$'));
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $result->AddViewColumn($column);
            
            //
            // View column for budget_spent field
            //
            $column = new TextViewColumn('budget_spent', 'Budget Spent', $this->dataset);
            $column->SetOrderable(true);
            $column = new CurrencyFormatValueViewColumnDecorator($column, 2, ',', '.', $this->RenderText('$'));
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $result->AddViewColumn($column);
            
            //
            // View column for multi_year field
            //
            $column = new TextViewColumn('multi_year', 'Multi Year', $this->dataset);
            $column->SetOrderable(true);
            $column = new CheckBoxFormatValueViewColumnDecorator($column);
            $column->SetDisplayValues($this->RenderText('<img src="images/checked.png" alt="true">'), $this->RenderText(''));
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $result->AddViewColumn($column);
            
            //
            // View column for public_engagement field
            //
            $column = new TextViewColumn('public_engagement', 'Public Engagement', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('projectGrid_public_engagement_handler_list');
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $result->AddViewColumn($column);
            
            //
            // View column for level_of_service field
            //
            $column = new TextViewColumn('level_of_service', 'Level Of Service', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $result->AddViewColumn($column);
            
            //
            // View column for approved field
            //
            $column = new TextViewColumn('approved', 'Approved by CAO', $this->dataset);
            $column->SetOrderable(true);
            $column = new CheckBoxFormatValueViewColumnDecorator($column);
            $column->SetDisplayValues($this->RenderText('<img src="images/checked.png" alt="true">'), $this->RenderText(''));
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $result->AddViewColumn($column);
            
            //
            // View column for progress field
            //
            $column = new TextViewColumn('progress', 'Progress', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $result->AddViewColumn($column);
            
            //
            // View column for DEPARTMENT field
            //
            $column = new TextViewColumn('dept_id_DEPARTMENT', 'Department', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $result->AddViewColumn($column);
            
            //
            // View column for program_name field
            //
            $column = new TextViewColumn('programm_id_program_name', 'Project Type', $this->dataset);
            $column->SetOrderable(true);
            $result->AddPrintColumn($column);
            
            //
            // View column for project_name field
            //
            $column = new TextViewColumn('project_name', 'Project Name', $this->dataset);
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
            
            //
            // View column for year field
            //
            $column = new TextViewColumn('year', 'Year', $this->dataset);
            $column->SetOrderable(true);
            $column->SetEscapeHTMLSpecialChars(true);
            $column->SetWordWrap(false);
            $result->AddPrintColumn($column);
            
            //
            // View column for notes field
            //
            $column = new TextViewColumn('notes', 'Notes', $this->dataset);
            $column->SetOrderable(true);
            $result->AddPrintColumn($column);
            
            //
            // View column for Name field
            //
            $column = new TextViewColumn('priority_Name', 'Priority', $this->dataset);
            $column->SetOrderable(true);
            $result->AddPrintColumn($column);
            
            //
            // View column for username field
            //
            $column = new TextViewColumn('lead_username', 'Project Lead', $this->dataset);
            $column->SetOrderable(true);
            $result->AddPrintColumn($column);
            
            //
            // View column for approved_budget field
            //
            $column = new TextViewColumn('approved_budget', 'Approved Budget', $this->dataset);
            $column->SetOrderable(true);
            $column = new CurrencyFormatValueViewColumnDecorator($column, 2, ',', '.', $this->RenderText('$'));
            $result->AddPrintColumn($column);
            
            //
            // View column for budget_spent field
            //
            $column = new TextViewColumn('budget_spent', 'Budget Spent', $this->dataset);
            $column->SetOrderable(true);
            $column = new CurrencyFormatValueViewColumnDecorator($column, 2, ',', '.', $this->RenderText('$'));
            $result->AddPrintColumn($column);
            
            //
            // View column for multi_year field
            //
            $column = new TextViewColumn('multi_year', 'Multi Year', $this->dataset);
            $column->SetOrderable(true);
            $column = new CheckBoxFormatValueViewColumnDecorator($column);
            $column->SetDisplayValues($this->RenderText('<img src="images/checked.png" alt="true">'), $this->RenderText(''));
            $result->AddPrintColumn($column);
            
            //
            // View column for public_engagement field
            //
            $column = new TextViewColumn('public_engagement', 'Public Engagement', $this->dataset);
            $column->SetOrderable(true);
            $result->AddPrintColumn($column);
            
            //
            // View column for level_of_service field
            //
            $column = new TextViewColumn('level_of_service', 'Level Of Service', $this->dataset);
            $column->SetOrderable(true);
            $result->AddPrintColumn($column);
            
            //
            // View column for approved field
            //
            $column = new TextViewColumn('approved', 'Approved by CAO', $this->dataset);
            $column->SetOrderable(true);
            $column = new CheckBoxFormatValueViewColumnDecorator($column);
            $column->SetDisplayValues($this->RenderText('<img src="images/checked.png" alt="true">'), $this->RenderText(''));
            $result->AddPrintColumn($column);
            
            //
            // View column for progress field
            //
            $column = new TextViewColumn('progress', 'Progress', $this->dataset);
            $column->SetOrderable(true);
            $result->AddPrintColumn($column);
            
            //
            // View column for DEPARTMENT field
            //
            $column = new TextViewColumn('dept_id_DEPARTMENT', 'Department', $this->dataset);
            $column->SetOrderable(true);
            $result->AddPrintColumn($column);
            
            return $result;
        }
        
        public function MasterDetailRecordGridForprojectDetailEdit1project_OnCustomDrawRow($rowData, &$rowCellStyles, &$rowStyles)
        {
        $today = date("Y-m-d");
        if ($today > $rowData['date_end'] AND $rowData['progress'] < 1)
        $rowCellStyles['date_end'] .= 'font-size: 10pt;font-weight: bold; color: #FF0000;background-color:#F3F781;';
        elseif ($rowData['progress'] >= 1)
        $rowCellStyles['progress'] .= 'font-size: 10pt;font-weight: bold; background-color: #58FA58;';
        
        if ($rowData['budget_spent'] > $rowData['approved_budget'])
        $rowCellStyles['budget_spent'] .= 'font-size: 10pt;font-weight: bold; color:#FFFFFF; background-color: #FF0000;';
        }
        function MasterDetailRecordGridForprojectDetailEdit1project_OnCustomRenderColumn($fieldName, $fieldData, $rowData, &$customText, &$handled)
        {
            if ($fieldName == 'progress') 
            
              {
            
                if ($fieldData >= 1)
            
                  $customText = 'Project <br /> Complete';
            else $customText = ($fieldData * 100 . '%');
                
                $handled = true;   
            
              }
        }
        function CreateMasterDetailRecordGridForproject_timeline_detailDetailEdit2projectGrid()
        {
            $result = new Grid($this, $this->dataset, 'MasterDetailRecordGridForproject_timeline_detailDetailEdit2project');
            $result->SetAllowDeleteSelected(false);
            $result->OnCustomDrawCell->AddListener('MasterDetailRecordGridForproject_timeline_detailDetailEdit2project' . '_OnCustomDrawRow', $this);
            $result->OnCustomRenderColumn->AddListener('MasterDetailRecordGridForproject_timeline_detailDetailEdit2project' . '_' . 'OnCustomRenderColumn', $this);
            $result->SetShowFilterBuilder(false);
            $result->SetAdvancedSearchAvailable(false);
            $result->SetFilterRowAvailable(false);
            $result->SetShowUpdateLink(false);
            $result->SetEnabledInlineEditing(false);
            $result->SetShowKeyColumnsImagesInHeader(false);
            $result->SetName('master_grid');
            //
            // View column for program_name field
            //
            $column = new TextViewColumn('programm_id_program_name', 'Project Type', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $result->AddViewColumn($column);
            
            //
            // View column for project_name field
            //
            $column = new TextViewColumn('project_name', 'Project Name', $this->dataset);
            $column->SetOrderable(true);
            $column->SetEscapeHTMLSpecialChars(true);
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
            // View column for year field
            //
            $column = new TextViewColumn('year', 'Year', $this->dataset);
            $column->SetOrderable(true);
            $column->SetEscapeHTMLSpecialChars(true);
            $column->SetWordWrap(false);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $result->AddViewColumn($column);
            
            //
            // View column for notes field
            //
            $column = new TextViewColumn('notes', 'Objectives', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('projectGrid_notes_handler_list');
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $result->AddViewColumn($column);
            
            //
            // View column for Name field
            //
            $column = new TextViewColumn('priority_Name', 'Priority', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $result->AddViewColumn($column);
            
            //
            // View column for username field
            //
            $column = new TextViewColumn('lead_username', 'Project Lead', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $result->AddViewColumn($column);
            
            //
            // View column for approved_budget field
            //
            $column = new TextViewColumn('approved_budget', 'Approved Budget', $this->dataset);
            $column->SetOrderable(true);
            $column = new CurrencyFormatValueViewColumnDecorator($column, 2, ',', '.', $this->RenderText('$'));
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $result->AddViewColumn($column);
            
            //
            // View column for budget_spent field
            //
            $column = new TextViewColumn('budget_spent', 'Budget Spent', $this->dataset);
            $column->SetOrderable(true);
            $column = new CurrencyFormatValueViewColumnDecorator($column, 2, ',', '.', $this->RenderText('$'));
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $result->AddViewColumn($column);
            
            //
            // View column for multi_year field
            //
            $column = new TextViewColumn('multi_year', 'Multi Year', $this->dataset);
            $column->SetOrderable(true);
            $column = new CheckBoxFormatValueViewColumnDecorator($column);
            $column->SetDisplayValues($this->RenderText('<img src="images/checked.png" alt="true">'), $this->RenderText(''));
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $result->AddViewColumn($column);
            
            //
            // View column for public_engagement field
            //
            $column = new TextViewColumn('public_engagement', 'Public Engagement', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('projectGrid_public_engagement_handler_list');
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $result->AddViewColumn($column);
            
            //
            // View column for level_of_service field
            //
            $column = new TextViewColumn('level_of_service', 'Level Of Service', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $result->AddViewColumn($column);
            
            //
            // View column for approved field
            //
            $column = new TextViewColumn('approved', 'Approved by CAO', $this->dataset);
            $column->SetOrderable(true);
            $column = new CheckBoxFormatValueViewColumnDecorator($column);
            $column->SetDisplayValues($this->RenderText('<img src="images/checked.png" alt="true">'), $this->RenderText(''));
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $result->AddViewColumn($column);
            
            //
            // View column for progress field
            //
            $column = new TextViewColumn('progress', 'Progress', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $result->AddViewColumn($column);
            
            //
            // View column for DEPARTMENT field
            //
            $column = new TextViewColumn('dept_id_DEPARTMENT', 'Department', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $result->AddViewColumn($column);
            
            //
            // View column for program_name field
            //
            $column = new TextViewColumn('programm_id_program_name', 'Project Type', $this->dataset);
            $column->SetOrderable(true);
            $result->AddPrintColumn($column);
            
            //
            // View column for project_name field
            //
            $column = new TextViewColumn('project_name', 'Project Name', $this->dataset);
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
            
            //
            // View column for year field
            //
            $column = new TextViewColumn('year', 'Year', $this->dataset);
            $column->SetOrderable(true);
            $column->SetEscapeHTMLSpecialChars(true);
            $column->SetWordWrap(false);
            $result->AddPrintColumn($column);
            
            //
            // View column for notes field
            //
            $column = new TextViewColumn('notes', 'Notes', $this->dataset);
            $column->SetOrderable(true);
            $result->AddPrintColumn($column);
            
            //
            // View column for Name field
            //
            $column = new TextViewColumn('priority_Name', 'Priority', $this->dataset);
            $column->SetOrderable(true);
            $result->AddPrintColumn($column);
            
            //
            // View column for username field
            //
            $column = new TextViewColumn('lead_username', 'Project Lead', $this->dataset);
            $column->SetOrderable(true);
            $result->AddPrintColumn($column);
            
            //
            // View column for approved_budget field
            //
            $column = new TextViewColumn('approved_budget', 'Approved Budget', $this->dataset);
            $column->SetOrderable(true);
            $column = new CurrencyFormatValueViewColumnDecorator($column, 2, ',', '.', $this->RenderText('$'));
            $result->AddPrintColumn($column);
            
            //
            // View column for budget_spent field
            //
            $column = new TextViewColumn('budget_spent', 'Budget Spent', $this->dataset);
            $column->SetOrderable(true);
            $column = new CurrencyFormatValueViewColumnDecorator($column, 2, ',', '.', $this->RenderText('$'));
            $result->AddPrintColumn($column);
            
            //
            // View column for multi_year field
            //
            $column = new TextViewColumn('multi_year', 'Multi Year', $this->dataset);
            $column->SetOrderable(true);
            $column = new CheckBoxFormatValueViewColumnDecorator($column);
            $column->SetDisplayValues($this->RenderText('<img src="images/checked.png" alt="true">'), $this->RenderText(''));
            $result->AddPrintColumn($column);
            
            //
            // View column for public_engagement field
            //
            $column = new TextViewColumn('public_engagement', 'Public Engagement', $this->dataset);
            $column->SetOrderable(true);
            $result->AddPrintColumn($column);
            
            //
            // View column for level_of_service field
            //
            $column = new TextViewColumn('level_of_service', 'Level Of Service', $this->dataset);
            $column->SetOrderable(true);
            $result->AddPrintColumn($column);
            
            //
            // View column for approved field
            //
            $column = new TextViewColumn('approved', 'Approved by CAO', $this->dataset);
            $column->SetOrderable(true);
            $column = new CheckBoxFormatValueViewColumnDecorator($column);
            $column->SetDisplayValues($this->RenderText('<img src="images/checked.png" alt="true">'), $this->RenderText(''));
            $result->AddPrintColumn($column);
            
            //
            // View column for progress field
            //
            $column = new TextViewColumn('progress', 'Progress', $this->dataset);
            $column->SetOrderable(true);
            $result->AddPrintColumn($column);
            
            //
            // View column for DEPARTMENT field
            //
            $column = new TextViewColumn('dept_id_DEPARTMENT', 'Department', $this->dataset);
            $column->SetOrderable(true);
            $result->AddPrintColumn($column);
            
            return $result;
        }
        
        public function MasterDetailRecordGridForproject_timeline_detailDetailEdit2project_OnCustomDrawRow($rowData, &$rowCellStyles, &$rowStyles)
        {
        $today = date("Y-m-d");
        if ($today > $rowData['date_end'] AND $rowData['progress'] < 1)
        $rowCellStyles['date_end'] .= 'font-size: 10pt;font-weight: bold; color: #FF0000;background-color:#F3F781;';
        elseif ($rowData['progress'] >= 1)
        $rowCellStyles['progress'] .= 'font-size: 10pt;font-weight: bold; background-color: #58FA58;';
        
        if ($rowData['budget_spent'] > $rowData['approved_budget'])
        $rowCellStyles['budget_spent'] .= 'font-size: 10pt;font-weight: bold; color:#FFFFFF; background-color: #FF0000;';
        }
        function MasterDetailRecordGridForproject_timeline_detailDetailEdit2project_OnCustomRenderColumn($fieldName, $fieldData, $rowData, &$customText, &$handled)
        {
            if ($fieldName == 'progress') 
            
              {
            
                if ($fieldData >= 1)
            
                  $customText = 'Project <br /> Complete';
            else $customText = ($fieldData * 100 . '%');
                
                $handled = true;   
            
              }
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
        public function projectGrid_OnGetCustomTemplate($part, $mode, &$result, &$params)
        {
        if ($part == PagePart::RecordCard && $mode == PageMode::View)
          $result = 'project_view.tpl';
        
        if ($part == PagePart::VerticalGrid && $mode == PageMode::Edit)
           $result = 'project_edit.tpl';
         
        if ($part == PagePart::VerticalGrid && $mode == PageMode::Insert)
          $result = 'project_insert.tpl';
        }
        public function projectGrid_OnCustomDrawRow($rowData, &$rowCellStyles, &$rowStyles)
        {
        $today = date("Y-m-d");
        if ($today > $rowData['date_end'] AND $rowData['progress'] < 1)
        $rowCellStyles['date_end'] .= 'font-size: 10pt;font-weight: bold; color: #FF0000;background-color:#F3F781;';
        elseif ($rowData['progress'] >= 1)
        $rowCellStyles['progress'] .= 'font-size: 10pt;font-weight: bold; background-color: #58FA58;';
        
        if ($rowData['budget_spent'] > $rowData['approved_budget'])
        $rowCellStyles['budget_spent'] .= 'font-size: 10pt;font-weight: bold; color:#FFFFFF; background-color: #FF0000;';
        }
        function projectGrid_OnCustomRenderColumn($fieldName, $fieldData, $rowData, &$customText, &$handled)
        {
            if ($fieldName == 'progress') 
            
              {
            
                if ($fieldData >= 1)
            
                  $customText = 'Project <br /> Complete';
            else $customText = ($fieldData * 100 . '%');
                
                $handled = true;   
            
              }
        }
        function projectGrid_OnCustomRenderTotal($totalValue, $aggregate, $columnName, &$customText, &$handled)
        {
            if ($columnName == 'approved_budget')
            
            {
            
                $customText = '<strong>Total: $' . $totalValue . '</strong>';
            
                $handled = true;   
            
            }
        }
        function projectGrid_BeforeUpdateRecord($page, &$rowData, &$cancel, &$message, $tableName)
        {
            $rowData['staff_id'] = $rowData['lead'];
        }
        function projectGrid_BeforeInsertRecord($page, &$rowData, &$cancel, &$message, $tableName)
        {
            $rowData['staff_id'] = $rowData['lead'];
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
        
        public function GetModalGridDeleteHandler() { return 'project_modal_delete'; }
        protected function GetEnableModalGridDelete() { return true; }
        
        private $partitions = array(1 => array('4'), 2 => array('6'), 3 => array('9'), 4 => array('10'), 5 => array('11'), 6 => array('12'), 7 => array('8'));
        function partition_GetPartitionsHandler(&$partitions)
        {
            $partitions[1] = 'Planning';
            $partitions[2] = 'Engineering / Public Works';
            $partitions[3] = 'Strategic Planning';
            $partitions[4] = 'Community Services';
            $partitions[5] = 'Human Resources';
            $partitions[6] = 'Finance';
            $partitions[7] = 'Legislative Services';
        }
        
        function partition_GetPartitionConditionHandler($partitionName, &$condition)
            {
                $condition = '';
                if (isset($partitionName) && isset($this->partitions[$partitionName]))
                    foreach ($this->partitions[$partitionName] as $value)
                        AddStr($condition, sprintf('(project.dept_id = %s)', $this->PrepareTextForSQL($value)), ' OR ');
            }
    
        protected function CreateGrid()
        {
            $result = new Grid($this, $this->dataset, 'projectGrid');
            if ($this->GetSecurityInfo()->HasDeleteGrant())
               $result->SetAllowDeleteSelected(true);
            else
               $result->SetAllowDeleteSelected(false);   
            
            ApplyCommonPageSettings($this, $result);
            
            $result->SetUseImagesForActions(true);
            $result->SetInsertClientValidationScript($this->RenderText('if ( Number(fieldValues[\'budget_spent\']) > Number(fieldValues[\'approved_budget\']))
            
            {
              errorInfo.SetMessage(\'"Budget spent is greater than the Approved Budget"\');
              return false;
            }
            else if
            (fieldValues[\'date_start\'] >= fieldValues[\'date_end\'])
            {
              errorInfo.SetMessage(\'"Start date is greater than or equal to End date"\');
              return false;
            }'));
            
            $result->SetEditClientFormLoadedScript($this->RenderText('if (editors[\'approved\'].getValue() == 1) {
              editors[\'programm_id\'].setEnabled(false);
              editors[\'project_name\'].setEnabled(false);
              editors[\'date_start\'].setEnabled(false);
              editors[\'date_end\'].setEnabled(false);
              editors[\'approved_budget\'].setEnabled(false);
              editors[\'notes\'].setEnabled(false);
              editors[\'priority\'].setEnabled(false);
              editors[\'lead\'].setEnabled(false);
              editors[\'level_of_service\'].setEnabled(false);
              editors[\'multi_year\'].setEnabled(false);
              editors[\'public_engagement\'].setEnabled(false);
              editors[\'year\'].setEnabled(false); 
              editors[\'dept_id\'].setEnabled(false);
              }
            else 
            {
              editors[\'programm_id\'].setEnabled(true);
              editors[\'project_name\'].setEnabled(true);
              editors[\'date_start\'].setEnabled(true);
              editors[\'date_end\'].setEnabled(true);
              editors[\'approved_budget\'].setEnabled(true);
              editors[\'notes\'].setEnabled(true);
              editors[\'priority\'].setEnabled(true);
              editors[\'lead\'].setEnabled(true);
              editors[\'level_of_service\'].setEnabled(true);
              editors[\'multi_year\'].setEnabled(true);
              editors[\'public_engagement\'].setEnabled(true);
              editors[\'year\'].setEnabled(true); 
              editors[\'dept_id\'].setEnabled(true);
            }'));
            
            $result->SetEditClientValidationScript($this->RenderText('if ( Number(fieldValues[\'budget_spent\']) > Number(fieldValues[\'approved_budget\']))
            
            {
              errorInfo.SetMessage(\'"Budget spent is greater than the Approved Budget"\');
              return false;
            }
            else if
            (fieldValues[\'date_start\'] >= fieldValues[\'date_end\'])
            {
              errorInfo.SetMessage(\'"Start date is greater than or equal to End date"\');
              return false;
            }'));
            $result->SetUseFixedHeader(false);
            $result->SetShowLineNumbers(false);
            
            $result->SetHighlightRowAtHover(false);
            $result->SetWidth('');
            $this->OnGetCustomTemplate->AddListener('projectGrid' . '_OnGetCustomTemplate', $this);
            $result->OnCustomDrawCell->AddListener('projectGrid' . '_OnCustomDrawRow', $this);
            $result->OnCustomRenderColumn->AddListener('projectGrid' . '_' . 'OnCustomRenderColumn', $this);
            $result->OnCustomRenderTotal->AddListener('projectGrid' . '_' . 'OnCustomRenderTotal', $this);
            $result->BeforeUpdateRecord->AddListener('projectGrid' . '_' . 'BeforeUpdateRecord', $this);
            $result->BeforeInsertRecord->AddListener('projectGrid' . '_' . 'BeforeInsertRecord', $this);
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
            $pageView = new taskDetailView0projectPage($this, 'Tasks', 'Tasks', array('project_id'), GetCurrentUserGrantForDataSource('project.task'), 'UTF-8', 20, 'taskDetailEdit0project_handler');
            
            $pageView->SetRecordPermission(GetCurrentUserRecordPermissionsForDataSource('project.task'));
            $handler = new PageHTTPHandler('taskDetailView0project_handler', $pageView);
            GetApplication()->RegisterHTTPHandler($handler);
            $pageEdit = new taskDetailEdit0projectPage($this, array('project_id'), array('project_id'), $this->GetForeingKeyFields(), $this->CreateMasterDetailRecordGridFortaskDetailEdit0projectGrid(), $this->dataset, GetCurrentUserGrantForDataSource('project.task'), 'UTF-8');
            
            $pageEdit->SetRecordPermission(GetCurrentUserRecordPermissionsForDataSource('project.task'));
            $pageEdit->SetShortCaption('Tasks within this project');
            $pageEdit->SetHeader(GetPagesHeader());
            $pageEdit->SetFooter(GetPagesFooter());
            $pageEdit->SetCaption('Tasks');
            $pageEdit->SetHttpHandlerName('taskDetailEdit0project_handler');
            $handler = new PageHTTPHandler('taskDetailEdit0project_handler', $pageEdit);
            GetApplication()->RegisterHTTPHandler($handler);
            $pageView = new projectDetailView1projectPage($this, 'Project Budget', 'Project Budget', array('project_id'), GetCurrentUserGrantForDataSource('project.project'), 'UTF-8', 20, 'projectDetailEdit1project_handler');
            
            $pageView->SetRecordPermission(GetCurrentUserRecordPermissionsForDataSource('project.project'));
            $handler = new PageHTTPHandler('projectDetailView1project_handler', $pageView);
            GetApplication()->RegisterHTTPHandler($handler);
            $pageEdit = new projectDetailEdit1projectPage($this, array('project_id'), array('project_id'), $this->GetForeingKeyFields(), $this->CreateMasterDetailRecordGridForprojectDetailEdit1projectGrid(), $this->dataset, GetCurrentUserGrantForDataSource('project.project'), 'UTF-8');
            
            $pageEdit->SetRecordPermission(GetCurrentUserRecordPermissionsForDataSource('project.project'));
            $pageEdit->SetShortCaption('Project Budget Chart');
            $pageEdit->SetHeader(GetPagesHeader());
            $pageEdit->SetFooter(GetPagesFooter());
            $pageEdit->SetCaption('Project Budget');
            $pageEdit->SetHttpHandlerName('projectDetailEdit1project_handler');
            $handler = new PageHTTPHandler('projectDetailEdit1project_handler', $pageEdit);
            GetApplication()->RegisterHTTPHandler($handler);
            $pageView = new project_timeline_detailDetailView2projectPage($this, 'Tasks Gantt view', 'Tasks Gantt view', array('task_project_id'), GetCurrentUserGrantForDataSource('project.project_timeline_detail'), 'UTF-8', 20, 'project_timeline_detailDetailEdit2project_handler');
            
            $pageView->SetRecordPermission(GetCurrentUserRecordPermissionsForDataSource('project.project_timeline_detail'));
            $handler = new PageHTTPHandler('project_timeline_detailDetailView2project_handler', $pageView);
            GetApplication()->RegisterHTTPHandler($handler);
            $pageEdit = new project_timeline_detailDetailEdit2projectPage($this, array('task_project_id'), array('project_id'), $this->GetForeingKeyFields(), $this->CreateMasterDetailRecordGridForproject_timeline_detailDetailEdit2projectGrid(), $this->dataset, GetCurrentUserGrantForDataSource('project.project_timeline_detail'), 'UTF-8');
            
            $pageEdit->SetRecordPermission(GetCurrentUserRecordPermissionsForDataSource('project.project_timeline_detail'));
            $pageEdit->SetShortCaption('Tasks Gantt view');
            $pageEdit->SetHeader(GetPagesHeader());
            $pageEdit->SetFooter(GetPagesFooter());
            $pageEdit->SetCaption('Tasks Gantt view');
            $pageEdit->SetHttpHandlerName('project_timeline_detailDetailEdit2project_handler');
            $handler = new PageHTTPHandler('project_timeline_detailDetailEdit2project_handler', $pageEdit);
            GetApplication()->RegisterHTTPHandler($handler);
            //
            // View column for notes field
            //
            $column = new TextViewColumn('notes', 'Objectives', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'projectGrid_notes_handler_list', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            //
            // View column for public_engagement field
            //
            $column = new TextViewColumn('public_engagement', 'Public Engagement', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'projectGrid_public_engagement_handler_list', $column);
            GetApplication()->RegisterHTTPHandler($handler);//
            // View column for notes field
            //
            $column = new TextViewColumn('notes', 'Objectives', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'projectGrid_notes_handler_view', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            //
            // View column for public_engagement field
            //
            $column = new TextViewColumn('public_engagement', 'Public Engagement', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'projectGrid_public_engagement_handler_view', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            return $result;
        }
        
        public function OpenAdvancedSearchByDefault()
        {
            return false;
        }
    
        protected function DoGetGridHeader()
        {
            return '<strong>Project Guidelines and References:</strong>
    <ul class="feature-list">
      <li><a href="workplan_help.pdf" target="_blank">General Workplan Help</a></li>
      <li><a href="ProjectDesign.pdf" target="_blank">Capital and Operating Project Design Directive</a></li>
      <li><a href="PublicParticipation.pdf" target="_blank">IAP2 Spectrum of Public Participation</a></li> 
       
    </ul>';
        }
    }

    SetUpUserAuthorization(GetApplication());

    try
    {
        $Page = new projectPage("project.php", "project", GetCurrentUserGrantForDataSource("project"), 'UTF-8');
        $Page->SetShortCaption('View all Projects');
        $Page->SetHeader(GetPagesHeader());
        $Page->SetFooter(GetPagesFooter());
        $Page->SetCaption('Project');
        $Page->SetRecordPermission(GetCurrentUserRecordPermissionsForDataSource("project"));
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
	
