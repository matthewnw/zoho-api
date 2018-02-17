<?php

namespace Matthewnw\Zoho;

use Matthewnw\Zoho\Exception;
use Matthewnw\Zoho\Exception\ZohoAPIError;

/**
	* Zoho provides the php based language binding to the https based api of Zoho API.
*/
abstract class ZohoClient {
	/**
		* @var string $scope the context of the instance.
	*/
	public $scope;

	public $fixedParams=array();

	/**
		* @var string $zoho_url The base request api URL.
	*/
	public $zoho_url;

	/**
		* @var const ZOHO_API_VERSION It contain the api version.It is a constant one.
	*/
	const ZOHO_API_VERSION = '1.0';

	/**
		* @var string $zoho_action It is action name, that is performed by the URL.
	*/
	public $zoho_action;

	/**
		* @var string $zoho_authtoken It is a unique token that authenticates the user to access the Zoho Account. This is a user-specific and permanent token, that need to be passed along with every Zoho Reports API request.
	*/
	public $zoho_authtoken;

	/**
		* @var boolean $proxy It will indicate wheather the proxy is set or not.
	*/
	public $proxy = FALSE;

	/**
		* @var string $proxy_host The hostname/ip address of the proxy-server.
	*/
	public $proxy_host;

	/**
		* @var int $proxy_port The proxy server port.
	*/
	public $proxy_port;

	/**
		* @var string $proxy_user_name The user name for proxy-server authentication.
	*/
	public $proxy_user_name;

	/**
		* @var string $proxy_password The password for proxy-server authentication.
	*/
	public $proxy_password;

	/**
		* @var string $proxy_type Can be any one ( HTTP , HTTPS , BOTH ).Specify "BOTH" if same configuration can be used for both http and https.
	*/
	public $proxy_type;

	/**
		* @var int $connection_timeout It is a time value until a connection is etablished.
	*/
	public $connection_timeout;

	/**
		* @var int $read_timeout It is a time value until waiting to read data.
	*/
	public $read_timeout;


	/**
		* @internal Creates a new Zoho instance.
	*/
	public function __construct($scope, $path_prefix, $auth_token) {
        $this->scope = $scope;
        $this->zoho_url = $path_prefix;
        $this->zoho_authtoken = $auth_token;
    }


	/**
		* Returns the authtoken of the user.
		* @return string AuthToken.
	*/
	public function getAuthToken()
	{
		return $this->zoho_authtoken;
	}

	/**
		*Internal method for handling special charecters in the table or database name.
		* @param string $string The database or table name containing the special charecters.
	*/
	protected function splCharReplace($string)
	{
		$string = str_replace("%2F", "(/)", $string);
		$string = str_replace("%5C", "(//)", $string);
		return $string;
	}

	/**
		* Used to specify the proxy server details.
		* @param string $proxy_host The hostname/ip address of the proxy-server.
		* @param int $proxy_port The proxy server port.
		* @param string $proxy_type Can be any one ( HTTP , HTTPS , BOTH ).Specify "BOTH" if same configuration can be used for both http and https.
		* @param string $proxy_user_name The user name for proxy-server authentication.
		* @param string $proxy_password The password for proxy-server authentication.
	*/
	public function setProxy($proxy_host, $proxy_port, $proxy_type, $proxy_user_name, $proxy_password)
	{
		$this->proxy = TRUE;
		$this->proxy_host = $proxy_host;
		$this->proxy_port = $proxy_port;
		$this->proxy_user_name = $proxy_user_name;
		$this->proxy_password = $proxy_password;
		$this->proxy_type = $proxy_type;
	}

	/**
		* Sets the timeout until a connection is etablished. A value of zero means the timeout is not used. The default value is 15000.
		* @param int $time_limit An integer value.
	*/
	public function setConnectionTimeout($time_limit)
	{
		$this->connection_timeout = $time_limit;
	}

	/**
		* Sets the timeout until waiting to read data. A value of zero means the timeout is not used. The default value is 15000.
		* @param int $time_limit An integer value.
	*/
	public function setReadTimeout($time_limit)
	{
		$this->read_timeout = $time_limit;
	}

	/**
		* Returns the timeout until a connection is etablished.A value of zero means the timeout is not used.
		* @return int Connection timeout limit.
	*/
	public function getConnectionTimeout()
	{
		return $this->connection_timeout;
	}

	/**
		* Returns the timeout until waiting to read data. A value of zero means the timeout is not used. The default value is 15000.
		* @return int Read timeout limit.
	*/
	public function getReadTimeout()
	{
		return $this->read_timeout;
	}

