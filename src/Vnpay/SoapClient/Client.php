<?php
namespace Vnpay\SoapClient;

use Vnpay\SoapClient\Result\LoginResult;
use Vht\Common\AbstractHasDispatcher;
use Vnpay\SoapClient\Soap\SoapClient;
use Vnpay\SoapClient\Result;
use Vnpay\SoapClient\Event;

/**
 * A client for the Vnpay SOAP API
 *
 */
class Client extends AbstractHasDispatcher implements ClientInterface
{
    /**
     * SOAP namespace
     *
     * @var string
     */
    const SOAP_NAMESPACE = 'http://www.vnpay.vn/VnTopup/';

    /**
     * PHP SOAP client for interacting with the Vnpay API
     *
     * @var SoapClient
     */
    protected $soapClient;

    /**
     * Login result
     *
     * @var Result\LoginResult
     */
    protected $loginResult;

    /**
     * Construct Vnpay SOAP client
     *
     * @param SoapClient $soapClient SOAP client
     *
     */
    public function __construct(SoapClient $soapClient)
    {
        $this->soapClient = $soapClient;
    }

    public function doLogin()
    {
        $loginResult = new LoginResult();
        $this->setLoginResult($loginResult);

        return $loginResult;
    }

    public function login()
    {
        return $this->doLogin();
    }

    /**
     * Get login result
     *
     * @return Result\LoginResult
     */
    public function getLoginResult()
    {
        if (null === $this->loginResult) {
            $this->login();
        }

        return $this->loginResult;
    }

    protected function setLoginResult(Result\LoginResult $loginResult)
    {
        $this->loginResult = $loginResult;
    }

    public function helloWorld()
    {
        return $this->call('HelloWorld');
    }

    public function getBalance($PartnerCode, $LocalDateTime, $Sign)
    {
        return $this->call(
            'GetBalance',
            array(
                'balancerequest' =>
                    array(
                        'balanceRequest' =>
                            array(
                                'PartnerCode'   => $PartnerCode,
                                'LocalDateTime' => $LocalDateTime,
                                'Sign'          => $Sign,
                            )
                    )
            )
        );
    }

    public function topupMobile($mobileNo, $amount, $trace, $localDateTime, $partnerCode, $sign)
    {
        return $this->call(
            'TopupMobile',
            array(
                'topuprequest' =>
                    array(
                        'topupRequest' =>
                            array(
                                'MobileNo'      => $mobileNo,
                                'Amount'        => $amount,
                                'Trace'         => $trace,
                                'LocalDateTime' => $localDateTime,
                                'PartnerCode'   => $partnerCode,
                                'Sign'          => $sign,
                            )
                    )
            )
        );
    }

    public function getCard($partnerCode, $productCode, $amount, $trace, $localDateTime, $sign)
    {
        return $this->call(
            'GetCard',
            array(
                'PartnerCode'   => $partnerCode,
                'ProductCode'   => $productCode,
                'Amount'        => $amount,
                'Trace'         => $trace,
                'LocalDateTime' => $localDateTime,
                'Sign'          => $sign,
            )
        );
    }

    public function getCardToMobile($partnerCode, $productCode, $amount, $trace, $mobileNo, $localDateTime, $sign)
    {
        return $this->call(
            'GetCardToMobile',
            array(
                'PartnerCode'   => $partnerCode,
                'ProductCode'   => $productCode,
                'Amount'        => $amount,
                'Trace'         => $trace,
                'MobileNo'      => $mobileNo,
                'LocalDateTime' => $localDateTime,
                'Sign'          => $sign,
            )
        );
    }

    public function getTransaction($partnerCode, $trace, $localDateTime, $sign)
    {
        return $this->call(
            'GetTransaction',
            array(
                'transaction' =>
                    array(
                        'TransactionRequest' =>
                            array(
                                'PartnerCode'   => $partnerCode,
                                'Trace'         => $trace,
                                'LocalDateTime' => $localDateTime,
                                'Sign'          => $sign,
                            )
                    )
            )
        );
    }

    public function getTransactionCard($sPartnerCode, $sTrace, $sLocalDateTime, $sSign)
    {
        return $this->call(
            'GetTransactionCard',
            array(
                'sPartnerCode'  => $sPartnerCode,
                'sTrace'        => $sTrace,
                'LocalDateTime' => $sLocalDateTime,
                'sSign'         => $sSign,
            )
        );
    }

    public function getMaxTrace($sPartnerCode)
    {
        return $this->call(
            'GetMaxTrace',
            array(
                'sPartnerCode'  => $sPartnerCode,
            )
        );
    }

    public function checkCardList($partnerCode, $product, $total, $unitCode, $trace, $signData)
    {
        return $this->call(
            'CheckCardList',
            array(
                'PartnerCode'   => $partnerCode,
                'Product'       => $product,
                'Total'         => $total,
                'UnitCode'      => $unitCode,
                'Trace'         => $trace,
                'SignData'      => $signData,
            )
        );
    }

    public function getCardList($partnerCode, $product, $total, $unitCode, $trace, $signData)
    {
        return $this->call(
            'GetCardList',
            array(
                'PartnerCode'   => $partnerCode,
                'Product'       => $product,
                'Total'         => $total,
                'UnitCode'      => $unitCode,
                'Trace'         => $trace,
                'SignData'      => $signData,
            )
        );
    }

    /**
     * Initialize connection
     *
     */
    protected function init()
    {
    }

    /**
     * Issue a call to Vnpay API
     *
     * @param string $method SOAP operation name
     * @param array  $params SOAP parameters
     *
     * @return array | $result object, such as QueryResult, SaveResult, DeleteResult.
     * @throws \Exception
     * @throws \SoapFault
     */
    protected function call($method, array $params = array())
    {
        $this->init();

        $requestEvent = new Event\RequestEvent($method, $params);
        $this->dispatch(Events::REQUEST, $requestEvent);

        try {
            $result = $this->soapClient->$method($params);
        } catch (\SoapFault $soapFault) {
            $faultEvent = new Event\FaultEvent($soapFault, $requestEvent);
            $this->dispatch(Events::FAULT, $faultEvent);

            throw $soapFault;
        }

        if (!isset($result)) {
            return array();
        }

        $this->dispatch(
            Events::RESPONSE,
            new Event\ResponseEvent($requestEvent, $result)
        );

        return $result;
    }
}

