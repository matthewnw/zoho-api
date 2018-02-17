<?php

namespace Matthewnw\Zoho\Creator;

use Matthewnw\Zoho\ZohoClient;
use Matthewnw\Zoho\Exception\ZohoAPIError;

/**
	* ZohoCreator provides the php based language binding to the https based api of ZohoCreator.
*/

class ZohoCreatorClient extends ZohoClient {

	protected $applications = array();

	public function __construct($auth_token)
	{
        parent::__construct('creatorapi', 'https://creator.zoho.com/api', $auth_token);
	}

	public function application($name) {
        if (!array_key_exists($name, $this->applications)) {
            $this->applications[$name] = new ZohoApplication($name, $this);
        }
        return $this->applications[$name];
    }

	/**
     * @see https://www.zoho.eu/creator/help/api/rest-api/rest-api-list-applications.html
     */
    public function getApplications() {
        $response = $this->call('applications');
        if (! $response instanceOf ZohoAPIError){
            $this->applications = $response['result']['application_list']['applications'][0]['application'];
        }
        return $response;
    }
}
