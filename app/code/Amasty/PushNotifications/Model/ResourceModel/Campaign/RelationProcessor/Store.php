<?php
/**
* @author Amasty Team
* @copyright Copyright (c) 2022 Amasty (https://www.amasty.com)
* @package Push Notifications for Magento 2
*/
declare(strict_types=1);

namespace Amasty\PushNotifications\Model\ResourceModel\Campaign\RelationProcessor;

use Amasty\PushNotifications\Api\Data\CampaignInterface;
use Amasty\PushNotifications\Model\CampaignStore as CampaignStoreModel;
use Amasty\PushNotifications\Model\ResourceModel\CampaignStore as CampaignStoreResource;
use Magento\Framework\Model\AbstractModel;
use Magento\Framework\Model\ResourceModel\Db\VersionControl\RelationInterface;
use Magento\Store\Model\Store as MagentoStoreModel;

class Store implements RelationInterface
{
    /**
     * @var ChangedRelationProcessor
     */
    private $changedRelationProcessor;

    public function __construct(
        ChangedRelationProcessor $changedRelationProcessor
    ) {
        $this->changedRelationProcessor = $changedRelationProcessor;
    }

    public function processRelation(AbstractModel $object)
    {
        $oldStores = (array)$object->getOrigData(CampaignInterface::STORES);
        $newStores = array_diff($object->getStores(), $oldStores);
        $removedStores = array_diff($oldStores, $object->getStores());
        if (in_array(MagentoStoreModel::DEFAULT_STORE_ID, $newStores)) {
            $removedStores = [];
        }
        $this->changedRelationProcessor->replaceRelation(
            $object,
            $newStores,
            $removedStores,
            CampaignStoreResource::TABLE_NAME,
            CampaignStoreModel::STORE_ID
        );
    }
}
