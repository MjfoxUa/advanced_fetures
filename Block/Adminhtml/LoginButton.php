<?php

namespace Mjfox\Education\Block\Adminhtml;

use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;
use Magento\Backend\Model\SessionFactory;

class LoginButton implements ButtonProviderInterface
{
    /**
     * @var SessionFactory
     */
    private $adminsession;

    public function __construct(SessionFactory $adminsession)
    {
        $this->adminsession = $adminsession;
    }

    public function getButtonData()
    {
        $admin =  $this->adminsession->create();
        $customerData=$admin->getData();
        $id = $customerData['customer_data']['customer_id'];
        $url="https://magento2.plumserver.com/dev11/mjfox_education?id=".$id;
        $data = [
            'label' => __('Login Button'),
            'on_click' => sprintf("location.href = '%s';", $url),
            'class' => 'add',
            'sort_order' => 40,
        ];

        return $data;
    }
}
