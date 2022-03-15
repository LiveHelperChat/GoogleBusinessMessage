<?php

$tpl = erLhcoreClassTemplate::getInstance('lhgooglebusinessmessage/newagent.tpl.php');

$item = new \LiveHelperChatExtension\googlebusinessmessage\providers\erLhcoreClassModelGoogleBusinessAgent();

$tpl->set('item', $item);

if (ezcInputForm::hasPostData()) {

    if (!isset($_POST['csfr_token']) || !$currentUser->validateCSFRToken($_POST['csfr_token'])) {
        erLhcoreClassModule::redirect('googlebusinessmessage/agents');
        exit;
    }

    $Errors = LiveHelperChatExtension\googlebusinessmessage\providers\erLhcoreClassGoogleBusinessValidator::validateAgent($item);

    if (count($Errors) == 0) {
        try {
            $item->saveThis();
            erLhcoreClassModule::redirect('googlebusinessmessage/agents');
            exit ;
        } catch (Exception $e) {
            $tpl->set('errors',array($e->getMessage()));
        }
    } else {
        $tpl->set('errors',$Errors);
    }
}

$Result['content'] = $tpl->fetch();
$Result['path'] = array(
    array(
        'url' => erLhcoreClassDesign::baseurl('googlebusinessmessage/index'),
        'title' => erTranslationClassLhTranslation::getInstance()->getTranslation('googlebusinessmessage/module', 'Google Business Message')
    ),
    array (
        'url' => erLhcoreClassDesign::baseurl('googlebusinessmessage/agents'),
        'title' => erTranslationClassLhTranslation::getInstance()->getTranslation('googlebusinessmessage/module','Agents')
    ),
    array(
        'title' => erTranslationClassLhTranslation::getInstance()->getTranslation('googlebusinessmessage/module', 'New agent')
    )
);

?>
