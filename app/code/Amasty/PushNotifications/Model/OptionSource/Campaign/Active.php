<?php
/**
* @author Amasty Team
* @copyright Copyright (c) 2022 Amasty (https://www.amasty.com)
* @package Push Notifications for Magento 2
*/

namespace Amasty\PushNotifications\Model\OptionSource\Campaign;

use Magento\Framework\Data\OptionSourceInterface;

class Active implements OptionSourceInterface
{
    public const STATUS_ACTIVE = 1;
    public const STATUS_INACTIVE = 0;

    /**
     * @return array
     */
    public function toArray()
    {
        return [
            self::STATUS_ACTIVE => __("Active"),
            self::STATUS_INACTIVE => __("Inactive"),
        ];
    }

    /**
     * @return array
     */
    public function toOptionArray()
    {
        return [
            [
                'value' => self::STATUS_ACTIVE,
                'label' => __("Active")
            ],
            [
                'value' => self::STATUS_INACTIVE,
                'label' => __("Inactive")
            ],
        ];
    }
}
