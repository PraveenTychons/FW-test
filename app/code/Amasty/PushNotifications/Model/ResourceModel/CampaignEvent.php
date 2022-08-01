<?php
/**
* @author Amasty Team
* @copyright Copyright (c) 2022 Amasty (https://www.amasty.com)
* @package Push Notifications for Magento 2
*/

namespace Amasty\PushNotifications\Model\ResourceModel;

use Amasty\PushNotifications\Model\CampaignEvent as CampaignEventModel;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class CampaignEvent extends AbstractDb
{
    public const TABLE_NAME = 'amasty_notifications_campaign_event';

    protected function _construct()
    {
        $this->_init(self::TABLE_NAME, CampaignEventModel::ID);
    }
}
