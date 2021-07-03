<?php


namespace Mjfox\Education\Controller\Adminhtml\Uiform;

use Magento\Backend\Model\View\Result\Redirect;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Mjfox\Education\Model\EducationFactory;

class Delete extends Action
{
    /**
     * @var EducationsFactory
     */
    private $educationFactory;

    /**
     * Delete constructor.
     *
     * @param Context           $context
     * @param EducationsFactory $educationFactory
     */
    public function __construct(
        Context $context,
        EducationFactory $educationFactory
    ) {
        $this->request = $context->getRequest();
        parent::__construct($context);
        $this->educationFactory = $educationFactory;
    }

    public function execute()
    {
        /** @var Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        $itemId = $this->getRequest()->getParam('id');
        try {
            if ($itemId) {
                $item = $this->educationFactory->create();
                $item->load($itemId);
                if ($item->getId()) {
                    $item->delete();
                    $this->messageManager->addSuccessMessage(__('You deleted the item.'));

                    return $resultRedirect->setPath('edu/uigrid');
                }
            }
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage($e->getMessage());

            return $resultRedirect->setPath('edu/uigrid', ['id' => $itemId]);
        }
        $this->messageManager->addErrorMessage(__('We can\'t find a item to delete.'));

        return $resultRedirect->setPath('*/*/');
    }
}
