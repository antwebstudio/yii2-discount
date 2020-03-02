<?php
namespace ant\discount\widgets;

use ant\discount\models\DiscountCouponForm;

class DiscountCoupon extends \yii\base\Widget {
	public $cart;
	
	public $url = ['/discount/default/apply-coupon'];
	
	public function run() {
		$model = new DiscountCouponForm;
		
		return $this->render('discount-coupon', [
			'model' => $model,
			'coupons' => (array) $this->getCoupons(),
		]);
	}
	
	protected function getCoupons() {
		return \Yii::$app->discount->getContext('coupons');
	}
}