<?php
namespace ant\discount\components;

use ant\discount\helpers\Discount;

class DiscountCalculator extends \yii\base\Component {
	public $cart;
	public $coupons = [];
	
	protected $rules = [];
	
	public static function with($contexts = []) {
		return new self($contexts);
	}
	
	public function addRules($rules) {
		foreach ($rules as $rule) {
			$this->rules[] = $rule;
		}
		return $this;
	}
	
	public function getCartDiscount() {
		$amount = 0;
		foreach ($this->rules as $rule) {
			$rule->setContext($this);
			$amount += $rule->getDiscountForCart($this->cart);
		}
		return Discount::amount($amount);
	}
	
	public function getCartItemDiscount($cartItems) {
		$amount = 0;
		foreach ($this->rules as $rule) {
			$rule->setContext($this);
			$amount += $rule->getDiscountForCartItem($cartItems);
		}
		return Discount::amount($amount);
	}
}