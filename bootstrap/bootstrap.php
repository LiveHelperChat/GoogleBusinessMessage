<?php
#[\AllowDynamicProperties]
class erLhcoreClassExtensionGooglebusinessmessage
{

    public function __construct()
    {

    }

    public function run()
    {

        $dispatcher = erLhcoreClassChatEventDispatcher::getInstance();

        $dispatcher->listen('chat.webhook_incoming', array(
            $this,
            'verifyCall'
        ));

        $dispatcher->listen('chat.webhook_incoming_chat_started', array(
            $this,
            'webhookChatStarted'
        ));

        $dispatcher->listen('chat.rest_api_before_request', array(
            $this,
            'addVariables'
        ));

        $dispatcher->listen('chat.rest_api_make_request', array(
            $this,
            'makeRequest'
        ));

        $dispatcher->listen('instance.extensions_structure', array(
            $this,
            'checkStructure'
        ));

        $dispatcher->listen('instance.registered.created', array(
            $this,
            'instanceCreated'
        ));

        $dispatcher->listen('instance.destroyed', array(
            $this,
            'instanceDestroyed'
        ));

    }

    public function webhookChatStarted($params)
    {
        if ($params['webhook']->scope == 'googlebusinessmessage') {
            $agentId = explode('agents/',$params['data']['agent'])[1];
            $agent = \LiveHelperChatExtension\googlebusinessmessage\providers\erLhcoreClassModelGoogleBusinessAgent::findOne(['filter' => ['agent_id' => $agentId]]);
            if (is_object($agent)) {
                $params['chat']->dep_id = $agent->dep_id;
                $params['chat']->updateThis(['update' => ['dep_id']]);
            }
        }
    }

    public function makeRequest($params)
    {
        if (is_object($params['params_customer']['chat']->incoming_chat) && $params['params_customer']['chat']->incoming_chat->incoming->scope == 'googlebusinessmessage') {
            include_once 'extension/googlebusinessmessage/vendor/autoload.php';

            // create the Google client
            $client = new Google\Client();

            /**
             * Set your method for authentication. Depending on the API, This could be
             * directly with an access token, API key, or (recommended) using
             * Application Default Credentials.
             */
            $client->useApplicationDefaultCredentials();

            $dataGoogle = include('extension/googlebusinessmessage/settings/google_service.json.php');
            $client->setAuthConfig(json_decode($dataGoogle, true));
            $client->addScope('https://www.googleapis.com/auth/businessmessages');

            // returns a Guzzle HTTP Client
            $httpClient = $client->authorize();

            $messageParams = json_decode($params['params_request']['body'], true);

            if (isset($messageParams['text']) && $messageParams['text'] != '') {
                $text = $messageParams['text'];
                erLhcoreClassChatEventDispatcher::getInstance()->dispatch('chat.make_plain_message', array(
                    'init' => 'googlebusinessmessage',
                    'msg' => & $text
                ));
                $messageParams['text'] = $text;
                $messageParams['fallback'] = $text;
            }

            $response = $httpClient->post($params['url'], [
                GuzzleHttp\RequestOptions::JSON => $messageParams
            ]);

            return [
                'status' => erLhcoreClassChatEventDispatcher::STOP_WORKFLOW,
                'processed' => true,
                'http_response' => (string)$response->getBody(),
                'http_error' => '',
                'http_code' => $response->getStatusCode(),
            ];
        }
    }

    public function addVariables($params)
    {
        if (is_object($params['chat']->incoming_chat) && $params['chat']->incoming_chat->incoming->scope == 'googlebusinessmessage') {
            $params['chat']->dynamic_array = [];
            $params['chat']->dynamic_array['uuidv4'] = vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex(random_bytes(16)), 4));

            if (isset($_SERVER['HTTP_HOST'])) {
                $site_address = (erLhcoreClassSystem::$httpsMode == true ? 'https:' : 'http:') . '//' . $_SERVER['HTTP_HOST'];
            } else {
                if (class_exists('erLhcoreClassInstance')) {
                    $site_address = 'https://' . erLhcoreClassInstance::$instanceChat->address . '.' . erConfigClassLhConfig::getInstance()->getSetting('site', 'seller_domain');
                } else {
                    $site_address = erLhcoreClassModule::getExtensionInstance('erLhcoreClassExtensionLhcphpresque')->settings['site_address'];
                }
            }

