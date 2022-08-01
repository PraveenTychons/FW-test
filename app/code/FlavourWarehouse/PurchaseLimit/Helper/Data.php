<?php

namespace FlavourWarehouse\PurchaseLimit\Helper;

class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
   
    /**
     * @var \Magento\Customer\Model\Session
     */
    protected $customerSession;

    /**
     * @var \Magento\Framework\Serialize\SerializerInterface
     */
    protected $serializer;

    /**
     * @var \Magento\Customer\Api\CustomerRepositoryInterface
     */
    protected $customerRepositoryInterface;

    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface 
     */
    protected $scopeConfig;

    /**
     * @param \Magento\Framework\App\Helper\Context $context
     * @param \Magento\Customer\Model\Session $customerSession
     * @param \Magento\Framework\Serialize\SerializerInterface $serializer
     * @param \Magento\Customer\Api\CustomerRepositoryInterface $customerRepositoryInterface
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     */

    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \Magento\Customer\Model\Session $customerSession,
        \Magento\Framework\Serialize\SerializerInterface $serializer,
        \Magento\Customer\Api\CustomerRepositoryInterface $customerRepositoryInterface,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
    ) {
        parent::__construct($context);
        $this->customerSession = $customerSession;
        $this->serializer = $serializer;
        $this->customerRepositoryInterface = $customerRepositoryInterface;
        $this->scopeConfig = $scopeConfig;
    }

    /**
     * @return bool|mixed
     */
    public function getCustomer(){
        if (empty($this->customerSession->getCustomer()->getData())) {
            return null;
        } else {
            $customerId = $this->customerSession->getCustomer()->getId();
            return $this->customerRepositoryInterface->getById($customerId);
        }
    }

    /**
     *
     * @param mixed $store
     * @return bool|mixed
     */
    public function getLimitData($store = null){
        $limitData = $this->scopeConfig->getValue(
            'purchase_limit/general/limitdata',
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE,
            $store
        );

        try {
            return $this->serializer->unserialize($limitData);
        } catch (\Exception $e) {
            return false;
        }
    }

    public function getRetainValue($store = null){
        $retainValue = $this->scopeConfig->getValue(
            'purchase_limit/general/checkbox',
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE,
            $store
        );
        return $retainValue;
    }

    /**
     * @return float|int
     */
    public function getBalanceLimit(){
        $balanceLimit = null;
        if (!empty($this->getCustomer())) {
            if ($this->getCustomer()->getCustomAttribute('balance_limit') != null) {
                $balanceLimit = floatval($this->getCustomer()->getCustomAttribute('balance_limit')->getValue());
            }
        }
        return $balanceLimit;
    }
   

    /**
     * @return mixed|null
     */
    public function getResetDate(){
        $resetDate = null;
        if (!empty($this->getCustomer())) {
            if ($this->getCustomer()->getCustomAttribute('reset_date') != null) {
                $resetDate = $this->getCustomer()->getCustomAttribute('reset_date')->getValue();
            }
        }
        return $resetDate;
    }

    /**
     * @param int|null $storeId
     * @return mixed
     */
    public function isActive($storeId = null){
        $isActive = $this->scopeConfig->isSetFlag(
            'purchase_limit/general/is_active',
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE,
            $storeId
        );
        return $isActive;
    }

    /**
     * @param int|null $storeId
     * @return mixed
     */
    public function getNotificationMessage($storeId = null){
        $notificationMessage = $this->scopeConfig->getValue(
            'purchase_limit/general/notification',
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE,
            $storeId
        );
        return $notificationMessage;
    }    
    
    /**
     * @param int|null $storeId
     * @return mixed
     */    
    public function getRedirectUrl($storeId = null){
        $redirectUrl = $this->scopeConfig->getValue(
            'purchase_limit/general/redirect_url',
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE,
            $storeId
        );
        return $redirectUrl;
    }    

}