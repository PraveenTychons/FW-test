<?php
/**
* @author Amasty Team
* @copyright Copyright (c) 2022 Amasty (https://www.amasty.com)
* @package Push Notifications for Magento 2
*/

namespace Amasty\PushNotifications\Controller;

use Amasty\PushNotifications\Model\ConfigProvider;
use Magento\Framework\App\Action\Forward;
use Magento\Framework\App\ActionFactory;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\App\RouterInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Module\Manager;

class Router implements RouterInterface
{
    public const FIREBASE_MESSAGING_SW_FILE_CONTENT_ACTION_PATH = 'amasty_notifications/firebase/content';

    public const FIREBASE_MESSAGING_SW_FILE_NAME = 'firebase-messaging-sw.js';

    /**
     * @var ActionFactory
     */
    private $actionFactory;

    /**
     * @var ResponseInterface
     */
    private $_response;

    /**
     * @var  Manager
     */
    private $moduleManager;

    /**
     * @var ConfigProvider
     */
    private $configProvider;

    /**
     * @var ResultFactory
     */
    private $resultFactory;

    public function __construct(
        ActionFactory $actionFactory,
        ResponseInterface $response,
        ConfigProvider $configProvider,
        ResultFactory $resultFactory,
        Manager $moduleManager
    ) {
        $this->actionFactory = $actionFactory;
        $this->_response = $response;
        $this->moduleManager = $moduleManager;
        $this->configProvider = $configProvider;
        $this->resultFactory = $resultFactory;
    }

    /**
     * @param RequestInterface $request
     *
     * @return \Magento\Framework\App\ActionInterface|null
     */
    public function match(RequestInterface $request)
    {
        $identifier = explode(DIRECTORY_SEPARATOR, trim($request->getPathInfo(), DIRECTORY_SEPARATOR));

        if ($this->configProvider->isModuleEnable()
            && in_array(self::FIREBASE_MESSAGING_SW_FILE_NAME, $identifier)
            && $this->configProvider->getSenderId() != ''
        ) {
            $request->setPathInfo(self::FIREBASE_MESSAGING_SW_FILE_CONTENT_ACTION_PATH);

            return $this->actionFactory->create(Forward::class);
        }

        return null;
    }
}
