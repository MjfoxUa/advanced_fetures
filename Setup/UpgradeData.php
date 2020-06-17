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

namespace Mjfox\Education\Setup;

use Magento\Framework\Setup\UpgradeDataInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Cms\Model\BlockFactory;
use Magento\Cms\Model\PageFactory;

class UpgradeData implements UpgradeDataInterface
{
    private $blockFactory;
    private $pageFactory;

    public function __construct(BlockFactory $blockFactory, PageFactory $pageFactory)
    {
        $this->pageFactory = $pageFactory;
        $this->blockFactory = $blockFactory;
    }

    public function upgrade(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        if (version_compare($context->getVersion(), '1.1.0', '<')) {
            $cmsBlockData = [
                'title' => 'Education CMS Block',
                'identifier' => 'education_cms_block',
                'is_active' => 1,
                'stores' => [0]
            ];

            $this->blockFactory->create()->setData($cmsBlockData)->save();

            $testPage = [
                'title' => 'Test page title',
                'identifier' => 'test-page',
                'stores' => [0],
                'is_active' => 1,
                'content_heading' => 'Test page heading',
                'content' => 'Test page content',
                'page_layout' => '1column'
            ];

            $this->pageFactory->create()->setData($testPage)->save();
        }
    }
}
