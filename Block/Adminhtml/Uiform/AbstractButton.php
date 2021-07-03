<?php

namespace Mjfox\Education\Block\Adminhtml\Uiform;

use Magento\Backend\Block\Widget\Context;

class AbstractButton
{
    private $urlBuilder;

    private $request;

    public function __construct(
        Context $context
    ) {
        $this->urlBuilder = $context->getUrlBuilder();
        $this->request = $context->getRequest();
    }

    /**
     * @return mixed|null
     */
    public function getId()
    {
        $id = $this->request->getParam('id');

        return $id ?: null;
    }

    /**
     * Generate url by route and parameters
     *
     * @param   string $route
     * @param   array $params
     * @return  string
     */
    public function getUrl($route = '', $params = [])
    {
        return $this->urlBuilder->getUrl($route, $params);
    }
}
