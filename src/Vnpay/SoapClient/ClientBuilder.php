<?php
namespace Vnpay\SoapClient;

use Vnpay\SoapClient\Soap\SoapClientFactory;
use Vnpay\SoapClient\Plugin\LogPlugin;
use Psr\Log\LoggerInterface;

/**
 * Vnpay SOAP client builder
 *
 */
class ClientBuilder
{
    protected $log;

    /**
     * Construct client builder with required parameters
     *
     * @param string $wsdl        Path to your Vnpay WSDL
     * @param array  $soapOptions Further options to be passed to the SoapClient
     */
    public function __construct($wsdl, array $soapOptions = array())
    {
        $this->wsdl = $wsdl;
        $this->soapOptions = $soapOptions;
    }

    /**
     * Enable logging
     *
     * @param LoggerInterface $log Logger
     *
     * @return ClientBuilder
     */
    public function withLog(LoggerInterface $log)
    {
        $this->log = $log;

        return $this;
    }

    /**
     * Build the Vnpay SOAP client
     *
     * @return Client
     */
    public function build()
    {
        $soapClientFactory = new SoapClientFactory();
        $soapClient = $soapClientFactory->factory($this->wsdl, $this->soapOptions);

        $client = new Client($soapClient);

        if ($this->log) {
            $logPlugin = new LogPlugin($this->log);
            $client->getEventDispatcher()->addSubscriber($logPlugin);
        }

        return $client;
    }
}
