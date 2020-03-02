<?php
namespace ant\discount\validators;

class CouponValidator extends \yii\validators\Validator {
	public $message = 'Invalid coupon';
	
	public function validateAttribute($model, $attribute) {
		$message = $this->message;
		//$model->addError($attribute, $message);
	}
}