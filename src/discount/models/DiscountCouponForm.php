<?php
namespace ant\discount\models;

use Yii;

class DiscountCouponForm extends \yii\base\Model {
	public $coupon;
	
	protected $maximumAllow = 3;
	
	public function rules() {
		return [
			['coupon', function($attribute, $params, $validator) {
				$coupons = (array) Yii::$app->discount->getContext('coupon');
				if (count($coupons) > $this->maximumAllow) {
					$this->addError($attribute, Yii::t('discount', 'Maximum only {max} coupon is allowed.', ['max' => $this->maximumAllow]));
				}
			}],
			['coupon', 'ant\discount\validators\CouponValidator'],
			[['coupon'], 'required'],
		];
	}
	
	public function remove() {
		$code = $this->coupon;
		$coupons = (array) Yii::$app->discount->getContext('coupons');
		unset($coupons[array_search($code, $coupons)]);
		Yii::$app->discount->setContext('coupons', $coupons, true);
	}
	
	public function apply() {
		if ($this->validate()) {
			$coupons = (array) Yii::$app->discount->getContext('coupons');
			$coupons[] = $this->coupon;
			
			Yii::$app->discount->setContext('coupons', $coupons, true);
			return true;
		}
	}
}