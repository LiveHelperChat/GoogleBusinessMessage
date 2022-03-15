<div class="form-group">
    <label><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('googlebusinessmessage/module','Name');?></label>
    <input type="text" maxlength="50" class="form-control form-control-sm" name="name" value="<?php echo htmlspecialchars($item->name)?>" />
</div>

<div class="form-group">
    <label><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('googlebusinessmessage/module','Client Token');?></label>
    <input type="text" maxlength="50" class="form-control form-control-sm" name="client_token" value="<?php echo htmlspecialchars($item->client_token)?>" />
</div>

<div class="form-group">
    <label><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('googlebusinessmessage/module','Verify token. Is set automatically on verify call. Just for information purposes.');?></label>
    <input type="text" maxlength="50" readonly class="form-control form-control-sm" name="verify_token" value="<?php echo htmlspecialchars($item->verify_token)?>" />
</div>

<?php if ($incomingWebhook = erLhcoreClassModelChatIncomingWebhook::findOne(['filter' => ['name' => 'GoogleBusinessMessage']])) : ?>
    <div class="form-group">
        <label>Callback URL for Google Business Message</label>
        <input readonly type="text" class="form-control form-control-sm" value="https://<?php echo $_SERVER['HTTP_HOST']?><?php echo erLhcoreClassDesign::baseurl('webhooks/incoming')?>/<?php echo htmlspecialchars($incomingWebhook->identifier)?>">
    </div>
<?php endif; ?>

<div class="form-group">
    <label><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('googlebusinessmessage/module','Brand ID');?></label>
    <input type="text" maxlength="50" class="form-control form-control-sm" name="brand_id" value="<?php echo htmlspecialchars($item->brand_id)?>" />
</div>

<div class="form-group">
    <label><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('googlebusinessmessage/module','Agent ID');?></label>
    <input type="text" maxlength="50" class="form-control form-control-sm" name="agent_id" value="<?php echo htmlspecialchars($item->agent_id)?>" />
</div>

<div class="form-group">
    <label><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('googlebusinessmessage/module','Department');?></label>
    <?php echo erLhcoreClassRenderHelper::renderCombobox(array(
        'input_name'     => 'dep_id',
        'optional_field' => erTranslationClassLhTranslation::getInstance()->getTranslation('chat/lists/search_panel','Select department'),
        'selected_id'    => $item->dep_id,
        'css_class'      => 'form-control form-control-sm',
        'list_function'  => 'erLhcoreClassModelDepartament::getList',
        'list_function_params'  => array(),
    )); ?>
</div>