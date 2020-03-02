<?php
namespace ant\discount\rules;

use yii\helpers\ArrayHelper;

class DiscountRule extends \yii\base\Component {
	public $conditions = [];
	public $context;
	
	public $userGroups;
	public $users;
	
	public $products;
	public $categories;
	
	public $priority = 20;
	
	public $percent;
	public $amount;
	
	public $discount_percent;
	public $discount_amount;
	
	public $code;
	
	public function setContext($context) {
		$this->context = $context;
	}

	public function getIsShouldApply() {
		return true;
	}
	
	protected function shouldApplyToCart($cart) {
		return $this->isShouldApply;
	}
	
	protected function shouldApplyToCartItem($cartItem) {
		return $this->isShouldApply;
	}
	
	protected function matchConditionForCart($cart) {
		foreach ($this->conditions as $condition) {
			if (!$condition->shouldApplyToCart($cart)) {
				return false;
			}
		}
		return true;
	}
	
	protected function matchConditionForCartItem($cartItem) {
		foreach ($this->conditions as $condition) {
			if (!$condition->shouldApplyToCartItem($cartItem)) {
				return false;
			}
		}
		return true;
	}
	
	public function getDiscountForCartItem($cartItem) {
		if ($this->matchConditionForCartItem($cartItem)) {
			return $this->shouldApplyToCartItem($cartItem) ? $cartItem->unit_price * $this->getPercent() / 100 + $this->getAmount() : 0;
		}
	}
	
	public function getDiscountForCart($cart) {
		if ($this->matchConditionForCart($cart)) {
			return $this->shouldApplyToCart($cart) ? $cart->getSubtotal() * $this->getPercent() / 100 + $this->getAmount() : 0;
		}
	}
	
	protected function getPercent() {
		if (isset($this->discount_percent)) return $this->discount_percent;
		
		return $this->percent ? $this->percent : 0;
	}
	
	protected function getAmount() {
		if (isset($this->discount_amount)) return $this->discount_amount;
		
		return $this->amount ? $this->amount : 0;
	}
}