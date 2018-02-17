<?php

namespace Matthewnw\Zoho\Exception;

/**
    * ParseException is thrown if the server has responded but client was not able to parse the response. Possible reasons could be version mismatch.The client might have to be updated to a newer version.
*/

class ParseException extends \Exception
{
    /**
        * @var string The error message sent by the server.
    */
    private $error_message;

    /**
        * @internal Creates a new Parse_Exception instance.
    */

    function __construct($error_message)
    {
        $this->error_message = $error_message;
    }

    /**
        * Get the complete response content as sent by the server.
        * @return string The complete response content.
    */

    function getResponseContent()
    {
        return "Error Message : $this->error_message";
    }
}
