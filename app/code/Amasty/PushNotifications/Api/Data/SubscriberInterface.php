<?php
/**
* @author Amasty Team
* @copyright Copyright (c) 2022 Amasty (https://www.amasty.com)
* @package Push Notifications for Magento 2
*/

namespace Amasty\PushNotifications\Api\Data;

interface SubscriberInterface
{
    public const SUBSCRIBER_ID = 'subscriber_id';
    public const SOURCE = 'source';
    public const IS_ACTIVE = 'is_active';
    public const SUBSCRIBER_IP = 'subscriber_ip';
    public const TOKEN = 'token';
    public const LOCATION = 'location';
    public const VISITOR_ID = 'visitor_id';
    public const CUSTOMER_ID = 'customer_id';
    public const CREATED_AT = 'created_at';
    public const UPDATED_AT = 'updated_at';
    public const STORE_ID = 'store_id';

    /**
     * @return int
     */
    public function getSubscriberId();

    /**
     * @param int $subscriberId
     *
     * @return \Amasty\PushNotifications\Api\Data\SubscriberInterface
     */
    public function setSubscriberId($subscriberId);

    /**
     * @return string
     */
    public function getSource();

    /**
     * @param string $source
     *
     * @return \Amasty\PushNotifications\Api\Data\SubscriberInterface
     */
    public function setSource($source);

    /**
     * @return string
     */
    public function getSubscribersIp();

    /**
     * @param string $subscribersIp
     *
     * @return \Amasty\PushNotifications\Api\Data\SubscriberInterface
     */
    public function setSubscribersIp($subscribersIp);

    /**
     * @return int|string
     */
    public function getIsActive();

    /**
     * @param int|string $active
     *
     * @return \Amasty\PushNotifications\Api\Data\SubscriberInterface
     */
    public function setIsActive($active);

    /**
     * @return string
     */
    public function getToken();

    /**
     * @param string $token
     *
     * @return \Amasty\PushNotifications\Api\Data\SubscriberInterface
     */
    public function setToken($token);

    /**
     * @return int
     */
    public function getLocation();

    /**
     * @param int|string $location
     *
     * @return \Amasty\PushNotifications\Api\Data\SubscriberInterface
     */
    public function setLocation($location);

    /**
     * @return int
     */
    public function getVisitorId();

    /**
     * @param int $visitorId
     *
     * @return \Amasty\PushNotifications\Api\Data\SubscriberInterface
     */
    public function setVisitorId($visitorId);

    /**
     * @return int
     */
    public function getCustomerId();

    /**
     * @param int $customerId
     *
     * @return \Amasty\PushNotifications\Api\Data\SubscriberInterface
     */
    public function setCustomerId($customerId);

    /**
     * @return string
     */
    public function getCreatedAt();

    /**
     * @param string $createdAt
     *
     * @return \Amasty\PushNotifications\Api\Data\SubscriberInterface
     */
    public function setCreatedAt($createdAt);

    /**
     * @return string
     */
    public function getUpdatedAt();

    /**
     * @param string $updatedAt
     *
     * @return \Amasty\PushNotifications\Api\Data\SubscriberInterface
     */
    public function setUpdatedAt($updatedAt);

    /**
     * @return int
     */
    public function getStoreId();

    /**
     * @param int $storeId
     *
     * @return \Amasty\PushNotifications\Api\Data\SubscriberInterface
     */
    public function setStoreId($storeId);
}