	/**
	 * Call a request and send to Zoho
	 *
	 * @param $path path suffix for the request
	 * @param array $params
	 * @param $username send optional username as some end points need it prefixed like adding records (https://www.zoho.eu/creator/help/api/rest-api/rest-api-add-records.html)
	 * @return mixed
	 */
	public function call($path, $params = array(), $username = null) {
        $params = array_merge($this->fixedParams, $params);
		$params['authtoken'] = $this->zoho_authtoken;
		$params['scope'] = $this->scope;
		// check for username as some API paths need the username prefix for some stupid reason
		if ($username === null){
			$url = "$this->zoho_url/json/$path";
		}else{
			$url = "$this->zoho_url/$username/json/$path";
		}
        try {
            $request = $this->sendRequest($url, $params, true);
			if ($request == '' || $request == false){
				return new ZohoAPIError('Null request() returned', 'ZohoClient->call()->sendRequest()');
			}
            return $request;
        } catch (\Exception $e) {
			return new ZohoAPIError($e, 'ZohoClient->call()->sendRequest()');
        }
    }

    /**
        * @internal Send request and get response from the server.
        * @return returns a JSON decoded response
        * New function for requests
    */
    protected function sendRequest($request_url, $params, $return_response = true)
    {
		if($this->zoho_action != "IMPORT")
        {
            $params = array_diff($params,array(''));
        }
        $HTTP_request = curl_init();
        curl_setopt($HTTP_request,CURLOPT_URL,$request_url);
        curl_setopt($HTTP_request,CURLOPT_RETURNTRANSFER,TRUE);
        curl_setopt($HTTP_request,CURLOPT_FOLLOWLOCATION,TRUE);
        if(is_array($params))
        {
            curl_setopt($HTTP_request,CURLOPT_POST, 1);
            curl_setopt($HTTP_request,CURLOPT_POSTFIELDS,$params);
        }
        curl_setopt($HTTP_request,CURLOPT_CONNECTTIMEOUT,$this->connection_timeout);
        curl_setopt($HTTP_request,CURLOPT_TIMEOUT,$this->read_timeout);
        if($this->proxy == TRUE)
        {
            curl_setopt($HTTP_request,CURLOPT_PROXY,$this->proxy_host);
            curl_setopt($HTTP_request,CURLOPT_PROXYTYPE,$this->proxy_type);
            curl_setopt($HTTP_request,CURLOPT_PROXYPORT,$this->proxy_port);
            curl_setopt($HTTP_request,CURLOPT_PROXYAUTH, CURLAUTH_BASIC);
            curl_setopt($HTTP_request,CURLOPT_PROXYUSERPWD,"$this->proxy_user_name:$this->proxy_password");
        }
        $HTTP_response = curl_exec($HTTP_request);
        $HTTP_status_code = curl_getinfo($HTTP_request, CURLINFO_HTTP_CODE);

        if($HTTP_response != FALSE)
        {
            if($HTTP_status_code != 200)
            {
                $JSON_response = json_decode($HTTP_response, TRUE);
                if(json_last_error() != JSON_ERROR_NONE)
                {
                    $HTTP_response = stripslashes($HTTP_response);
                    $JSON_response = json_decode($HTTP_response, TRUE);
                }
                if(json_last_error())
                {
                    throw new Exception\ParseException("Returned JSON format for ".$this->zoho_action." is not proper. Could possibly be version mismatch");
                }
                $error_message = $JSON_response['message'];
                $error_code = $JSON_response['code'];
                throw new Exception\ServerException($error_code, $error_message, $this->zoho_action, $HTTP_status_code);
            }
            else
            {
                $action = $this->zoho_action;
                if($action == "EXPORT")
                {
                    return $HTTP_response;
                }
                else if($return_response == true)
                {
                    $JSON_response = json_decode($HTTP_response, TRUE);
                    if(json_last_error() != JSON_ERROR_NONE)
                    {
                        $HTTP_response = stripslashes($HTTP_response);
                        $JSON_response = json_decode($HTTP_response, TRUE);
                    }
                    if(json_last_error() ){
                        throw new Exception\ParseException("Returned JSON format for ".$this->zoho_action." is not proper. Could possibly be version mismatch");
                    }else{
						if(isset($JSON_response['errorlist'])){
							$error_code = $JSON_response['errorlist'][0]['error'][0];
							$error_message = $JSON_response['errorlist'][0]['error'][1];
							throw new Exception\ServerException($error_code, $error_message, $this->zoho_action, $HTTP_status_code);
						}
                        return $JSON_response;
                    }
                }
            }
        }
        else
        {
            throw new Exception\IOException(curl_error($HTTP_request), $this->zoho_action, $HTTP_status_code);
        }
        curl_close($HTTP_request);
    }
}
