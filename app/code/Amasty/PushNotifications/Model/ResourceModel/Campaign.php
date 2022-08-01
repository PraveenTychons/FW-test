<?php
/**
* @author Amasty Team
* @copyright Copyright (c) 2022 Amasty (https://www.amasty.com)
* @package Push Notifications for Magento 2
*/

namespace Amasty\PushNotifications\Model\ResourceModel;

use Amasty\PushNotifications\Api\Data\CampaignInterface;
use Magento\Framework\DataObject;
use Magento\Framework\Model\AbstractModel;
use Magento\Framework\Model\ResourceModel\Db\Context;
use Magento\Framework\Model\ResourceModel\Db\VersionControl\AbstractDb;
use Magento\Framework\Model\ResourceModel\Db\VersionControl\RelationComposite;
use Magento\Framework\Model\ResourceModel\Db\VersionControl\Snapshot;

class Campaign extends AbstractDb
{
    public const TABLE_NAME = 'amasty_notifications_campaign';
    public const SUBSCRIBER_VIEWS_TABLE_NAME = 'amasty_notifications_campaign_subscriber_views';
    public const SUBSCRIBER_BATCH_SIZE = 1000;

    /**
     * @var DataObject
     */
    private $associatedCampaignEntityMap;

    public function _construct()
    {
        $this->_init(self::TABLE_NAME, CampaignInterface::CAMPAIGN_ID);
    }

    public function __construct(
        Context $context,
        Snapshot $entitySnapshot,
        RelationComposite $entityRelationComposite,
        DataObject $associatedCampaignEntityMap,
        $connectionName = null
    ) {
        parent::__construct($context, $entitySnapshot, $entityRelationComposite, $connectionName);
        $this->associatedCampaignEntityMap = $associatedCampaignEntityMap;
    }

    protected function _afterLoad(AbstractModel $object)
    {
        foreach ($this->associatedCampaignEntityMap->getData() as $entityType => $config) {
            if (isset($config['column'], $config['table'])) {
                $object->setData(
                    $entityType,
                    $this->getRelationData($object->getCampaignId(), $config['table'], $config['column'])
                );
            }
        }

        return $this;
    }

    private function getRelationData($id, string $tableName, string $field): array
    {
        $select = $this->getConnection()->select()->from(
            ['c' => $this->getTable($tableName)],
            [$field]
        )->where(
            'campaign_id = :campaign_id'
        );
        $bind = ['campaign_id' => (int)$id];

        return $this->getConnection()->fetchCol($select, $bind);
    }

    private function updateCampaignSubscriberShown(int $campaignId, array $subscriberIdsShown)
    {
        if (empty($subscriberIdsShown)) {
            return;
        }

        foreach (array_chunk($subscriberIdsShown, self::SUBSCRIBER_BATCH_SIZE) as $subscriberIdsBatch) {
            $dataToInsert = [];
            foreach ($subscriberIdsBatch as $subscriberId) {
                $dataToInsert[] = [
                    'campaign_id' => $campaignId,
                    'subscriber_id' => (int)$subscriberId,
                    'shown' => 1
                ];
            }

            $this->getConnection()->insertOnDuplicate(
                $this->getTable(self::SUBSCRIBER_VIEWS_TABLE_NAME),
                $dataToInsert,
                ['campaign_id', 'subscriber_id', 'shown'],
            );
        }
    }

    private function getShownUniqueByCampaignId(int $campaignId): int
    {
        $connection = $this->getConnection();
        $select = $connection->select()
            ->from(
                $this->getTable(self::SUBSCRIBER_VIEWS_TABLE_NAME),
                new \Zend_Db_Expr('SUM(shown)')
            )->where('campaign_id = ?', $campaignId);

        return (int)$connection->fetchOne($select);
    }

    protected function _beforeSave(AbstractModel $object)
    {
        if (!empty($object->getSubscriberViews())) {
            $this->updateCampaignSubscriberShown(
                (int)$object->getCampaignId(),
                $object->getSubscriberViews()
            );
            $object->setShownUniqueCounter(
                $this->getShownUniqueByCampaignId(
                    (int)$object->getCampaignId()
                )
            );
        }

        return parent::_beforeSave($object);
    }
}
