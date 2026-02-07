<?php

namespace Modules\Billing\Services;

use Modules\Billing\Models\Coupon;
use Carbon\Carbon;

class CouponService
{
    /**
     * Validate and apply a coupon.
     *
     * @param string $code
     * @return Coupon|null
     */
    public function apply(string $code): ?Coupon
    {
        $coupon = Coupon::where('code', $code)->first();

        if (!$coupon) {
            return null;
        }

        if ($coupon->valid_until && $coupon->valid_until->isPast()) {
            return null;
        }

        return $coupon;
    }

    /**
     * Calculate discounted price.
     *
     * @param float $price
     * @param Coupon $coupon
     * @return float
     */
    public function calculateDiscount(float $price, Coupon $coupon): float
    {
        $discountAmount = $price * ($coupon->discount_percent / 100);
        return max(0, $price - $discountAmount);
    }
}
