<?php
namespace Vnpay\SoapClient;

use Vnpay\SoapClient\Result;

/**
 * Vnpay API client interface
 *
 */
interface ClientInterface
{
    /**
     * Logs in to the login server and starts a client session
     *
     * @return Result\LoginResult
     * @link
     */
    public function login();

    /**
     * Returns information 'Hello World'
     *
     * @return mixed
     * @link http://210.245.12.221:8080/TopupAirtime/VnpSrv.asmx?op=HelloWorld
     */
    public function helloWorld();

    /**
     * @param $PartnerCode
     * @param $LocalDateTime
     * @param $Sign
     *
     * @return Result\GetBalanceResult
     * @link http://210.245.12.221:8080/TopupAirtime/VnpSrv.asmx?op=GetBalance
     */
    public function getBalance($PartnerCode, $LocalDateTime, $Sign);

    /**
     * @param $MobileNo
     * @param $Amount
     * @param $Trace
     * @param $LocalDateTime
     * @param $PartnerCode
     * @param $Sign
     *
     * @return Result\TopupMobileResult
     * @link http://210.245.12.221:8080/TopupAirtime/VnpSrv.asmx?op=TopupMobile
     */
    public function TopupMobile($MobileNo, $Amount, $Trace, $LocalDateTime, $PartnerCode, $Sign);

    /**
     * @param $PartnerCode
     * @param $ProductCode
     * @param $Amount
     * @param $Trace
     * @param $LocalDateTime
     * @param $Sign
     *
     * @return Result\GetCardResult
     * @link http://210.245.12.221:8080/TopupAirtime/VnpSrv.asmx?op=GetCard
     */
    public function getCard($PartnerCode, $ProductCode, $Amount, $Trace, $LocalDateTime, $Sign);

    /**
     * @param $PartnerCode
     * @param $ProductCode
     * @param $Amount
     * @param $Trace
     * @param $MobileNo
     * @param $LocalDateTime
     * @param $Sign
     *
     * @return Result\GetCardToMobileResult
     * @link http://210.245.12.221:8080/TopupAirtime/VnpSrv.asmx?op=GetCardToMobile
     */
    public function getCardToMobile($PartnerCode, $ProductCode, $Amount, $Trace, $MobileNo, $LocalDateTime, $Sign);

    /**
     * @param $PartnerCode
     * @param $Trace
     * @param $LocalDateTime
     * @param $Sign
     *
     * @return Result\GetTransactionResult
     * @link http://210.245.12.221:8080/TopupAirtime/VnpSrv.asmx?op=GetTransaction
     */
    public function getTransaction($PartnerCode, $Trace, $LocalDateTime, $Sign);

    /**
     * @param $sPartnerCode
     * @param $sTrace
     * @param $sLocalDateTime
     * @param $sSign
     *
     * @return Result\GetTransactionCardResult
     * @link http://210.245.12.221:8080/TopupAirtime/VnpSrv.asmx?op=GetTransactionCard
     */
    public function getTransactionCard($sPartnerCode, $sTrace, $sLocalDateTime, $sSign);

    /**
     * @param $sPartnerCode
     *
     * @return Result\GetMaxTraceResult
     * @link http://210.245.12.221:8080/TopupAirtime/VnpSrv.asmx?op=GetMaxTrace
     */
    public function getMaxTrace($sPartnerCode);

    /**
     * @param $PartnerCode
     * @param $Product
     * @param $Total
     * @param $UnitCode
     * @param $Trace
     * @param $SignData
     *
     * @return Result\CheckCardListResult
     * @link http://210.245.12.221:8080/TopupAirtime/VnpSrv.asmx?op=CheckCardList
     */
    public function checkCardList($PartnerCode, $Product, $Total, $UnitCode, $Trace, $SignData);

    /**
     * @param $PartnerCode
     * @param $Product
     * @param $Total
     * @param $UnitCode
     * @param $Trace
     * @param $SignData
     *
     * @return Result\GetCardListResult
     * @link http://210.245.12.221:8080/TopupAirtime/VnpSrv.asmx?op=GetCardList
     */
    public function getCardList($PartnerCode, $Product, $Total, $UnitCode, $Trace, $SignData);
}

