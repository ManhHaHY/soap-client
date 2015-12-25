<?php

namespace Vnpay\SoapClient\Result;

class VnPayResult {

    protected $message;
    protected $statusCode;

    public function __construct() {

    }

    /**
     * @param $message
     */
    function setMessage($message) {
        $this->message = $message;
    }

    /**
     * @return string
     */
    function getMessage() {
        return $this->message;
    }

    /**
     * @param $statusCode
     */
    function setStatusCode($statusCode) {
        $this->statusCode = $statusCode;
    }

    /**
     * @return string
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

}

?>
