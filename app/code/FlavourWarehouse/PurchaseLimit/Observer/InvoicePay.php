<?php
namespace FlavourWarehouse\PurchaseLimit\Observer; 

use Magento\Framework\Event\ObserverInterface; 
use FlavourWarehouse\PurchaseLimit\Helper\Data;
use Psr\Log\LoggerInterface;
use Magento\Customer\Model\Session;
use Magento\Customer\Api\CustomerRepositoryInterface;

class InvoicePay implements ObserverInterface 
{

	protected $logger;

     /**
     * @var \FlavourWarehouse\PurchaseLimit\Helper\Data
     */
    protected $helper;


	public function __construct(
        LoggerInterface $logger,
        Data $data,
        Session $customerSession,
        CustomerRepositoryInterface $customerRepositoryInterface
	)
	{
		$this->logger = $logger;
        $this->helper = $data;
        $this->_customerSession = $customerSession;
        $this->customerRepositoryInterface = $customerRepositoryInterface;
	}

	public function execute(\Magento\Framework\Event\Observer $observer) {
	          
        $isActive = $this->helper->isActive();
        $invoice = $observer->getEvent()->getInvoice();
        $order = $invoice->getOrder();
        $orderId = $order->getIncrementId();
        $orderStatus = $order->getState();
        $orderSubtotal = $order->getSubtotal();
        $baseTaxAmount = $order->getBaseTaxAmount();
        $customerId = $order->getCustomerId();
        $customer =$this->customerRepositoryInterface->getById($customerId);

        if($isActive){
            /**
            * use 'new' when the order is set to invoice
            */
            if($orderStatus == 'new'){
                $allowanceleft = $customer->getCustomAttribute('balance_limit');
                $resetDate = $customer->getCustomAttribute('reset_date');
                if(empty($allowanceleft) || empty($resetDate)){
                    return $this;
                }
                $storedValue = $allowanceleft->getValue();
                $deductedValue = $orderSubtotal + $baseTaxAmount;
                $newAllowance = $storedValue - $deductedValue;
                if($newAllowance < 0){
                    $newAllowance = 0;
                }
                $customer->setCustomAttribute('balance_limit', $newAllowance);
                $this->customerRepositoryInterface->save($customer);
                return $this;    
            }
        }
	}
}


