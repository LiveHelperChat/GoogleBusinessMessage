<h1><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('googlebusinessmessage/module','Agent list');?></h1>

<?php if (isset($items)) : ?>
    <table cellpadding="0" cellspacing="0" class="table table-sm" width="100%" ng-non-bindable>
        <thead>
        <tr>
            <th width="1%"><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('googlebusinessmessage/module','ID');?></th>
            <th><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('googlebusinessmessage/module','Name');?></th>
            <th><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('googlebusinessmessage/module','Verify Token');?></th>
            <th><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('googlebusinessmessage/module','Client Token');?></th>
            <th width="1%"></th>
        </tr>
        </thead>
        <?php foreach ($items as $item) : ?>
            <tr>
                <td><?php echo htmlspecialchars($item->id) ?></td>
                <td>
                    <?php echo htmlspecialchars($item->name)?>
                </td>
                <td>
                    <?php echo htmlspecialchars($item->verify_token)?>
                </td>
                <td>
                    <?php echo htmlspecialchars($item->client_token)?>
                </td>
                <td>
                    <div class="btn-group" role="group" aria-label="..." style="width:60px;">
                        <a class="btn btn-secondary btn-xs" href="<?php echo erLhcoreClassDesign::baseurl('googlebusinessmessage/editagent')?>/<?php echo $item->id?>" ><i class="material-icons mr-0">&#xE254;</i></a>
                        <a class="btn btn-danger btn-xs csfr-required" onclick="return confirm('<?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('kernel/messages','Are you sure?');?>')" href="<?php echo erLhcoreClassDesign::baseurl('googlebusinessmessage/deleteagent')?>/<?php echo $item->id?>" ><i class="material-icons mr-0">&#xE872;</i></a>
                    </div>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>

    <?php include(erLhcoreClassDesign::designtpl('lhkernel/secure_links.tpl.php')); ?>

    <?php if (isset($pages)) : ?>
        <?php include(erLhcoreClassDesign::designtpl('lhkernel/paginator.tpl.php')); ?>
    <?php endif;?>
<?php endif; ?>

<a href="<?php echo erLhcoreClassDesign::baseurl('googlebusinessmessage/newagent')?>" class="btn btn-sm btn-secondary"><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('googlebusinessmessage/module','New agent');?></a>