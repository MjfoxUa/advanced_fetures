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

use Magento\Catalog\Model\Category;
use Magento\Catalog\Model\Product;
use Magento\Catalog\Model\ResourceModel\Eav\Attribute;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Cms\Model\BlockFactory;
use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;

class InstallData implements InstallDataInterface
{
    private $eavSetupFactory;

    private $blockFactory;

    public function __construct(BlockFactory $blockFactory, EavSetupFactory $eavSetupFactory)
    {
        $this->blockFactory = $blockFactory;
        $this->eavSetupFactory = $eavSetupFactory;
    }

    public function install(
        ModuleDataSetupInterface $setup,
        ModuleContextInterface $context
    ) {
        $eavSetup = $this->eavSetupFactory->create(['setup' => $setup]);

        $eavSetup->addAttribute(
            Category::ENTITY,
            'mp_new_attribute',
            [
                'type'         => 'varchar',
                'label'        => 'Test Category Attribute',
                'input'        => 'text',
                'sort_order'   => 100,
                'source'       => '',
                'global'       => 1,
                'visible'      => true,
                'required'     => false,
                'user_defined' => false,
                'default'      => null,
                'group'        => '',
                'backend'      => ''
            ]
        );

        $eavSetup = $this->eavSetupFactory->create(['setup' => $setup]);
        $eavSetup->addAttribute(
            Product::ENTITY,
            'international',
            [
                'group' => 'General',
                'type' => 'int',
                'label' => 'International',
                'backend' => '',
                'input' => 'select',
                'wysiwyg_enabled'   => false,
                'source' => 'Mjfox\Education\Model\Config\Source\YesNo',
                'required' => true,
                'sort_order' => 15,
                'global' => Attribute::SCOPE_GLOBAL,
                'used_in_product_listing' => false,
                'visible_on_front' => false,
            ]
        );

        $eavSetup->addAttribute(
            Category::ENTITY,
            'mj_new_attribute',
            [
                'type'         => 'varchar',
                'label'        => 'Mjfox Education',
                'input'        => 'text',
                'sort_order'   => 100,
                'source'       => '',
                'global'       => 1,
                'visible'      => true,
                'required'     => false,
                'user_defined' => false,
                'default'      => null,
                'group'        => '',
                'backend'      => ''
            ]
        );

        $cmsBlockData = [
            'title' => 'Education CMS Block',
            'identifier' => 'education_cms_block',
            'content' => "<h1>Education Test</h1>",
            'is_active' => 1,
            'stores' => [0],
            'sort_order' => 0
        ];

        $this->blockFactory->create()->setData($cmsBlockData)->save();
    }
}
