<?php
/**
* @author Amasty Team
* @copyright Copyright (c) 2022 Amasty (https://www.amasty.com)
* @package Push Notifications for Magento 2
*/

declare(strict_types=1);

namespace Amasty\PushNotifications\Model;

use Amasty\PushNotifications\Lib\MobileDetect;

class DeviceDetect
{
    public const DESKTOP = 'desktop';
    public const TABLET = 'tablet';
    public const MOBILE = 'mobile';

    /**
     * @var MobileDetect
     */
    private $mobileDetect;

    public function __construct(
        MobileDetect $mobileDetect
    ) {
        $this->mobileDetect = $mobileDetect;
    }

    public function detectDevice(): string
    {
        if ($this->mobileDetect->isTablet()) {
            return self::TABLET;
        }
        if ($this->mobileDetect->isMobile()) {
            return self::MOBILE;
        }

        return self::DESKTOP;
    }
}
