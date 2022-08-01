<?php
/**
* @author Amasty Team
* @copyright Copyright (c) 2022 Amasty (https://www.amasty.com)
* @package Push Notifications for Magento 2
*/

namespace Amasty\PushNotifications\Model\OptionSource\Campaign;

use Magento\Framework\Data\OptionSourceInterface;

class Status implements OptionSourceInterface
{
    public const STATUS_PASSED = 0;
    public const STATUS_SCHEDULED = 1;
    public const STATUS_EDITED = 2;
    public const STATUS_BY_EVENT = 3;

    /**
     * @return array
     */
    public function toOptionArray()
    {
        return [
            ['value' => self::STATUS_PASSED, 'label'=> __('Passed')],
            ['value' => self::STATUS_SCHEDULED, 'label'=> __('Scheduled')],
            ['value' => self::STATUS_EDITED, 'label'=> __('Edited')],
            ['value' => self::STATUS_BY_EVENT, 'label'=> __('By Event')]
        ];
    }
}
