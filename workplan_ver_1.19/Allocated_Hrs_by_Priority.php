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
    
    
    
    class Allocated_Hrs_by_PriorityPage extends Page
    {
        protected function DoBeforeCreate()
        {
            $selectQuery = 'SELECT DISTINCT 
              `project`.`priority`,
              SUM(`task`.`hrs`) AS `total_allocated_hrs`
            FROM
              `task`
              INNER JOIN `project` ON (`task`.`project_id` = `project`.`project_id`)
            GROUP BY
              `project`.`priority`';
            $insertQuery = array();
            $updateQuery = array();
            $deleteQuery = array();
            $this->dataset = new QueryDataset(
              new MyConnectionFactory(), 
              GetConnectionOptions(),
              $selectQuery, $insertQuery, $updateQuery, $deleteQuery, 'Allocated Hrs by Priority');
            $field = new StringField('priority');
            $this->dataset->AddField($field, true);
            $field = new StringField('total_allocated_hrs');
            $this->dataset->AddField($field, false);
        }
    
        protected function DoPrepare() {
    
        }
    
        protected function CreatePageNavigator()
        {
            return null;
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
            $grid->SearchControl = new SimpleSearch('Allocated_Hrs_by_Priorityssearch', $this->dataset,
                array('priority', 'total_allocated_hrs'),
                array($this->RenderText('Priority'), $this->RenderText('Total Allocated Hrs')),
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
            $this->AdvancedSearchControl = new AdvancedSearchControl('Allocated_Hrs_by_Priorityasearch', $this->dataset, $this->GetLocalizerCaptions(), $this->GetColumnVariableContainer(), $this->CreateLinkBuilder());
            $this->AdvancedSearchControl->setTimerInterval(1000);
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('priority', $this->RenderText('Priority')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('total_allocated_hrs', $this->RenderText('Total Allocated Hrs')));
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
            // View column for priority field
            //
            $column = new TextViewColumn('priority', 'Priority', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for total_allocated_hrs field
            //
            $column = new TextViewColumn('total_allocated_hrs', 'Total Allocated Hrs', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
        }
    
        protected function AddSingleRecordViewColumns(Grid $grid)
        {
            //
            // View column for priority field
            //
            $column = new TextViewColumn('priority', 'Priority', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for total_allocated_hrs field
            //
            $column = new TextViewColumn('total_allocated_hrs', 'Total Allocated Hrs', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
        }
    
        protected function AddEditColumns(Grid $grid)
        {
            //
            // Edit column for priority field
            //
            $editor = new TextEdit('priority_edit');
            $editColumn = new CustomEditColumn('Priority', 'priority', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for total_allocated_hrs field
            //
            $editor = new TextEdit('total_allocated_hrs_edit');
            $editColumn = new CustomEditColumn('Total Allocated Hrs', 'total_allocated_hrs', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
        }
    
        protected function AddInsertColumns(Grid $grid)
        {
            //
            // Edit column for priority field
            //
            $editor = new TextEdit('priority_edit');
            $editColumn = new CustomEditColumn('Priority', 'priority', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for total_allocated_hrs field
            //
            $editor = new TextEdit('total_allocated_hrs_edit');
            $editColumn = new CustomEditColumn('Total Allocated Hrs', 'total_allocated_hrs', $editor, $this->dataset);
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
            // View column for priority field
            //
            $column = new TextViewColumn('priority', 'Priority', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for total_allocated_hrs field
            //
            $column = new TextViewColumn('total_allocated_hrs', 'Total Allocated Hrs', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
        }
    
        protected function AddExportColumns(Grid $grid)
        {
            //
            // View column for priority field
            //
            $column = new TextViewColumn('priority', 'Priority', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for total_allocated_hrs field
            //
            $column = new TextViewColumn('total_allocated_hrs', 'Total Allocated Hrs', $this->dataset);
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
    
        function GetCustomClientScript()
        {
            return ;
        }
        
        function GetOnPageLoadedClientScript()
        {
            return ;
        }
        public function Allocated_Hrs_by_PriorityGrid_OnGetCustomTemplate($part, $mode, &$result, &$params)
        {
        if ($part == PagePart::Grid && $mode == PageMode::ViewAll)
          $result = 'hours_by_priority.tpl';
        }
    
        protected function CreateGrid()
        {
            $result = new Grid($this, $this->dataset, 'Allocated_Hrs_by_PriorityGrid');
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
            $this->OnGetCustomTemplate->AddListener('Allocated_Hrs_by_PriorityGrid' . '_OnGetCustomTemplate', $this);
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
            $this->SetExportToExcelAvailable(false);
            $this->SetExportToWordAvailable(false);
            $this->SetExportToXmlAvailable(false);
            $this->SetExportToCsvAvailable(false);
            $this->SetExportToPdfAvailable(false);
            $this->SetPrinterFriendlyAvailable(false);
            $this->SetSimpleSearchAvailable(true);
            $this->SetAdvancedSearchAvailable(true);
            $this->SetFilterRowAvailable(true);
            $this->SetVisualEffectsEnabled(true);
            $this->SetShowTopPageNavigator(false);
            $this->SetShowBottomPageNavigator(false);
    
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

    SetUpUserAuthorization(GetApplication());

    try
    {
        $Page = new Allocated_Hrs_by_PriorityPage("Allocated_Hrs_by_Priority.php", "Allocated_Hrs_by_Priority", GetCurrentUserGrantForDataSource("Allocated Hrs by Priority"), 'UTF-8');
        $Page->SetShortCaption('Chart: Allocated Hrs by Priority');
        $Page->SetHeader(GetPagesHeader());
        $Page->SetFooter(GetPagesFooter());
        $Page->SetCaption('Allocated Hrs by Priority');
        $Page->SetRecordPermission(GetCurrentUserRecordPermissionsForDataSource("Allocated Hrs by Priority"));
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
	
