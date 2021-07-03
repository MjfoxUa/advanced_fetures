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
use Mjfox\Education\Controller\Adminhtml\Uiform;
use Mjfox\Education\Model\Education;

class Save extends Uiform
{
    /**
     * @var Education
     */
    private $education;

    public function __construct(
        Context $context,
        Education $education
    ) {
        parent::__construct($context);
        $this->education = $education;
    }

    public function execute()
    {
        $data = $this->getRequest()->getParams();
        $resultRedirect = $this->resultRedirectFactory->create();

        try {
            if (! empty($data)) {
                if (isset($data['id'])) {
                    $this->education->load($data['id']);
                }

                $this->education->setData($data)->save();
                $gatewayId = $this->education->getId();
            }

            $this->messageManager->addSuccessMessage(__('Successfully saved'));
        } catch (\Exception $e) {
            $this->messageManager->addExceptionMessage($e, __('Something went wrong while saving.'));
        }

        if (isset($data['back'])) {
            $resultRedirect->setPath('*/*/edit', ['id' => $gatewayId, '_current' => true]);
        } else {
            $resultRedirect->setPath('edu/uigrid/index');
        }

        return $resultRedirect;
    }
}
