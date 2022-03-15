<?php

$tpl = erLhcoreClassTemplate::getInstance('lhgooglebusinessmessage/activation.tpl.php');

if (ezcInputForm::hasPostData()) {

    if (!isset($_POST['csfr_token']) || !$currentUser->validateCSFRToken($_POST['csfr_token'])) {
        erLhcoreClassModule::redirect('googlebusinessmessage/activation');
        exit;
    }

    if (isset($_POST['InstallGBC'])) {
        LiveHelperChatExtension\googlebusinessmessage\providers\erLhcoreClassGoogleBusinessValidator::installOrUpdate();
    }

    if (isset($_POST['RemoveGBC'])) {
        LiveHelperChatExtension\googlebusinessmessage\providers\erLhcoreClassGoogleBusinessValidator::remove();
    }

    $tpl->set('updated','done');
}

$Result['content'] = $tpl->fetch();

$Result['path'] = array(
    array(
        'url' => erLhcoreClassDesign::baseurl('googlebusinessmessage/index'),
        'title' => erTranslationClassLhTranslation::getInstance()->getTranslation('googlebusinessmessage/module', 'Google Business Message')
    ),
    array(
        'title' => erTranslationClassLhTranslation::getInstance()->getTranslation('googlebusinessmessage/module','Activation')
    )
);

?>