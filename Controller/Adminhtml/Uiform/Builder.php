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

use Magento\Framework\App\RequestInterface;
use Magento\Framework\Registry;
use Magento\Store\Model\Store;
use Magento\Store\Model\StoreFactory;
use Magento\Store\Model\StoreManagerInterface;
use Mjfox\Education\Model\Education;
use Mjfox\Education\Model\EducationFactory;

class Builder
{
    /**
     * @var Registry
     */
    private $coreRegistry;

    /**
     * @var EducationFactory
     */
    private $educationFactory;

    /**
     * @var \Mjfox\Education\Model\Education
     */
    private $educationResource;

    /**
     * @var StoreManagerInterface
     */
    private $storeManager;

    /**
     * @var StoreFactory
     */
    private $storeFactory;

    /**
     * Builder constructor.
     *
     * @param Registry                                       $coreRegistry
     * @param EducationFactory                               $educationFactory
     * @param \Mjfox\Education\Model\ResourceModel\Education $educationResource
     * @param StoreManagerInterface                          $storeManager
     * @param StoreFactory                                   $storeFactory
     */
    public function __construct(
        Registry $coreRegistry,
        EducationFactory $educationFactory,
        \Mjfox\Education\Model\ResourceModel\Education $educationResource,
        StoreManagerInterface $storeManager,
        StoreFactory $storeFactory
    ) {
        $this->coreRegistry = $coreRegistry;
        $this->educationFactory = $educationFactory;
        $this->educationResource = $educationResource;
        $this->storeManager = $storeManager;
        $this->storeFactory = $storeFactory;
    }

    public function build(RequestInterface $request)
    {
        $storeId = (int) $request->getParam('store', 0);
        $educationId = (int) $request->getParam('id');

        $store = $this->storeManager->getStore($storeId);
        $this->storeManager->setCurrentStore($store->getCode());

        /** @var Education $education */
        $education = $this->educationFactory->create();

        if ($educationId) {
            $this->educationResource->load($education, $educationId);
        }

        /** @var Store $store */
        $store = $this->storeFactory->create();
        $store->load($storeId);

        $education->setStoreId($store->getId());

        $this->coreRegistry->register('current_store', $store);
        $this->coreRegistry->register('current_mj_education', $education);

        return $education;
    }
}
