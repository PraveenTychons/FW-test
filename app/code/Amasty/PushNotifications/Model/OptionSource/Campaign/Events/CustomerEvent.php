<?php
/**
* @author Amasty Team
* @copyright Copyright (c) 2022 Amasty (https://www.amasty.com)
* @package Push Notifications for Magento 2
*/
declare(strict_types=1);

namespace Amasty\PushNotifications\Model\OptionSource\Campaign\Events;

use Magento\Framework\Data\OptionSourceInterface;

class CustomerEvent implements OptionSourceInterface
{
    public const REGISTER_SUCCESS = 'customer_register_success';
    public const CUSTOMER_LOGIN = 'customer_login';
    public const CUSTOMER_LOGOUT = 'customer_logout';
    public const GROUP_CHANGING = 'group_changing';
    public const BIRTHDAY = 'birthday';

    /**
     * @inheritDoc
     */
    public function toOptionArray(): array
    {
        return [
            [
                'value' => self::REGISTER_SUCCESS,
                'label' => __('Registration')
            ],
            [
                'value' => self::CUSTOMER_LOGIN,
                'label' => __('Login')
            ],
            [
                'value' => self::CUSTOMER_LOGOUT,
                'label' => __('Logout')
            ],
            [
                'value' => self::GROUP_CHANGING,
                'label' => __('Group Changing')
            ],
            [
                'value' => self::BIRTHDAY,
                'label' => __('Birthday')
            ]
        ];
    }

    /**
     * @return array|false
     */
    public function toArray()
    {
        $optionArray = $this->toOptionArray();
        $labels = array_column($optionArray, 'label');
        $values = array_column($optionArray, 'value');

        return array_combine($values, $labels);
    }
}
