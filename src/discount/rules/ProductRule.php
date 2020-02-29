<?php
namespace ant\discount\rules;

class ProductRule extends DiscountRule implements \ant\discount\components\DiscountRuleInterface {
	public $products;
	public $categories;
	
	public $priority = 20;

	public function getIsShouldApply() {
		
	}
}