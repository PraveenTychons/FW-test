<?php
/**
* @author Amasty Team
* @copyright Copyright (c) 2022 Amasty (https://www.amasty.com)
* @package Push Notifications for Magento 2
*/
declare(strict_types=1);

namespace Amasty\PushNotifications\Model;

use Amasty\PushNotifications\Model\ResourceModel\CampaignEvent as CampaignEventResource;
use Magento\Framework\Model\AbstractModel;

class CampaignEvent extends AbstractModel
{
    public const ID = 'id';
    public const EVENT_TYPE = 'event_type';
    public const CAMPAIGN_ID = 'campaign_id';

    public function _construct()
    {
        $this->_init(CampaignEventResource::class);
    }

    public function getId()
    {
        return $this->getData(self::ID);
    }

    public function setId($id): CampaignEvent
    {
        return $this->setData(self::ID, $id);
    }

    public function getEventType(): string
    {
        return $this->getData(self::EVENT_TYPE);
    }

    public function setEventType(string $eventType): CampaignEvent
    {
        return $this->setData(self::EVENT_TYPE, $eventType);
    }

    public function getCampaignId(): ?int
    {
        return $this->getData(self::CAMPAIGN_ID);
    }

    public function setCampaignId(?int $campaignId): CampaignEvent
    {
        return $this->setData(self::CAMPAIGN_ID, $campaignId);
    }
}
