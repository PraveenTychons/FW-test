<?php
/**
* @author Amasty Team
* @copyright Copyright (c) 2022 Amasty (https://www.amasty.com)
* @package Push Notifications for Magento 2
*/

namespace Amasty\PushNotifications\Model\ResourceModel;

use Amasty\PushNotifications\Model\CampaignCustomerGroup as CampaignCustomerGroupModel;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class CampaignCustomerGroup extends AbstractDb
{
    public const TABLE_NAME = 'amasty_notifications_campaign_group';

    protected function _construct()
    {
        $this->_init(self::TABLE_NAME, CampaignCustomerGroupModel::CAMPAIGN_GROUP_ID);
    }
}
