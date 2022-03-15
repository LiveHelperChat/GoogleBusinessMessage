<?php
$tpl = erLhcoreClassTemplate::getInstance('lhgooglebusinessmessage/index.tpl.php');

$Result['content'] = $tpl->fetch();

$Result['path'] = array(
    array(
        'url' => erLhcoreClassDesign::baseurl('googlebusinessmessage/index'),
        'title' => erTranslationClassLhTranslation::getInstance()->getTranslation('googlebusinessmessage/module','Google Business Message')
    )
);

?>