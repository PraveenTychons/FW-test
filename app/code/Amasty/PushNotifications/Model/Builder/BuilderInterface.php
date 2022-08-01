<?php
/**
* @author Amasty Team
* @copyright Copyright (c) 2022 Amasty (https://www.amasty.com)
* @package Push Notifications for Magento 2
*/

namespace Amasty\PushNotifications\Model\Builder;

use Amasty\PushNotifications\Exception\NotificationException;

interface BuilderInterface
{
    /**
     * @param array $params
     * @return array|string
     * @throws NotificationException
     */
    public function build(array $params);
}
