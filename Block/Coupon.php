<?php

namespace Mjfox\Education\Block;

use Magento\Checkout\Block\Onepage\Success;
use Magento\Checkout\Model\Session;
use Magento\Framework\View\Element\Template\Context;
use Magento\Framework\App\Http\Context as HttpContext;
use Magento\Sales\Model\Order\Config;
use Magento\SalesRule\Model\CouponGenerator;
use Mjfox\Education\Model\Coupon as CouponModel;
use Mjfox\Education\Helper\Data;

class Coupon extends Success
{
    /**
     * @var Coupon
     */
    private $coupon;
    /**
     * @var CouponGenerator
     */
    private $couponGenerator;
    /**
     * @var Data
     */
    private $helperData;

    /**
     * Cupon constructor.
     *
     * @param Context                             $context
     * @param Session                             $checkoutSession
     * @param Config                              $orderConfig
     * @param CouponModel                         $coupon
     * @param \Magento\Framework\App\Http\Context $httpContext
     * @param CouponGenerator                     $couponGenerator
     * @param Data                                $helperData
     * @param array                               $data
     */
    public function __construct(
        Context $context,
        Session $checkoutSession,
        Config $orderConfig,
        CouponModel $coupon,
        HttpContext $httpContext,
        CouponGenerator $couponGenerator,
        Data $helperData,
        array $data = []
    ) {
        $this->couponGenerator = $couponGenerator;
        $this->coupon = $coupon;
        $this->helperData = $helperData;
        parent::__construct($context, $checkoutSession, $orderConfig, $httpContext, $data);
    }

    public function getCuponFotThisCustomer()
    {

        $data = [
            'rule_id' => '6',
            'qty' => '1',
            'length' => '12',
            'format' => 'alphanum',
            'prefix' => 'pre',
            'suffix' => 'suf',
        ];

        $cupon = $this->couponGenerator->generateCodes($data);
        $customerEmail = $this->_checkoutSession
            ->getLastRealOrder()
            ->getCustomerEmail();

        $this->helperData->sendEmail($customerEmail, $cupon[0]);

        return $cupon[0];
    }
}
