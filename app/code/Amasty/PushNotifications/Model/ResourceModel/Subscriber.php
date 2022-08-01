<?php
/**
* @author Amasty Team
* @copyright Copyright (c) 2022 Amasty (https://www.amasty.com)
* @package Push Notifications for Magento 2
*/

namespace Amasty\PushNotifications\Model\ResourceModel;

use Amasty\PushNotifications\Api\Data\SubscriberInterface;
use Magento\Framework\DataObject;
use Magento\Framework\DB\Helper;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use Magento\Framework\Model\ResourceModel\Db\Context;

class Subscriber extends AbstractDb
{
    public const TABLE_NAME = 'amasty_notifications_subscriber';

    /**
     * @var Helper
     */
    private $dbHelper;

    /**
     * @var DataObject
     */
    private $associatedQuestionEntityMap;

    /**
     * Question constructor.
     *
     * @param Context $context
     * @param Helper $dbHelper
     * @param DataObject $associatedQuestionEntityMap
     * @param null $connectionName
     */
    public function __construct(
        Context $context,
        Helper $dbHelper,
        DataObject $associatedQuestionEntityMap,
        $connectionName = null
    ) {
        parent::__construct($context, $connectionName);
        $this->associatedQuestionEntityMap = $associatedQuestionEntityMap;
        $this->dbHelper = $dbHelper;
    }

    public function _construct()
    {
        $this->_init(self::TABLE_NAME, SubscriberInterface::SUBSCRIBER_ID);
    }

    /**
     * @param string $entityType
     * @return array
     */
    public function getReferenceConfig($entityType = '')
    {
        return $this->associatedQuestionEntityMap->getData($entityType);
    }
}
