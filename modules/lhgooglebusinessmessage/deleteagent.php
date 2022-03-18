<?php

$item = \LiveHelperChatExtension\googlebusinessmessage\providers\erLhcoreClassModelGoogleBusinessAgent::fetch($Params['user_parameters']['id']);

$currentUser = erLhcoreClassUser::instance();

if (!isset($_SERVER['HTTP_X_CSRFTOKEN']) || !$currentUser->validateCSFRToken($_SERVER['HTTP_X_CSRFTOKEN'])) {
    die('Invalid CSRF Token');
    exit;
}

$item->removeThis();

erLhcoreClassModule::redirect('googlebusinessmessage/agents');
exit;

?>