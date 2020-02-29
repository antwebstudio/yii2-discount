<?php
namespace ant\discount\components;

class DiscountCalculator extends \yii\base\Component {
	public function and() {
		return $this;
	}
	
	public function getTotalDiscount() {
		return 12;
	}
}