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
    include_once dirname(__FILE__) . '/' . 'components/page.php';
    include_once dirname(__FILE__) . '/' . 'components/renderers/renderer.php';
    include_once dirname(__FILE__) . '/' . 'components/renderers/list_renderer.php';
    include_once dirname(__FILE__) . '/' . 'authorization.php';
    include_once dirname(__FILE__) . '/' . 'database_engine/mysql_engine.php';
    include_once dirname(__FILE__) . '/' . 'components/security/user_identity_cookie_storage.php';

    function GetConnectionOptions()
    {
        $result = GetGlobalConnectionOptions();
        $result['client_encoding'] = 'utf8';
        return $result;
    }

    class LoginControl
    {
        /** @var IdentityCheckStrategy */
        private $identityCheckStrategy;
        private $urlToRedirectAfterLogin;
        private $errorMessage;
        private $lastUserName;
        private $lastSaveidentity;
        private $loginAsGuestLink;
        /** @var \Captions */
        private $captions;

        /**
         * @var UserIdentityCookieStorage
         */
        private $userIdentityStorage;

        #region Events
        public $OnGetCustomTemplate;
        #endregion

        public function __construct($identityCheckStrategy, $urlToRedirectAfterLogin, Captions $captions)
        {
            $this->identityCheckStrategy = $identityCheckStrategy;
            $this->urlToRedirectAfterLogin = $urlToRedirectAfterLogin;
            $this->errorMessage = '';
            $this->captions = $captions;
            $this->lastSaveidentity = false;
            $this->userIdentityStorage = new UserIdentityCookieStorage($identityCheckStrategy);
            $this->OnGetCustomTemplate = new Event();
        }

        public function Accept(Renderer $renderer)
        {
            $renderer->RenderLoginControl($this);
        }

        public function GetErrorMessage() { return $this->errorMessage; }

        public function GetLastUserName() { return $this->lastUserName; }
        public function GetLastSaveidentity() { return $this->lastSaveidentity; }
        public function CanLoginAsGuest() { return false; }
        
        public function GetLoginAsGuestLink() 
        { 
            $pageInfos = GetPageInfos();
            foreach($pageInfos as $pageInfo)
            {
                if (GetApplication()->GetUserRoles('guest', $pageInfo['name'])->HasViewGrant())
                {   
                    return $pageInfo['filename'];
                }
            }
            return $this->urlToRedirectAfterLogin; 
        }

        public function CheckUsernameAndPassword($username, $password, &$errorMessage)
        {
            try
            {
                $result = $this->identityCheckStrategy->CheckUsernameAndPassword($username, $password, $errorMessage);
                if (!$result) {
                    $errorMessage = $this->captions->GetMessageString('UsernamePasswordWasInvalid');
                }
                return $result;
            }
            catch(Exception $e)
            {
                $errorMessage = $e->getMessage();
                return false;
            }
        }

        public function SaveUserIdentity($username, $password, $saveidentity)
        {
            $this->userIdentityStorage->SaveUserIdentity(new UserIdentity($username, $password, $saveidentity));
        }

        public function ClearUserIdentity()
        {
            $this->userIdentityStorage->ClearUserIdentity();
        }

        private function DoOnAfterLogin($userName)
        {
            $connectionFactory = new MyConnectionFactory();
            $connection = $connectionFactory->CreateConnection(GetConnectionOptions());
            try {
                $connection->Connect();
            }
            catch(Exception $e)
            {
                ShowErrorPage($e->getMessage());
                die;
            }

            $this->OnAfterLogin($userName, $connection);

            $connection->Disconnect();
        }

        private function OnAfterLogin($userName, $connection)
        {

        }

        private function GetUrlToRedirectAfterLogin()
        {
            $pageInfos = GetPageInfos();
            foreach($pageInfos as $pageInfo)
            {
                if (GetCurrentUserGrantForDataSource($pageInfo['name'])->HasViewGrant())
                {   
                    return $pageInfo['filename'];
                }
            }
            return $this->urlToRedirectAfterLogin;
        }
        
        public function ProcessMessages()
        {
            if (isset($_GET[OPERATION_PARAMNAME]) && $_GET[OPERATION_PARAMNAME] == 'logout')
            {
                $this->ClearUserIdentity();
            }
            elseif ($this->userIdentityStorage->LoadUserIdentity() != null && !(isset($_POST['username']) && isset($_POST['password'])))
            {
            }
            elseif (isset($_POST['username']) && isset($_POST['password']))
            {
                $username = $_POST['username'];
                $password = $_POST['password'];
                $saveidentity = isset($_POST['saveidentity']);

                if ($this->CheckUsernameAndPassword($username, $password, $this->errorMessage))
                {
                    $this->SaveUserIdentity($username, $password, $saveidentity);
                    SetCurrentUser($username);
                    $this->DoOnAfterLogin($username);
                    header('Location: ' . $this->GetUrlToRedirectAfterLogin() );
                    exit;
                }
                else
                {
                    $this->lastUserName = $username;
                    $this->lastSaveidentity = $saveidentity;
                }
            }
        }

        public function GetCustomTemplate($part, $defaultValue, &$params = null) {
            $result = null;

            if (!$params)
                $params = array();

            $this->OnGetCustomTemplate->Fire(array($part, null, &$result, &$params));
            if ($result)
                return Path::Combine('custom_templates', $result);
            else
                return $defaultValue;
        }
    }

    class LoginPage extends CustomLoginPage
    {
        private $loginControl;
        private $renderer;
        private $header;
        private $footer;

        private $captions;

        public function __construct(LoginControl $loginControl)
        {
            parent::__construct();
            $this->loginControl = $loginControl;
            $this->captions = GetCaptions('UTF-8');
            $this->renderer = new ViewAllRenderer($this->captions);
        }

        public function GetLoginControl()
        {
            return $this->loginControl;
        }

        public function Accept(Renderer $renderer)
        {
            $renderer->RenderLoginPage($this);
        }

        public function GetContentEncoding() { return 'UTF-8'; }
        
        public function GetCaption() { return 'Login'; }
        
        public function SetHeader($value) { $this->header = $value; }
        public function GetHeader() { return $this->RenderText($this->header); }
        
        public function SetFooter($value) { $this->footer = $value; }
        public function GetFooter() { return $this->RenderText($this->footer); }

        public function BeginRender()
        {
            $this->loginControl->ProcessMessages();
        }

        public function EndRender()
        {
            echo $this->renderer->Render($this);
        }

        public function addListeners() {
            $this->OnGetCustomTemplate->AddListener('Global_GetCustomTemplateHandler');
            $this->loginControl->OnGetCustomTemplate->AddListener('Global_GetCustomTemplateHandler');
        }
    }

    $loginPage = new LoginPage(
        new LoginControl(
            GetIdentityCheckStrategy(),
            'Dashboard.php',
            GetCaptions('UTF-8')));

    SetUpUserAuthorization();

    $loginPage->addListeners();

    $loginPage->SetHeader(GetPagesHeader());
    $loginPage->SetFooter(GetPagesFooter());
    $loginPage->BeginRender();
    $loginPage->BeginRender();
    $loginPage->EndRender();
