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

use Exception;
use Magento\Backend\App\Action\Context;
use Magento\Backend\App\Action;
use Magento\Backend\Model\View\Result\Redirect;
use Magento\Framework\Exception\LocalizedException;
use Mjfox\Education\Controller\Adminhtml\Uiform;
use Mjfox\Education\Model\EducationFactory;

class Save extends Uiform
{

    /**
     * @var EducationFactory
     */
    private $educationFactory;

    public function __construct(
        Context $context,
        EducationFactory $educationFactory
    ) {
        $this->educationFactory = $educationFactory;
        parent::__construct($context);
    }

    public function execute()
    {
        /** @var Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();

        $postData = $this->getRequest()->getPostValue();
        $id = $postData['id'];

        /** @var Uiform $model */
        $model = $this->educationFactory->create();
        $model->load($id);

        $model->setData([
                "name" => $postData['name'],
                "description" => $postData['description']
        ]);
        $model->save();
        $this->messageManager->addSuccessMessage(__('You saved the consent location.'));
        return $resultRedirect->setPath('*/*/edit', ['location_id' => $model->getId()]);
    }
}
