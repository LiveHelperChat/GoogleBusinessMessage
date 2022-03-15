<?php
/**
 * php cron.php -s site_admin -e googlebusinessmessage -c cron/export_configuration
 * */

if ($incomingWebhook = erLhcoreClassModelChatIncomingWebhook::findOne(['filter' => ['name' => 'GoogleBusinessMessage']])) {
    $state = $incomingWebhook->getState();
    $state['dep_id'] = 1;
    unset($state['id']);
    file_put_contents('extension/googlebusinessmessage/doc/incoming-webhook.json', json_encode($state, JSON_PRETTY_PRINT));
}

if ($restAPI = erLhcoreClassModelGenericBotRestAPI::findOne(['filter' => ['name' => 'GoogleBusinessMessage']])) {
    $state = $restAPI->getState();
    unset($state['id']);
    file_put_contents('extension/googlebusinessmessage/doc/rest-api.json', json_encode($state, JSON_PRETTY_PRINT));
}

if ($bot = erLhcoreClassModelGenericBotBot::findOne(['filter' => ['name' => 'GBusinessMessage']])) {
    $exportBot = erLhcoreClassGenericBotValidator::exportBot($bot);
    file_put_contents('extension/googlebusinessmessage/doc/bot-data.json', json_encode($exportBot, JSON_PRETTY_PRINT));

    if ($event = erLhcoreClassModelChatWebhook::findOne(['filter' => ['event' => ['chat.desktop_client_admin_msg', 'bot_id' => $bot->id]]])) {
        $state = $event->getState();
        unset($state['id']);
        file_put_contents('extension/googlebusinessmessage/doc/chat.desktop_client_admin_msg.json', json_encode($state, JSON_PRETTY_PRINT));
    }

    if ($event = erLhcoreClassModelChatWebhook::findOne(['filter' => ['event' => ['chat.workflow.canned_message_before_save', 'bot_id' => $bot->id]]])) {
        $state = $event->getState();
        unset($state['id']);
        file_put_contents('extension/googlebusinessmessage/doc/chat.workflow.canned_message_before_save.json', json_encode($state, JSON_PRETTY_PRINT));
    }

    if ($event = erLhcoreClassModelChatWebhook::findOne(['filter' => ['event' => ['chat.web_add_msg_admin', 'bot_id' => $bot->id]]])) {
        $state = $event->getState();
        unset($state['id']);
        file_put_contents('extension/googlebusinessmessage/doc/chat.web_add_msg_admin.json', json_encode($state, JSON_PRETTY_PRINT));
    }
}



?>