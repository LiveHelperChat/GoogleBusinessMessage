<h1><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('cloudtalkio/admin','Google Business Message Activation');?></h1>
<div ng-non-bindable>

<?php if (isset($errors)) : ?>
    <?php include(erLhcoreClassDesign::designtpl('lhkernel/validation_error.tpl.php'));?>
<?php endif; ?>

<?php if (isset($updated)) : $msg = erTranslationClassLhTranslation::getInstance()->getTranslation('user/account','Updated'); ?>
    <?php include(erLhcoreClassDesign::designtpl('lhkernel/alert_success.tpl.php'));?>
<?php endif; ?>

<p>Once it's activate we will create necessary dependencies. Rest API, Bot and Incoming web hook configuration.</p>

<p>You will see what information you have to put</p>

<h5>Incomming webhook</h5>
<?php if ($incomingWebhook = erLhcoreClassModelChatIncomingWebhook::findOne(['filter' => ['name' => 'GoogleBusinessMessage']])) : ?>
    <p class="text-success">Exists</p>
    <div class="form-group">
        <label>Callback URL for Google Business Message</label>
        <input readonly type="text" class="form-control form-control-sm" value="https://<?php echo $_SERVER['HTTP_HOST']?><?php echo erLhcoreClassDesign::baseurl('webhooks/incoming')?>/<?php echo htmlspecialchars($incomingWebhook->identifier)?>">
    </div>
<?php else : ?>
    <p class="text-danger">Missing</p>
<?php endif; ?>

<h5>Rest API configuration</h5>
<?php if (erLhcoreClassModelGenericBotRestAPI::getCount(['filter' => ['name' => 'GoogleBusinessMessage']]) > 0) : ?>
    <p class="text-success">Exists</p>
<?php else : ?>
    <p class="text-danger">Missing</p>
<?php endif; ?>

<h5>Bot Configuration</h5>
<?php if ($bot = erLhcoreClassModelGenericBotBot::findOne(['filter' => ['name' => 'GBusinessMessage']])) : ?>
    <p class="text-success">Exists</p>
<?php else : ?>
    <p class="text-danger">Missing</p>
<?php endif; ?>

<h5>Event listeners</h5>
<?php if ($bot && erLhcoreClassModelChatWebhook::findOne(['filter' => ['event' => ['chat.desktop_client_admin_msg', 'bot_id' => $bot->id]]])) : ?>
    <p class="text-success">chat.desktop_client_admin_msg</p>
<?php else : ?>
    <p class="text-danger">chat.desktop_client_admin_msg</p>
<?php endif; ?>

<?php if ($bot && erLhcoreClassModelChatWebhook::findOne(['filter' => ['event' => ['chat.web_add_msg_admin', 'bot_id' => $bot->id]]])) : ?>
    <p class="text-success">chat.web_add_msg_admin</p>
<?php else : ?>
    <p class="text-danger">chat.web_add_msg_admin</p>
<?php endif; ?>

<?php if ($bot && erLhcoreClassModelChatWebhook::findOne(['filter' => ['event' => ['chat.workflow.canned_message_before_save', 'bot_id' => $bot->id]]])) : ?>
    <p class="text-success">chat.workflow.canned_message_before_save</p>
<?php else : ?>
    <p class="text-danger">chat.workflow.canned_message_before_save</p>
<?php endif; ?>

<form action="" method="post">

    <?php include(erLhcoreClassDesign::designtpl('lhkernel/csfr_token.tpl.php'));?>

    <div class="btn-group" role="group" aria-label="...">
        <input type="submit" class="btn btn-sm btn-success" name="InstallGBC" value="<?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('system/buttons','Install/Update');?>"/>
        <input type="submit" class="btn btn-sm btn-danger" name="RemoveGBC" value="<?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('system/buttons','Remove');?>"/>
    </div>

</form>
</div>