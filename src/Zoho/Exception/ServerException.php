<?php

namespace Matthewnw\Zoho\Exception;

/**
  * ServerException is thrown if the report server has recieved the request but did not process the request due to some error.
*/
class ServerException extends \Exception
{
    /**
        * @var int The error code sent by the server.
    */
    private $error_code;
    /**
        * @var string The error message sent by the server.
    */
    private $error_message;
    /**
        * @var string The action to be performed over the resource specified by the uri.
    */
    private $action;
    /**
        * @var int The http status code for the request.
    */
    private $HTTP_status_code;

    /**
        * @internal Creates a new Server_Exception instance.
    */

    function __construct($error_code, $error_message, $action, $HTTP_status_code)
    {
        $this->error_code = $error_code;
        $this->error_message = $error_message;
        $this->action = $action;
        $this->HTTP_status_code = $HTTP_status_code;
    }

    /**
        * Get the error message sent by the server.
        * @return string The error message.
    */

    function getErrorMessage()
    {
        return $this->error_message;
    }

    /**
        * Get the error code sent by the server.
        * @return int The error code.
    */

    function getErrorCode()
    {
        return $this->error_code;
    }

    /**
        * Get The action to be performed over the resource specified by the uri.
        * @return string The action.
    */

    function getAction()
    {
        return $this->action;
    }

    /**
        * Get the http status code for the request.
        * @return int The http status code.
    */

    function getHTTPStatusCode()
    {
        return $this->HTTP_status_code;
    }

    /**
        * Get the complete response content as sent by the server.
        * @return string The complete response content.
    */

    function toString()
    {
        $str1 = "HttpStatusCode: $this->HTTP_status_code Error Code: $this->error_code";
        $str2 = "Action: $this->action Error Message: $this->error_message";
        return "ServerException ( ".$str1." ".$str2." )";
    }
}
