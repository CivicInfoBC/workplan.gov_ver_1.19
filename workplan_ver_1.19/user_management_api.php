<?php


include_once dirname(__FILE__) . '/' . 'authorization.php';
include_once dirname(__FILE__) . '/' . 'components/security/user_management_request_handler.php';

SetUpUserAuthorization();
UserManagementRequestHandler::HandleRequest($_GET, CreateTableBasedGrantsManager(), GetIdentityCheckStrategy());
