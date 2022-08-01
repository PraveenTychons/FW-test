<?php

namespace FlavourWarehouse\PurchaseLimit\Observer;

use FlavourWarehouse\PurchaseLimit\Helper\Data;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Event\Observer;
use Magento\Framework\Message\ManagerInterface;
use Magento\Framework\Exception\LocalizedException;
use Psr\Log\LoggerInterface;
use Magento\Customer\Api\CustomerRepositoryInterface;

class CreditRefund implements ObserverInterface
{

     /**
     * @var \FlavourWarehouse\PurchaseLimit\Helper\Data
     */
    protected $helper;

    public function __construct(
        ManagerInterface $messageManager,
        LoggerInterface $logger,
        Data $data,
        CustomerRepositoryInterface $customerRepositoryInterface
    ) {
        $this->logger = $logger;
        $this->helper = $data;
        $this->messageManager = $messageManager;
        $this->customerRepositoryInterface = $customerRepositoryInterface;
    }

    /**
     * @param Observer $observer
     *
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function execute(Observer $observer)
    {

        $isActive = $this->helper->isActive();
        $creditmemo = $observer->getEvent()->getCreditmemo();
        $order = $creditmemo->getOrder();
        $creditmemoqty = $creditmemo->getTotalQty();
        $creditmemoSubtotal = $creditmemo->getSubtotal();       
        $creditmemoTax = $creditmemo->getBaseTaxAmount();
        $customerId = $order->getCustomerId();
        $creditIncrementId = $order->getIncrementId();
        $customer = $this->customerRepositoryInterface->getById($customerId);
        
        if($isActive){
            $allowanceleft = $customer->getCustomAttribute('balance_limit');
            $resetDate = $customer->getCustomAttribute('reset_date');
            if(empty($allowanceleft) || empty($resetDate)){
                return $this;
            }
            $balanceLimit = $allowanceleft->getValue();
            $addedBalance = $creditmemoSubtotal + $creditmemoTax;
            $newBalance = $balanceLimit + $addedBalance; 
            $customer->setCustomAttribute('balance_limit', $newBalance);
            $this->customerRepositoryInterface->save($customer);
            return $newBalance;
        }    
    }
}