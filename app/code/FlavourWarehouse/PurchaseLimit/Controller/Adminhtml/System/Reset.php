<?php
/**
 * Copyright © 2016 MageWorx. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace FlavourWarehouse\PurchaseLimit\Controller\Adminhtml\System;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\Result\JsonFactory;
use Psr\Log\LoggerInterface;

class Reset extends Action
{

    protected $resultJsonFactory;

    /**
     * @var Data
     */
    protected $helper;
    protected $logger;
    /**
     * @param Context $context
     * @param JsonFactory $resultJsonFactory
     * @param Data $helper
     */
    public function __construct(
        Context $context,
        JsonFactory $resultJsonFactory,
        LoggerInterface $logger,
        \FlavourWarehouse\PurchaseLimit\Helper\Data $helper,
        \Magento\Customer\Model\CustomerFactory $customerFactory,
        \Magento\Customer\Model\ResourceModel\Customer $customerResource
        
    )
    {
        $this->helper = $helper;
        $this->logger = $logger;
        $this->customerFactory = $customerFactory;
        $this->customerResource = $customerResource;
        $this->resultJsonFactory = $resultJsonFactory;
       
        parent::__construct($context);
    }

    public function execute()
    {
        $oldValues  = $this->helper->getLimitData();
            if($oldValues){
        		foreach ($oldValues as $value) {
                	if (is_array($value)) {
                        $value['customer_group'];
                    }
                $customerGroup = $this->customerFactory->create()->getCollection()
                ->addAttributeToSelect("*")
                ->addAttributeToFilter("group_id",array("eq" => $value['customer_group']) )->load();
                    foreach($customerGroup as $customer){
                        $customer->setPurchaseLimit(NULL);
                        $customer->setBalanceLimit(NULL);
                        $customer->setResetDate(NULL);
                        $this->customerResource->saveAttribute($customer, 'purchase_limit');
                        $this->customerResource->saveAttribute($customer, 'balance_limit');
                        $this->customerResource->saveAttribute($customer, 'reset_date');
                        //$customer->save();        
                    }
                }
            }
    }
}
?>
