<?php
namespace ant\discount\rules;

class ProductRule extends DiscountRule implements \ant\discount\components\DiscountRuleInterface {
	public $products;
	
	protected function shouldApplyToCart($cart) {
		return false;
	}
	
	protected function shouldApplyToCartItem($cartItem) {
		return in_array($cartItem->item->id, $this->products);
	}
}