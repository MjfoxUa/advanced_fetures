<?php

namespace Mjfox\Education\Helper;

use Magento\Framework\App\Area;
use Magento\Framework\App\Helper\Context;
use Magento\Framework\Mail\Template\TransportBuilder;
use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\Translate\Inline\StateInterface;
use Magento\Store\Model\ScopeInterface;
use Magento\Store\Model\StoreManagerInterface;

class Data extends AbstractHelper
{
    /**
     * @var TransportBuilder
     */
    protected $transportBuilder;

    /**
     * @var StoreManagerInterface
     */
    protected $storeManager;

    /**
     * @var StateInterface
     */
    protected $inlineTranslation;

    /**
     * Data constructor.
     *
     * @param Context               $context
     * @param TransportBuilder      $transportBuilder
     * @param StoreManagerInterface $storeManager
     * @param StateInterface        $state
     */
    public function __construct(
        Context $context,
        TransportBuilder $transportBuilder,
        StoreManagerInterface $storeManager,
        StateInterface $state
    ) {
        $this->transportBuilder = $transportBuilder;
        $this->storeManager = $storeManager;
        $this->inlineTranslation = $state;
        parent::__construct($context);
    }

    public function sendEmail($toEmail, $cupon)
    {
        // this is an example and you can change template id,fromEmail,toEmail,etc as per your need.
        $templateId = 'coupon_email_template'; // template id
        $fromEmail = 'owner@domain.com';  // sender Email id
        $fromName = 'Admin';             // sender Name
      //  $toEmail = 'customer@email.com'; // receiver email id

        try {
            // template variables pass here
            $templateVars = [
                'coupon' => $cupon,
                'customer' => $toEmail
            ];

            $storeId = $this->storeManager->getStore()->getId();

            $from = ['email' => $fromEmail, 'name' => $fromName];
            $this->inlineTranslation->suspend();

            $storeScope = ScopeInterface::SCOPE_STORE;
            $templateOptions = [
                'area' => Area::AREA_FRONTEND,
                'store' => $storeId
            ];
            $transport = $this->transportBuilder->setTemplateIdentifier($templateId)
                ->setTemplateOptions($templateOptions)
                ->setTemplateVars($templateVars)
                ->setFromByScope($from, $storeScope)
                ->addTo($toEmail)
                ->getTransport();
            $transport->sendMessage();
            $this->inlineTranslation->resume();
        } catch (\Exception $e) {
            $this->_logger->info($e->getMessage());
        }
    }
}
