<?php

namespace Mjfox\Education\Model;

use \Magento\Framework\Model\AbstractModel;
use \Magento\Framework\DataObject\IdentityInterface;

class Education extends AbstractModel implements IdentityInterface
{
    const CACHE_TAG = 'mjfox_education_education';

    protected $_cacheTag = 'mjfox_education_education';

    protected $_eventPrefix = 'mjfox_education_education';

    protected function _construct()
    {
        $this->_init(ResourceModel\Education::class);
    }

    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

    public function getDefaultValues()
    {
        $values = [];
        return $values;
    }
}
