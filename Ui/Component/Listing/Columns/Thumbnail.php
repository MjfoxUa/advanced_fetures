<?php
namespace Mjfox\Education\Ui\Component\Listing\Columns;

use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Ui\Component\Listing\Columns\Column;
use Mjfox\Education\Model\Image\Image;

class Thumbnail extends Column
{
    const NAME = 'thumbnail';

    const ALT_FIELD = 'name';

    /**
     * @var Image
     */
    private $imageHelper;

    /**
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param \Mjfox\Education\Model\Image\Image $imageHelper
     * @param \Magento\Framework\UrlInterface $urlBuilder
     * @param array $components
     * @param array $data
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        \Mjfox\Education\Model\Image\Image $imageHelper,
        \Magento\Framework\UrlInterface $urlBuilder,
        \Magento\Framework\ObjectManagerInterface $objectManager,
        array $components = [],
        array $data = []
    ) {
        $this->imageHelper = $imageHelper;
        $this->urlBuilder = $urlBuilder;
        $this->_objectManager = $objectManager;
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
       // var_dump($dataSource);
      //  exit;
        if (isset($dataSource['data']['items'])) {
            $fieldName = $this->getData('name');
            foreach ($dataSource['data']['items'] as & $item) {
                $filename = 'image.png';
                //$item[$fieldName . '_src'] = $this->imageHelper->getBaseUrl().$filename;
                $item[$fieldName . '_src'] = 'https://magento2.plumserver.com/dev11/pub/media//test_2.png';
                //$item[$fieldName . '_alt'] = $this->getAlt($item) ?: $filename;
                $item[$fieldName . '_alt'] = 'https://magento2.plumserver.com/dev11/pub/media//test_2.png';
                //$item[$fieldName . '_orig_src'] = $this->imageHelper->getBaseUrl().$filename;
                $item[$fieldName . '_orig_src'] = 'https://magento2.plumserver.com/dev11/pub/media//test_2.png';
            }
        }

        return $dataSource;
    }

    /**
     * @param array $row
     * @return null|string
     */
    protected function getAlt($row)
    {
        $altField = $this->getData('config/altField') ?: self::ALT_FIELD;
        return isset($row[$altField]) ? $row[$altField] : null;
    }
}
