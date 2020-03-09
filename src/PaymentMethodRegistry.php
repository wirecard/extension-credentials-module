<?php

namespace Credentials;

/**
 * Class PaymentMethodRegistry
 * @package Credentials
 * @since 1.0.0
 */
class PaymentMethodRegistry
{
    /**
     * @var string
     */
    const TYPE_CREDIT_CARD = "creditcard";
    /**
     * @var string
     */
    const TYPE_PAYPAL = "paypal";
    /**
     * @var string
     */
    const TYPE_SOFORTBANKING = "sofortbanking";
    /**
     * @var string
     */
    const TYPE_ALIPAY_XBORDER = "alipay-xborder";
    /**
     * @var string
     */
    const TYPE_IDEAL = "ideal";
    /**
     * @var string
     */
    const TYPE_WIRETRANSFER = "wiretransfer";
    /**
     * @var string
     */
    const TYPE_RATEPAY = "ratepay-invoice";
    /**
     * @var string
     */
    const TYPE_EPS = "eps";
    /**
     * @var string
     */
    const TYPE_GIROPAY = "giropay";
    /**
     * @var string
     */
    const TYPE_ZAPP = "zapp";
    /**
     * @var string
     */
    const TYPE_SEPACREDIT = "sepacredit";
    /**
     * @var string
     */
    const TYPE_SEPA_DIRECT_DEBIT = "sepadirectdebit";
    /**
     * @var string
     */
    const TYPE_MASTERPASS = "masterpass";

    /**
     * @var array | PaymentMethod[]
     */
    private $registry = [];

    /**
     * PaymentMethodRegistry constructor.
     * @throws Exception\InvalidPaymentMethodException
     */
    public function __construct()
    {
        $this->initializeRegistry();
    }

    /**
     * @return void
     * @throws Exception\InvalidPaymentMethodException
     */
    private function initializeRegistry()
    {
        foreach ($this->availablePaymentMethods() as $paymentMethod) {
            $this->registry[$paymentMethod] = new PaymentMethod($paymentMethod, $this);
        }
    }

    /**
     * @param string $paymentMethod
     * @return PaymentMethod
     * @throws Exception\InvalidPaymentMethodException
     * @since 1.0.0
     */
    public function getPaymentMethod($paymentMethod)
    {
        if (!isset($this->registry[$paymentMethod])) {
            $this->registry[$paymentMethod] = new PaymentMethod($paymentMethod, $this);
        }
        return $this->registry[$paymentMethod];
    }

    /**
     * @return array
     * @since 1.0.0
     */
    public function availablePaymentMethods()
    {
        return [
            self::TYPE_CREDIT_CARD,
            self::TYPE_PAYPAL,
            self::TYPE_SOFORTBANKING,
            self::TYPE_ALIPAY_XBORDER,
            self::TYPE_IDEAL,
            self::TYPE_WIRETRANSFER,
            self::TYPE_RATEPAY,
            self::TYPE_EPS,
            self::TYPE_GIROPAY,
            self::TYPE_ZAPP,
            self::TYPE_SEPACREDIT,
            self::TYPE_SEPA_DIRECT_DEBIT,
            self::TYPE_MASTERPASS
        ];
    }

    /**
     * @param string $type
     * @return bool
     * @since 1.0.0
     */
    public function hasPaymentMethod($type)
    {
        return in_array($type, $this->availablePaymentMethods(), true);
    }
}
