<?php
declare(strict_types=1);

namespace Mjfox\Education\Model\Config\Source;

use Magento\Eav\Model\Entity\Attribute\Source\AbstractSource;

class StatusField extends AbstractSource
{
    /**
     * @var int
     */
    const IN_STOCK = 1;

    /**
     * @var int
     */
    const OUT_OF_DISABLED = 0;

    /**
     * @return array
     */
    public function toOptionArray()
    {
        return [
            ['value' => self::OUT_OF_DISABLED, 'label' => __('Out Of Stock')],
            ['value' => self::IN_STOCK, 'label' => __('In Stock')]
        ];
    }

    public function getAllOptions()
    {
        if ($this->_options === null) {
            $this->_options = [
                ['value' => self::OUT_OF_DISABLED, 'label' => __('Out Of Stock')],
                ['value' => self::IN_STOCK, 'label' => __('In Stock')]
            ];
        }
        return $this->_options;
    }
}
