<?php

namespace Vnpay\SoapClient\Result;

/**
 * get card result
 */
class GetCardResult
{
    protected $RespCode;
    protected $Trace;
    protected $Amount;
    protected $LocalDateTime;
    protected $VnPayDateTime;
    protected $PinCode;
    protected $Serial;
    protected $Sign;
    protected $ProductCode;

    /**
     * @return string
     */
    public function getRespCode()
    {
        return $this->RespCode;
    }

    /**
     * @return integer
     */
    public function getTrace()
    {
        return $this->Trace;
    }

    /**
     * @return integer
     */
    public function getAmount()
    {
        return $this->Amount;
    }

    /**
     * @return string
     */
    public function getLocalDateTime()
    {
        return $this->LocalDateTime;
    }

    /**
     * @return string
     */
    public function getVnPayDateTime()
    {
        return $this->VnPayDateTime;
    }

    /**
     * @return string
     */
    public function getPinCode()
    {
        return $this->PinCode;
    }

    /**
     * @return string
     */
    public function getSerial()
    {
        return $this->Serial;
    }

    /**
     * @return string
     */
    public function getSign()
    {
        return $this->Sign;
    }

    /**
     * @return string
     */
    public function getProductCode()
    {
        return $this->ProductCode;
    }
}
