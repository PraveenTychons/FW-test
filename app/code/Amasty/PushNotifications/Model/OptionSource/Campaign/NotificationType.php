<?php
/**
* @author Amasty Team
* @copyright Copyright (c) 2022 Amasty (https://www.amasty.com)
* @package Push Notifications for Magento 2
*/
declare(strict_types=1);

namespace Amasty\PushNotifications\Model\OptionSource\Campaign;

use Magento\Framework\Data\OptionSourceInterface;

class NotificationType implements OptionSourceInterface
{
    public const CRON_TYPE = 'cron';
    public const EVENT_TYPE = 'event';

    /**
     * @inheritDoc
     */
    public function toOptionArray(): array
    {
        return [
            [
                'value' => self::CRON_TYPE,
                'label' => __('Scheduled Notification')
            ],
            [
                'value' => self::EVENT_TYPE,
                'label' => __('Event Notification')
            ]
        ];
    }
}
