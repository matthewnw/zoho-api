<?php

namespace Matthewnw\Zoho\Exception;

/**
 * Error, used to format Exceptions into arrays to output and logs.
 */
class ZohoAPIError {
    /**
        * @var string The error message sent by the server.
    */
    private $context;
    private $errors;
    private $exception;
    private $valid;
    private $error_type;
    private $error_code;

    /**
        * @internal Creates a new Parse_Exception instance.
    */
    function __construct($exception, $context = '')
    {
        if (is_string($exception)){
            $this->exception = new \Exception($exception);
        }else{
            $this->exception = $exception;
        }
        $this->context = $context;
        if ($this->setError()) {
            $this->valid = true;
        }else{
            $this->valid = false;
        }
    }

    private function setError()
    {
        if ($this->exception instanceof ServerException) {
            $this->error_type = 'ServerException';
            $this->error_code = $this->exception->getErrorCode();
            $this->errors = array(
                'error_code' => $this->exception->getErrorCode(),
                'action' => $this->exception->getAction(),
                'http_statuscode' => $this->exception->getHTTPStatusCode(),
                'exception_message' => $this->exception->toString(),
                'error_message' => $this->exception->getErrorMessage(),
            );
        } elseif ($this->exception instanceof IOException) {
            $this->error_type = 'IOException';
            $this->errors['error_message'] = $this->exception->getResponseContent();
        } elseif ($this->exception instanceof ParseException) {
            $this->error_type = 'ParseException';
            $this->errors['error_message'] = $this->exception->getResponseContent();
        } elseif ($this->exception instanceof Exception) {
            $this->error_type = 'Exception';
            $this->errors['error_message'] = $this->exception->getMessage();
        }else{
            return false;
        }
        return true;
    }

    public function getErrorArray()
    {
        if ($this->valid){
            $this->errors['error_context'] = $this->context;
            $this->errors['error_type'] = $this->error_type;
            return $this->errors;
        }
        return false;
    }

    public function getErrorString()
    {
        if ($this->valid){
            $this->errors['error_context'] = $this->context;
            $this->errors['error_type'] = $this->error_type;
            $error_string = '';
            foreach($this->errors as $key => $message){
                $error_string .= "$key - $message\r\n";
            }
            return $error_string;
        }
        return false;
    }
}
