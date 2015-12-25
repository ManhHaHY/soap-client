<?php
namespace Vnpay\SoapClient\Plugin;

use Vnpay\SoapClient\Event\RequestEvent;
use Vnpay\SoapClient\Event\ResponseEvent;
use Vnpay\SoapClient\Event\FaultEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Psr\Log\LoggerInterface;
use Monolog\Logger;

/**
 * A plugin that logs messages
 *
 *  */
class LogPlugin implements EventSubscriberInterface
{
    /**
     * Constructor
     *
     * @param LoggerInterface $logger
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function onClientRequest(RequestEvent $event)
    {
        $this->logger->info(sprintf(
            '[vnpay/soap-client] request: call "%s" with params %s',
            $event->getMethod(),
            \json_encode($event->getParams())
        ));
    }

    public function onClientResponse(ResponseEvent $event)
    {
        $this->logger->info(sprintf(
            '[vnpay/soap-client] response: %s',
            \print_r($event->getResponse(), true)
        ));
    }

    public function onClientFault(FaultEvent $event)
    {
        $this->logger->error(sprintf(
            '[vnpay/soap-client] fault "%s" for request "%s" with params %s',
            $event->getSoapFault()->getMessage(),
            $event->getRequestEvent()->getMethod(),
            \json_encode($event->getRequestEvent()->getParams())
        ));
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return array(
            'vnpay.soap_client.request'  => 'onClientRequest',
            'vnpay.soap_client.response' => 'onClientResponse',
            'vnpay.soap_client.fault'    => 'onClientFault'
        );
    }
}