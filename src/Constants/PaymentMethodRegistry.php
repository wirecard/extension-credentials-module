<?php

namespace Credentials\Constants;

/**
 * Class PaymentMethodRegistry
 * @package Credentials\Constants
 */
class PaymentMethodRegistry
{
    const TYPE_CREDIT_CARD = "creditcard";
    const TYPE_PAYPAL = "paypal";
    const TYPE_SOFORTBANKING = "sofortbanking";
    const TYPE_ALIPAY_XBORDER = "alipay-xborder";
    const TYPE_IDEAL = "ideal";
    const TYPE_WIRETRANSFER = "wiretransfer";
    const TYPE_RATEPAY = "ratepay-invoice";
    const TYPE_EPS = "eps";
    const TYPE_GIROPAY = "giropay";
    const TYPE_ZAPP = "zapp";
    const TYPE_SEPACREDIT = "sepacredit";
    const TYPE_SEPA_DIRECT_DEBIT = "sepadirectdebit";
    const TYPE_MASTERPASS = "masterpass";

    /**
     * @return array
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
}