            $avatarImage = '';
            $representative = 'BOT';

            if (isset($params['params']['msg']) && $params['params']['msg']->user_id > 0) {
                $representative = 'HUMAN';
                /*$user = erLhcoreClassModelUser::fetch($params['params']['msg']->user_id);
                if (is_object($user) && $user->has_photo) {
                    $avatarImage = ($user->filepath != '' ? $site_address . erLhcoreClassSystem::instance()->wwwDir() : erLhcoreClassSystem::instance()->wwwImagesDir() ) .'/'. $user->filepath . $user->filename;
                }*/
            }

            /*if (empty($avatarImage)) {
                if ($params['chat']->status == erLhcoreClassModelChat::STATUS_BOT_CHAT && is_object($params['chat']->bot) && $params['chat']->bot->has_photo) {
                    $avatarImage = ($params['chat']->bot->filepath != '' ? $site_address . erLhcoreClassSystem::instance()->wwwDir() : erLhcoreClassSystem::instance()->wwwImagesDir() ) .'/'. $params['chat']->bot->filepath . $params['chat']->bot->filename;
                }
            }

            if (empty($avatarImage)) {
                $avatarImage = $site_address . erLhcoreClassDesign::design('images/g-logo.png');
            }*/

            // Other avatar images just don't work.
            $avatarImage = 'https://developers.google.com/identity/images/g-logo.png';

            $params['chat']->dynamic_array['avatarImage'] = $avatarImage;
            $params['chat']->dynamic_array['representativeType'] = $representative;
        }
    }

    /*
     * During integration process to intercept request and verify it.
     * */
    public function verifyCall($params)
    {
        if (
            isset($params['data']['clientToken']) && ($agent = \LiveHelperChatExtension\googlebusinessmessage\providers\erLhcoreClassModelGoogleBusinessAgent::findOne(['filter' => ['client_token' => $params['data']['clientToken']]])) && is_object($agent) &&
            isset($params['data']['secret'])
        ) {
            $agent->verify_token = $params['data']['secret'];
            $agent->updateThis(['update' => ['verify_token']]);
            echo $params['data']['secret'];
            exit;
        }
    }

    /**
     * Checks automated hosting structure
     *
     * This part is executed once in manager is run this cronjob.
     * php cron.php -s site_admin -e instance -c cron/extensions_update
     *
     * */
    public function checkStructure()
    {
        erLhcoreClassUpdate::doTablesUpdate(json_decode(file_get_contents('extension/googlebusinessmessage/doc/structure.json'), true));
    }


    /**
     * Used only in automated hosting enviroment
     */
    public function instanceDestroyed($params)
    {
        // Set subdomain manual, so we avoid calling in cronjob
        $this->instanceManual = $params['instance'];
    }

    /**
     * Used only in automated hosting enviroment
     */
    public function instanceCreated($params)
    {
        try {
            // Instance created trigger
            $this->instanceManual = $params['instance'];

            // Just do table updates
            erLhcoreClassUpdate::doTablesUpdate(json_decode(file_get_contents('extension/googlebusinessmessage/doc/structure.json'), true));

        } catch (Exception $e) {
            erLhcoreClassLog::write(print_r($e, true));
        }
    }

    public static function getSession()
    {
        if (!isset (self::$persistentSession)) {
            self::$persistentSession = new ezcPersistentSession (ezcDbInstance::get(), new ezcPersistentCodeManager ('./extension/googlebusinessmessage/pos'));
        }
        return self::$persistentSession;
    }

    public function __get($var)
    {
        switch ($var) {
            /*case 'settings' :
                $this->settings = include ('extension/googlebusinessmessage/settings/settings.ini.php');
                return $this->settings;*/

            default :
                ;
                break;
        }
    }

    private static $persistentSession;

    private $instanceManual = false;
}


