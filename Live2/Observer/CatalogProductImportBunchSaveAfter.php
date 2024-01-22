<?php

namespace Live2\Live2\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Psr\Log\LoggerInterface;


class CatalogProductImportBunchSaveAfter implements ObserverInterface
{
    public const WebHook = 'http://localhost:8080/webhooks';

    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * @param LoggerInterface $logger
     */
    public function __construct(
        LoggerInterface $logger
    ) {
        $this->logger = $logger;
    }

    public function execute(\Magento\Framework\Event\Observer $observer)
    {

        $access_token = \Live2\Live2\Helper\Live2ApiCall::getAccessToken();
        try{
            $bunch = $observer->getBunch();
            $this->logger->info("outputDataLIVE2");
            $jsonData = json_encode($bunch);

            $ch = curl_init(self::WebHook);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Content-Length: ' . strlen($jsonData), 'Store-Type: magento','AccessToken :'.$access_token));
            $result = curl_exec($ch);
            curl_close($ch);
        }catch (\Execption $e) {
            $e->getMessage(); 
        }
    }
}