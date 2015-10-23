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

include_once dirname(__FILE__) . '/' . 'authorization.php';

include_once dirname(__FILE__) . '/' . 'components/application.php';
include_once dirname(__FILE__) . '/' . 'components/captions.php';
include_once dirname(__FILE__) . '/' . 'components/error_utils.php';

include_once dirname(__FILE__) . '/' . 'components/utils/system_utils.php';
include_once dirname(__FILE__) . '/' . 'components/utils/string_utils.php';

include_once dirname(__FILE__) . '/' . 'components/security/base_user_auth.php';
include_once dirname(__FILE__) . '/' . 'components/security/table_based_user_grants_manager.php';

SetUpUserAuthorization();

class AdminPanelView
{
    private $localizerCaptions = null;

    /** @var TableBasedUserGrantsManager */
    private $tableBasedGrantsManager;

    public function __construct($tableBasedGrantsManager)
    {
        $this->tableBasedGrantsManager = $tableBasedGrantsManager;
    }

    public function GetContentEncoding()
    {
        return 'UTF-8';
    }

    public function GetLocalizerCaptions()
    {
        if (!isset($this->localizerCaptions))
            $this->localizerCaptions = new Captions($this->GetContentEncoding());
        return $this->localizerCaptions;
    }

    public function RenderText($text)
    {
        return ConvertTextToEncoding($text, GetAnsiEncoding(), $this->GetContentEncoding());
    }

    public function GetHeader()
    {
        return GetPagesHeader();
    }

    public function GetFooter()
    {
        return GetPagesFooter();
    }

    public function Render()
    {
        include_once 'libs/smartylibs/Smarty.class.php';
                
        $smarty = new Smarty();
        $smarty->template_dir = 'components/templates';
        $smarty->assign_by_ref('Page', $this);

        $users = $this->tableBasedGrantsManager->GetAllUsersAsJson();
        $smarty->assign_by_ref('Users', $users);

        $localizerCaptions = $this->GetLocalizerCaptions();
        $smarty->assign_by_ref('Captions', $localizerCaptions);

        /* $roles = $this->tableBasedGrantsManager->GetAllRolesAsJson();
        $smarty->assign_by_ref('Roles', $roles); */

        $headerString = 'Content-Type: text/html';
        if ($this->GetContentEncoding() != null)
            StringUtils::AddStr($headerString, 'charset=' . $this->GetContentEncoding(), ';');
        header($headerString);

        $pageInfos = GetPageInfos();
        $pageListViewData = array(
            'Pages' => array(),
            'CurrentPageOptions' => array());
        foreach($pageInfos as $pageInfo)
            $pageListViewData['Pages'][] =
                array(
                    'Caption' => $this->RenderText($pageInfo['caption']),
                    'Hint' => $this->RenderText($pageInfo['short_caption']),
                    'Href' => $pageInfo['filename'],
                    'GroupName' => $this->RenderText($pageInfo['group_name']),
                    'BeginNewGroup' => $pageInfo['add_separator'] 
                );
        $pageGroups = GetPageGroups();
        foreach($pageGroups as &$pageGroup)
            $pageGroup = $this->RenderText($pageGroup);
        $pageListViewData['Groups'] = $pageGroups;

        $smarty->assign_by_ref('PageList', $pageListViewData);
        $authenticationViewData =  $this->GetAuthenticationViewData();
        $smarty->assign_by_ref('Authentication', $authenticationViewData);
        
        $smarty->display('admin_panel.tpl');
    }

    public function GetAuthenticationViewData() {
        return array(
            'Enabled' => true,
            'LoggedIn' => GetApplication()->IsCurrentUserLoggedIn(),
            'CurrentUser' => array(
                'Name' => GetApplication()->GetCurrentUser(),
                'Id' => GetApplication()->GetCurrentUserId(),
            )
        );
    }

    public function GetCommonViewData() {
        return array(
            'ContentEncoding' => $this->GetContentEncoding()
        );
    }

}

$tableBasedGrants = CreateTableBasedGrantsManager();

$view = new AdminPanelView($tableBasedGrants);

if (!GetApplication()->GetUserAuthorizationStrategy()->HasAdminGrant(GetApplication()->GetCurrentUser()))
{
    RaiseSecurityError($view, 'You do not have permission to access this page.');
}

$view->Render();