<?php
namespace Vnpay\SoapClient\Soap;

/**
 * Factory to create a \SoapClient properly configured for the Vnpay SOAP client
 *
 */
class SoapClientFactory
{
    /**
     * Default classmap
     *
     * @var array
     */
    protected $classmap = array(
        'CheckCardListResult'       => 'Vnpay\SoapClient\Result\CheckCardListResult',
        'GetBalanceResult'          => 'Vnpay\SoapClient\Result\GetBalanceResult',
        'GetCardListResult'         => 'Vnpay\SoapClient\Result\GetCardListResult',
        'GetCardResult'             => 'Vnpay\SoapClient\Result\GetCardResult',
        'GetCardToMobileResult'     => 'Vnpay\SoapClient\Result\GetCardToMobileResult',
        'GetMaxTraceResult'         => 'Vnpay\SoapClient\Result\GetMaxTraceResult',
        'GetTransactionCardResult'  => 'Vnpay\SoapClient\Result\GetTransactionCardResult',
        'GetTransactionResult'      => 'Vnpay\SoapClient\Result\GetTransactionResult',
        'LoginResult'               => 'Vnpay\SoapClient\Result\LoginResult',
        'TopupMobileResult'         => 'Vnpay\SoapClient\Result\TopupMobileResult',
    );

    /**
     * @param string $wsdl Path to WSDL file
     * @param array $soapOptions
     *
     * @return SoapClient
     */
    public function factory($wsdl, array $soapOptions = array())
    {
        $defaults = array(
            'trace'      => 1,
            'features'   => \SOAP_SINGLE_ELEMENT_ARRAYS,
            'classmap'   => $this->classmap,
            'cache_wsdl' => \WSDL_CACHE_MEMORY,
            //'connection_timeout' => 80000
        );

        $options = array_merge($defaults, $soapOptions);

        return new SoapClient($wsdl, $options);
    }
}
