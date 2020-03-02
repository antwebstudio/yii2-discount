<?php
namespace ant\discount\rules;

use ant\discount\models\DiscountCoupon;

class CouponRule extends DiscountRule {
	protected function shouldApplyToCart($cart) {
		return DiscountCoupon::find()->andWhere(['rule_id' => $this->ruleId, 'code' => $this->context->coupons])->count();
		
		foreach (DiscountCoupon::find()->andWhere(['code' => $this->context->coupons])->all() as $coupon) {
			
		}
		return true;
	}
	
	protected function shouldApplyToCartItem($cartItem) {
		return false;
	}
}