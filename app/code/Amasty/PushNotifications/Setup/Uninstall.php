<?php
/**
* @author Amasty Team
* @copyright Copyright (c) 2022 Amasty (https://www.amasty.com)
* @package Push Notifications for Magento 2
*/
declare(strict_types=1);

namespace Amasty\PushNotifications\Setup;

use Amasty\PushNotifications\Model\ResourceModel\Campaign;
use Amasty\PushNotifications\Model\ResourceModel\CampaignCustomerGroup;
use Amasty\PushNotifications\Model\ResourceModel\CampaignEvent;
use Amasty\PushNotifications\Model\ResourceModel\CampaignSegments;
use Amasty\PushNotifications\Model\ResourceModel\CampaignStore;
use Amasty\PushNotifications\Model\ResourceModel\Subscriber;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\UninstallInterface;

class Uninstall implements UninstallInterface
{
    public function uninstall(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();
        $this->uninstallTables($setup)
            ->uninstallConfigData($setup);
        $setup->endSetup();
    }

    private function uninstallTables(SchemaSetupInterface $setup): self
    {
        $tablesToDrop = [
            Campaign::TABLE_NAME,
            Subscriber::TABLE_NAME,
            CampaignStore::TABLE_NAME,
            CampaignCustomerGroup::TABLE_NAME,
            CampaignSegments::TABLE_NAME,
            Campaign::SUBSCRIBER_VIEWS_TABLE_NAME,
            CampaignEvent::TABLE_NAME
        ];
        foreach ($tablesToDrop as $table) {
            $setup->getConnection()->dropTable(
                $setup->getTable($table)
            );
        }

        return $this;
    }

    private function uninstallConfigData(SchemaSetupInterface $setup): self
    {
        $setup->getConnection()->delete(
            $setup->getTable('core_config_data'),
            "`path` LIKE 'amasty_notifications%'"
        );

        return $this;
    }
}
