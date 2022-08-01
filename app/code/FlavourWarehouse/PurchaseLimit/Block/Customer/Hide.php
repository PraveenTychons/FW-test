<?php

namespace FlavourWarehouse\PurchaseLimit\Block\Customer;

use Magento\Framework\App\DefaultPathInterface;

class Hide extends \Magento\Framework\View\Element\Html\Link\Current
{
    protected $_customerSession;

    protected $customerGroup;

    protected $logger;

    protected $helper;

    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Customer\Model\Session $customerSession,
        \FlavourWarehouse\PurchaseLimit\Helper\Data $helper,
        \Magento\Customer\Model\ResourceModel\Group\Collection $customerGroup,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Customer\Model\CustomerFactory $customerFactory,
        \Psr\Log\LoggerInterface $logger,
        DefaultPathInterface $default,
        array $data = []
     ) {
         $this->logger = $logger;
         $this->helper = $helper;
         $this->customerFactory = $customerFactory;
         $this->scopeConfig = $scopeConfig;
         $this->_customerSession = $customerSession;
         $this->customerGroup = $customerGroup;
         parent::__construct($context, $default);
        
     }

    protected function _toHtml()
    {
        $responseHtml = null; 
        if ($this->_customerSession->isLoggedIn()) {
            $customerGroupId = $this->_customerSession->getCustomer()->getGroupId(); 
            
            $oldValues  = $this->helper->getLimitData();
            if($oldValues){
        		foreach ($oldValues as $value) {
                	if (is_array($value)) {
                        $value['customer_group'];
                }
            }
            if ($customerGroupId == $value['customer_group']) {
                $responseHtml = parent::_toHtml(); 
            }
        }
        }
        return $responseHtml;
    }
}