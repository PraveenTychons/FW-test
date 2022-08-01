<?php
/**
* @author Amasty Team
* @copyright Copyright (c) 2022 Amasty (https://www.amasty.com)
* @package Push Notifications for Magento 2
*/

namespace Amasty\PushNotifications\Model\Builder;

class NotificationMessageBuilder implements BuilderInterface
{
    public const SUCCESS_STATUS = 1;

    /**
     * @inheritdoc
     */
    public function build(array $params)
    {
        $result = '';

        if (isset($params['status'])) {
            $status = (int)$params['status'];

            if ($status === self::SUCCESS_STATUS) {
                $result = __('Notification has been sent.');
            } else {
                $result = __('Notification send error.');
            }
        }

        return $result;
    }
}
