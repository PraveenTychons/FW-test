<?php
/**
* @author Amasty Team
* @copyright Copyright (c) 2022 Amasty (https://www.amasty.com)
* @package Push Notifications for Magento 2
*/

declare(strict_types=1);

namespace Amasty\PushNotifications\Model\OptionSource;

use Amasty\PushNotifications\Model\DeviceDetect;
use Magento\Framework\Data\OptionSourceInterface;

class DeviceType implements OptionSourceInterface
{
    public function toOptionArray(): array
    {
        $optionArray = [];
        foreach ($this->toArray() as $value => $label) {
            $optionArray[] = ['value' => $value, 'label' => $label];
        }

        return $optionArray;
    }

    public function toArray(): array
    {
        return [
            DeviceDetect::DESKTOP => __('Desktop'),
            DeviceDetect::TABLET => __('Tablet'),
            DeviceDetect::MOBILE => __('Mobile')
        ];
    }
}
