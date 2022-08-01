<?php

namespace FlavourWarehouse\PurchaseLimit\Model\Config;

use Magento\Framework\App\Config\ScopeConfigInterface;
use FlavourWarehouse\PurchaseLimit\Helper\Data;
use Psr\Log\LoggerInterface;

/*https://www.magentoextensions.org/documentation/_serialized_8php_source.html*/

/**
 *
 * @package FlavourWarehouse\PurchaseLimit\Model\Config
 */
class Serialized extends \Magento\Framework\App\Config\Value
{
    /**
     * @var \Magento\Framework\Serialize\SerializerInterface
     */
    public $serializer;

    /**
     * Serialized constructor.
     * @param \Magento\Framework\Model\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param ScopeConfigInterface $config
     * @param \Magento\Framework\App\Cache\TypeListInterface $cacheTypeList
     * @param \Magento\Framework\Serialize\SerializerInterface $serializer
     * @param \Magento\Framework\Model\ResourceModel\AbstractResource|null $resource
     * @param \Magento\Framework\Data\Collection\AbstractDb|null $resourceCollection
     * @param \Magento\Customer\Model\CustomerFactory $customerFactory
     * @param LoggerInterface $logger
     * @param Data $helper
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        ScopeConfigInterface $config,
        \Magento\Framework\App\Cache\TypeListInterface $cacheTypeList,
        \Magento\Framework\Serialize\SerializerInterface $serializer,
        \Magento\Framework\Model\ResourceModel\AbstractResource $resource = null,
        \Magento\Framework\Data\Collection\AbstractDb $resourceCollection = null,
        \Magento\Customer\Model\CustomerFactory $customerFactory,
        \Magento\Customer\Model\ResourceModel\Customer $customerResource,
        LoggerInterface $logger,
        Data $helper,
        array $data = []
    ) {
        $this->serializer = $serializer;
        $this->customerFactory = $customerFactory;
        $this->customerResource = $customerResource;
        $this->logger = $logger;
        $this->helper = $helper;
        parent::__construct(
            $context,
            $registry,
            $config,
            $cacheTypeList,
            $resource,
            $resourceCollection,
            $data
        );
    }

    /**
     * @return \Magento\Framework\App\Config\Value|void
     */
    protected function _afterLoad()
    {
        if (!is_array($this->getValue())) {
            $value = $this->getValue();
            $this->setValue(empty($value) ? false : $this->serializer->unserialize($value));
        }
    }

    /**
     * @return \Magento\Framework\App\Config\Value
     * @throws \Magento\Framework\Exception\ValidatorException
     */
    public function beforeSave()
    {
        $newValues     = $this->getValue();
        if (is_array($newValues)) {
            unset($newValues['__empty']);
            $arrCustomerGroup = [];
            foreach ($newValues as $value) {
                if (is_array($value)) {
                    $arrCustomerGroup[] = $value['customer_group'];
                    if (!is_numeric($value['purchase_limit'])) {
                        throw new \Magento\Framework\Exception\ValidatorException(__(
                            'Purchase Limit must be a number!'
                        ));
                    } elseif ($value['purchase_limit'] < 0) {
                        throw new \Magento\Framework\Exception\ValidatorException(__(
                            'Purchase Limit must be greater than zero!'
                        ));
                    }

                    if (((bool)strtotime($value['reset_date'])) != 1) {
                        throw new \Magento\Framework\Exception\ValidatorException(__(
                            'Invalid reset date!'
                        ));
                    }
                }
            }
            $this->isUniqueCustomerGroup($arrCustomerGroup);
            $this->updateCustomerData($newValues);
        }

        $this->setValue($newValues);

        if (is_array($this->getValue())) {
            $this->setValue($this->serializer->serialize($this->getValue()));
        }
        return parent::beforeSave();
    }


    /**
     * @param array $arrCustomerGroup
     * @throws \Magento\Framework\Exception\ValidatorException
     */
    protected function isUniqueCustomerGroup($arrCustomerGroup)
    {
        $uniqueCustomerGroup = array_unique($arrCustomerGroup);
        if ($uniqueCustomerGroup != $arrCustomerGroup) {
            throw new \Magento\Framework\Exception\ValidatorException(__(
                'Customer group should be unique!'
            ));
        }
    }

    /**
     * @param array $newValues
     * @throws \Magento\Framework\Exception\ValidatorException
     */
    protected function updateCustomerData($newValues)
    {
        try {
            $oldValues  = $this->helper->getLimitData();
            if ($oldValues !== $newValues) {
                foreach ($newValues as $value) {
                    if (is_array($value)) {
                        $customerGroup = $this->customerFactory->create()->getCollection()
                            ->addAttributeToSelect("*")
                            ->addAttributeToFilter("group_id", array("eq" => $value['customer_group']))->load();
                        foreach ($customerGroup as $customer) {
                            if ($customer->getBalanceLimit() == NULL) {
                                $customer->setPurchaseLimit($value['purchase_limit']);
                                $customer->setBalanceLimit($value['purchase_limit']);
                                $effectiveResetDate = date('d-m-Y', strtotime($value['reset_date']));
                                $customer->setResetDate($effectiveResetDate);
                                $this->saveAttributeData($customer);
                            }
                            $purchaseLimitDefault = $customer->getPurchaseLimit();
                            if ($oldValues) {
                                foreach ($oldValues as $oldValue) {
                                    if (is_array($oldValue)) {
                                        $oldValue['purchase_limit'];
                                    }
                                }
                                if ($purchaseLimitDefault == $oldValue['purchase_limit']) {
                                    $customer->setPurchaseLimit($value['purchase_limit']);
                                    $customer->setBalanceLimit($value['purchase_limit']);
                                    $effectiveResetDate = date('d-m-Y', strtotime($value['reset_date']));
                                    $customer->setResetDate($effectiveResetDate);
                                    $this->saveAttributeData($customer);
                                }
                            }

                            //$customer->save();        
                        }
                    }
                }
            }
        } catch (\Exception $e) {
            throw new \Magento\Framework\Exception\ValidatorException(__(
                'Cannot save customer data!' . $e->getMessage()
            ));
        }
    }

    public function saveAttributeData($customerData)
    {
        $this->customerResource->saveAttribute($customerData, 'purchase_limit');
        $this->customerResource->saveAttribute($customerData, 'balance_limit');
        $this->customerResource->saveAttribute($customerData, 'reset_date');
    }
}
