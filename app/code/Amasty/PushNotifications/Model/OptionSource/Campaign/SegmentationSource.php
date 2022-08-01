<?php
/**
* @author Amasty Team
* @copyright Copyright (c) 2022 Amasty (https://www.amasty.com)
* @package Push Notifications for Magento 2
*/

namespace Amasty\PushNotifications\Model\OptionSource\Campaign;

use Magento\Framework\Data\OptionSourceInterface;
use Magento\Framework\Module\Manager;

class SegmentationSource implements OptionSourceInterface
{
    public const CUSTOMER_GROUPS = 0;
    public const CUSTOMER_SEGMENTS = 1;

    /**
     * @var Manager
     */
    private $moduleManager;

    public function __construct(
        Manager $moduleManager
    ) {
        $this->moduleManager = $moduleManager;
    }

    /**
     * @inheritDoc
     */
    public function toOptionArray()
    {
        $result = [
            [
                'value' => self::CUSTOMER_GROUPS,
                'label' => __('Use Customer Groups (Default)')
            ],
            [
                'disabled' => !$this->moduleManager->isEnabled('Amasty_Segments'), //field flag used in options.js
                'value' => self::CUSTOMER_SEGMENTS,
                'label' => __('Use Amasty Customer Segments')
            ]
        ];

        return $result;
    }
}
