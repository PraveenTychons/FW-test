<?php
namespace FlavourWarehouse\PurchaseLimit\Observer;

use FlavourWarehouse\PurchaseLimit\Helper\Data;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Message\ManagerInterface;
use Magento\Framework\UrlInterface;
use Psr\Log\LoggerInterface;

/**
 * Class RestrictCartObserver
 * @package FlavourWarehouse\PurchaseLimit\Observer
 */
class RestrictCartObserver implements ObserverInterface
{
     /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    protected $scopeConfig;

    /**
     * @var \FlavourWarehouse\PurchaseLimit\Helper\Data
     */
    protected $helper;

     /**
    * @var \Psr\Log\LoggerInterface
    */
    protected $logger;

    /**
     * @var UrlInterface
     */
    private $url;

    /**
     * @var ManagerInterface
     */
    private $messageManager;

    /**
     * @var \Magento\Framework\Pricing\Helper\Data
     */
    private $formatPrice;

    const DEFAULT_NOTIFICATION_ERROR   =  'Your available purchase limit is %1 !';

    /**
     * RestrictCartObserver constructor.
     *
     * @param Data $data
     * @param ManagerInterface $messageManager
     * @param UrlInterface $url
     * @param LoggerInterface $logger
     * @param Magento\Framework\Pricing\Helper\Data $formatPrice
     * @param Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     * @param Magento\Checkout\Model\Session $checkoutSession
     */
    public function __construct(
        Data $data,
        ManagerInterface $messageManager,
        UrlInterface $url,
        LoggerInterface $logger,
        \Magento\Framework\Pricing\Helper\Data $formatPrice,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Checkout\Model\Session $checkoutSession
    ) {
        $this->helper = $data;
        $this->messageManager = $messageManager;
        $this->url = $url;
        $this->logger = $logger;
        $this->formatPrice = $formatPrice;
        $this->scopeConfig = $scopeConfig;
        $this->checkoutSession = $checkoutSession;
    }

    /**
     * @param \Magento\Framework\Event\Observer $observer
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $action = $observer->getControllerAction();
        $controller = $action->getRequest()->getControllerName();

      /*$module = $action->getRequest()->getRouteName();
        $path = $action->getRequest()->getPathInfo();

        main.INFO: CONTROLLER cart [] []
        main.INFO: MODULE checkout [] []
        main.INFO: PATH /checkout/cart/ [] []

        main.INFO: CONTROLLER index [] []
        main.INFO: MODULE checkout [] []
        main.INFO: PATH /checkout/ [] []

        main.INFO: CONTROLLER checkout [] []
        main.INFO: MODULE multishipping [] []
        main.INFO: PATH /multishipping/checkout/addresses/ [] [] */

        $isCart = 0;
        
        if ($controller == 'cart') {
            $isCart = 1;
        }

        $quote = $this->checkoutSession->getQuote();

        $isActive = $this->helper->isActive();
        $notificationMessage = $this->helper->getNotificationMessage();
        if ($notificationMessage == null) {
        	$notificationMessage = self::DEFAULT_NOTIFICATION_ERROR;
        }
        
        $redirectUrl = $this->helper->getRedirectUrl();
        $balanceLimit = $this->helper->getBalanceLimit();
        $resetDate = $this->helper->getresetDate();
        $amount = $quote->getSubtotal();

        if (!$isActive) {
            return;
        }
      
        if (!$balanceLimit) {
            return;
        }

        if (!$resetDate) {
            return;
        }

        if (!$amount) {
            return;
        }
       
        if (date("Y-m-d") > date("Y-m-d", strtotime($resetDate))) {
            if (!$isCart) {
                if ($redirectUrl == null) {
              		$action->getResponse()->setRedirect($this->url->getUrl("checkout/cart"));
              	} else {  
                	$action->getResponse()->setRedirect($this->url->getUrl($redirectUrl));
              	}
            } else {
                	$this->messageManager->addErrorMessage(__('Your Purchase limit expired on %1', date("m/d/Y", strtotime($resetDate))));
            }
        }

        if ($amount > $balanceLimit) {
            if (!$isCart) {
              	if ($redirectUrl == null) {
              		$action->getResponse()->setRedirect($this->url->getUrl("checkout/cart"));
              	} else {  
                	$action->getResponse()->setRedirect($this->url->getUrl($redirectUrl));
              	}
            } else {
                $this->messageManager->addErrorMessage(__($notificationMessage, 
                	$this->formatPrice->currency($balanceLimit, true, false)));
            }
        }
                
    }
}