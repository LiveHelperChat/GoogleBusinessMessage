<?php

namespace LiveHelperChatExtension\googlebusinessmessage\providers;

class erLhcoreClassGoogleBusinessValidator
{
    public static function validateAgent(& $item)
    {
        $definition = array(
            'name' => new \ezcInputFormDefinitionElement(
                \ezcInputFormDefinitionElement::OPTIONAL, 'unsafe_raw'
            ),
            'client_token' => new \ezcInputFormDefinitionElement(
                \ezcInputFormDefinitionElement::OPTIONAL, 'unsafe_raw'
            ),
            'agent_id' => new \ezcInputFormDefinitionElement(
                \ezcInputFormDefinitionElement::OPTIONAL, 'unsafe_raw'
            ),
            'brand_id' => new \ezcInputFormDefinitionElement(
                \ezcInputFormDefinitionElement::OPTIONAL, 'unsafe_raw'
            ),
            'dep_id' => new \ezcInputFormDefinitionElement(
                \ezcInputFormDefinitionElement::OPTIONAL, 'int', array('min_range' => 1)
            )
        );

        $form = new \ezcInputForm( INPUT_POST, $definition );
        $Errors = array();

        if ( $form->hasValidData( 'name' ) && $form->name != '')
        {
            $item->name = $form->name;
        } else {
            $Errors[] = \erTranslationClassLhTranslation::getInstance()->getTranslation('xmppservice/operatorvalidator','Please enter page name!');
        }

        if ( $form->hasValidData( 'client_token' ) && $form->client_token != '')
        {
            $item->client_token = $form->client_token;
        } else {
            $Errors[] = \erTranslationClassLhTranslation::getInstance()->getTranslation('xmppservice/operatorvalidator','Please enter Client Token!');
        }

        if ( $form->hasValidData( 'agent_id' ) && $form->agent_id != '')
        {
            $item->agent_id = $form->agent_id;
        }

        if ( $form->hasValidData( 'brand_id' ) && $form->brand_id != '')
        {
            $item->brand_id = $form->brand_id;
        }

        if ( $form->hasValidData( 'dep_id' ))
        {
            $item->dep_id = $form->dep_id;
        } else {
            $Errors[] = \erTranslationClassLhTranslation::getInstance()->getTranslation('xmppservice/operatorvalidator','Please choose a department!');
        }

        return $Errors;
    }

    public static function remove()
    {
        if ($incomingWebhook = \erLhcoreClassModelChatIncomingWebhook::findOne(['filter' => ['name' => 'GoogleBusinessMessage']])) {
            $incomingWebhook->removeThis();
        }

        if ($restAPI = \erLhcoreClassModelGenericBotRestAPI::findOne(['filter' => ['name' => 'GoogleBusinessMessage']])) {
            $restAPI->removeThis();
        }

        if ($botPrevious = \erLhcoreClassModelGenericBotBot::findOne(['filter' => ['name' => 'GBusinessMessage']])) {
            $botPrevious->removeThis();

            if ($event = \erLhcoreClassModelChatWebhook::findOne(['filter' => ['event' => ['chat.desktop_client_admin_msg', 'bot_id' => $botPrevious->id]]])) {
                $event->removeThis();
            }

            if ($event = \erLhcoreClassModelChatWebhook::findOne(['filter' => ['event' => ['chat.workflow.canned_message_before_save', 'bot_id' => $botPrevious->id]]])) {
                $event->removeThis();
            }

            if ($event = \erLhcoreClassModelChatWebhook::findOne(['filter' => ['event' => ['chat.web_add_msg_admin', 'bot_id' => $botPrevious->id]]])) {
                $event->removeThis();
            }
        }
    }

    public static function installOrUpdate()
    {
        // GoogleBusinessMessage
        $incomingWebhook = \erLhcoreClassModelChatIncomingWebhook::findOne(['filter' => ['name' => 'GoogleBusinessMessage']]);
        $content = json_decode(file_get_contents('extension/googlebusinessmessage/doc/incoming-webhook.json'),true);

        if (!$incomingWebhook) {
            $incomingWebhook = new \erLhcoreClassModelChatIncomingWebhook();
            $incomingWebhook->setState($content);
            $incomingWebhook->dep_id = 1;
            $incomingWebhook->identifier = \erLhcoreClassModelForgotPassword::randomPassword(20);
        } else {
            $dep_id = $incomingWebhook->dep_id;
            $identifier = $incomingWebhook->identifier;
            $incomingWebhook->setState($content);
            $incomingWebhook->dep_id = $dep_id;
            $incomingWebhook->identifier = $identifier;
        }
        $incomingWebhook->saveThis();

        // RestAPI
        $restAPI = \erLhcoreClassModelGenericBotRestAPI::findOne(['filter' => ['name' => 'GoogleBusinessMessage']]);
        $content = json_decode(file_get_contents('extension/googlebusinessmessage/doc/rest-api.json'),true);

        if (!$restAPI) {
            $restAPI = new \erLhcoreClassModelGenericBotRestAPI();
        }

        $restAPI->setState($content);
        $restAPI->saveThis();

        if ($botPrevious = \erLhcoreClassModelGenericBotBot::findOne(['filter' => ['name' => 'GBusinessMessage']])) {
            $botPrevious->removeThis();
        }

        $botData = \erLhcoreClassGenericBotValidator::importBot(json_decode(file_get_contents('extension/googlebusinessmessage/doc/bot-data.json'),true));
        $botData['bot']->name = 'GBusinessMessage';
        $botData['bot']->updateThis(['update' => ['name']]);

        $trigger = $botData['triggers'][0];
        $actions = $trigger->actions_front;
        $actions[0]['content']['rest_api'] = $restAPI->id;
        $trigger->actions_front = $actions;
        $trigger->actions = json_encode($actions);
        $trigger->updateThis(['update' => ['actions']]);

        if ($botPrevious && $event = \erLhcoreClassModelChatWebhook::findOne(['filter' => ['event' => ['chat.desktop_client_admin_msg', 'bot_id' => $botPrevious->id]]])) {
            $event->removeThis();
        }
        $event = new \erLhcoreClassModelChatWebhook();
        $event->setState(json_decode(file_get_contents('extension/googlebusinessmessage/doc/chat.desktop_client_admin_msg.json'),true));
        $event->bot_id = $botData['bot']->id;
        $event->trigger_id = $trigger->id;
        $event->saveThis();

        if ($botPrevious && $event = \erLhcoreClassModelChatWebhook::findOne(['filter' => ['event' => ['chat.workflow.canned_message_before_save', 'bot_id' => $botPrevious->id]]])) {
            $event->removeThis();
        }
        $event = new \erLhcoreClassModelChatWebhook();
        $event->setState(json_decode(file_get_contents('extension/googlebusinessmessage/doc/chat.workflow.canned_message_before_save.json'),true));
        $event->bot_id = $botData['bot']->id;
        $event->trigger_id = $trigger->id;
        $event->saveThis();

        if ($botPrevious && $event = \erLhcoreClassModelChatWebhook::findOne(['filter' => ['event' => ['chat.web_add_msg_admin', 'bot_id' => $botPrevious->id]]])) {
            $event->removeThis();
        }
        $event = new \erLhcoreClassModelChatWebhook();
        $event->setState(json_decode(file_get_contents('extension/googlebusinessmessage/doc/chat.web_add_msg_admin.json'),true));
        $event->bot_id = $botData['bot']->id;
        $event->trigger_id = $trigger->id;
        $event->saveThis();
    }
}

?>