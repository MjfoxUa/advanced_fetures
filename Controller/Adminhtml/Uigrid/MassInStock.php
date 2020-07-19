<?php

namespace Mjfox\Education\Controller\Adminhtml\Uigrid;

use Magento\Backend\App\Action;
use Magento\Backend\Model\View\Result\Redirect;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Exception\LocalizedException;
use Magento\Ui\Component\MassAction\Filter;
use Mjfox\Education\Model\ResourceModel\Education\CollectionFactory;

class MassInStock extends Action implements HttpPostActionInterface
{
    /**
     * @var CollectionFactory
     */
    private $collectionFactory;
    /**
     * @var Filter
     */
    private $filter;

    /**
     * MassDelete constructor.
     *
     * @param Context           $context
     * @param Filter            $filter
     * @param CollectionFactory $collectionFactory
     */
    public function __construct(Context $context, Filter $filter, CollectionFactory $collectionFactory)
    {
        $this->filter = $filter;
        $this->collectionFactory = $collectionFactory;
        parent::__construct($context);
    }

    public function execute()
    {
        $collection = $this->filter->getCollection($this->collectionFactory->create());
        $collectionSize = $collection->getSize();

        foreach ($collection as $block) {
            $block->setStatus(1);
            $block->save();
        }

        $this->messageManager->addSuccessMessage(__('A total of %1 record(s) changed status.', $collectionSize));

        /** @var Redirect $resultRedirect */
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        return $resultRedirect->setPath('*/*/');
    }
}
