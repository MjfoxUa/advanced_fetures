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

    private $_getModel;
    /**
     * @var string
     */
    private $editUrl;

    private $_objectManager = null;
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
        //https://magento2.plumserver.com/dev11/pub/media/education/tmp/test_5.png
        if (isset($dataSource['data']['items'])) {
            $fieldName = $this->getData('name');
            foreach ($dataSource['data']['items'] as & $item) {
                $filename = 'myimage.png';
                $item[$fieldName . '_src'] = $this->imageHelper->getBaseUrl().$filename;
                $item[$fieldName . '_alt'] = $this->getAlt($item) ?: $filename;
                $item[$fieldName . '_orig_src'] = $this->imageHelper->getBaseUrl().$filename;
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
