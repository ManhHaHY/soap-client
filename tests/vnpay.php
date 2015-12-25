<?php

use Vnpay\SoapClient\Result\VnPayResult;
use Vnpay\SoapClient\Exception\VnPayException;

class Vnpay {

    protected $builder = null;
    protected $encryption = null;
    protected $partnerCode = ''; //change your "PartnerCode"
    protected $localDateTimeStr = null;
    protected $trace = null;

    public function __construct($log = false)
    {
        $publicKey = openssl_get_publickey('file:///'.BASE_DIR.'private/dev/VNPAY_publicKey_test.pem');
        $privateKey = openssl_get_privatekey('file:///'.BASE_DIR.'private/dev/API_privateKey_test.pem');

        $builder = new Vnpay\SoapClient\ClientBuilder(
            'private/wsdl/VnpSrv_TopupAirtime.asmx.xml'
        );

        $this->encryption = new Vht\Common\Encryption($publicKey, $privateKey);

        if ($log) {
            $log = new Monolog\Logger('vnpay');
            $log->pushHandler(new Monolog\Handler\StreamHandler(BASE_DIR.'logs/'.date("Ymd_H-i").'.log'));
            $this->builder = $builder->withLog($log)->build();
        } else {
            $this->builder = $builder->build();
        }

        $localDateTime = new \DateTime();
        $this->localDateTimeStr = $localDateTime->format('YmdHis');
        $this->trace = rand(10,99).$localDateTime->format('hi');
    }

    /**
     * @return mixed
     */
    public function helloWorld()
    {
        return $this->builder->helloWorld()->HelloWorldResult;
    }

    /**
     * @return VnPayResult
     * @throws VnPayException
     */
    public function getBalance()
    {
        $sign = $this->encryption->generateSignRSA("$this->partnerCode-$this->localDateTimeStr");

        $result = $this->builder->getBalance($this->partnerCode, $this->localDateTimeStr, $sign);

        $balanceReturn = $result->GetBalanceResult->balanceReturn;
        $dataSign = $balanceReturn->Result.'-'.$balanceReturn->PartnerCode.'-'.$balanceReturn->Balance.'-'.$balanceReturn->VnPayDateTime;

        $toSign = $this->encryption->verifyHexSignRSA($dataSign, end($balanceReturn));
        if ($toSign) {
            $vnPayResult = new VnPayResult();
            $vnPayResult->setMessage($balanceReturn->Balance);
            $vnPayResult->setStatusCode($balanceReturn->Result);

            return $vnPayResult;
        } else {
            $vnPayExcep = new VnPayException();
            $vnPayExcep->setVnPayExceptionErrorCode(500);

            throw $vnPayExcep;
        }
    }

    /**
     * @param $mobileNo
     * @param $amount
     *
     * @return VnPayResult
     * @throws VnPayException
     */
    public function topupMobile($mobileNo, $amount)
    {
        $sign = $this->encryption->generateSignRSA("$mobileNo-$amount-$this->trace-$this->localDateTimeStr-$this->partnerCode");

        $result = $this->builder->topupMobile($mobileNo, $amount, $this->trace, $this->localDateTimeStr, $this->partnerCode, $sign);

        $topupReturn = $result->TopupMobileResult->topupReturn;
        $dataSign = $topupReturn->RespCode.'-'.
                    $topupReturn->MobileNo.'-'.
                    $topupReturn->Trace.'-'.
                    $topupReturn->Balance.'-'.
                    $topupReturn->Amount.'-'.
                    $topupReturn->LocalDateTime.'-'.
                    $topupReturn->VnPayDateTime;

        $toSign = $this->encryption->verifyHexSignRSA($dataSign, end($topupReturn));
        if ($toSign) {
            $vnPayResult = new VnPayResult();
            $vnPayResult->setMessage($dataSign);
            $vnPayResult->setStatusCode($topupReturn->RespCode);

            return $vnPayResult;
        } else {
            $vnPayExcep = new VnPayException();
            $vnPayExcep->setVnPayExceptionErrorCode(500);

            throw $vnPayExcep;
        }
    }

