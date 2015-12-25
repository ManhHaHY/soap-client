<?php

namespace Vnpay\SoapClient\Exception;

use Exception;

class VnPayException extends Exception {

    protected $message;
    protected $errorCode;

    public function __construct() {

    }

    function setVnPayExceptionMessage($message) {
        $this->message = $message;
    }

    function getVnPayExceptionMessage() {
        return $this->message;
    }

    function setVnPayExceptionErrorCode($errorCode) {
        $this->errorCode = $errorCode;
    }

    function getVnPayExceptionErrorCode() {
        return $this->errorCode;
    }

}