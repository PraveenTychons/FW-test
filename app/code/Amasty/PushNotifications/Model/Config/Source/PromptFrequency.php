<?php
/**
* @author Amasty Team
* @copyright Copyright (c) 2022 Amasty (https://www.amasty.com)
* @package Push Notifications for Magento 2
*/

namespace Amasty\PushNotifications\Model\Config\Source;

class PromptFrequency implements \Magento\Framework\Data\OptionSourceInterface
{
    public const FREQUENCY_EVERY_TIME = 0;
    public const FREQUENCY_HOURLY     = 1;
    public const FREQUENCY_DAILY  = 2;
    public const FREQUENCY_WEEKLY  = 3;

    /**
     * @var array|null
     */
    protected $options;

    /**
     * @return array|null
     */
    public function toOptionArray()
    {
        if (!$this->options) {
            $this->options = [
                self::FREQUENCY_EVERY_TIME  => __('Every time'),
                self::FREQUENCY_HOURLY      => __('Hourly'),
                self::FREQUENCY_DAILY   => __('Daily'),
                self::FREQUENCY_WEEKLY   => __('Weekly'),
            ];
        }

        return $this->options;
    }
}
