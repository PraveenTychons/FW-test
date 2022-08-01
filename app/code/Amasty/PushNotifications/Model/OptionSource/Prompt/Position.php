<?php
/**
* @author Amasty Team
* @copyright Copyright (c) 2022 Amasty (https://www.amasty.com)
* @package Push Notifications for Magento 2
*/

namespace Amasty\PushNotifications\Model\OptionSource\Prompt;

use Magento\Framework\Data\OptionSourceInterface;

class Position implements OptionSourceInterface
{
    public const STATUS_RIGHT = 'right';
    public const STATUS_LEFT = 'left';
    public const STATUS_CENTER = 'center';

    /**
     * @return array
     */
    public function toOptionArray()
    {
        return [
            ['value' => self::STATUS_RIGHT, 'label'=> __('Bottom Right')],
            ['value' => self::STATUS_LEFT, 'label'=> __('Bottom Left')],
            ['value' => self::STATUS_CENTER, 'label'=> __('Bottom Center')]
        ];
    }
}
