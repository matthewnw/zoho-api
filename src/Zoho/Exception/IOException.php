<?php

namespace Matthewnw\Zoho\Exception;

/**
            *IOException is thrown when an input or output operation is failed or interpreted.
*/
class IOException extends \Exception
{
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
        * @internal Creates a new IO_Exception instance.
    */

    function __construct($error_message, $action, $HTTP_status_code)
    {
        $this->error_message = $error_message;
        $this->action = $action;
        $this->HTTP_status_code = $HTTP_status_code;
    }

    /**
        * Get the complete response content as sent by the server.
        * @return string The complete response content.
    */

    function getResponseContent()
    {
        $str1 = "HttpStatusCode: $this->HTTP_status_code ";
        $str2 = "Action: $this->action Error Message: $this->error_message";
        return "IO Exception ( ".$str1." ".$str2." )";
    }
}
