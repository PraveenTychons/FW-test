<?php
/**
* @author Amasty Team
* @copyright Copyright (c) 2022 Amasty (https://www.amasty.com)
* @package Push Notifications for Magento 2
*/

namespace Amasty\PushNotifications\Controller;

class RegistryConstants
{
    public const USER_FIREBASE_TOKEN_PARAMS_KEY_NAME = 'userToken';
    public const CAMPAIGN_ID_PARAMS_KEY_NAME = 'campaignId';
    public const FIREBASE_SUBSCRIBE_URL_PATH = 'amasty_notifications/firebase/subscribe';
    public const FIREBASE_CLICK_COUNTER_URL_PATH = 'amasty_notifications/firebase/counter';
    public const CLICK_COUNTER_FLAG_PARAM_NAME = 'amcounter';
    public const CLICK_COUNTER_URL_PATH_PARAM_NAME = 'counterUrlPath';
    public const REGISTRY_TEST_NOTIFICATION_NAME = 'amasty-notification-test';
}
