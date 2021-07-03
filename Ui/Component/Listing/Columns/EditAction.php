<?php

namespace Mjfox\Education\Ui\Component\Listing\Columns;

use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;

class EditAction extends Column
{
    /**
     * Identify referrer plumrocket
     */
    const MJFOX_REDIRECT = 'mjfox';

    /**
     * @var UrlInterface
     */
    protected $urlBuilder;

    /**
     * Constructor
     *
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param UrlInterface $urlBuilder
     * @param array $components
     * @param array $data
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        UrlInterface $urlBuilder,
        array $components = [],
        array $data = []
    ) {
        $this->urlBuilder = $urlBuilder;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    /**
     * Prepare Data Source
     *
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            $urlEntityParamName = $this->getData('config/urlEntityParamName') ?: 'id';
            foreach ($dataSource['data']['items'] as & $item) {
                if (isset($item[$urlEntityParamName])) {
                    $viewUrlPath = $this->getData('config/viewUrlPath') ?: '#';
                    $item[$this->getData('name')] = [
                        'edit' => [
                            'href' => $this->urlBuilder->getUrl(
                                $viewUrlPath,
                                [
                                    'id' => $item[$urlEntityParamName],
                                    self::MJFOX_REDIRECT => 1
                                ]
                            ),
                            'label' => __('Edit'),
                        ]
                    ];
                }
            }
        }

        return $dataSource;
    }
}
