<?php

namespace Mjfox\Education\Controller\Coupon;

use Magento\Framework\App\Action\Action as Action;
use Magento\Framework\App\ResponseInterface;
use Magento\Customer\Model\Session as CustomerSession;

class Index extends Action
{
    /**
     * @var \Magento\Quote\Api\CartManagementInterface
     */
    private $_quoteManagement;

    /**
     * @var \Magento\Catalog\Model\ProductFactory
     */
    private $_productFactory;

    /**
     * @var \Magento\Checkout\Model\Session
     */
    private $_session;

    /**
     * @var \Magento\Store\Model\Store
     */
    private $_store;
    /**
     * @var \Magento\Quote\Api\CartRepositoryInterface
     */
    private $_cartRepositoryInterface;
    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    private $resultPageFactory;
    /**
     * @var CustomerSession
     */
    private $customerSession;

    /**
     * Index constructor.
     *
     * @param \Magento\Framework\App\Action\Context      $context
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     * @param \Magento\Catalog\Model\Product             $product
     * @param \Magento\Quote\Api\CartRepositoryInterface $cartRepositoryInterface
     * @param \Magento\Store\Model\Store                 $store
     * @param \Magento\Checkout\Model\Session            $session
     * @param \Magento\Catalog\Model\ProductFactory      $productFactory
     * @param \Magento\Quote\Api\CartManagementInterface $quoteManagement
     * @param CustomerSession                            $customerSession
     */
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Magento\Catalog\Model\Product $product,
        \Magento\Quote\Api\CartRepositoryInterface $cartRepositoryInterface,
        \Magento\Store\Model\Store $store,
        \Magento\Checkout\Model\Session $session,
        \Magento\Catalog\Model\ProductFactory $productFactory,
        \Magento\Quote\Api\CartManagementInterface $quoteManagement,
        CustomerSession $customerSession
    ) {
        $this->resultPageFactory        = $resultPageFactory;
        $this->_cartRepositoryInterface = $cartRepositoryInterface;
        $this->_store                   = $store;
        $this->_session                 = $session;
        $this->_productFactory          = $productFactory;
        $this->_quoteManagement         = $quoteManagement;
        $this->customerSession = $customerSession;

        parent::__construct($context);
    }

    /**
     * @return ResponseInterface|\Magento\Framework\Controller\ResultInterface|void
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();

        $product_id = $this->getRequest()->getParam('product');
        $coupon = $this->getRequest()->getParam('coupon');

        $product = $this->_productFactory->create();
        $product->load($product_id);

        if ($this->customerSession->isLoggedIn()) {
            $customer = $this->customerSession->getCustomer();
            $quote = $this->_quoteManagement->getCartForCustomer($customer->getId());
            $quote->addProduct($product);

            $this->_cartRepositoryInterface->save($quote);
            $quote->collectTotals();
        } else {
            if ($this->_session->getQuote()) {
                $quote = $this->_session->getQuote();
            } else {
                $quoteId = $this->_quoteManagement->createEmptyCart();
                $this->_session->setQuoteId($quoteId);
                $quote = $this->_cartRepositoryInterface->get($quoteId);
            }
            $quote->addProduct($product);
            $quote->setCouponCode($coupon);
            $quote->collectTotals();
            $quote->save();
        }
        //require('Magento_Customer/js/customer-data').reload(['cart'], false)
         return $resultRedirect->setPath('customer/account/?reload');
    }
}