    /**
     * @param $productCode
     * @param $amount
     *
     * @return VnPayResult
     * @throws VnPayException
     */
    public function getCard($productCode, $amount)
    {
        $sign = $this->encryption->generateSignRSA("$this->partnerCode-$productCode-$this->trace-$amount-$this->localDateTimeStr");

        $result = $this->builder->getCard($this->partnerCode, $productCode, $amount, $this->trace, $this->localDateTimeStr, $sign);

        $getCardResult = $result->GetCardResult;

        $dataSign = $getCardResult->RespCode;
        if (isset($getCardResult->ProductCode))
            $dataSign .= '-'.$getCardResult->ProductCode;
        $dataSign .= '-'.$getCardResult->Amount.'-'.
                        $getCardResult->LocalDateTime.'-'.
                        $getCardResult->VnPayDateTime.'-'.
                        $getCardResult->Trace;
        if (isset($getCardResult->Serial))
            $dataSign .= '-'.$getCardResult->Serial;
        if (isset($getCardResult->PinCode))
            $dataSign .= '-'.$getCardResult->PinCode;

        $toSign = $this->encryption->verifyHexSignRSA($dataSign, $getCardResult->Sign);
        if ($toSign) {
            $vnPayResult = new VnPayResult();
            $vnPayResult->setMessage($dataSign);
            $vnPayResult->setStatusCode($getCardResult->RespCode);

            return $vnPayResult;
        } else {
            $vnPayExcep = new VnPayException();
            $vnPayExcep->setVnPayExceptionErrorCode(500);

            throw $vnPayExcep;
        }
    }

    /**
     * @param $productCode
     * @param $amount
     * @param $mobileNo
     *
     * @return VnPayResult
     * @throws VnPayException
     */
    public function getCardToMobile($productCode, $amount, $mobileNo)
    {
        $sign = $this->encryption->generateSignRSA("$this->partnerCode-$productCode-$amount-$this->trace-$mobileNo-$this->localDateTimeStr");

        $result = $this->builder->getCardToMobile($this->partnerCode, $productCode, $amount, $this->trace, $mobileNo, $this->localDateTimeStr, $sign);

        $getCardToMobileResult = $result->GetCardToMobileResult;
        $dataSign = $getCardToMobileResult->RespCode.'-'.$getCardToMobileResult->Trace;
        if (isset($getCardToMobileResult->PinCode))
            $dataSign .= '-'.$getCardToMobileResult->PinCode;
        if (isset($getCardToMobileResult->Serial))
            $dataSign .= '-'.$getCardToMobileResult->Serial;
        $dataSign .= '-'.$getCardToMobileResult->Amount.'-'.$getCardToMobileResult->LocalDateTime.'-'.$getCardToMobileResult->VnPayDateTime;
        if (isset($getCardToMobileResult->ProductCode))
            $dataSign .= '-'.$getCardToMobileResult->ProductCode;

        $toSign = $this->encryption->verifyHexSignRSA($dataSign, $getCardToMobileResult->Sign);
        if ($toSign) {
            $vnPayResult = new VnPayResult();
            $vnPayResult->setMessage($dataSign);
            $vnPayResult->setStatusCode($getCardToMobileResult->RespCode);

            return $vnPayResult;
        } else {
            $vnPayExcep = new VnPayException();
            $vnPayExcep->setVnPayExceptionErrorCode(500);

            throw $vnPayExcep;
        }
    }

