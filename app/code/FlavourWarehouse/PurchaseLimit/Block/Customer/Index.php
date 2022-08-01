<?php

namespace FlavourWarehouse\PurchaseLimit\Block\Customer;

class Index extends \Magento\Framework\View\Element\Template
{
    protected $customerSession;

	public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Customer\Model\Session $customerSession,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Magento\Customer\Api\CustomerRepositoryInterface $customerRepositoryInterface,
        \Magento\Framework\Pricing\Helper\Data $formatPrice
    )
	{
		parent::__construct($context);
        $this->customerSession = $customerSession;
        $this->customerRepositoryInterface = $customerRepositoryInterface;
        $this->resultPageFactory = $resultPageFactory;
        $this->formatPrice = $formatPrice;

	}

	public function CustomCustomerAttributes(){

        $result['reset_date'] = null;
        $result['purchase_limit'] = null;
        $result['balance_limit'] = null;
        if($this->customerSession){
            $customerId = $this->customerSession->getCustomer()->getId();
            $customerData =$this->customerRepositoryInterface->getById($customerId);

            $purchaseLimit = $customerData->getCustomAttribute('purchase_limit');
            ($purchaseLimit !== null) ? $result['purchase_limit'] = $this->formatPrice->currency($purchaseLimit->getValue(), true, false)  : $result['purchase_limit'] = "-";

            $balanceLimit = $customerData->getCustomAttribute('balance_limit');
            ($balanceLimit !== null) ? $result['balance_limit'] =  $this->formatPrice->currency($balanceLimit->getValue(), true, false) : $result['balance_limit'] = "-";

            $resetDate = $customerData->getCustomAttribute('reset_date');
            ($resetDate !== null) ? $result['reset_date'] = $this->convertToTime($resetDate->getValue()) : $result['reset_date'] = "-";
            return $result;
        }
    }

    public function convertToTime($timestamp){

        $converted = date('d M Y h.i.s A', strtotime($timestamp));
        $reversed = date('d-m-Y', strtotime($converted));
        return $result['reset_date'] = $reversed;
        
    }
}


