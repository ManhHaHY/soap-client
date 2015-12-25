<?php

namespace Vnpay\SoapClient\Result;

class GetTransactionResult
{
    protected $transqueryReturn;
    protected $Result;
    protected $RespCode;
    protected $PartnerCode;
    protected $MobileNo;
    protected $Amount;
    protected $LocalDateTime;
    protected $VnPayDateTime;
    protected $Sign;

    /**
     * @return int
     */
    public function getResult()
    {
        return $this->Result;
    }

    /**
     * @return int
     */
    public function getRespCode()
    {
        return $this->RespCode;
    }

    /**
     * @return string
     */
    public function getPartnerCode()
    {
        return $this->PartnerCode;
    }

    /**
     * @return string
     */
    public function getMobileNo()
    {
        return $this->MobileNo;
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
