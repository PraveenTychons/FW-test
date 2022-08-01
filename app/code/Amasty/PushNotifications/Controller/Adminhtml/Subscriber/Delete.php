<?php
/**
* @author Amasty Team
* @copyright Copyright (c) 2022 Amasty (https://www.amasty.com)
* @package Push Notifications for Magento 2
*/

namespace Amasty\PushNotifications\Controller\Adminhtml\Subscriber;

use Amasty\PushNotifications\Api\SubscriberRepositoryInterface;
use Amasty\PushNotifications\Controller\Adminhtml\Subscriber;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\Redirect;
use Magento\Framework\Exception\LocalizedException;

class Delete extends Subscriber
{
    /**
     * @var SubscriberRepositoryInterface
     */
    private $repository;

    public function __construct(
        Context $context,
        SubscriberRepositoryInterface $repository
    ) {
        parent::__construct($context);
        $this->repository = $repository;
    }

    /**
     * Delete action
     */
    public function execute()
    {
        $id = (int)$this->getRequest()->getParam('id');

        if ($id) {
            try {
                $this->repository->deleteById($id);
                $this->messageManager->addSuccessMessage(__('Subscriber is deleted.'));
            } catch (LocalizedException $exception) {
                $this->messageManager->addErrorMessage($exception->getMessage());
            }
        } else {
            $this->messageManager->addErrorMessage(__('Subscriber ID is not found.'));
        }

        /** @var Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        return $resultRedirect->setRefererUrl();
    }
}
