<?php
/**
* @author Amasty Team
* @copyright Copyright (c) 2022 Amasty (https://www.amasty.com)
* @package Push Notifications for Magento 2
*/


namespace Amasty\PushNotifications\Model\ResourceModel\CampaignStore;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    /**
     * @inheritdoc
     */
    protected $_idFieldName = 'id';

    /**
     * @inheritdoc
     */
    protected function _construct()
    {
        $this->_init(
            \Amasty\PushNotifications\Model\CampaignStore::class,
            \Amasty\PushNotifications\Model\ResourceModel\CampaignStore::class
        );
    }
}
