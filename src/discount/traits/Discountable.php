<?php
namespace ant\discount\traits;

use ant\discount\helpers\Discount;
use ant\helpers\Currency;

trait Discountable {
	
	public function getTotalDiscount() {
		$discount = new Discount($this->{$this->getDiscountPercentAttributeName()}, Discount::TYPE_PERCENT);
		$discountAmountByPercent = $discount->of($this->{$this->getUnitPriceAttributeName()});
		
		return Currency::rounding($discountAmountByPercent + $this->{$this->getDiscountAmountAttributeName()});
	}
	
	public function setDiscount($discount, $discountType = 0) {
		deprecate();
		
		if ($discount instanceof \ant\discount\helpers\Discount) {
			$this->discount_value = $discount->value;
			$this->discount_type = $discount->type;
		} else {
			$this->discount_value = $discount;
			$this->discount_type = $discountType;
		}
	}
	
	public function getDiscount() {
		deprecate();
		
		return new \ant\discount\helpers\Discount($this->discount_value, $this->discount_type);
	}
	
	public function setDiscountAmount($value) {
		$this->{$this->getDiscountAmountAttributeName()} = $value;
	}
	
	public function getDiscountAmount() {
		deprecate();
		
		$value = $this->{$this->getDiscountAmountAttributeName()} ? $this->{$this->getDiscountAmountAttributeName()} : 0;
		$discount = new Discount($value, Discount::TYPE_AMOUNT);
		return $discount->of($this->unitPrice);
	}
	
	public function getDiscountedUnitPrice() {
		return Currency::rounding($this->{$this->getUnitPriceAttributeName()} - $this->getTotalDiscount());
	}
	
	protected function getUnitPriceAttributeName() {
		return 'unit_price';
	}
	
	protected function getDiscountPercentAttributeName() {
		return 'discount_percent';
	}
	
	protected function getDiscountAmountAttributeName() {
		return 'discount_amount';
	}
}