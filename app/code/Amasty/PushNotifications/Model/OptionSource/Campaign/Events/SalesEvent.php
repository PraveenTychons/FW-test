<?php
/**
* @author Amasty Team
* @copyright Copyright (c) 2022 Amasty (https://www.amasty.com)
* @package Push Notifications for Magento 2
*/
declare(strict_types=1);

namespace Amasty\PushNotifications\Model\OptionSource\Campaign\Events;

use Magento\Framework\Data\OptionSourceInterface;

class SalesEvent implements OptionSourceInterface
{
    public const STATUS_CHANGING = 'status_changing';
    public const ORDER_CANCEL_AFTER = 'order_cancel_after';

    /**
     * @inheritDoc
     */
    public function toOptionArray()
    {
        return [
            [
                'value' => self::STATUS_CHANGING,
                'label' => __('Order Status Changing')
            ],
            [
                'value' => self::ORDER_CANCEL_AFTER,
                'label' => __('Order Cancellation')
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
