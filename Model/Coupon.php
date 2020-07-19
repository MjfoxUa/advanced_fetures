<?php

namespace Mjfox\Education\Model;

use Exception;
use Psr\Log\LoggerInterface;
use Magento\SalesRule\Api\Data\RuleInterface;
use Magento\SalesRule\Api\Data\CouponInterface;
use Magento\Framework\Exception\InputException;
use Magento\SalesRule\Api\RuleRepositoryInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\SalesRule\Api\CouponRepositoryInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\SalesRule\Api\Data\RuleInterfaceFactory;

class Coupon
{
    /**
     * @var CouponRepositoryInterface
     */
    private $couponRepository;
    /**
     * @var RuleRepositoryInterface
     */
    private $ruleRepository;
    /**
     * @var RuleInterfaceFactory
     */
    private $rule;
    /**
     * @var CouponInterface
     */
    private $coupon;
    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * Coupon constructor.
     *
     * @param CouponRepositoryInterface $couponRepository
     * @param RuleRepositoryInterface   $ruleRepository
     * @param RuleInterfaceFactory      $rule
     * @param CouponInterface           $coupon
     * @param LoggerInterface           $logger
     */
    public function __construct(
        CouponRepositoryInterface $couponRepository,
        RuleRepositoryInterface $ruleRepository,
        RuleInterfaceFactory $rule,
        CouponInterface $coupon,
        LoggerInterface $logger
    ) {
        $this->couponRepository = $couponRepository;
        $this->ruleRepository = $ruleRepository;
        $this->rule = $rule;
        $this->coupon = $coupon;
        $this->logger = $logger;
    }

    /**
     * Create Rule
     */
    public function testCuponRule()
    {
        $newRule = $this->rule->create();
        $newRule->setName('20$ discount')
            ->setDescription("20% Discount on applied rule")
            ->setIsAdvanced(true)
            ->setStopRulesProcessing(false)
            ->setDiscountQty(20)
            ->setCustomerGroupIds([0, 1, 2])
            ->setWebsiteIds([1])
            ->setIsRss(1)
            ->setUsesPerCoupon(0)
            ->setDiscountStep(0)
            ->setCouponType(RuleInterface::COUPON_TYPE_SPECIFIC_COUPON)
            ->setSimpleAction(RuleInterface::DISCOUNT_ACTION_FIXED_AMOUNT_FOR_CART)
            ->setDiscountAmount(20)
            ->setIsActive(true);

        try {
            $ruleCreate = $this->ruleRepository->save($newRule);
            //If rule generated, Create new Coupon by rule id
            if ($ruleCreate->getRuleId()) {
                $this->createCoupon($ruleCreate->getRuleId());
            }
        } catch (Exception $exception) {
            $this->logger->error($exception->getMessage());
        }
    }

    /**
     * @param int $ruleId
     * @return int|null
     * @throws InputException
     * @throws LocalizedException
     * @throws NoSuchEntityException
     */
    public function createCoupon(int $ruleId)
    {
        /** @var CouponInterface $coupon */
        $coupon = $this->coupon;
        $coupon->setCode('20FIXED')
            ->setIsPrimary(1)
            ->setRuleId($ruleId);

        /** @var CouponRepositoryInterface $couponRepository */
        $coupon = $this->couponRepository->save($coupon);
        return $coupon->getCouponId();
    }
}
