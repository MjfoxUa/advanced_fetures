<?php
namespace Mjfox\Education\Controller\Index\CustomerLoggedIn;

use Magento\Customer\Model\CustomerFactory;
use Magento\Customer\Model\ResourceModel\Customer\CollectionFactory;
use Magento\Customer\Model\Session;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;

class Index extends Action
{
    protected $customerCollection;
    protected $customerModel;
    protected $customerSession;

    /**
     * Index constructor.
     *
     * @param Context                            $context
     * @param CollectionFactory $customerCollection
     * @param CustomerFactory                          $customerModel
     * @param Session                                  $customerSession
     */
    public function __construct(
        Context                  $context,
        CollectionFactory        $customerCollection,
        CustomerFactory          $customerModel,
        Session                  $customerSession
    ) {
        parent::__construct($context);

        $this->customerCollection = $customerCollection;
        $this->customerModel = $customerModel;
        $this->customerSession = $customerSession;
    }

    public function execute()
    {
        $id = $this->getRequest()->getParam('id');
        $resultRedirect = $this->resultRedirectFactory->create();

        if (!$this->customerSession->isLoggedIn()) {
            $collection = $this->customerCollection->create();
            $collection->addAttributeToFilter('id', $id);
            if ($collection->getSize()) {
                $customer_id = $collection->getFirstItem()->getId();
                $customer = $this->customerModel->create()->load($customer_id);
                $this->customerSession->setCustomerAsLoggedIn($customer);
                $this->_redirect('customer/account/index');
                return false;
            }
        }

        return $resultRedirect->setPath('customer/account/');
    }
}
