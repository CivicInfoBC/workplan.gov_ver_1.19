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
    
    
    
    class projectDetailView0programPage extends DetailPage
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
            $column = new TextViewColumn('programm_id_program_name', 'Project Type', $this->dataset);
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
            $column->SetFullTextWindowHandlerName('projectDetailViewGrid0program_project_name_handler_list');
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
            // View column for notes field
            //
            $column = new TextViewColumn('notes', 'Notes', $this->dataset);
            $column->SetOrderable(false);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('projectDetailViewGrid0program_notes_handler_list');
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for priority field
            //
            $column = new TextViewColumn('priority', 'Priority', $this->dataset);
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
            // View column for approved_budget field
            //
            $column = new TextViewColumn('approved_budget', 'Approved Budget', $this->dataset);
            $grid->SetTotal($column, PredefinedAggregate::$Sum);
            $column->SetOrderable(false);
            $column = new CurrencyFormatValueViewColumnDecorator($column, 2, ',', '.', $this->RenderText('$'));
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
            $result = new Grid($this, $this->dataset, 'projectDetailViewGrid0program');
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
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'projectDetailViewGrid0program_project_name_handler_list', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            //
            // View column for notes field
            //
            $column = new TextViewColumn('notes', 'Notes', $this->dataset);
            $column->SetOrderable(false);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'projectDetailViewGrid0program_notes_handler_list', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            return $result;
        }
    }
    
    
    
    // OnBeforePageExecute event handler
    
    
    
    class projectDetailEdit0programPage extends DetailPageEdit
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
            $grid->SearchControl = new SimpleSearch('projectDetailEdit0programssearch', $this->dataset,
                array('programm_id_program_name', 'project_name', 'date_start', 'date_end', 'notes', 'priority', 'lead', 'approved_budget'),
                array($this->RenderText('Project Type'), $this->RenderText('Project Name'), $this->RenderText('Date Start'), $this->RenderText('Date End'), $this->RenderText('Notes'), $this->RenderText('Priority'), $this->RenderText('Lead'), $this->RenderText('Approved Budget')),
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
            $this->AdvancedSearchControl = new AdvancedSearchControl('projectDetailEdit0programasearch', $this->dataset, $this->GetLocalizerCaptions(), $this->GetColumnVariableContainer(), $this->CreateLinkBuilder());
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
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('notes', $this->RenderText('Notes')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('priority', $this->RenderText('Priority')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('lead', $this->RenderText('Lead')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('approved_budget', $this->RenderText('Approved Budget')));
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
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('projectDetailEditGrid0program_project_name_handler_list');
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
            // View column for notes field
            //
            $column = new TextViewColumn('notes', 'Notes', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('projectDetailEditGrid0program_notes_handler_list');
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for priority field
            //
            $column = new TextViewColumn('priority', 'Priority', $this->dataset);
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
            // View column for approved_budget field
            //
            $column = new TextViewColumn('approved_budget', 'Approved Budget', $this->dataset);
            $grid->SetTotal($column, PredefinedAggregate::$Sum);
            $column->SetOrderable(true);
            $column = new CurrencyFormatValueViewColumnDecorator($column, 2, ',', '.', $this->RenderText('$'));
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
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('projectDetailEditGrid0program_project_name_handler_view');
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
            // View column for notes field
            //
            $column = new TextViewColumn('notes', 'Notes', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('projectDetailEditGrid0program_notes_handler_view');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for priority field
            //
            $column = new TextViewColumn('priority', 'Priority', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for lead field
            //
            $column = new TextViewColumn('lead', 'Lead', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for approved_budget field
            //
            $column = new TextViewColumn('approved_budget', 'Approved Budget', $this->dataset);
            $column->SetOrderable(true);
            $column = new CurrencyFormatValueViewColumnDecorator($column, 2, ',', '.', $this->RenderText('$'));
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
            $editor = new DateTimeEdit('date_start_edit', true, 'Y-m-d H:i:s', GetFirstDayOfWeek());
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
            // Edit column for notes field
            //
            $editor = new TextAreaEdit('notes_edit', 50, 8);
            $editColumn = new CustomEditColumn('Notes', 'notes', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for priority field
            //
            $editor = new TextEdit('priority_edit');
            $editor->SetSize(20);
            $editor->SetMaxLength(20);
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
            // Edit column for approved_budget field
            //
            $editor = new TextEdit('approved_budget_edit');
            $editColumn = new CustomEditColumn('Approved Budget', 'approved_budget', $editor, $this->dataset);
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
                'Project Type', 
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
            $editor = new DateTimeEdit('date_start_edit', true, 'Y-m-d H:i:s', GetFirstDayOfWeek());
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
            // Edit column for notes field
            //
            $editor = new TextAreaEdit('notes_edit', 50, 8);
            $editColumn = new CustomEditColumn('Notes', 'notes', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for priority field
            //
            $editor = new TextEdit('priority_edit');
            $editor->SetSize(20);
            $editor->SetMaxLength(20);
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
            // Edit column for approved_budget field
            //
            $editor = new TextEdit('approved_budget_edit');
            $editColumn = new CustomEditColumn('Approved Budget', 'approved_budget', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
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
            // View column for approved_budget field
            //
            $column = new TextViewColumn('approved_budget', 'Approved Budget', $this->dataset);
            $column->SetOrderable(true);
            $column = new CurrencyFormatValueViewColumnDecorator($column, 2, ',', '.', $this->RenderText('$'));
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
            // View column for approved_budget field
            //
            $column = new TextViewColumn('approved_budget', 'Approved Budget', $this->dataset);
            $column->SetOrderable(true);
            $column = new CurrencyFormatValueViewColumnDecorator($column, 2, ',', '.', $this->RenderText('$'));
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
    
        protected function CreateGrid()
        {
            $result = new Grid($this, $this->dataset, 'projectDetailEditGrid0program');
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
            $this->SetFilterRowAvailable(false);
            $this->SetVisualEffectsEnabled(true);
            $this->SetShowTopPageNavigator(true);
            $this->SetShowBottomPageNavigator(true);
    
            //
            // Http Handlers
            //
            //
            // View column for project_name field
            //
            $column = new TextViewColumn('project_name', 'Project Name', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'projectDetailEditGrid0program_project_name_handler_list', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            //
            // View column for notes field
            //
            $column = new TextViewColumn('notes', 'Notes', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'projectDetailEditGrid0program_notes_handler_list', $column);
            GetApplication()->RegisterHTTPHandler($handler);//
            // View column for project_name field
            //
            $column = new TextViewColumn('project_name', 'Project Name', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'projectDetailEditGrid0program_project_name_handler_view', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            //
            // View column for notes field
            //
            $column = new TextViewColumn('notes', 'Notes', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'projectDetailEditGrid0program_notes_handler_view', $column);
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
    
    
    
    class programPage extends Page
    {
        protected function DoBeforeCreate()
        {
            $this->dataset = new TableDataset(
                new MyConnectionFactory(),
                GetConnectionOptions(),
                '`program`');
            $field = new IntegerField('program_id', null, null, true);
            $field->SetIsNotNull(true);
            $this->dataset->AddField($field, true);
            $field = new StringField('program_name');
            $this->dataset->AddField($field, false);
            $field = new StringField('year');
            $this->dataset->AddField($field, false);
            $field = new StringField('multi');
            $field->SetIsNotNull(true);
            $this->dataset->AddField($field, false);
            $field = new StringField('description');
            $field->SetIsNotNull(true);
            $this->dataset->AddField($field, false);
            $field = new StringField('lead');
            $this->dataset->AddField($field, false);
            $field = new DateField('date_start');
            $this->dataset->AddField($field, false);
            $field = new DateField('date_end');
            $this->dataset->AddField($field, false);
            $field = new IntegerField('progress');
            $field->SetIsNotNull(true);
            $this->dataset->AddField($field, false);
            $field = new StringField('notes');
            $this->dataset->AddField($field, false);
            $this->dataset->AddLookupField('lead', 'staff', new StringField('username'), new StringField('username', 'lead_username', 'lead_username_staff'), 'lead_username_staff');
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
            $grid->SearchControl = new SimpleSearch('programssearch', $this->dataset,
                array('program_name', 'description', 'lead_username', 'date_start', 'date_end'),
                array($this->RenderText(' Name'), $this->RenderText('Description'), $this->RenderText('Lead'), $this->RenderText('Date Start'), $this->RenderText('Date End')),
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
            $this->AdvancedSearchControl = new AdvancedSearchControl('programasearch', $this->dataset, $this->GetLocalizerCaptions(), $this->GetColumnVariableContainer(), $this->CreateLinkBuilder());
            $this->AdvancedSearchControl->setTimerInterval(1000);
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('program_name', $this->RenderText(' Name')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('description', $this->RenderText('Description')));
            
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
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateLookupSearchInput('lead', $this->RenderText('Lead'), $lookupDataset, 'username', 'username', false, 8));
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
            if (GetCurrentUserGrantForDataSource('program.project')->HasViewGrant())
            {
              //
            // View column for projectDetailView0program detail
            //
            $column = new DetailColumn(array('program_id'), 'detail0program', 'projectDetailEdit0program_handler', 'projectDetailView0program_handler', $this->dataset, 'Projects', $this->RenderText('Projects'));
              $grid->AddViewColumn($column);
            }
            
            //
            // View column for program_name field
            //
            $column = new TextViewColumn('program_name', ' Name', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for description field
            //
            $column = new TextViewColumn('description', 'Description', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('programGrid_description_handler_list');
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for username field
            //
            $column = new TextViewColumn('lead_username', 'Lead', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('programGrid_username_handler_list');
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
            // View column for program_name field
            //
            $column = new TextViewColumn('program_name', ' Name', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for description field
            //
            $column = new TextViewColumn('description', 'Description', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('programGrid_description_handler_view');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for username field
            //
            $column = new TextViewColumn('lead_username', 'Lead', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('programGrid_username_handler_view');
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
            // Edit column for program_name field
            //
            $editor = new TextEdit('program_name_edit');
            $editor->SetSize(50);
            $editor->SetMaxLength(50);
            $editColumn = new CustomEditColumn(' Name', 'program_name', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for description field
            //
            $editor = new TextAreaEdit('description_edit', 50, 8);
            $editColumn = new CustomEditColumn('Description', 'description', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
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
                'Lead', 
                'lead', 
                $editor, 
                $this->dataset, 'username', 'username', $lookupDataset);
            $editColumn->SetCaptionTemplate($this->RenderText('%username%'));
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
            $editor = new DateTimeEdit('date_end_edit', false, 'Y-m-d', GetFirstDayOfWeek());
            $editColumn = new CustomEditColumn('Date End', 'date_end', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
        }
    
        protected function AddInsertColumns(Grid $grid)
        {
            //
            // Edit column for program_name field
            //
            $editor = new TextEdit('program_name_edit');
            $editor->SetSize(50);
            $editor->SetMaxLength(50);
            $editColumn = new CustomEditColumn(' Name', 'program_name', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for description field
            //
            $editor = new TextAreaEdit('description_edit', 50, 8);
            $editColumn = new CustomEditColumn('Description', 'description', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
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
                'Lead', 
                'lead', 
                $editor, 
                $this->dataset, 'username', 'username', $lookupDataset);
            $editColumn->SetCaptionTemplate($this->RenderText('%username%'));
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
            $editor = new DateTimeEdit('date_end_edit', false, 'Y-m-d', GetFirstDayOfWeek());
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
            // View column for program_name field
            //
            $column = new TextViewColumn('program_name', ' Name', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for description field
            //
            $column = new TextViewColumn('description', 'Description', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for lead field
            //
            $column = new TextViewColumn('lead', 'Lead', $this->dataset);
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
            // View column for program_name field
            //
            $column = new TextViewColumn('program_name', ' Name', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for description field
            //
            $column = new TextViewColumn('description', 'Description', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for lead field
            //
            $column = new TextViewColumn('lead', 'Lead', $this->dataset);
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
    
        function CreateMasterDetailRecordGridForprojectDetailEdit0programGrid()
        {
            $result = new Grid($this, $this->dataset, 'MasterDetailRecordGridForprojectDetailEdit0program');
            $result->SetAllowDeleteSelected(false);
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
            $column = new TextViewColumn('program_name', ' Name', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $result->AddViewColumn($column);
            
            //
            // View column for description field
            //
            $column = new TextViewColumn('description', 'Description', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('programGrid_description_handler_list');
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $result->AddViewColumn($column);
            
            //
            // View column for username field
            //
            $column = new TextViewColumn('lead_username', 'Lead', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('programGrid_username_handler_list');
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
            // View column for program_name field
            //
            $column = new TextViewColumn('program_name', ' Name', $this->dataset);
            $column->SetOrderable(true);
            $result->AddPrintColumn($column);
            
            //
            // View column for description field
            //
            $column = new TextViewColumn('description', 'Description', $this->dataset);
            $column->SetOrderable(true);
            $result->AddPrintColumn($column);
            
            //
            // View column for lead field
            //
            $column = new TextViewColumn('lead', 'Lead', $this->dataset);
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
        
        function GetCustomClientScript()
        {
            return ;
        }
        
        function GetOnPageLoadedClientScript()
        {
            return ;
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
        
        public function GetModalGridDeleteHandler() { return 'program_modal_delete'; }
        protected function GetEnableModalGridDelete() { return true; }
    
        protected function CreateGrid()
        {
            $result = new Grid($this, $this->dataset, 'programGrid');
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
            $pageView = new projectDetailView0programPage($this, 'Projects', 'Projects', array('programm_id'), GetCurrentUserGrantForDataSource('program.project'), 'UTF-8', 20, 'projectDetailEdit0program_handler');
            
            $pageView->SetRecordPermission(GetCurrentUserRecordPermissionsForDataSource('program.project'));
            $handler = new PageHTTPHandler('projectDetailView0program_handler', $pageView);
            GetApplication()->RegisterHTTPHandler($handler);
            $pageEdit = new projectDetailEdit0programPage($this, array('programm_id'), array('program_id'), $this->GetForeingKeyFields(), $this->CreateMasterDetailRecordGridForprojectDetailEdit0programGrid(), $this->dataset, GetCurrentUserGrantForDataSource('program.project'), 'UTF-8');
            
            $pageEdit->SetRecordPermission(GetCurrentUserRecordPermissionsForDataSource('program.project'));
            $pageEdit->SetShortCaption('Projects');
            $pageEdit->SetHeader(GetPagesHeader());
            $pageEdit->SetFooter(GetPagesFooter());
            $pageEdit->SetCaption('Projects');
            $pageEdit->SetHttpHandlerName('projectDetailEdit0program_handler');
            $handler = new PageHTTPHandler('projectDetailEdit0program_handler', $pageEdit);
            GetApplication()->RegisterHTTPHandler($handler);
            //
            // View column for description field
            //
            $column = new TextViewColumn('description', 'Description', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'programGrid_description_handler_list', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            //
            // View column for username field
            //
            $column = new TextViewColumn('lead_username', 'Lead', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'programGrid_username_handler_list', $column);
            GetApplication()->RegisterHTTPHandler($handler);//
            // View column for description field
            //
            $column = new TextViewColumn('description', 'Description', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'programGrid_description_handler_view', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            //
            // View column for username field
            //
            $column = new TextViewColumn('lead_username', 'Lead', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'programGrid_username_handler_view', $column);
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
        $Page = new programPage("program.php", "program", GetCurrentUserGrantForDataSource("program"), 'UTF-8');
        $Page->SetShortCaption('Project Type');
        $Page->SetHeader(GetPagesHeader());
        $Page->SetFooter(GetPagesFooter());
        $Page->SetCaption('Project Type');
        $Page->SetRecordPermission(GetCurrentUserRecordPermissionsForDataSource("program"));
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
	
