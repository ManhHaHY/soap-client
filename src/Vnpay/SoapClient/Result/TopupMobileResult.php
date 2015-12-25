<?php

namespace Vnpay\SoapClient\Result;

/**
 * topup mobile result
 */
class TopupMobileResult
{
    protected $topupReturn;
    protected $RespCode;
    protected $MobileNo;
    protected $Trace;
    protected $Balance;
    protected $Amount;
    protected $LocalDateTime;
    protected $VnPayDateTime;
    protected $Sign;

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
    public function getSign()
    {
        return $this->Sign;
    }
}