    /**
     * @param $trace
     *
     * @return VnPayResult
     * @throws VnPayException
     */
    public function getTransaction($trace)
    {
        $sign = $this->encryption->generateSignRSA("$this->partnerCode-$trace-$this->localDateTimeStr");

        $result = $this->builder->getTransaction($this->partnerCode, $trace, $this->localDateTimeStr, $sign);

        $transQueryReturn = $result->GetTransactionResult->transqueryReturn;
        $dataSign = $transQueryReturn->Result.'-'.$transQueryReturn->RespCode.'-'.$transQueryReturn->PartnerCode.'-'.
                    $transQueryReturn->MobileNo.'-'.$transQueryReturn->Amount.'-'.$transQueryReturn->VnPayDateTime;

        $toSign = $this->encryption->verifyHexSignRSA($dataSign, end($transQueryReturn));
        if ($toSign) {
            $vnPayResult = new VnPayResult();
            $vnPayResult->setMessage($dataSign);
            $vnPayResult->setStatusCode($transQueryReturn->Result);

            return $vnPayResult;
        } else {
            $vnPayExcep = new VnPayException();
            $vnPayExcep->setVnPayExceptionErrorCode(500);

            throw $vnPayExcep;
        }
    }

    /**
     * @param $trace
     *
     * @return VnPayResult
     */
    public function getTransactionCard($trace)
    {
        $sign = $this->encryption->generateSignRSA("$this->partnerCode-$trace-$this->localDateTimeStr");

        $result = $this->builder->getTransactionCard($this->partnerCode, $trace, $this->localDateTimeStr, $sign);

        $getTransactionCardResult = $result->GetTransactionCardResult;

        $vnPayResult = new VnPayResult();
        $vnPayResult->setMessage($getTransactionCardResult);
        $vnPayResult->setStatusCode(200);

        return $vnPayResult;

    }

    /**
     * @return VnPayResult
     */
    public function getMaxTrace()
    {
        $result = $this->builder->getMaxTrace($this->partnerCode);
        $vnPayResult = new VnPayResult();
        $vnPayResult->setMessage($result->GetMaxTraceResult);

        return $vnPayResult;

    }

    /**
     * @param $product
     * @param $total
     * @param $unitCode
     *
     * @return VnPayResult
     */
    public function checkCardList($product, $total, $unitCode)
    {
        $sign = $this->encryption->generateSignRSA("$this->partnerCode-$product-$total-$unitCode-$this->trace");
        $result = $this->builder->checkCardList($this->partnerCode, $product, $total, $unitCode, $this->trace, $sign);

        $CardListResponseType = $result->CheckCardListResult->CardListResponseType;
        $message = $CardListResponseType->ResponseCode.'-'.$CardListResponseType->Description;
        if (isset($CardListResponseType->TranxMap))
            $message .= $CardListResponseType->TranxMap;
        if (isset($CardListResponseType->ListCard))
            $message .= $CardListResponseType->ListCard;

        $vnPayResult = new VnPayResult();
        $vnPayResult->setMessage($message);
        $vnPayResult->setStatusCode($CardListResponseType->ResponseCode);

        return $vnPayResult;
    }

    /**
     * @param $product
     * @param $total
     * @param $unitCode
     *
     * @return VnPayResult
     */
    public function getCardList($product, $total, $unitCode)
    {
        $sign = $this->encryption->generateSignRSA("$this->partnerCode-$product-$total-$unitCode-$this->trace");
        $result = $this->builder->getCardList($this->partnerCode, $product, $total, $unitCode, $this->trace, $sign);

        $CardListResponseType = $result->GetCardListResult->CardListResponseType;
        $message = $CardListResponseType->ResponseCode.'-'.$CardListResponseType->Description;
        if (isset($CardListResponseType->TranxMap))
            $message .= $CardListResponseType->TranxMap;
        if (isset($CardListResponseType->ListCard))
            $message .= $CardListResponseType->ListCard;

        $vnPayResult = new VnPayResult();
        $vnPayResult->setMessage($message);
        $vnPayResult->setStatusCode($CardListResponseType->ResponseCode);

        return $vnPayResult;
    }
}