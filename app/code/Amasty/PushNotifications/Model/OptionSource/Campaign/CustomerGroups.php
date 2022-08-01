<?php
/**
* @author Amasty Team
* @copyright Copyright (c) 2022 Amasty (https://www.amasty.com)
* @package Push Notifications for Magento 2
*/

namespace Amasty\PushNotifications\Model\OptionSource\Campaign;

use Magento\Framework\Data\OptionSourceInterface;
use Magento\Customer\Model\ResourceModel\Group\Collection;

/**
 * Class CustomerGroups
 */
class CustomerGroups implements OptionSourceInterface
{
    /**
     * @var Collection
     */
    private $customerGroupCollection;

    public function __construct(
        Collection $customerGroupCollection
    ) {
        $this->customerGroupCollection = $customerGroupCollection;
    }

    public function toOptionArray()
    {
        return $this->customerGroupCollection->toOptionArray();
    }
}
