<?php
/**
* @author Amasty Team
* @copyright Copyright (c) 2022 Amasty (https://www.amasty.com)
* @package Push Notifications for Magento 2
*/

namespace Amasty\PushNotifications\Model\Processor;

use Amasty\PushNotifications\Exception\NotificationException;

interface ProcessorInterface
{
    /**
     * @param array $params
     * @param int|null $storeId
     *
     * @return array
     *
     * @throws NotificationException
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\CouldNotSaveException
     * @throws \Magento\Framework\Exception\AlreadyExistsException
     */
    public function process(array $params, $storeId = null);
}
