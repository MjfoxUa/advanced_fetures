<?php

declare(strict_types=1);

namespace Mjfox\Education\Block\Adminhtml\Uiform;

use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

class Delete extends AbstractButton implements ButtonProviderInterface
{
    /**
     * @return array
     */
    public function getButtonData()
    {
        if (! $this->getId()) {
            return [];
        }

        return [
            'label' => __('Delete'),
            'class' => 'secondary',
            'sort_order' => 20,
            'on_click' => 'deleteConfirm(\'' . __('Are you sure you want to do this?') . '\', \''
                . $this->getUrl("edu/uiform/delete", ["id" => $this->getId()])
                . '\', {"data": {}})',
        ];
    }
}
