<?php
/**
* @author Amasty Team
* @copyright Copyright (c) 2022 Amasty (https://www.amasty.com)
* @package Push Notifications for Magento 2
*/

namespace Amasty\PushNotifications\Model\ResourceModel\CampaignCustomerGroup;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

/**
 * Class Collection
 */
class Collection extends AbstractCollection
{
    protected function _construct()
    {
        parent::_construct();
        $this->_init(
            \Amasty\PushNotifications\Model\CampaignCustomerGroup::class,
            \Amasty\PushNotifications\Model\ResourceModel\CampaignCustomerGroup::class
        );
    }
}
