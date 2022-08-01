<?php
/**
* @author Amasty Team
* @copyright Copyright (c) 2022 Amasty (https://www.amasty.com)
* @package Push Notifications for Magento 2
*/
declare(strict_types=1);

namespace Amasty\PushNotifications\Observer;

use Amasty\PushNotifications\Exception\NotificationException;
use Amasty\PushNotifications\Model\Processor\CampaignProcessor;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Psr\Log\LoggerInterface;

class SendPushByEvent implements ObserverInterface
{
    public const EVENT_NAME = 'amasty_pushnotifications_by_event';
    public const EVENT_VARIABLE = 'event';
    public const CUSTOMER_IDS_VARIABLE = 'customer_ids';

    /**
     * @var CampaignProcessor
     */
    private $campaignProcessor;

    /**
     * @var LoggerInterface
     */
    private $logger;

    public function __construct(
        CampaignProcessor $campaignProcessor,
        LoggerInterface $logger
    ) {
        $this->campaignProcessor = $campaignProcessor;
        $this->logger = $logger;
    }

    public function execute(Observer $observer)
    {
        try {
            $customerIds = $observer->getData(self::CUSTOMER_IDS_VARIABLE);
            $event = $observer->getData(self::EVENT_VARIABLE);
            if (empty($customerIds) || !$event) {
                return;
            }
            $this->campaignProcessor->processByEvent($event, $customerIds);
        } catch (NotificationException $exception) {
            $this->logger->critical($exception);
        }
    }
}
