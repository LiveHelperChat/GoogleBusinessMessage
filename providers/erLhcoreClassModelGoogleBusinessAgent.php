<?php

namespace LiveHelperChatExtension\googlebusinessmessage\providers;

class erLhcoreClassModelGoogleBusinessAgent
{
    use \erLhcoreClassDBTrait;

    public static $dbTable = 'lhc_google_business_agent';

    public static $dbTableId = 'id';

    public static $dbSessionHandler = 'erLhcoreClassExtensionGooglebusinessmessage::getSession';

    public static $dbSortOrder = 'DESC';

    public function getState()
    {
        return array(
            'id' => $this->id,
            'name' => $this->name,
            'verify_token' => $this->verify_token,
            'client_token' => $this->client_token,
            'dep_id' => $this->dep_id,
            'brand_id' => $this->brand_id,
            'agent_id' => $this->agent_id
        );
    }

    public function __toString()
    {
        return $this->name;
    }

    public function __get($var)
    {
        switch ($var) {

            default:
                ;
                break;
        }
    }

    public $id = null;
    public $name = '';
    public $verify_token = '';
    public $client_token = '';
    public $dep_id = 0;
    public $brand_id = '';
    public $agent_id = '';
}

?>