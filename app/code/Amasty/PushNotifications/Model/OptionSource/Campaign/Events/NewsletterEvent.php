<?php
/**
* @author Amasty Team
* @copyright Copyright (c) 2022 Amasty (https://www.amasty.com)
* @package Push Notifications for Magento 2
*/
declare(strict_types=1);

namespace Amasty\PushNotifications\Model\OptionSource\Campaign\Events;

use Magento\Framework\Data\OptionSourceInterface;

class NewsletterEvent implements OptionSourceInterface
{
    public const SUBSCRIPTION = 'subscription';
    public const SUBSCRIPTION_CANCELLATION = 'subscription_cancellation';

    /**
     * @inheritDoc
     */
    public function toOptionArray(): array
    {
        return [
            [
                'value' => self::SUBSCRIPTION,
                'label' => __('Subscription')
            ],
            [
                'value' => self::SUBSCRIPTION_CANCELLATION,
                'label' => __('Subscription Cancellation')
            ]
        ];
    }

    /**
     * @return array|false
     */
    public function toArray()
    {
        $optionArray = $this->toOptionArray();
        $labels = array_column($optionArray, 'label');
        $values = array_column($optionArray, 'value');

        return array_combine($values, $labels);
    }
}
