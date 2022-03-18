<?php

$tpl = erLhcoreClassTemplate::getInstance('lhgooglebusinessmessage/editagent.tpl.php');

$item = \LiveHelperChatExtension\googlebusinessmessage\providers\erLhcoreClassModelGoogleBusinessAgent::fetch($Params['user_parameters']['id']);

if (ezcInputForm::hasPostData()) {

    if (isset($_POST['Cancel_action'])) {
        erLhcoreClassModule::redirect('googlebusinessmessage/agents');
        exit ;
    }

    if (!isset($_POST['csfr_token']) || !$currentUser->validateCSFRToken($_POST['csfr_token'])) {
        erLhcoreClassModule::redirect('googlebusinessmessage/agents');
        exit;
    }

    $Errors = LiveHelperChatExtension\googlebusinessmessage\providers\erLhcoreClassGoogleBusinessValidator::validateAgent($item);

    if (count($Errors) == 0) {
        try {
            $item->saveThis();
            erLhcoreClassModule::redirect('googlebusinessmessage/agents');
            exit;
        } catch (Exception $e) {
            $tpl->set('errors',array($e->getMessage()));
        }
    } else {
        $tpl->set('errors',$Errors);
    }
}

$tpl->setArray(array(
    'item' => $item,
));

$Result['content'] = $tpl->fetch();

$Result['path'] = array(
    array(
        'url' => erLhcoreClassDesign::baseurl('googlebusinessmessage/index'),
        'title' => erTranslationClassLhTranslation::getInstance()->getTranslation('googlebusinessmessage/module', 'Google Business Message')
    ),
    array (
        'url' =>erLhcoreClassDesign::baseurl('googlebusinessmessage/agents'),
        'title' => erTranslationClassLhTranslation::getInstance()->getTranslation('googlebusinessmessage/module','Agents')
    ),
    array (
        'title' => erTranslationClassLhTranslation::getInstance()->getTranslation('googlebusinessmessage/module', 'Edit agent')
    )
);

?>