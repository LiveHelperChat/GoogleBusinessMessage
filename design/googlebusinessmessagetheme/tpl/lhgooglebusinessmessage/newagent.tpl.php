<h1><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('googlebusinessmessage/module','New agent');?></h1>

<?php if (isset($errors)) : ?>
    <?php include(erLhcoreClassDesign::designtpl('lhkernel/validation_error.tpl.php'));?>
<?php endif; ?>

<form action="<?php echo erLhcoreClassDesign::baseurl('googlebusinessmessage/newagent')?>" method="post" ng-non-bindable>

    <?php include(erLhcoreClassDesign::designtpl('lhkernel/csfr_token.tpl.php'));?>

    <?php include(erLhcoreClassDesign::designtpl('lhgooglebusinessmessage/parts/form_agent.tpl.php'));?>

    <div class="btn-group" role="group" aria-label="...">
        <input type="submit" class="btn btn-sm btn-secondary" name="Save_page" value="<?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('system/buttons','Save');?>"/>
        <input type="submit" class="btn btn-sm btn-secondary" name="Cancel_page" value="<?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('system/buttons','Cancel');?>"/>
    </div>

</form>