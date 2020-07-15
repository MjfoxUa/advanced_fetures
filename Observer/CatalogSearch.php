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

namespace Mjfox\Education\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\View\Result\PageFactory;
use Magento\Search\Helper\Data;
use Magento\Search\Model\QueryFactory;

class CatalogSearch implements ObserverInterface
{
    protected $_resultPageFactory;
    /**
     * @var Data
     */
    private $data;
    /**
     * @var QueryFactory
     */
    private $queryFactory;

    public function __construct(PageFactory $resultPageFactory, Data $data, QueryFactory $queryFactory)
    {
        $this->_resultPageFactory = $resultPageFactory;
        $this->data = $data;
        $this->queryFactory = $queryFactory;
    }

    public function execute(Observer $observer)
    {
       // var_dump($this->queryFactory->get()->getQueryText());
    }
}
