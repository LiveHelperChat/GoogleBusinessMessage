<?php

erLhcoreClassRestAPIHandler::setHeaders();

$data = json_decode(file_get_contents('php://input'), true);

erLhcoreClassLog::write(
    print_r($data,true).
    print_r($_POST,true).
    print_r($_GET,true)
);

if (
    isset($data['clientToken']) && $data['clientToken'] == erLhcoreClassModule::getExtensionInstance('erLhcoreClassExtensionGooglebusinessmessage')->settings['clientToken'] &&
    isset($data['secret'])
) {
    echo $data['secret'];
    exit;
}

exit;

?>