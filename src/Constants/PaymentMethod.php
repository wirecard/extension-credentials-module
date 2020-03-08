<?php

namespace Credentials\Constants;

class PaymentMethod
{
    const TYPE_CREDIT_CARD = "creditcard";
    const TYPE_PAYPAL = "paypal";

    /**
     * @return array
     */
    public static function availablePaymentMethods()
    {
        return [
            self::TYPE_CREDIT_CARD,
            self::TYPE_PAYPAL
        ];
    }
}
