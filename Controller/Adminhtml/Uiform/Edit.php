<?php
/**
 * Plumrocket Inc.
 * NOTICE OF LICENSE
 * This source file is subject to the End-user License Agreement
 * that is available through the world-wide-web at this URL:
 * http://wiki.plumrocket.net/wiki/EULA
 * If you are unable to obtain it through the world-wide-web, please
 * send an email to support@plumrocket.com so we can send you a copy immediately.
 *
 * @package     Plumrocket magento
 * @copyright   Copyright (c) 2020 Plumrocket Inc. (http://www.plumrocket.com)
 * @license     http://wiki.plumrocket.net/wiki/EULA  End-user License Agreement
 */

namespace Mjfox\Education\Controller\Adminhtml\Uiform;

use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\Page;
use Magento\Backend\Model\View\Result\Redirect;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Controller\ResultInterface;
use Magento\Store\Model\StoreManagerInterface;
use Mjfox\Education\Controller\Adminhtml\Uiform;

class Edit extends Uiform
{
    /**
     * @var StoreManagerInterface
     */
    private $storeManager;

    /**
     * @var Builder
     */
    private $uiformBuilder;

    /**
     * Edit constructor.
     *
     * @param Context               $context
     * @param StoreManagerInterface $storeManager
     * @param Builder               $uiformBuilder
     */
    public function __construct(
        Context $context,
        StoreManagerInterface $storeManager,
        Builder $uiformBuilder
    ) {
        parent::__construct($context);
        $this->storeManager = $storeManager;
        $this->uiformBuilder = $uiformBuilder;
    }
    /**
     * @return Page
     */
    public function execute()
    {

        $storeId = (int) $this->getRequest()->getParam('store', 0);
        $id = (int) $this->getRequest()->getParam('id');

        $store = $this->storeManager->getStore($storeId);
        $this->storeManager->setCurrentStore($store->getCode());

        $checkbox = $this->uiformBuilder->build($this->getRequest());

        if ($id && ! $checkbox->getId()) {
            $this->messageManager->addErrorMessage(__('This form no longer exists.'));

            /** @var Redirect $resultRedirect */
            $resultRedirect = $this->resultRedirectFactory->create();

            return $resultRedirect->setPath('*/*/');
        }

        /** @var Page $resultPage */
        $resultPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE);

        $this->initEducationForm($resultPage)->addBreadcrumb(
            $id ? __('Edit Form') : __('New Form'),
            $id ? __('Edit Form') : __('New Form')
        );

        $title = $resultPage->getConfig()->getTitle();

        $title->prepend(__('Uiform'));
        $title->prepend($checkbox->getId()
            ? __('Edit Form (ID: %1)', $checkbox->getId())
            : __('New Form'));

        return $resultPage;
    }
}
